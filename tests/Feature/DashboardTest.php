<?php

it('loads dashboard', function () {
    $response = $this->get('/');
    $response->assertStatus(200);
});
