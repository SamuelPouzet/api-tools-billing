<?php

namespace Billing\V1\Main\Mapper;

use Laminas\Db\Adapter\Adapter;

/**
 * class GlobalMapperFactory
 * génère un globalmapper
 */
class GlobalMapperFactory
{
    /**
     * @param $services
     * @return GlobalMapper
     */
    public function __invoke($services)
    {
        $config = $services->get('config');
        $relationalConfig = $config['mapper-relationnal'] ?? null;
        return new GlobalMapper($services->get(Adapter::class), $relationalConfig);
    }
}