<?php

/**
 * Subclass for representing a row from the 'horaris' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Horaris extends BaseHoraris
{
	
	public function getMaterials()
	{
		$RET = array();
		foreach($this->getHorarisespaissJoinMaterial() as $HE):		
			$M = $HE->getMaterial();
			if($M instanceof Materials)	$RET[] = $M;			
		endforeach;
		return $RET;
	}
	
	public function getArrayEspais()
	{
		$RET = array();		
		foreach($this->getHorarisespaiss() as $HE):																									
			$RET[] = $HE->getEspais();									
		endforeach;		
		return $RET;
	}
    
    //Funció usada a gActivitats per llistar els espais
    public function getArrayHorarisEspaisActiusAgrupats()
    {
        $RET = array();
        $C = new Criteria();
        $C->add( HorarisespaisPeer::HORARIS_HORARISID , $this->getHorarisid() );        
        $C->add( HorarisespaisPeer::ACTIU , true );
        $C->add( HorarisespaisPeer::SITE_ID , $this->getSiteId() );
        $C->addGroupByColumn( HorarisespaisPeer::ESPAIS_ESPAIID );
        foreach(HorarisespaisPeer::doSelect($C) as $HE):
            $RET[$HE->getEspaisEspaiid()] = $HE->getEspais()->getNom();
        endforeach;        
        return $RET;                
    }
    
    public function getArrayHorarisEspaisMaterial()
    {
        $RET = array();
        $C = new Criteria();
        $C->add( HorarisespaisPeer::HORARIS_HORARISID , $this->getHorarisid() );
        $C->add( HorarisespaisPeer::ACTIU , true );
        $C->add( HorarisespaisPeer::SITE_ID , $this->getSiteId() );
        $C->addGroupByColumn( HorarisespaisPeer::MATERIAL_IDMATERIAL );
        foreach(HorarisespaisPeer::doSelect($C) as $HE):            
            $OM = MaterialPeer::retrieveByPK($HE->getMaterialIdmaterial());
            if($OM instanceof Material):
                $RET[$OM->getIdmaterial()] = array('material'=>$OM->getIdmaterial(),'nom'=>$OM->toString(),'generic'=>$OM->getMaterialgenericIdmaterialgeneric());
            endif;
        endforeach;        
        return $RET;        
    } 
    
}
