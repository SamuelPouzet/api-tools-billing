<?php

namespace Billing\V1\Rest\Billing;

use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\Sql\Sql;
use Laminas\Paginator\Adapter\LaminasDb\DbSelect;


class BillingMapper
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
        $select->from('bill');
        $select->where(['id' => $id]);

        $selectString = $sql->buildSqlString($select);
        $results = $this->adapter->query($selectString, $this->adapter::QUERY_MODE_EXECUTE);

        if (!$results) {
            return false;
        }
        $data = $results->toArray();

        $entity = new BillingEntity();
        $entity->exchangeArray($data[0]);
        return $entity;

    }

    public function fetchAll()
    {
        // the select instance is needed for the collection's paginator
        $sql = new Sql($this->adapter);
        $select = $sql->select();
        $select->from('bill');

        $adapter = new DbSelect($select, $this->adapter);
        $collection = new BillingCollection($adapter);
        return $collection;
    }

    public function create(string $json): bool
    {

        try{
            $data = json_decode($json);
        }catch (\Exception $e){
            return false;
        }

        $entity = new BillingEntity($data);
        $sql = new Sql($this->adapter);
        $sql->insert();
        $sql->values( $entity->getArrayCopy() );

        return true;
    }

    public function delete(int $id): bool
    {
        $sql = new Sql($this->adapter);
        $delete = $sql->delete();
        $delete->from('bill');
        $delete->where(['id'=>$id]);

        $statement = $sql->prepareStatementForSqlObject($delete);
        $statement->execute();
        return true;
    }

}