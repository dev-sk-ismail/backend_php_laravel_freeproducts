<?php


namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class LeadController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Session::get('userArray')) {
                return redirect('/admin');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $leads = Lead::latest()->paginate(10);
        return view('admin.leads.index', compact('leads'));
    }
    public function show($id)
    {
        $lead = Lead::findOrFail($id);
        $orderStatusOptions = Lead::getOrderStatusOptions();
        return view('admin.leads.view', compact('lead', 'orderStatusOptions'));
    }

    public function update(Request $request, $id)
    {
        $lead = Lead::findOrFail($id);

        if ($lead->order_status === 'fulfilled') {
            return redirect()
                ->route('leads.show', $lead->id)
                ->with('errorMessage', 'Fulfilled orders cannot be updated');
        }

        return redirect()
            ->route('leads.show', $lead->id)
            ->with('successMessage', 'Lead updated successfully');
    }

    public function fulfill($id)
    {
        $lead = Lead::findOrFail($id);

        if ($lead->order_status !== 'draft') {
            return redirect()
                ->route('leads.show', $lead->id)
                ->with('errorMessage', 'Only draft orders can be fulfilled');
        }

        try {
            // Parse the Shopify response to get the order ID
            $shopifyData = json_decode($lead->shopify_response, true);

            // Get the order ID from the complete_order response
            $orderId = $shopifyData['complete_order']['data']['draftOrderComplete']['draftOrder']['order']['id'] ?? null;

            if (!$orderId) {
                throw new \Exception('Shopify order ID not found in response data');
            }

            // Fulfill the order in Shopify
            $fulfillmentResult = $this->fulfillShopifyOrder($orderId);

            if ($fulfillmentResult['success']) {
                // Update lead status and save fulfillment response
                $lead->update([
                    'order_status' => 'fulfilled',
                    'shopify_response' => json_encode([
                        'draft_order' => $shopifyData['draft_order'],
                        'complete_order' => $shopifyData['complete_order'],
                        'fulfillment' => $fulfillmentResult['response']
                    ])
                ]);

                return redirect()
                    ->route('leads.show', $lead->id)
                    ->with('successMessage', 'Order fulfilled successfully in Shopify');
            } else {
                throw new \Exception($fulfillmentResult['error']);
            }
        } catch (\Exception $e) {
            Log::error('Order fulfillment failed:', [
                'lead_id' => $lead->id,
                'error' => $e->getMessage()
            ]);

            return redirect()
                ->route('leads.show', $lead->id)
                ->with('errorMessage', 'Failed to fulfill order: ' . $e->getMessage());
        }
    }

    private function fulfillShopifyOrder($orderId)
    {
        $domain = config('services.shopify.domain');
        $version = "2023-07";
        $accessToken = config('services.shopify.access_token');
        $shopifyEndpoint = "https://{$domain}/admin/api/{$version}/graphql.json";

        if (empty($domain) || empty($accessToken)) {
            return ['success' => false, 'error' => 'Shopify configuration is incomplete'];
        }

        // First, get the order details and fulfillable line items
        $orderQuery = [
            "query" => '
                query getOrder($id: ID!) {
                    order(id: $id) {
                        id
                        displayFulfillmentStatus
                        fulfillmentOrders(first: 1) {
                            edges {
                                node {
                                    id
                                    status
                                    lineItems(first: 10) {
                                        edges {
                                            node {
                                                id
                                                remainingQuantity
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            ',
            "variables" => [
                "id" => $orderId
            ]
        ];

        $orderInfo = $this->makeShopifyRequest($shopifyEndpoint, $accessToken, $orderQuery);

        if (!$orderInfo['success']) {
            return $orderInfo;
        }

        $order = $orderInfo['response']['data']['order'];

        // Check if order is already fulfilled
        if ($order['displayFulfillmentStatus'] === 'FULFILLED') {
            return ['success' => false, 'error' => 'Order is already fulfilled'];
        }

        // Get the fulfillment order ID and line items
        $fulfillmentOrderId = $order['fulfillmentOrders']['edges'][0]['node']['id'] ?? null;
        if (!$fulfillmentOrderId) {
            return ['success' => false, 'error' => 'No fulfillment order found'];
        }

        $lineItems = [];
        foreach ($order['fulfillmentOrders']['edges'][0]['node']['lineItems']['edges'] as $edge) {
            if ($edge['node']['remainingQuantity'] > 0) {
                $lineItems[] = [
                    "fulfillmentOrderLineItemId" => $edge['node']['id'],
                    "quantity" => $edge['node']['remainingQuantity']
                ];
            }
        }

        if (empty($lineItems)) {
            return ['success' => false, 'error' => 'No fulfillable items found'];
        }

        // Create fulfillment using the fulfillment order
        $fulfillmentMutation = [
            "query" => '
                mutation fulfillmentCreateV2($input: FulfillmentV2Input!) {
                    fulfillmentCreateV2(input: $input) {
                        fulfillment {
                            id
                            status
                            trackingInfo {
                                number
                                url
                            }
                        }
                        userErrors {
                            field
                            message
                        }
                    }
                }
            ',
            "variables" => [
                "input" => [
                    "fulfillmentOrderId" => $fulfillmentOrderId,
                    "lineItems" => $lineItems,
                    "notifyCustomer" => true
                ]
            ]
        ];

        $result = $this->makeShopifyRequest($shopifyEndpoint, $accessToken, $fulfillmentMutation);

        if ($result['success'] && !empty($result['response']['data']['fulfillmentCreateV2']['userErrors'])) {
            return [
                'success' => false,
                'error' => $result['response']['data']['fulfillmentCreateV2']['userErrors'][0]['message']
            ];
        }

        return $result;
    }

    private function makeShopifyRequest($endpoint, $accessToken, $query)
    {
        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($query));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'X-Shopify-Access-Token: ' . $accessToken
        ]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            Log::error('Shopify API Error:', ['error' => $error]);
            return ['success' => false, 'error' => 'Failed to connect to Shopify API: ' . $error];
        }

        if ($httpCode !== 200) {
            Log::error('Shopify API Error:', ['httpCode' => $httpCode, 'response' => $response]);
            return ['success' => false, 'error' => 'Shopify API returned error code: ' . $httpCode];
        }

        $result = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return ['success' => false, 'error' => 'Invalid JSON response from Shopify'];
        }

        if (isset($result['errors'])) {
            return ['success' => false, 'error' => $result['errors'][0]['message']];
        }

        return ['success' => true, 'response' => $result];
    }
}