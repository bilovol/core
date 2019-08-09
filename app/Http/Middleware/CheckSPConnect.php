<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Sendpulse\RestApi\ApiClient;
use Sendpulse\RestApi\Storage\SessionStorage;

class CheckSPConnect
{

    public function handle($request, Closure $next)
    {
        $connect = $request->get('connect');
        try {
            (new ApiClient($connect->secretId, $connect->secretKey, new SessionStorage()))->listAddressBooks();
        } catch (Exception $e) {
            return redirect('/connect');
        }
        return $next($request);
    }
}
