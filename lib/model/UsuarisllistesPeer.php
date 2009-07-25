<?php

/**
 * Subclass for performing query and update operations on the 'usuarisllistes' table.
 *
 * 
 *
 * @package lib.model
 */ 
class UsuarisllistesPeer extends BaseUsuarisllistesPeer
{

  static public function Vincula($U , $IDL)
  {     
     $ULP = new Usuarisllistes();
     $ULP->setUsuarisUsuarisid($U);
     $ULP->setLlistesIdllistes($IDL);
     $ULP->save();
  }
  
  static public function Desvincula($U , $IDL)
  {
     $C = new Criteria();
     $C->add(self::USUARIS_USUARISID , $U);
     $C->add(self::LLISTES_IDLLISTES , $IDL);     
     foreach(self::doSelect($C) as $ULP) $ULP->delete();     
  }
   
  static private function CercaUsuaris($CERCA = "")
  {
    $C = new Criteria();
    if(empty($CERCA)) return $C;
    
    foreach(explode(" ", $CERCA) as $P):
      $P = trim($P);
                  
      $C1 = $C->getNewCriterion(UsuarisPeer::DNI, "%$P%", CRITERIA::LIKE);
      $C1->addOr($C->getNewCriterion(UsuarisPeer::NOM, "%$P%", CRITERIA::LIKE));
      $C1->addOr($C->getNewCriterion(UsuarisPeer::COG1, "%$P%", CRITERIA::LIKE));
      $C1->addOr($C->getNewCriterion(UsuarisPeer::COG2, "%$P%", CRITERIA::LIKE));                  
      $C->addAnd($C1);     
      
    endforeach;
    return $C;
  } 
   

  static public function getUsuarisLlista( $CERCA , $IDL , $PAGINA )
  {
          
     $C = self::CercaUsuaris($CERCA);     
     $C->add(UsuarisllistesPeer::LLISTES_IDLLISTES , $IDL);     
     $C->addJoin(UsuarisllistesPeer::USUARIS_USUARISID , UsuarisPeer::USUARIID);
     
     $pager = new sfPropelPager('Usuaris', 10);
     $pager->setCriteria($C);
     $pager->setPage($PAGINA);
     $pager->init();
     return $pager;

  } 
  
  static public function getUsuarisNoLlista( $CERCA , $IDL , $PAGINA )
  {
     //$C = new Criteria();
     
     $C = self::CercaUsuaris($CERCA);
     $C->addGroupByColumn(UsuarisPeer::USUARIID);
     
     $pager = new sfPropelPager('Usuaris', 10);
     $pager->setCriteria($C);
     $pager->setPage($PAGINA);
     $pager->init();
     return $pager;

  } 
  
  
  static public function getUsuarisLlistaEmail($idL)
  {
     
     $C = new Criteria(); $RET = array();
     $C->add(UsuarisllistesPeer::LLISTES_IDLLISTES , $idL);
     foreach(UsuarisllistesPeer::doSelect($C) as $UL):
        $email = $UL->getUsuaris()->getEmail();           
        if(self::comprobar_email($email)) $RET[] = $email;
     endforeach;

     return $RET;
  }
  
  static public function getLlistesUsuari($idU){
     
     $C = new Criteria();
     $C->add(UsuarisllistesPeer::USUARIS_USUARISID , $idU);
     
     $SELECT = array();
     foreach(self::doSelect($C) as $L):        
        $SELECT[$L->getLlistesIdllistes()] = $L->getLlistes()->getNom(); 
     endforeach;
          
     return $SELECT;
  }  
  
  static public function saveUsuarisLlistes($LLISTA = array() , $idU = 0)
  {

     $C = new Criteria();
     $C->add( self::USUARIS_USUARISID , $idU );
     
     //Finalment esborrem totes les files antigues
     foreach(self::doSelect($C) as $L) $L->delete();      
     
     //Entrem les noves dades
     if(isset($LLISTA)):
	     foreach($LLISTA as $V):        
	        $L = new Usuarisllistes(); $L->setNew(true);        
	        $L->setUsuarisUsuarisid($idU);
	        $L->setLlistesIdllistes($V);     
	        $L->save();
	     endforeach;
	 endif;     
  }
  
  
  static private function comprobar_email($email){
    $mail_correcto = 0;
    //compruebo unas cosas primeras
    if ((strlen($email) >= 6) && (substr_count($email,"@") == 1) && (substr($email,0,1) != "@") && (substr($email,strlen($email)-1,1) != "@")){
       if ((!strstr($email,"'")) && (!strstr($email,"\"")) && (!strstr($email,"\\")) && (!strstr($email,"\$")) && (!strstr($email," "))) {
          //miro si tiene caracter .
          if (substr_count($email,".")>= 1){
             //obtengo la terminacion del dominio
             $term_dom = substr(strrchr ($email, '.'),1);
             //compruebo que la terminación del dominio sea correcta
             if (strlen($term_dom)>1 && strlen($term_dom)<5 && (!strstr($term_dom,"@")) ){
                //compruebo que lo de antes del dominio sea correcto
                $antes_dom = substr($email,0,strlen($email) - strlen($term_dom) - 1);
                $caracter_ult = substr($antes_dom,strlen($antes_dom)-1,1);
                if ($caracter_ult != "@" && $caracter_ult != "."){
                   $mail_correcto = 1;
                }
             }
          }
       }
    }
    if ($mail_correcto)
       return 1;
    else
       return 0;
} 
  
}
