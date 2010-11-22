<?php

/**
 * Subclass for representing a row from the 'agendatelefonicadades' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Agendatelefonicadades extends BaseAgendatelefonicadades
{
	public function getTipusString()
	{
		return AgendatelefonicadadesPeer::getTipus($this->tipus);		
	}
    
    public function getAgendatelefonicadadess()
    {
        $C = new Criteria();
        $C = AgendatelefonicadadesPeer::getCriteriaActiu($C,$this->getSiteId());
        $parent->getAgendatelefonicadadess($C);        
    }
}
