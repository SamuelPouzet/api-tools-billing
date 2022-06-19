<?php

namespace Billing\V1\Main\Mapper;

use Billing\V1\Main\Entity\EntityInterface;
use Billing\V1\Rest\Billing\BillingCollection;
use Billing\V1\Rest\Billing\BillingEntity;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\Sql\Sql;
use Laminas\Paginator\Adapter\LaminasDb\DbSelect;
use Laminas\Paginator\Paginator;

class GlobalMapper
{

    protected $adapter;

    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    public function fetchOne(int $id, EntityInterface $entity)
    {
        $sql = new Sql($this->adapter);
        $select = $sql->select();
        $select->from( $entity::TABLENAME );
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
        $entity->exchangeArray($data[0]);
        return $entity;

    }

    public function getFetchAllAdapter( EntityInterface $entity): DbSelect
    {
        // the select instance is needed for the collection's paginator
        $sql = new Sql($this->adapter);
        $select = $sql->select();
        $select->from($entity::TABLENAME);

        return new DbSelect($select, $this->adapter);
    }

    public function create(EntityInterface $entity)
    {
        $sql = new Sql($this->adapter);
        $insert = $sql->insert();
        $insert->into($entity::TABLENAME);
        $insert->values($entity->getArrayCopy());

        $statement = $sql->prepareStatementForSqlObject($insert);
        $statement->execute();

        return $entity;
    }

    public function delete(EntityInterface $entity)
    {
        $sql = new Sql($this->adapter);
        $delete = $sql->delete();
        $delete->from($entity::TABLENAME);
        $delete->where(['id' => $entity->getId() ]);

        $statement = $sql->prepareStatementForSqlObject($delete);
        $statement->execute();
        return true;
    }

    public function update(EntityInterface $entityToUpdate, \stdClass $class): bool
    {

        if (!$entityToUpdate) {
            return false;
        }

        //on checke via les mêmes filtres, l'intégrité des données qu'on a reçues
        $entityToUpdate->exchangeArray(get_object_vars($class));

        $sql = new Sql($this->adapter);

        $update = $sql->update();
        $update->table($entityToUpdate::TABLENAME);
        $update->set($entityToUpdate->getArrayCopy());
        $update->where(['id' => $entityToUpdate->getId()]);

        $statement = $sql->prepareStatementForSqlObject($update);
        $statement->execute();
        return true;
    }

}