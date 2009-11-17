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
}
