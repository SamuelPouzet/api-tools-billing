<?php

namespace Billing\V1\Rest\Company;

use Billing\V1\Main\Mapper\GlobalMapper;

/**
 * class CompanyMapperFactory
 */
class CompanyMapperFactory
{
    /**
     * @param $services
     * @return CompanyMapper
     */
    public function __invoke($services)
    {
        return new CompanyMapper($services->get(GlobalMapper::class));
    }
}