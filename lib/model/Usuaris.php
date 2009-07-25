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

}
