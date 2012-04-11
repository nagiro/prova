<?php

require 'lib/model/om/BaseDadesBancariesPeer.php';


/**
 * Skeleton subclass for performing query and update operations on the 'dades_bancaries' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 03/12/12 11:32:42
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class DadesBancariesPeer extends BaseDadesBancariesPeer {

    /**
     * Valida si un compte corrent en format només numèric és correcte.      
     * */
    static public function isCorrecteCCC($ccc){
     
        //$ccc sería el 20770338793100254321
        $valido = true;
         
        ///////////////////////////////////////////////////
        //    Dígito de control de la entidad y sucursal:
        //Se multiplica cada dígito por su factor de peso
        ///////////////////////////////////////////////////
        $suma = 0;
        $suma += $ccc[0] * 4;
        $suma += $ccc[1] * 8;
        $suma += $ccc[2] * 5;
        $suma += $ccc[3] * 10;
        $suma += $ccc[4] * 9;
        $suma += $ccc[5] * 7;
        $suma += $ccc[6] * 3;
        $suma += $ccc[7] * 6;
         
        $division = floor($suma/11);
        $resto    = $suma - ($division  * 11);
        $primer_digito_control = 11 - $resto;
        if($primer_digito_control == 11)
        $primer_digito_control = 0;
         
        if($primer_digito_control == 10)
        $primer_digito_control = 1;
         
        if($primer_digito_control != $ccc[8])
        $valido = false;
         
        ///////////////////////////////////////////////////
        //            Dígito de control de la cuenta:
        ///////////////////////////////////////////////////
        $suma = 0;
        $suma += $ccc[10] * 1;
        $suma += $ccc[11] * 2;
        $suma += $ccc[12] * 4;
        $suma += $ccc[13] * 8;
        $suma += $ccc[14] * 5;
        $suma += $ccc[15] * 10;
        $suma += $ccc[16] * 9;
        $suma += $ccc[17] * 7;
        $suma += $ccc[18] * 3;
        $suma += $ccc[19] * 6;
         
        $division = floor($suma/11);
        $resto = $suma-($division  * 11);
        $segundo_digito_control = 11- $resto;
         
        if($segundo_digito_control == 11)
        $segundo_digito_control = 0;
        if($segundo_digito_control == 10)
        $segundo_digito_control = 1;
         
        if($segundo_digito_control != $ccc[9])
        $valido = false;
         
        return $valido;    
        
    }

    /**
     * Ens diu si un compte corrent existeix per a una entitat      
     * */
    static public function isExisteix($ccc,$idS,$idU){
        $C = new Criteria();
        $C->add(self::ACTIU, true);
        $C->add(self::SITE_ID, $idS);
        $C->add(self::IDUSUARI, $idU);                
        
        foreach(self::doSelect($C) as $ODB):
            if($ODB->getCcc() == $ccc) return true; 
        endforeach;
        
        return false;
    }

	static public function initialize($idD , $idU , $idS )
	{
		$ODB = DadesBancariesPeer::retrieveByPK($idD);            
		if(!($ODB instanceof DadesBancaries)):            			
			$ODB = new DadesBancaries();
            $ODB->setIdusuari($idU);
            $ODB->setSiteId($idS);        
            $ODB->setActiu(true);        									
		endif; 
                
        return new DadesBancariesForm($ODB,array('IDS'=>$idS,'IDU'=>$idU));
	}


    static public function getDadesUsuari($idU)
    {
        $C = new Criteria();
        $C->add(self::ACTIU, TRUE);
        $C->add(self::IDUSUARI, $idU);
        
        return self::doSelect($C);
    }
    
    //S'entra un llistat de self i es llista com un select. 
    static public function getSelectBySelect($LODB,$nou = false)
    {
        
        $RET = array();        
        if(is_null($LODB)) return $RET;
                
        if($nou) $RET[null] = 'Nou compte corrent';         
        foreach($LODB as $ODB):
            $RET[$ODB->getIddada()] = "xxxx-xxxx-xx-xxxxxx".substr($ODB->getCcc(),16,4);
        endforeach;
        
        return $RET;
    }
    
    /**
     * A partir d'un CCC el recuperem 
     **/
    static public function getByCCC( $CCC , $idU , $idS )
    {
        $C = new Criteria();
        $C->add(self::ACTIU, true);
        $C->add(self::SITE_ID, $idS);
        $C->add(self::IDUSUARI, $idU);
        
        foreach(self::doSelect($C) as $ODB):
            if($ODB->getCcc() == $CCC) return $ODB; 
        endforeach;
        
        return null;                                             
    }

    /**
     * Afegeixo un compte corrent mitjançant una funció i retorno el seu ID
     * */
    static public function addCCC( $CCC , $idS , $idU , $dni = "" , $titular = "", $entitat = "", $poblacio = "" )
    {
        //Recuperem el que hi hagi segons CCC a un site. Si no existeix pel site, l'afegim.
        $ODB = self::getByCCC( $CCC , $idU , $idS );
        
        if(is_null($ODB)){
            $ODB = self::initialize(null,$idU,$idS)->getObject();
            $ODB->setNif($dni);
            $ODB->setTitular($titular);
            $ODB->setEntitat($entitat);
            $ODB->setPoblacio($poblacio);
            $ODB->save();            
        }
        return $ODB;
    }

} // DadesBancariesPeer