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

    /**
     * Quan afegim un valor aquí, hem d'actualitzar la funció:
     * self::getTipusPagamentString
     * */  
    const PAGAMENT_TARGETA = 20;
    const PAGAMENT_METALIC = 21;
    const PAGAMENT_DOMICILIACIO = 33;
    const PAGAMENT_CODI_BARRES = 34;
    const PAGAMENT_RESERVA = 35;
    const PAGAMENT_LLISTA_ESPERA = 36;

    
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

    static public function getTipusPagamentArray()
    {
        $RET = array();
        $C = new Criteria();
        $C->add(self::TIPUSNOM, 'matricula_pagament');
        $C->add(self::ACTIU, true);
        
        foreach(self::doSelect($C) as $OT):
            $RET[$OT->getIdtipus()] = $OT->getTipusdesc();
        endforeach;
                
        return $RET;
    }    
    
    static public function getTipusPagamentString($id)
    {
        switch($id){
            case self::PAGAMENT_TARGETA: 
                return "Targeta de crèdit";
                break;
            case self::PAGAMENT_METALIC:
                return "En metàl·lic";
                break;
            case self::PAGAMENT_DOMICILIACIO:
                return "Domiciliació";
                break;
            case self::PAGAMENT_CODI_BARRES:
                return "Amb codi de barres";
                break;
            case self::PAGAMENT_RESERVA:
                return "Reserva de plaça";
                break;
            case self::PAGAMENT_LLISTA_ESPERA:
                return "Posar en llista d'espera";
                break;
            default:
                return "N/D";
                break;
        }
    }

    static public function getTipusBy( $nom , $idS = 1 )
    {
        $RET = array();
        $C = new Criteria();
                
        $C->add(self::TIPUSNOM , $nom );
        $C->add(self::SITE_ID , $idS );
        if( self::doCount($C) == 0 ): 
            $C = new Criteria();
            $C->add( self::TIPUSNOM, $nom );
            $C->add( self::SITE_ID , $idS );
        endif; 
        
        foreach(self::doSelect($C) as $OT):
            $RET[$OT->getIdtipus()] = $OT->getTipusdesc();
        endforeach;    
        
        return $RET;
    }

}
