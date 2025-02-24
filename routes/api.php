<?php

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;

Route::get('/get/{slug}', [ApiController::class, 'index']);

