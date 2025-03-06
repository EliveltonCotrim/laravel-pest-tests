<?php

use function Pest\Laravel\get;


test('test the application returns a successful response')
    ->get('/')
    ->assertStatus(200);
