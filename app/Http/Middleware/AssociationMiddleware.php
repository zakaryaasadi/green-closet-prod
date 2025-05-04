<?php

namespace App\Http\Middleware;

use App\Enums\UserType;
use App\Helpers\AppHelper;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssociationMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()->type == UserType::ASSOCIATION)
            return $next($request);

        else
            return redirect('/' . AppHelper::getSlug() . '/');
    }
}
