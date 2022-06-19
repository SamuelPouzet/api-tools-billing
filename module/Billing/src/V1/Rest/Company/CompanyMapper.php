<?php

namespace Billing\V1\Rest\Company;

use Billing\V1\Rest\Billing\BillingCollection;
use Billing\V1\Rest\Billing\BillingEntity;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\Sql\Sql;
use Laminas\Paginator\Adapter\LaminasDb\DbSelect;

class CompanyMapper
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
        $select->from('company');
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
        $entity = new CompanyEntity();
        $entity->exchangeArray($data[0]);
        return $entity;

    }

    public function fetchAll()
    {
        // the select instance is needed for the collection's paginator
        $sql = new Sql($this->adapter);
        $select = $sql->select();
        $select->from('company');

        $adapter = new DbSelect($select, $this->adapter);
        $collection = new CompanyCollection($adapter);
        return $collection;
    }
}