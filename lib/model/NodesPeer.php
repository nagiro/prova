<?php

/**
 * Subclass for performing query and update operations on the 'nodes' table.
 *
 * 
 *
 * @package lib.model
 */ 
class NodesPeer extends BaseNodesPeer
{
  
  static function getNodesSelect()
  {
    $RET = array();

    foreach(self::getNodesActius as $NODE)
    {
      $RET[$NODE->getIdnodes()] = $NODE->getIdnodes().' - '.$NODE->getTitolmenu(); 
    }
    return $RET;
  }
  
  static function retornaMenu($Tambe_invisibles = false)
  {          
     return self::getNodes($Tambe_invisibles);
  }
  
  static function getNodes($Tambe_invisibles = false)
  {
  	 $C = new Criteria();
  	 if(!$Tambe_invisibles) $C->add(self::ISACTIVA,true);
     $C->addAscendingOrderByColumn(self::ORDRE);
          
     return self::doSelect($C);
  }
  
  static function selectOrdre($NOU = false)
  {
     $RET = array();     
     foreach(self::getNodes() as $N) $RET[$N->getOrdre()] = $N->getOrdre();     
     if($NOU): $RET[sizeof($RET)+1] = sizeof($RET)+1; endif;
     return $RET;
  }
  
  static function gestionaOrdre( $desti , $actual )
  {   
     foreach(self::getNodes() as $N):
        $Ordre = $N->getOrdre();     
	    if($actual == 0){ if($Ordre >= $desti) $N->setOrdre($Ordre+1); }            
	    elseif($actual < $desti) { if($Ordre > $actual && $Ordre <= $desti) $N->setOrdre($Ordre-1); } 
	    elseif($actual > $desti) { if($Ordre >= $desti && $Ordre < $actual) $N->setOrdre($Ordre+1); }	    
	    $N->save();     
     endforeach;
  }
  
  static function getIsCategoria($IDN)
  {
  	return self::retrieveByPK($IDN)->getIscategoria();  
  }
  
  static function getIsExterna($IDN)
  {
  	$URL = self::retrieveByPK($IDN)->getUrl();  	
  	return (strlen($URL)>4);  
  }
  
  static public function selectPagina($idP)
  {
  	$NODE = self::retrieveByPK($idP);
  	return $NODE; 
  }
    
}
