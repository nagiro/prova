<?php

class NoticiesPeer extends BaseNoticiesPeer
{
	static public function getNoticies($TEXT = "", $PAGINA = 1)
	{
		$C = new Criteria();
		$C->addDescendingOrderByColumn(self::DATAPUBLICACIO);
		
		if(!empty($TEXT)): 
			$C1 = $C->getNewCriterion(self::TITOLNOTICIA, "%$TEXT%", CRITERIA::LIKE);
			$C2 = $C->getNewCriterion(self::TEXTNOTICIA , "%$TEXT%" , CRITERIA::LIKE);
			$C1->addOr($C2); $C->add($C1);			
		endif; 
				
		$pager = new sfPropelPager('Noticies', 20);
	 	$pager->setCriteria($C);
	 	$pager->setPage($PAGINA);
	 	$pager->init();
	 	return $pager;
		
	}
}
