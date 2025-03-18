<?php

use App\Actions\CreateProductAction;
use App\Models\Product;
use App\Models\User;
use App\Notifications\NewProductionNofication;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\postJson;

it('has actions page', function () {
    Notification::fake();

    // assert
    $this->mock(CreateProductAction::class)
        ->shouldReceive('handle')
        ->atLeast()->once();

    // Aarrange
    $user = User::factory()->create();
    $title = 'Product 1';

    actingAs($user);

    // Act
    postJson(route('product.store'), [
        'title' => $title,
        'owner_id' => $user->id
    ]);

});

it('should be able to create a product', function () {
    Notification::fake();

    $user = User::factory()->create();

    (new CreateProductAction()->handle('Product 1', $user));

    assertDatabaseCount(Product::class, 1);
    assertDatabaseHas(Product::class, ['title' => 'Product 1', 'owner_id' => $user->id]);

    Notification::assertSentTo($user, NewProductionNofication::class);
});
