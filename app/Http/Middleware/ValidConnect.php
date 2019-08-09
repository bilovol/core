<?php

namespace App\Http\Middleware;

use App\Models\Connect;
use Closure;

class ValidConnect
{
    public function handle($request, Closure $next)
    {
        $connect = Connect::where('id', 1)->first();
        if (empty($connect)) {
            return redirect('/');
        }

        $request->attributes->add(['connect' => $connect]);

        return $next($request);
    }
}
