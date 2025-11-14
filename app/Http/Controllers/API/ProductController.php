<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    // ✅ GET /products
    public function index()
    {

       $sort = \Request::get('sort', 'asc');
       $perPage = \Request::get('perPage');
       $search = \Request::get('search', '');
       $categoryFilter = \Request::get('category', 'all'); 

        // join with categories to get CategoryName ande select products with category name
        $products = Product::join('categories', 'products.CategoryID', '=', 'categories.id')
        ->select('products.*', 'categories.CategoryName');

        // category filter
        if ($categoryFilter !== 'all') {
            $products = $products->where('products.CategoryID', $categoryFilter);
        }

        // search filter
        if ($search !=='') {
            $products = $products->where(
                function($query) use ($search) {
                    $query->where('products.ProductName', 'like', '%' . $search . '%')
                          ->orWhere('categories.CategoryName', 'like', '%' . $search . '%')
                          ->orWhere('products.PriceBuy', 'like', '%' . $search . '%')
                          ->orWhere('products.PriceSell', 'like', '%' . $search . '%');
                }
            );
        }


       $products = $products->orderBy('products.id', $sort)
       ->paginate($perPage);

        return response()->json($products);
    }

    // ✅ POST /products
    public function store(Request $request)
    {
        try {

            // ✅ Image Upload (optional)
            $imagePath = null;
            $imageName = '';
            if ($request->hasFile('ImagePath')) {
                $file = $request->file('ImagePath');
                $imageName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('assets/img/products/'), $imageName);
                $imagePath = 'assets/img/products/' . $imageName;
            }

            $product = new Product();
            $product->ProductName = $request->ProductName;
            $product->CategoryID = $request->CategoryID;
            $product->ImagePath = $imageName;
            $product->Qty = $request->Qty;
            $product->PriceBuy = $request->PriceBuy;
            $product->PriceSell = $request->PriceSell;
            $product->save();

            $success = true;
            $message = "ເພີ່ມສິນຄ້າສຳເລັດ";

        } catch (\Illuminate\Database\QueryException $ex) {
            $success = false;
            $message = $ex->getMessage();
        }

        return response()->json([
            'success' => $success,
            'message' => $message,
        ], 201);
    }

    // ✅ GET /products/{id}
    public function show($id)
    {
        $product = Product::find($id);
        return response()->json($product);
    }

    // ✅ PUT /products/{id}
    public function update(Request $request, $id)
    {
        try {

            $product = Product::find($id);

            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found',
                ], 404);
            }

            // ✅ Update new image if uploaded
            if ($request->hasFile('image')) {

                // delete old image
                if ($product->ImagePath && file_exists(public_path($product->ImagePath))) {
                    unlink(public_path($product->ImagePath));
                }

                $file = $request->file('image');
                $imageName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/products'), $imageName);
                $product->ImagePath = 'uploads/products/' . $imageName;
            }

            $product->ProductName = $request->ProductName;
            $product->CategoryID = $request->CategoryID;
            $product->Qty = $request->Qty;
            $product->PriceBuy = $request->PriceBuy;
            $product->PriceSell = $request->PriceSell;

            $product->save();

            $success = true;
            $message = "ແກ້ໄຂສິນຄ້າສຳເລັດ";

        } catch (\Illuminate\Database\QueryException $ex) {
            $success = false;
            $message = $ex->getMessage();
        }

        return response()->json([
            'success' => $success,
            'message' => $message,
        ], 200);
    }

    // ✅ DELETE /products/{id}
    public function destroy($id)
    {
        try {

            $product = Product::find($id);

            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found',
                ], 404);
            }

            // delete image
            if ($product->ImagePath && file_exists(public_path($product->ImagePath))) {
                unlink(public_path($product->ImagePath));
            }

            $product->delete();

            $success = true;
            $message = "ລຶບສິນຄ້າສຳເລັດ";

        } catch (\Illuminate\Database\QueryException $ex) {
            $success = false;
            $message = $ex->getMessage();
        }

        return response()->json([
            'success' => $success,
            'message' => $message,
        ], 200);
    }
}
