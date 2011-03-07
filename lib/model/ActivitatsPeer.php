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

   const ESTAT_ACTIVITAT_ACCEPTADA = 1;
   const ESTAT_ACTIVITAT_PRERESERVA = 2; 
    
   static public function getCriteriaActiu($C,$idS)
   {
    $C->add(self::ACTIU, true);
    $C->add(self::SITE_ID, $idS);
    return $C;
   }

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

   
   static function getActivitatsDia( $idS , $dia , $page = 1 )
   {

      $C = new Criteria();
      $C = self::getCriteriaActiu($C,$idS);
      $C = HorarisPeer::getCriteriaActiu($C,$idS);
      
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

   static function getActivitatsCerca( $text , $data , $page = 1 , $idS )
   {
   	  $di = mktime(0,0,0,date('m',$data),1,date('Y',$data));            
	  $df = mktime(0,0,0,date('m',$data)+1,1,date('Y',$data));
	  
	  $C = HorarisPeer::cercaCriteria(null,$text,$di,$df,null,$idS);	  
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
   		return array(  self::ESTAT_ACTIVITAT_ACCEPTADA=>'Acceptada',
                       self::ESTAT_ACTIVITAT_PRERESERVA=>'PreReserva');
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
	
    static public function initializeDescription($idA,$idS)
    {
        $FA = self::initialize($idA,0,$idS);
        return new ActivitatsTextosForm($FA->getObject(),array('IDS'=>$idS));
    }
    
	static public function initialize($idA , $cicle = 0, $idS )
	{
		$OA = ActivitatsPeer::retrieveByPK($idA);            
		if(!($OA instanceof Activitats)):            			
			$OA = new Activitats();
            $OA->setSiteId($idS);        
            $OA->setActiu(true);        
			if($cicle > 0):
				$OA->setCiclesCicleid($cicle);
			else:
				$OA->setCiclesCicleid(null);
			endif;						
		endif; 
                
        return new ActivitatsForm($OA,array('IDS'=>$idS));
	}
	
	static public function getActivitatsCicles( $idC , $idS , $pager = false, $pagina = 1, $publicaweb = true)
	{
		$C = new Criteria();
        $C = self::getCriteriaActiu($C,$idS);
        
		$C->add(self::CICLES_CICLEID,$idC);
        if($publicaweb) $C->add(self::PUBLICAWEB, true);        
		
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
   	
			
	static public function selectCategories( $idS , $web = false )
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
	
	static public function selectCicleCategoriaActivitat( $idS , $cat , $idC = 0 )
	{
		
		$C = new Criteria();
        $C = self::getCriteriaActiu($C,$idS);
        $C = HorarisPeer::getCriteriaActiu($C,$idS);
        $C = CiclesPeer::getCriteriaActiu($C,$idS);
        
		
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
	
	static public function getCiclesCategoria( $idS , $cat , $page = 1 )
	{		
		
		$C = self::selectCicleCategoriaActivitat( $idS , $cat , 0 );
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
	
	static public function getPrimerHorariActivitat($IDA,$idS)
	{
		$C = new Criteria();
        $C = HorarisPeer::getCriteriaActiu($C,$idS);
        
		$C->add(HorarisPeer::ACTIVITATS_ACTIVITATID, $IDA);
		$C->addAscendingOrderByColumn(HorarisPeer::DIA);
		
		$OH = HorarisPeer::doSelectOne($C);
		if($OH instanceof Horaris):
			return $OH; 
		else: 
			return null;
		endif; 
	}
    
    static public function getDiesAmbActivitatsMes( $DATACAL , $idS )
    {
        
        $C = new Criteria();
        $C = self::getCriteriaActiu($C,$idS);
        $C = ActivitatsPeer::getCriteriaActiu($C,$idS);
        $C = HorarisPeer::getCriteriaActiu($C,$idS);
        
        $dia_inicial = mktime(0,0,0,date('m',$DATACAL),1,date('Y',$DATACAL));
        $dia_final   = mktime(0,0,0,date('m',$DATACAL)+1,1,date('Y',$DATACAL));
                
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
    
    static public function getLlistatWord( InformeActivitatsForm $IAF , $IDS )
    {                
        $C = new Criteria();
        $C = ActivitatsPeer::getCriteriaActiu($C,$IDS);
        $C = HorarisPeer::getCriteriaActiu($C,$IDS);
        
        $C->addJoin(ActivitatsPeer::ACTIVITATID, HorarisPeer::ACTIVITATS_ACTIVITATID);                        
        if($IAF->getValue('idCicle') > 0) $C->add(ActivitatsPeer::CICLES_CICLEID, $IAF->getValue('idCicle'));        
        
        $C1 = $C->getNewCriterion(HorarisPeer::DIA,$IAF->getValue('DataInici'),CRITERIA::GREATER_EQUAL);
        $C2 = $C->getNewCriterion(HorarisPeer::DIA,$IAF->getValue('DataFi'),CRITERIA::LESS_EQUAL);                
        if(!is_null($IAF->getValue('DataInici'))) $C->addAnd($C1);
        if(!is_null($IAF->getValue('DataFi'))) $C->addAnd($C2);
        $C->add(ActivitatsPeer::TMIG , "" , CRITERIA::NOT_EQUAL );
        $C->addAscendingOrderByColumn(HorarisPeer::DIA);
        $C->addGroupByColumn(ActivitatsPeer::ACTIVITATID);
        return ActivitatsPeer::doSelect($C);
    }    

  
  /**
   * ActivitatsPeer::criteriaPoblacioExternaActivitats()
   *
   * Fa la selecció de les activitats que es generen en llocs externs per dates futures
   *  
   * @param mixed $C (Criteria)
   * @return
   */
  static public function criteriaPoblacioExternaActivitats($C)
  {
    $C = new Criteria();
    $C->add(HorarisPeer::ACTIU, true);
    $C->add(HorarisespaisPeer::ACTIU, true);
    $C->add(EspaisExternsPeer::ACTIU, true);
    $C->add(ActivitatsPeer::ACTIU, true);
    $C->addJoin(HorarisEspaisPeer::HORARIS_HORARISID,HorarisPeer::HORARISID);
    $C->addJoin(EspaisExternsPeer::IDESPAIEXTERN, HorarisespaisPeer::IDESPAIEXTERN);
    $C->addJoin(ActivitatsPeer::ACTIVITATID, HorarisPeer::ACTIVITATS_ACTIVITATID);
    $C->add(ActivitatsPeer::PUBLICAWEB, true);
    $C->add(HorarisPeer::DIA, date('Y-m-d',time()),CRITERIA::GREATER_EQUAL);
    $C->addJoin(PoblacionsPeer::IDPOBLACIO, EspaisExternsPeer::POBLE);
    $C->addGroupByColumn(ActivitatsPeer::ACTIVITATID);
    $C->addGroupByColumn(EspaisExternsPeer::POBLE);
    return $C;
  }

  /**
   * ActivitatsPeer::criteriaPoblacioInternaActivitats()
   * 
   * Fa la selecció de les activitats que es generen en un site per dates futures
   * 
   * @param mixed $C (Criteria)
   * @return
   */
  static public function criteriaPoblacioInternaActivitats($C)
  {
    $C = new Criteria();
    $C->add(HorarisPeer::ACTIU, true);    
    $C->add(ActivitatsPeer::ACTIU, true);
    $C->add(SitesPeer::ACTIU, true);        
    $C->addJoin(SitesPeer::SITE_ID , HorarisPeer::SITE_ID);    
    $C->addJoin(ActivitatsPeer::ACTIVITATID, HorarisPeer::ACTIVITATS_ACTIVITATID);
    $C->add(ActivitatsPeer::PUBLICAWEB, true);
    $C->add(HorarisPeer::DIA, date('Y-m-d',time()),CRITERIA::GREATER_EQUAL);
    $C->addJoin(PoblacionsPeer::IDPOBLACIO, SitesPeer::POBLE);
    $C->addGroupByColumn(ActivitatsPeer::ACTIVITATID);
    $C->addGroupByColumn(SitesPeer::POBLE);
    return $C;
  }

  
  /**
   * ActivitatsPeer::selectPoblesActivitats()
   * 
   * Omple el llistat de select del portal hospici.   
   * 
   * @return array
   */
  static public function selectPoblesActivitats()
  {
    
    //Busquem les activitats futures que tenen una població externa.
    $C = new Criteria();
    $C = self::criteriaPoblacioExternaActivitats($C);
    
    $COUNT = array();    
    foreach(PoblacionsPeer::doSelect($C) as $OP){        
        if(!isset($COUNT[$OP->getIdpoblacio()]['COUNT'])) $COUNT[$OP->getIdpoblacio()]['COUNT'] = 0;
        $COUNT[$OP->getIdpoblacio()]['NOM'] = $OP->getNom();
        $COUNT[$OP->getIdpoblacio()]['COUNT']++;        
    }                 
    
    //Busquem les activitats futures que es fan a un SITE
    $C = new Criteria();    
    $C = self::criteriaPoblacioInternaActivitats($C);
    foreach(PoblacionsPeer::doSelect($C) as $OP){
        if(!isset($COUNT[$OP->getIdpoblacio()]['COUNT'])) $COUNT[$OP->getIdpoblacio()]['COUNT'] = 0;                        
        $COUNT[$OP->getIdpoblacio()]['NOM'] = $OP->getNom();
        $COUNT[$OP->getIdpoblacio()]['COUNT']++;        
    }         

    $FIN = array();        
    foreach($COUNT as $K=>$P){
        $FIN[$K] = $P['NOM'].' ('.$P['COUNT'].')';
    }

    return $FIN;
  }

  /**
   * ActivitatsPeer::selectCategoriesActivitats()
   * 
   * Treu el llistat de cagegories segons un poble d'entrada
   * 
   * @param mixed $idP (Identificador de poble)
   * @return array
   */
  static public function selectCategoriesActivitats($idP)
  {
    
    //Busquem les activitats futures que tenen una població externa.
    $C = new Criteria();
    $C = self::criteriaPoblacioExternaActivitats($C);
    $C->add(EspaisExternsPeer::POBLE, $idP);
    
    $COUNT = array();    
    foreach(ActivitatsPeer::doSelect($C) as $OA){        
        if(!isset($COUNT[$OA->getTipusactivitatIdtipusactivitat()]['COUNT'])){
            $COUNT[$OA->getTipusactivitatIdtipusactivitat()]['COUNT'] = 0;
            $COUNT[$OA->getTipusactivitatIdtipusactivitat()]['NOM'] = $OA->getTipusactivitat()->getNom();    
        }
        $COUNT[$OA->getTipusactivitatIdtipusactivitat()]['COUNT']++;        
    }         
    
    //Busquem les activitats futures que es fan a un SITE
    $C = new Criteria();    
    $C = self::criteriaPoblacioInternaActivitats($C);
    $C->add(SitesPeer::POBLE, $idP);
    
    foreach(ActivitatsPeer::doSelect($C) as $OA){
        if(!isset($COUNT[$OA->getTipusactivitatIdtipusactivitat()]['COUNT'])){
            $COUNT[$OA->getTipusactivitatIdtipusactivitat()]['COUNT'] = 0;
            $COUNT[$OA->getTipusactivitatIdtipusactivitat()]['NOM'] = $OA->getTipusactivitat()->getNom();    
        }
        $COUNT[$OA->getTipusactivitatIdtipusactivitat()]['COUNT']++;        
    }         

    $FIN = array();        
    foreach($COUNT as $K=>$P){
        $FIN[$K] = $P['NOM'].' ('.$P['COUNT'].')';
    }

    return $FIN;
  }


  /**
   * ActivitatsPeer::selectCategoriesActivitats()
   * 
   * @param mixed $idP
   * @return
   */
  static public function getActivitatsHospici($idPoble, $idCategoria, $idData, $aDates, $p = 1 )
  {

    switch($idData){
        case 0: 
            $datai = date('Y-m-d',time());
            $dataf = date('Y-m-d',time());
            break;
        case 1: 
            $t = time();            
            while(6 <> date('w',$t)) $t = strtotime(date("Y-m-d", $t) . "+1 day");
            $datai = date('Y-m-d',$t);                        
            while(0 <> date('w',$t)) $t = strtotime(date("Y-m-d", $t) . "+1 day");
            $dataf = date('Y-m-d',$t);
            break;
        case 2: 
            $datai = strtotime(date("Y-m-d", time()));
            $dataf = strtotime(date("Y-m-d", time()) . "+7 day");            
            break;
        case 3: 
            $datai = strtotime(date("Y-m-d", time()));
            $dataf = strtotime(date("Y-m-d", time()) . "+15 day");            
            break;
        case 4: 
            $datai = strtotime(date("Y-m-d", time()));
            $dataf = strtotime(date("Y-m-d", time()) . "+30 day");            
            break;
        case 5:
            $datai = preg_replace("/([0-9]{2})[\/|\-]([0-9]{2})[\/|\-]([0-9]{4})/","\$3-\$2-\$1",$aDates['DI']);
            $dataf = preg_replace("/([0-9]{2})[\/|\-]([0-9]{2})[\/|\-]([0-9]{4})/","\$3-\$2-\$1",$aDates['DF']);
            break;
        default:
            $datai = date('Y-m-d',time());
            $dataf = date('Y-m-d',time());
            break;                                            
    }
        

    $C = new Criteria();
            
    $C->add(HorarisPeer::ACTIU, true); //L'horari ha de ser actiu        
    $C1 = $C->getNewCriterion(HorarisPeer::DIA,$datai,CRITERIA::GREATER_EQUAL); //Entre el rang de dates
    $C2 = $C->getNewCriterion(HorarisPeer::DIA,$dataf,CRITERIA::LESS_EQUAL); 
    $C1->addAnd($C2); $C->add($C1);
        
    $C->add(ActivitatsPeer::TIPUSACTIVITAT_IDTIPUSACTIVITAT, $idCategoria); //Seleccionem el tipus d'activitat
    $C->add(ActivitatsPeer::PUBLICAWEB, 1);    
    $C->addJoin(ActivitatsPeer::ACTIVITATID, HorarisPeer::ACTIVITATS_ACTIVITATID);    

    $C->addGroupByColumn(ActivitatsPeer::ACTIVITATID);
    $C->addAscendingOrderByColumn(ActivitatsPeer::TIPUSACTIVITAT_IDTIPUSACTIVITAT);

    $C1 = clone $C;        
    $C2 = clone $C;        
     
    $C1->add(EspaisExternsPeer::POBLE, $idPoble); //Agafem també els que es fan a un poble extern
    $C1->addJoin(HorarisespaisPeer::IDESPAIEXTERN, EspaisExternsPeer::IDESPAIEXTERN ); //Vinculem amb els espais
    $C1->add(HorarisespaisPeer::ACTIU, true);    //L'activitat al poble extern ha d'estar activa
    $C1->addJoin(HorarisespaisPeer::HORARIS_HORARISID, HorarisPeer::HORARISID); //relacionem amb els horaris

    $S = 10;
    $p_max = ((($p-1)*$S)+$S);
    $p_min = (($p-1)*$S);            
        
    $RET = array(); $count= 1; 
    $RS = ActivitatsPeer::doSelect($C1);    
    foreach($RS as $OA):
        if($count <= $p_max && $count > $p_min):
            $RET[$OA->getActivitatid()] = $OA;
            $count++;
        endif;
    endforeach;            
        
    $C2->getNewCriterion(SitesPeer::ACTIU, true); //El site ha d'estar actiu'    
    $C2->getNewCriterion(SitesPeer::POBLE, $idPoble);    //Agafem els sites que estan a aquest poble
    $C2->getNewCriterion(ActivitatsPeer::SITE_ID, SitesPeer::SITE_ID); //Relacionem amb els sites    
    
    $RS2 = ActivitatsPeer::doSelect($C2);
    foreach($RS2 as $OA):
        if($count <= $p_max && $count > $p_min):
            if(!isset($RET[$OA->getActivitatid()])){
                $RET[$OA->getActivitatid()] = $OA;
                $count++;
            }
        endif;
        
    endforeach;            

    return $RET;
  }

}
