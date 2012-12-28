<?php

/**
 * Subclass for representing a row from the 'nodes' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Nodes extends BaseNodes
{

  static function Check()
  {
    $E = array();
    return $E;
  }
  
  public function getNomForUrl()
  {
    $nom = $this->getTitolmenu();
    return myUser::text2url($nom);
  }
  
  /**
   * Retorna l'arbre de nodes del directori
   **/
  public function getArbre(){
    
    //Variable per assegurar uqe no hi hagi cap error en l'arbre.
    $i = 0;
    
    $RET = array( $this->getIdnodes() => $this );    
    $NODE_ACTUAL = NodesPeer::retrieveByPK( $this->getIdpare() );
    while( ! is_null( $NODE_ACTUAL ) && $i++ < 10 ){
        $RET[ $NODE_ACTUAL->getIdnodes() ] = $NODE_ACTUAL;
        $NODE_ACTUAL = NodesPeer::retrieveByPK( $NODE_ACTUAL->getIdpare() );           
    }
    return $RET;
  }
  
}
