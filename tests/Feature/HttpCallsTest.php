<?php

it('has httpcalls page', function () {
    $response = $this->get('/httpcalls');

    $response->assertStatus(200);
});
