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


  static public function select()
  {
  	$C = new Criteria();
  	$C->addAscendingOrderByColumn(self::ORDRE);
  	
    $Espais = self::doSelect($C);
    $RET = array();
    foreach($Espais as $E):
      $RET[$E->getEspaiid()] = $E->getNom();    
    endforeach;
    
    return $RET;    
      
  }
  
  static public function selectJavascript($sel = -1)
  {

  	$C = new Criteria();
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
  
  static public function selectFormReserva()
  {
    $RET = array();
    $C = new Criteria();
    $C->addAscendingOrderByColumn(self::ORDRE);
    foreach(self::doSelect($C) as $E):
    
        if($E->getEspaiid() >= 1 && $E->getEspaiid() < 6) $RET[$E->getEspaiid()] = $E->getNom();
        if($E->getEspaiid() >= 9 && $E->getEspaiid() < 16) $RET[$E->getEspaiid()] = $E->getNom();
        if($E->getEspaiid() == 19) $RET[$E->getEspaiid()] = $E->getNom();          
    
    endforeach;
    return $RET;
  }

}
