<?php

namespace Billing\V1\Rest\Company;

use Billing\V1\Main\Mapper\GlobalMapper;
use Laminas\Paginator\Paginator;

class CompanyMapper
{
    protected $mapper;

    public function __construct(GlobalMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    public function fetchOne(int $id)
    {
        $entity = new CompanyEntity();
        $this->mapper->fetchOne($id, $entity);
        return $entity;

    }

    public function fetchAll(): Paginator
    {
        $entity = new CompanyEntity();
        return new CompanyCollection($this->mapper->getFetchAllAdapter($entity));

    }

    public function create(\stdClass $class)
    {
        //on passe par l'entity pour bénéficier des filtres des getters et setters
        $entity = new CompanyEntity(get_object_vars($class));
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