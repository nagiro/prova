<?php

/**
 * Subclass for performing query and update operations on the 'reservaespais' table.
 *
 * 
 *
 * @package lib.model
 */ 
class ReservaespaisPeer extends BaseReservaespaisPeer
{

  const EN_ESPERA = 0;
  const ACCEPTADA = 1;
  const DENEGADA  = 2; 
  const ANULADA   = 3;

  
  static function selectEstat()
  {
     return array(
                    self::EN_ESPERA => 'En espera' ,
                    self::ACCEPTADA => 'Acceptada' ,
                    self::DENEGADA  => 'Denegada',
                    self::ANULADA   => 'Anul·lada', 
     );
  }
  
  /**
    * Mostra les reserves pendents que tenim
    *
    * @param int $Pagina
    * @return Reservaespais
    */
   static function getReservesPendents()
   {
      $C = new Criteria();
      $C->add( ReservaespaisPeer::ESTAT , ReservaespaisPeer::EN_ESPERA , CRITERIA::EQUAL);
      return ReservaespaisPeer::doSelect($C);
   }
   
   static function getReservesSelect($CERCA = "" , $Pagina = 1)
   {
      $C = new Criteria();
      if(!empty($CERCA)):
	      $C1 = $C->getNewCriterion(self::NOM , '%'.$CERCA.'%', CRITERIA::LIKE);
	      $C2 = $C->getNewCriterion(self::REPRESENTACIO , '%'.$CERCA.'%', CRITERIA::LIKE);
	      $C3 = $C->getNewCriterion(self::RESPONSABLE , '%'.$CERCA.'%', CRITERIA::LIKE);
	      $C4 = $C->getNewCriterion(self::PERSONALAUTORITZAT , '%'.$CERCA.'%', CRITERIA::LIKE);
	      $C5 = $C->getNewCriterion(self::ORGANITZADORS , '%'.$CERCA.'%', CRITERIA::LIKE);
	      $C6 = $C->getNewCriterion(self::DATAACTIVITAT , '%'.$CERCA.'%', CRITERIA::LIKE);
	      
	      $C7 = $C->getNewCriterion(UsuarisPeer::NOM , '%'.$CERCA.'%', CRITERIA::LIKE);
	      $C8 = $C->getNewCriterion(UsuarisPeer::DNI , '%'.$CERCA.'%', CRITERIA::LIKE);
	      $C9 = $C->getNewCriterion(UsuarisPeer::COG1 , '%'.$CERCA.'%', CRITERIA::LIKE);
	      $C10 = $C->getNewCriterion(UsuarisPeer::COG2 , '%'.$CERCA.'%', CRITERIA::LIKE);
	            
	      $C1->addOr($C2); $C1->addOr($C3); $C1->addOr($C4); $C1->addOr($C5); $C1->addOr($C6); 
	      $C1->addOr($C7); $C1->addOr($C8); $C1->addOr($C9); $C1->addOr($C10);
	      
	      $C->add($C1);
	      
	  endif;
      
      $C->addDescendingOrderByColumn(self::DATAALTA);
      
                 
      $P = new sfPropelPager('Reservaespais', 20);
      $P->setPeerMethod('doSelectJoinUsuaris');
      $P->setCriteria($C);
      $P->setPage($Pagina);
      $P->init();
      return $P;      
            
   }
   
   
   /**
    * Funció que retorna un pager amb totes les reserves que s'han demanat ordenades per data d'entrada
    *
    * @param int $Pagina
    * @return sfPropelPager
    */
   static function getReserves($Pagina = 0)
   {
        $C = new Criteria();           
        $P = new sfPropelPager('Reservaespais', 10);
        $P->setCriteria($C);
        $P->setPage($Pagina);
        $P->init();
        return $P; 
   }
   
   /**
    * Funció que retorna les reserves que ha fet un usuari
    *
    * @param int $idU
    * @return Reservaespais
    */
   static function getReservesUsuaris($idU)
   {
      $C = new Criteria();
      $C->add(ReservaespaisPeer::USUARIS_USUARIID , $idU);
      return ReservaespaisPeer::doSelect($C);
   }
   
   /**
    * Desa un registre
    *
    * @param array $D
    * @param int $IDU
    * @param int $IDR
    * @return bool/Reservaespais
    */
   static function save( $D = array(), $IDU = 0 , $IDR = 0 )   
   {
      $R = new Reservaespais(); $RETURN = array();
      
      if($IDR > 0) { $R = ReservaespaisPeer::retrieveByPK($IDR);  $R->setNew(false);  }
       
      if($IDU > 0) $R->setUsuarisUsuariid($IDU);
      if(!empty($D['REPRESENTACIO'])) $R->setRepresentacio($D['REPRESENTACIO']);
      if(!empty($D['RESPONSABLE'])) $R->setResponsable($D['RESPONSABLE']);
      if(!empty($D['PERSONALAUTORITZAT'])) $R->setPersonalautoritzat($D['PERSONALAUTORITZAT']);
      if(!empty($D['PREVISIOASSISTENTS'])) $R->setPrevisioassistents($D['PREVISIOASSISTENTS']);
      if(!empty($D['ESCICLE'])) $R->setEscicle($D['ESCICLE']);
      if(!empty($D['EXEMPCIO'])) $R->setExempcio($D['EXEMPCIO']);
      if(!empty($D['PRESSUPOST'])) $R->setPressupost($D['PRESSUPOST']);
      if(!empty($D['COLLABORACIO'])) $R->setColaboracioccg($D['COLLABORACIO']);
      if(!empty($D['COMENTARIS'])) $R->setComentaris($D['COMENTARIS']);
      if(!empty($D['ESTAT'])) $R->setEstat($D['ESTAT']); else $R->setEstat(self::EN_ESPERA);
      if(!empty($D['DATAALTA'])) $R->setDataalta(date('Y-m-d',time()));
      if(!empty($D['ORGANITZADORS'])) $R->setOrganitzadors($D['ORGANITZADORS']);
      if(!empty($D['DATAACTIVITAT'])) $R->setDataactivitat($D['DATAACTIVITAT']);
      if(!empty($D['HORARIACTIVITAT'])) $R->setHorariactivitat($D['HORARIACTIVITAT']);
      if(!empty($D['TIPUSACTE'])) $R->setTipusacte($D['TIPUSACTE']);
      if(!empty($D['NOM'])) $R->setNom($D['NOM']);
      if(!empty($D['ISENREGISTRABLE'])) $R->setIsenregistrable($D['ISENREGISTRABLE']);
      if(!empty($D['ESPAIS'])) $R->setEspaissolicitats(implode('@',$D['ESPAIS']));
      if(!empty($D['MATERIAL'])) $R->setMaterialsolicitat(implode('@',$D['MATERIAL']));
      $R->setDataalta(date('Y-m-d',time()));
      $ERRORS = $R->check(); if(empty($ERRORS)) { $R->save(); }      
      return $R;
            
   }
      
}
