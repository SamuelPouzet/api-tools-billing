<?php

namespace Billing\V1\Rest\Billing;

use Billing\V1\Main\Mapper\GlobalMapper;
use Laminas\Db\Adapter\Adapter;

class BillingMapperFactory
{
    public function __invoke($services)
    {
        return new BillingMapper($services->get(GlobalMapper::class));
    }
}