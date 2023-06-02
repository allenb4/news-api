<?php

namespace App\Lib\News;

use Illuminate\Support\Facades\Facade;

class NewsFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Factory::class;
    }
}
