<?php

namespace Billing\V1\Main\Entity;

class GlobalEntity
{

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

    private function keyAsSetter(string $key): string
    {
        $array = explode('_', $key);
        array_map('strtolower', $array);
        array_map('ucfirst', $array);
        return 'set' . implode('', $array);
    }
}