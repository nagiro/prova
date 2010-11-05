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

  static function inicialitza( $id , $idMG , $idS )
  {
  	
  	$OM = self::retrieveByPK($id);
    
  	if($OM instanceof Material):
  		return new MaterialForm($OM);
  	else:
  		$OM = new Material();
  		$OM->setMaterialgenericIdmaterialgeneric($idMG);  		
        $OM->setSiteId($idS);
        $OM->setActiu(true);                  
  		return new MaterialForm($OM);  		
  	endif;
  	  	
  }

	
  static public function QuantAvui($idS)
  {
     $C = self::criteria($idS);
     $time = date('Y-m-d',mktime(null,null,null,date('m'),date('d')-1,date('Y')));
     $C->add(self::ALTAREGISTRE , $time , Criteria::GREATER_EQUAL );
     return self::doCount($C);
  }

  
  static public function select($idS)
  {
    
    $C = self::criteria($idS);
        
    $RET = array();
    
    foreach(self::doSelect($C) as $M):
      $RET[$M->getIdmaterial()] = $M->getIdentificador().' - '.$M->getNom();    
    endforeach;    
    
    return $RET;    
      
  } 
  
  static public function selectGeneric($idG, $idS, $idM)
  {    
    
	$C = self::criteria($idS);  	    
    $C->add( self::MATERIALGENERIC_IDMATERIALGENERIC , $idG );
    $C->add( self::IDMATERIAL , $idM );    
    
    $RET = array();
  	foreach(self::doSelect($C) as $M):
  		$RET[$M->getIdmaterial()] = $M->toString();
  	endforeach;
  	
  	return $RET;
  	
  }
  
  
  static public function getMaterial($MATERIALGENERIC , $PAGINA = 1, $idS)
  {  	
  	
    $C = self::criteria($idS);    
    if($MATERIALGENERIC > 0) $C->add(self::MATERIALGENERIC_IDMATERIALGENERIC , $MATERIALGENERIC);    
    
    $pager = new sfPropelPager('Material', 10);
	$pager->setCriteria($C);
	$pager->setPage($PAGINA);
	$pager->init();  	
  	return $pager;
    
  }  

  static public function getCriteriaSolapament($C,$di,$df,$vi,$vf,$inclos = true){
    
    if($inclos){
        $C1 = $C->getNewCriterion( $vi , $di , Criteria::GREATER_EQUAL );
        $C2 = $C->getNewCriterion( $vi , $df , Criteria::LESS_EQUAL );
        $C3 = $C->getNewCriterion( $vf , $di , Criteria::GREATER_EQUAL );
        $C4 = $C->getNewCriterion( $vf , $df , Criteria::LESS_EQUAL );
        $C5 = $C->getNewCriterion( $vi , $di , Criteria::GREATER_EQUAL );
        $C6 = $C->getNewCriterion( $vf , $df , Criteria::LESS_EQUAL );
        $C7 = $C->getNewCriterion( $vi , $di , Criteria::LESS_EQUAL );
        $C8 = $C->getNewCriterion( $vf , $df , Criteria::GREATER_EQUAL );
        $C1->addAnd($C2); $C3->addAnd($C4); $C5->addAnd($C6); $C7->addAnd($C8); 
        $C1->addOr($C3); $C1->addOr($C5); $C1->addOr($C7);
    } else {
        $C1 = $C->getNewCriterion( $vi , $di , Criteria::GREATER_THAN );
        $C2 = $C->getNewCriterion( $vi , $df , Criteria::LESS_THAN );
        $C3 = $C->getNewCriterion( $vf , $di , Criteria::GREATER_THAN );
        $C4 = $C->getNewCriterion( $vf , $df , Criteria::LESS_THAN );
        $C5 = $C->getNewCriterion( $vi , $di , Criteria::GREATER_THAN );
        $C6 = $C->getNewCriterion( $vf , $df , Criteria::LESS_THAN );
        $C7 = $C->getNewCriterion( $vi , $di , Criteria::LESS_THAN );
        $C8 = $C->getNewCriterion( $vf , $df , Criteria::GREATER_THAN );
        $C1->addAnd($C2); $C3->addAnd($C4); $C5->addAnd($C6); $C7->addAnd($C8); 
        $C1->addOr($C3); $C1->addOr($C5); $C1->addOr($C7);        
    }
    return $C1;
    
  }

  static public function getOptionsMaterialLliureHores( $datai , $dataf , $hi , $hf , $idS , $idG )
  {
    
    $OCUPAT = self::getMaterialOcupatHores( $datai , $dataf , $hi , $hf , $idS , $idG );

    $RET = array();
    $C = self::criteria($idS);
    $C->add( MaterialPeer::MATERIALGENERIC_IDMATERIALGENERIC , $idG );
    foreach(self::doSelect($C) as $OM):
        if(!array_key_exists($OM->getIdmaterial(),$OCUPAT)):
            $RET[$OM->getIdmaterial()] = '<option value="'.$OM->getIdmaterial().'">'.addslashes($OM->toString()).'</option>';
        else: 
            $RET[$OM->getIdmaterial()] = '<option value="'.$OM->getIdmaterial().'" style="text-decoration: line-through">'.addslashes($OM->toString()).'</option>';            
        endif;
    endforeach;
    
    return implode(' ',$RET); 

  }

  static private function criteriaOcupatCessio($datai , $dataf , $hi , $hf , $idS , $idG = null , $idH = null , $idC = null)
  {
    //Agafo les activitats que tenen material ocupat una data determinada.
    $C = self::criteria($idS);    
            
    $C->add( MaterialPeer::ACTIU , true );
    $C->add( MaterialPeer::SITE_ID , $idS );        
    if(!is_null($idG)) $C->add( MaterialPeer::MATERIALGENERIC_IDMATERIALGENERIC , $idG );
    if(!is_null($idC)) $C->add( CessiomaterialPeer::CESSIO_ID, $idC , Criteria::NOT_EQUAL );
    $C->addJoin( self::IDMATERIAL , CessiomaterialPeer::MATERIAL_IDMATERIAL );
    $C->addJoin( CessiomaterialPeer::CESSIO_ID , CessioPeer::CESSIO_ID );            
    $C->addAnd(self::getCriteriaSolapament($C,$datai,$dataf,CessioPeer::DATA_CESSIO, CessioPeer::DATA_RETORN , false ));                 
    $C->add(CessiomaterialPeer::ACTIU, true);
    $C->add(CessioPeer::ACTIU, true);            

    return $C;
  }
      
  static private function criteriaOcupatEspais($datai , $dataf , $hi , $hf , $idS , $idG = null , $idH = null , $idC = null)
  {
    //Mirem les activitats que usen material aquests dies. 
    $C = new Criteria();
    $C->add( HorarisPeer::ACTIU , true );
    $C->addJoin( HorarisPeer::HORARISID , HorarisespaisPeer::HORARIS_HORARISID );
    $C->add( HorarisespaisPeer::ACTIU , true );
    $C->addJoin( HorarisespaisPeer::MATERIAL_IDMATERIAL , MaterialPeer::IDMATERIAL );
    $C->add( MaterialPeer::ACTIU , true );
    if(!is_null($idG)) $C->add( MaterialPeer::MATERIALGENERIC_IDMATERIALGENERIC , $idG );    
    if(!is_null($idH)) $C->add( HorarisPeer::HORARISID , $idH, Criteria::NOT_EQUAL);
    $C1 = self::getCriteriaSolapament($C,$datai,$dataf,HorarisPeer::DIA,HorarisPeer::DIA);
    $C2 = self::getCriteriaSolapament($C,$hi,$hf,HorarisPeer::HORAPRE, HorarisPeer::HORAPOST);
    $C1->addAnd($C2);    
    $C->addAnd($C1);            
    return $C;    
  }
      
  /**
   * Demano quin material està ocupat en un intèrval 
   * */    
  static private function getMaterialOcupatHores( $datai , $dataf , $hi , $hf , $idS , $idG = null , $idH = null , $idC = null)
  {
    
    $CESSIO = array();
    
    $C = self::criteriaOcupatCessio( $datai , $dataf , $hi , $hf , $idS , $idG , $idH , $idC );        
    foreach(self::doSelect($C) as $OM) $CESSIO[$OM->getIdmaterial()] = $OM;            
      
    $C = self::criteriaOcupatEspais( $datai , $dataf , $hi , $hf , $idS , $idG , $idH , $idC );    
    foreach(self::doSelect($C) as $OM) $CESSIO[$OM->getIdmaterial()] = $OM;    

    return $CESSIO;
                          
  }

  /**
   * Diu si un cert material està lliure un cert dia 
   * */
  static public function isLliure( $idM , $idS , $data , $hi , $hf , $idH = null )
  {
    
    $OCUPAT = self::getMaterialOcupatHores( $data , $data , $hi , $hf , $idS , null, $idH );
    return !array_key_exists($idM, $OCUPAT);
                              
  }

  /**
   * Diu si un material és lliure en un intèrval e temps 
   * */
  static public function isLliureFranja( $idM , $idS , $datai , $dataf , $hi , $hf , $idH = null , $idC = null )
  {
    
    $OCUPAT = self::getMaterialOcupatHores( $datai , $dataf , $hi , $hf , $idS , null, null, $idC );     
    return !array_key_exists($idM, $OCUPAT);
                              
  }

  /**
   * Indica on està ocupat el material en un intèrval de temps 
   * */
  static public function OnOcupatMaterialHores( $idM , $datai , $dataf , $hi , $hf , $idS , $idG = null , $idH = null , $idC = null)
  {
    
    //Busquem primer l'horari en el que està ocupat. 
    //Altrament busquem la cessió en la que està ocupat
    //Agafo les activitats que tenen material ocupat una data determinada.
    $CESSIO = array();
    $C = self::criteriaOcupatCessio( $datai , $dataf , $hi , $hf , $idS , $idG , $idH , $idC );        
    foreach(CessioPeer::doSelect($C) as $OC) $CESSIO[$idM] = $OC;            
      
    $C = self::criteriaOcupatEspais( $datai , $dataf , $hi , $hf , $idS , $idG , $idH , $idC );    
    foreach(HorarisPeer::doSelect($C) as $OH) $CESSIO[$idM] = $OH;    
        
    return $CESSIO;
    
  }

      
  static public function criteria($idS)
  {
    $C = new Criteria();
    $C->add(self::ACTIU , true);
    $C->add(self::SITE_ID , $idS );
    return $C;
  }
  
}
