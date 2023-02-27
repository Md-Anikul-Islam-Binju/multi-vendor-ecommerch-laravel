<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/sslcommerz/pay-via-ajax', '/sslcommerz/success','/sslcommerz/cancel','/sslcommerz/fail','/sslcommerz/ipn','/nagad/payment','/nagad/payment/success'
    ];
}
