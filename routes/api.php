<?php

use App\Http\Controllers\ProductController;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/products', function () {
    $produts1 = [
        ['title' => 'Produto A'],
        ['title' => 'Produto B'],
    ];

    $products = Product::all()->map(fn($p) => ['title' => $p->title])->toArray();

    return response()->json(array_merge($produts1, $products));
});

Route::apiResource('/products', ProductController::class);
