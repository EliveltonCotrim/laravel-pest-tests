<?php

use App\Jobs\ImportProductsJob;
use App\Mail\WelcomeEmail;
use App\Models\Product;
use App\Models\User;
use App\Notifications\NewProductionNofication;
use Illuminate\Support\Facades\Route;
use function Pest\Laravel\options;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/products', function () {
    return view('products.index', ['products' => Product::all()]);
});

Route::post('/upload-avatar', function (Request $request) {
    $file = request()->file('file');
    $file->store(path: '/', options: ['disk' => 'avatar']);
})->name('upload.avatar');
Route::post('/import-products', function (Request $request) {
    $file = request()->file('file');

    $openToRead = fopen($file->getRealPath(), 'r');

    while(($data = fgetcsv($openToRead, 1000, ',')) !== false){
        Product::create([
            'title' => $data[0],
            'owner_id' => $data[1],
            'price' => $data[1]
        ]);
    }
})->name('import.products');

Route::post('sending-email/{user}', function(User $user){

    Mail::to($user)->send(new WelcomeEmail($user));
})->name('sending-email');

Route::post('porduct-import', function(){
    $data = request()->get('data');
    ImportProductsJob::dispatch($data, auth()->id());

})->name('product.import');

Route::post('porduct/store', function(){

    $data = request()->all();

    Product::create($data);

    auth()->user()->notify(new NewProductionNofication());

    return response()->json(true, 201);

})->name('product.store');


