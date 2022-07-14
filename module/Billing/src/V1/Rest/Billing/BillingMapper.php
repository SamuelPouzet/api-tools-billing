<?php

namespace Billing\V1\Rest\Billing;

use Billing\V1\Main\Entity\EntityInterface;
use Billing\V1\Main\Mapper\GlobalMapper;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Paginator\Paginator;


class BillingMapper
{

    protected $mapper;

    public function __construct(GlobalMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    public function fetchOne(int $id)
    {
        $entity = new BillingRelationnalEntity();
        $this->mapper->fetchOne($id, $entity);
        return $entity;

    }

    public function fetchAll(): array
    {
        $entity = new BillingRelationnalEntity();
        return $this->mapper->FetchAll($entity);

    }

    public function create(\stdClass $class)
    {
        //on passe par l'entity pour bénéficier des filtres des getters et setters
        $entity = new BillingEntity(get_object_vars($class));
        return $this->mapper->create($entity);
    }

    public function delete(int $id)
    {
        $entity = $this->fetchOne($id);
        return $this->mapper->delete($entity);
    }

    public function update(int $id, \stdClass $class)
    {
        $entity = $this->fetchOne($id);
        return $this->mapper->update($entity, $class);
    }

}