<?php

/**
 * Subclass for performing query and update operations on the 'agendatelefonica' table.
 *
 * 
 *
 * @package lib.model
 */ 
class AgendatelefonicaPeer extends BaseAgendatelefonicaPeer
{
   
  static function getLinies()
  {
     $C = new Criteria();
     return self::doCount($C);
  }
   
   
}
