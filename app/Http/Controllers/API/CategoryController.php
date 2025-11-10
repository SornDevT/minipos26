<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::orderBy('id', 'asc')->get();
        return response()->json($categories);
    }


    public function store(Request $request)
    {
        try {

            $category = new Category();
            $category->CategoryName = $request->name;
            $category->save();

            $susccess = true;
            $message = "ເພີ່ມໝວດໝູ່ສຳເລັດ";

        } catch (\Illuminate\Database\QueryException $ex) {
            $susccess = false;
            $message = $ex->getMessage();
        }

        // return response
        return response()->json([
            'success' => $susccess,
            'message' => $message,
        ], 201);
    }

    public function show($id)
    {
        $category = Category::find($id);
        return response()->json($category);
    }

    public function update(Request $request, $id)
    {
        try {

            $category = Category::find($id);

            if (!$category) {
                return response()->json([
                    'success' => false,
                    'message' => 'Category not found',
                ], 404);
            }

            $category->CategoryName = $request->name;
            $category->save();

            $susccess = true;
            $message = "ແກ້ໄຂໝວດໝູ່ສຳເລັດ";

        } catch (\Illuminate\Database\QueryException $ex) {
            $susccess = false;
            $message = $ex->getMessage();
        }

        // return response
        return response()->json([
            'success' => $susccess,
            'message' => $message,
        ], 200);
    }

    public function destroy($id)
    {
        try {

            $category = Category::find($id);

            if (!$category) {
                return response()->json([
                    'success' => false,
                    'message' => 'Category not found',
                ], 404);
            }

            $category->delete();

            $susccess = true;
            $message = "ລຶບໝວດໝູ່ສຳເລັດ";

        } catch (\Illuminate\Database\QueryException $ex) {
            $susccess = false;
            $message = $ex->getMessage();
        }

        // return response
        return response()->json([
            'success' => $susccess,
            'message' => $message,
        ], 200);
    }
   
}
