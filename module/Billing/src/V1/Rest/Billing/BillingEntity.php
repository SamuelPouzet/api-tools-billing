<?php
namespace Billing\V1\Rest\Billing;

use Billing\V1\Main\Entity\EntityInterface;
use Billing\V1\Main\Entity\GlobalEntity;

class BillingEntity extends GlobalEntity implements EntityInterface
{

    const TABLENAME = 'bill';

    public function getTableName()
    {
        return self::TABLENAME;
    }

    /**
     * @var int $id
     * Primary key
     */
    protected $id;

    /**
     * @var int $user_id
     * Id of the user who has created the bill
     */
    protected $user_id;

    /**
     * @var string $date_bill
     * Date when the bill occurs
     */
    protected $date_bill;

    /**
     * @var int $amount
     * Amount of the bill
     */
    protected $amount;

    /**
     * @var int $currency
     * Currency of the bill
     * With PHP8.1 replace by an enum
     */
    protected $currency;

    /**
     * @var int $type
     * Currency of the bill
     * With PHP8.1 replace by an enum
     */
    protected $type;

    /**
     * @var string $date_create
     * Date when the bill was created
     */
    protected $date_create;

    /**
     * @varint $company_id
     * Id of the company who needs to pay
     */
    protected $company_id;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return self
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @param int $user_id
     * @return self
     */
    public function setUserId(int $user_id): self
    {
        $this->user_id = $user_id;
        return $this;
    }

    /**
     * @return string
     */
    public function getDateBill(): string
    {
        return $this->date_bill;
    }

    /**
     * @param string $date_bill
     * @return self
     */
    public function setDateBill(string $date_bill): self
    {
        $this->date_bill = $date_bill;
        return $this;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     * @return self
     */
    public function setAmount(int $amount): self
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return int
     */
    public function getCurrency(): int
    {
        return $this->currency;
    }

    /**
     * @param int $currency
     * @return self
     */
    public function setCurrency(int $currency): self
    {
        $this->currency = $currency;
        return $this;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @param int $type
     * @return self
     */
    public function setType(int $type): self
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getDateCreate(): string
    {
        return $this->date_create;
    }

    /**
     * @param string $date_create
     * @return self
     */
    public function setDateCreate(string $date_create): self
    {
        $this->date_create = $date_create;
        return $this;
    }

    /**
     * @return int
     */
    public function getCompanyId(): int
    {
        return $this->company_id;
    }

    /**
     * @param int $company_id
     * @return self
     */
    public function setCompanyId(int $company_id): self
    {
        $this->company_id = $company_id;
        return $this;
    }

}

