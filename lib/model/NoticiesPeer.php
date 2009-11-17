<?php

class NoticiesPeer extends BaseNoticiesPeer
{
	static public function getNoticies($TEXT = "", $PAGINA = 1, $filtreWEB = false)
	{
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
				
		$pager = new sfPropelPager('Noticies', 20);
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
