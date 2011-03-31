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
  
  static function getCursos($mode = self::CURSACTIU , $PAGINA = 1, $CERCA = "" , $idS )
  {
  	$C = new Criteria();  	
    $C = self::getCriteriaActiu($C,$idS);
  	if($mode == self::CURSACTIU): $C->add(self::ISACTIU , true); else: $C->add(self::ISACTIU , false); endif;        	
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
     $PLACES = CursosPeer::getPlaces( $IDC , $idS );
     return ($PLACES['OCUPADES'] >= $PLACES['TOTAL']);              
  }
        
  static function CalculaPreu($IDCURS , $DESCOMPTE , $idS )
  {            
     $PLACES = CursosPeer::getPlaces( $IDCURS , $idS );
     if($PLACES['OCUPADES'] >= $PLACES['TOTAL']) $DESCOMPTE = MatriculesPeer::REDUCCIO_GRATUIT;

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
  
  static public function getCursosHospici($idText, $idSite, $idPoble, $idCategoria, $idData, $aDates = null, $hasPobles = false)
  {
    //Segons text
    $text = (!is_null($idText) && !empty($idText))?" AND (c.TitolCurs like '%{$idText}%' OR c.Descripcio like '%{$idText}%')":"";
    
    //Segons poble    
    $poble = (!is_null($idPoble) && $idPoble > 0)?' AND p.idPoblacio = '.$idPoble:'';    
    
    //Hem de buscar segons idCategoria.
    $categoria = (!is_null($idCategoria) && $idCategoria > 0)?' AND c.Categoria = '.$idCategoria:'';
    
    $d = hospiciActions::getDatesCercadorHospici($idData,$aDates);
    $datai = $d['datai']; $dataf = $d['dataf'];

//    DataAparicio
//    DataDesaparicio
//    DataFiMatricula
//    DataInici

    //Si busquem una data, ha de ser inferior a la data de desaparicio i d'inici de curs
    $data = " AND c.DataAparicio <= {$dataf} AND c.DataDesaparicio >= {$datai} AND c.DataInici >= {$datai} ";

    $connection = Propel::getConnection();        
    $query = 
            "
                Select c.idCursos as idC, p.idPoblacio as idP, p.Nom as pobleNom
                  from cursos c
                  LEFT JOIN sites s ON (c.site_id = s.site_id)
                  LEFT JOIN poblacions p ON (p.idPoblacio = s.poble)  
                WHERE 
                   c.actiu = 1 AND s.actiu = 1                    
                   {$text}
                   {$poble}
                   {$categoria}
                   {$data}                   
                 GROUP BY idC,idP,pobleNom                     
            ";           
    echo $query;
    die;        
    $statement = $connection->prepare($query);        
    $statement->execute();
    $RET = array();
    
    //Guardo els elements resultats i els passo a un format Criteria    
    while($result = $statement->fetch(PDO::FETCH_ASSOC)){
        if($hasPobles):
            $RET[$result['idP']][$result['idA']] = $result['idA'];
        else:
            $RET[$result['idA']] = $result['idA'];
        endif;   
    }

    //Ja hem superat la data d'aparició i encara no 
    $C->add(self::DATAAPARICIO, $datai, Criteria::LESS_THAN );
    $C->add(self::DATADESAPARICIO, $datai, Criteria::GREATER_EQUAL);

  }
  
}
