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
  public function countMatriculats()
  {  
     $C = new Criteria(); 
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
  
}
