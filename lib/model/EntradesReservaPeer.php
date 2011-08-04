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

    const ENVIADA = 0;    
    const CONFIRMADA = 10;
    const ANULADA = 20;

    static public function getCriteriaActiu($C)
    {
        $C->add(self::ACTIU, true);
        return $C;
    }

	static public function initialize( $idER = 0 )
	{		
		$OER = EntradesPeer::retrieveByPK($idER);		
		if(!($OER instanceof EntradesReserva)):
			$OER = new EntradesReserva();
			$OER->setUsuariid(null);
			$OER->setHorarisid(null);
			$OER->setQuantes(0);
			$OER->setData(date('Y-m-d H:i',time()));						
		endif; 		
		
        return new EntradesReservaForm($OER);
	}

    static public function getEntradesUsuari($idU){
        $C = new Criteria();
        $C = self::getCriteriaActiu($C);
        
        $C->add(self::USUARI_ID, $idU);
        $C->addDescendingOrderByColumn(self::ENTRADES_RESERVA_ID);
        return self::doSelect($C);        
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
        $C->add(self::HORARIS_ID, $idH);
        $C->add(self::ESTAT,EntradesReservaPeer::ANULADA, CRITERIA::NOT_EQUAL);
        return (self::doCount($C)>0);        
    }


} // EntradesReservaPeer
