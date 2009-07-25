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
