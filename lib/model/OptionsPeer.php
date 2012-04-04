<?php

require 'lib/model/om/BaseOptionsPeer.php';


/**
 * Skeleton subclass for performing query and update operations on the 'options' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 10/13/10 11:26:11
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class OptionsPeer extends BaseOptionsPeer {

    static public function getCriteriaActiu($C,$idS)
    {
        $C->add(self::SITE_ID, $idS);
        return $C;    
    }

    static public function getString($cond,$idS)
    {
        
        $C = new Criteria();
        $C->add(self::OPTION_ID, $cond);
        $C->add(self::SITE_ID, $idS);
        $OO = self::doSelectOne($C);
        if($OO instanceof Options) return $OO->getValor();
        else{ 
            $C->add(self::OPTION_ID, $cond);
            $C->add(self::SITE_ID, 1);
            $OO = self::doSelectOne($C);
            if($OO instanceof Options) return $OO->getValor();
            else return 'n/d';
        }        
    }
    
    static public function getOptionsArray( $IDS , $totes_les_opcions_de_ccg_generals = false )
    {
        $RET = array();
        
        $C = new Criteria();
        if($totes_les_opcions_de_ccg_generals) $C = self::getCriteriaActiu($C,1);
        else $C = self::getCriteriaActiu($C,$IDS);
                
        foreach(self::doSelect($C) as $OO):
            $RET[$OO->getOptionid()] = $OO->getOptionId();
        endforeach;        
         
        return $RET;
    }
    
    static public function initialize( $idO , $idS , $new )
    {        
        $OO = self::retrieveByPK($idO,$idS);            
        if(!($OO instanceof Options)):                                    		
        	$OO = new Options();
            $OO->setSiteId($idS);                  
        endif;         
       	return new OptionsForm($OO,array('IDS'=>$idS,'NEW'=>$new));
    }
    
    static public function getMailEnt( $OER )
    {

        $idS = $OER->getSiteId();  	
        $Nom = $OER->getNomUsuari();        
        $Activitat = $OER->getNomActivitat();
        $OH = $OER->getHoraris();        
        $OS = SitesPeer::retrieveByPK($OER->getSiteId());
        if(!($OS instanceof Sites)) $OS = new Sites();
      	        
                
        $TEXT = OptionsPeer::getString( 'BODY_MAIL_ENTRADES' , $idS );            
        $TEXT = str_replace( '{{NOM}}' , $OER->getNomUsuari() , $TEXT );
        $TEXT = str_replace( '{{NUM_ENTRADES}}' , $OER->getQuantitat() , $TEXT );
        $TEXT = str_replace( '{{ACTIVITAT}}' , $OER->getNomActivitat() , $TEXT );
        $TEXT = str_replace( '{{ENTITAT}}' , $OS->getNom() , $TEXT );
        $TEXT = str_replace( '{{TEL_ENTITAT}}' , $OS->getTelefon() , $TEXT );
        $TEXT = str_replace( '{{MAIL_ENTITAT}}' , $OS->getEmail() , $TEXT );
        $TEXT = str_replace( '{{TEL_ADMIN}}' , '972.20.20.13' , $TEXT );
        $TEXT = str_replace( '{{MAIL_ADMIN}}' , OptionsPeer::getString('MAIL_ADMIN',$idS) , $TEXT );            
        $TEXT = str_replace( '{{DIA}}' , $OH->getDia('d/m/Y') , $TEXT );
        $TEXT = str_replace( '{{HORA}}' , $OH->getHorainici('H:i') , $TEXT );
        $TEXT = str_replace( '{{ESPAI}}' , implode(',',Horaris::getArrayEspais()) , $TEXT );
        $TEXT = str_replace( '{{CODI}}' , sha1($OER->getIdentrada()) , $TEXT );
          	
       	return $TEXT; 
        
    }

} // OptionsPeer