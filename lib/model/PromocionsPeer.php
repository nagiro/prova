<?php

/**
 * Subclass for performing query and update operations on the 'promocions' table.
 *
 * 
 *
 * @package lib.model
 */ 
class PromocionsPeer extends BasePromocionsPeer
{

  static function selectOrdre($NOU = false)
  {
     $RET = array();     
     foreach(self::getAllByOrdre() as $P) $RET[$P->getOrdre()] = $P->getOrdre();     
     if($NOU): $RET[sizeof($RET)+1] = sizeof($RET)+1; endif;
     return $RET;
  }
	
  static function retrieveByOrdre($ordre = 1)
  {
    $c = new Criteria;
    $c->add(self::ORDRE, $ordre);
    return self::doSelectOne($c); 
  }
   
  static function getAllByOrdre()
  {
    $c = new Criteria;
    $c->addAscendingOrderByColumn(self::ORDRE);
    return self::doSelect($c); 
  }
   
  static function getMaximOrdre()
  {
    $con = Propel::getConnection(self::DATABASE_NAME);
    $sql = 'SELECT MAX('.self::ORDRE.') AS max FROM '.self::TABLE_NAME; 
    $stmt = $con->prepareStatement($sql);
    $rs = $stmt->executeQuery();
   
    $rs->next();
    return $rs->getInt('max');
  }
  
  static function gestionaOrdre( $desti , $actual )
  {   
     foreach(self::getAllByOrdre() as $P):
        $Ordre = $P->getOrdre();     
	    if($actual == 0){ if($Ordre >= $desti) $P->setOrdre($Ordre+1); }            
	    elseif($actual < $desti) { if($Ordre > $actual && $Ordre <= $desti) $P->setOrdre($Ordre-1); } 
	    elseif($actual > $desti) { if($Ordre >= $desti && $Ordre < $actual) $P->setOrdre($Ordre+1); }	    
	    $P->save();     
     endforeach;
  }
  
  
  
}
