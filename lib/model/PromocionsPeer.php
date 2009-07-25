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
  
  static function Reordena($Ordrei,$Ordref)
  {  
    
    $C = new Criteria();
    //Si fem un moviment amunt, haurem de desplaçar de final fins a inicial-1 amb un +1
    //Si fem un movimetn avall, haurem de desplaçar d'incial fins a final amb un -1
    if($Ordref < $Ordrei) $C->add(self::ORDRE, $Ordref, CRITERIA::GREATER_EQUAL); //Si volem fer un moviment cap enrrera, haurem de desplaçar tots fins a l'actual + 1
    else                  $C->add(self::ORDRE, $Ordrei, CRITERIA::GREATER_EQUAL); //Si anem endavant, haurem de desplaçar enrrara tots de i a f (+1) i a partir de f (-1)
                          $C->addAscendingOrderByColumn(self::ORDRE);
    foreach(self::doSelect($C) as $P)
    {
      if ($Ordref <  $Ordrei && $P->getOrdre() < $Ordrei){ 
          $P->setOrdre($P->getOrdre()+1);
          $P->save();  
      }
      elseif($Ordref >= $Ordrei && $P->getOrdre() <=  $Ordref)
      {       
          $P->setOrdre($P->getOrdre()-1);
          $P->save();
      }                                 
    }    
  }
 

}
