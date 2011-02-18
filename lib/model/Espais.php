<?php

/**
 * Subclass for representing a row from the 'espais' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Espais extends BaseEspais
{
    public function __toString()
    {
        return $this->getNom();
    }
    
    public function getFotos()
    {
        return MultimediaPeer::getFotosEspais($this->getEspaiid(), $this->getSiteId());        
    }
    
}
