<?php

namespace App\Repository;

class RealStateRepository extends AbstractRepository
{   
    private $location = [];

    public function setLocation(array $data): self
    {
        $this->location = $data;
    
        return $this;
    } 
   
   /**
    * Method getResult
    *
    * @return object
    */
    public function getResult(): object
    {
        $location = $this->location;

        return $this->model->whereHas('address', function ($q) use($location) {
           
            $q->where('state_id', $location['state'])->where('city_id', $location['city']);
        });
    }
}