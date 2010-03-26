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
	
  static public function selectFormulariUsuaris()
  {
  	return array(1=>'Portàtil',2=>'Projector',3=>'DVD',4=>'Microfonia');
  }
	
  static public function select()
  {
    $C = new Criteria();
    $C->addAscendingOrderByColumn(self::NOM);
    $MG = self::doSelect($C);
    $RET = array();
    $RET[0] = 'Tots els materials';
    foreach($MG as $M):
      $RET[$M->getIdmaterialgeneric()] = $M->getNom();    
    endforeach;
    
    return $RET;    
      
  }
  
  static public function selectAjax($seleccionat = "")
  {
    $C = new Criteria();
    $C->addAscendingOrderByColumn(self::NOM);
    $MG = self::doSelect($C);
    $RET = '<option value="-1">Escull...</option>';
    foreach($MG as $M):
    	if($seleccionat == $M->getIdmaterialgeneric()):
    		$RET .= '<option SELECTED value="'.$M->getIdmaterialgeneric().'">'.$M->getNom().'</option>';
    	else:
    		$RET .= '<option value="'.$M->getIdmaterialgeneric().'">'.$M->getNom().'</option>';
    	endif;      
    endforeach;
    
    $RET = str_replace("'","\'",$RET);
    
    return $RET;    
      
  }

  
  static public function selectMaterialCedit($isRetornat=false)
  {
  	
  	$C = new Criteria();
  	  	
    $MG = self::doSelect($C);
    $RET = array();
    foreach($MG as $M):
		$N = $M->getNom();
		$RET[$N] = array();
		
		$C2 = new Criteria();
		$C2->addJoin(MaterialPeer::IDMATERIAL,CessiomaterialPeer::MATERIAL_IDMATERIAL);
		$C2->add(CessiomaterialPeer::RETORNAT,$isRetornat);
		      
      	foreach($M->getMaterials($C2) as $MD):
      								
      		$RET[$N][$MD->getIdmaterial()] = $MD->getIdentificador();
      		            
      	endforeach;
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
