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
    
    static public function getCriteriaActiu($C,$idS)
    {
        $C->add(self::ACTIU, true);
        $C->add(self::SITE_ID, $idS);
        return $C;
    }
    
    static public function initialize($idP , $idS )
    {
    	$OP = PromocionsPeer::retrieveByPK($idP);            
    	if(!($OP instanceof Promocions)):                		    	
    		$OP = new Promocions();
            $OP->setSiteId($idS);        
            $OP->setActiu(true);        			
    	endif; 
        
        return new PromocionsForm($OP,array('IDS'=>$idS));
    }

    static public function getAllPromocions($idS)
    {
        $C = new Criteria();
        $C = self::getCriteriaActiu($C,$idS);
        $C->addAscendingOrderByColumn(PromocionsPeer::ORDRE);        
        return self::doSelect($C);        
    }

  static function selectOrdre( $idS , $NOU = false )
  {     
     $RET = array();
     $C = new Criteria();
     $C = self::getCriteriaActiu( $C , $idS );
     $TOP = self::doCount($C);
     
     for($i = 1; $i <= $TOP+1; $i++) $RET[$i] = $i;
     
     return $RET;            
  }
	
  static function retrieveByOrdre($idS , $ordre = 1)
  {
    $c = new Criteria;
    $C = self::getCriteriaActiu($C,$idS);
    $c->add(self::ORDRE, $ordre);    
    return self::doSelectOne($c); 
  }
   
  static function getAllByOrdre($idS)
  {
    $C = new Criteria;
    $C = self::getCriteriaActiu($C,$idS);
    $C->addAscendingOrderByColumn(self::ORDRE);
    return self::doSelect($C); 
  }
   
  static function getMaximOrdre($idS)
  {
    $con = Propel::getConnection(self::DATABASE_NAME);
    $sql = 'SELECT MAX('.self::ORDRE.') AS max FROM '.self::TABLE_NAME.' where site_id = '.$idS.' AND actiu = 1'; 
    $stmt = $con->prepareStatement($sql);
    $rs = $stmt->executeQuery();
   
    $rs->next();
    return $rs->getInt('max');
  }
  
  static function gestionaOrdre( $desti , $actual , $idS )
  {    
     foreach(self::getAllByOrdre($idS) as $P):
        $Ordre = $P->getOrdre();     
	    if($actual == 0){ if($Ordre >= $desti) $P->setOrdre($Ordre+1); }            
	    elseif($actual < $desti) { if($Ordre > $actual && $Ordre <= $desti) $P->setOrdre($Ordre-1); } 
	    elseif($actual > $desti) { if($Ordre >= $desti && $Ordre < $actual) $P->setOrdre($Ordre+1); }	    
	    $P->save();     
     endforeach;
  }
  
  
  
}
