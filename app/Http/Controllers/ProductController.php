<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        //
    }

    public function store(ProductRequest $request)
    {
        try {

            $product = Product::create($request->all());

            return response()->json(['product' => $product], JsonResponse::HTTP_CREATED);

        } catch (\Exception $e) {
            return response()->json($e->getMessage(), JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(Product $product)
    {
        //
    }

    public function update(Request $request, Product $product)
    {
        try {
            $request->validate([
                'title' => 'required|string|min:3|max:255'
            ]);

            $product = $product->update([
                'title' => $request->get('title')
            ]);

            return response()->json(['product' => $product], JsonResponse::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json($e->getMessage(), JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(Product $product)
    {
        try {
            $product->delete();

            return response()->json(true, JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
