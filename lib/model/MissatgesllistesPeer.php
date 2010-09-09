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
	//Recollim les llistes a les que s'ha vinculat el missatge
	static public function getLlistesArray($IDM)
	{
		$RET = array();
				
		$C = new Criteria();
		$C->add(self::IDMISSATGESLLISTES,$IDM);
        $C->addJoin(self::LLISTES_IDLLISTES, LlistesPeer::IDLLISTES);		
		foreach(LlistesPeer::doSelect($C) as $OL) { $RET[] = $OL->getIdllistes(); }
		                
		return $RET;
		
	}
	
}
