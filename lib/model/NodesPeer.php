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
  
  static function retornaMenu()
  {          
     return self::getNodes();
  }
  
  static function getNodes()
  {
  	 $C = new Criteria();
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
  
}
