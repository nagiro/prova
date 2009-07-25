<?php

/**
 * Subclass for performing query and update operations on the 'TipusActivitat' table.
 *
 * 
 *
 * @package lib.model
 */ 
class TipusactivitatPeer extends BaseTipusactivitatPeer
{

  static public function getSelect()
    {
      $TA = self::doSelect(new Criteria());
      $ret = array();
      foreach($TA as $T)
      {
        $ret[$T->getIdtipusactivitat()] = $T->getNom();
      }
      
      return $ret;
    }
        

}
