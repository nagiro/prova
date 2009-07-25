<?php

/**
 * Subclass for representing a row from the 'descripcions' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Descripcions extends BaseDescripcions
{
   
   public function getText($PART)
   {
      $TOCA = false;      
      foreach(explode('---',$this->getDescripcio()) as $D):
         if($D == $PART) $TOCA = true;
         if($TOCA) return $D;
      endforeach;
   }
   
   
}

