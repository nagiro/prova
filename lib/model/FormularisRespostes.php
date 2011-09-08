<?php

require 'lib/model/om/BaseFormularisRespostes.php';


/**
 * Skeleton subclass for representing a row from the 'formularis_respostes' table.
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
class FormularisRespostes extends BaseFormularisRespostes {

	/**
	 * Initializes internal state of FormularisRespostes object.
	 * @see        parent::__construct()
	 */
	public function __construct()
	{
		// Make sure that parent constructor is always invoked, since that
		// is where any default values for this object are set.
		parent::__construct();
	}

    public function getNom()
    {
        $OF = FormularisPeer::retrieveByPK($this->getIdformularis());
        if($OF instanceof Formularis) return $OF->getNom();
        else return 'n/d';
        
    }

    public function getFormulariss()
    {
        $C = new Criteria();
        $C->add(FormularisRespostesPeer::ACTIU, true);
        $C->add(FormularisRespostesPeer::IDFORMULARIS, $this->getIdformularis());
        $C->addDescendingOrderByColumn(FormularisRespostesPeer::IDFORMULARISRESPOSTES);
        
        return FormularisPeer::doSelect($C);
        
    }

} // FormularisRespostes
