<?php
namespace Billing\V1\Rest\Billing;

class BillingResourceFactory
{
    public function __invoke($services)
    {
        return new BillingResource();
    }
}
