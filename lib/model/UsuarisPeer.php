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
  
  static public function initialize( $idU , $idS , $isMatricules = false , $isWeb = false )
  {
    $OU = UsuarisPeer::retrieveByPK($idU);            
	if(!($OU instanceof Usuaris)):            		
		$OU = new Usuaris();
        $OU->setSiteId($idS);        
        $OU->setActiu(true);
		$OU->setNivellsIdnivells(2);
    	$OU->setHabilitat(true);     
	endif; 

    if($isMatricules):
        return new UsuarisMatriculesForm($OU);
    elseif($isWeb):
        return new ClientUsuarisForm($OU);
    else:
        return new UsuarisForm($OU);
    endif; 			    

  }
  
  //Comprovem que l'usuari pertanyi a un SITE
  static public function getCriteriaActiu( $C , $idS = null )
  {        
    $C->add(self::ACTIU, true);
    if(!is_null($idS)):
        $C->addJoin(UsuarisSitesPeer::USUARI_ID, self::USUARIID);
        $C->add(UsuarisSitesPeer::SITE_ID, $idS);
    endif; 
    
    return $C;
  }
     
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
    
  
  static function cercaTotsCamps( $text , $PAGINA = 1 , $idS )
  {
    $C = new Criteria();
    $C = self::CriteriaCerca($text,$C);
    $C = self::getCriteriaActiu( $C , $idS );
            
    $pager = new sfPropelPager('Usuaris', 10);
    $pager->setCriteria($C);
    $pager->setPage($PAGINA);
    $pager->init();
       
    return $pager;
     
  }
  
  
  static function cercaTotsCampsSelect($text,$limit)
  {
        
    $RET = array(); 
    
    $C = self::CriteriaCerca($text,new Criteria());    
    $C->setLimit($limit);

    foreach(self::doSelect($C) as $U):
  		$RET[$U->getUsuariid()] = array('clau'=>$U->getUsuariid(),'text'=>$U->getDni().' - '.$U->getNomComplet());  		
  	endforeach;
       
    return $RET;
     
  }
  
  static function CriteriaCerca($text,$C)
  {
  	
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

    return $C;
    
  }
    
  static function selectTreballadors($idS)
  {
    $C = new Criteria();
    $C = self::getCriteriaActiu($C,$idS);
    
    $C->add(UsuarisPeer::NIVELLS_IDNIVELLS,UsuarisPeer::ADMIN);
    $C->addAscendingOrderByColumn(UsuarisPeer::COG1);
    $C->addAscendingOrderByColumn(UsuarisPeer::COG2);
    $C->addAscendingOrderByColumn(UsuarisPeer::NOM);
    $C->add(UsuarisPeer::HABILITAT , true);
    $TREB = self::doSelect($C);
    $RET = array();

    foreach($TREB as $T):
      
      $RET[$T->getUsuariid()] = $T->getNom()." ".$T->getCog1();    
    
    endforeach;
  
    return $RET;
  
  }
  
  static function selectAllUsers()
  {
    
    $C = new Criteria();        
    
    $C->addAscendingOrderByColumn(self::COG1);
    $C->addAscendingOrderByColumn(self::NOM);
    $C->add(self::HABILITAT , true);
    $C->add(self::ACTIU, true);
    
    $TREB = self::doSelect($C);
    $RET = array();

    foreach($TREB as $T):
      
      $RET[$T->getUsuariid()] = strtoupper(self::uc_latin1($T->getNomComplet()));    
    
    endforeach;
  
    return $RET;
    
    
  }

  static function selectUsuaris($idS)
  {
    $C = new Criteria();    
    $C = self::getCriteriaActiu($C,$idS);
    
    $C->addAscendingOrderByColumn(UsuarisPeer::COG1);
//    $C->addAscendingOrderByColumn(UsuarisPeer::COG2);
    $C->addAscendingOrderByColumn(UsuarisPeer::NOM);
    $C->add(UsuarisPeer::HABILITAT , true);
    
    $TREB = self::doSelect($C);
    $RET = array();

    foreach($TREB as $T):
      
      $RET[$T->getUsuariid()] = strtoupper(self::uc_latin1($T->getNomComplet()));    
    
    endforeach;
  
    return $RET;
  
  }
 

  static function uc_latin1($str)
  {
  	$LATIN1_UC_CHARS = "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝ";
    $LATIN1_LC_CHARS = "àáâãäåæçèéêëìíîïðñòóôõöøùúûüý";
    
	$str = strtoupper(strtr($str, $LATIN1_LC_CHARS, $LATIN1_UC_CHARS));
	return strtr($str, array("ß" => "SS"));
	    
  }
  
  
  static function getUserLogin($login,$password,$idS)
  {
  	
	$C = new Criteria();    
    $C = self::getCriteriaActiu($C,$idS);
    
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
  
  static public function getNom($idU)
  {
  	return UsuarisPeer::retrieveByPK($idU)->getNomComplet();
  }
   
  static public function canSeeComptabilitat($idU)
  {
  	$usuaris = array(1,2,4,6,9,11,24);
  	return (in_array($idU,$usuaris)); 
  }        
    
  static public function addSite($idU,$idS)
  {
    UsuarisSitesPeer::initialize($idU,$idS,false)->getObject()->save();    
  }
    
}
