<?php

namespace Billing\V1\Rest\Company;

use Laminas\Db\Adapter\Adapter;

class CompanyMapperFactory
{
    public function __invoke($services)
    {
        return new CompanyMapper($services->get(Adapter::class));
    }
}