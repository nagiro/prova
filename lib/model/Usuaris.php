<?php

/**
 * Subclass for representing a row from the 'usuaris' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Usuaris extends BaseUsuaris
{

	function getPoblacioString()
	{
		$poblacio = $this->getPoblaciotext(); 
		if(!empty($poblacio)):			 
			return $this->getPoblaciotext();
		else:
			$OP = PoblacionsPeer::retrieveByPK($this->getPoblacio());
			if($OP instanceof Poblacions):
				$poblacio = $OP->getNom();
				return $poblacio;
			else:
				return "Desconeguda";
			endif; 		
		endif;
	}
	
  public function __toString(){  return $this->getNomComplet(); }
	
  function getNomComplet(){     
     return $this->getCog1().' '.$this->getCog2().', '.$this->getNom();
  }
   
  public function Check($new)
  {
    $E = array();    
    if( strlen($this->getDNI())   < 7)  $E[] = "No s'ha entrat el DNI o �s incorrecte";     
    if( strlen($this->getNom())   < 1)  $E[] = "No s'ha entrat el NOM";
    if( strlen($this->getCog1())  < 1) $E[] = "Heu d'entrar els COGNOMS.";
    if((strlen($this->getMobil()) < 1) 
     && (strlen($this->getTelefon()) < 1 ) 
     && (strlen($this->getEmail()) < 1 )) $E[] = "Heu d'entrar algun TEL�FON o CORREU ELECTR�NIC.";
    
    $C = new Criteria();    
    $C->add(UsuarisPeer::DNI , $this->getDNI() , Criteria::EQUAL );
    if( UsuarisPeer::doCount($C) > 0 && $new) $E[] = "El DNI ja existeix.";    
    
    return $E;
  }
  
  public function getDades()
  {
  	
  	$RET  = $this->getDni();
  	$RET .= '<br />'.$this->getNomComplet();
  	$RET .= '<br />'.$this->getTelefon();
  	$RET .= '<br />'.$this->getEmail();
  	$RET .= '<br />'.$this->getAdreca();
  	$RET .= '<br />'.$this->getCodipostal().' - '.$this->getPoblaciotext();
  	return $RET;
  	  	
  }
  
  public function getTelefon2()
  {
    
  	$telf = $this->getTelefon();
    $mob  = $this->getMobil();
      	
    if(strlen($telf) > 0 ) return $telf;
    else return $mob;          	
  	  	
  }

}
