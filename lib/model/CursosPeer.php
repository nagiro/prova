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
     $CATEGORIES = array(
        'Artesania i arts aplicades' => 'Artesania i arts aplicades' ,
        'Noves tecnologies' => 'Noves tecnologies' ,
        'Artesania i arts aplicades' => 'Artesania i arts aplicades' ,
     	'Estudi de Fotografia' => 'Estudi de Fotografia' ,
     	'Humanitats' => 'Humanitats' ,
     	'Idiomes' => 'Idiomes' ,        
     	'Psicologia Aplicada' => 'Psicologia Aplicada' ,
     	'Sociologia i psicologia aplicades' => 'Sociologia i psicologia aplicades' );
     
     return $CATEGORIES;
  }
  
  static function getCursos($mode = self::ACTIU , $PAGINA = 1)
  {
  	$C = new Criteria();  	
  	if($mode == self::ACTIU): $C->add(self::ISACTIU , true); else: $C->add(self::ISACTIU , false); endif;  	
  	$C->addDescendingOrderByColumn( self::DATAAPARICIO );
  	$C->addAscendingOrderByColumn( self::CATEGORIA );

  	$pager = new sfPropelPager('Cursos', 10);
	$pager->setCriteria($C);
	$pager->setPage($PAGINA);
	$pager->init();  	
  	
  	return $pager;  	
  }
  
  static function getTotsCursos($PAGINA = 1)
  {
  	$C = new Criteria();  	  	  
  	$C->addDescendingOrderByColumn( self::DATAAPARICIO );
  	$C->addAscendingOrderByColumn( self::CATEGORIA );

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
    
}
