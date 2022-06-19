<?php

namespace Billing\V1\Rest\Billing;

use Laminas\Db\Adapter\Adapter;

class BillingMapperFactory
{
    public function __invoke($services)
    {
        return new BillingMapper($services->get(Adapter::class));
    }
}