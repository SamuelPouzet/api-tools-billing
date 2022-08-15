<?php

namespace Billing\V1\Rest\Billing;

use Billing\V1\Main\Exception\NoDataException;
use Laminas\ApiTools\ApiProblem\ApiProblem;
use Laminas\ApiTools\Rest\AbstractResourceListener;
use Laminas\Stdlib\Parameters;

/**
 *
 */
class BillingResource extends AbstractResourceListener
{

    /**
     * @var
     */
    protected $mapper;

    /**
     * @param $mapper
     */
    public function __construct($mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * Create a resource
     *
     * @param mixed $data
     * @return ApiProblem|mixed
     */
    public function create($data)
    {
        return $this->mapper->create($data);
    }

    /**
     * Delete a resource
     *
     * @param mixed $id
     * @return ApiProblem|mixed
     */
    public function delete($id)
    {
        return $this->mapper->delete($id);
    }

    /**
     * Delete a collection, or members of a collection
     *
     * @param mixed $data
     * @return ApiProblem|mixed
     */
    public function deleteList($data)
    {
        return new ApiProblem(405, 'The DELETE method has not been defined for collections');
    }

    /**
     * Fetch a resource
     *
     * @param mixed $id
     * @return ApiProblem|mixed
     */
    public function fetch($id)
    {
        try {
            return $this->mapper->fetchOne($id);
        } catch (NoDataException $e) {
            $return = [
                'status' => 'Not Found',
                'statusCode' => 0
            ];

            return json_encode($return);
        } catch (\Exception $e) {
            return json_encode($e);
        }

    }

    /**
     * Fetch all or a subset of resources
     *
     * @param array|Parameters $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = [])
    {
        return $this->mapper->fetchAll();
    }

    /**
     * Patch (partial in-place update) a resource
     *
     * @param mixed $id
     * @param mixed $data
     * @return ApiProblem|mixed
     */
    public function patch($id, $data)
    {
        return new ApiProblem(405, 'The PATCH method has not been defined for individual resources');
    }

    /**
     * Patch (partial in-place update) a collection or members of a collection
     *
     * @param mixed $data
     * @return ApiProblem|mixed
     */
    public function patchList($data)
    {
        return new ApiProblem(405, 'The PATCH method has not been defined for collections');
    }

    /**
     * Replace a collection or members of a collection
     *
     * @param mixed $data
     * @return ApiProblem|mixed
     */
    public function replaceList($data)
    {
        return new ApiProblem(405, 'The PUT method has not been defined for collections');
    }

    /**
     * Update a resource
     *
     * @param mixed $id
     * @param mixed $data
     * @return ApiProblem|mixed
     */
    public function update($id, $data)
    {
        return $this->mapper->update($id, $data);;
    }

}
