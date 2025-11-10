<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    // ✅ GET /products
    public function index()
    {
        $products = Product::orderBy('id', 'asc')->get();
        return response()->json($products);
    }

    // ✅ POST /products
    public function store(Request $request)
    {
        try {

            // ✅ Image Upload (optional)
            $imagePath = null;

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $imageName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/products'), $imageName);
                $imagePath = 'uploads/products/' . $imageName;
            }

            $product = new Product();
            $product->ProductName = $request->ProductName;
            $product->CategoryID = $request->CategoryID;
            $product->ImagePath = $imagePath;
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
