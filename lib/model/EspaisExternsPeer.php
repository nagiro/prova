<?php

require 'lib/model/om/BaseEspaisExternsPeer.php';


/**
 * Skeleton subclass for performing query and update operations on the 'espais_externs' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 02/25/11 13:45:05
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class EspaisExternsPeer extends BaseEspaisExternsPeer 
{

  static public function initialize( $idEE , $idP = -1 , $Nom = "n/d" )
  {
    $OEE = self::retrieveByPK($idEE);            
    if(!($OEE instanceof EspaisExterns)):                    	
    	$OEE = new EspaisExterns();
        $OEE->setPoble($idP);
        $OEE->setNom($Nom);
        $OEE->setAdreca("");
        $OEE->setContacte("");                                             	
    endif; 
    return new EspaisExternsForm($OEE);
  }
   
  static public function getCriteriaActiu( $C )
  {    
    $C->add(self::ACTIU, true);    
    return $C;
  }

  static public function criteriaHorari_EspaiExtern( $idH , $C , $idS )
  {
        //Agafem la relaci� amb un horari que t� un espai extern.        
        $C = HorarisespaisPeer::getCriteriaActiu( $C , $idS );
        $C = EspaisExternsPeer::getCriteriaActiu( $C , $idS );        
        $C->add( HorarisespaisPeer::HORARIS_HORARISID , $idH );
        $C->add( HorarisespaisPeer::ESPAIS_ESPAIID , null );
        $C->addJoin( HorarisespaisPeer::IDESPAIEXTERN, EspaisExternsPeer::IDESPAIEXTERN);
        return EspaisExternsPeer::doSelect($C);                    
  }

} // EspaisExternsPeer