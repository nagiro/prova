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

   const ACCEPTAT_PAGAT = "8";
   const ACCEPTAT_NO_PAGAT = " ";
   const EN_ESPERA = "14";   
   const ERROR = "10";
   const BAIXA = "9";
   const CANVI_GRUP = "13";
   const EN_PROCES = "25";
   const DEVOLUCIO = '11';
      
   const REDUCCIO_CAP             = '16';
   const REDUCCIO_MENOR_25_ANYS   = '18';
   const REDUCCIO_JUBILAT         = '17';
   const REDUCCIO_ATURAT          = '19';
   const REDUCCIO_GRATUIT         = '24';
   
   const PAGAMENT_METALIC         = '21';
   const PAGAMENT_TARGETA         = '20';
   const PAGAMENT_TELEFON         = '23';
   const PAGAMENT_TRANSFERENCIA   = '24';
   
   
    static public function initialize( $idM , $idS , $selUsuari = false)
    {
        $OM = MatriculesPeer::retrieveByPK($idM);            
        if($OM instanceof Matricules):            
        	return new MatriculesForm($OM);
        else:
        	$OM = new Matricules();
            $OM->setSiteId($idS);        
            $OM->setActiu(true);        
            if($selUsuari):
                return new MatriculesUsuariForm($OM,array('IDS'=>$idS));
            else:
                return new MatriculesForm($OM,array('IDS'=>$idS));
            endif;			
        endif; 
    }
   
   
  static public function getCriteriaActiu( $C , $idS )
  {    
    $C->add(self::ACTIU, true);
    $C->add(self::SITE_ID, $idS);
    return $C;
  }
   
  static function QuantesAvui($idS)
  {
     $C = self::getCriteriaActiu(new Criteria(),$idS);     
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
              self::REDUCCIO_GRATUIT => 'Gratuït'
            );
  }

  static function selectDescomptesWeb()
  {
     return array(
              self::REDUCCIO_CAP => 'Cap',
              self::REDUCCIO_MENOR_25_ANYS => 'Estudiant menor de 25 anys',
              self::REDUCCIO_JUBILAT => 'Jubilat',
              self::REDUCCIO_ATURAT => 'Aturat',              
            );
  }
  
  
  static function textDescomptes($D)
  {  
      switch($D){
         case self::REDUCCIO_CAP : return 'Cap';
         case self::REDUCCIO_MENOR_25_ANYS : return 'Estudiant menor de 25 anys';
         case self::REDUCCIO_JUBILAT : return 'Jubilat';
         case self::REDUCCIO_ATURAT : return 'Aturat';
         default: return 'Desconegut'; 
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
  
  static function getCursosMatriculacio($idS)
  {
  	$C = new Criteria();
  	$C = CursosPeer::getCriteriaActiu($C,$idS);
	$C->add(CursosPeer::ISACTIU,true);     
	$C->addDescendingOrderByColumn(CursosPeer::CATEGORIA);
	$C->addDescendingOrderByColumn(CursosPeer::CODI);

	return CursosPeer::doSelect($C);
  	
  }
  
  static function cercaCursos($CERCA , $PAGINA = 1 , $idS )
  {     
     
     $C = CursosPeer::getCriteriaActiu( new Criteria() , $idS );
              
     $C1 = $C->getNewCriterion(CursosPeer::CODI, '%'.$CERCA.'%',CRITERIA::LIKE);
     $C2 = $C->getNewCriterion(CursosPeer::TITOLCURS, '%'.$CERCA.'%',CRITERIA::LIKE);
     $C3 = $C->getNewCriterion(CursosPeer::CATEGORIA, '%'.$CERCA.'%',CRITERIA::LIKE);	               
     $C1->addOr($C2); $C1->addOr($C3);	$C->add($C1);
     
     $C->add(CursosPeer::ISACTIU, 1);
     
     $C->addAscendingOrderByColumn( CursosPeer::CATEGORIA );
  	 $C->addAscendingOrderByColumn( CursosPeer::DATADESAPARICIO );
  	 $C->addAscendingOrderByColumn( CursosPeer::CODI );
                 
     $pager = new sfPropelPager('Cursos', 40);
	 $pager->setCriteria($C);
	 $pager->setPage($PAGINA);
	 $pager->init();
	 return $pager;
         
  }

  static function cercaAlumnes( $CERCA , $PAGINA = 1 , $idS )
  {
          
     $C = new Criteria();
     $C = self::getCriteriaActiu($C,$idS);
     $C = UsuarisPeer::getCriteriaActiu($C,$idS);
     $C->add(MatriculesPeer::ESTAT, self::EN_PROCES, CRITERIA::NOT_EQUAL);
     
     $C1 = $C->getNewCriterion(UsuarisPeer::NOM, '%'.$CERCA.'%',CRITERIA::LIKE);
     $C2 = $C->getNewCriterion(UsuarisPeer::COG1, '%'.$CERCA.'%',CRITERIA::LIKE);
     $C3 = $C->getNewCriterion(UsuarisPeer::COG2, '%'.$CERCA.'%',CRITERIA::LIKE);
     $C4 = $C->getNewCriterion(UsuarisPeer::DNI, '%'.$CERCA.'%',CRITERIA::LIKE);
     
     $C1->addOr($C2); $C1->addOr($C3);$C1->addOr($C4);
     
     $C->add($C1);
     
     $C->addJoin( UsuarisPeer::USUARIID , self::USUARIS_USUARIID );
          
     
     $C->addAscendingOrderByColumn(UsuarisPeer::COG1);
     $C->addAscendingOrderByColumn(UsuarisPeer::NOM);
     $C->addGroupByColumn(UsuarisPeer::DNI);
     
     $pager = new sfPropelPager('Usuaris', 10);
	 $pager->setCriteria($C);
	 $pager->setPage($PAGINA);
	 $pager->init();
	 return $pager;     
     
  }
  
  
  static function cercaMatricules( $CERCA , $idS )
  {
     $C = new Criteria();          
     $C = self::getCriteriaActiu( $C , $idS );
      
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

  //M'informa si actualment estic dins el període de matriculació dels antics alumnes. 
  static function isPeriodeAnticsAlumnes($idS)
  {

    $DiAa = OptionsPeer::getString('DATA_MAT_ANTICS',$idS);
    $DiT  = OptionsPeer::getString('DATA_MAT_TOTHOM',$idS); 
  	$avui = date('Y-m-d',time());
  	
  	return ($DiAa < $avui && $avui < $DiT );
  	
  }
  
  //Ens diu si l'alumne ha fet algun curs durant l'últim any i mig. 
  static function isAnticAlumne( $idU , $idS )
  {
  	
  	$DATA_ANY_I_MIG_ENRRERA = mktime(0,0,0,date('m',time())-18,date('d',time()),date('Y',time()));
  	
  	$C = new Criteria();
    $C = UsuarisPeer::getCriteriaActiu($C,$idS);
    $C = CursosPeer::getCriteriaActiu($C,$idS);
    
  	$C->add(self::USUARIS_USUARIID, $idU);
  	$C->addJoin(self::CURSOS_IDCURSOS,CursosPeer::IDCURSOS);
  	$C->add(CursosPeer::DATAINICI, $DATA_ANY_I_MIG_ENRRERA, CRITERIA::GREATER_THAN);
    	
  	return (self::doCount($C) == 0)?false:true;    	
  	
  }
  
/*  static function cercaUsuariMatricules($idU, $PAGINA = 1)
  {
    
    $C   = new Criteria();
    $C->add(self::USUARIS_USUARIID, $idU, Criteria::EQUAL);
                
    $pager = new sfPropelPager('Matricules', 20);
    $pager->setCriteria($C);
    $pager->setPage($PAGINA);
    $pager->init();
       
    return $pager;
     
  }
*/  
  static function getEstatsSelect()
  {
  	
  	
  	return array(	self::ACCEPTAT_PAGAT => 'Acceptat i pagat', 
  					self::ACCEPTAT_NO_PAGAT => 'Acceptat i no pagat',
  					self::EN_ESPERA => 'En espera',
  					self::ERROR => 'Error internet',
  					self::BAIXA => 'Baixa',
  					self::CANVI_GRUP => 'Canvi de grup',
  					self::DEVOLUCIO => 'Devolució',
  					self::EN_PROCES => 'En procès de pagament'  					  	
  	);  
           
  }
  
  static function getMatriculesUsuari($idU,$idS){

    $C = new Criteria();    
    $C = self::getCriteriaActiu( $C , $idS );
    $C->add(MatriculesPeer::USUARIS_USUARIID , $idU);
    $C->add(MatriculesPeer::ESTAT, self::EN_PROCES, CRITERIA::NOT_EQUAL);
    $C->addDescendingOrderByColumn(MatriculesPeer::DATAINSCRIPCIO);

    return MatriculesPeer::doSelect($C);
  }

  static function getMatriculesCurs( $idC , $idS ){
      $C = new Criteria();
      $C = self::getCriteriaActiu( $C , $idS );      
      $C->add(MatriculesPeer::CURSOS_IDCURSOS , $idC);
      $C->addAscendingOrderByColumn(MatriculesPeer::ESTAT);
      $C->addJoin(MatriculesPeer::USUARIS_USUARIID, UsuarisPeer::USUARIID);      
      $C->addDescendingOrderByColumn(MatriculesPeer::ESTAT);
      $C->addAscendingOrderByColumn(UsuarisPeer::COG1);
      $C->addAscendingOrderByColumn(UsuarisPeer::COG2);
      $C->addAscendingOrderByColumn(UsuarisPeer::NOM);
      $C->add(MatriculesPeer::ESTAT,MatriculesPeer::EN_PROCES, CRITERIA::NOT_EQUAL);
  	    	  	
      return MatriculesPeer::doSelect($C);
  }
  
  
  /**
   * Retorna un array amb tots els valors per carregar al TPV
   *
   * @param DOUBLE $PREU
   * @param STRING $NOM
   * @return ARRAY
   */
  static function getTPV($PREU , $NOM , $matricula, $idS , $WEB = true)
  {
     $TPV = array();
     
     $TPV['Ds_Merchant_Amount'] = $PREU*100;
     $TPV['Ds_Merchant_Currency'] = '978';
     $TPV['Ds_Merchant_Order'] = date('ymdHis'); 
     $TPV['Ds_Merchant_MerchantCode'] = OptionsPeer::getString('TPV_Ds_Merchant_MerchantCode',$idS);
     $TPV['Ds_Merchant_Terminal'] = '1';
     $TPV['Ds_Merchant_TransactionType'] = '0';
     if($WEB):
        $TPV['Ds_Merchant_MerchantURL'] = OptionsPeer::getString('TPV_WEB_Merchant_MerchantURL',$idS);
        $TPV['Ds_Merchant_UrlOK'] = OptionsPeer::getString('TPV_WEB_Ds_Merchant_UrlOK',$idS);
        $TPV['Ds_Merchant_UrlKO'] = OptionsPeer::getString('TPV_WEB_Ds_Merchant_UrlKO',$idS);
     else:
        $TPV['Ds_Merchant_MerchantURL'] = OptionsPeer::getString('TPV_Merchant_MerchantURL',$idS);                         
        $TPV['Ds_Merchant_UrlOK'] = OptionsPeer::getString('TPV_Ds_Merchant_UrlOK',$idS);
        $TPV['Ds_Merchant_UrlKO'] = OptionsPeer::getString('TPV_Ds_Merchant_UrlKO',$idS);
     endif;
        
     $TPV['Ds_Merchant_ProductDescription'] = OptionsPeer::getString('TPV_ProductDescription',$idS);
     $TPV['Ds_Merchant_Titular'] = $NOM;
     $TPV['Ds_Merchant_MerchantName'] = OptionsPeer::getString('TPV_MerchantName',$idS);
     $TPV['Ds_Merchant_MerchantData'] = $matricula;
              
     $message =  $TPV['Ds_Merchant_Amount'].
                 $TPV['Ds_Merchant_Order'].
                 $TPV['Ds_Merchant_MerchantCode'].
                 $TPV['Ds_Merchant_Currency'].
                 'perritopequenitonegr'; 
                       
     $TPV['Ds_Merchant_MerchantSignature'] = strtoupper(sha1($message));
     
     return $TPV;
  }
  
  static public function setMatriculaPagada( $OM )
  {
    
    $RET = false;         
    
    $CURS_PLE = CursosPeer::isPle( $OM->getCursosIdcursos() , $OM->getSiteId() ); //Passem si el curs es ple 
  	
  	 //Mirem si el curs és ple. Si es ple i no hi ha cap import pagat, guardem com en espera.
     if(!$CURS_PLE){
     	$OM->setEstat(self::ACCEPTAT_PAGAT);
     } else {
        if($OM->getPagat() > 0){ $OM->setEstat(self::ACCEPTAT_PAGAT);  }
        else { $OM->setEstat(self::EN_ESPERA);   }     
     }
               
     $OM->save();
     
     return $OM; 
     
  }
  
  static function getEstatText($Estat)
  {     

     switch($Estat){
        case self::ACCEPTAT_PAGAT : return 'Acceptat i pagat';
        case self::ACCEPTAT_NO_PAGAT : return 'Acceptat i no pagat'; 
        case self::EN_ESPERA : return 'En espera';
        case self::ERROR : return 'Error internet';
        case self::BAIXA : return 'Baixa';
        case self::CANVI_GRUP : return 'Canvi de grup';
        case self::EN_PROCES: return 'En procès de pagament';
        case self::DEVOLUCIO: return 'Devolució';
        default : return 'NO ESPECIFICAT';  
     }   
  }
  
  static public function getMatriculesPagadesDia( $modePagament = 0 , $idS )
  {
  	$C = new Criteria();
    self::getCriteriaActiu( $C , $idS );
  	$C->add(MatriculesPeer::ESTAT, MatriculesPeer::ACCEPTAT_PAGAT);
  	$C->addDescendingOrderByColumn(MatriculesPeer::DATAINSCRIPCIO);    
  	$C->addJoin(MatriculesPeer::USUARIS_USUARIID, UsuarisPeer::USUARIID);
  	$C->addJoin(MatriculesPeer::CURSOS_IDCURSOS, CursosPeer::IDCURSOS);
  	if($modePagament > 0) $C->add(matriculesPeer::TPAGAMENT, $modePagament );  	
  	return self::doSelect($C);
  }
  
  static public function MailMatricula( $OM , $idS )
  {
  	
  	$Nom = $OM->getUsuaris()->getNomComplet();
  	$NomCurs = $OM->getCursos()->getCodi().' | '.$OM->getCursos()->getTitolcurs();
  	$dataInici = $OM->getCursos()->getDatainici('d-m-Y');        
    
    $TEXT = OptionsPeer::getString( 'MAIL_MAT_OK' , $idS );    
    $TEXT = str_replace( '{{LOGO_URL}}', OptionsPeer::getString( 'LOGO_URL' , $idS ) , $TEXT );    
    $TEXT = str_replace( '{{URL_LOGIN}}', OptionsPeer::getString( 'URL_LOGIN' , $idS ) , $TEXT );
    $TEXT = str_replace( '{{NOM}}' , $Nom , $TEXT );
    $TEXT = str_replace( '{{NOM_CURS}}' , $NomCurs , $TEXT );
    $TEXT = str_replace( '{{DATA_INICI}}' , $dataInici , $TEXT );
      	
   	return $TEXT; 
  	
  }

  static public function MailMatriculaFAIL( $OM , $idS )
  {

  	$Nom = $OM->getUsuaris()->getNomComplet();
  	$NomCurs = $OM->getCursos()->getCodi().' | '.$OM->getCursos()->getTitolcurs();
  	$dataInici = $OM->getCursos()->getDatainici('d-m-Y');

    $TEXT = OptionsPeer::getString( 'MAIL_MAT_KO' , $idS );    
    $TEXT = str_replace( '{{LOGO_URL}}', OptionsPeer::getString( 'LOGO_URL' , $idS ) , $TEXT );    
    $TEXT = str_replace( '{{URL_LOGIN}}', OptionsPeer::getString( 'URL_LOGIN' , $idS ) , $TEXT );
    $TEXT = str_replace( '{{NOM}}' , $Nom , $TEXT );
    $TEXT = str_replace( '{{NOM_CURS}}' , $NomCurs , $TEXT );
    $TEXT = str_replace( '{{DATA_INICI}}' , $dataInici , $TEXT );
  	      				
   	return $TEXT; 
  	
  }  
  
}
