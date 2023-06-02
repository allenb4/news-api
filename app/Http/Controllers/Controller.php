<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function getPageLimit()
    {
        return is_numeric(request()->input('perPage')) ?
            request()->input('perPage') :
            10;
    }

    protected function getCurrentPage()
    {
        return is_numeric(request()->input('page')) ?
            request()->input('page') :
            1;
    }
}
