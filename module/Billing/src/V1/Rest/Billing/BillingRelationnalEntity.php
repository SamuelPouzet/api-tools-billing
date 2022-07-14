<?php

namespace Billing\V1\Rest\Billing;

use Billing\V1\Rest\Company\CompanyEntity;
use Billing\V1\Rest\User\UserEntity;

class BillingRelationnalEntity extends BillingEntity
{
    /**
     * @var UserEntity
     */
    protected $user;

    /**
     * @var CompanyEntity
     */
    protected $company;

    public function __construct(?array $data = null)
    {
        parent::__construct($data);
    }

    /**
     * @return UserEntity
     */
    public function getUser(): UserEntity
    {
        return $this->user;
    }

    /**
     * @param UserEntity $user
     * @return BillingRelationnalEntity
     */
    public function setUser(UserEntity $user): BillingRelationnalEntity
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return CompanyEntity
     */
    public function getCompany(): CompanyEntity
    {
        return $this->company;
    }

    /**
     * @param CompanyEntity $company
     * @return BillingRelationnalEntity
     */
    public function setCompany(CompanyEntity $company): BillingRelationnalEntity
    {
        $this->company = $company;
        return $this;
    }

}