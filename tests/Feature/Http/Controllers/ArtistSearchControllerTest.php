<?php

test('__invoke', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
})->todo();
