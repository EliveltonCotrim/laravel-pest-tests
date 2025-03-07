<?php

test('a rota products está retornando a view correta products')
    ->get('/products')
    ->assertViewIs('products.index');

test('a rota products está retornando uma lista de products')
    ->get('/products')
    ->assertViewIs('products.index')
    ->assertViewHas('products');
