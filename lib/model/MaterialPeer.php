<?php

/**
 * Subclass for performing query and update operations on the 'material' table.
 *
 * 
 *
 * @package lib.model
 */ 
class MaterialPeer extends BaseMaterialPeer
{
	
  static public function QuantAvui()
  {
     $C = new Criteria();
     $time = date('Y-m-d',mktime(null,null,null,date('m'),date('d')-1,date('Y')));
     $C->add(self::ALTAREGISTRE , $time , Criteria::GREATER_EQUAL );
     return self::doCount($C);
  }

  
  static public function select()
  {
    $MG = self::doSelect(new Criteria());
    $RET = array();
    foreach($MG as $M):
      $RET[$M->getIdmaterial()] = $M->getIdentificador().' - '.$M->getNom();    
    endforeach;    
    return $RET;    
      
  } 
  
  static public function selectGeneric($idG)
  {
	  	
    $C = new Criteria();
    $C->add(self::MATERIALGENERIC_IDMATERIALGENERIC , $idG);
    $RET = array();
  	foreach(self::doSelect($C) as $M):
  		$RET[$M->getIdmaterial()] = $M->getIdentificador().' - '.$M->getNom();
  	endforeach;
  	
  	return $RET;
  	
  }
  
  
  static public function getMaterial($MATERIALGENERIC , $PAGINA = 1)
  {  	
  	
    $C = new Criteria();
    if($MATERIALGENERIC > 0) $C->add(self::MATERIALGENERIC_IDMATERIALGENERIC , $MATERIALGENERIC);
    
    $pager = new sfPropelPager('Material', 10);
	$pager->setCriteria($C);
	$pager->setPage($PAGINA);
	$pager->init();  	
  	return $pager;
  }  
  
}
