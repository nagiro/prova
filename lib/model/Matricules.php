<?php

/**
 * Subclass for representing a row from the 'matricules' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Matricules extends BaseMatricules
{

  static function Check($new)
  {
    $E = array();    
    return $E;    
  }    
  
  public function getTpagamentString()
  {
  	return MatriculesPeer::textPagament($this->getTpagament());
  }
  
  public function getTreduccioString()
  {  
  	$A_D = DescomptesPeer::getDescomptesArray($this->getSiteId(),false,false);
    return $A_D[$this->getTreduccio()];  	
  }
  
  public function getEstatString()
  {  
  	return MatriculesPeer::getEstatText($this->getEstat());  	
  }
   
  //Ens diu si tenim descompte a la matrícula o no
  public function hasDescompte(){       
    return ($this->getTreduccio() != DescomptesPeer::CAP);
  }
  
  public function getCcc()
  {
    $ODB = DadesBancariesPeer::retrieveByPK($this->getIddadesbancaries());
    if($ODB instanceof DadesBancaries):
        return $ODB->getCcc();
    else: 
        return "";
    endif;  
  }
 
}
