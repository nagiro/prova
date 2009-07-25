<?php

/**
 * Subclass for performing query and update operations on the 'agendaactivitats' table.
 *
 * 
 *
 * @package lib.model
 */ 
class AgendaactivitatsPeer extends BaseAgendaactivitatsPeer
{

  static public function selectCiutats()
  {
    $C = new Criteria();
    $C->addGroupByColumn( self::CIUTAT );
    $C->addAscendingOrderByColumn( self::CIUTAT );
    return self::doSelect($C);
  }
  
  static public function getActivitatsDies($text, $ciutat, $entitat , $dataI , $dataF , $idActivitat )
  {
    $ACTIVITATS = self::getActivitats(NULL, $text, $ciutat, $entitat , $dataI , $dataF , $idActivitat );
    
    $CALENDARI = array();
    foreach($ACTIVITATS as $ACTIVITAT):
      $data = explode("-",$ACTIVITAT->getDate());
      $CALENDARI[intval($data[0])][intval($data[1])][intval($data[2])] = $ACTIVITAT->getDate();               
    endforeach;
    
    return $CALENDARI; 
  }
  
  static public function getActivitats($dia, $text, $ciutat, $entitat, $dataI, $dataF , $idActivitat )
  {    
        
    $C = new Criteria();
    if( $dia  != NULL ) $C->add(self::DATE, $dia);
    else {
      $data1 = $C->getNewCriterion(self::DATE, $dataI , CRITERIA::GREATER_THAN);
      $data2 = $C->getNewCriterion(self::DATE, $dataF , CRITERIA::LESS_THAN);
      $data1->addAnd($data2);
      $C->add($data1);
    }
    
    foreach(explode(' ',$text) as $PARAULA):
      
      $PARAULA = trim($PARAULA);
    
      if( strlen($PARAULA) > 2 ) {
        $text1Criterion = $C->getNewCriterion(self::TITOL, '%'.$text.'%', CRITERIA::LIKE);
        $text2Criterion = $C->getNewCriterion(self::TEXT, '%'.$text.'%', CRITERIA::LIKE);
        $text3Criterion = $C->getNewCriterion(self::LLOC, '%'.$text.'%', CRITERIA::LIKE);
        $text1Criterion->addOr($text2Criterion);
        $text1Criterion->addOr($text3Criterion);
        $C->add($text1Criterion);
      }
    endforeach;
    
    if( $ciutat != NULL ) $C->add(self::CIUTAT, $ciutat);
    if( $entitat != NULL ) $C->add(CluberPeer::ENTITATS_ENTITATID, $entitat);
    if( $idActivitat != NULL ) $C->add(self::AGENDAACTIVITATSACTIVITATSID, $idActivitat, CRITERIA::EQUAL );
    
    $C->addAscendingOrderByColumn(CluberPeer::ENTITATS_ENTITATID);
    
    return self::doSelectJoinCluber($C);
  
  }
  

}
