<?php

namespace Billing\V1\Rest\User;

use Laminas\Db\Adapter\Adapter;

class UserMapperFactory
{
    public function __invoke($services)
    {
        return new UserMapper($services->get(Adapter::class));
    }
}