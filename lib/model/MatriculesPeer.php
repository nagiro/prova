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
   const PAGAMENT_DOMICILIACIO    = '33'; 

    static public function criteriaMatriculat($C,$amb_llista_espera = false, $amb_baixa = false , $amb_tots_els_estats = false )
    {
        if(!$amb_tots_els_estats):                 
            $C1 = $C->getNewCriterion(self::ESTAT,self::ACCEPTAT_PAGAT);
            $C2 = $C->getNewCriterion(self::ESTAT,self::ACCEPTAT_NO_PAGAT);
            $C4 = $C->getNewCriterion(self::ESTAT,self::RESERVAT);                                  //També agafem aquells que estan en estat de plaça reservada
            if($amb_llista_espera) $C3 = $C->getNewCriterion(self::ESTAT,self::EN_ESPERA);
            if($amb_llista_espera) $C1->addOr($C3);        
            if($amb_llista_espera) $C5 = $C->getNewCriterion(self::ESTAT,self::BAIXA);
            if($amb_llista_espera) $C1->addOr($C5);
            $C1->addOr($C4);
            $C1->addOr($C2);         
            $C->add($C1); 
        endif;
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
    static public function saveNewMatricula( $idU , $idC , $comment = "" , $idD , $Mode_pagament , $idDadesBancaries = null )
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
        if($idDadesBancaries > 0) $OM->setIddadesbancaries($idDadesBancaries);
        else $OM->setIddadesbancaries(null);
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
            
            //Si el tipus de pagament és "reserva" ho guardem com a reservat.                        
            if( $Mode_pagament == TipusPeer::PAGAMENT_RESERVA )
            {
                $OM->setPagat( 0 );
                $OM->setEstat( MatriculesPeer::RESERVAT );
                $OM->save();
                $RET['AVISOS']['RESERVA_OK'] = "RESERVA_OK";                
                self::SendMailMatricula( $OM , $OM->getSiteid() ); //Enviem el correu electrònic per a la reserva
                
            } 
            
            //Si és una matrícula de compra amb targeta, cridem el TPV
            elseif( $Mode_pagament == TipusPeer::PAGAMENT_TARGETA )                                        
            {                                                                                        
                $RET['AVISOS']['PAGAMENT_TPV'] = "PAGAMENT_TPV";
            } 
            elseif($Mode_pagament == TipusPeer::PAGAMENT_METALIC) 
            {                     
                //Guardem la matrícula tal qual està.
                $OM->setEstat( MatriculesPeer::ACCEPTAT_PAGAT );
                $OM->setPagat( $PREU );
                $OM->save();
                $RET['AVISOS']['MATRICULA_METALIC_OK'] = "MATRICULA_METALIC_OK";
                self::SendMailMatricula( $OM , $OM->getSiteid() );                                    
            }
            elseif( $Mode_pagament == TipusPeer::PAGAMENT_CODI_BARRES )
            {
                //Guardem la matrícula tal qual i marquem com a no pagada fins que vagi al banc a pagar-la.
                $OM->setEstat( MatriculesPeer::ACCEPTAT_NO_PAGAT );
                $OM->setPagat( $PREU );
                $OM->save();
                $RET['AVISOS']['MATRICULA_CODI_BARRES'] = "MATRICULA_CODI_BARRES";
                self::SendMailMatricula( $OM , $OM->getSiteid() );            
            }                        
            //Si és una matrícula amb domiciliació
            elseif( $Mode_pagament == TipusPeer::PAGAMENT_DOMICILIACIO )
            {                
                $OM->setPagat( $PREU );
                $OM->setEstat( MatriculesPeer::ACCEPTAT_NO_PAGAT );
                $OM->setTpagament( MatriculesPeer::PAGAMENT_DOMICILIACIO );
                $OM->save();
                $RET['AVISOS']['MATRICULA_DOMICILIACIO_OK'] = "MATRICULA_DOMICILIACIO_OK";
                self::SendMailMatricula( $OM , $OM->getSiteid() );
            }
                                    
        }
        
        return $RET;
    }
   
    //Envia el correu d'una matrícula
    static public function SendMailMatricula($OM,$idS){
    if($OM->getEstat() == MatriculesPeer::ACCEPTAT_PAGAT):
        self::sendMail(OptionsPeer::getString('MAIL_FROM',$idS), $OM->getUsuaris()->getEmail(), 'Resguard de matrícula', MatriculesPeer::MailMatricula($OM,$idS));  			
    	self::sendMail(OptionsPeer::getString('MAIL_FROM',$idS), 'informatica@casadecultura.org', 'Resguard de matrícula', MatriculesPeer::MailMatricula($OM,$idS));
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

  static function textPagament($P)
  {  
      return TipusPeer::getTipusPagamentString($P);      
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
  static function getTPV($PREU , $NOM , $matricula, $idS , $WEB = true, $entrades = false)
  {
     $TPV = array();
     
     $TPV['Ds_Merchant_Amount'] = $PREU*100;
     $TPV['Ds_Merchant_Currency'] = '978';
     $TPV['Ds_Merchant_Order'] = date('ymdHis'); 
     $TPV['Ds_Merchant_MerchantCode'] = OptionsPeer::getString('TPV_Ds_Merchant_MerchantCode',$idS);
     $TPV['Ds_Merchant_Terminal'] = '1';
     $TPV['Ds_Merchant_TransactionType'] = '0';
     if($WEB):
        if($entrades):
            $TPV['Ds_Merchant_MerchantURL'] = OptionsPeer::getString('TPV_WEB_ENT_Merchant_MerchantURL',$idS);
            $TPV['Ds_Merchant_UrlOK'] = OptionsPeer::getString('TPV_WEB_ENT_Ds_Merchant_UrlOK',$idS);
            $TPV['Ds_Merchant_UrlKO'] = OptionsPeer::getString('TPV_WEB_ENT_Ds_Merchant_UrlKO',$idS);
        else:      
            $TPV['Ds_Merchant_MerchantURL'] = OptionsPeer::getString('TPV_WEB_Merchant_MerchantURL',$idS);
            $TPV['Ds_Merchant_UrlOK'] = OptionsPeer::getString('TPV_WEB_Ds_Merchant_UrlOK',$idS);
            $TPV['Ds_Merchant_UrlKO'] = OptionsPeer::getString('TPV_WEB_Ds_Merchant_UrlKO',$idS);
        endif;
     else:
        if($entrades):
            $TPV['Ds_Merchant_MerchantURL'] = OptionsPeer::getString('TPV_ENT_Merchant_MerchantURL',$idS);                         
            $TPV['Ds_Merchant_UrlOK'] = OptionsPeer::getString('TPV_ENT_Ds_Merchant_UrlOK',$idS);
            $TPV['Ds_Merchant_UrlKO'] = OptionsPeer::getString('TPV_ENT_Ds_Merchant_UrlKO',$idS);
        else: 
            $TPV['Ds_Merchant_MerchantURL'] = OptionsPeer::getString('TPV_Merchant_MerchantURL',$idS);                         
            $TPV['Ds_Merchant_UrlOK'] = OptionsPeer::getString('TPV_Ds_Merchant_UrlOK',$idS);
            $TPV['Ds_Merchant_UrlKO'] = OptionsPeer::getString('TPV_Ds_Merchant_UrlKO',$idS);        
        endif;
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
  

  /**
   * Ens torna el codi HTML del document per imprimir quan tenim una matrícula amb pagament en metàl·lic per caixer. 
   * */
  static public function DocMatriculaPagamentCaixer($OM, $idS)
  {
    
    $inici = OptionsPeer::getString( 'PAG_CAIXER_CODI_OP' , $idS );                          
    $entitat = OptionsPeer::getString( 'PAG_CAIXER_CODI_ENTITAT' , $idS );
    
    $referencia = str_pad(strval($OM->getIdmatricules()),11,'0',STR_PAD_LEFT);                                
    
    //Càlcul de valor de check
    $ponderacions = array( 10=>2 , 9=>3 , 8=>4 , 7=>5 , 6=>6 , 5=>7 , 4=>8 , 3=>9 , 2=>2 , 1=>3 , 0=>4 );
    $tot = 0;
    for($i = 10; $i >= 0; $i--):                                    
        $tot += $referencia[$i]*$ponderacions[$i];
    endfor;                                
    $cc = ($tot % 11); 
    if($cc == 10) $cc = 0;
    //Afegim el valor de check a la referència i seguim.
    $referencia .= $cc;
    
    $import = str_pad(strval($OM->getPagat()*100),10,'0',STR_PAD_LEFT);
    $codi = $inici.$entitat.$referencia.$import;
    
    $barcode = new phpCode128($codi, 150, false , false);
    $barcode->setEanStyle(true);
    $barcode->setAutoAdjustFontSize(true);                                       
    $barcode->saveBarcode(OptionsPeer::getString('SF_WEBSYSROOT',1).'tmp/'.$idS.'-barcode.png');                
                                                                                                
    //Comença la càrrega d'informació.
    $i = 1;
    $HTML = OptionsPeer::getString( 'BODY_DOC_MATR_CAIXER' , $idS );
    
    //CONSULTEM USUARI
    $OU = UsuarisPeer::retrieveByPK( $OM->getUsuarisusuariid() );
    $OC = CursosPeer::retrieveByPK( $OM->getCursosidcursos() );
                    
    $HTML = str_replace( '@@LOGO_URL@@' ,       OptionsPeer::getString('LOGO_URL',$idS) ,       $HTML );
    $HTML = str_replace( '@@CODI_BARRES@@' ,    $idS ,                                          $HTML );
    $HTML = str_replace( '@@TIPUS_PAGAMENT@@' , $OM->getTpagamentString() ,                     $HTML );
    $HTML = str_replace( '@@CODI@@' ,           $codi ,                                         $HTML );
    $HTML = str_replace( '@@FACTURA@@',         $OM->getIdmatricules(),                         $HTML );
    $HTML = str_replace( '@@CODI_CLIENT@@',     $OM->getUsuarisusuariid(),                      $HTML );
    $HTML = str_replace( '@@DATA_FACTURA@@',    date('d/m/Y',time()),                           $HTML );
    $HTML = str_replace( '@@NOM@@',             $OU->getNomComplet(),                           $HTML );
    $HTML = str_replace( '@@TELEFON@@',         $OU->getTelefonString(),                        $HTML );
    $HTML = str_replace( '@@NIF@@',             $OU->getDni(),                                  $HTML );
    $HTML = str_replace( '@@CARRER@@',          $OU->getAdreca(),                               $HTML );
    $HTML = str_replace( '@@POBLE@@',           $OU->getPoblacioString(),                       $HTML );
    $HTML = str_replace( '@@CODI_POSTAL@@',     $OU->getCodipostal(),                           $HTML );
    $HTML = str_replace( '@@CONCEPTE@@',        $OC->getTitolcurs(),                            $HTML );
    $HTML = str_replace( '@@DIA@@',             $OC->getDatainici('d/m/Y'),                     $HTML );
    $HTML = str_replace( '@@HORARIS@@',         $OC->getHoraris(),                              $HTML );
    $HTML = str_replace( '@@P@@',               $OM->getPagat(),                                $HTML );
    $HTML = str_replace( '@@Q@@',               1,                                              $HTML );
    $HTML = str_replace( '@@I@@',               $OM->getPagat(),                                $HTML );
    $HTML = str_replace( '@@BASE@@',            $OM->getPagat(),                                $HTML );
    $HTML = str_replace( '@@IVA@@',             0,                                              $HTML );
    $HTML = str_replace( '@@TOTAL@@',           $OM->getPagat(),                                $HTML );
    $HTML = str_replace( '@@TITULAR@@',         "",                                             $HTML );
    $HTML = str_replace( '@@CCC@@',             "",                                             $HTML );                                

    return $HTML;
    
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


  static public function sendMail($from,$to,$subject,$body = "",$files = array())
    {    
        //Si entrem un mail que no és en format array, l'inicialitzem
        $mails = $to;
        if(!is_array($to)) $mails = array($to);
        
        //Definim el mailer
    //        $t = Swift_SmtpTransport::newInstance('smtp.casadecultura.org',587);
    //        $t->setUsername('informatica@casadecultura.org');
    //        $t->setPassword('gi1807bj');
        $t = Swift_MailTransport::newInstance();
        $mailer = Swift_Mailer::newInstance($t);
        
        //Enviem tots els correus         
        foreach($mails as $to):
        
            //Comencem l'enviament de correus als que el tinguin correcte.
       	    try{
                
        		$sm = Swift_Message::newInstance($subject,$body,'text/html','utf8');
                $sm->setFrom($from);
                $sm->setTo($to);
        		
        		foreach($files as $F):
        			$sm->attach(Swift_Attachment::fromPath($F['tmp_name']));
        		endforeach;        		        			    
            	
        		$OK = $mailer->send($sm,$errors);                                                
            
            } catch (Exception $e) { $OK = false; myUser::addLogActionStatic(0,'ErrorEnviantMailSaveMissatgeGlobal',$e->getMessage(),null); }                        
            
        endforeach;
    	
        return array('OK'=>$OK,'MAILS_INC'=>$errors);
    }   
  
  
}
