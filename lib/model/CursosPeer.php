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

   const ACTIU = 1;
   const PASSAT = 0;   
   
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
		 	  	  	  
  	$C->addDescendingOrderByColumn( self::DATAAPARICIO );
  	$C->addAscendingOrderByColumn( self::CATEGORIA ); 	  	
  	$C->addDescendingOrderByColumn( self::TITOLCURS );
  		
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
  	$C->addDescendingOrderByColumn( self::DATAAPARICIO );	

  	foreach(self::doSelect($C) as $CURS): 
  		$RET[$CURS->getIdcursos()] = $CURS->getCodi().' - '.$CURS->getTitolcurs();
  	endforeach;
  	
  	return $RET;  	
  	
  }
  
  static function getCursos($mode = self::ACTIU , $PAGINA = 1, $CERCA = "")
  {
  	$C = new Criteria();  	
  	if($mode == self::ACTIU): $C->add(self::ISACTIU , true); else: $C->add(self::ISACTIU , false); endif;  	
  	$C->addAscendingOrderByColumn( self::CATEGORIA );
  	$C->addDescendingOrderByColumn( self::DATADESAPARICIO );
  	$C->addAscendingOrderByColumn( self::CODI );
  	
  	
  	if(!empty($CERCA)):
  		$C1 = $C->getNewCriterion(self::CODI, "%$CERCA%" , CRITERIA::LIKE);
  		$C2 = $C->getNewCriterion(self::TITOLCURS , "%$CERCA%" , CRITERIA::LIKE );
		$C1->addOr($C2); $C->add($C1);  		  	
  	endif; 

  	$pager = new sfPropelPager('Cursos', 30);
	$pager->setCriteria($C);
	$pager->setPage($PAGINA);
	$pager->init();  	
  	
  	return $pager;  	
  }
  
  static function getTotsCursos($PAGINA = 1)
  {
  	$C = new Criteria();  	  	  
    $C->addAscendingOrderByColumn( self::CATEGORIA );
  	$C->addDescendingOrderByColumn( self::DATAAPARICIO );
  	
  	$pager = new sfPropelPager('Cursos', 20);
	$pager->setCriteria($C);
	$pager->setPage($PAGINA);
	$pager->init();  	
  	return $pager;  	
  }
      
  static function getMatricules($idC)
  {
  	$Curs = self::retrieveByPK($idC);  	
  	return $Curs->getMatriculess();
  }

  static function getPlaces($idC)
  {
     
     $CURS = self::retrieveByPK($idC); $C = new Criteria();
     $C->addOr(MatriculesPeer::ESTAT , MatriculesPeer::ACCEPTAT_NO_PAGAT );
     $C->addOr(MatriculesPeer::ESTAT , MatriculesPeer::ACCEPTAT_PAGAT );
     $MATRICULES = $CURS->countMatriculess($C);
     $PLACES = $CURS->getPlaces();
     return array('OCUPADES'=>$MATRICULES , 'TOTAL'=>$PLACES);
          
  }
  
  public function isPle()
  {          
     $PLACES = CursosPeer::getPlaces($this->idcursos);
     return ($PLACES['OCUPADES'] >= $PLACES['TOTAL']);              
  }
        
  static function CalculaPreu($IDCURS , $DESCOMPTE)
  {            
     $PLACES = CursosPeer::getPlaces($IDCURS);
     if($PLACES['OCUPADES'] >= $PLACES['TOTAL']) $DESCOMPTE = MatriculesPeer::REDUCCIO_GRATUIT;

     $CURS = CursosPeer::retrieveByPK($IDCURS);
     
     switch($DESCOMPTE){
         case MatriculesPeer::REDUCCIO_CAP : return $CURS->getPreu();
         case MatriculesPeer::REDUCCIO_ATURAT : return $CURS->getPreur();
         case MatriculesPeer::REDUCCIO_JUBILAT : return $CURS->getPreur();
         case MatriculesPeer::REDUCCIO_MENOR_25_ANYS : return $CURS->getPreur();
         case MatriculesPeer::REDUCCIO_GRATUIT   : return 0;           
      }                  
  }
  
  
  static function CalculaTotalPreus($CURSOS,$DESCOMPTE)
  {   
     $Preu = 0;
     foreach($CURSOS as $C):
        $Preu += self::CalculaPreu($C , $DESCOMPTE);
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
    
  static public function getCopyCursByCodi($codi)
  {
  	$OCurs = self::getByCodi($codi);
  	
  	$O2 = new Cursos();
  	$O2->setCodi($codi);
  	
  	if($OCurs instanceof Cursos):
  		$O2->setTitolcurs($OCurs->getTitolcurs());
  		$O2->setPlaces($OCurs->getPlaces());  		
  		$O2->setDescripcio($OCurs->getDescripcio());
  		$O2->setPreu($OCurs->getPreu());
  		$O2->setPreur($OCurs->getPreur());
  		$O2->setHoraris($OCurs->getHoraris());
  		$O2->setCategoria($OCurs->getCategoria());
  		$O2->setOrdresortida($OCurs->getOrdresortida());  		  	
  	endif;
  	
  	return $O2;
  }
  
  static public function getByCodi($codi)
  {
  	$C = new Criteria();
  	$C->add(self::CODI, $codi);
  	$C->addDescendingOrderByColumn(self::IDCURSOS);
  	return self::doSelectOne($C); 	
  }
  
}
