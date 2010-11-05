<?php

/**
 * Subclass for representing a row from the 'agendatelefonica' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Agendatelefonica extends BaseAgendatelefonica
{
    
    public function getAgendatelefonicadadess($criteria = null, PropelPDO $con = null)
    {
        $C = new Criteria();
        $C->add(AgendatelefonicadadesPeer::ACTIU, 1);
        $C->add(AgendatelefonicadadesPeer::AGENDATELEFONICA_AGENDATELEFONICAID, $this->getAgendatelefonicaid());
        return AgendatelefonicadadesPeer::doSelect($C);        
    }
    
}
