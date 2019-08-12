<?php

namespace App\Http\Middleware;

use App\Repositories\ConnectRepository;
use Closure;
use Exception;
use Sendpulse\RestApi\ApiClient;
use Sendpulse\RestApi\Storage\SessionStorage;

class CheckSPConnect
{

    public function handle($request, Closure $next)
    {
        $sessionConnectId = 1;
        $connect = (new ConnectRepository())->getSpConnectById($sessionConnectId);
        try {
            (new ApiClient($connect['secret_id'], $connect['secret_key'], new SessionStorage()))->listAddressBooks();
        } catch (Exception $e) {
            return redirect('/connect');
        }
        return $next($request);
    }
}
