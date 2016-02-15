<?php

namespace Core\Orm;

Class Table {

    public function setSlug(){
        return $this->username.".".$this->id;
    }

}
