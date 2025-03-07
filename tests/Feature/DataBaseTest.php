<?php

use App\Models\Product;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\assertSoftDeleted;
use function Pest\Laravel\deleteJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;
use function PHPUnit\Framework\assertSame;

it('should be able o create a product', function () {
    $data = [
        'title' => 'Produto teste'
    ];

    postJson(route('products.store'), $data)
        ->assertCreated();

    assertDatabaseHas('products', ['title' => $data['title']]);
    assertDatabaseCount('products', 1);

});

it('should be able to update a product', function () {
    $product = Product::factory()->create();

    $data = [
        'title' => 'Produto atualizado'
    ];

    putJson(route('products.update', $product), $data)
        ->assertOk()
        ->assertJson([
            'product' => [
                'id' => $product->id,
                'title' => $data['title']
            ]
        ])->assertJsonMissingValidationErrors();

    // Primeira forma de validar se o item foi atualizado.
    assertDatabaseHas('products', ['id' => $product->id, 'title' => $data['title']]);

    // Segunda forma
    expect($product)
        ->refresh()
        ->title->toBe($data['title']);

    // Terceira forma
    assertSame($data['title'], $product->title);

    assertDatabaseCount('products', 1);

});

// it('should be able to delete a product', function () {
//     $product = Product::factory()->create();

//     deleteJson(route('products.destroy', $product))
//         ->assertOk();

//     assertDatabaseMissing('products', ['id' => $product->id]);
//     assertDatabaseCount('products', 0);
// });

it('should be able to sofdelete a product', function () {
    $product = Product::factory()->create();

    deleteJson(route('products.destroy', $product))
        ->assertOk();

    assertSoftDeleted('products', ['id' => $product->id]);
    assertDatabaseCount('products', 1);
});
