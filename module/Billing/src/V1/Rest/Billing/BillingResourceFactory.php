<?php
namespace Billing\V1\Rest\Billing;

/**
 *
 */
class BillingResourceFactory
{
    /**
     * @param $services
     * @return BillingResource
     */
    public function __invoke($services)
    {
        return new BillingResource($services->get(BillingMapper::class));
    }
}
