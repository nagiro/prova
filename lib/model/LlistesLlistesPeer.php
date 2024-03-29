<?php

require 'lib/model/om/BaseLlistesLlistesPeer.php';


/**
 * Skeleton subclass for performing query and update operations on the 'llistes_llistes' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 10/25/11 12:18:25
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class LlistesLlistesPeer extends BaseLlistesLlistesPeer {

    static public function getLlistesAll($IDS){
        $C = new Criteria();
        $C->add(self::ACTIU, true);
        $C->add(self::SITE_ID, $IDS);
        
        return self::doSelect($C);
    }

    /**
     * Retorna les llistes relacionades amb un missatge
     * @param $idM idMissatge     
     * @return Select LlistesLlistes
     * */
    static public function getLlistesMissatge($idM){        
        $C = new Criteria();
        $C->add(self::ACTIU, true);        
        $C->addJoin(LlistesLlistesMissatgesPeer::IDLLISTA, self::IDLLISTA);
        $C->add(LlistesLlistesMissatgesPeer::IDMISSATGE, $idM);
        $C->add(LlistesLlistesMissatgesPeer::ACTIU, true);
        $C->addGroupByColumn(self::IDLLISTA);        
        
        return self::doSelect($C);
    }


} // LlistesLlistesPeer
