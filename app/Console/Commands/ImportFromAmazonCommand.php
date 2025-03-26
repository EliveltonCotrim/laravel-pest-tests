<?php

namespace App\Console\Commands;

use App\Models\User;
use Http;
use Illuminate\Console\Command;
use App\Actions\CreateProductAction;

class ImportFromAmazonCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-from-amazon-command';

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
        $data = Http::get('https://api.amazon.com/products')->json();

        $action = app(CreateProductAction::class);
        foreach ($data as $key => $item) {
            $action->handle($item['title'], User::first());
        }
    }
}
