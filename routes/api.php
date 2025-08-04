<?php

use App\Http\Controllers\BatchController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::apiResource('products', ProductController::class);

Route::apiResource('batches', BatchController::class);

Route::apiResource('clients', ClientController::class);
