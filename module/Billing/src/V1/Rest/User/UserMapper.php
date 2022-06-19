<?php

namespace Billing\V1\Rest\User;

use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\Sql\Sql;
use Laminas\Paginator\Adapter\LaminasDb\DbSelect;

class UserMapper
{

    protected $adapter;

    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    public function fetchOne(int $id)
    {
        $sql = new Sql($this->adapter);
        $select = $sql->select();
        $select->from('user');
        $select->where(['id' => $id]);

        $selectString = $sql->buildSqlString($select);
        $results = $this->adapter->query($selectString, $this->adapter::QUERY_MODE_EXECUTE);

        if (!$results) {
            return false;
        }
        $data = $results->toArray();

        if (!isset($data[0])) {
            return false;
        }
        $entity = new UserEntity();
        $entity->exchangeArray($data[0]);
        return $entity;

    }

    public function fetchAll()
    {
        // the select instance is needed for the collection's paginator
        $sql = new Sql($this->adapter);
        $select = $sql->select();
        $select->from('user');

        $adapter = new DbSelect($select, $this->adapter);
        $collection = new UserCollection($adapter);
        return $collection;
    }

    public function create(\stdClass $class): bool
    {

        //on passe par l'entity pour bénéficier des filtres des getters et setters
        $entity = new UserEntity(get_object_vars($class));
        $sql = new Sql($this->adapter);
        $insert = $sql->insert();
        $insert->into('user');
        $insert->values($entity->getArrayCopy());

        $statement = $sql->prepareStatementForSqlObject($insert);
        $statement->execute();
        return true;
    }

    public function update(int $id, \stdClass $class): bool
    {

        //on passe par l'entity pour bénéficier des filtres des getters et setters
        $entityToUpdate = $this->fetchOne($id);
        if (!$entityToUpdate) {
            return false;
        }

        //on checke via les mêmes filtres, l'intégrité des données qu'on a reçues
        $entityToUpdate->exchangeArray(get_object_vars($class));

        $sql = new Sql($this->adapter);

        $update = $sql->update();
        $update->table('user');
        $update->set($entityToUpdate->getArrayCopy());
        $update->where(['id' => $entityToUpdate->getId()]);

        $statement = $sql->prepareStatementForSqlObject($update);
        $statement->execute();
        return true;
    }

}