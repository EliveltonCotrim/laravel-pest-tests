<?php

namespace App\Console\Commands;

use App\Models\Product;
use Http;
use Illuminate\Console\Command;

class ExportProductToAmazon extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:export-product-to-amazon';

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
        Http::withToken('123123')->post(
            'https://api.amazon.com/products',
            Product::all()->map(fn($p) => ['title' => $p->title])->toArray()
        );
    }
}
