<?php

namespace App\Actions;

use App\Models\Product;
use App\Models\User;
use App\Notifications\NewProductionNofication;

class CreateProductAction
{
    public function handle(string $title, User $user)
    {
        Product::query()->create(['title' => $title, 'owner_id' => $user->id]);

        $user->notify(new NewProductionNofication());
    }
}
