<?php

use Illuminate\Support\Str;
use function Pest\Laravel\post;
use function Pest\Laravel\postJson;

it('product :: title should be required', function () {
    postJson(route('products.store'), ['title' => ''])
        ->assertInvalid(['title' => 'required']);

    post(route('products.store'), ['title' => ''])
        ->assertInvalid(['title' => 'required']);
});

it('product :: title should be max of 255 caracters', function () {

    postJson(route('products.store'), ['title' => Str::random(256)])
        ->assertInvalid(['title' => trans('validation.max.string', ['attibute' => 'title', 'max' => '255'])]);

});

it('create product validations', function ($data, $error) {

    postJson(route('products.store'), $data)
        ->assertInvalid($error);

})->with([
    'title:required' => [['title' => ''], ['title' => 'requred']],
    'title:max:255' => [['title' => Str::random(256)], ['title' =>  trans('validation.max.string', ['attibute' => 'title', 'max' => '255'])]],
]);
