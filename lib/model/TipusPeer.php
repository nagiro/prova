<?php

/**
 * Subclass for performing query and update operations on the 'tipus' table.
 *
 * 
 *
 * @package lib.model
 */ 
class TipusPeer extends BaseTipusPeer
{
	static public function getDataIniciMatriculaAnticsAlumnes()
	{
		$C =new Criteria();		
		$C->add(self::TIPUSNOM, 'matricules_inici_antics');		
		return self::doSelectOne($C);
	}
	
	static public function getDataIniciMatriculaTothom()
	{
		$C = new Criteria();
		$C->add(self::TIPUSNOM, 'matricules_inici_tothom');
		return self::doSelectOne($C);
	}
	
    static public function getDescomptesArray()
    {
        $RET = array();
        $C = new Criteria();
        $C->add(self::TIPUSNOM, 'matricula_reduccio');
        $C->add(self::ACTIU, true);
        
        foreach(self::doSelect($C) as $OT):
            $RET[$OT->getIdtipus()] = $OT->getTipusdesc();
        endforeach;
        
        return $RET;
    }
    
}
