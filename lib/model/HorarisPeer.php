<?php

/**
 * Subclass for performing query and update operations on the 'horaris' table.
 *
 * 
 *
 * @package lib.model
 */ 
class HorarisPeer extends BaseHorarisPeer
{

  const DESCRIPCIO_WEB = "WEB"; 	

  static public function getCercaWeb($DIA, $TEXT, $DATAI,$DATAF)
  {

	$C = self::cercaCriteria($DIA, $TEXT, $DATAI,$DATAF,null);

	$C->addGroupByColumn(self::HORARISID);
	
	$pager = new sfPropelPager('Horaris', 30);	
    $pager->setCriteria($C);
    $pager->setPage($page);
    $pager->init();

    return $pager;    
     
  }
  
  
  /**
   * Funció que fa la cerca pel calendari de la pàgina principal i omple l'agenda
   *
   * @param unknown_type $DIA
   * @param unknown_type $TEXT
   * @param unknown_type $DATAI
   * @param unknown_type $DATAF
   * @param unknown_type $IDACTIVITAT
   * @return unknown
   */
  static public function getCerca($DIA, $TEXT, $DATAI, $DATAF, $IDACTIVITAT)
  {
  	 //Fem la cerca
     $HORARIS = self::cerca($DIA, $TEXT, $DATAI, $DATAF, $IDACTIVITAT);
     $RET = array( 'CALENDARI'=>array() , 'ACTIVITATS' => array() );
     //Carreguem al calendari quan hi ha les activitats    
     $RET['CALENDARI'] = self::calendari($HORARIS);     
     $ANT = "";
     //Fem la recerca de les activitats agrupades per activitat i carregant les dades
     foreach($HORARIS as $H):
        if($ANT <> $H->getActivitatsActivitatid()) {           
           $A = $H->getActivitats();
           
           $titol = $A->getTCurt();
           if(!empty($titol)){           
	           $RET['ACTIVITATS'][$H->getActivitatsActivitatid()]['TITOL'] = $titol; 
	           $RET['ACTIVITATS'][$H->getActivitatsActivitatid()]['TEXT'] = $A->getDCurt();
	           $RET['ACTIVITATS'][$H->getActivitatsActivitatid()]['DIES'][] = $H->getDia('d/m/Y');
           } 
        } else {
           if(isset($RET['ACTIVITATS'][$H->getActivitatsActivitatid()]))
              $RET['ACTIVITATS'][$H->getActivitatsActivitatid()]['DIES'][] = $H->getDia('d/m/Y');
        }
        
        $ANT = $H->getActivitatsActivitatid();        
     endforeach;
     
     return $RET;
     
  }
  
  static public function getActivitatsGrouped($DIA, $TEXT, $DATAI, $DATAF, $IDACTIVITAT)
  {
     $RET = array(); $ANT = "";
     $HORARIS = self::cerca($DIA, $TEXT, $DATAI, $DATAF, $IDACTIVITAT);
     $RET['CALENDARI'] = self::calendari($HORARIS);
     $RET['ACTIVITATS'] = array();
     
     foreach($HORARIS as $H):
        if($ANT <> $H->getActivitatsActivitatid()) $RET['ACTIVITATS'][] = $H->getActivitatsActivitatid();
        $ANT = $H->getActivitatsActivitatid();        
     endforeach;
     
     return $RET;
  }
 	
 
  static public function getCalendari($DIA , $TEXT, $DATAI, $DATAF, $IDACTIVITAT, $GESTIO)
  {
     return self::calendari(self::cerca($DIA , $TEXT, $DATAI, $DATAF, $IDACTIVITAT),$GESTIO);
  }
  
  static public function getActivitats($DIA , $TEXT, $DATAI, $DATAF, $IDACTIVITAT)
  {
    
    $HORARIS = self::cerca($DIA , $TEXT, $DATAI, $DATAF, $IDACTIVITAT);     
    $RET = ARRAY('ACTIVITATS'=>array(),'CALENDARI'=>array());
    $RET['CALENDARI'] = self::calendari($HORARIS);
    $RET['ACTIVITATS'] = self::activitats($HORARIS);
    
    return $RET;
  
  }
  
  static private function activitats($HORARIS)
  {

      $RET = array();
      foreach($HORARIS as $H):     
          $OActivitats = $H->getActivitats();            
	      $RET[$H->getHorarisid()]['ID'] = $OActivitats->getActivitatid();   //Guardem les activitats
	      $RET[$H->getHorarisid()]['NOM_ACTIVITAT'] = $OActivitats->getNom();   //Guardem les activitats	      
	      $RET[$H->getHorarisid()]['DIA'] = $H->getDia('d-m-Y');   //Guardem les activitats
	      $RET[$H->getHorarisid()]['HORA_INICI'] = $H->getHorainici('H:i');   //Guardem les activitats
	      $RET[$H->getHorarisid()]['HORA_FI'] = $H->getHorafi('H:i');   //Guardem les activitats
	      $RET[$H->getHorarisid()]['HORA_PRE'] = $H->getHorapre('H:i');   //Guardem les activitats
	      $RET[$H->getHorarisid()]['HORA_POST'] = $H->getHorapost('H:i');   //Guardem les activitats	      
	      $RET[$H->getHorarisid()]['AVIS'] = $H->getAvis();   //Carreguem l'avís per si de cas      
	      foreach($H->getHorarisespaiss() as $HE):          
	      	$RET[$H->getHorarisid()]['ESPAIS'][] = (is_null($HE->getEspais()))?"":$HE->getEspais()->getNom();   //Guardem les activitats      	
	      	$RET[$H->getHorarisid()]['MATERIAL'][] = (is_null($HE->getMaterial()))?"":$HE->getMaterial()->getNom();      	
	      endforeach;
	   endforeach;
	   return $RET;
     
  }
  
  static private function calendari($HORARIS,$GESTIO = true)
  {     
      $RET = array(); $titol = "";
      foreach($HORARIS as $H):
         if($GESTIO): 
            $titol = $H->getActivitats()->getNom();
         else:	         
	        $titol = $H->getActivitats()->getTCurt();	        	         
         endif;             
         if(!empty($titol)):              
            $dia = mktime(0,0,0,$H->getDia('m'),$H->getDia('d'),$H->getDia('Y'));
            $ESPAIS = "";
                        
            foreach($H->getHorarisespaiss() as $E) $ESPAIS .= $E->getEspais()->getNom(); 
            
            $RET[$dia][$H->getActivitatsActivitatid()]['ORGANITZADOR']  = $H->getActivitats()->getOrganitzador(); 
		    $RET[$dia][$H->getActivitatsActivitatid()]['ESPAIS']  = $ESPAIS; //Guardem l'hora que acaba            
	        $RET[$dia][$H->getActivitatsActivitatid()]['TITOL'] =  $titol; //Guardem el dia que es fa l'activitat      
		    $RET[$dia][$H->getActivitatsActivitatid()]['HORAI']  = $H->getHorainici('H:i'); //Guardem el dia que es fa l'activitat
		    $RET[$dia][$H->getActivitatsActivitatid()]['HORAF']  = $H->getHorafi('H:i'); //Guardem l'hora que acaba
		    		    
	     endif;	     
      endforeach;
      return $RET;
  } 
  
  static private function cercaCriteria($DIA , $TEXT, $DATAI, $DATAF, $IDACTIVITAT)
  {

  	$C = new Criteria();
  	
  	if(!is_null($DIA))   $DIA   = mktime(0,0,0,date('m',$DIA),date('d',$DIA),date('Y',$DIA));
  	if(!is_null($DATAI)) $DATAI = mktime(0,0,0,date('m',$DATAI),date('d',$DATAI),date('Y',$DATAI));
  	if(!is_null($DATAF)) $DATAF = mktime(0,0,0,date('m',$DATAF),date('d',$DATAF),date('Y',$DATAF));
  	  	
    if( !is_null($DIA) ) $C->add(self::DIA, $DIA);
    elseif( !is_null($DATAI) && !is_null($DATAF) ) {
      $data1 = $C->getNewCriterion(self::DIA, $DATAI , CRITERIA::GREATER_EQUAL);
      $data2 = $C->getNewCriterion(self::DIA, $DATAF , CRITERIA::LESS_EQUAL);
      $data1->addAnd($data2);
      $C->add($data1);
    }
    
    foreach(explode(' ',$TEXT) as $PARAULA):
      
      $PARAULA = trim($PARAULA);
    
      if( strlen($PARAULA) > 2 ) {
        $text1Criterion = $C->getNewCriterion(ActivitatsPeer::NOM, '%'.$TEXT.'%', CRITERIA::LIKE);
        $text2Criterion = $C->getNewCriterion(ActivitatsPeer::TCOMPLET , '%'.$TEXT.'%' , CRITERIA::LIKE );
        $text3Criterion = $C->getNewCriterion(ActivitatsPeer::DCOMPLET , '%'.$TEXT.'%' , CRITERIA::LIKE );
        $text1Criterion->addOr($text2Criterion);
        $text1Criterion->addOr($text3Criterion);
        $C->add($text1Criterion);
      }
    endforeach;
        
    if( !is_null($IDACTIVITAT) ) $C->add(ActivitatsPeer::ACTIVITATSACTIVITATSID, $IDACTIVITAT, CRITERIA::EQUAL ); //Si enviem una idActivitat, la carreguem
    
    $C->addAscendingOrderByColumn(self::DIA);   //Ordenem per data
    $C->addAscendingOrderByColumn(self::HORAINICI);   //Ordenem per data
  	 
    return $C;
  	
  }
  
  static private function cerca($DIA , $TEXT, $DATAI, $DATAF, $IDACTIVITAT)
  {
    
  	$C = self::cercaCriteria($DIA , $TEXT, $DATAI, $DATAF, $IDACTIVITAT);  	
    //$C->setLimit(200);    
    
    return self::doSelectJoinAll($C);
    
  } 
 
   /**
    * Espai per estadístics
    */
   
  
  static public function getMesosEspais($any)
  {
     $RET = array(array(array()));
     $SQL = "
     	SELECT MONTH(".self::DIA.") as mes,".HorarisespaisPeer::ESPAIS_ESPAIID." as espai,".self::ACTIVITATS_ACTIVITATID." as activitat
     	  FROM ".self::TABLE_NAME.", ".HorarisespaisPeer::TABLE_NAME."
     	 WHERE ".self::HORARISID." = ".HorarisespaisPeer::HORARIS_HORARISID."
     	   AND YEAR(".self::DIA.") = '$any'          
     ";

     
     $con = Propel::getConnection(); $stmt = $con->prepare($SQL); $stmt->execute();     
	 
     while($rs = $stmt->fetch(PDO::FETCH_OBJ)): 
          
        if(isset($RET[$rs->mes][$rs->espai][$rs->activitat]))                        
           $RET[$rs->mes][$rs->espai][$rs->activitat] += 1;
        else
           $RET[$rs->mes][$rs->espai][$rs->activitat] = 0;
     endwhile;
     
     return $RET;     
  } 
  
  
  static public function getMesosDiesEspai($any,$espai)
  {
     $RET = array();
     $SQL = "
     	SELECT MONTH(".self::DIA.") as mes, DAY(".self::DIA.") as dia ,".self::ACTIVITATS_ACTIVITATID." as activitat
     	  FROM ".self::TABLE_NAME.", ".HorarisespaisPeer::TABLE_NAME."
     	 WHERE ".self::HORARISID." = ".HorarisespaisPeer::HORARIS_HORARISID."
     	   AND YEAR(".self::DIA.") = '$any'          
           AND ".HorarisespaisPeer::ESPAIS_ESPAIID." = $espai
     ";
     $con = Propel::getConnection();
     $stmt = $con->prepare($SQL);
     $stmt->execute();
     
     while($rs = $stmt->fetch(PDO::FETCH_OBJ)):                        
        if(isset($RET[$rs->mes][$rs->dia][$rs->activitat]))
           $RET[$rs->mes][$rs->dia][$rs->activitat] += 1;
        else
           $RET[$rs->mes][$rs->dia][$rs->activitat] = 0;        
     endwhile;
     
     return $RET;     
  }  
  
  static public function getMesosEspaisHores($any,$espai,$mes)
  {
     $RET = array(array(array()));
              
	 $SQL = "
	     	 SELECT count(*) as count , h.horaInici as hi , h.horaFi as hf , h.dia as dia 
	     	   FROM horarisespais he , horaris h , espais e
	 		  WHERE he.Espais_EspaiID = e.EspaiID
	   			AND he.Horaris_HorarisID = h.HorarisID
	   			AND e.EspaiID = $espai
	   			AND YEAR(h.dia) = $any
	   			AND MONTH(h.dia) = $mes
	   		 GROUP BY h.horainici, h.horafi , h.dia          
	     ";
	   		 
     $con = Propel::getConnection(); $stmt = $con->prepare($SQL); $stmt->execute();     
	 
     while($rs = $stmt->fetch(PDO::FETCH_OBJ)):
     	$res = explode('-',$rs->dia);      
        $time = mktime(0,0,0,$res[1],$res[0],$res[2]);
        $hourIT = explode(':',$rs->hi);
        $hourI = intval($hourIT[0]);
        $hourFT = explode(':',$rs->hf);
        $hourF = intval($hourFT[0]);
        
        for($i = $hourI; $i <= $hourF; $i++):
           	if(isset($RET[$time][$i])):
           		$RET[$time][$i] += $rs->count;
           	else:
           		if($time > 0) $RET[$time][$i] = $rs->count;
           	endif;
        endfor;
                
     endwhile;               
     
     return $RET;     
  } 
  
  
  static public function validaDia( $DIA , $idE , $HoraPre , $HoraPost , $idH )
  {
  
  	//Garantim que si hi ha un altre espai, no comprovi
  	if($idE == 1) $idE = 0;
  	
	$SQL = "  SELECT count(*) as Va
				FROM horarisespais he, horaris h
    		   WHERE h.DIA = '$DIA'
    			 AND h.HorarisID = he.Horaris_HorarisID
    			 AND (
						( ( h.horaPre  > '$HoraPre' ) AND ( h.horaPre   < '$HoraPost' ) ) OR
						( ( h.horaPost > '$HoraPre' ) AND ( h.horaPost  < '$HoraPost' ) ) OR
						( ( h.horaPre  <= '$HoraPre' ) AND ( h.horaPost >= '$HoraPost' ) ) OR
						( ( h.horaPre  > '$HoraPre' ) AND ( h.horaPost  < '$HoraPost' ) )
        			)
        		 AND he.Espais_EspaiID = $idE        			        			
        	";
	
   	 if( $idH > 0 ) $SQL .= " AND he.Horaris_HorarisID <> $idH";
			
     $con = Propel::getConnection();
     $stmt = $con->prepare($SQL);
     $stmt->execute();

     $rs = $stmt->fetch(PDO::FETCH_OBJ);
     return $rs->Va;  	
  
  }
  
  static public function validaMaterial( $DIA , $idE , $idM , $HoraPre , $HoraPost , $idH)
  {
  	
	$SQL = "  SELECT count(*) as Va
				FROM horarisespais he, horaris h
    		   WHERE h.DIA = '$DIA'
    			 AND h.HorarisID = he.Horaris_HorarisID
    			 AND (
						( ( h.horaPre >= '$HoraPre' ) AND ( h.horaPre <= '$HoraPost' ) ) OR
						( ( h.horaPost >= '$HoraPre' ) AND ( h.horaPost <= '$HoraPost' ) ) OR
						( ( h.horaPre <= '$HoraPre' ) AND ( h.horaPost >= '$HoraPost' ) ) OR
						( ( h.horaPre >= '$HoraPre' ) AND ( h.horaPost <= '$HoraPost' ) )
        			)
        		 AND he.Material_idMaterial = $idM        			
        	";
	
	 if( $idH > 0 ) $SQL .= " AND he.Horaris_HorarisID <> $idH";
	 
     $con = Propel::getConnection();
     $stmt = $con->prepare($SQL);
     $stmt->execute();

     $rs = $stmt->fetch(PDO::FETCH_OBJ);
     return $rs->Va;  	
  	
  }
  
  
  static public function save( $HORARIS, $DBDD , $MATERIAL , $ESPAIS )
  {
	
  	//Esborrem les dades dels antics horaris sempre i quant sigui nou  	
	if($HORARIS['HorarisID'] > 0) //Si l'horari NO és nou, l'esborrem
	{ 
		
		$OH = HorarisPeer::retrieveByPK($HORARIS['HorarisID']);		
		foreach($OH->getHorarisespaiss() as $HE):
			$HE->delete();
		endforeach;
		$OH->delete();
		
	}	 	
  	
  	//Per cada un dels dies que ha entrat, creem un horari
  	foreach($DBDD['DIES'] as $D):  		
  		  			  
	  	$OH = new Horaris();
	  	$OH->setNew(true);
	  	$NOU = true;	    
	  	  	
	  	$OH->setActivitatsActivitatid($HORARIS['Activitats_ActivitatID']);
	  	$OH->setHorainici($DBDD['HoraIn']);
	  	$OH->setHorapre($DBDD['HoraPre']);
	  	$OH->setHorapost($DBDD['HoraPost']);
	  	$OH->setHorafi($DBDD['HoraFi']);
	  	$OH->setAvis($HORARIS['Avis']);
	  	$OH->setEspectadors($HORARIS['Espectadors']);
	  	$OH->setPlaces($HORARIS['Places']);
		$OH->setDia($D);
		$OH->save();  //Guardem				
		
  		foreach($ESPAIS as $K=>$idE):  			
  			foreach($MATERIAL as $K=>$idM):
  				$OHE = new Horarisespais();				//Creem  un registre per espai i per material de l'horari del dia
  				$OHE->setNew(true);  			
  				$OHE->setMaterialIdmaterial($idM);
  				$OHE->setEspaisEspaiid($idE);
  				$OHE->setHorarisHorarisid($OH->getHorarisid());   //Amb l'identificador de l'horari que hem creat
  				$OHE->save();
  			endforeach;
  			if(empty($MATERIAL)):
  				$OHE = new Horarisespais();				//Creem  un registre per espai i per material de l'horari del dia
  				$OHE->setNew(true);  			
  				$OHE->setMaterialIdmaterial(NULL);
  				$OHE->setEspaisEspaiid($idE);
  				$OHE->setHorarisHorarisid($OH->getHorarisid());   //Amb l'identificador de l'horari que hem creat
  				$OHE->save();
  			endif;
  		endforeach;
  			
  	endforeach;
  	
  }
  
  	static function isMaterialEnUs($idM,$di,$df)
	{		
		$C = new Criteria();
		$C->add(HorarisespaisPeer::MATERIAL_IDMATERIAL, $idM);
		$C->addJoin(HorarisespaisPeer::HORARIS_HORARISID, HorarisPeer::HORARISID);
		$C->add(HorarisPeer::DIA, implode('/',$di) , CRITERIA::GREATER_EQUAL);
		$C->add(HorarisPeer::DIA, implode('/',$df) , CRITERIA::LESS_EQUAL);
		return (HorarisespaisPeer::doCount($C) > 0);
	}
  
  
}