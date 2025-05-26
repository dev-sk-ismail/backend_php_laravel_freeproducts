<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
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
		Session::put('userCred',$request->all());
		$userCred = array(
			'name' => $request->get('name'),
			'email'=> $request->get('email'),
			'phone'=> $request->get('phone_number')
		);
		$this->add_klaviyo_firstList($userCred);
		return view('user.order');
	}
	public function add_klaviyo_firstList($userCred){
		$userdata1 = array('profiles' => $userCred);
		$data_string =json_encode($userdata1);
		$api_key='pk_046f5b0ce6553543d8db2b42fd410e9061';
		$ch = curl_init("https://a.klaviyo.com/api/v2/list/Nvm9d9/members?api_key=$api_key");
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
	        'order_id' => 'required']);
		Session::put('amazonOderId',$request->get('order_id'));
		$allproducts = DB::table('products')->select('*')->simplePaginate(10)->toArray();
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
		//dd($product_review);
		$user_cred = Session::get('userCred');
		$user_cred['orderId'] = Session::get('amazonOderId');
		return view('user.confirm_address',compact('user_cred'));
	}

	public function sentUserData(Request $request)
	{
		
		$validatedData = $request->validate([
	        'name' => 'required|max:255',
	        'address_line1' => 'required|max:255',
	        'email_address' => 'required|email',
	        'phone' => 'required|numeric',
	        'city' => 'required',
	        'state_or_region' => 'required',
	        'country_code' => 'required',
	        'zip_code' => 'required'
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
		
    	//$this->sendMail($userData);
    	return redirect('thankyou');
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
		$data_string =json_encode($data);
		$api_key='pk_046f5b0ce6553543d8db2b42fd410e9061';
		$email = $userData['email'];
		/*Find is the customer exist*/
		$ch = curl_init("https://a.klaviyo.com/api/v2/list/Nvm9d9/members?api_key=$api_key&emails=$email");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		$result = curl_exec($ch);
		$res = json_decode($result,1);
		curl_close($ch);

		if(isset($res[0]['email']) &&  $res[0]['email'] == $userData['email']){
			/*Delete from first list*/
			$ch = curl_init("https://a.klaviyo.com/api/v2/list/Nvm9d9/members?api_key=$api_key&emails=$email");
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
			$result = curl_exec($ch);
			curl_close($ch);

			/*Insert in new list*/
			$curl = curl_init("https://a.klaviyo.com/api/v2/list/Q4pUHN/members?api_key=$api_key");
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
}
