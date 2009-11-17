<?php

/**
 * Subclass for representing a row from the 'matricules' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Matricules extends BaseMatricules
{

  static function Check($new)
  {
    $E = array();    
    return $E;    
  }    
  
  public function getTreduccioString()
  {  
  	return TipusPeer::retrieveByPK($this->getTreduccio())->getTipusdesc();  	
  }
  
  public function getEstatString()
  {  
  	return TipusPeer::retrieveByPK($this->getEstat())->getTipusdesc();  	
  }
 

}
