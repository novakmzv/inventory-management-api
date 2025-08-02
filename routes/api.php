<?php

use App\Http\Controllers\BatchController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::apiResource('products', ProductController::class);

Route::apiResource('batches', BatchController::class);
