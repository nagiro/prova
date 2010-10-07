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
  
  static function getCursosMatriculacio()
  {
  	
  	$C = new Criteria();

	$C->add(CursosPeer::ISACTIU,true);     
	$C->addDescendingOrderByColumn(CursosPeer::CATEGORIA);
	$C->addDescendingOrderByColumn(CursosPeer::CODI);

	return CursosPeer::doSelect($C);
  	
  }
  
  static function cercaCursos($CERCA , $PAGINA = 1)
  {     

     $C = new Criteria();
         
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

  static function cercaAlumnes( $CERCA , $PAGINA = 1 )
  {
     
     $C = new Criteria();           
     $C1 = $C->getNewCriterion(UsuarisPeer::NOM, '%'.$CERCA.'%',CRITERIA::LIKE);
     $C2 = $C->getNewCriterion(UsuarisPeer::COG1, '%'.$CERCA.'%',CRITERIA::LIKE);
     $C3 = $C->getNewCriterion(UsuarisPeer::COG2, '%'.$CERCA.'%',CRITERIA::LIKE);
     $C4 = $C->getNewCriterion(UsuarisPeer::DNI, '%'.$CERCA.'%',CRITERIA::LIKE);
     
     $C1->addOr($C2); $C1->addOr($C3);$C1->addOr($C4);
     
     $C->add($C1);
     
     $C->addJoin( array( UsuarisPeer::USUARIID ) , array( self::USUARIS_USUARIID ) );     
     
     $C->addAscendingOrderByColumn(UsuarisPeer::COG1);
     $C->addAscendingOrderByColumn(UsuarisPeer::NOM);
     $C->addGroupByColumn(UsuarisPeer::DNI);
     
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

  //M'informa si actualment estic dins el període de matriculació dels antics alumnes. 
  static function isPeriodeAnticsAlumnes()
  {

  	$DiAa = TipusPeer::getDataIniciMatriculaAnticsAlumnes();
  	$DiT  = TipusPeer::getDataIniciMatriculaTothom();
  	$avui = date('Y-m-d',time());
  	
  	return ($DiAa < $avui && $avui < $DiT );
  	
  }
  
  //Ens diu si l'alumne ha fet algun curs durant l'últim any i mig. 
  static function isAnticAlumne($idU)
  {
  	
  	$DATA_ANY_I_MIG_ENRRERA = mktime(0,0,0,date('m',time())-18,date('d',time()),date('Y',time()));
  	
  	$C = new Criteria();
  	$C->add(self::USUARIS_USUARIID, $idU);
  	$C->addJoin(self::CURSOS_IDCURSOS,CursosPeer::IDCURSOS);
  	$C->add(CursosPeer::DATAINICI, $DATA_ANY_I_MIG_ENRRERA, CRITERIA::GREATER_THAN);
    	
  	return (self::doCount($C) == 0)?false:true;    	
  	
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
  
  static function getMatriculesUsuari($idU){
    $C = new Criteria();
    $C->add(MatriculesPeer::USUARIS_USUARIID , $idU);
    $C->add(MatriculesPeer::ESTAT, self::EN_PROCES, CRITERIA::NOT_EQUAL);
    $C->addDescendingOrderByColumn(MatriculesPeer::DATAINSCRIPCIO);

    return MatriculesPeer::doSelect($C);
  }

  static function getMatriculesCurs($idC){
      $C = new Criteria();
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
  static function getTPV($PREU , $NOM , $matricula, $WEB = true)
  {
     $TPV = array();
     
     $TPV['Ds_Merchant_Amount'] = $PREU*100;
     $TPV['Ds_Merchant_Currency'] = '978';
     $TPV['Ds_Merchant_Order'] = date('ymdHis'); 
     $TPV['Ds_Merchant_MerchantCode'] = '091623116';
     $TPV['Ds_Merchant_Terminal'] = '1';
     $TPV['Ds_Merchant_TransactionType'] = '0';
     if($WEB):
        $TPV['Ds_Merchant_MerchantURL'] = 'http://servidor.casadecultura.cat/web_beta/web/GetTPV';
        $TPV['Ds_Merchant_UrlOK'] = 'http://servidor.casadecultura.cat/web_beta/web/MatriculaFinal/OK/1';
        $TPV['Ds_Merchant_UrlKO'] = 'http://servidor.casadecultura.cat/web_beta/web/MatriculaFinal';
     else:
        $TPV['Ds_Merchant_MerchantURL'] = 'http://servidor.casadecultura.cat/web_beta/gestio/FinalitzaMatricula';                         
        $TPV['Ds_Merchant_UrlOK'] = 'http://servidor.casadecultura.cat/web_beta/gestio/matriculat';
        $TPV['Ds_Merchant_UrlKO'] = 'http://servidor.casadecultura.cat/web_beta/gestio/matriculat';
     endif;
        
     $TPV['Ds_Merchant_ProductDescription'] = 'Matrícula Casa de Cultura';
     $TPV['Ds_Merchant_Titular'] = $NOM;
     $TPV['Ds_Merchant_MerchantName'] = 'Casa de Cultura';
     $TPV['Ds_Merchant_MerchantData'] = $matricula;
              
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
    
    $RET = false; 
    $MATRICULA = MatriculesPeer::retrieveByPK($M);
    $CURS_PLE = CursosPeer::isPle($MATRICULA->getCursosIdcursos()); //Passem si el curs es ple 
  	
  	 //Mirem si el curs és ple. Si es ple i no hi ha cap import pagat, guardem com en espera.
     if(!$CURS_PLE){
     	$MATRICULA->setEstat(self::ACCEPTAT_PAGAT);
        $RET = true; 	
     } else {
        if($MATRICULA->getPagat() > 0){ $MATRICULA->setEstat(self::ACCEPTAT_PAGAT); $RET = true; }
        else { $MATRICULA->setEstat(self::EN_ESPERA); $RET = false;  }     
     }
               
     $MATRICULA->save();
     
     return $RET; 
     
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
  
  static public function getMatriculesPagadesDia($modePagament = 0)
  {
  	$C = new Criteria();
  	$C->add(MatriculesPeer::ESTAT, MatriculesPeer::ACCEPTAT_PAGAT);
  	$C->addDescendingOrderByColumn(MatriculesPeer::DATAINSCRIPCIO);    
  	$C->addJoin(MatriculesPeer::USUARIS_USUARIID, UsuarisPeer::USUARIID);
  	$C->addJoin(MatriculesPeer::CURSOS_IDCURSOS, CursosPeer::IDCURSOS);
  	if($modePagament > 0) $C->add(matriculesPeer::TPAGAMENT, $modePagament );  	
  	return self::doSelect($C);
  }
  
  static public function MailMatricula($OM)
  {
  	
  	$Nom = $OM->getUsuaris()->getNomComplet();
  	$NomCurs = $OM->getCursos()->getCodi().' | '.$OM->getCursos()->getTitolcurs();
  	$dataInici = $OM->getCursos()->getDatainici('d-m-Y');
  	$text = "";
  	$text .= '

        <table width="640px" style="font-family: sans-serif; font-size:14px; margin:0 auto; border:0px solid #B33330;">
        <tr><td align="center" style=" padding:20px;"><img width="200px" src="http://servidor.casadecultura.org/downloads/logos/CCG_BLANC.jpg" /></td></tr>
        <tr><td style="border-top:2px solid #B33330;padding: 20px; text-align: left;">

        <p>Benvolgut/da '.$Nom.'</p>
        
        <p>La seva matrícula al curs '.$NomCurs.' s\'ha efectuat correctament. Per qualsevol dubte, consulta o suggeriment si us plau adrecis al web de la Casa de Cultura i entri a la seva zona o bé cliqui <a href="http://servidor.casadecultura.cat/web_beta/web/login">aquí </a>.
        Si no recorda o no sap la seva contrassenya cliqui <a href="http://servidor.casadecultura.cat/web_beta/web/remember">aquí </a>.
        </p>     
        <p>L\'esperem el dia '.$dataInici.' a la classe.</p>                
        <p>Cordialment, <br />Casa de Cultura de Girona</p>
        <p><span style="font-size:10px; font-style: italic; color: gray;">En cas de resposta afirmativa, les vostres dades seran incorporades a un fitxer titularitat de la Fundaci&oacute; Casa de Cultura creat sota la seva responsabilitat per a gestionar les activitats que s&rsquo;hi porten a terme i per a informar-ne a persones que hi estiguin interessades. La Casa de Cultura es compromet a complir els seus deures de mantenir reserva i d&rsquo;adoptar les mesures legalment previstes i les t&egrave;cnicament necess&agrave;ries per evitar-ne un acc&eacute;s o qualsevol classe de tractament no autoritzat. Podran ser cedides a altres persones amb les quals la Casa de Cultura col&bull;labora en la programaci&oacute; i organitzaci&oacute; d&rsquo;activitats, exclusivament a l&rsquo;efecte de fer-vos arribar la informaci&oacute; que vost&egrave; manifesta estar interessat en rebre. Per qualsevol altre cessi&oacute; requerir&iacute;em pr&egrave;viament el seu consentiment. En qualsevol cas podeu exercir els vostres drets d&rsquo;acc&eacute;s, rectificaci&oacute; i cancel&bull;laci&oacute; tot adre&ccedil;ant-se a: Sr/a. Director/a de la Casa de Cultura, Pla&ccedil;a de l&rsquo;Hospital 6, 17002 GIRONA, tel&egrave;fon 972 202 013 i correu electr&ograve;nic  secretaria@casadecultura.org.</span></p>
        
        </td></tr>
        </table>';
      				
   	return $text; 
  	
  }

  static public function MailMatriculaFAIL($OM)
  {
  	
  	$Nom = $OM->getUsuaris()->getNomComplet();
  	$NomCurs = $OM->getCursos()->getCodi().' | '.$OM->getCursos()->getTitolcurs();
  	$dataInici = $OM->getCursos()->getDatainici('d-m-Y');
  	$text = "";
  	$text .= '

        <table width="640px" style="font-family: sans-serif; font-size:14px; margin:0 auto; border:0px solid #B33330;">
        <tr><td align="center" style=" padding:20px;"><img width="200px" src="http://servidor.casadecultura.org/downloads/logos/CCG_BLANC.jpg" /></td></tr>
        <tr><td style="border-top:2px solid #B33330;padding: 20px; text-align: left;">

        <p>Benvolgut/da '.$Nom.'</p>
        
        <p>La seva matrícula al curs '.$NomCurs.' no s\'ha pogut realitzar. Actualment el curs és ple o bé ha tingut algun problema a l\'hora de realitzar-la. 
        Si vostè vol comprovar l\'estat de la seva matrícula truqui al telèfon 972.20.20.13 o bé enviï un correu a informatica@casadecultura.org per comprovar què ha succeït.
        </p>                     
        <p>Cordialment, <br />Casa de Cultura de Girona</p>
        <p><span style="font-size:10px; font-style: italic; color: gray;">En cas de resposta afirmativa, les vostres dades seran incorporades a un fitxer titularitat de la Fundaci&oacute; Casa de Cultura creat sota la seva responsabilitat per a gestionar les activitats que s&rsquo;hi porten a terme i per a informar-ne a persones que hi estiguin interessades. La Casa de Cultura es compromet a complir els seus deures de mantenir reserva i d&rsquo;adoptar les mesures legalment previstes i les t&egrave;cnicament necess&agrave;ries per evitar-ne un acc&eacute;s o qualsevol classe de tractament no autoritzat. Podran ser cedides a altres persones amb les quals la Casa de Cultura col&bull;labora en la programaci&oacute; i organitzaci&oacute; d&rsquo;activitats, exclusivament a l&rsquo;efecte de fer-vos arribar la informaci&oacute; que vost&egrave; manifesta estar interessat en rebre. Per qualsevol altre cessi&oacute; requerir&iacute;em pr&egrave;viament el seu consentiment. En qualsevol cas podeu exercir els vostres drets d&rsquo;acc&eacute;s, rectificaci&oacute; i cancel&bull;laci&oacute; tot adre&ccedil;ant-se a: Sr/a. Director/a de la Casa de Cultura, Pla&ccedil;a de l&rsquo;Hospital 6, 17002 GIRONA, tel&egrave;fon 972 202 013 i correu electr&ograve;nic  secretaria@casadecultura.org.</span></p>
        
        </td></tr>
        </table>';
      				
   	return $text; 
  	
  }  
  
  
}
