<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return [
        'rc' => '0200',
        'message' => 'Successfully',
        'data' => [
            'description' => 'CRM Paketur',
            'version' => '1.0.0'
        ]
    ];
});
