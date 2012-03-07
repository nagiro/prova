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
   const ACCEPTAT_NO_PAGAT = "12";
   const RESERVAT = "26";
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
   const REDUCCIO_ESPECIAL        = '28';
   
   const PAGAMENT_METALIC         = '21';
   const PAGAMENT_TARGETA         = '20';
   const PAGAMENT_TELEFON         = '23';
   const PAGAMENT_TRANSFERENCIA   = '24';

    static public function criteriaMatriculat($C,$amb_llista_espera = false)
    {
        $C1 = $C->getNewCriterion(self::ESTAT,self::ACCEPTAT_PAGAT);
        $C2 = $C->getNewCriterion(self::ESTAT,self::ACCEPTAT_NO_PAGAT);
        $C4 = $C->getNewCriterion(self::ESTAT,self::RESERVAT);                                  //També agafem aquells que estan en estat de plaça reservada
        if($amb_llista_espera) $C3 = $C->getNewCriterion(self::ESTAT,self::EN_ESPERA);
        if($amb_llista_espera) $C1->addOr($C3);        
        $C1->addOr($C4);
        $C1->addOr($C2);         
        $C->add($C1); 
        $C->add(self::ACTIU, true);
        return $C;
    } 

    static public function getMatriculaUsuari($idU,$idC,$idS)
    {
        $C = new Criteria();
        $C = self::getCriteriaActiu($C,$idS);
        $C->add(self::CURSOS_IDCURSOS, $idC);
        $C->add(self::USUARIS_USUARIID, $idU);
        $C = self::criteriaMatriculat($C);
                                       
        return self::doSelectOne($C);
    }

    static public function hasMatriculaUsuari($idU,$idC,$idS)
    {
        $C = new Criteria();
        $C = self::getCriteriaActiu($C,$idS);
        $C->add(self::CURSOS_IDCURSOS, $idC);
        $C->add(self::USUARIS_USUARIID, $idU);
        $C = self::criteriaMatriculat($C);
                                       
        return self::doCount($C);         
    }

    /**
     * Funció que guarda una matrícula després d'enviar-ho des del gestor o bé des de l'hospici. 
     * @param $idU Identificador d'usuari
     * @param $idC Identificador de curs
     * @param $idM Identificador de matrícula si volem reutilitzar-la
     * @param $comment Comentari a guardar
     * @return new Matricules() o $error ( Codi d'error ) 
     * */
    static public function saveNewMatricula( $idU , $idC , $comment = "" , $idD , $Mode_pagament )
    {        
        
        //Parametre que retornarem
        $RET = array('AVISOS'=>array(),'OM'=>new Matricules());
                
        $OC = CursosPeer::retrieveByPK($idC);
        
        //Comprovem que l'usuari existeixi.
        if(is_null(UsuarisPeer::retrieveByPK($idU))) { $RET['AVISOS']["ERR_USUARI"] = "ERR_USUARI"; return $RET; }
        
        //Comprovem que el curs existeixi.
        if(is_null(CursosPeer::retrieveByPK($idC))) { $RET['AVISOS']["ERR_CURS"] = "ERR_CURS"; return $RET; }
        
        //Comprovem que aquest usuari no tingui ja una matrícula a aquest curs. Si ja ha estat matriculat, retornem -1.
        $OM = self::getMatriculaUsuari($idU, $idC, $OC->getSiteid());
        if(!is_null($OM)){ $RET['AVISOS']["ERR_JA_TE_UNA_MATRICULA"] = "ERR_JA_TE_UNA_MATRICULA"; return $RET; }                                     
                                  
        //Entrem les dades que tenim i la deixem en procès per modificar-la després segons el que hagi passat
        $OM = new Matricules();
        $OM->setUsuarisUsuariid($idU);
        $OM->setCursosIdcursos($idC);
        $OM->setEstat(MatriculesPeer::EN_PROCES);
        $OM->setComentari($comment);
        $OM->setDatainscripcio(date('Y-m-d H:i',time()));
        $OM->setPagat(DescomptesPeer::getPreuAmbDescompte($OC->getPreu(),$idD));
        $OM->setTreduccio($idD);
        $OM->setTpagament($Mode_pagament);
        $OM->setSiteId($OC->getSiteid());
        $OM->setActiu(true);
        $OM->setTpvOperacio(0);
        $OM->setTpvOrder(0);        
        $OM->save();
        
        //Guardem l'identificador de la matrícula
        $RET['OM'] = $OM;
        
        //Ara comprovem les diferents possibilitats. Calculem el preu amb reducció i deixem a 0 si no hi ha places. 
        $PREU = DescomptesPeer::getPreuAmbDescompte( $OC->getPreu() , $OM->getTreduccio() );
        
        //Si el curs és ple, guardem que està en espera i mostrem que el curs està ple i resta en llista d'espera
        if($OC->isPle()){
                              
          $OM->setPagat(0);
          $OM->setEstat(MatriculesPeer::EN_ESPERA);
          $OM->save();
          $RET['AVISOS']['CURS_PLE'] = "CURS_PLE";
          
        //Si queden places al curs                
        } else {
            
            //Si hem dit que el curs és en format reserva en comptes de pagament
            if($OC->isReserva())
            {
                $OM->setPagat(0);
                $OM->setEstat(MatriculesPeer::RESERVAT);
                $OM->save();
                $RET['AVISOS']['RESERVA_OK'] = "RESERVA_OK";                
                self::SendMailMatricula($OM,$OM->getSiteid()); //Enviem el correu electrònic per a la reserva
                
            } 
            //Si és una matrícula de compra
            elseif($OC->isCompra())
            {
            
                //Si el mode de pagament és targeta, cridem el tpv
                if( $Mode_pagament == MatriculesPeer::PAGAMENT_TARGETA ){
      		        $RET['AVISOS']['PAGAMENT_TPV'] = "PAGAMENT_TPV";
                                        
                //Altrament, acceptem i mostrem la matrícula
                } else { 
                    
                    //Guardem la matrícula tal qual està.
                    $OM->setEstat(MatriculesPeer::ACCEPTAT_PAGAT);
                    $OM->setPagat($PREU);
                    $OM->save();
                    $RET['AVISOS']['MATRICULA_METALIC_OK'] = "MATRICULA_METALIC_OK";
                    self::SendMailMatricula($OM,$OM->getSiteid());                
                }
            }
        }
        
        return $RET;
    }
   
    //Envia el correu d'una matrícula
    static public function SendMailMatricula($OM,$idS){
    if($OM->getEstat() == MatriculesPeer::ACCEPTAT_PAGAT):
        myUser::sendMail(OptionsPeer::getString('MAIL_FROM',$idS), $OM->getUsuaris()->getEmail(), 'Resguard de matrícula', MatriculesPeer::MailMatricula($OM,$idS));  			
    	myUser::sendMail(OptionsPeer::getString('MAIL_FROM',$idS), 'informatica@casadecultura.org', 'Resguard de matrícula', MatriculesPeer::MailMatricula($OM,$idS));
     endif; 
    }    
   
    /**
     * Funció que inicialitza una matrícula
     * */   
    static public function initialize( $idM , $idS , $selUsuari = false, $URL_AJAX_USER = null )
    {
        $OM = MatriculesPeer::retrieveByPK($idM);            
        if($OM instanceof Matricules):            
        	return new MatriculesForm($OM,array('IDS'=>$OM->getSiteid()));
        else:
        	$OM = new Matricules();
            $OM->setDatainscripcio(date('Y-m-d H:i',time()));
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
  
  static public function h_getCriteriaActiu( $C )
  {    
    $C->add(self::ACTIU, true);    
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
              self::REDUCCIO_ESPECIAL => 'Reducció especial',
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
              self::REDUCCIO_ESPECIAL => 'Reducció especial', 
            );
  }
  
  
  static function textDescomptes($D)
  {  
      switch($D){
         case self::REDUCCIO_CAP : return 'Cap';
         case self::REDUCCIO_MENOR_25_ANYS : return 'Estudiant menor de 25 anys';
         case self::REDUCCIO_JUBILAT : return 'Jubilat';
         case self::REDUCCIO_ATURAT : return 'Aturat';
         case self::REDUCCIO_ESPECIAL : return 'Reducció especial';
         default: return 'Desconegut'; 
      }
  }
  
  static function selectPagament()
  {
      return array(
         self::PAGAMENT_METALIC => 'Metal·lic',
         self::PAGAMENT_TARGETA => 'Targeta',         
//         self::PAGAMENT_TELEFON => 'Telèfon',
//         self::PAGAMENT_TRANSFERENCIA => 'Transferència'
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
	$C->addAscendingOrderByColumn(CursosPeer::CATEGORIA);
	$C->addAscendingOrderByColumn(CursosPeer::CODI);

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
     
     //Cerquem tots els camps de l'usuari
     $C = UsuarisPeer::CriteriaCerca($CERCA,$C);
               
     $C->addJoin( UsuarisPeer::USUARIID , self::USUARIS_USUARIID );
               
     $C->addAscendingOrderByColumn(UsuarisPeer::COG1);
     $C->addAscendingOrderByColumn(UsuarisPeer::NOM);
     $C->addGroupByColumn(UsuarisPeer::DNI);
     
     $pager = new sfPropelPager('Usuaris', 20);
	 $pager->setCriteria($C);
	 $pager->setPage($PAGINA);
	 $pager->init();
	 return $pager;     
     
  }
  
  
  static function cercaMatricules( $CERCA , $idS )
  {
     $C = new Criteria();          
     $C = self::getCriteriaActiu( $C , $idS );

     foreach(explode(' ',$CERCA) as $PARAULA):     
        $C1 = $C->getNewCriterion(CursosPeer::CODI, '%'.$PARAULA.'%',CRITERIA::LIKE);
        $C2 = $C->getNewCriterion(CursosPeer::TITOLCURS, '%'.$PARAULA.'%',CRITERIA::LIKE);
        $C3 = $C->getNewCriterion(CursosPeer::CATEGORIA, '%'.$PARAULA.'%',CRITERIA::LIKE);            
        $C1->addOr($C2); $C1->addOr($C3); $C->addAnd($C1);        
     endforeach;
          
     //Cerquem tots els camps de l'usuari
     $C = UsuarisPeer::CriteriaCerca($CERCA,$C);
     
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
  					self::EN_PROCES => 'En procès de pagament',
                    self::RESERVAT => 'Reservat'  					  	
  	);  
           
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
        case self::RESERVAT: return 'Reservat';
        default : return 'NO ESPECIFICAT';  
     }   
  }
  

 static public function h_getMatriculesCursosUsuariArray($idU)
 {
    $AU = self::h_getMatriculesUsuari($idU);
    $RET = array();
    foreach($AU as $OM):
        $RET[$OM->getCursosIdcursos()] = $OM->getIdmatricules();
    endforeach;
    return $RET;
 }

 /**
  * A diferència de getMatriculesUsuari, a l'Hospici s'agafen totes... no només les del SITE. 
  * Bàsicament, no hi ha filtre per site.  
  **/
  static function h_getMatriculesUsuari( $idU ){
    
    $C = new Criteria();    
    $C = self::h_getCriteriaActiu( $C );
    $C1 = $C->getNewCriterion(self::ESTAT,self::ACCEPTAT_PAGAT);
    $C2 = $C->getNewCriterion(self::ESTAT,self::ACCEPTAT_NO_PAGAT);
    $C3 = $C->getNewCriterion(self::ESTAT,self::EN_ESPERA);
    $C4 = $C->getNewCriterion(self::ESTAT,self::RESERVAT);
    $C1->addOr($C2); $C1->addOr($C3); $C1->addOr($C4); $C->add($C1);    
    $C->add(self::ACTIU, true);    
    $C->add(MatriculesPeer::USUARIS_USUARIID , $idU);                
    $C->addDescendingOrderByColumn(MatriculesPeer::DATAINSCRIPCIO);

    return MatriculesPeer::doSelect($C);
  }

 /**
  * Mostrem les notícies segons l'usuari i el site on està.   
  **/  
  static function getMatriculesUsuari($idU,$idS){

    $C = new Criteria();    
    $C = self::getCriteriaActiu( $C , $idS );
    $C->add(MatriculesPeer::USUARIS_USUARIID , $idU);
    //$C->add(MatriculesPeer::ESTAT, self::EN_PROCES, CRITERIA::NOT_EQUAL);
    $C->add(MatriculesPeer::CURSOS_IDCURSOS, null, CRITERIA::NOT_EQUAL);
    
    $C->addAscendingOrderByColumn(MatriculesPeer::ESTAT);
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
   * Funció que amb una resposta del TPV la valida
   * @param $Ds_Merchant_Amount
   * @param $Ds_Merchant_Order
   * @param $Ds_Merchant_MerchantCode
   * @param $Ds_Merchant_Currency
   * @param $MerchantSignature
   * @param $password
   * @return boolean  
   * */
  static public function valTPV($Ds_Merchant_Amount,$Ds_Merchant_Order,$Ds_Merchant_MerchantCode,$Ds_Merchant_Currency,$Ds_Response,$MerchantSignature,$password)
  {
       
     $message =  $Ds_Merchant_Amount.
                 $Ds_Merchant_Order.
                 $Ds_Merchant_MerchantCode.
                 $Ds_Merchant_Currency.
                 $Ds_Response.
                 $password;

     return ($MerchantSignature == strtoupper(sha1($message)));
    
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
                 OptionsPeer::getString('TPV_PASSWORD',$idS);               
                       
     $TPV['Ds_Merchant_MerchantSignature'] = strtoupper(sha1($message));
     
     return $TPV;
  }
  
  static public function getMatriculesPagadesDia( $modePagament = 0 , $idS )
  {
  	$C = new Criteria();
    self::getCriteriaActiu( $C , $idS );
    $C1 = $C->getNewCriterion(MatriculesPeer::ESTAT, MatriculesPeer::ACCEPTAT_PAGAT);
    $C2 = $C->getNewCriterion(MatriculesPeer::ESTAT, MatriculesPeer::DEVOLUCIO);
  	$C1->addOr($C2); $C->add($C1);    
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
    $OS = SitesPeer::retrieveByPK($OM->getSiteId());
    
    $TEXT = OptionsPeer::getString( 'BODY_MAIL_MATRICULA' , $idS );            
    $TEXT = str_replace( '{{NOM}}' , $Nom , $TEXT );
    $TEXT = str_replace( '{{CURS}}' , $NomCurs , $TEXT );
    $TEXT = str_replace( '{{ENTITAT}}' , $OS->getNom() , $TEXT );
    $TEXT = str_replace( '{{TEL_ENTITAT}}' , $OS->getTelefon() , $TEXT );
    $TEXT = str_replace( '{{MAIL_ENTITAT}}' , $OS->getEmail() , $TEXT );
    $TEXT = str_replace( '{{TEL_ADMIN}}' , '972.20.20.13' , $TEXT );
    $TEXT = str_replace( '{{MAIL_ADMIN}}' , OptionsPeer::getString('MAIL_ADMIN',$idS) , $TEXT );            
    $TEXT = str_replace( '{{DIA_CLASSE}}' , $dataInici , $TEXT );
      	
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
