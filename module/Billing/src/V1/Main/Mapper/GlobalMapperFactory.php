<?php

namespace Billing\V1\Main\Mapper;

use Laminas\Db\Adapter\Adapter;

class GlobalMapperFactory
{
    public function __invoke($services)
    {
        return new GlobalMapper($services->get(Adapter::class));
    }
}