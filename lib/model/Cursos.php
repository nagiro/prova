<?php

/**
 * Subclass for representing a row from the 'cursos' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Cursos extends BaseCursos
{
  /**
   * Retorna el nombre de matriculats que hi ha a un curs
   *
   * @return INT
   */
  public function countMatriculats($idS)
  {  
     $C = new Criteria();
     $C = MatriculesPeer::getCriteriaActiu($C,$idS); 
     $C->addOr(MatriculesPeer::ESTAT , MatriculesPeer::ACCEPTAT_NO_PAGAT );
     $C->addOr(MatriculesPeer::ESTAT , MatriculesPeer::ACCEPTAT_PAGAT );
     return self::countMatriculess($C);          
  }
  
  public function getMatriculats()
  {
     $C = new Criteria(); 
//     $C->addOr(MatriculesPeer::ESTAT , MatriculesPeer::ACCEPTAT_NO_PAGAT );
//     $C->addOr(MatriculesPeer::ESTAT , MatriculesPeer::ACCEPTAT_PAGAT );
     $C->addAscendingOrderByColumn(MatriculesPeer::ESTAT);
     return self::getMatriculess($C);
  }
  
  public function getCategoriaText()
  {  	
  	return TipusPeer::retrieveByPk($this->getCategoria())->getTipusDesc();
  }
  
  public function countMatriculesActives($idS)
  {
     $C = new Criteria();
     $C = MatriculesPeer::getCriteriaActiu($C,$idS);          
     $C1 = $C->getNewCriterion(MatriculesPeer::ESTAT, MatriculesPeer::ACCEPTAT_NO_PAGAT );
     $C2 = $C->getNewCriterion(MatriculesPeer::ESTAT , MatriculesPeer::ACCEPTAT_PAGAT );
     $C1->addOr($C2); $C->add($C1);
     $C->add(MatriculesPeer::CURSOS_IDCURSOS, $this->getIdcursos());     
     return MatriculesPeer::doCount($C);
  }
 
  public function getPlacesArray()
  {
    return CursosPeer::getPlaces($this->getIdcursos(),$this->getSiteId());
  }
  
  public function CalculaPreu($DESCOMPTE)
  {
    return CursosPeer::CalculaPreu($this->getIdcursos(), $DESCOMPTE, $this->getSiteId());
  }
}
