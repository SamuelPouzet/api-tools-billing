<?php

namespace Billing\V1\Rest\Billing;

use Billing\V1\Main\Entity\EntityInterface;
use Billing\V1\Main\Mapper\GlobalMapper;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Paginator\Paginator;


/**
 *
 */
class BillingMapper
{

    /**
     * @var GlobalMapper
     */
    protected $mapper;

    /**
     * @param GlobalMapper $mapper
     */
    public function __construct(GlobalMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * @param int $id
     * @return BillingRelationnalEntity
     * @throws \Exception
     */
    public function fetchOne(int $id)
    {
        $entity = new BillingRelationnalEntity();
        $this->mapper->fetchOne($id, $entity);
        return $entity;

    }

    /**
     * @return array
     * @throws \Exception
     */
    public function fetchAll(): array
    {
        $entity = new BillingRelationnalEntity();
        return $this->mapper->FetchAll($entity);

    }

    /**
     * @param \stdClass $class
     * @return EntityInterface
     */
    public function create(\stdClass $class)
    {
        //on passe par l'entity pour bénéficier des filtres des getters et setters
        $entity = new BillingEntity(get_object_vars($class));
        return $this->mapper->create($entity);
    }

    /**
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public function delete(int $id)
    {
        $entity = $this->fetchOne($id);
        return $this->mapper->delete($entity);
    }

    /**
     * @param int $id
     * @param \stdClass $class
     * @return bool
     * @throws \Exception
     */
    public function update(int $id, \stdClass $class)
    {
        $entity = $this->fetchOne($id);
        return $this->mapper->update($entity, $class);
    }

}