<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\sendMailtoUser;
use App\Models\Lead;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
	public function index()
	{
		return view('user/index');
	}
	public function order(Request $request)
	{
		Log::debug('Starting order process', [
			'name' => $request->get('full_name'),
			'email' => $request->get('email'),
			'phone' => $request->get('phone_number')
		]);

		$name = $request->get('full_name');
		$userCred = array(
			'name' => $name,
			'email'=> $request->get('email'),
			'phone_number' => $request->get('phone_number')
		);
		Session::put('userCred', $userCred);

		Log::debug('Adding user to Klaviyo first list', ['userCred' => $userCred]);
		$this->add_klaviyo_firstList($userCred);

		return view('user.order');
	}	public function add_klaviyo_firstList($userCred){
		Log::debug('Klaviyo first list API request', [
			'endpoint' => config('services.klaviyo.api_endpoint'),
			'list_id' => config('services.klaviyo.list_id_first'),
			'user_data' => $userCred
		]);

		$userdata1 = array('profiles' => $userCred);
		$data_string = json_encode($userdata1);
		$api_key = config('services.klaviyo.api_key');
		$list_id = config('services.klaviyo.list_id_first');
		$endpoint = config('services.klaviyo.api_endpoint');
		
		$ch = curl_init("{$endpoint}/{$list_id}/members?api_key={$api_key}");
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		        'Content-Type: application/json'
		    )
		);
		$result = curl_exec($ch);
		Log::debug('Klaviyo first list API response', ['response' => $result]);
		curl_close($ch);
	}

	public function search_offer(Request $request)
	{
		Log::debug('Searching offers', ['order_id' => $request->get('order_id')]);

		$validatedData = $request->validate([
			'order_id' => 'required'
		]);
		Session::put('amazon_order_id', $request->get('order_id'));
		$query = DB::table('products')->select('*');
		$allproducts = [
			'data' => $query->simplePaginate(10)->items(),
			'prev_page_url' => $query->simplePaginate(10)->previousPageUrl(),
			'next_page_url' => $query->simplePaginate(10)->nextPageUrl()
		];
		Log::debug('Products retrieved', ['count' => count($allproducts['data'])]);
		return view('user.search_offer',compact('allproducts'));
	}
	public function usingDay(Request $request)
	{
		Log::debug('Product selection', [
			'productName' => $request->get('productName'),
			'product_id' => $request->get('product_id'),
			'variant_id' => $request->get('variant_id')
		]);

		Session::put('productName', $request->get('productName'));
		Session::put('productDetails', [
			'product_id' => $request->get('product_id'),
			'variant_id' => $request->get('variant_id'),
			'price' => $request->get('price'),
			'is_voucher' => $request->get('is_voucher'),
			'code' => $request->get('code')
		]);
		return view('user.usingDay');
	}

	public function product_survey()
	{
		$product_imageName = Session::get('productName');
		$product_imageName = explode('|', $product_imageName);
		$imageName = $product_imageName[1];
		return view('user.product-survey',compact('imageName'));
	}
	

	public function survey(Request $request)
	{
		Session::put('product_review',$request->all());
		return view('user.survey');
	}


	public function confirmAddress()
	{
		$product_review = Session::get('product_review');
		$user_cred = Session::get('userCred', []); // Set default empty array if not exists

		// Ensure all required fields exist
		$user_cred = array_merge([
			'name' => '',
			'email' => '',
			'phone_number' => '',
			'orderId' => Session::get('amazon_order_id')
		], $user_cred);

		return view('user.confirm_address', compact('user_cred'));
	}
	public function generateLead(Request $request)
	{
		Log::debug('Starting user data submission', [
			'request_data' => $request->except(['password']),
			'session_data' => [
				'amazon_order_id' => Session::get('amazon_order_id'),
				'product_name' => Session::get('productName'),
				'product_details' => Session::get('productDetails')
			]
		]);

		try {
			// Clear any previous product-related session data
			Session::forget('voucher_code');

			// Validate the request data
			$validatedData = $request->validate([
				'name' => 'required|max:255',
				'address_line1' => 'required|max:255',
				'email_address' => 'required|email',
				'phone' => 'required|numeric',
				'city' => 'required',
				'state_or_region' => 'required',
				'country_code' => 'required',
				'zip_code' => 'required|numeric|digits:5'
			], [
				'name.required' => 'Please enter your name',
				'address_line1.required' => 'Please enter your address',
				'email_address.required' => 'Please enter your email address',
				'email_address.email' => 'Please enter a valid email address',
				'phone.required' => 'Please enter your phone number',
				'phone.numeric' => 'Phone number must contain only numbers',
				'city.required' => 'Please enter your city',
				'state_or_region.required' => 'Please enter your state',
				'country_code.required' => 'Please select your country',
				'zip_code.required' => 'Please enter your zip code',
				'zip_code.numeric' => 'Zip code must contain only numbers',
				'zip_code.digits' => 'Zip code must be exactly 5 digits'
			]);

			$amazon_order_id = Session::get('amazon_order_id');
			$product_review_all = Session::get('product_review');

			if (!empty($product_review_all)) {
				$product_review = (isset($product_review_all['review_with_text']) ? $product_review_all['review_with_text'] : '0');
				$product_feedback = (isset($product_review_all['review']) ? $product_review_all['review'] : '0');
				$product_rating = (isset($product_review_all['review_with_number']) ? $product_review_all['review_with_number'] : '0');
			} else {
				$product_review = $product_feedback = $product_rating = 0;
			}

			$product_imageName = Session::get('productName');
			$product_imageName = explode('|', $product_imageName);
			$productName = $product_imageName[0];

			$productDetails = Session::get('productDetails');

			// Create lead record
			$lead = Lead::create([
				'name' => $validatedData['name'],
				'email' => $validatedData['email_address'],
				'phone' => $validatedData['phone'],
				'address' => $validatedData['address_line1'],
				'city' => $validatedData['city'],
				'state' => $validatedData['state_or_region'],
				'country' => $validatedData['country_code'],
				'zip_code' => $validatedData['zip_code'],
				'amazon_order_id' => $amazon_order_id,
				'product_name' => $productName,
				'product_id' => $productDetails['product_id'] ?? null,
				'variant_id' => $productDetails['variant_id'] ?? null,
				'is_voucher' => filter_var($productDetails['is_voucher'] ?? false, FILTER_VALIDATE_BOOLEAN),
				'voucher_code' => $productDetails['code'] ?? null,
				'product_review' => $product_review,
				'product_feedback' => $product_feedback,
				'product_rating' => $product_rating,
				'order_status' => 'draft'
			]);

			$userData = [
				'name' => $validatedData['name'],
				'address' => $validatedData['address_line1'],
				'email' => $validatedData['email_address'],
				'phone' => $validatedData['phone'],
				'city' => $validatedData['city'],
				'state' => $validatedData['state_or_region'],
				'country' => $validatedData['country_code'],
				'zip_code' => $validatedData['zip_code'],
				'amazon_order_id' => $amazon_order_id,
				'product_name' => $productName,
				'product_review' => $product_review,
				'product_feedback' => $product_feedback,
				'product_rating' => $product_rating
			];

			$this->add_klaviyo_finalList($userData);

			// Strict checking for voucher products
			$isVoucher = filter_var($productDetails['is_voucher'] ?? false, FILTER_VALIDATE_BOOLEAN);

			if ($isVoucher && !empty($productDetails['code'])) {
				// Store voucher code in session for thank you page
				Session::put('voucher_code', $productDetails['code']);

				// Update lead status to voucher
				$lead->update(['order_status' => 'voucher']);

				// Clear other product details from session
				Session::forget('productDetails');
				Session::forget('productName');

				return redirect('thankyou');
			}

			// Create Shopify order only for non-voucher products
			try {
				$shopifyResult = $this->createShopifyOrder($userData);
				if (!$shopifyResult['success']) {
					throw new \Exception($shopifyResult['error'] ?? 'Failed to create Shopify order');
				}

				// Update lead with successful order and Shopify response
				$lead->update([
					'order_status' => 'draft',
					'shopify_response' => json_encode($shopifyResult['response'])
				]);

				// Clear product details from session after successful order
				Session::forget('productDetails');
				Session::forget('productName');

				return redirect('thankyou');
			} catch (\Exception $e) {
				// Log Shopify error and store in lead
				$lead->update(['shopify_response' => $e->getMessage()]);

				Session::flash('errorMessage', 'There was an error creating your order. Please try again.');
				return back()
					->withInput()
					->withErrors(['shopify_error' => 'There was an error creating your order. Please try again.']);
			}
		} catch (\Illuminate\Validation\ValidationException $e) {
			return back()->withErrors($e->errors())->withInput();
		} catch (\Exception $e) {
			return back()
				->withErrors(['error' => 'An error occurred while processing your request. Please try again.'])
				->withInput();
		}
	}
	public function add_klaviyo_finalList($userData){
		$product_review_all = Session::get('product_review');

		if(!empty($product_review_all)){
			$product_review = (isset($product_review_all['review_with_text'])? $product_review_all['review_with_text'] : '0');
			$product_feedback = (isset($product_review_all['review'])? $product_review_all['review'] : '0');
			$product_rating =(isset($product_review_all['review_with_number'])? $product_review_all['review_with_number'] : '0');
		}else{
			$product_review = $product_feedback = $product_rating = 0;
		}
		
		$product_imageName = Session::get('productName');
		$product_imageName = explode('|', $product_imageName);
		$productName = $product_imageName[0];

		$userData['amazon_order_id'] = Session::get('amazon_order_id');
		$userData['product_name'] = $productName;
		$userData['product_review'] = $product_review;
		$userData['product_feedback'] = $product_feedback;
		$userData['product_rating'] = $product_rating;
		
		$data = array('profiles' => $userData);
		$data_string = json_encode($data);
		$api_key = config('services.klaviyo.api_key');
		$endpoint = config('services.klaviyo.api_endpoint');
		$list_id_first = config('services.klaviyo.list_id_first');
		$list_id_final = config('services.klaviyo.list_id_final');
		$email = $userData['email'];		/*Find if the customer exists*/
		$ch = curl_init("{$endpoint}/{$list_id_first}/members?api_key={$api_key}&emails={$email}");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		$result = curl_exec($ch);
		$res = json_decode($result,1);
		curl_close($ch);

		if(isset($res[0]['email']) &&  $res[0]['email'] == $userData['email']){
			/*Delete from first list*/
			$ch = curl_init("{$endpoint}/{$list_id_first}/members?api_key={$api_key}&emails={$email}");
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
			$result = curl_exec($ch);
			curl_close($ch);

			/*Insert in new list*/
			$curl = curl_init("{$endpoint}/{$list_id_final}/members?api_key={$api_key}");
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_HTTPHEADER, array(
			    'Content-Type: application/json'));
			$result = curl_exec($curl);
			curl_close($curl);
		}
	}
	public function sendMail($userData)
	{
	   	//$to = "sonali.paul@codeclouds.in";
	   	$to = "msinfotch321@gmail.com.com";
		Mail::to($to)->send(new sendMailtoUser($userData));
		
	}
	public function thankyou(){
		return view('user.thankyou');
	}
	private function createShopifyOrder($userData)
	{
		// Split the name into first and last name
		$nameParts = explode(' ', trim($userData['name']), 2);
		$firstName = $nameParts[0];
		$lastName = isset($nameParts[1]) ? $nameParts[1] : $firstName; // Use first name as last name if no last name provided

		$productDetails = Session::get('productDetails');
		if (!$productDetails) {
			Log::error('Product details not found in session');
			return ['success' => false, 'error' => 'Product details not found in session'];
		}

		// Set up the Shopify API request
		$domain = config('services.shopify.domain');
		$version = "2023-07"; // Using a stable API version
		$accessToken = config('services.shopify.access_token');
		$shopifyEndpoint = "https://{$domain}/admin/api/{$version}/graphql.json";

		if (empty($domain) || empty($accessToken)) {
			Log::error('Shopify configuration missing');
			return ['success' => false, 'error' => 'Shopify configuration is incomplete'];
		}

		// Add gid://shopify/ProductVariant/ prefix if not present
		$variantId = $productDetails['variant_id'];
		if (strpos($variantId, 'gid://') !== 0) {
			$variantId = "gid://shopify/ProductVariant/" . $variantId;
		}

		// Construct the GraphQL mutation
		$query = [
			"query" => 'mutation draftOrderCreate($input: DraftOrderInput!) {
				draftOrderCreate(input: $input) {
					draftOrder {
						id
						order {
							id
						}
					}
					userErrors {
						field
						message
					}
				}
			}',
			"variables" => [
				"input" => [
					"email" => $userData['email'],
					"note" => "Order from " . $userData['name'],
					"lineItems" => [
						[
							"variantId" => $variantId,
							"quantity" => 1
						]
					],
					"billingAddress" => [
						"address1" => $userData['address'],
						"city" => $userData['city'],
						"province" => $userData['state'],
						"zip" => $userData['zip_code'],
						"country" => $userData['country'],
						"firstName" => $firstName,
						"lastName" => $lastName,
						"phone" => $userData['phone']
					],
					"shippingAddress" => [
						"address1" => $userData['address'],
						"city" => $userData['city'],
						"province" => $userData['state'],
						"zip" => $userData['zip_code'],
						"country" => $userData['country'],
						"firstName" => $firstName,
						"lastName" => $lastName,
						"phone" => $userData['phone']
					],
					"tags" => ["freecloud9", "web-order"],
					"customAttributes" => [
						[
							"key" => "source",
							"value" => "freecloud9-website"
						],
						[
							"key" => "amazonOrderId",
							"value" => $userData['amazon_order_id']
						]
					]
				]
			]
		];

		Log::debug('Shopify API Request:', [
			'endpoint' => $shopifyEndpoint,
			'query' => $query
		]);

		$ch = curl_init($shopifyEndpoint);
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

		Log::debug('Shopify API Response:', [
			'httpCode' => $httpCode,
			'response' => $response
		]);

		if ($error) {
			Log::error('Shopify cURL Error: ' . $error);
			return ['success' => false, 'error' => 'Failed to connect to Shopify API: ' . $error];
		}

		if ($httpCode !== 200) {
			Log::error('Shopify API Error - HTTP Code: ' . $httpCode . ', Response: ' . $response);
			return ['success' => false, 'error' => 'Shopify API returned error code: ' . $httpCode];
		}

		$result = json_decode($response, true);
		if (json_last_error() !== JSON_ERROR_NONE) {
			Log::error('Shopify Response JSON Parse Error: ' . json_last_error_msg() . ', Response: ' . $response);
			return ['success' => false, 'error' => 'Invalid response from Shopify API'];
		}

		// Check for GraphQL errors
		if (isset($result['errors'])) {
			Log::error('Shopify GraphQL Errors:', $result['errors']);
			return ['success' => false, 'error' => 'Shopify API returned errors: ' . $result['errors'][0]['message']];
		}

		// After successful draft order creation, complete it
		if (isset($result['data']['draftOrderCreate']['draftOrder']['id'])) {
			$draftOrderId = $result['data']['draftOrderCreate']['draftOrder']['id'];
			$completeResult = $this->completeDraftOrder($shopifyEndpoint, $accessToken, $draftOrderId);

			if (!$completeResult['success']) {
				return $completeResult;
			}

			// Store the final order ID in session
			if (isset($completeResult['response']['data']['draftOrderComplete']['draftOrder']['order']['id'])) {
				Session::put('shopify_order_id', $completeResult['response']['data']['draftOrderComplete']['draftOrder']['order']['id']);
			}

			return [
				'success' => true,
				'response' => [
					'draft_order' => $result,
					'complete_order' => $completeResult['response']
				]
			];
		}

		return ['success' => false, 'error' => 'Failed to create draft order'];
	}

	private function completeDraftOrder($shopifyEndpoint, $accessToken, $draftOrderId)
	{
		$completeQuery = [
			"query" => 'mutation draftOrderComplete($id: ID!) {
				draftOrderComplete(id: $id, paymentPending: false) {
					draftOrder {
						id
						order {
							id
						}
					}
					userErrors {
						field
						message
					}
				}
			}',
			"variables" => [
				"id" => $draftOrderId
			]
		];

		$ch = curl_init($shopifyEndpoint);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($completeQuery));
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

		if ($error || $httpCode !== 200) {
			Log::error('Failed to complete draft order:', [
				'error' => $error,
				'httpCode' => $httpCode,
				'response' => $response
			]);
			return ['success' => false, 'error' => 'Failed to complete the order'];
		}

		$result = json_decode($response, true);
		if (isset($result['data']['draftOrderComplete']['userErrors']) && !empty($result['data']['draftOrderComplete']['userErrors'])) {
			$errors = $result['data']['draftOrderComplete']['userErrors'];
			Log::error('Draft Order Completion Errors:', $errors);
			return ['success' => false, 'error' => 'Failed to complete the order: ' . $errors[0]['message']];
		}

		return ['success' => true, 'response' => $result];
	}
}
