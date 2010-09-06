<?php

/**
 * Subclass for performing query and update operations on the 'activitats' table.
 *
 * 
 *
 * @package lib.model
 */ 
class ActivitatsPeer extends BaseActivitatsPeer
{
   //Retorna quantes activitats hi ha avui
   static function QuantesAvui()
   {     
     $H = new Horaris();
     $C = new Criteria();
     $C->add(HorarisPeer::DIA,date('Y-m-d',time()));          
     return HorarisPeer::doCount($C);
   }
   
   static function getNoticies()
   {
      $C = new Criteria();
      $C->add(self::PUBLICAWEB , true);
      $C->addDescendingOrderByColumn(self::ACTIVITATID);      
      return self::doSelect($C);
   }

   
   static function getActivitatsDia($dia,$page = 1)
   {

      $C = new Criteria();
      $C->addJoin(self::ACTIVITATID, HorarisPeer::ACTIVITATS_ACTIVITATID);
      $C->add(HorarisPeer::DIA, $dia);
      $C->add(self::TMIG, '', CRITERIA::NOT_EQUAL);
      $C->add(self::PUBLICAWEB,1);
      $C->addAscendingOrderByColumn(HorarisPeer::HORAINICI);
                
      $pager = new sfPropelPager('Horaris', 20);
	  $pager->setCriteria($C);
      $pager->setPage($page);
      $pager->init();    	
            
      return $pager; 
   }

   static function getActivitatsCerca( $text , $data , $page = 1 )
   {
   	  $di = mktime(0,0,0,date('m',$data),1,date('Y',$data));            
	  $df = mktime(0,0,0,date('m',$data)+1,1,date('Y',$data));
	  
	  $C = HorarisPeer::cercaCriteria(null,$text,$di,$df,null);	  
      $C->add(self::TMIG, '', CRITERIA::NOT_EQUAL);
      $C->add(self::PUBLICAWEB,1);      
      $C->addDescendingOrderByColumn(HorarisPeer::DIA);
      $C->addGroupByColumn(self::ACTIVITATID);      
                
      $pager = new sfPropelPager('Horaris', 20);
	  $pager->setCriteria($C);
      $pager->setPage($page);
      $pager->init();    	
            
      return $pager; 
   }
   
   
   static function getActivitatsDia2($dia)
   {
      $RET = array();

      $SQL = "
            SELECT A.* , E.*, H.*
              FROM espais E, horarisespais HE, horaris H, activitats A 
             WHERE H.Activitats_ActivitatID = A.ActivitatID 
                  AND H.HorarisID = HE.Horaris_HorarisID 
                  AND HE.Espais_EspaiID = E.EspaiID                  
                  AND H.Dia = '$dia'
                  AND A.tMig <> '' ";
      
     $con = Propel::getConnection(); $stmt = $con->prepare($SQL); $stmt->execute();     
	 
     while($rs = $stmt->fetch(PDO::FETCH_OBJ)): 
     
         $RET[$rs->ActivitatID]['DADES']['ID'] = $rs->ActivitatID; 
         $RET[$rs->ActivitatID]['DADES']['TITOL'] = $rs->tMig;
         $RET[$rs->ActivitatID]['DADES']['TEXT'] = $rs->dMig;
         $RET[$rs->ActivitatID]['DADES']['IMATGE'] = $rs->Imatge;
         $RET[$rs->ActivitatID]['DADES']['PDF'] = $rs->PDF;
         
         $RET[$rs->ActivitatID]['HORARIS'][$rs->HorarisID]['ESPAIS'][] = $rs->Nom;
         $RET[$rs->ActivitatID]['HORARIS'][$rs->HorarisID]['HORAI'] = $rs->HoraInici;
         $RET[$rs->ActivitatID]['HORARIS'][$rs->HorarisID]['HORAF'] = $rs->HoraFi;
         
      endwhile;
          
      return $RET; 
   }
   
   static function getSelectEstats()
   {
   		return array(1=>'Acceptada',2=>'PreReserva');
   }
   
	static public function getTipusEnviaments()
	{
		return array(1=>'El primer dia',2=>'Una setmana abans',3=>'Cada dia d\'activitat');
	}
	
	static public function getTipusEnviamentsSelect()
	{
		return self::getTipusEnviaments();
	}
	
	static public function getTipusEnviamentsSelectValidator()
	{
		$RET = array();
		foreach(self::getTipusEnviaments() as $K=>$V):
		
			$RET[$K] = $K;
		
		endforeach;
		
		return $RET;
	}
	
	static public function initilize($idA , $cicle = 0)
	{
		$OA = ActivitatsPeer::retrieveByPK($idA);
		if($OA instanceof Activitats):
			return new ActivitatsForm($OA);
		else:
			$OA = new Activitats();
			if($cicle > 0):
				$OA->setCiclesCicleid($cicle);
			else:
				$OA->setCiclesCicleid(null);
			endif;
			return new ActivitatsForm($OA);			
		endif; 
	}
	
	static public function getActivitatsCicles($idC, $pager = false, $pagina = 1)
	{
		$C = new Criteria();
		$C->add(self::CICLES_CICLEID,$idC);
        $C->add(self::PUBLICAWEB, true);        
		
		if($pager):
			$pager = new sfPropelPager('Activitats', 20);
			$pager->setCriteria($C);
			$pager->setPage($pagina);
			$pager->init();    		            
			return $pager;
		else: 
			return self::doSelect($C);
		endif; 
		
		
	}
   	
			
	static public function selectCategories($web = false)
	{
		$CAT = array();
		if($web):

			$CAT['cap'] = 'Contingut manual';
		
			$CAT['exposicions-general'] = 'Exposicions i arts visuals - General';
			$CAT['exposicions-historic'] = 'Exposicions i arts visuals - Històric';
			$CAT['exposicions-actual'] = 'Exposicions i arts visuals - Actual';
			
			$CAT['musica-general'] = 'Música i audiovisuals - General';
			$CAT['musica-historic'] = 'Música i audiovisuals - Històric';
			$CAT['musica-actual'] = 'Música i audiovisuals - Actual';
						
			$CAT['esceniques-general'] = 'Arts escèniques i cinema - General';
			$CAT['esceniques-historic'] = 'Arts escèniques i cinema - Històric';
			$CAT['esceniques-actual'] = 'Arts escèniques i cinema - Actual';
						
			$CAT['ciencia-general'] = 'Ciència i humanitats - General';
			$CAT['ciencia-historic'] = 'Ciència i humanitats - Històric';
			$CAT['ciencia-actual'] = 'Ciència i humanitats - Actual';
						
			$CAT['cursos-general'] = 'Cursos - General';
			$CAT['cursos-historic'] = 'Cursos - Historic';
			$CAT['cursos-actual'] = 'Cursos - Actual';
						
			$CAT['altres-general'] = 'Altres - General';
			$CAT['altres-historic'] = 'Altres - Historic ';
			$CAT['altres-actual'] = 'Altres - Actual';
			
		else:
		
			$CAT['exposicions'] = 'Exposicions i arts visuals';
			$CAT['musica'] = 'Música i audiovisuals';
			$CAT['esceniques'] = 'Arts escèniques i cinema';
			$CAT['ciencia'] = 'Ciència i humanitats';
			$CAT['cursos'] = 'Cursos';
			$CAT['altres'] = 'Altres';
			
		endif;		
		
		return $CAT;
	}

	/**
	 * Agafem les activitats d'un tipus del menú i d'un mode determinat i les mostrem ordenades per categoria i dia. 
	 *
	 * @param unknown_type $cat
	 * @param unknown_type $mode
	 * @param unknown_type $idC
	 */
	static public function getActsCategoria($cat,$page = 1, $idC = 0)
	{		
		
		$C = new Criteria();
		
		list($nom,$mode) = explode("-",$cat);
		
		$C->add(self::CATEGORIES,'%'.$cat.'%',CRITERIA::LIKE);	
		$C->addJoin(self::ACTIVITATID, HorarisPeer::ACTIVITATS_ACTIVITATID);
		$C->addJoin(self::CICLES_CICLEID,CiclesPeer::CICLEID);
		
		if($mode == 'historic'):
			$C->add(HorarisPeer::DIA, date('Y-m-d',time()), CRITERIA::LESS_THAN);
			$C->addDescendingOrderByColumn(HorarisPeer::DIA);
		endif;
		 
		if($mode == 'actual'):
			$C->add(HorarisPeer::DIA, date('Y-m-d',time()), CRITERIA::GREATER_EQUAL);
			$C->addAscendingOrderByColumn(HorarisPeer::DIA);
		endif; 
				
		if($idC > 0) $C->add(self::CICLES_CICLEID,$idC);		
		
		$pager = new sfPropelPager('Horaris', 20);
    	$pager->setCriteria($C);
    	$pager->setPage($page);
    	$pager->init();    	
			    	
		return $pager;
				
	}
	
	/**
	 * Agafem els cicles que afecten aquesta categoria i la resta d'activitats que no pertanyen a cap cicle.  
	 *
	 * @param unknown_type $cat
	 * @param unknown_type $mode
	 * @param unknown_type $idC
	 */	
	
	static public function selectCicleCategoriaActivitat($cat,$idC = 0)
	{
		
		$C = new Criteria();
		
		list($nom,$mode) = explode("-",$cat);
		
		$C->add(self::CATEGORIES,'%'.$nom.'%',CRITERIA::LIKE);	
		$C->addJoin(self::ACTIVITATID, HorarisPeer::ACTIVITATS_ACTIVITATID);
		$C->addJoin(self::CICLES_CICLEID,CiclesPeer::CICLEID);
		
		if($mode == 'historic'):
			$C->add(HorarisPeer::DIA, date('Y-m-d',time()), CRITERIA::LESS_THAN);
			$C->addDescendingOrderByColumn(HorarisPeer::DIA);
		endif;
		 
		if($mode == 'actual'):
			$C->add(HorarisPeer::DIA, date('Y-m-d',time()), CRITERIA::GREATER_EQUAL);
			$C->addAscendingOrderByColumn(HorarisPeer::DIA);
		endif; 			

		if($idC > 0 ) $C->add(self::CICLES_CICLEID, $idC);
		
		$C->addGroupByColumn(CiclesPeer::CICLEID);
		
		return $C;
		
	}
	
	static public function getCiclesCategoria($cat,$page = 1)
	{		
		
		$C = self::selectCicleCategoriaActivitat($cat,0);
        $C->add(self::CICLES_CICLEID, 1, CRITERIA::GREATER_THAN);
				
		$pager = new sfPropelPager('Cicles', 20);
    	$pager->setCriteria($C);
    	$pager->setPage($page);
    	$pager->init();    	    	
    	
		return $pager;
				
	}
	
	static public function countActivitatsCiclesCategoria( $cat , $idC = 0 )
	{		
		
		$C = self::selectCicleCategoriaActivitat($cat,$idC);
				
		return self::doCount($C);
								
	}
	
	static public function getPrimerHorariActivitat($IDA)
	{
		$C = new Criteria();
		$C->add(HorarisPeer::ACTIVITATS_ACTIVITATID, $IDA);
		$C->addAscendingOrderByColumn(HorarisPeer::DIA);
		
		$OH = HorarisPeer::doSelectOne($C);
		if($OH instanceof Horaris):
			return $OH; 
		else: 
			return null;
		endif; 
	}
    
    static public function getDiesAmbActivitatsMes($DATACAL)
    {
        $dia_inicial = mktime(0,0,0,date('m',$DATACAL),1,date('Y',$DATACAL));
        $dia_final   = mktime(0,0,0,date('m',$DATACAL)+1,1,date('Y',$DATACAL));
        
        $C = new Criteria();
        $C->add(ActivitatsPeer::PUBLICAWEB, true);
        $C->addJoin(HorarisPeer::ACTIVITATS_ACTIVITATID, ActivitatsPeer::ACTIVITATID);
        $C->add(HorarisPeer::DIA, $dia_inicial, CRITERIA::GREATER_EQUAL);
        $C->add(HorarisPeer::DIA, $dia_final, CRITERIA::LESS_EQUAL);
        
        $RET = array();
        
        foreach(HorarisPeer::doSelect($C) as $OH):
            $RET[$OH->getDia()] = $OH->getDia();
        endforeach;
        
        return $RET;
    }

}
