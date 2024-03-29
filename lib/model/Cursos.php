<?php

/**
 * Subclass for representing a row from the 'cursos' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Cursos extends BaseCursos
{
  /**
   * Retorna el nombre de matriculats que hi ha a un curs
   *
   * @return INT
   */
  public function countMatriculats($idS)
  {  
    
     $C = new Criteria();
     $C = MatriculesPeer::criteriaMatriculat($C); 
     $C->add(MatriculesPeer::CURSOS_IDCURSOS, $this->getIdcursos());        
     return self::countMatriculess($C);          
  }
  
  public function getMatriculats()
  {
     $C = new Criteria(); 
     $C->addAscendingOrderByColumn(MatriculesPeer::ESTAT);     
     $C->addAscendingOrderByColumn(MatriculesPeer::DATAINSCRIPCIO);
     //$C->add(MatriculesPeer::CURSOS_IDCURSOS, $this->getIdcursos());
     return $this->getMatriculess($C);
  }
  
  public function getCategoriaText()
  {  	
  	return TipusPeer::retrieveByPk($this->getCategoria())->getTipusDesc();
  }
  
  public function countMatriculesActives($idS)
  {
     $C = new Criteria();
     $C = MatriculesPeer::criteriaMatriculat($C,false);
     $C->add(MatriculesPeer::CURSOS_IDCURSOS, $this->getIdcursos());     
     return MatriculesPeer::doCount($C);
  }
 
  public function isPle()
  {
    $RS = $this->getPlacesArray();
    if($RS['OCUPADES'] >= $RS['TOTAL']) return true;
    else return false;    
  }
 
  public function getPlacesArray()
  {
    return CursosPeer::getPlaces($this->getIdcursos(),$this->getSiteId());
  }
  
  public function CalculaPreu($DESCOMPTE)
  {
    return CursosPeer::CalculaPreu($this->getIdcursos(), $DESCOMPTE, $this->getSiteId());
  }
    
  public function getActivitatVinculada()
  {
    $IDA = $this->getActivitatid();    
    $OA = ActivitatsPeer::initialize($IDA,0,$this->getSiteId())->getObject();    
    if($OA->isNew()):
        $OA->setNom($this->getTitolcurs());
        $OA->setCiclesCicleid(null);
        $OA->setTipusactivitatIdtipusactivitat(TipusactivitatPeer::T_CURS);        
        $OA->setPreu($this->getPreu());
        $OA->setPreureduit($this->getPreur());
        $OA->setPublicable(true);
        $OA->setEstat(ActivitatsPeer::ESTAT_ACTIVITAT_ACCEPTADA);        
        $OA->save();
        $this->setActivitatid($OA->getActivitatid());
        $this->save();
    endif;         
    return $OA;
  }
 
  public function getNomSite()
  {    
    return SitesPeer::getNom($this->getSiteId());
  } 
 
  public function getNomForUrl()
  {
    $nom = $this->getTitolcurs();
    return myUser::text2url($nom);        
  } 

  public function h_getDescomptes()
  {
    return $this->getDescomptesArray();
  }

  public function getDescomptesArray($ambPreu = true){
    
    $RET = array();

    $RET[DescomptesPeer::CAP]  = 'Sense descompte';
    if($ambPreu) $RET[DescomptesPeer::CAP] .= ' ('.$this->getPreu().'€)';    
    
    foreach(explode('@',$this->getAdescomptes()) as $IDD){
        $OD = DescomptesPeer::retrieveByPK($IDD);
        if($OD instanceof Descomptes):
            $RET[$IDD]  = $OD->getDescripcio();
            if($ambPreu) $RET[$IDD] .= ' ('.DescomptesPeer::getPreuAmbDescompte($this->getPreu(),$IDD).'€)';
        endif;        
    }            
    return $RET;

    
  }
  
  /**
   * Retorna els tipus de pagament que hi ha pel curs existent. 
   * @param intranet bool ( Indica si és per a usar a la intranet o a la extranet )
   * */
  public function getSelectPagaments( $intranet = false , $mostra_escull = false){
    
    $ALL = TipusPeer::getTipusPagamentArray();
    $RET = array();
    $SEL = ($intranet)?$this->getPagamentintern():$this->getPagamentextern();
    $SEL = explode( '@' , $SEL );
    
    if($mostra_escull) $RET[0] = 'Escull una modalitat...';           
    foreach($SEL as $E):                
        if(!empty($E)) $RET[$E] = $ALL[$E];
    endforeach;
    
    return $RET;
    
  }
  
  /**
   * Ens diu si un curs té actiu la llista d'espera o no
   * @param $intranet bool ( Indica si estem mirant-ho per a la intranet o bé per a la extranet )
   **/
  public function getIsLlistaEspera($intranet = false)
  {
    $A = $this->getSelectPagaments( $intranet );
    return array_key_exists( TipusPeer::PAGAMENT_LLISTA_ESPERA , $A );    
  }

}
