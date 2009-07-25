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
	public function hola()
	{
		return 'Valor'.$this->agendatelefonicaid;
	}
}
