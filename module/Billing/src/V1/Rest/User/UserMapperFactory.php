<?php

namespace Billing\V1\Rest\User;

use Billing\V1\Main\Mapper\GlobalMapper;

/**
 * class UserMapperFactory
 */
class UserMapperFactory
{
    /**
     * @param $services
     * @return UserMapper
     */
    public function __invoke($services)
    {
        return new UserMapper($services->get(GlobalMapper::class));
    }
}