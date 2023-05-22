<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class DeleteRubbishedProductImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-rubbished-product-images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete isolated product images from the disk';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $files = Storage::disk('products')->allFiles('image');
        foreach ($files as $file) {
            $product = Product::where('image_url', $file)->get()->first();
            if (!$product) {
                Storage::disk('products')->delete($file);
            }
        }
    }
}
