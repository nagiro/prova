<?php

/**
 * Subclass for representing a row from the 'horaris' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Horaris extends BaseHoraris
{
	
	public function getMaterials()
	{
		$RET = array();
		foreach($this->getHorarisespaissJoinMaterial() as $HE):		
			$M = $HE->getMaterial();
			if($M instanceof Materials)	$RET[] = $M;			
		endforeach;
		return $RET;
	}
	
}
