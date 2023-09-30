<?php

namespace Gavan4eg\CashalotApi\Facades;

use Illuminate\Support\Facades\Facade;

class CashalotApi extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'cashalotapi';
    }
}
