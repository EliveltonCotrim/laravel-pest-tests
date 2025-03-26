<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\User;
use Illuminate\Console\Command;
use App\Actions\CreateProductAction;
use \Illuminate\Support\Facades\Validator;

class CreateProductCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create-product  {title?} {owner_id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $title = $this->argument('title');
        $owner_id = $this->argument('owner_id');

        if(!$owner_id)
            $owner_id = $this->components->ask('Please, provide a valid user id');

        if(!$title){
            $title = $this->components->ask('Please, provide a title for the product');
        }

        Validator::make(['title' => $title, 'owner_id' => $owner_id], [
            'title' => 'required|string',
            'owner_id' => 'required|exists:users,id'
        ])->validate();

        app(CreateProductAction::class)->handle($title, User::findOrFail($owner_id));

        // Product::query()->create([
        //     'title' => $title,
        //     'owner_id' => $owner_id
        // ]);

        $this->components->info(sprintf('Product created!!!'));
    }
}
