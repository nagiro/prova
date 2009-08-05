<?php

/**
 * Subclass for performing query and update operations on the 'matricules' table.
 *
 * 
 *
 * @package lib.model
 */ 
class MatriculesPeer extends BaseMatriculesPeer
{

   const ACCEPTAT_PAGAT = "A";
   const ACCEPTAT_NO_PAGAT = "B";
   const EN_ESPERA = "C";   
   const ERROR = "D";
   const BAIXA = "B";
   const CANVI_GRUP = "G";
   const PROCES_PAGAMENT = "P";            //Truncat abans del pagament
      
   const REDUCCIO_CAP             = '0';
   const REDUCCIO_MENOR_25_ANYS   = '1';
   const REDUCCIO_JUBILAT         = '2';
   const REDUCCIO_ATURAT          = '3';
   const REDUCCIO_GRATUIT         = '4';
   
   const PAGAMENT_METALIC         = '0';
   const PAGAMENT_TARGETA         = '1';
   const PAGAMENT_TELEFON         = '2';
   const PAGAMENT_TRANSFERENCIA   = '3';
   
   
  static function QuantesAvui()
  {
     $C = new Criteria();
     $time = mktime(null,null,null,date('m'),date('d')-1,date('Y'));
     $C->add(self::DATAINSCRIPCIO , $time , Criteria::GREATER_EQUAL );
     return self::doCount($C);     
  }
   
  static function selectDescomptes()
  {
     return array(
              self::REDUCCIO_CAP => 'Cap',
              self::REDUCCIO_MENOR_25_ANYS => 'Estudiant menor de 25 anys',
              self::REDUCCIO_JUBILAT => 'Jubilat',
              self::REDUCCIO_ATURAT => 'Aturat',
              self::REDUCCIO_GRATUIT => 'Gratuit'
            );
  }
  
  static function textDescomptes($D)
  {  
      switch($D){
         case self::REDUCCIO_CAP : return 'Cap';
         case self::REDUCCIO_MENOR_25_ANYS : return 'Estudiant menor de 25 anys';
         case self::REDUCCIO_JUBILAT : return 'Jubilat';
         case self::REDUCCIO_ATURAT : return 'Aturat';
      }
  }
  
  static function selectPagament()
  {
      return array(
         self::PAGAMENT_METALIC => 'Metal·lic',
         self::PAGAMENT_TARGETA => 'Targeta',
         self::PAGAMENT_TELEFON => 'Telèfon',
         self::PAGAMENT_TRANSFERENCIA => 'Transferència'
      );  
  }

  static function textPagament($P)
  {  
      switch($P){
         case self::PAGAMENT_METALIC : return 'Metal·lic a secretaria';
         case self::PAGAMENT_TARGETA : return 'Targeta de crèdit';
         case self::PAGAMENT_TELEFON : return 'Matrícula per telèfon';
         case self::PAGAMENT_TRANSFERENCIA : return 'Ingrés bancari';
      }
  }
  
  static function cercaCursos($CERCA , $PAGINA = 1)
  {     

     $C = new Criteria();
         
     $C1 = $C->getNewCriterion(CursosPeer::CODI, '%'.$CERCA.'%',CRITERIA::LIKE);
     $C2 = $C->getNewCriterion(CursosPeer::TITOLCURS, '%'.$CERCA.'%',CRITERIA::LIKE);
     $C3 = $C->getNewCriterion(CursosPeer::CATEGORIA, '%'.$CERCA.'%',CRITERIA::LIKE);	               
     $C1->addOr($C2); $C1->addOr($C3);	$C->add($C1);
     
     $C->addDescendingOrderByColumn(CursosPeer::DATAINICI);
          
     $pager = new sfPropelPager('Cursos', 10);
	 $pager->setCriteria($C);
	 $pager->setPage($PAGINA);
	 $pager->init();
	 return $pager;
         
  }

  static function cercaAlumnes( $CERCA , $PAGINA = 1 )
  {
     
     $C = new Criteria();           
     $C1 = $C->getNewCriterion(UsuarisPeer::NOM, '%'.$CERCA.'%',CRITERIA::LIKE);
     $C2 = $C->getNewCriterion(UsuarisPeer::COG1, '%'.$CERCA.'%',CRITERIA::LIKE);
     $C3 = $C->getNewCriterion(UsuarisPeer::COG2, '%'.$CERCA.'%',CRITERIA::LIKE);
     $C4 = $C->getNewCriterion(UsuarisPeer::DNI, '%'.$CERCA.'%',CRITERIA::LIKE);
     
     $C1->addOr($C2); $C1->addOr($C3);$C1->addOr($C4);
     
     $C->add($C1);
     
     $C->addAscendingOrderByColumn(UsuarisPeer::COG1);
     $C->addAscendingOrderByColumn(UsuarisPeer::NOM);
     
     $pager = new sfPropelPager('Usuaris', 10);
	 $pager->setCriteria($C);
	 $pager->setPage($PAGINA);
	 $pager->init();
	 return $pager;     
     
  }
  
  
  static function cercaMatricules($CERCA)
  {
     $C = new Criteria(); 
     $C1 = $C->getNewCriterion(CursosPeer::CODI, '%'.$CERCA.'%',CRITERIA::LIKE);
     $C2 = $C->getNewCriterion(CursosPeer::TITOLCURS, '%'.$CERCA.'%',CRITERIA::LIKE);
     $C3 = $C->getNewCriterion(CursosPeer::CATEGORIA, '%'.$CERCA.'%',CRITERIA::LIKE);
     
     $C4 = $C->getNewCriterion(UsuarisPeer::NOM, '%'.$CERCA.'%',CRITERIA::LIKE);
     $C5 = $C->getNewCriterion(UsuarisPeer::COG1, '%'.$CERCA.'%',CRITERIA::LIKE);
     $C6 = $C->getNewCriterion(UsuarisPeer::COG2, '%'.$CERCA.'%',CRITERIA::LIKE);
     $C7 = $C->getNewCriterion(UsuarisPeer::DNI, '%'.$CERCA.'%',CRITERIA::LIKE);
     
     $C1->addOr($C2); $C1->addOr($C3);$C1->addOr($C4);$C1->addOr($C5);$C1->addOr($C6);$C1->addOr($C7);
     
     $C->add($C1);
     
     $C->addDescendingOrderByColumn(MatriculesPeer::DATAINSCRIPCIO);
     
     return MatriculesPeer::doSelectJoinAll($C);
          
  }
   
  static function cercaUsuariMatricules($idU, $PAGINA = 1)
  {
    
    $C   = new Criteria();
    $C->add(self::USUARIS_USUARIID, $idU, Criteria::EQUAL);
                
    $pager = new sfPropelPager('Matricules', 20);
    $pager->setCriteria($C);
    $pager->setPage($PAGINA);
    $pager->init();
       
    return $pager;
     
  }
  
  static function getEstatsSelect()
  {
    //A = Acceptat i pagat
    //B = Acceptat i no pagat
    //C = En espera
    //D = Error
    
    $A['A'] = 'Acceptat i pagat';
    $A['B'] = 'Acceptat i no pagat';
    $A['C'] = 'En espera';
    $A['D'] = 'Error';
       
    return $A;
     
  }
  
  static function getMatriculesUsuari($idU){
      $C = new Criteria();
      $C->add(MatriculesPeer::USUARIS_USUARIID , $idU);         
      return MatriculesPeer::doSelect($C);
  }

  static function getMatriculesCurs($idC){
      $C = new Criteria();
      $C->add(MatriculesPeer::CURSOS_IDCURSOS , $idC);
      $C->addAscendingOrderByColumn(MatriculesPeer::ESTAT);
      return MatriculesPeer::doSelect($C);
  }
  
  
  /**
   * Retorna un array amb tots els valors per carregar al TPV
   *
   * @param DOUBLE $PREU
   * @param STRING $NOM
   * @return ARRAY
   */
  static function getTPV($PREU , $NOM , $matricules, $WEB = true)
  {
     $TPV = array();
     
     $TPV['Ds_Merchant_Amount'] = $PREU*100;
     $TPV['Ds_Merchant_Currency'] = '978';
     $TPV['Ds_Merchant_Order'] = date('ymdHis'); 
     $TPV['Ds_Merchant_MerchantCode'] = '091623116';
     $TPV['Ds_Merchant_Terminal'] = '1';
     $TPV['Ds_Merchant_TransactionType'] = '0';
     if($WEB):
        $TPV['Ds_Merchant_MerchantURL'] = 'http://servidor.casadecultura.cat/intranet/intranet_dev.php/web/matriculat';
     else:
        $TPV['Ds_Merchant_MerchantURL'] = 'http://servidor.casadecultura.cat/intranet/intranet_dev.php/gestio/matriculat';                         
     endif;
        
     $TPV['Ds_Merchant_ProductDescription'] = 'Matrícula Casa de Cultura';
     $TPV['Ds_Merchant_Titular'] = $NOM;
     $TPV['Ds_Merchant_MerchantName'] = 'Casa de Cultura';
     $TPV['Ds_Merchant_MerchantData'] = implode("@",$matricules);
              
     $message =  $TPV['Ds_Merchant_Amount'].
                 $TPV['Ds_Merchant_Order'].
                 $TPV['Ds_Merchant_MerchantCode'].
                 $TPV['Ds_Merchant_Currency'].
                 'perritopequenitonegr'; 
                       
     $TPV['Ds_Merchant_MerchantSignature'] = strtoupper(sha1($message));
     
     return $TPV;
  }
  
  static public function setMatriculaPagada($M)
  {
     
     $MATRICULA = MatriculesPeer::retrieveByPK($M);     
     $MATRICULA->setEstat(self::ACCEPTAT_PAGAT);
     $MATRICULA->save();
     
  }
  
  static function getEstatText($Estat)
  {     

     switch($Estat){
        case self::ACCEPTAT_PAGAT : return 'Acceptat i pagat';
        case self::ACCEPTAT_NO_PAGAT : return 'Acceptat i no pagat'; 
        case self::EN_ESPERA : return 'En espera';
        case self::ERROR : return 'Error';
        case self::BAIXA : return 'Baixa';
        case self::CANVI_GRUP : return 'Canvi de grup';
        case self::PROCES_PAGAMENT: return 'En procès de pagament';
        default : return 'NO ESPECIFICAT';  
     }   
  }
  
}
