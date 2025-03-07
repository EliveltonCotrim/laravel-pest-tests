<?php

use App\Models\Product;
use function Pest\Laravel\get;

it('should return list products', function () {
    $response = $this->get('/api/products');

    $response->assertOk()->assertExactJson([
        ['title' => 'Produto A'],
        ['title' => 'Produto B'],
    ]);
});

it('should list products from the database', function () {
    $product1 = Product::factory()->create();
    $product2 = Product::factory()->create();

    get( '/api/products')->assertOk()->assertJson([
        ['title' => 'Produto A'],
        ['title' => 'Produto B'],
        ['title' => $product1->title],
        ['title' => $product2->title],
    ]);
});
