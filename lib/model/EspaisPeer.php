<?php

/**
 * Subclass for performing query and update operations on the 'espais' table.
 *
 * 
 *
 * @package lib.model
 */ 
class EspaisPeer extends BaseEspaisPeer
{

  static public function getCriteriaActiu($C,$idS)
  {
    $C->add(self::ACTIU, true);
    $C->add(self::SITE_ID, $idS);
    return $C;
  }

  static public function initialize( $idE , $idS )
  {
    $OE = self::retrieveByPK($idE);            
	if(!($OE instanceof Espais)):
		$OE = new Espais();   		                    
        $OE->setSiteId($idS);        
        $OE->setActiu(true);        		            			    			    			        					
	endif;    
    
    return new EspaisForm($OE,array('IDS'=>$idS)); 
  }

  static public function select( $idS , $with_new = false )
  {
  	$C = new Criteria();
    $C = self::getCriteriaActiu($C,$idS);
    
  	$C->addAscendingOrderByColumn(self::ORDRE);
  	
    $Espais = self::doSelect($C);
    $RET = array();
    $RET['0'] = 'Nou espai...';
    foreach($Espais as $E):
      $RET[$E->getEspaiid()] = $E->getNom();    
    endforeach;
    
    return $RET;    
      
  }
  
  static public function selectJavascript( $idS , $sel = -1 )
  {

  	$C = new Criteria();
    $C = self::getCriteriaActiu($C,$idS);
    
  	$C->addAscendingOrderByColumn(self::ORDRE);
  	
    $Espais = self::doSelect($C);
  	
    $RET = "";
    foreach($Espais as $E):
    	$idE = $E->getEspaiid();
    	if($sel == $idE): $RET .= '<OPTION SELECTED value="'.$idE.'">'.$E->getNom().'</OPTION>';
    	else: $RET .= '<OPTION value="'.$idE.'">'.$E->getNom().'</OPTION>';
    	endif;    
    endforeach;    
    
    $RET = str_replace("'","\'",$RET);    
    
    return $RET;    
  	
  }


  /**
   * Usat al formulari ClientReservesPeer
   * */  
  static public function selectFormReserva($idS)
  {
    $RET = array();
    $C = new Criteria();
    $C = self::getCriteriaActiu($C,$idS);
    $C->add(EspaisPeer::ISLLOGABLE, true);
    $C->addAscendingOrderByColumn(self::ORDRE);
    foreach(self::doSelect($C) as $E):
    
        $RET[$E->getEspaiid()] = $E->getNom();
    
//        if($E->getEspaiid() >= 1 && $E->getEspaiid() < 6) $RET[$E->getEspaiid()] = $E->getNom();
//        if($E->getEspaiid() >= 9 && $E->getEspaiid() < 16) $RET[$E->getEspaiid()] = $E->getNom();
//        if($E->getEspaiid() == 19) $RET[$E->getEspaiid()] = $E->getNom();          
    
    endforeach;
    return $RET;
  }

}
