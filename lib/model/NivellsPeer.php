<?php

/**
 * Subclass for performing query and update operations on the 'nivells' table.
 *
 * 
 *
 * @package lib.model
 */ 
class NivellsPeer extends BaseNivellsPeer
{

  const CAP = 6;
  const ANTICSMATRICULATS = 5;
  const CONSULTA = 4; 
  const EDICIO = 3; 
  const REGISTRAT = 2; 
  const ADMIN = 1;
	
  static function getSelect()
  {
    
    $nivells = self::doSelect(new Criteria());
    $ret = array();
    foreach($nivells as $N)
    {
      $ret[$N->getIdnivells()] = $N->getNom();
    }
    return $ret;
        
  }

}
