<?php

test('testando código 200')
    ->get('/')
    ->assertStatus(200);
