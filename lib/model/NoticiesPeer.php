<?php

class NoticiesPeer extends BaseNoticiesPeer
{
	
	static public function migraNoticiesActivitats()
	{
		
		$data = date('Y-m-d',mktime(0,0,0,date('m',time()),date('d',time()),date('Y',time())));
		$dataf = date('Y-m-d',mktime(0,0,0,date('m',time()),date('d',time())+7,date('Y',time())));		
		
		echo $dataf;
		
		$C = new Criteria();
		$C->addJoin(ActivitatsPeer::ACTIVITATID, HorarisPeer::ACTIVITATS_ACTIVITATID);
		$C->add(HorarisPeer::DIA , $dataf , CRITERIA::LESS_EQUAL);
		$C->add(HorarisPeer::DIA , $data  , CRITERIA::GREATER_EQUAL);
		$RS = ActivitatsPeer::doSelect($C);		
				
		foreach($RS as $K=>$OO):			
			$OO2 = new Noticies();
			$OO2->setTitolnoticia($OO->getTMig());
			$OO2->setTextnoticia($OO->getDMig());
			$OO2->setDatapublicacio($data);
			$OO2->setActiva(1);
			$OO2->setImatge($OO->getImatge());
			$OO2->setAdjunt($OO->getPdf());
			$OO2->setIdActivitat($OO->getActivitatid());
			$OO2->setDataDesaparicio($dataf);
			$OO2->save();		
		endforeach;
		
	}
	
	static public function netejaNoticies()
	{
		
		$C = new Criteria();
		$C->add(self::DATADESAPARICIO,date('Y-m-d',time()),CRITERIA::LESS_THAN);
		
		foreach(self::doSelect($C) as $OON):
			$OON->delete();
		endforeach;
		
	}
	
	static public function getNoticies($TEXT = "", $PAGINA = 1, $filtreWEB = false)
	{
		
		//Agafem totes les notícies de notícies i les activitats que hem posat que es publiquen com a notícies		
		$C = new Criteria();
		$C->addDescendingOrderByColumn(self::DATAPUBLICACIO);
				
		//Només les notícies amb el text oportú.
		if(!empty($TEXT)): 
			$C1 = $C->getNewCriterion(self::TITOLNOTICIA, "%$TEXT%", CRITERIA::LIKE);
			$C2 = $C->getNewCriterion(self::TEXTNOTICIA , "%$TEXT%" , CRITERIA::LIKE);
			$C1->addOr($C2); $C->add($C1);			
		endif;

		//Hem d'estar en el període de publicació.
		if($filtreWEB):
			$C->add( self::DATADESAPARICIO , date('Y-m-d',time()) , CRITERIA::GREATER_EQUAL );
			$C->add( self::DATAPUBLICACIO  , date('Y-m-d',time()) , CRITERIA::LESS_EQUAL );
			$C->add( self::ACTIVA, true);
		endif;				
				
		$pager = new sfPropelPager('Noticies', 3);
	 	$pager->setCriteria($C);
	 	$pager->setPage($PAGINA);
	 	$pager->init();
	 	return $pager;
		
	}
	
	static public function addNoticiesActivitat(Activitats $A)
	{
		
		//Mirem si ja existeix la notícia relacionada amb l'activitat i la lliguem
		$C = new Criteria();
		$C->add(NoticiesPeer::IDACTIVITAT,$A->getActivitatid());
		$N = NoticiesPeer::doSelectOne($C);
		if(!($N instanceof Noticies)) $N = new Noticies();
				
		$N->setTitolnoticia($A->getTnoticia());
		$N->setTextnoticia('El text relacionat correspon a al de l\'activitat');
		$N->setIdactivitat($A->getActivitatid());
		$N->setDatapublicacio($A->get7DiesAbansData());
		$N->setDatadesaparicio($A->getPrimeraData());
		$N->setActiva(true);
		$N->setImatge($A->getImatge());
		$N->setAdjunt($A->getPdf());
				
		$N->save();
		
	}
	
}
