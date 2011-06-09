<?php

/**
 * Subclass for performing query and update operations on the 'cursos' table.
 *
 * 
 *
 * @package lib.model
 */ 
class CursosPeer extends BaseCursosPeer
{

   const CURSACTIU = 1;
   const PASSAT = 0;   

    static public function initialize( $idC , $idS )
    {
        $OC = CursosPeer::retrieveByPK($idC);            
        if(!($OC instanceof Cursos)):                    	
        	$OC = new Cursos();
            $OC->setSiteId($idS);          
            $OC->setActiu(true);                                      	
        endif; 
        return new CursosForm($OC,array('IDS'=>$idS));
    }

   
  static public function getCriteriaActiu( $C , $idS )
  {    
    $C->add(self::ACTIU, true);
    $C->add(self::SITE_ID, $idS);
    return $C;
  }
   
  static function getSelect()
  {
    $RES = array();
    
    $C = new Criteria();
    $CURSOS = CursosPeer::doSelect($C);
    foreach($CURSOS as $CURS):
      $RES[$CURS->getIdcursos()] = $CURS->getCodi().' - '.$CURS->getTitolcurs();    
    endforeach;
       
    return $RES;
     
  }
  
  static function getSelectCategories()
  {
  	
  	$RET = array();
  	$C = new Criteria();
  	$C->add(TipusPeer::TIPUSNOM , 'curs_cat');
  	
  	foreach(tipusPeer::doSelect($C) as $Cat):
  		$RET[$Cat->getIdtipus()] = $Cat->getTipusDesc();
  	endforeach;
  	
  	return $RET;
    
  }
  
  static function getSelectCursos()
  {
  	
	$RET = array();
	$C = new Criteria();
    
    $C->add( self::ISACTIU , true );

	$C->addAscendingOrderByColumn( self::CATEGORIA );
	$C->addDescendingOrderByColumn( self::TITOLCURS );
  	$C->addDescendingOrderByColumn( 'YEAR('.self::DATAINICI.')' );
  	$C->addDescendingOrderByColumn( 'MONTH('.self::DATAINICI.')' );  	
  	
    $RET[0] = 'El curs no està actiu o bé escolliu-ne un';
      	
  	foreach(self::doSelect($C) as $CURS):
  		$DATA = $CURS->getDatafimatricula();  		  		
		list($year,$month,$day) = explode("-",$DATA); 
  		$RET[$CURS->getIdcursos()] = $CURS->getCodi().'('.$year.'-'.$month.') - '.$CURS->getTitolcurs();
  	endforeach;  	    
    
  	return $RET;  	
  	
  }
  
  static function getSelectCursosActius()
  {
  	$RET = array();
	$C = new Criteria();  	
  	$C->add(self::ISACTIU , true);  	
  	$C->addAscendingOrderByColumn( self::CATEGORIA );
  	$C->addAscendingOrderByColumn( self::DATAAPARICIO );	

  	foreach(self::doSelect($C) as $CURS): 
  		$RET[$CURS->getIdcursos()] = $CURS->getCodi().' - '.$CURS->getTitolcurs();
  	endforeach;
  	
  	return $RET;  	
  	
  }
  
  static function getCursos($mode = self::CURSACTIU , $PAGINA = 1, $CERCA = "" , $idS , $visibleWeb = false )
  {
  	$C = new Criteria();  	
    $C = self::getCriteriaActiu($C,$idS);
    
  	if($mode == self::CURSACTIU): $C->add(self::ISACTIU , true); else: $C->add(self::ISACTIU , false); endif;
   
    if($visibleWeb) $C->add(self::VISIBLEWEB, true); //Si ha de ser només per web, marquem com a només els visibles. 
              	
  	$C->addAscendingOrderByColumn( self::CATEGORIA );
  	//$C->addAscendingOrderByColumn( self::DATADESAPARICIO );
  	$C->addAscendingOrderByColumn( self::CODI );
  	
  	if(!empty($CERCA)):
  		$C1 = $C->getNewCriterion(self::CODI, "%$CERCA%" , CRITERIA::LIKE);
  		$C2 = $C->getNewCriterion(self::TITOLCURS , "%$CERCA%" , CRITERIA::LIKE );
		$C1->addOr($C2); $C->add($C1);  		  	
  	endif; 

 	$pager = new sfPropelPager('Cursos', 50);
	$pager->setCriteria($C);
	$pager->setPage($PAGINA);
	$pager->init();  	
  	
  	return $pager;  	
  }
  
  static function getTotsCursos($PAGINA = 1)
  {
  	$C = new Criteria();  	  	  
    $C->addAscendingOrderByColumn( self::CATEGORIA );
  	$C->addAscendingOrderByColumn( self::DATAAPARICIO );
  	
  	$pager = new sfPropelPager('Cursos', 50);
	$pager->setCriteria($C);
	$pager->setPage($PAGINA);
	$pager->init();  	
  	return $pager;  	
  }
      
  static function getMatricules($idC,$idS)
  {
  	$Curs = self::retrieveByPK($idC);
  	$C = new Criteria();
    $C = MatriculesPeer::getCriteriaActiu($C,$idS);
  	$c1 = $C->getNewCriterion(MatriculesPeer::ESTAT,MatriculesPeer::ACCEPTAT_PAGAT);
  	$c2 = $C->getNewCriterion(MatriculesPeer::ESTAT,MatriculesPeer::EN_ESPERA);
  	$c1->addOr($c2);
  	$C->add($c1);  	  	
  	$C->addJoin(MatriculesPeer::USUARIS_USUARIID, UsuarisPeer::USUARIID);
    $C->addAscendingOrderByColumn(UsuarisPeer::COG1);
    $C->addAscendingOrderByColumn(UsuarisPeer::COG2);
    $C->addAscendingOrderByColumn(UsuarisPeer::NOM);
  	  	
  	return $Curs->getMatriculess($C);
  }

  /**
   * return array(OCUPADES, TOTAL);
   * */

  static function getPlaces( $idC , $idS )
  {
     
     $FC = self::initialize( $idC , $idS );
     $CURS = $FC->getObject();          
     $MATRICULES = $CURS->countMatriculesActives( $idS );
     $PLACES = $CURS->getPlaces();
     return array('OCUPADES'=>$MATRICULES , 'TOTAL'=>$PLACES);
          
  }
  
  static function isPle( $IDC , $idS )
  {          
     //Si les places ocupades són més grans o igual que el total, el curs és ple
     $PLACES = CursosPeer::getPlaces( $IDC , $idS );
     return ($PLACES['OCUPADES'] >= $PLACES['TOTAL']);              
  }
        
  static function CalculaPreu($IDCURS , $DESCOMPTE , $idS )
  {   
    
     //Recuperem les places del curs
     $PLACES = CursosPeer::getPlaces( $IDCURS , $idS );
     
     //Si les places ocupades són iguals o més que el total, fem la matrícula gratuïta. 
     if($PLACES['OCUPADES'] >= $PLACES['TOTAL']) $DESCOMPTE = MatriculesPeer::REDUCCIO_GRATUIT;

     //Carreguem el curs i retornem el preu reduit o normal segons el que hem entrat     
     $CURS = CursosPeer::retrieveByPK($IDCURS);
     
     switch($DESCOMPTE){
         case MatriculesPeer::REDUCCIO_CAP : return $CURS->getPreu();
         case MatriculesPeer::REDUCCIO_ATURAT : return $CURS->getPreur();
         case MatriculesPeer::REDUCCIO_JUBILAT : return $CURS->getPreur();
         case MatriculesPeer::REDUCCIO_MENOR_25_ANYS : return $CURS->getPreur();
         case MatriculesPeer::REDUCCIO_GRATUIT   : return 0;
         case MatriculesPeer::REDUCCIO_ESPECIAL : return $CURS->getPreur();           
      }
               
  }
  
  
  static function CalculaTotalPreus( $CURSOS , $DESCOMPTE , $idS )
  {   
     $Preu = 0;
     foreach($CURSOS as $C):
        $Preu += self::CalculaPreu($C , $DESCOMPTE , $idS );
     endforeach;     
      
     return $Preu;
  }
  
  static function getCodisAjax($query,$limit)
  {
  	$RET = array();
  	$C = new Criteria();
  	$C->addGroupByColumn(self::CODI);
  	$C->addGroupByColumn(self::TITOLCURS);
  	$C->addAscendingOrderByColumn(self::IDCURSOS);  	
  	$C->add(self::CODI,$query.'%', CRITERIA::LIKE);
  	
  	foreach(self::doSelect($C) as $Curs):
  		$RET[$Curs->getCodi()] = array('clau'=>$Curs->getcodi(),'text'=>$Curs->getCodi().' - '.$Curs->getTitolcurs());  		
  	endforeach;
  	
  	return $RET;
  	
  }
  
  static function getCodisOptions($idS)
  {
  	$RET = array();
  	$C = new Criteria();
    $C = self::getCriteriaActiu($C,$idS);
  	$C->addGroupByColumn(self::CODI);
  	$C->addGroupByColumn(self::TITOLCURS);
  	$C->addAscendingOrderByColumn(self::CODI);
  	$C->addAscendingOrderByColumn(self::IDCURSOS);  	  	
  	$RET[0] = "Codi de curs nou";
  	foreach(self::doSelect($C) as $Curs):
  		$RET[$Curs->getCodi()] = $Curs->getCodi().' - '.$Curs->getTitolcurs();  		
  	endforeach;
  	
  	return $RET;
  	
  }
  
  static function getCodisTitol()
  {
  	$RET = array();
  	$C = new Criteria();
  	$C->addGroupByColumn(self::CODI);
  	$C->addGroupByColumn(self::TITOLCURS);
  	$C->addAscendingOrderByColumn(self::IDCURSOS);  	  	
  	
  	foreach(self::doSelect($C) as $Curs):
  		$RET['CLAU'][$Curs->getCodi()] = '"'.$Curs->getcodi().'"';  		
  		$RET['TEXT'][$Curs->getCodi()] = '"'.addslashes($Curs->getTitolcurs()).'"';
  	endforeach;
  	
  	return $RET;
  	
  }
    
  static public function getCopyCursByCodi($codi,$idS)
  {
       
  	$OCurs = self::getByCodi($codi,$idS);
  	                           	
  	if($OCurs instanceof Cursos):
        $OCurs->setIdcursos(null);
        $OCurs->setNew(false);
        $FC = new CursosForm($OCurs); 	
        $FC->getObject()->setIsactiu(true);
        $FC->getObject()->setDataaparicio(date('Y-m-d',time()));
        $FC->getObject()->setDatadesaparicio(date('Y-m-d',time()));
        $FC->getObject()->setDatainici(date('Y-m-d',time()));
    else:
        $OC = new Cursos();
        $OC->setSiteId($idS);
        $OC->setActiu(true); 
        $OC->setCodi($codi);
        $FC = new CursosForm($OC);                                	  	
  	endif;
        	
  	return $FC;
  }
  
  static public function getByCodi($codi,$idS)
  {
  	$C = new Criteria();
    $C = self::getCriteriaActiu($C,$idS);
  	$C->add(self::CODI, $codi);
  	$C->addDescendingOrderByColumn(self::IDCURSOS);
  	return self::doSelectOne($C); 	
  }  
  
  static public function getWhereHospici($idText, $idSite, $idPoble, $idCategoria, $idData, $aDates = null)
  {

    //Segons text
    $where = (!is_null($idText) && !empty($idText))?" AND (c.TitolCurs like '%{$idText}%' OR c.Descripcio like '%{$idText}%')":"";
    
    //Segons poble    
    $where .= (!is_null($idPoble) && $idPoble > 0)?' AND p.idPoblacio = '.$idPoble:'';    
    
    //Hem de buscar segons idCategoria.
    $where .= (!is_null($idCategoria) && $idCategoria > 0)?' AND c.Categoria = '.$idCategoria:'';
    
    $d = hospiciActions::getDatesCercadorHospici($idData,$aDates);
    $datai = $d['datai']; $dataf = $d['dataf'];

    //Si busquem una data, ha de ser inferior a la data de desaparicio i d'inici de curs
    $where .= " AND c.DataAparicio >= '{$datai}' AND c.DataAparicio <= '{$dataf}' AND c.DataInici >= '{$datai}' ";

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
