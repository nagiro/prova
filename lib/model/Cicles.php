<?php

/**
 * Subclass for representing a row from the 'cicles' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Cicles extends BaseCicles
{

    /**
     * Si el cicle està actiu, l'inactivo i sinó al revés.
     * */
    public function doActivaInactiva()
    {
        if($this->getExtingit()) $this->setExtingit(false);
        else $this->setExtingit(true);
    }    

    public function getPrimeraActivitat()
    {
        $C = new Criteria();        
        $C = CiclesPeer::getCriteriaActiu($C,$this->getSiteId());
        $C = ActivitatsPeer::getCriteriaActiu($C,$this->getSiteId());
        $C = HorarisPeer::getCriteriaActiu($C,$this->getSiteId());
        
        $C->add(CiclesPeer::CICLEID, $this->getCicleid());
        
        $C->addJoin(CiclesPeer::CICLEID, ActivitatsPeer::CICLES_CICLEID);
        $C->addJoin(ActivitatsPeer::ACTIVITATID, HorarisPeer::ACTIVITATS_ACTIVITATID);
        $C->addAscendingOrderByColumn(HorarisPeer::DIA);                
                        
        $OA = ActivitatsPeer::doSelectOne($C);
        if($OA instanceof Activitats) return $OA;
        else return null;
                
    }
    
    public function getUltimaActivitat()
    {
        $C = new Criteria();        
        $C = CiclesPeer::getCriteriaActiu($C,$this->getSiteId());
        $C = ActivitatsPeer::getCriteriaActiu($C,$this->getSiteId());
        $C = HorarisPeer::getCriteriaActiu($C,$this->getSiteId());
        
        $C->add(CiclesPeer::CICLEID, $this->getCicleid());
        
        $C->addJoin(CiclesPeer::CICLEID, ActivitatsPeer::CICLES_CICLEID);
        $C->addJoin(ActivitatsPeer::ACTIVITATID, HorarisPeer::ACTIVITATS_ACTIVITATID);
        $C->addDescendingOrderByColumn(HorarisPeer::DIA);                
                        
        $OA = ActivitatsPeer::doSelectOne($C);
        if($OA instanceof Activitats) return $OA;
        else return null;
                
    }
    
    
    public function getPrimerDia()
    {
        $C = new Criteria();        
        $C = CiclesPeer::getCriteriaActiu($C,$this->getSiteId());
        $C = ActivitatsPeer::getCriteriaActiu($C,$this->getSiteId());
        $C = HorarisPeer::getCriteriaActiu($C,$this->getSiteId());
        
        $C->add(CiclesPeer::CICLEID, $this->getCicleid());
        
        $C->addJoin(CiclesPeer::CICLEID, ActivitatsPeer::CICLES_CICLEID);
        $C->addJoin(ActivitatsPeer::ACTIVITATID, HorarisPeer::ACTIVITATS_ACTIVITATID);
        $C->addAscendingOrderByColumn(HorarisPeer::DIA);                
                        
        $OH = HorarisPeer::doSelectOne($C);
        if($OH instanceof Horaris) return $OH->getDia('d/m/Y');
        else return "n/d";
                
    }
    
    public function getNumActivitats()
    {
        $C = new Criteria();
        $C = CiclesPeer::getCriteriaActiu($C,$this->getSiteId());
        $C = ActivitatsPeer::getCriteriaActiu($C,$this->getSiteId());
        $C = HorarisPeer::getCriteriaActiu($C,$this->getSiteId());
                 
        $C->addJoin(CiclesPeer::CICLEID, ActivitatsPeer::CICLES_CICLEID);
        $C->addJoin(ActivitatsPeer::ACTIVITATID, HorarisPeer::ACTIVITATS_ACTIVITATID);
        
        $C->add(CiclesPeer::CICLEID, $this->getCicleid());
        
        $C->addAscendingOrderByColumn(HorarisPeer::DIA);
        $C->addGroupByColumn(ActivitatsPeer::ACTIVITATID);
        return HorarisPeer::doCount($C);        
    }
    
    public function getNomForUrl()
    {
        $nom = $this->getTmig();
        return myUser::text2url($nom);        
    }
    
    
    
}
