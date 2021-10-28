<?php

use SAM\SSLCommerz\Http\Controllers\SSLCommerzController;










Route::post('/sslcommerz/success', [SSLCommerzController::class, 'success']);
Route::post('/sslcommerz/fail', [SSLCommerzController::class, 'fail']);
Route::post('/sslcommerz/cancel', [SSLCommerzController::class, 'cancel']);

Route::post('/sslcommerz/ipn', [SSLCommerzController::class, 'ipn']);
//SSLCOMMERZ END
