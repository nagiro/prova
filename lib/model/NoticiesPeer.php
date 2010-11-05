<?php

class NoticiesPeer extends BaseNoticiesPeer
{
	
    static public function getCriteriaActiu($C,$idS)
    {
        $C->add(self::ACTIU, true);
        $C->add(self::SITE_ID, $idS);
        return $C;
    }
        
  	static public function initialize( $idN , $idS )
	{	   
		$ON = NoticiesPeer::retrieveByPK($idN);            
		if(!($ON instanceof Noticies)):            			
			$ON = new Noticies();
            $ON->setDatapublicacio(date('Y-m-d',time()));
			$ON->setDatadesaparicio(date('Y-m-d',time()));
            $ON->setSiteId($idS);        
            $ON->setActiu(true);        						
		endif; 
        
        return new NoticiesForm($ON,array('IDS'=>$idS));
	}

    
	static public function getNoticies($TEXT = "", $PAGINA = 1, $filtreWEB = false, $totes = false , $idS )
	{
		
		//Agafem totes les notícies de notícies i les activitats que hem posat que es publiquen com a notícies		
		$C = new Criteria();
        $C = self::getCriteriaActiu( $C , $idS );
						
		//Només les notícies amb el text oportú.
		if(!empty($TEXT)): 
			$C1 = $C->getNewCriterion(self::TITOLNOTICIA, "%$TEXT%", CRITERIA::LIKE);
			$C2 = $C->getNewCriterion(self::TEXTNOTICIA , "%$TEXT%" , CRITERIA::LIKE);
			$C1->addOr($C2); $C->add($C1);			
		endif;

        if(!$totes):
			$C->add( self::DATAPUBLICACIO  , date('Y-m-d',time()) , CRITERIA::LESS_EQUAL );
            $C->add( self::DATADESAPARICIO , date('Y-m-d',time()) , CRITERIA::GREATER_EQUAL );
		endif;
        
       	if($filtreWEB && !$totes):
			$C->add(self::ACTIVA, true);
		endif; 				        

        if(!$totes):
            $C->addAscendingOrderByColumn(self::ORDRE);
            $C->addAscendingOrderByColumn(self::DATAPUBLICACIO);
        else: 
            $C->addDescendingOrderByColumn(self::DATAPUBLICACIO);
        endif;                  			        
            
		$pager = new sfPropelPager('Noticies', 20);
	 	$pager->setCriteria($C);
	 	$pager->setPage($PAGINA);
	 	$pager->init();
	 	return $pager;
		
	}
	
	static public function getNoticia( $idN , $idS )
	{
		$FON = self::initialize($idN,$idS);
        return $FON->getObject();		
	}
	
	
	static public function getNoticiaActivitat( $IDA , $idS )
	{	   		        						
		$OA = ActivitatsPeer::retrieveByPK($IDA);	
		$OH = ActivitatsPeer::getPrimerHorariActivitat($IDA,$idS);
		if($OH instanceof Horaris):											
			list($Y,$M,$D) = explode('-',$OH->getDia());
		else: 
			$D = date('d',time());
			$M = date('m',time());
			$Y = date('Y',time());
		endif; 
		
		$diai = mktime(0,0,0,$M,$D-10,$Y);
		$diaf = mktime(0,0,0,$M,$D,$Y);
							
        $FN = NoticiesPeer::initialize(0,$idS);
        $ON = $FN->getObject();
        
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
	}	
    
    static public function selectOrdre($idS)
    {
        //Només podem ordenar aquells que la data de fi de publicació és superior a la actual.  
        $RET = array();
        $C = new Criteria();
        $C = self::getCriteriaActiu( $C , $idS );        
        $C->add(self::DATADESAPARICIO, date('Y-m-d',time()) , CRITERIA::GREATER_EQUAL );        
        $TOP = self::doCount($C);
        
        for($i = 1; $i <= $TOP+1; $i++) $RET[$i] = $i;
        
        return $RET;            
    }
    
}
