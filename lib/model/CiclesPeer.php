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
	
  static public function getSelect()
  {
    
    $cicles = self::doSelect(new Criteria());
    $ret = array();
    foreach($cicles as $C)
    {
      $ret[$C->getCicleid()] = $C->getNom();
    }
    return $ret;
        
  }
    
  static public function initialize($idC)
  {
  	$OC = self::retrieveByPK($idC);
  	if($OC instanceof Cicles):
  		return new CiclesForm($OC);
  	else: 
  		$OC = new Cicles();
  		return new CiclesForm($OC);
  	endif; 
  	
  }
  
  static public function getList($PAGE = 1)
  {
	if($PAGE == 1){  $limit_inf = 0; $limit_sup = 9; }     
	else { $limit_inf = (($PAGE-1)*10); $limit_sup = (($PAGE)*10)-1; }
  	
  	$connection = Propel::getConnection();
	$query = 'SELECT c.CicleID, c.Nom, c.extingit, count(*) as c FROM (cicles c INNER JOIN (activitats a INNER JOIN horaris h ON a.ActivitatID = h.Activitats_ActivitatID ) ON c.CicleID = a.Cicles_CicleID) group by c.CicleID, c.Nom, c.extingit ORDER BY c.extingit Asc, h.Dia Desc LIMIT '.$limit_inf.','.$limit_sup;		
	$statement = $connection->prepare($query); $statement->execute();
	$rs = $statement->fetchAll();
	
	$query = 'SELECT c.CicleID, min(h.Dia) as d FROM (cicles c INNER JOIN (activitats a INNER JOIN horaris h ON a.ActivitatID = h.Activitats_ActivitatID ) ON c.CicleID = a.Cicles_CicleID) group by c.CicleID ORDER BY c.extingit Asc, h.Dia Desc LIMIT '.$limit_inf.','.$limit_sup;		
	$statement = $connection->prepare($query); $statement->execute();
	$rs2 = $statement->fetchAll();
		
	$RET = array();			
	foreach($rs as $k=>$r){
			
		list($year,$month,$day) = explode('-',$rs2[$k]['d']);
		$RET[$r['CicleID']]['DIA'] = mktime(0,0,0,$month,$day,$year);
		$RET[$r['CicleID']]['ACTIVITATS'] = $r['c'];
		$RET[$r['CicleID']]['EXTINGIT'] = $r['extingit'];
		$RET[$r['CicleID']]['TITOL'] = $r['Nom'];		
		
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
