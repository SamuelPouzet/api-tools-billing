<?php

namespace Billing\V1\Rest\Company;

use Billing\V1\Main\Mapper\GlobalMapper;
use Laminas\Paginator\Paginator;

/**
 *  class CompanyMapper
 */
class CompanyMapper
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
     * @return CompanyEntity
     * @throws \Exception
     */
    public function fetchOne(int $id)
    {
        $entity = new CompanyEntity();
        $this->mapper->fetchOne($id, $entity);
        return $entity;

    }

    /**
     * @return Paginator
     */
    public function fetchAll(): Paginator
    {
        $entity = new CompanyEntity();
        return new CompanyCollection($this->mapper->getFetchAllAdapter($entity));

    }

    /**
     * @param \stdClass $class
     * @return \Billing\V1\Main\Entity\EntityInterface
     */
    public function create(\stdClass $class)
    {
        //on passe par l'entity pour bénéficier des filtres des getters et setters
        $entity = new CompanyEntity(get_object_vars($class));
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