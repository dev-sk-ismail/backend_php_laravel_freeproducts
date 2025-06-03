<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\sendMailtoUser;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
	public function index()
	{
		return view('user/index');
	}
	public function order(Request $request)
	{
		$userCred = array(
			'name' => $request->get('full_name'),
			'email'=> $request->get('email'),
			'phone_number' => $request->get('phone_number')
		);
		Session::put('userCred', $userCred);
		$this->add_klaviyo_firstList($userCred);
		return view('user.order');
	}	public function add_klaviyo_firstList($userCred){
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
		curl_close($ch);
	}

	public function search_offer(Request $request)
	{
		$validatedData = $request->validate([
			'order_id' => 'required'
		]);
		Session::put('amazonOderId',$request->get('order_id'));
		$query = DB::table('products')->select('*');
		$allproducts = [
			'data' => $query->simplePaginate(10)->items(),
			'prev_page_url' => $query->simplePaginate(10)->previousPageUrl(),
			'next_page_url' => $query->simplePaginate(10)->nextPageUrl()
		];
		return view('user.search_offer',compact('allproducts'));
	}
	public function usingDay(Request $request)
	{
		Session::put('productName', $request->get('productName'));
		Session::put('productDetails', [
			'product_id' => $request->get('product_id'),
			'variant_id' => $request->get('variant_id'),
			'price' => $request->get('price')
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
			'orderId' => Session::get('amazonOderId')
		], $user_cred);

		return view('user.confirm_address', compact('user_cred'));
	}
	public function sentUserData(Request $request)
	{
		try {
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
		$amazonOderId = Session::get('amazonOderId');
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

		$userData = array(
            'name' => $validatedData['name'],
            'address' => $validatedData['address_line1'],
            'email' => $validatedData['email_address'],
            'phone' => $validatedData['phone'],
            'city' => $validatedData['city'],
            'state' => $validatedData['state_or_region'],
            'country' => $validatedData['country_code'],
            'zip_code' => $validatedData['zip_code'],
            'amazonOderId' => $amazonOderId,
            'product_name' => $productName,
            'product_review' => $product_review,
            'product_feedback' => $product_feedback,
            'product_rating' => $product_rating ,
            'created_at' => $lastupdated = date('Y-m-d H:i:s')
			);
			DB::table('users')->insert($userData);
			$this->add_klaviyo_finalList($userData);
			// Create Shopify order
			try {
				$orderCreated = $this->createShopifyOrder($userData);
				if (!$orderCreated) {
					throw new \Exception('Failed to create Shopify order');
				}
				//$this->sendMail($userData);
				return redirect('thankyou');
			} catch (\Exception $e) {
				Log::error('Shopify Order Creation Error: ' . $e->getMessage());
				return back()
					->withInput()
					->withErrors(['shopify_error' => 'There was an error creating your order. Please try again.']);
			}
		} catch (\Illuminate\Validation\ValidationException $e) {
			return back()->withErrors($e->errors())->withInput();
		} catch (\Exception $e) {
			Log::error('Error in sentUserData: ' . $e->getMessage());
			return back()->withErrors(['error' => 'An error occurred while processing your request. Please try again.'])->withInput();
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

		$userData['amazonOderId'] = Session::get('amazonOderId');
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
		$productDetails = Session::get('productDetails');
		if (!$productDetails) {
			Log::error('Product details not found in session');
			throw new \Exception('Product details not found in session');
		}

		// Set up the Shopify API request
		$domain = config('services.shopify.domain');
		$version = "2023-07"; // Using a stable API version
		$accessToken = config('services.shopify.access_token');
		$shopifyEndpoint = "https://{$domain}/admin/api/{$version}/graphql.json";

		if (empty($domain) || empty($accessToken)) {
			Log::error('Shopify configuration missing');
			throw new \Exception('Shopify configuration is incomplete');
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
						"firstName" => $userData['name'],
						"lastName" => $userData['name'],
						"phone" => $userData['phone']
					],
					"shippingAddress" => [
						"address1" => $userData['address'],
						"city" => $userData['city'],
						"province" => $userData['state'],
						"zip" => $userData['zip_code'],
						"country" => $userData['country'],
						"firstName" => $userData['name'],
						"lastName" => $userData['name'],
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
							"value" => $userData['amazonOderId']
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
			throw new \Exception('Failed to connect to Shopify API: ' . $error);
		}

		if ($httpCode !== 200) {
			Log::error('Shopify API Error - HTTP Code: ' . $httpCode . ', Response: ' . $response);
			throw new \Exception('Shopify API returned error code: ' . $httpCode);
		}

		$result = json_decode($response, true);
		if (json_last_error() !== JSON_ERROR_NONE) {
			Log::error('Shopify Response JSON Parse Error: ' . json_last_error_msg() . ', Response: ' . $response);
			throw new \Exception('Invalid response from Shopify API');
		}

		// Check for GraphQL errors
		if (isset($result['errors'])) {
			Log::error('Shopify GraphQL Errors:', $result['errors']);
			throw new \Exception('Shopify API returned errors: ' . $result['errors'][0]['message']);
		}

		// Check for user errors in the mutation response
		if (!empty($result['data']['draftOrderCreate']['userErrors'])) {
			$errors = $result['data']['draftOrderCreate']['userErrors'];
			Log::error('Shopify Order Creation User Errors:', $errors);
			throw new \Exception('Order creation failed: ' . $errors[0]['message']);
		}

		if (!isset($result['data']['draftOrderCreate']['draftOrder']['id'])) {
			Log::error('Shopify Order Creation Failed - No Order ID Returned:', $result);
			throw new \Exception('Order creation failed: No order ID returned');
		}

		// After successful draft order creation, complete it
		if (isset($result['data']['draftOrderCreate']['draftOrder']['id'])) {
			$draftOrderId = $result['data']['draftOrderCreate']['draftOrder']['id'];

			// Complete the draft order
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

			// Make the completion request
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

			$completeResponse = curl_exec($ch);
			$completeHttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			$completeError = curl_error($ch);
			curl_close($ch);

			Log::debug('Shopify Draft Order Complete Response:', [
				'httpCode' => $completeHttpCode,
				'response' => $completeResponse
			]);

			if ($completeError || $completeHttpCode !== 200) {
				Log::error('Failed to complete draft order:', [
					'error' => $completeError,
					'httpCode' => $completeHttpCode,
					'response' => $completeResponse
				]);
				throw new \Exception('Failed to complete the order');
			}

			$completeResult = json_decode($completeResponse, true);
			if (isset($completeResult['data']['draftOrderComplete']['userErrors']) && !empty($completeResult['data']['draftOrderComplete']['userErrors'])) {
				$errors = $completeResult['data']['draftOrderComplete']['userErrors'];
				Log::error('Draft Order Completion Errors:', $errors);
				throw new \Exception('Failed to complete the order: ' . $errors[0]['message']);
			}

			// Store the final order ID in session
			if (isset($completeResult['data']['draftOrderComplete']['draftOrder']['order']['id'])) {
				Session::put('shopify_order_id', $completeResult['data']['draftOrderComplete']['draftOrder']['order']['id']);
			}
		}

		return true;
	}
}
