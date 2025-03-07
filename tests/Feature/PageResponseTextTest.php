<?php

use App\Models\Product;
use function Pest\Laravel\get;

test('deve listar produtos', function () {
    $productA = Product::factory()->create();
    $productB = Product::factory()->create();

    get('/products')
        ->assertOk()
        ->assertSeeTextInOrder([
            'Product A',
            'Product B',
            $productA->title,
            $productB->title,
        ]);
});
