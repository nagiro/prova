<?php

require 'lib/model/om/BaseEntradesPreus.php';


/**
 * Skeleton subclass for representing a row from the 'entrades_preus' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 11/03/11 11:52:23
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class EntradesPreus extends BaseEntradesPreus {


	/**
	 * Initializes internal state of EntradesPreus object.
	 * @see        parent::__construct()
	 */
	public function __construct()
	{
		// Make sure that parent constructor is always invoked, since that
		// is where any default values for this object are set.
		parent::__construct();
	}

    /**
     * Ens informa si hi ha l'opció llista d'espera o no.
     **/
    public function hasLlistaEspera()
    {
        $A = $this->getPagamentExternArray();        
        return ( array_search( TipusPeer::PAGAMENT_LLISTA_ESPERA , $A ) > 0 );        
    }

    public function getDescomptesArrayStrings()
    {
        $RET = array();
        $AD = DescomptesPeer::getArrayDescomptesAmbPreu( $this->getPreu() , $this->getSiteId() );
        foreach( $this->getDescomptesArray() as $idT ):
            $RET[ $idT ] = $AD[$idT];            
        endforeach;
        
        return $RET;            
    }
    
    public function getPagamentExternSelect()
    {
        $RET = array();
        $A = $this->getPagamentExternArray();        
        $A2 = TipusPeer::getTipusPagamentArray();
                                        
        foreach($A as $E):                                            
            $RET[$E] = $A2[$E];            
        endforeach;                
                
        if( $this->getIsPle() && $this->hasLlistaEspera() ):
            $RET = array();
            $RET[TipusPeer::PAGAMENT_LLISTA_ESPERA] = $A2[TipusPeer::PAGAMENT_LLISTA_ESPERA]; 
        elseif( !$this->getIsPle() ):
            unset($RET[TipusPeer::PAGAMENT_LLISTA_ESPERA]);
        endif;
        
        return $RET;
    }
    

    public function getDescomptesArray()
    {
        return explode('@',$this->getDescomptes());                
    }
    
    public function getPagamentInternArray()
    {
        return explode('@',$this->getPagamentintern());                
    }
    
    public function getPagamentExternArray()
    {
        return explode('@',$this->getPagamentextern());                
    }
    
    public function setPagamentInternArray($array)
    {
        $this->setPagamentintern(implode("@",$array));                
    }
    
    public function setPagamentExternArray($array)
    {
        $this->setPagamentextern(implode("@",$array));                
    }

    public function setDescomptesString($array)
    {
        $this->setDescomptes(implode("@",$array));
    }


    public function countEntradesVenudes(){
        
        $C = new Criteria();
        $C->add( EntradesReservaPeer::ENTRADES_PREUS_HORARI_ID      , $this->getHorariid() );
        $C->add( EntradesReservaPeer::ENTRADES_PREUS_ACTIVITAT_ID   , $this->getActivitatid() );
        $C = EntradesReservaPeer::criteriaEntradesOK( $C );                
        $RES = 0;
        
        foreach( EntradesReservaPeer::doSelect( $C ) as $OER ):            
            $RES += $OER->getQuantitat();
        endforeach;
                
        return $RES;
    }
    
    /**
     * Ens indica si en una entrada determinada ja estan les reserves exhaurides
     * */
    public function getIsPle(){        
        return ($this->countEntradesVenudes() >= $this->getPlaces()); 
    }

    public function getActivitat(){        
        return ActivitatsPeer::retrieveByPK($this->getActivitatId());
    }

    public function getHorari(){        
        return HorarisPeer::retrieveByPK($this->getHorariId());
    }    


} // EntradesPreus
