<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        if (!Session::get('userArray')) {
            return redirect('/admin');
        }

        $allproducts = DB::table('products')->select('*')->simplePaginate(10)->toArray();

        return view('products.index', compact('allproducts'));
    }

    public function add()
    {
        return view('products.add-product');
    }

    public function newProductCreate(Request $request)
    {
        if (!Session::get('userArray')) {
            return redirect('/admin');
        }

        $validatedData = $request->validate([
            'name' => 'required',
            'price' => 'required'
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $fullFilename = $fileName . time() . '.' . $file->getClientOriginalExtension();

            $destinationPath = public_path('admin_product_images');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $file->move($destinationPath, $fullFilename);
        } else {
            $fullFilename = '';
        }

        $insertData = array(
            'name' => $validatedData['name'],
            'price' => $validatedData['price'],
            'image' => $fullFilename
        );

        DB::table('products')->insert($insertData);
        Session::flash('successMessage', 'You have successfully registered a new user.');

        return redirect('/admin/products');
    }

    public function view(Request $request, $id)
    {
        if (!Session::get('userArray')) {
            return redirect('/admin');
        }

        $productDetails = DB::table('products')->select('*')->where(array('id' => $id))->first();
        return view('products.view-product', compact('productDetails'));
    }
}
