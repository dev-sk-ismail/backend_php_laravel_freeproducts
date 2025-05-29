<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    private $productImagesPath = 'admin_product_images';

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
            'price' => 'required',
            'product_id' => 'required',
            'variant_id' => 'required'
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $fullFilename = $fileName . time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path($this->productImagesPath);
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
            'product_id' => $validatedData['product_id'],
            'variant_id' => $validatedData['variant_id'],
            'image' => $fullFilename
        );

        DB::table('products')->insert($insertData);
        Session::flash('successMessage', 'Product created successfully.');

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

    public function update(Request $request, $id)
    {
        if (!Session::get('userArray')) {
            return redirect('/admin');
        }

        $validatedData = $request->validate([
            'name' => 'required',
            'price' => 'required',
            'product_id' => 'required',
            'variant_id' => 'required'
        ]);

        $updateData = [
            'name' => $validatedData['name'],
            'price' => $validatedData['price'],
            'product_id' => $validatedData['product_id'],
            'variant_id' => $validatedData['variant_id']
        ];

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $fullFilename = $fileName . time() . '.' . $file->getClientOriginalExtension();

            $destinationPath = public_path($this->productImagesPath);
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $file->move($destinationPath, $fullFilename);

            // Delete old image if exists
            $oldProduct = DB::table('products')->select('image')->where('id', $id)->first();
            if ($oldProduct && $oldProduct->image) {
                $oldImagePath = public_path($this->productImagesPath . '/' . $oldProduct->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $updateData['image'] = $fullFilename;
        }

        DB::table('products')->where('id', $id)->update($updateData);
        Session::flash('successMessage', 'Product updated successfully.');

        return redirect('/admin/products');
    }

    public function destroy($id)
    {
        if (!Session::get('userArray')) {
            return redirect('/admin');
        }

        // Delete image file if exists
        $product = DB::table('products')->select('image')->where('id', $id)->first();
        if ($product && $product->image) {
            $imagePath = public_path($this->productImagesPath . '/' . $product->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        // Delete the product from database
        DB::table('products')->where('id', $id)->delete();
        Session::flash('successMessage', 'Product deleted successfully.');

        return redirect('/admin/products');
    }
}
