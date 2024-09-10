<?php

namespace Triptasoft\FilamentAiSql\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Triptasoft\FilamentAiSql\FilamentAiSql
 */
class FilamentAiSql extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Triptasoft\FilamentAiSql\FilamentAiSql::class;
    }
}
