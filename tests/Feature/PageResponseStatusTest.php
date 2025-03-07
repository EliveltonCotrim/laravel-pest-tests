<?php

test('testando código 200')
    ->get('/')
    ->assertOk();

test('testando código 404')
    ->get('/not-exists')
    ->assertNotFound();
