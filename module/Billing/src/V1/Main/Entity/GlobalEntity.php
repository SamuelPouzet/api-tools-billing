<?php

namespace Billing\V1\Main\Entity;

use Billing\V1\Main\Traits\NamingTrait;

class GlobalEntity
{
    use NamingTrait;

    public function __construct(?array $data = null)
    {
        if($data){
            $this->exchangeArray($data);
        }
    }

    /**
     * @return array
     */
    public function getArrayCopy(): array
    {
        return get_object_vars($this);
    }

    /**
     * @param array $data
     * @return void
     */
    public function exchangeArray(array $data): void
    {
        foreach ($data as $key=>$value){
            $method = $this->keyAsSetter($key);
            if(method_exists($this, $method)){
                $this->$method($value);
            }
        }

    }

}