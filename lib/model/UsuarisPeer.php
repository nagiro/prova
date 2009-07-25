<?php

/**
 * Subclass for performing query and update operations on the 'usuaris' table.
 *
 * 
 *
 * @package lib.model
 */ 
class UsuarisPeer extends BaseUsuarisPeer
{
     
  const ADMIN = 1;
  const REGISTERED = 2;
   
  static function cercaDNI($DNI)
  {
    $C = new Criteria();
    $C->add(self::DNI, $DNI, Criteria::EQUAL);
    return self::doSelectOne($C);
  }
  
  static function hasDNI($DNI)
  {
    $C = new Criteria();
    $C->add( self::DNI , $DNI , Criteria::EQUAL );
    return ( self::doCount($C) > 0 ); 
  }
    
  
  static function cercaTotsCamps($text, $PAGINA = 1)
  {
    
    $C   = new Criteria();
    
    foreach(explode(' ',$text) as $PARAULA):        
	    $C1  = $C->getNewCriterion(self::DNI, '%'.$PARAULA.'%', Criteria::LIKE);
	    $C2  = $C->getNewCriterion(self::NOM, '%'.$PARAULA.'%', Criteria::LIKE);
	    $C3  = $C->getNewCriterion(self::COG1, '%'.$PARAULA.'%', Criteria::LIKE);
	    $C4  = $C->getNewCriterion(self::COG2, '%'.$PARAULA.'%', Criteria::LIKE);
	    $C5  = $C->getNewCriterion(self::EMAIL, '%'.$PARAULA.'%', Criteria::LIKE);
	    $C6  = $C->getNewCriterion(self::ADRECA, '%'.$PARAULA.'%', Criteria::LIKE);
	    $C7  = $C->getNewCriterion(self::POBLACIO, '%'.$PARAULA.'%', Criteria::LIKE);
	    $C8  = $C->getNewCriterion(self::TELEFON, '%'.$PARAULA.'%', Criteria::LIKE);
	    $C9  = $C->getNewCriterion(self::MOBIL, '%'.$PARAULA.'%', Criteria::LIKE);
	    $C10 = $C->getNewCriterion(self::ENTITAT, '%'.$PARAULA.'%', Criteria::LIKE);    
	    $C1->addOr($C2);  $C1->addOr($C3); $C1->addOr($C4); $C1->addOr($C5);
	    $C1->addOr($C6);  $C1->addOr($C7); $C1->addOr($C8); $C1->addOr($C9);
	    $C1->addOr($C10); $C->addAnd($C1);
    endforeach;
            
    $pager = new sfPropelPager('Usuaris', 10);
    $pager->setCriteria($C);
    $pager->setPage($PAGINA);
    $pager->init();
       
    return $pager;
     
  }
  
  static function selectTreballadors()
  {
    $C = new Criteria();
    $C->add(UsuarisPeer::NIVELLS_IDNIVELLS,UsuarisPeer::ADMIN);
    $C->addAscendingOrderByColumn(UsuarisPeer::NOM);
    $C->add(UsuarisPeer::HABILITAT , true);
    $TREB = self::doSelect($C);
    $RET = array();

    foreach($TREB as $T):
      
      $RET[$T->getUsuariid()] = $T->getNom()." ".$T->getCog1();    
    
    endforeach;
  
    return $RET;
  
  }
  
  static function getUserLogin($login,$password)
  {
  	
	$C = new Criteria();
	$C->add(self::DNI , $login );
	$C->add(self::PASSWD, $password);
	return self::doSelectOne($C);       
  }
  
  static function isLogined($user,$pass = "")
  {
  	
  	$C = new Criteria();
  	$C->add(self::DNI , $user);
  	$C->add(self::PASSWD , $pass );
  	
  	return (self::doCount($C) == 1);
  	
  }
  
	
}
