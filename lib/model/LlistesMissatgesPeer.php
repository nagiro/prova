<?php

require 'lib/model/om/BaseLlistesMissatgesPeer.php';


/**
 * Skeleton subclass for performing query and update operations on the 'llistes_missatges' table.
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
class LlistesMissatgesPeer extends BaseLlistesMissatgesPeer {

    static public function getMissatgesAll($idS, $P){
        $C = new Criteria();
        $C->add(self::ACTIU, true);
        $C->add(self::SITE_ID, $idS);
        $C->addDescendingOrderByColumn(self::IDMISSATGE);
        
        $pager = new sfPropelPager('LlistesMissatges', 20);
        $pager->setCriteria($C);
        $pager->setPage($P);
        $pager->init();    	
        
        return $pager;
    }

    static public function initialize( $idM , $idS )
	{
		$O = LlistesMissatgesPeer::retrieveByPK($idM);            
		if(!($O instanceof LlistesMissatges)):            			
			$O = new LlistesMissatges();
            $O->setSiteId($idS);        
            $O->setActiu(true);        									
		endif; 
                
        return new LlistesMissatgesForm($O);
	}

} // LlistesMissatgesPeer
