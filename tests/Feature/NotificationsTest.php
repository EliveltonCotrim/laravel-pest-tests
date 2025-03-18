<?php

use App\Models\User;
use App\Notifications\NewProductionNofication;
use Illuminate\Support\Facades\Notification;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\postJson;

it('should sends a notification about a new product', function () {
    Notification::fake();

    $user = User::factory()->create();

    actingAs($user);

    postJson(route('product.store'), [
        'title' => 'Product',
        'code' => Str::random(10),
        'owner_id' => $user->id
    ])->assertCreated();

    Notification::assertCount(1);
    Notification::assertSentTo($user, NewProductionNofication::class);
});
