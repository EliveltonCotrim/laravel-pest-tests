<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ImportProductsJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(protected array $data, protected readonly int $owner_id)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach ($this->data as $product) {
            Product::query()->create(array_merge($product, ['owner_id' => $this->owner_id]));
        }
    }
}
