<?php

/**
 * Subclass for representing a row from the 'reservaespais' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Reservaespais extends BaseReservaespais
{
   
   public function check()
   {
      $E = array();
      if(empty($this->espaissolicitats)) $E[] = 'Has de reservar algun espai.';
      if(empty($this->nom)) $E[] = 'Has de donar un nom a l\'activitat.';
      if(empty($this->dataactivitat)) $E[] = 'Has d\'entrar una data per l\'activitat';
      if(empty($this->horariactivitat)) $E[] = 'Has d\'entrar un horari per l\'activitat';
      
      return $E;
   }
   
   public function getEspais()
   {
      $sol = array();
      $espais = explode('@',$this->espaissolicitats);
      foreach($espais as $E):
         $ESPAI = EspaisPeer::retrieveByPK($E);         
         $sol[$ESPAI->getEspaiid()] = $ESPAI->getNom();
      endforeach;
      return implode('<br />',$sol);
   }

   public function getEstatText()
   {
      switch(ReservaespaisPeer::ESTAT){
         case ReservaespaisPeer::EN_ESPERA: return 'En espera';
         case ReservaespaisPeer::ACCEPTADA: return 'Acceptada';
         case ReservaespaisPeer::DENEGADA: return 'Denegada';         
      }
   }
   
}
