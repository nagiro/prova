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
  
  static public function getCiclesActius(Criteria $C = null)
  {  	
  	if(is_null($C)) $C = new Criteria();
  	$C->add(self::BAIXA,0);
  	return self::doSelect($C);
  }
  
  static public function initialize($idC)
  {
  	$OC = self::retrieveByPK($idC);
  	if($OC instanceof Cicles):
  		return new CiclesForm($OC);
  	else: 
  		$OC = new Cicles();
  		return new CiclesForm($OC);
  	endif; 
  	
  }
  
}
