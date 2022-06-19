<?php

namespace Billing\V1\Rest\User;

use Billing\V1\Main\Entity\EntityInterface;
use Billing\V1\Main\Mapper\GlobalMapper;
use Laminas\Paginator\Paginator;

/**
 *
 */
class UserMapper
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
     * @return UserEntity
     */
    public function fetchOne(int $id): UserEntity
    {
        $entity = new UserEntity();
        $this->mapper->fetchOne($id, $entity);
        return $entity;

    }

    /**
     * @return UserCollection
     */
    public function fetchAll(): UserCollection
    {
        $entity = new UserEntity();
        return new UserCollection($this->mapper->getFetchAllAdapter($entity));

    }

    /**
     * @param \stdClass $class
     * @return \Billing\V1\Main\Entity\EntityInterface
     */
    public function create(\stdClass $class): EntityInterface
    {
        //on passe par l'entity pour bénéficier des filtres des getters et setters
        $entity = new UserEntity(get_object_vars($class));
        return $this->mapper->create($entity);
    }

    /**
     * @param int $id
     * @return bool
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
     */
    public function update(int $id, \stdClass $class)
    {
        $entity = $this->fetchOne($id);
        return $this->mapper->update($entity, $class);
    }


}