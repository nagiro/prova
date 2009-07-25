<?php

/**
 * Subclass for performing query and update operations on the 'agendatelefonicadades' table.
 *
 * 
 *
 * @package lib.model
 */ 
class AgendatelefonicadadesPeer extends BaseAgendatelefonicadadesPeer
{    
   
  static function doSearch( $TEXT )
  {
    
     $C = new Criteria();
     $PARAULES = explode(" ",$TEXT); $PAR2 = array();
     foreach( $PARAULES as $P ) if( strlen( $P ) > 2 ): $PAR2[] = trim($P); endif;                      
     
     foreach( $PAR2 as $P ):
      
//      $text1Criterion = $C->getNewCriterion( AgendatelefonicadadesPeer::DADA , '%'.$P.'%', CRITERIA::LIKE);
      $text1Criterion = $C->getNewCriterion( AgendatelefonicaPeer::NOM , '%'.$P.'%', CRITERIA::LIKE);
      $text2Criterion = $C->getNewCriterion( AgendatelefonicaPeer::TAGS , '%'.$P.'%', CRITERIA::LIKE);
      $text3Criterion = $C->getNewCriterion( AgendatelefonicaPeer::ENTITAT , '%'.$P.'%', CRITERIA::LIKE);
      $text1Criterion->addOr($text2Criterion); $text1Criterion->addOr($text3Criterion);  $C->add($text1Criterion);          
     endforeach;
     
     $C->addGroupByColumn( AgendatelefonicaPeer::AGENDATELEFONICAID );
     $C->setLimit(30);
     $ATD = AgendatelefonicaPeer::doSelect($C);
     
     return $ATD; 
  
  }
    
  static function select(  )
  {
    
     return array(
       	1=>'Telèfon',
  		2=>'Adreça',  
  		3=>'Compte corrent',
  		4=>'Fax',
  		5=>'Email',
  		6=>'Ciutat',
  		7=>'Codi Postal');
  
  }
  
  static function getTipus($idTipus)
  {
  	switch($idTipus){
  		case 1: return 'Telèfon'; break;
  		case 2: return 'Adreça'; break;  
  		case 3: return 'Compte corrent'; break;
  		case 4: return 'Fax'; break;
  		case 5: return 'Email'; break;
  		case 6: return 'Ciutat'; break;
  		case 7: return 'Codi Postal'; break;		
  	}
  }

}
