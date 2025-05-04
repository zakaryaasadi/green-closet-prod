<?php

namespace App\Http\Middleware;

use App\Enums\UserType;
use App\Helpers\AppHelper;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()->type == UserType::CLIENT)
            return $next($request);

        else
            return redirect('/' . AppHelper::getSlug() . '/');
    }
}
