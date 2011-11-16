<?php

require 'lib/model/om/BaseEntradesReservaPeer.php';


/**
 * Skeleton subclass for performing query and update operations on the 'entrades_reserva' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 04/27/11 14:57:30
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class EntradesReservaPeer extends BaseEntradesReservaPeer {
        
    const ESTAT_ENTRADA_CONFIRMADA = 10;
    const ESTAT_ENTRADA_ANULADA = 20;
    const ESTAT_ENTRADA_EN_ESPERA = 30;

    static public function getCriteriaActiu($C)
    {
        $C->add(self::ACTIU, true);
        return $C;
    }

    static public function selectEstats(){
        return array(
            self::ESTAT_ENTRADA_EN_ESPERA => 'En espera',            
            self::ESTAT_ENTRADA_CONFIRMADA => 'Confirmada',
            self::ESTAT_ENTRADA_ANULADA => 'Anulada',        
        );
        
    }

	static public function initialize( $idS , $url_ajax_usuaris, $idER = 0 , $idA = 0, $idH = 0 , $idU = 0 )
	{				
        $OER = self::retrieveByPK($idER);	
        
		if(!($OER instanceof EntradesReserva)):
			$OER = new EntradesReserva();
            $OER->setEntradesPreusActivitatId(($idA == 0)?null:$idA);
            $OER->setEntradesPreusHorariId(($idH == 0)?null:$idH);
			$OER->setUsuariid(($idU == 0)?null:$idU);
            $OER->setNomReserva("");
            $OER->setQuantitat(0);			
			$OER->setEstat(self::ESTAT_ENTRADA_EN_ESPERA);
            $OER->setActiu(true);
            $OER->setSiteid($idS);
			$OER->setData(date('Y-m-d H:i',time()));
		endif; 		
		
        return new EntradesReservaForm($OER,array('ajax'=>$url_ajax_usuaris));
	}

    static public function h_getEntradesUsuariArray($idU){
        $RET = array();
        
        foreach(self::getEntradesUsuari($idU) as $OE):
            $RET[$OE->getActivitatsid()] = $OE->getEntradesReservaId();
        endforeach;
        
        return $RET;
    }


    /**
     * Retorna les entrades guardades per a un usuari en concret.
     * @param $idU Usuariid()
     * @return Llistat d'entrades
     * */
    static public function getEntradesUsuari($idU){
        $C = new Criteria();
        $C = self::getCriteriaActiu($C);
        
        $C->add(self::USUARI_ID, $idU);
        $C->addDescendingOrderByColumn(self::ENTRADES_RESERVA_ID);
        return self::doSelect($C);        
    }

    /**
     * Retorna les entrades guardades per a una activitat en concret.
     * @param $idA Activitatid()
     * @return Llistat d'entrades
     * */
    static public function getEntradesActivitat($idA){
        $C = new Criteria();
        $C = self::getCriteriaActiu($C);
        
        $C->add(self::ACTIVITATS_ID, $idA);
        $C->addDescendingOrderByColumn(self::ENTRADES_RESERVA_ID);
        return self::doSelect($C);        
    }


    /**
     * Diu quantes entrades s'han confirmat d'una activitat.
     * @param $idA Activitat id     
     * @return Int Quantes entrades s'han trobat.
     * */
    static public function countEntradesActivitatConf($idA,$idH = 0){
        $RET = 0;
        
        $C = new Criteria();
        $C = self::getCriteriaActiu($C);
        $C->add( self::ENTRADES_PREUS_ACTIVITAT_ID , $idA );
        if($idH > 0) $C->add( self::ENTRADES_PREUS_HORARI_ID , $idH ); 
        $C->add( self::ESTAT , self::ESTAT_ENTRADA_CONFIRMADA);
        
        foreach(self::doSelect($C) as $OE):            
            $RET += $OE->getQuantes();
        endforeach;
        
        return $RET;
    }


    /**
     * L'usuari ja ha comprat entrades per aquest dia en concret.
     * @param $idU Usuari ID
     * @param $idH Horari ID
     * @return Int Quantes entrades s'han trobat.
     * */
    static public function ExisteixenEntradesComprades($idU,$idH)
    {
        $C = new Criteria();
        $C = self::getCriteriaActiu($C);
        
        $C->add(self::USUARI_ID, $idU);
        $C->add(self::ACTIVITATS_ID, $idH);
        $C->add(self::ESTAT,EntradesReservaPeer::ANULADA, CRITERIA::NOT_EQUAL);
        return (self::doCount($C)>0);        
    }


} // EntradesReservaPeer
