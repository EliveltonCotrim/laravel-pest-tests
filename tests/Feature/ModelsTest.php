<?php

use App\Models\Product;
use App\Models\User;
use function PHPUnit\Framework\assertTrue;

it('model relathionship :: product owner should be an user', function () {
    // $product = Product::factory()
    //     ->hasOwner()
    //     ->create();

    $user = User::factory()->create();

    $product = Product::factory()
        ->create();


    expect($product->owner)
        ->toBeInstanceOf(User::class);

});

it('model get mutator :: product title should always be str()->title()', function () {
    $product = Product::factory()->create(['title' => 'titulo']);

    expect($product)
        ->title->toBe('Titulo');
});

it('model get mutator :: product code should be encrypted', function () {
    $product = Product::factory()->create(['code' => 'codigo_123']);

    assertTrue(Hash::isHashed($product->code));
});

it('model scopes :: should bring only relased products', function () {
    Product::factory()->count(10)->create(['released' => true]);
    Product::factory()->count(5)->create(['released' => false]);

    expect(Product::query()->released()->get())
        ->toHaveCount(10);
});
