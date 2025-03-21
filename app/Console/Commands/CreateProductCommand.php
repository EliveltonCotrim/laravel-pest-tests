<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

class CreateProductCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-product-command  {title?} {owner_id?}';

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

        Product::query()->create([
            'title' => $title,
            'owner_id' => $owner_id
        ]);

        $this->components->info(sprintf('Product created!!!'));
    }
}
