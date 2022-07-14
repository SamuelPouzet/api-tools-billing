<?php

namespace Billing\V1\Main\Traits;

trait NamingTrait
{
    private function keyAsSetter(string $key): string
    {
        $array = explode('_', $key);
        array_map('strtolower', $array);
        array_map('ucfirst', $array);
        return 'set' . implode('', $array);
    }

    private function keyAsGetter(string $key): string
    {
        $array = explode('_', $key);
        array_map('strtolower', $array);
        array_map('ucfirst', $array);
        return 'get' . implode('', $array);
    }
}