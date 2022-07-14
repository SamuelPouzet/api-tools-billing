<?php

namespace Billing\V1\Main\Mapper;

use Billing\V1\Main\Entity\EntityInterface;
use Billing\V1\Main\Traits\NamingTrait;
use Billing\V1\Rest\Billing\BillingCollection;
use Billing\V1\Rest\Billing\BillingEntity;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\Sql\Sql;
use Laminas\Paginator\Adapter\LaminasDb\DbSelect;
use Laminas\Paginator\Paginator;

class GlobalMapper
{

    use NamingTrait;

    /**
     * @var AdapterInterface
     */
    protected $adapter;

    /**
     * @var array|null
     */
    protected $relationalConfig;

    public function __construct(AdapterInterface $adapter, ?array $relationalConfig)
    {
        $this->relationalConfig = $relationalConfig;
        $this->adapter = $adapter;
    }

    public function fetchOne(int $id, EntityInterface $entity): ?EntityInterface
    {
        $sql = new Sql($this->adapter);
        $select = $sql->select();
        $select->from( $entity::TABLENAME );
        $select->where(['id' => $id]);

        $selectString = $sql->buildSqlString($select);
        $results = $this->adapter->query($selectString, $this->adapter::QUERY_MODE_EXECUTE);

        if (!$results) {
            return null;
        }
        $data = $results->toArray();

        if (!isset($data[0])) {
            return null;
        }
        $entity->exchangeArray($data[0]);
        $this->getRelations($entity);
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

    public function FetchAll( EntityInterface $entity ): array
    {
        // the select instance is needed for the collection's paginator
        $sql = new Sql($this->adapter);
        $select = $sql->select();
        $select->from($entity::TABLENAME);

        $selectString = $sql->buildSqlString($select);
        $results = $this->adapter->query($selectString, $this->adapter::QUERY_MODE_EXECUTE);

        if (!$results) {
            return [];
        }
        $data = $results->toArray();

        $elementsList = [];

        foreach ($data as $row) {
            $entityToReturn = clone $entity;
            $entityToReturn->exchangeArray($row);
            $this->getRelations($entityToReturn);
            $elementsList[] = $entityToReturn;
        }

        return $elementsList;
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

        // on sette les relations pour s'assurer qu'elle existent bien.
        $this->getRelations($entityToUpdate);

        $sql = new Sql($this->adapter);

        $update = $sql->update();
        $update->table($entityToUpdate::TABLENAME);
        $update->set($this->removeRelationsFromArrayCopy( $entityToUpdate->getArrayCopy(), $entityToUpdate ) );
        $update->where(['id' => $entityToUpdate->getId()]);

        $statement = $sql->prepareStatementForSqlObject($update);
        $statement->execute();
        return true;
    }

    private function removeRelationsFromArrayCopy(array $arrayCopy, EntityInterface $entity): array
    {
        if(!$this->relationalConfig){
            //On n'a pas de relations de configurées, rien à changer donc, ou alors config foireuse
            return $arrayCopy;
        }

        foreach ($this->relationalConfig as $relationType => $relationsList){
            if(! isset($relationsList[get_class($entity)]) || empty($relationsList[get_class($entity)])){
                continue;
            }
            foreach ($relationsList[get_class($entity)] as $key=>$config){

               //on se moque de la config, on a ici une jointure qui n'a pas vocation à être persistée
                 if(isset($arrayCopy[$key])){
                     unset($arrayCopy[$key]);
                 }
            }
        }

        return $arrayCopy;

    }

    private function getRelations(EntityInterface $entity): void
    {
        if(!$this->relationalConfig){
            return;
        }

        foreach ($this->relationalConfig as $relationType => $relationsList){
            $method = 'set' . ucfirst($relationType);

            if(method_exists($this, $method)){
                if(! isset($relationsList[get_class($entity)]) || empty($relationsList[get_class($entity)])){
                    continue;
                }
                $this->$method($relationsList[get_class($entity)], $entity);
            }else{
                throw new \Exception(sprintf('relation %s doesn\'t exists', $relationType));
            }

        }
    }

    protected function setOneToOne(array $relationsList, EntityInterface $entity): void
    {
        foreach ($relationsList as $key => $relation){
            $method = $this->keyAsSetter($key);
            if(method_exists($entity, $method)){
                if(!isset($relation['relatedClass'])){
                    throw new \Exception('relatedClass is mandatory in config');
                }elseif(! class_exists($relation['relatedClass'])){
                    throw new \Exception(sprintf('class %c doesn\'t exists', $relation['relatedClass']) );
                }
                if(!isset($relation['id'])){
                    throw new \Exception('id is mandatory in config');
                }

                $relatedEntity =  new $relation['relatedClass'];
                $getMethod = $this->keyAsGetter($relation['id']);
                if(method_exists($entity, $getMethod)){
                    $foreignKey = $entity->$getMethod();
                    if(!$foreignKey){
                        throw new \Exception('trying to relate with no key');
                    }
                }

                if(! $this->fetchOne($foreignKey, $relatedEntity) ){
                    throw new \Exception('Trying to relate to an unexisting entity');
                }
                $entity->$method($relatedEntity);
            }
        }

    }

    protected function setManyToOne(array $relationsList, EntityInterface $entity)
    {
        $this->setOneToOne($relationsList, $entity);
    }

    protected function setOneToMany()
    {

    }

    protected function setManyToMany()
    {

    }
}