<?php

namespace App\Model;

class Model
{
    public function hydrate(array $data)
    {
        foreach ($data as $key => $value) {
            $method = 'set' . $key;

            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }
}
