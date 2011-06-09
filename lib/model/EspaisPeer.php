<?php

/**
 * Subclass for performing query and update operations on the 'espais' table.
 *
 * 
 *
 * @package lib.model
 */ 
class EspaisPeer extends BaseEspaisPeer
{

  static public function getCriteriaActiu($C,$idS)
  {
    $C->add(self::ACTIU, true);
    $C->add(self::SITE_ID, $idS);
    return $C;
  }

  static public function initialize( $idE , $idS )
  {
    $OE = self::retrieveByPK($idE);            
	if(!($OE instanceof Espais)):
		$OE = new Espais();   		                    
        $OE->setSiteId($idS);        
        $OE->setActiu(true);        		            			    			    			        					
	endif;    
    
    return new EspaisForm($OE,array('IDS'=>$idS)); 
  }

  static public function select( $idS , $with_new = false )
  {
  	$C = new Criteria();
    $C = self::getCriteriaActiu($C,$idS);
    
  	$C->addAscendingOrderByColumn(self::ORDRE);
  	
    $Espais = self::doSelect($C);
    $RET = array();
    if($with_new) $RET['0'] = 'Nou espai...';
    foreach($Espais as $E):
      $RET[$E->getEspaiid()] = $E->getNom();    
    endforeach;
    
    return $RET;    
      
  }
  
  static public function selectJavascript( $idS , $sel = -1 )
  {

  	$C = new Criteria();
    $C = self::getCriteriaActiu($C,$idS);
    
  	$C->addAscendingOrderByColumn(self::ORDRE);
  	
    $Espais = self::doSelect($C);
  	
    $RET = "";
    foreach($Espais as $E):
    	$idE = $E->getEspaiid();
    	if($sel == $idE): $RET .= '<OPTION SELECTED value="'.$idE.'">'.$E->getNom().'</OPTION>';
    	else: $RET .= '<OPTION value="'.$idE.'">'.$E->getNom().'</OPTION>';
    	endif;    
    endforeach;    
    
    $RET = str_replace("'","\'",$RET);    
    
    return $RET;    
  	
  }


  /**
   * Usat al formulari ClientReservesPeer
   * */  
  static public function selectFormReserva($idS)
  {
    $RET = array();
    $C = new Criteria();
    $C = self::getCriteriaActiu($C,$idS);
    $C->add(EspaisPeer::ISLLOGABLE, true);
    $C->addAscendingOrderByColumn(self::ORDRE);
    foreach(self::doSelect($C) as $E):
    
        $RET[$E->getEspaiid()] = $E->getNom();
    
//        if($E->getEspaiid() >= 1 && $E->getEspaiid() < 6) $RET[$E->getEspaiid()] = $E->getNom();
//        if($E->getEspaiid() >= 9 && $E->getEspaiid() < 16) $RET[$E->getEspaiid()] = $E->getNom();
//        if($E->getEspaiid() == 19) $RET[$E->getEspaiid()] = $E->getNom();          
    
    endforeach;
    return $RET;
  }

  static public function getEspaisSite($idS)
  {
    $C = new Criteria();
    $C = self::getCriteriaActiu($C,$idS);
    $C->addAscendingOrderByColumn(self::ORDRE);
    return self::doSelect($C);
  }

  /**
   * EspaisPeer::getEstadistiquesEspais()
   * 
   * Entrem uns paràmetres de cerca i retorna un array amb l'ocupació d'espais
   * 
   * @param mixed $espais
   * @param mixed $site
   * @param mixed $month
   * @param mixed $year
   * @return
   */
  static public function getEstadistiquesEspais($espais = array(), $site, $month, $year)
  {
    
    $RET= array();
    if(!empty($espais)){
        $SQL = "
            SELECT H.Dia as d, HOUR(H.HoraPre) as hi, HOUR(H.HoraPost) as hf, E.EspaiID as idE, E.Nom as e_nom
              FROM espais E, horarisespais HE, horaris H 
             WHERE H.HorarisID = HE.Horaris_HorarisID 
               AND HE.Espais_EspaiID = E.EspaiID
               AND H.actiu = 1 AND E.actiu = 1 AND HE.actiu = 1
               AND H.site_id = $site                  
               AND MONTH(H.Dia) = '$month'
               AND YEAR(H.Dia) = '$year'
               AND HE.Espais_EspaiID in (".implode(',',$espais).")
             ORDER BY H.Dia Asc, idE, H.HoraPre Asc";
                                           
        $con = Propel::getConnection();
        $stmt = $con->prepare($SQL);
        $stmt->execute(); 
        $RET = array();
                 
        while($rs = $stmt->fetch(PDO::FETCH_OBJ)){
            $RET[$rs->d][$rs->idE][$rs->hi] = $rs->hf;    
        } 	
                        
        for($i = 1; $i < 31; $i++):
            $data = date('Y-m-d',strtotime($year.'-'.$month.'-'.$i));        
            foreach($espais as $idE):
                if(!isset($RET[$data][$idE])) $RET[$data][$idE][8] = 8; 
            endforeach;        
            ksort($RET[$data]);
        endfor;
        ksort($RET);
    }
    
    return $RET;
    
  }


/*******************************************************************************/
/*********************** Funcions per a l'Hospici ******************************/
/*******************************************************************************/

  static public function getWhereHospici($idText, $idSite, $idPoble, $idCategoria, $idData, $aDates = null)
  {

    //Segons text
    $where = (!is_null($idText) && !empty($idText))?" AND (e.Nom like '%{$idText}%')":"";
    
    //Segons poble    
    $where .= (!is_null($idPoble) && $idPoble > 0)?' AND p.idPoblacio = '.$idPoble:'';    
    
    //Hem de buscar segons idCategoria.
    $where .= (!is_null($idCategoria) && $idCategoria > 0)?' AND t.idTipus = '.$idCategoria:'';
    
    $d = hospiciActions::getDatesCercadorHospici($idData,$aDates);
    $datai = $d['datai']; $dataf = $d['dataf'];

    //Si busquem una data, ha de ser inferior a la data de desaparicio i d'inici de curs
//    $where .= " AND c.DataAparicio >= '{$datai}' AND c.DataAparicio <= '{$dataf}' AND c.DataInici >= '{$datai}' ";

    return $where;
    
  }
  
  static public function getCursosHospici($idText, $idSite, $idPoble, $idCategoria, $idData, $aDates, $p = 1 )
  {
    
    $RET = self::getCursosHospiciCerca($idText, $idSite, $idPoble, $idCategoria, $idData, $aDates, false);    
        
    $C = new Criteria();    
    $C->add(self::IDCURSOS , $RET , CRITERIA::IN );
    $pager = new sfPropelPager('Cursos', 20);
    $pager->setCriteria($C);
    $pager->setPage($p);
    $pager->init();    	
        
    return $pager; 

  }  
  
  static public function getCursosHospiciCerca($idText, $idSite, $idPoble, $idCategoria, $idData, $aDates = null, $hasPobles = false)
  {

    $where = self::getWhereHospici($idText, $idSite, $idPoble, $idCategoria, $idData, $aDates);

    $connection = Propel::getConnection();        
    $query = 
            "
                Select c.idCursos as idC, p.idPoblacio as idP, p.Nom as pobleNom
                  from cursos c
                  LEFT JOIN sites s ON (c.site_id = s.site_id)
                  LEFT JOIN poblacions p ON (p.idPoblacio = s.poble)  
                WHERE 
                   c.actiu = 1 AND s.actiu = 1                    
                   {$where}                                      
                 GROUP BY idC,idP,pobleNom
            ";  
    $statement = $connection->prepare($query);        
    $statement->execute();
    $RET = array();
    
    //Guardo els elements resultats i els passo a un format Criteria    
    while($result = $statement->fetch(PDO::FETCH_ASSOC)){
        if($hasPobles):
            $RET[$result['idP']][$result['idC']] = $result['idC'];                    
        else:
            $RET[$result['idC']] = $result['idC'];
        endif;   
    }

    return $RET;
  }

  /**
   * CursosPeer::selectPoblesCursos()
   * 
   * Omple el llistat de select del portal hospici.   
   * 
   * @return array
   */
  static public function selectPoblesCursos($text = null)
  {
    
    //Busquem les activitats futures amb tots els ets i uts que de moment és la població
    $RET = self::getCursosHospiciCerca($text,null,null,null,null,null,true);    
    
    $FIN[0] = ""; $count = 0;
    foreach($RET as $idP => $aActs){
        $nom = PoblacionsPeer::retrieveByPK($idP)->getNom();
        $FIN[$idP] = $nom.' ('.sizeof($aActs).')';
        $count += sizeof($aActs);                            
    }    
    $FIN[0] = "Qualsevol població (".$count.")";
    
    return $FIN;    
             
  }

  /**
   * CursosPeer::selectCategoriesCursos()
   *
   * Usat en el select de l'hospici que carrega els tipus d'activitats
   *  
   * @param mixed $idP
   * @return
   */
  static public function selectCategoriesCursos( $idP , $text )
  {
    
    //Busquem les activitats futures amb tots els ets i uts que de moment és la població
    $RET = self::getCursosHospiciCerca($text,null,$idP,null,null,null,false);    
    
    $where  = (sizeof($RET) > 0)?' c.idCursos in ('.implode(',',$RET).')':' c.idCursos = 0 ';
    $where .= " AND t.tipusNom = 'curs_cat' ";    
    
    $connection = Propel::getConnection();
    $query = 
            "
                Select t.tipusDesc as nom, t.idTipus as ta, count(*) as num 
                  from tipus t 
                  LEFT JOIN cursos c ON (t.idTipus = c.Categoria)
                 WHERE {$where}
                 GROUP BY nom, ta
                 ORDER BY num DESC                  
            ";            
    $statement = $connection->prepare($query);
    $statement->execute();
    $RET = array();
    
    //Guardo els elements resultats i els passo a un format Criteria
    $FIN[0] = ""; $count = 0;
    while($P = $statement->fetch(PDO::FETCH_ASSOC)){
        $FIN[$P['ta']] = $P['nom'].' ('.$P['num'].')';
        $count += $P['num'];        
    }    
    $FIN[0] = "Qualsevol categoria (".$count.")";
    
    return $FIN;    
        
  }

  /**
   * CursosPeer::selectDatesCursos()
   * 
   * Torna el select de dates amb el volum d'activitats tant per pobles com per entitats
   * 
   * @param mixed $idP
   * @param mixed $idC
   * @return
   */
  static public function selectDatesCursos($idP = null, $idC = null, $text = null, $idE = null)
  {
    
    //Busquem les activitats futures amb tots els ets i uts que de moment és la població
    $RET = self::getCursosHospiciCerca($text,null,$idP,$idC,null,null,false);    
    
    
    $C = new Criteria();
    $C->add(self::ACTIU, true);
    $C->add(self::IDCURSOS, $RET, CRITERIA::IN);
    $C->addGroupByColumn(self::IDCURSOS);
    
    //Tenim en compte si hem entrat una entitat o no
    if($idE > 0) $C = self::getCriteriaActiu($C,$idE);
    else $C->add(self::ACTIU, true);        
    
    //Definim els rangs
    $avui = time();
    $capSetmanaDis = $avui;
    while(6 <> date('w',$capSetmanaDis)) $capSetmanaDis = strtotime(date("Y-m-d", $capSetmanaDis) . "+1 day");
    $capSetmanaDiu = strtotime(date('Y-m-d',$capSetmanaDis).' +1 day');
    $fiMes = strtotime(date('Y-m-d',$avui).' +1 month');
    $fi2Mes = strtotime(date('Y-m-d',$avui).' +2 month');
    $fi3Mes = strtotime(date('Y-m-d',$avui).' +3 month');
    
    //Avui
    $C_avui = clone $C;
    $C_avui->add(self::DATAAPARICIO, date('Y-m-d',$avui));        
    $FIN[0] = 'Avui ('.self::doCount($C_avui).')';
    
    //Cap de setmana
    $C_cset = clone $C;
    $C1 = $C_cset->getNewCriterion(self::DATAAPARICIO, date('Y-m-d',$capSetmanaDis));
    $C2 = $C_cset->getNewCriterion(self::DATAAPARICIO, date('Y-m-d',$capSetmanaDiu));
    $C1->addOr($C2); $C_cset->add($C1);    
    $FIN[1] = 'El cap de setmana ('.self::doCount($C_cset).')';

    //Aquest mes
    $C_mes = clone $C;
    $C1 = $C_mes->getNewCriterion(self::DATAAPARICIO, date('Y-m-d',$fiMes), CRITERIA::LESS_THAN);
    $C2 = $C_mes->getNewCriterion(self::DATAAPARICIO, date('Y-m-d',$avui) , CRITERIA::GREATER_EQUAL);
    $C1->addAnd($C2); $C_mes->add($C1);    
    $FIN[2] = 'Aquest mes ('.self::doCount($C_mes).')';
    
    //Dos mesos
    $C_mes2 = clone $C;
    $C1 = $C_mes2->getNewCriterion(self::DATAAPARICIO, date('Y-m-d',$fi2Mes), CRITERIA::LESS_THAN);
    $C2 = $C_mes2->getNewCriterion(self::DATAAPARICIO, date('Y-m-d',$fiMes) , CRITERIA::GREATER_EQUAL);
    $C1->addAnd($C2); $C_mes2->add($C1);    
    $FIN[3] = 'El mes que ve ('.self::doCount($C_mes2).')';
    
    //Tres mesos
    $C_mes3 = clone $C;
    $C1 = $C_mes3->getNewCriterion(self::DATAAPARICIO, date('Y-m-d',$fi3Mes), CRITERIA::LESS_THAN);
    $C2 = $C_mes3->getNewCriterion(self::DATAAPARICIO, date('Y-m-d',$fi2Mes) , CRITERIA::GREATER_EQUAL);
    $C1->addAnd($C2); $C_mes3->add($C1);    
    $FIN[4] = 'El mes que ve ('.self::doCount($C_mes3).')';
                  
    return $FIN;    
        
  }  

  /**
   * CursosPeer::selectSitesCursos()
   * 
   * Carrega les entitats que hi ha a l'hospici 
   *  
   * @return
   */
  static public function selectSitesCursos($text = null)
  {
    
    $where = self::getWhereHospici($text, null, null, null, null, null);

    $connection = Propel::getConnection();        
    $query = 
            "
                Select c.idCursos as idC, s.site_id as idS, s.Nom as siteNom
                  from cursos c
                  LEFT JOIN sites s ON (c.site_id = s.site_id)                    
                WHERE 
                   c.actiu = 1 AND s.actiu = 1                    
                   {$where}   
                 GROUP BY idC,idS,siteNom
            ";  
    $statement = $connection->prepare($query);        
    $statement->execute();
    //Inicialitzem variables 
    $RET = array(); $ACOUNT = array(); $count = 0;
        
    $RET[0] = "Qualsevol entitat (".$count.")";        
    while($result = $statement->fetch(PDO::FETCH_ASSOC)){
        $idS = $result['idS']; 
        if(!isset($RET[$idS])) $ACOUNT[$idS] = 1; else $ACOUNT[$idS]++;        
        $RET[$idS] = $result['siteNom'].' ('.$ACOUNT[$idS].')';                            
        $count++;                   
    }
    
    $RET[0] = "Qualsevol entitat (".$count.")";        
       
    return $RET;
    
  }


}
