<?php

require 'lib/model/om/BaseFormularis.php';


/**
 * Skeleton subclass for representing a row from the 'formularis' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 09/05/11 10:56:55
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class Formularis extends BaseFormularis {

	/**
	 * Initializes internal state of Formularis object.
	 * @see        parent::__construct()
	 */
	public function __construct()
	{
		// Make sure that parent constructor is always invoked, since that
		// is where any default values for this object are set.
		parent::__construct();
	}
    
    public function getNomForUrl()
    {
        
        $nom = $this->getNom();
        return myUser::text2url($nom);
                
    }
    
    public function getSiteName()
    {
        $OS = SitesPeer::retrieveByPK($this->getSiteId());
        if($OS instanceof Sites) return $OS->getNom();
        else return 'n/d';        
    }
   
    public function isOmplert($idU)
    {
        $C = new Criteria();
        $C->add(FormularisRespostesPeer::IDUSUARIS, $idU);
        $C->add(FormularisRespostesPeer::IDFORMULARIS, $this->getIdformularis());
        $C->add(FormularisRespostesPeer::ACTIU, true);
        
        return (FormularisRespostesPeer::doCount($C) > 0)?true:false;
        
    }
   
} // Formularis
