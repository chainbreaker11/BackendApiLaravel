<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Product_Controller;

Route::get('/products', [Product_Controller::class, 'index']);
Route::get('/products/{id}', [Product_Controller::class, 'show']);
Route::post('/products', [Product_Controller::class, 'store']);
Route::put('/products/{id}', [Product_Controller::class, 'update']);
Route::delete('/products/{id}', [Product_Controller::class, 'destroy']);
