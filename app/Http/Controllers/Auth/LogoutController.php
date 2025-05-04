<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\AppHelper;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Session;

class LogoutController extends BaseController
{
    public function logout()
    {
        Session::flush();

        Auth::logout();

        return redirect('/' . AppHelper::getSlug());
    }
}
