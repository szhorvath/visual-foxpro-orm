<?php

namespace Szhorvath\FoxproDB\Facades;

use Illuminate\Support\Facades\Facade;

class FoxproDB extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'foxprodb';
    }
}
