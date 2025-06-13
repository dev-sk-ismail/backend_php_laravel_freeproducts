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

        $allproducts = DB::table('products')
            ->select('*')
            ->orderBy('id', 'desc')
            ->simplePaginate(10);

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

        try {
            \Log::info('Product Create Request:', $request->all());

            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'price' => 'required|string|max:255',
                'product_id' => 'nullable|string|max:255',
                'variant_id' => 'nullable|string|max:255',
                'is_voucher' => 'nullable|in:on,1,true',
                'code' => 'nullable|string|max:255'
            ]);

            \Log::info('Validated Data:', $validatedData);

            $insertData = [
                'name' => $validatedData['name'],
                'price' => $validatedData['price'],
                'product_id' => $validatedData['product_id'] ?? null,
                'variant_id' => $validatedData['variant_id'] ?? null,
                'is_voucher' => in_array($request->input('is_voucher'), ['on', '1', 'true']) ? true : false,
                'code' => $request->input('code'),
                'image' => '',
                'updated_at' => now()
            ];

            \Log::info('Insert Data:', $insertData);

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $fullFilename = $fileName . time() . '.' . $file->getClientOriginalExtension();
                $destinationPath = public_path($this->productImagesPath);
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }
                $file->move($destinationPath, $fullFilename);
                $insertData['image'] = $fullFilename;
            }

            DB::table('products')->insert($insertData);
            Session::flash('successMessage', 'Product created successfully.');
            return redirect('/admin/products');
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation Error:', ['errors' => $e->errors()]);
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            \Log::error('Error creating product:', ['error' => $e->getMessage()]);
            Session::flash('errorMessage', 'Error creating product: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function view(Request $request, $id)
    {
        if (!Session::get('userArray')) {
            return redirect('/admin');
        }

        $productDetails = DB::table('products')->select('*')->where('id', $id)->first();
        return view('products.view-product', compact('productDetails'));
    }

    public function update(Request $request, $id)
    {
        if (!Session::get('userArray')) {
            return redirect('/admin');
        }

        try {
            \Log::info('Product Update Request:', $request->all());

            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'price' => 'required|string|max:255',
                'product_id' => 'nullable|string|max:255',
                'variant_id' => 'nullable|string|max:255',
                'is_voucher' => 'nullable|in:on,1,true',
                'code' => 'nullable|string|max:255'
            ]);

            \Log::info('Validated Data:', $validatedData);

            $updateData = [
                'name' => $validatedData['name'],
                'price' => $validatedData['price'],
                'product_id' => $validatedData['product_id'] ?? null,
                'variant_id' => $validatedData['variant_id'] ?? null,
                'is_voucher' => in_array($request->input('is_voucher'), ['on', '1', 'true']) ? true : false,
                'code' => $request->input('code'),
                'updated_at' => now()
            ];

            \Log::info('Update Data:', $updateData);

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
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation Error:', ['errors' => $e->errors()]);
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            \Log::error('Error updating product:', ['error' => $e->getMessage()]);
            Session::flash('errorMessage', 'Error updating product: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
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
