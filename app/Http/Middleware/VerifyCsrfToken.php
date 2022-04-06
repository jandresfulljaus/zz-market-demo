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
        //
        'http://oms.bridgestone.fj:8000/api/ordenes/impactar',
        'http://oms.fulljaus.com/api/ordenes/impactar',
    ];
}
