<?php

/**
 * Subclass for performing query and update operations on the 'entitats' table.
 *
 * 
 *
 * @package lib.model
 */ 
class EntitatsPeer extends BaseEntitatsPeer
{

  static public function selectEntitats()
  {    
    $C = new Criteria();
    $C->add(self::HABILITAT, 1, CRITERIA::EQUAL);
    $C->addAscendingOrderByColumn( self::NOM );
    return self::doSelect($C);
  }
  
}
