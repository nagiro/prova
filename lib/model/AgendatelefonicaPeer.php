<?php

/**
 * Subclass for performing query and update operations on the 'agendatelefonica' table.
 *
 * 
 *
 * @package lib.model
 */ 
class AgendatelefonicaPeer extends BaseAgendatelefonicaPeer
{
   
  static public function getCriteriaActiu($C,$IDS)
  {
    $C->add(self::ACTIU, true);
    $C->add(self::SITE_ID,$IDS);
    return $C;
  }
   
  static function getLinies($idS)
  {
     $C = new Criteria();
     $C = self::getCriteriaActiu($C,$idS);
     
     return self::doCount($C);
  }
  
  static function initialize( $id = 0 , $idS = 1)
  {
    $C = new Criteria();
    $C->add(self::AGENDATELEFONICAID, $id);
    $C->add(self::SITE_ID, $idS);
    
    $OA = self::doSelectOne($C);
    
    if($OA instanceof Agendatelefonica):
        return new AgendatelefonicaForm($OA);
    else: 
        $OA = new Agendatelefonica();
        $OA->setSiteId($idS);
        $OA->setActiu(true);
        return new AgendatelefonicaForm($OA);
    endif; 
    
  }
   
}