<?php

/**
 * Subclass for performing query and update operations on the 'materialgeneric' table.
 *
 * 
 *
 * @package lib.model
 */ 
class MaterialgenericPeer extends BaseMaterialgenericPeer
{

  static public function select()
  {
    $C = new Criteria();
    $C->addAscendingOrderByColumn(self::NOM);
    $MG = self::doSelect($C);
    $RET = array();
    foreach($MG as $M):
      $RET[$M->getIdmaterialgeneric()] = $M->getNom();    
    endforeach;
    
    return $RET;    
      
  }
  
  static public function selectMaterial()
  {
    $MG = self::doSelect(new Criteria());
    $RET = array();
    foreach($MG as $M):
		$N = $M->getNom();
		$RET[$N] = array();      
      	foreach($M->getMaterials(new Criteria()) as $MD):						
      		$RET[$N][$MD->getIdmaterial()] = $MD->getIdentificador();           
      	endforeach;
    endforeach;
    
    return $RET;    
      
  }
  
  /**
   * Entrem l'identificador de la línia que estem tractant
   *
   * @param int idL
   */
  static public function getLinies($idL)
  {
     $C = new Criteria();
     $C->add(MaterialPeer::MATERIALGENERIC_IDMATERIALGENERIC , $idL );
     return MaterialPeer::doCount($C);
  }

}
