<?php

/**
 * Subclass for performing query and update operations on the 'missatges' table.
 *
 * 
 *
 * @package lib.model
 */ 
class MissatgesPeer extends BaseMissatgesPeer
{

  static function QuantsAvui($idU)
  {
     $C = new Criteria();
     $time = mktime(null,null,null,date('m'),date('d')-1,date('Y'));
     $C->add(self::ALTAREGISTRE , $time , Criteria::GREATER_EQUAL );
     $C->add(self::USUARIS_USUARIID , $idU);
     return self::doCount($C);
  }
   
  static function doSearch( $TEXT )
  {
    
     $C = new Criteria();
     $PARAULES = explode(" ",$TEXT); $PAR2 = array();
     foreach( $PARAULES as $P ) if( strlen( $P ) > 2 ): $PAR2[] = trim($P); endif;                      
     
     foreach( $PAR2 as $P ):
      
      $text1Criterion = $C->getNewCriterion( MissatgesPeer::TITOL , '%'.$P.'%', CRITERIA::LIKE);
      $text2Criterion = $C->getNewCriterion( MissatgesPeer::TEXT , '%'.$P.'%', CRITERIA::LIKE);
      $text1Criterion->addOr($text2Criterion);  $C->add($text1Criterion);          
     endforeach;
     
     $C->addGroupByColumn( MissatgesPeer::MISSATGEID );
     $C->setLimit(20);
     $C->addDescendingOrderByColumn(self::DATE);
     $ATD = MissatgesPeer::doSelect($C);
     
     return $ATD; 
  
  }
  
  static function getMissatgesAvui()
  {
      $C = new Criteria();
      $avui = date('Y-m-d',time()); 
      $C->add( self::PUBLICACIO , $avui );
      $C->addDescendingOrderByColumn(self::MISSATGEID);
      return MissatgesPeer::doSelect($C);
  }
    

}
