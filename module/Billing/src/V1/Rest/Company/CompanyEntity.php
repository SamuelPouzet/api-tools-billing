<?php
namespace Billing\V1\Rest\Company;

use Billing\V1\Main\Entity\EntityInterface;
use Billing\V1\Main\Entity\GlobalEntity;

class CompanyEntity extends GlobalEntity implements EntityInterface
{

    const TABLENAME = 'company';

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
     * @var string $name
     * Name of the company
     */
    protected $name;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return CompanyEntity
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return CompanyEntity
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

}
