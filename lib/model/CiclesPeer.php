<?php

/**
 * Subclass for performing query and update operations on the 'cicles' table.
 *
 * 
 *
 * @package lib.model
 */ 
class CiclesPeer extends BaseCiclesPeer
{

  static public function getSelect()
  {
    
    $cicles = self::doSelect(new Criteria());
    $ret = array();
    foreach($cicles as $C)
    {
      $ret[$C->getCicleid()] = $C->getNom();
    }
    return $ret;
        
  }
  
}
