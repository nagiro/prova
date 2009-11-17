<?php

/**
 * Subclass for performing query and update operations on the 'missatgesllistes' table.
 *
 * 
 *
 * @package lib.model
 */ 
class MissatgesllistesPeer extends BaseMissatgesllistesPeer
{
	
	static public function getLlistesArray($IDM)
	{
		$RET = array();
				
		$C = new Criteria();
		$C->add(self::IDMISSATGESLLISTES,$IDM);
		
		foreach(self::doSelect($C) as $ML):
						
			$RET[] = $ML->getLlistesIdllistes();
			 		
		endforeach;
		
		return $RET;
		
	}
	
}
