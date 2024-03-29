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
    
    /**
     * HOSPICI_RESERVA = TIPUS_PAGAMENT_RESERVA ( QUAN HO TROBI HO HE D'ANAR CANVIANT ) 
     * */    
    const HOSPICI_NO_RESERVA = 0;
    const HOSPICI_RESERVA = 1;
    const HOSPICI_RESERVA_TARGETA = 2;
    const HOSPICI_RESERVA_DOMICILIACIO = 3;
    
    const TIPUS_PAGAMENT_NO_RESERVA = 0;
    const TIPUS_PAGAMENT_RESERVA = 1;
    const TIPUS_PAGAMENT_TARGETA = 2;
    const TIPUS_PAGAMENT_DOMICILIACIO = 3;
    const TIPUS_PAGAMENT_METALIC_CAIXA = 4;

    static public function initialize( $idC , $idS )
    {
        $OC = CursosPeer::retrieveByPK($idC);            
        if(!($OC instanceof Cursos)):                    	
            $OC = new Cursos();
            $OC->setADescomptes(MatriculesPeer::REDUCCIO_CAP);
            $OC->setSiteId($idS);          
            $OC->setActiu(true);                                      	
        endif; 
        return new CursosForm($OC);
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
  
    static function getSelectCursosMatriculaInterna($idS)
    {
    
        //Llistar cursos en ordre. Segons any, Categoria, Títol. 
        $RET = array();
        $C = new Criteria();
        
        //$C->add( self::ISACTIU , true );
        $C->add(self::SITE_ID, $idS);
        
        $C->addDescendingOrderByColumn( 'YEAR('.self::DATAINICI.')' );
        $C->addAscendingOrderByColumn( self::CATEGORIA );
        $C->addDescendingOrderByColumn( self::TITOLCURS );            
        $C->addDescendingOrderByColumn( 'MONTH('.self::DATAINICI.')' );      	
        
        //$RET[0] = 'El curs no està actiu o bé escolliu-ne un';
          	
        foreach(self::doSelect($C) as $CURS):        	            
            $RET['Any '.$CURS->getDatainici('Y')][$CURS->getIdcursos()] = $CURS->getCodi().' ( '.$CURS->getDatainici('M').' ) - '.$CURS->getTitolcurs();          	
        endforeach;  	    
        
        return $RET;  	
        
    }
  

    static function getSelectCursosActius()
    {
        
        $RET = array();
        $C = new Criteria();  	
        $C->add(self::ISACTIU , true);  	
        $C->addAscendingOrderByColumn( self::CATEGORIA );
        $C->addAscendingOrderByColumn( self::DATAINMATRICULA );	
        
        foreach(self::doSelect($C) as $CURS): 
        	$RET[$CURS->getIdcursos()] = $CURS->getCodi().' - '.$CURS->getTitolcurs();
        endforeach;
        
        return $RET;  	
        
    }
  
  static function getCursos($mode = self::CURSACTIU , $PAGINA = 1, $CERCA = "" , $idS , $visibleWeb = false , $datai = null, $dataf = null)
  {
  	$C = new Criteria();  	
    $C = self::getCriteriaActiu($C,$idS);
    
  	//Mirem només els cursos que estan en actiu o sigui amb matrícula oberta. 
      if($mode == self::CURSACTIU): 
        $C->add(self::ISACTIU , true);
         
        //Si estem carregant per mirar pel web, tampoc mostrem els que ja estan fora de període de matriculació.
        if($visibleWeb):
            $C->add(self::DATAFIMATRICULA, date('Y-m-d',time()) , CRITERIA::GREATER_THAN);
        endif;
    else: 
        $C->add(self::ISACTIU , false); 
    endif;
    
    if(!is_null($datai) && !is_null($dataf)):
        $C1 = $C->getNewCriterion(self::DATAINICI, $datai, CRITERIA::GREATER_THAN);
        $C2 = $C->getNewCriterion(self::DATAINICI, $dataf, CRITERIA::LESS_THAN);        
        $C1->addAnd($C2);
        $C->add($C1);
    endif;
       
    if($visibleWeb) $C->add(self::VISIBLEWEB, true); //Si ha de ser només per web, marquem com a només els visibles. 
              	  	
    //Fem l'ordenació. Si el curs és inactiu a més ordenem per l'any... 
    if( $mode != self::CURSACTIU ):
        $C->addAscendingOrderByColumn( self::DATAINICI );
        $C->addAscendingOrderByColumn( self::CATEGORIA );      	
      	$C->addAscendingOrderByColumn( self::CODI );
    else:
        $C->addAscendingOrderByColumn( self::CATEGORIA );
      	$C->addAscendingOrderByColumn( self::DATAINICI );
      	$C->addAscendingOrderByColumn( self::CODI );
    endif;          	        
    
  	if(!empty($CERCA)):
  		$C1 = $C->getNewCriterion(self::CODI, "%$CERCA%" , CRITERIA::LIKE);
  		$C2 = $C->getNewCriterion(self::TITOLCURS , "%$CERCA%" , CRITERIA::LIKE );
		$C1->addOr($C2); $C->add($C1);  		  	
  	endif; 
    
 	if($PAGINA == 0):
        $pager = new sfPropelPager('Cursos', false);
    else:
        $pager = new sfPropelPager('Cursos', 50);
    endif;
	$pager->setCriteria($C);
	$pager->setPage($PAGINA);
	$pager->init();  	
  	
  	return $pager;  	
  }
  
  static function getTotsCursos($PAGINA = 1)
  {
  	$C = new Criteria();  	  	  
    $C->addAscendingOrderByColumn( self::CATEGORIA );
  	$C->addAscendingOrderByColumn( self::DATAINMATRICULA );
  	
  	$pager = new sfPropelPager('Cursos', 50);
	$pager->setCriteria($C);
	$pager->setPage($PAGINA);
	$pager->init();  	
  	return $pager;  	
  }
       
  static function getMatricules($idC,$idS,$amb_llista_espera = false, $amb_baixa = false , $amb_tots_els_estats = false )
  {
  	$Curs = self::retrieveByPK($idC);
  	$C = new Criteria();
    $C = MatriculesPeer::criteriaMatriculat( $C , $amb_llista_espera , $amb_baixa , $amb_tots_els_estats );
    $C->add( MatriculesPeer::CURSOS_IDCURSOS , $idC );
  	
  	$C->addJoin( MatriculesPeer::USUARIS_USUARIID , UsuarisPeer::USUARIID );
    $C->addAscendingOrderByColumn( MatriculesPeer::DATAINSCRIPCIO );
    $C->addAscendingOrderByColumn(UsuarisPeer::COG1);
    $C->addAscendingOrderByColumn(UsuarisPeer::COG2);
    $C->addAscendingOrderByColumn(UsuarisPeer::NOM);
  	  	
  	return MatriculesPeer::doSelect($C);
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
        $FC->getObject()->setDatainmatricula(date('Y-m-d',time()));
        $FC->getObject()->setDatafimatricula(date('Y-m-d',time()));
        $FC->getObject()->setDatainici(date('Y-m-d',time()));        
    else:
        $OC = new Cursos();
        $OC->setSiteId($idS);
        $OC->setActiu(true); 
        $OC->setCodi($codi);
        $OC->setAdescomptes(0);
        $FC = new CursosForm($OC);                                	  	
  	endif;
        	
  	return $FC->getObject();
  }
  
  static public function getByCodi($codi,$idS)
  {
  	$C = new Criteria();
    $C = self::getCriteriaActiu($C,$idS);
  	$C->add(self::CODI, $codi);
  	$C->addDescendingOrderByColumn(self::IDCURSOS);
  	return self::doSelectOne($C); 	
  }  

  static public function toTrimestre($m,$y)
  {
    $RET = array();
    if( $m >= 1 && $m <=3 ) $RET = array('ID'=>"1-".$y, 'NOM'=> "Primer trimestre");
    elseif( $m > 3 && $m <=6 ) $RET = array('ID'=>"4-".$y, 'NOM'=> "Segon trimestre");
    elseif( $m > 6 && $m <=9 ) $RET = array('ID'=>"7-".$y, 'NOM'=> "Tercer trimestre");
    elseif( $m > 9 && $m <= 12 ) $RET = array('ID'=>"10-".$y, 'NOM'=> "Quart trimestre");
    else $RET = array('ID'=>0, 'NOM'=>'N/D');
    return $RET;
  }

  static public function getDatesCursosHospici($a_cursos)
  {
        
    $C = new Criteria();
    $C->add(self::ACTIU, true);        
    $C->add(self::IDCURSOS , $a_cursos , CRITERIA::IN );
    $C->addJoin(TipusPeer::IDTIPUS, self::CATEGORIA);
    
    $RET = array(); $SOL = array();
    
    $RET[0] = array('NOM' => "En el futur..." , 'COUNT'=>0);
    foreach(CursosPeer::doSelect($C) as $OC):
        $m = $OC->getDatainici('m');
        $y = $OC->getDatainici('Y');
        $TRIM = self::toTrimestre($m,$y);
        if(!isset($RET[$TRIM['ID']])) $RET[$TRIM['ID']] = array('NOM' => $TRIM['NOM'].' de '.$y, 'COUNT'=>0 );                
        $RET[$TRIM['ID']]['COUNT'] += 1;
        $RET[0]['COUNT'] += 1;
    endforeach;
            
    krsort($RET);
        
    foreach($RET as $K=>$V):
        $SOL[$K] = $V['NOM']." ({$V['COUNT']})";
    endforeach;
    
    return $SOL;
    
  }        

  static public function getCategoriaCursosHospici($a_cursos)
  {
    $C = new Criteria();
    $C->add(self::ACTIU, true);        
    $C->add(self::IDCURSOS , $a_cursos , CRITERIA::IN );
    $C->addJoin(TipusPeer::IDTIPUS, self::CATEGORIA);            
    
    $RET = array(); $SOL = array();
    
    $RET[0] = array('NOM' => "Totes les categories..." , 'COUNT'=>0);
    foreach(TipusPeer::doSelect($C) as $OT):
        if(!isset($RET[$OT->getIdtipus()])) $RET[$OT->getIdtipus()] = array('NOM' => $OT->getTipusdesc(),'COUNT'=>0);        
        $RET[$OT->getIdtipus()]['COUNT'] += 1;
        $RET[0]['COUNT'] += 1;
    endforeach;
        
    foreach($RET as $K=>$V):
        $SOL[$K] = $V['NOM']." ({$V['COUNT']})";
    endforeach;
    
    return $SOL; 
    
  }        
        
  static public function getEntitatCursosHospici($a_cursos)
  {
    $C = new Criteria();    
    $C->add(self::ACTIU, true);
    $C->add(self::IDCURSOS , $a_cursos , CRITERIA::IN );    
    $C->addJoin(CursosPeer::SITE_ID,SitesPeer::SITE_ID);        
    
    $RET = array(); $SOL = array();

    $RET[0] = array('NOM' => "Totes les entitats..." , 'COUNT'=>0);
    foreach(SitesPeer::doSelect($C) as $OS):
        if(!isset($RET[$OS->getSiteId()])) $RET[$OS->getSiteId()] = array('NOM' => $OS->getNom(),'COUNT'=>0);        
        $RET[$OS->getSiteId()]['COUNT'] += 1;
        $RET[0]['COUNT'] += 1;
    endforeach;
    
    foreach($RET as $K=>$V):
        $SOL[$K] = $V['NOM']." ({$V['COUNT']})";
    endforeach;
    
    return $SOL; 

  }        
         
  static public function getPoblacionsCursosHospici($a_cursos)
  {
    $C = new Criteria();    
    $C->add(self::ACTIU, true);
    $C->add(self::IDCURSOS , $a_cursos , CRITERIA::IN );
    $C->addJoin(CursosPeer::SITE_ID,SitesPeer::SITE_ID);    
    $C->addJoin(PoblacionsPeer::IDPOBLACIO, SitesPeer::POBLE);
    
    $RET = array(); $SOL = array();
    
    $RET[0] = array('NOM' => "Tots els pobles..." , 'COUNT'=>0);
    foreach(PoblacionsPeer::doSelect($C) as $OP):
        if(!isset($RET[$OP->getIdpoblacio()])) $RET[$OP->getIdpoblacio()] = array('NOM' => $OP->getNom(),'COUNT'=>0);        
        $RET[$OP->getIdpoblacio()]['COUNT'] += 1;
        $RET[0]['COUNT'] += 1;
    endforeach;
    
    foreach($RET as $K=>$V):
        $SOL[$K] = $V['NOM']." ({$V['COUNT']})";
    endforeach;
    
    return $SOL; 
  }
        
  static public function getCursosCercaHospici($idText, $idSite, $idPoble, $idCategoria, $idData,  $p)
  {
    
    $WHERE = "c.actiu = 1 AND s.actiu = 1 AND c.VisibleWEB = 1";
    
    //Miro primer què he de filtrar
    if(!empty($idText))  $WHERE .= " AND ( c.TitolCurs like '%$idText%' OR c.Descripcio like '%$idText%' OR c.Codi like '%$idText%' )";
    if(!empty($idSite))  $WHERE .= " AND ( c.site_id = $idSite ) ";
    if(!empty($idPoble)) $WHERE .= " AND ( c.site_id = s.site_id AND s.poble = $idPoble ) ";
    if(!empty($idCategoria)) $WHERE .= " AND ( c.Categoria = $idCategoria ) ";
            
    if(empty($idData) || $idData == 0)
    {
        $idData = date('Y-m-d',time());   
        $WHERE .= " AND c.DataFiMatricula > '$idData' ";
    }
    else 
    { 
        list($m,$y)= explode('-',$idData); 
        $idData = date('Y-m-d',mktime(0,0,0,$m,1,$y)); 
        $idDataf = date('Y-m-d',mktime(0,0,0,$m+3,1,$y));
        $WHERE .= " AND c.DataInici > '$idData' AND c.DataInici < '$idDataf' ";
    }    
        
        
    $SQL = "    SELECT c.idCursos as idC from cursos c, sites s
                 WHERE $WHERE     
    ";
    
    $connection = Propel::getConnection();
    $statement = $connection->prepare($SQL);        
    $statement->execute();
    $RET = array();
    
    //Guardo els elements resultats i els passo a un format Criteria    
    while($result = $statement->fetch(PDO::FETCH_ASSOC)) $RET[$result['idC']] = $result['idC'];
    
    //Ara fem la select dels cursos amb el pager
    $C = new Criteria();    
    $C->add(self::IDCURSOS , $RET , CRITERIA::IN );    
    $C->addAscendingOrderByColumn(self::CATEGORIA);
    $C->addAscendingOrderByColumn(self::SITE_ID);
    $pager = new sfPropelPager('Cursos', 20);
    $pager->setCriteria($C);
    $pager->setPage($p);
    $pager->init();    	                
       
    return array('PAGER'=>$pager,'LCURSOS'=>$RET);
    
  }
  
  /**
   * Funció que retorna si es pot matricular a un curs d'idiomes abans o no.
   * @param $idC IdCursos
   * @param $CURSOS_MATRICULATS Llistat dels cursos als que s'ha matriculat
   * */  
  static public function IsAnticAlumne( $idC , $CURSOS_MATRICULATS ){
  
    //Hem de comprovar que la persona ja s'ha matriculat a algun curs d'idiomes si idC és d'idiomes.
    $ANG = array(29,30,31,32,33,34,35,36,37,124,125,126,127,128,129,130,131,136,188,189,190,191,192,193,194,195,196,228,275,278,279,280,281,282,283,284,285,286,356,384,385,386,387,388,389,390,391,396,397,445,451,452,474,475,476,477,478,479,480,481);
    $FRA = array(41,42,43,44,132,133,134,135,184,185,186,187,276,277,287,288,289,290,358,392,393,394,395,482,483,484,485,486);
    $ART = array(374,375,376,377,378,379,380,381,382,383,402,403,404,405,406,407,408,409,431,432,433,434,435,436,437,438,464,465,466,467,468,469,470,471,472,473,492,493);
    
    //El curs actual és un curs d'anglès?
    $exist = false;
    if(in_array($idC,$ANG)){
      foreach($CURSOS_MATRICULATS as $idC => $idM) if(in_array($idC,$ANG)) $exist = true;        
    }elseif(in_array($idC,$FRA)){
      foreach($CURSOS_MATRICULATS as $idC => $idM) if(in_array($idC,$FRA)) $exist = true;
    }elseif(in_array($idC,$ART)){
      foreach($CURSOS_MATRICULATS as $idC => $idM) if(in_array($idC,$ART)) $exist = true;      
    }

    return $exist;    
    
  }
  
}
