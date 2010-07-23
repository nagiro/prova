<?php

class NoticiesPeer extends BaseNoticiesPeer
{
	
	static public function getNoticies($TEXT = "", $PAGINA = 1, $filtreWEB = false)
	{
		
		//Agafem totes les notícies de notícies i les activitats que hem posat que es publiquen com a notícies		
		$C = new Criteria();
						
		//Només les notícies amb el text oportú.
		if(!empty($TEXT)): 
			$C1 = $C->getNewCriterion(self::TITOLNOTICIA, "%$TEXT%", CRITERIA::LIKE);
			$C2 = $C->getNewCriterion(self::TEXTNOTICIA , "%$TEXT%" , CRITERIA::LIKE);
			$C1->addOr($C2); $C->add($C1);			
		endif;

		//Hem d'estar en el període de publicació.
//		if($filtreWEB):			
//			$C->add( self::DATADESAPARICIO , date('Y-m-d',time()) , CRITERIA::GREATER_EQUAL );
//			$C->add( self::DATAPUBLICACIO  , date('Y-m-d',time()) , CRITERIA::LESS_EQUAL );
//			$C->add( self::ACTIVA, true);
//		else: 
			$C->add( self::DATAPUBLICACIO  , date('Y-m-d',time()) , CRITERIA::GREATER_EQUAL );
//		endif;				

//		if($filtreWEB):
//			$C->addDescendingOrderByColumn(self::DATAPUBLICACIO);
//		else: 
			$C->addAscendingOrderByColumn(self::DATAPUBLICACIO);
//		endif; 

		if($filtreWEB):
			$C->add(self::ACTIVA, true);
		endif; 
			
		$pager = new sfPropelPager('Noticies', 20);
	 	$pager->setCriteria($C);
	 	$pager->setPage($PAGINA);
	 	$pager->init();
	 	return $pager;
		
	}
	
	static public function getNoticia($idN)
	{
		
		$ON = self::retrieveByPK($idN);
		if($ON instanceof Noticies):
			return $ON; 
		else:
			return new Noticies();
		endif; 
		
	}
	
	
	static public function getNoticiaActivitat($IDA)
	{
		$C = new Criteria();
		$C->add(self::IDACTIVITAT,$IDA);
		$ON = self::retrieveByPK($IDA);
		if($ON instanceof Noticies):
			return $ON;
		else: 
			$OA = ActivitatsPeer::retrieveByPK($IDA);	
			$OH = ActivitatsPeer::getPrimerHorariActivitat($IDA);
			if($OH instanceof Horaris):											
				list($Y,$M,$D) = explode('-',$OH->getDia());
			else: 
				$D = date('d',time());
				$M = date('m',time());
				$Y = date('Y',time());
			endif; 
			
			$diai = mktime(0,0,0,$M,$D-7,$Y);
			$diaf = mktime(0,0,0,$M,$D,$Y);
						
			$ON = new Noticies();
			$ON->setImatge($OA->getImatge());
			$ON->setAdjunt($OA->getPdf());
			$ON->setTitolnoticia($OA->getTmig());
			$ON->setTextnoticia($OA->getDmig());
			$ON->setActiva(false);		
			$ON->setIdactivitat($IDA);
			$ON->setDatapublicacio(date('Y-m-d',$diai));
			$ON->setDatadesaparicio(date('Y-m-d',$diaf));
			$ON->save();		
			return $ON;
		endif; 
	}	
}
