<?php

/**
 * Subclass for performing query and update operations on the 'cicles' table.
 *
 * 
 *
 * @package lib.model
 */ 
class CiclesPeer extends BaseCiclesPeer
{

   const NO_PERTANY_A_CAP_CICLE = 1;

   static public function getCriteriaActiu( $C , $idS )
   {
    $C->add(self::ACTIU, true);
    $C->add(self::SITE_ID, $idS);
    return $C;
   }	
    
  static public function getSelect($idS)
  {
    $C = new Criteria();
    $C = self::getCriteriaActiu($C,$idS);
        
    $ret = array();    
    foreach(self::doSelect($C) as $C) $ret[$C->getCicleid()] = $C->getNom();
    
    return $ret;
        
  }
    
  static public function initialize($idC,$idS)
  {
  	$OC = self::retrieveByPK($idC);
  	if($OC instanceof Cicles):
  		return new CiclesForm($OC);
  	else: 
  		$OC = new Cicles();
        $OC->setActiu(true);
        $OC->setSiteId($idS);
  		return new CiclesForm($OC);
  	endif; 
  	
  }
  
  static public function getList($PAGE = 1 , $CERCA = "" , $idS )
  {
    
    $RET = array();

	if($PAGE == 1){  $limit_inf = 0; $limit_sup = 9; }
    elseif($PAGE > 1) { $limit_inf = (($PAGE-1)*10); $limit_sup = (($PAGE)*10)-1; }
    else { $limit_inf = 0; $limit_sup = 9; }
    
    //Agafo els 10 primers cicles ordenats per ordre d'entrada.
    $C = new Criteria();
    $C = self::getCriteriaActiu( $C , $idS );    
    if(!empty($CERCA)) $C->add(self::NOM,'%'.$CERCA.'%',CRITERIA::LIKE);
    $C->addDescendingOrderByColumn(self::CICLEID);
    
    $i = 0;
	foreach(self::doSelect($C) as $C){

        if($limit_inf <= $i || $limit_sup > $i++):              			    		
       		$RET[$C->getCicleid()]['EXTINGIT'] = $C->getExtingit();
       		$RET[$C->getCicleid()]['TITOL'] = $C->getNom();                           		
            $RET[$C->getCicleid()]['ACTIVITATS'] = $C->getNumActivitats();
            $RET[$C->getCicleid()]['DIA'] = $C->getPrimerDia();
        endif; 
    	
	}
    
    return $RET;
  }
  
  static public function getDataPrimeraActivitat($idC)
  {
  	$C = new Criteria();
  	$C->addJoin(ActivitatsPeer::ACTIVITATID, HorarisPeer::ACTIVITATS_ACTIVITATID);
  	$C->add(ActivitatsPeer::CICLES_CICLEID,$idC);
  	$C->addAscendingOrderByColumn(HorarisPeer::DIA);
  	
  	$OH = HorarisPeer::doSelectOne($C);
  	
  	if($OH instanceof Horaris) return $OH->getDia('d/m/Y'); 
  	else return 'n/d';
  	
  }
  
  static public function getDataUltimaActivitat($idC)
  {
  	$C = new Criteria();
  	$C->addJoin(ActivitatsPeer::ACTIVITATID, HorarisPeer::ACTIVITATS_ACTIVITATID);
  	$C->add(ActivitatsPeer::CICLES_CICLEID,$idC);
  	$C->addDescendingOrderByColumn(HorarisPeer::DIA);
  	
  	$OH = HorarisPeer::doSelectOne($C);
  	
  	if($OH instanceof Horaris) return $OH->getDia('d/m/Y'); 
  	else return 'n/d';
  	
  }

  static public function getActivitatsCicle($idC)
  {
  	$C = new Criteria();  	
  	$C->add(ActivitatsPeer::CICLES_CICLEID,$idC);
  	$C->addGroupByColumn(ActivitatsPeer::ACTIVITATID);
  	
  	return ActivitatsPeer::doCount($C);
  	
  }  

  static public function getActivitatsCicleList($idC)
  {
  	$C = new Criteria();  	
  	$C->add(ActivitatsPeer::CICLES_CICLEID,$idC);
  	$C->addGroupByColumn(ActivitatsPeer::ACTIVITATID);
  	
  	return ActivitatsPeer::doSelect($C);
  	
  }  

  
}
