<?php

/**
 * Subclass for performing query and update operations on the 'incidencies' table.
 *
 * 
 *
 * @package lib.model
 */ 
class IncidenciesPeer extends BaseIncidenciesPeer
{
   
   const ESTAT_ESPERA = 10;
   const ESTAT_TREBALLANTHI = 20;
   const ESTAT_RESOLT = 30;

  static private function getCriteriaActive($idS)
  {
    $C = new Criteria();
    $C->add(self::SITE_ID, $idS);
    $C->add(self::ACTIU , true);
    return $C;  
  }     
   
    static public function initialize( $idI , $idU , $idS )
    {
    	$OI = self::retrieveByPK($idI);            
    	if($OI instanceof Incidencies):            
    		return new IncidenciesForm($OI);
    	else:
    		$OI = new Incidencies();
    		$OI->setDataalta(time());
    		$OI->setQuiinforma($idU);       
            $OI->setActiu(true);
            $OI->setSiteId($idS);     
    		return new IncidenciesForm($OI,array('IDS'=>$idS));			
    	endif; 
    }
   
   
  static public function QuantesAvui($idS)
  {
     $C = self::getCriteriaActive($idS);     
     $time = mktime(null,null,null,date('m'),date('d')-1,date('Y'));
     $C->add(self::DATAALTA , $time , Criteria::GREATER_EQUAL );     
     return self::doCount($C);
  }
   
  static public function getIncidencies($CERCA = "" , $PAGINA = 1 , $idS )
  {
     
      $C = self::getCriteriaActive($idS);      
      $C1 = $C->getNewCriterion(self::TITOL , '%'.$CERCA.'%' , Criteria::LIKE);
      $C2 = $C->getNewCriterion(self::DESCRIPCIO , '%'.$CERCA.'%' , Criteria::LIKE);
      $C1->addOr($C2); $C->add($C1);
      $C->addDescendingOrderByColumn(self::ESTAT);    
   
      $pager = new sfPropelPager('Incidencies', 10);
      $pager->setCriteria($C);
      $pager->setPage($PAGINA);
      $pager->init();  	
      return $pager;
      
  }
  
  static public function getEstatSelect()
  {
     return array( self::ESTAT_ESPERA => 'En espera' , self::ESTAT_TREBALLANTHI => 'Treballant-hi' , self::ESTAT_RESOLT => 'Resolt' );
  }
  
  /**
   * Guardem el registre si Idi és 0 llavors el registre és nou
   *
   * @param unknown_type $D
   * @param unknown_type $IDI
   */
/*  static public function save($D, $IDI = 0)
  {
     $I = new Incidencies();
     if($IDI == 0) $I->setNew(true); else { $I = IncidenciesPeer::retrieveByPK($IDI); $I->setNew(false); }
     
     $I->setQuiinforma($D['QUIINFORMA']);
     $I->setQuiresol($D['QUIRESOL']);
     $I->setTitol($D['TITOL']);
     $I->setDescripcio($D['DESCRIPCIO']);
     $I->setEstat($D['ESTAT']);
     if($IDI == 0) $I->setDataalta(date('Y-m-d',time()));
     if($D['ESTAT'] == IncidenciesPeer::ESTAT_RESOLT)  $I->setDataresolucio(date('Y-m-d',time()));     
     $I->save();
     return $I;        
     
  }
*/    
}
