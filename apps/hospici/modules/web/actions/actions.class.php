<?php

/**
 * hospici actions.
 *
 * @package    intranet
 * @subpackage hospici
 * @author     Albert Johé i Martí
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class webActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    
    $this->setLayout('hospici');
    $this->accio = $request->getParameter('accio','index');
    $this->AUTENTIFICAT = $this->getUser()->isAuthenticated();                
    
    //Carrego la cerca
    $this->CERCA = $this->getUser()->getSessionPar('cerca');
    $C = $this->CERCA;            
    $this->DESPLEGABLES = array();            

    switch($this->accio){
        
        case 'cerca_activitat':
                                                                
                //Agafo els paràmetres si é sun post o bé si canvi de pàgina o sinó doncs cerca en blanc.                 
                if($request->getMethod() == 'POST') $C = $request->getParameter('cerca',array());                               
                $C['P'] = $request->getParameter('P',1);

                $this->getUser()->ParReqSesForm($request,'cerca',array());                                   
                $C['P'] = $request->getParameter('P',1);                     
                
                //Si em trobo el paràmetre SITE, impilca que he entrat per llistat d'entitats i vull veure tot el d'una.
                if($request->hasParameter('SITE')) $C['SITE'] = $request->getParameter('SITE');                                
                                                
                //Normalitzo tots els camps                    
                $C2 = $this->getCercaComplet($C);
                
                $RET = ActivitatsPeer::getActivitatsCercaHospici($C2);
                
                $this->ACTIVITATS_AMB_ENTRADES = EntradesReservaPeer::h_getEntradesActivitatUsuariArray($this->getUser()->getSessionPar('idU'));
                                
                $this->LLISTAT_ACTIVITATS = $RET['PAGER'];
                $LACTIVITATS = $RET['LACTIVITATS'];                
                $this->DESPLEGABLES['SELECT_POBLACIONS'] = ActivitatsPeer::getPoblacionsActivitatsHospici($LACTIVITATS);
                $this->DESPLEGABLES['SELECT_ENTITATS']   = ActivitatsPeer::getEntitatsActivitatsHospici($LACTIVITATS);
                $this->DESPLEGABLES['SELECT_CATEGORIES'] = ActivitatsPeer::getCategoriaActivitatsHospici($LACTIVITATS);
                                                        
                //Guardem a sessió la cerca "actual"        
                $this->CERCA = $C2;
                $this->getUser()->setSessionPar('cerca',$this->CERCA);
                $this->ERROR = $request->getParameter('ERROR',0);                                                                                                                                                    
                                                                
                $this->MODE = 'CERCA';
            break;
    
        case 'detall_activitat':                
                $this->CERCA = $this->getUser()->getSessionPar('cerca');
                $this->ACTIVITAT = ActivitatsPeer::retrieveByPK($request->getParameter('idA'));
                $this->HORARIS_AMB_ENTRADES = EntradesReservaPeer::h_getEntradesUsuariArray($this->getUser()->getSessionPar('idU'));
                $this->HORARIS = $this->ACTIVITAT->getHorarisOrdenats(HorarisPeer::DIA);                                                                            
                                
                $this->MODE = 'DETALL';
            break;
        
        //Arribem per primer cop al web o no entrem per cap url interessant
        default:
                                
            //Inicialitzem la cerca i la guardem a memòria
            $this->CERCA = $this->getCercaComplet(null);
            $this->getUser()->setSessionPar('cerca',$this->CERCA);
            $this->MODE = 'INICIAL';
    }                                        
    
  }
   

  /**
   * Omple el quadre de cerca amb tots els valors per defecte. 
   * */
  private function getCercaCursosComplet($C)
  {    
    if(!isset($C['TEXT']))              $C['TEXT'] = "";
    if(!isset($C['SITE']))              $C['SITE'] = 0;
    if(!isset($C['POBLE']))             $C['POBLE'] = 0;
    if(!isset($C['CATEGORIA']))         $C['CATEGORIA'] = 0;
    if(!isset($C['DATA']))              $C['DATA'] = 0;    
    if(!isset($C['P']))                 $C['P'] = 1;
    return $C;
  }  

  /**
   * Omple el quadre de cerca amb tots els valors per defecte. 
   * */
  private function getCercaEspaisComplet($C)
  {    
    if(!isset($C['TEXT']))              $C['TEXT'] = "";
    if(!isset($C['SITE']))              $C['SITE'] = 0;
    if(!isset($C['POBLE']))             $C['POBLE'] = 0;
    if(!isset($C['CATEGORIA']))         $C['CATEGORIA'] = 0;    
    if(!isset($C['P']))                 $C['P'] = 1;
    return $C;
  }  


  /**
   * Omple el quadre de cerca amb tots els valors per defecte. 
   * */
  private function getCercaComplet($C)
  {      
    if(!isset($C['TEXT']))              $C['TEXT'] = "";
    if(!isset($C['SITE']))              $C['SITE'] = 0;
    if(!isset($C['POBLE']))             $C['POBLE'] = 0;
    if(!isset($C['CATEGORIA']))         $C['CATEGORIA'] = 0;
    if(!isset($C['DATAI']))             $C['DATAI'] = date('d/m/Y',time());
    if(!isset($C['DATAF']))             $C['DATAF'] = date('d/m/Y',time()); //date('d/m/Y',mktime(0,0,0,date('m',time())+1,date('d',time()),date('Y',time())));
    if(!isset($C['P']))                 $C['P'] = 1;
    return $C;
  }   

  /**
   * Omple el quadre de cerca amb tots els valors per defecte. 
   * */
  private function getCercaFormularisComplet($C)
  {    
    if(!isset($C['TEXT']))              $C['TEXT'] = "";
    if(!isset($C['SITE']))              $C['SITE'] = 0;        
    if(!isset($C['P']))                 $C['P'] = 1;
    return $C;
  }  


  public function executeLoginAjax(sfWebRequest $request){

    if($this->makeLogin($request->getParameter('login'),$request->getParameter('pass'))){
                $this->renderText('OK');        
    } else {    $this->renderText($request->getParameter('login'));  }    
            
    return sfView::NONE;
  }
    
  public function executeFeedbackAjax(sfWebRequest $request){

    $TEXT = $request->getParameter('nom');
    $TEXT .= '<br />'.$request->getParameter('mail');
    $TEXT .= '<br />'.$request->getParameter('comentari');
    $this->sendMail('informatica@casadecultura.org','informatica@casadecultura.org','Hospici :: Nou suggeriment',$TEXT);
    $this->renderText('OK');        
                        
    return sfView::NONE;
  }

  public function executeLogin(sfWebRequest $request)
  {
    $this->setLayout('hospici');    
    $this->setTemplate('index');                
  
    $login = ""; $pass  = "";
  
    if($request->hasParameter('id')){        
        $PAR = unserialize(Encript::Desencripta($request->getParameter('id')));
        $login = $PAR['login']; $pass = $PAR['pass'];   
    } else {
        $login = $request->getParameter('login');
        $pass  = $request->getParameter('pass');
    }
    
    if($this->makeLogin($login,$pass)){
                $this->redirect('@hospici_usuaris');        
    } else {    $this->redirect('@hospici_cercador_activitats?ERROR=1');  }
            
  }      

  private function makeLogin($user,$pass){

    $OU = UsuarisPeer::getUserLogin($user,$pass,null);
    
    $OK = false;    
    if($OU instanceof Usuaris):
        $this->getUser()->setAuthenticated(true);        
        $this->getUser()->setSessionPar('idU',$OU->getUsuariid());
        $this->getUser()->setSessionPar('username',$OU->getNomComplet());
        $this->getUser()->setSessionPar('compres',array());        
        $OK = true;        
    else: 
        $this->getUser()->setAuthenticated(false);
        $this->getUser()->setSessionPar('idU',0);
        $this->getUser()->setSessionPar('username','');
        $this->getUser()->setSessionPar('compres',array());
        $OK = false;        
    endif;

    return $OK;
    
  }

  public function executeRemember(sfWebRequest $request)
  {
    
    $this->setLayout('hospici');
    
    if($request->isMethod('POST')):        
        //L'usuari he enviat el seu DNI i se li ha d'enviar la contrassenya
        $RS = $request->getParameter('remember');        
        $this->FREMEMBER = new RememberForm();
        $this->FREMEMBER->bind($RS);
        if($this->FREMEMBER->isValid()):
            $OU = UsuarisPeer::cercaDNI($this->FREMEMBER->getValue('DNI'));
            $BODY = OptionsPeer::getString('MAIL_REMEMBER',SitesPeer::HOSPICI_ID);
            $BODY = str_replace('{{PASSWORD}}',$OU->getPasswd(),$BODY);
            $this->ENVIAT = $this->sendMail(OptionsPeer::getString('MAIL_FROM',$this->IDS),$OU->getEmail(),' Hospici :: Recordatori de contrasenya ',$BODY);
            $this->ENVIAT = $this->sendMail(OptionsPeer::getString('MAIL_FROM',$this->IDS),'informatica@casadecultura.org', '[Hospici :: RECORDATORI '.$OU->getUsuariid().']',$BODY);
            if(!$this->ENVIAT):
                $this->SECCIO = "ERROR_ENVIAMENT";
            else:
                $this->SECCIO = 'ENVIADA';                         			            
            endif;                   
            
        else: 
            $this->SECCIO = 'ERROR_DNI_VALIDACIO';
        endif;        
            
    else:     
        $this->FREMEMBER = new RememberForm();    
        $this->SECCIO = 'INICI';        
    endif;
    
  }

  public function executeAlta(sfWebRequest $request)
  {
    $this->setLayout('hospici');
    
    if($request->isMethod('POST')):        
        //L'usuari, l'he de donar d'alta de l'Hospici com a mínim, que serà un SITE = 0.
        //Primer mirarem si l'usuari ja existeix
        $RS = $request->getParameter('usuaris');
        $this->FUSUARI = UsuarisPeer::initialize(null,0,false,true);
        $this->FUSUARI->bind($RS);
        if($this->FUSUARI->isValid()):
            $this->FUSUARI->save();
            $this->SECCIO = 'GUARDAT';
            $OU = $this->FUSUARI->getObject();
            myUser::addLogTimeline( 'alta' , 'Usuari (Hospici)' , $OU->getUsuariId() , 0 , $OU->getUsuariId() );
            $this->makeLogin($OU->getDni(),$OU->getPasswd());                        
        else: 
            $this->SECCIO = 'INICI';        
        endif;                    
    else:     
        $this->FUSUARI = UsuarisPeer::initialize(null,0,false,true);
        $this->SECCIO = 'INICI';    
    endif;
    
  }
  
  public function executeUsuaris(sfWebRequest $request)
  {
    
    $this->setLayout('hospici');
    $accio = $request->getParameter('accio','inici');
    $this->IDU = $this->getUser()->getSessionPar('idU');
    $this->IDS = SitesPeer::HOSPICI_ID;
    $this->SECCIO = "";
    
    switch($accio){
        
        case 'inici':
            $this->SECCIO = 'INICI';
        break;
        
        //Modificació de les dades de l'usuari.
        case 'update':
            $RS = $request->getParameter('usuaris');
            if($RS['UsuariID'] == $this->IDU):
                $FU = UsuarisPeer::initialize($this->IDU,$this->IDS,false,true);
                $FU->bind($RS);                
                if($FU->isValid()):
                    $FU->save();
                    myUser::addLogTimeline( 'modificacio' , 'Usuari (Hospici)' , $FU->getObject()->getUsuariId() , 0 , $FU->getObject()->getUsuariId() );
                    $this->MISSATGE1 = "OK";                                                 
                endif;                                                       
            endif;
            $this->SECCIO = 'USUARI';
        break;

        //Imprimeix el full de pagament en cas que existeixi. 
        case 'printFactura':
            
            $OER = EntradesReservaPeer::retrieveByPK( $request->getParameter( 'idER' ) );
            if( !is_null( $OER ) ):
                $HTML = EntradesReservaPeer::DocReservaEntrades( $OER , $OER->getSiteid() );                                                                                        
                myUser::Html2PDF($HTML);                                
    			throw new sfStopException;	
            endif;
            //Imprimim el comprovant d'entrada.
        break;
            
        //Usuari que compra o reserva una entrada
        case 'compra_entrada':            
            $RA = $request->getParameter('entrades',array());
                                      
            $IDA = $RA['idA'];
            $IDH = $RA['idH'];
            $NEntrades = (int)$RA['num'];
            $Descompte = (int)$RA['descomptes'];            
            $TPagament = (int)$RA['tipus_pagament'];
            
            //Comprem o reservem l'entrada
            $RET = EntradesReservaPeer::setCompraEntrada( $IDH , $this->IDU , $NEntrades , $Descompte , $TPagament );
            
            switch( $RET['status'] ){
                
                //(OH incorrecte)
                case -1:    $this->MISSATGE2 = "HORARI_INCORRECTE";         break;                
                
                //(OA incorrecte)
                case -2:    $this->MISSATGE2 = "ACTIVITAT_INCORRECTE";      break;                
                
                //(OEP incorrecte)                
                case -3:    $this->MISSATGE2 = "PREU_INCORRECTE";           break;                
                
                //(Repe)
                case -4:    $this->MISSATGE2 = "ENTRADA_REPE";              break;                
                
                //(Exhaurides)
                case -5:    $this->MISSATGE2 = "NO_QUEDEN_PROU_ENTRADES";   break;                
                
                //(Error TPV)
                case -6:    $this->MISSATGE2 = "ERROR_TPV";                 break;                
                
                //(Es volen comprar 0 entrades)
                case -7:    $this->MISSATGE2 = "ERROR_MINIM_ENTRADES";      break;                
                
                //(Compra metàl·lic o codi de barres OK)
                case 1:     
                    $this->MISSATGE2 = "COMPRA_OK";
                    $this->IDER = $RET['OER']->getIdentrada();                 
                break;
                                
                //(Reserva d\'entrada OK)
                case 2:     
                    $this->MISSATGE2 = "RESERVA_OK";                
                    $this->IDER = $RET['OER']->getIdentrada();
                break;
                                
                //(Pagament amb TPV)
                case 3:                    
                    $NOM  = UsuarisPeer::retrieveByPK( $RET['OER']->getUsuariid() )->getNomComplet();
                    $PREU_TOTAL = $RET['OER']->getPagat() * $RET['OER']->getQuantitat(); 
        			$this->TPV = MatriculesPeer::getTPV( $PREU_TOTAL , $NOM , $RET['OER']->getIdEntrada() , $RET['OER']->getSiteid() , true , true );
                    $this->URL = OptionsPeer::getString('TPV_URL',$RET['OER']->getSiteId());                    
                    $this->setLayout('blanc');
                    $this->setTemplate('pagament'); 
                break;
                                
                //(En llista d'espera)
                case 4:     $this->MISSATGE2 = "LLISTA_ESPERA_OK";          break;
                                
                //(Pagament amb domiciliació) || Aquest encara s'ha d'aplicar correctament.
                case 5:     $this->MISSATGE2 = "DOMICILIACIO_OK";           break;
                
            }   
                        
            $this->SECCIO = 'COMPRA_ENTRADA';
                                                
        break;
        
        //Usuari que anul·la una entrada prèviament reservada
        case 'anula_entrada':            
            $RS = $request->getParameter('idER');
            $OER = EntradesReservaPeer::retrieveByPK($RS);
            $idu = $OER->getUsuariid();
            $act = $OER->getActiu();
            
            if($idu == $this->IDU && $act):
                $OER->setEstat(EntradesReservaPeer::ANULADA);
                $OER->save();
            endif;                        
                                    
            $this->SECCIO = 'COMPRA_ENTRADA';
                                                
        break;        
        
        //Nova matrícula a un curs
        case 'nova_matricula':
            
            //Gestionem el pagament d'una matrícula.
            $RP = $request->getParameter('matricula');            
            $idU = $this->getUser()->getSessionPar('idU');
            $idC = $RP['idC']; $idD = $RP['idD']; $idP = $RP['idP'];
            $CCC = $RP['ccc1'].$RP['ccc2'].$RP['ccc3'].$RP['ccc4'];
            $titular = $RP['titular']; $tutor_dni = $RP['dni_tutor']; $tutor_nom = $RP['nom_tutor'];                                                
                        
            $RET = MatriculesPeer::saveNewMatricula( $idU , $idC , "Hospici" , $idD , $idP );
            
            $AVISOS = $RET['AVISOS'];            
            $this->SECCIO = 'MATRICULA';
            $this->getUser()->addLogAction('SAVE_MATRICULA','gMatricules',$RET['OM']->getIdmatricules());            
                                                                 			
            //Si la matrícula surt amb algun error greu, redireccionem i mostrem un missatge.            
            $this->redirectIf(array_key_exists('ERR_USUARI',$AVISOS),'web/cursos?accio=detall_curs&idC='.$idC.'&mis=ERR_USUARI');
            $this->redirectIf(array_key_exists('ERR_CURS',$AVISOS),'web/cursos?accio=detall_curs&idC='.$idC.'&mis=ERR_CURS');
            $this->redirectIf(array_key_exists('ERR_JA_TE_UNA_MATRICULA',$AVISOS),'web/cursos?accio=detall_curs&idC='.$idC.'&mis=ERR_JA_TE_UNA_MATRICULA');
                                      
            //Si la matrícula surt amb un error o OK normal, mostrem el missatge.
            if(array_key_exists('CURS_PLE',$AVISOS)) $this->MISSATGE3 = "CURS_PLE";
            elseif(array_key_exists('CURS_PLE_LLISTA_ESPERA',$AVISOS)) $this->MISSATGE3 = "CURS_PLE_LLISTA_ESPERA";
            elseif(array_key_exists('RESERVA_OK',$AVISOS)) $this->MISSATGE3 = "OK";
            elseif(array_key_exists('MATRICULA_METALIC_OK',$AVISOS)) $this->MISSATGE3 = 'OK';            
            elseif(array_key_exists('MATRICULA_DOMICILIACIO_OK',$AVISOS)) $this->MISSATGE3 = 'OK';
            elseif(array_key_exists('MATRICULA_CODI_BARRES',$AVISOS)) $this->MISSATGE3 = 'OK';                
            
            //Si la matrícula es paga amb TPV posem les dades per a fer el pagament.
            if(array_key_exists('PAGAMENT_TPV',$AVISOS)):
                $NOM  = UsuarisPeer::retrieveByPK($RET['OM']->getUsuarisUsuariid())->getNomComplet();
    			$this->TPV = MatriculesPeer::getTPV( $RET['OM']->getPagat() , $NOM , $RET['OM']->getIdmatricules() , $RET['OM']->getSiteid() , true );
                $this->URL = OptionsPeer::getString('TPV_URL',$RET['OM']->getSiteId());                
                $this->setLayout('blanc');
                $this->setTemplate('pagament');                  
            endif;
            
            //Si el pagament és amb domiciliació, hem d'afegir el compte corrent i després el podrem donar per validada.
            if( array_key_exists( 'MATRICULA_DOMICILIACIO_OK' , $AVISOS ) ):
                
                //Consultem el curs per saber el Siteid
                $OC = CursosPeer::retrieveByPK($idC);
                
                //Afegim el compte corrent
                $ODB = DadesBancariesPeer::addCCC( $CCC , $OC->getSiteId() , $idU , "" , $titular );
                $RET['OM']->setIddadesbancaries( $ODB->getIddada() );                                                
                $RET['OM']->save();                

            endif;
            
            //Si tenim dades del tutor, les guardem.
            if(!empty($tutor_dni) || !empty($tutor_nom)):
                $RET['OM']->setTutordni($tutor_dni);
                $RET['OM']->setTutornom($tutor_nom);
                $RET['OM']->save();
            endif;

            if(empty($this->MISSATGE3)) $this->MISSATGE3 = "KO";
                        
            //Si no hi ha cap error i no és un pagament amb targeta, marquem com a matrícula feta
            if($this->MISSATGE3 == 'OK' && !array_key_exists('PAGAMENT_TPV',$AVISOS) ):
                myUser::addLogTimeline( 'alta' , 'Matricules (Hospici)' , $RET['OM']->getUsuarisUsuariid() , $RET['OM']->getSiteId() , $RET['OM']->getIdmatricules() );
            endif;
                                                                             
        break;

        //S'ha matriculat correctament i TPV ok
        case 'matricula_OK':
                $this->MISSATGE3 = "OK";
                $this->SECCIO   = 'MATRICULA';                
            break;
            
        //No s'ha matriculat correctament o error a TPV
        case 'matricula_KO':
                $this->MISSATGE3 = "KO";
                $this->SECCIO   = 'MATRICULA';
            break;        

        //Mostra totes les reserves que s'han fet
        case 'llista_reserves':
            $this->SECCIO = 'RESERVA';            
            $this->MISSATGE4 = $request->getParameter('estat',null);
        break;

        //Editem una reserva prèviament feta
        case 'edita_reserva':
        
            $this->SECCIO = "RESERVA";
            $OR = ReservaespaisPeer::retrieveByPK($request->getParameter('idR'));
            if($OR instanceof Reservaespais):
                $this->FReserva = new HospiciReservesForm($OR,array('IDS'=>$OR->getSiteid()));                
                $this->OPCIONS = 'VISUALITZA'; 
            else: 
                $this->redirect('@hospici_llista_reserves');
            endif;
            
        break;
        
        //Creem una nova reserva, i mostrem el formulari
        case 'nova_reserva':        
            $idE = $request->getParameter('idE');
            $OE = EspaisPeer::retrieveByPK($idE);
            $this->SECCIO = 'RESERVA';
            
            if($OE instanceof Espais){
                $this->FReserva = ReservaespaisPeer::initializeHospici(null,$OE->getSiteid(),$OE->getEspaiid(),$this->getUser()->getSessionPar('idU'));                                                
            } else {
                $this->MISSATGE4 = "ERROR_ESPAI";                
            }
        break;  
                                        
        //Guardem la nova reserva
        case 'save_nova_reserva':
            
            $RP = $request->getParameter('reservaespais');
            $EP = $request->getParameter('extres');
            $idU = $this->getUser()->getSessionPar('idU');
            $this->SECCIO = 'RESERVA';
            $this->FReserva = ReservaespaisPeer::initializeHospici(null,$RP['site_id'],null,$idU);
            $this->FReserva->bind($RP);            
            if($this->FReserva->isValid()){
                //Guardem la reserva
                $this->FReserva->save();
                $ORE = $this->FReserva->getObject();
                
                //A partir d'aquí guardem camps extres que surten del formulari
                $ORE->setHasDifusio($EP['sidifu']);
                $ORE->setWebDescripcio($EP['descweb']);
                $ORE->save();
                $Img = $request->getFiles('img');
                $Pdf = $request->getFiles('pdf');                
                $nom_img_final = getcwd().'/uploads/arxius/'.'RE-'.$ORE->getReservaespaiid().'-IMG-'.$Img['name'];
                $nom_pdf_final = getcwd().'/uploads/arxius/'.'RE-'.$ORE->getReservaespaiid().'-PDF-'.$Pdf['name'];                
                move_uploaded_file($Img['tmp_name'], $nom_img_final);
                move_uploaded_file($Pdf['tmp_name'], $nom_pdf_final);                                                         
                //Finalitzem l'emmagatzematge                                                                          
                
                $idReserva = $this->FReserva->getObject()->getReservaespaiid();
                
                //Enviem mails per informar que s'ha fet una nova reserva d'espais a secretaria
                $from = OptionsPeer::getString('MAIL_FROM',$RP['site_id']);
                $to   = OptionsPeer::getString('MAIL_SECRETARIA',$RP['site_id']);
                $sub  = "Hospici | Nova reserva d'espai";
                $miss = "S'ha sol·licitat una nova reserva d'espai amb el codi {$idReserva}";                              
                $this->sendMail($from, $to, $sub, $miss);
                
                //Guardem el registre al timeline
                myUser::addLogTimeline( 'alta' , 'Reserva (Hospici)' , $idU , $RP['site_id'] , $this->FReserva->getObject()->getReservaespaiid() );
                
                //Vinculem l'usuari amb el site corresponent
                UsuarisPeer::addSite($idU,$RP['site_id']);
                                                        
                $this->redirect('@hospici_llista_reserves?estat=OK');
            } else {
                $this->MISSATGE4 = 'ERROR_SAVE';            
            }                
                            
        break;

        //Alta d'un nou formulari
        case 'alta_formulari':
                        
            $RP = $request->getParameter('formulari');
            $idU = $this->getUser()->getSessionPar('idU');            
            $OF = FormularisRespostesPeer::initialize($RP['idF'],$idU,serialize($RP));
            $OF->save();                                                    
            
            //Enviem mails per informar que s'ha fet una nova reserva d'espais a secretaria
            $from = OptionsPeer::getString('MAIL_FROM',$OF->getSiteid());
            $to   = OptionsPeer::getString('MAIL_ADMIN',$OF->getSiteid());
            $sub  = "Hospici | Nou formulari enviat";
            $miss = "S'ha enviat la següent informació amb una reserva d'espai.<br/><br />Dades:<br /><br /> ";
            foreach($RP as $K=>$V):
                $miss .= $K.': '.$V.'<br/>';
            endforeach;
            $this->sendMail($from, $to, $sub, $miss);
            $this->sendMail($from, 'giroscopi@casadecultura.org', $sub, $miss);
            
            //Vinculem l'usuari amb el site corresponent
            UsuarisPeer::addSite($idU,$OF->getSiteid());
            
            $this->MISSATGE6 = 'ALTA_OK';
            $this->SECCIO = "FORMULARIS";
                            
        break;
        
        //Capturem el que ens arriba del mail de condicions. 
        case 'condicions':
            
            $this->SECCIO = 'RESERVA';
            $RP = $request->getParameter('reservaespais');
            $idU = $this->getUser()->getSessionPar('idU');
            $OR = ReservaespaisPeer::retrieveByPK($request->getParameter('idR'));
            if($OR instanceof Reservaespais):
                if($request->hasParameter('B_ACCEPTO')){
                    $OR->setEstat(ReservaespaisPeer::ACCEPTADA);
                    $OR->setDataacceptaciocondicions(date('Y-m-d',time()));
                    $OR->save();   
                    myUser::addLogTimeline( 'acceptada' , 'Reserva (Hospici)' , $idU , $OR->getSiteId() , $OR->getReservaespaiid() );         
                    $this->redirect('@hospici_llista_reserves?estat=RESERVA_ACCEPTADA');
                } elseif($request->hasParameter('B_NO_ACCEPTO')){
                    $OR->setEstat(ReservaespaisPeer::ANULADA);
                    $OR->setDataacceptaciocondicions(date('Y-m-d',time()));
                    $OR->save();
                    myUser::addLogTimeline( 'no_acceptada' , 'Reserva (Hospici)' , $idU , $OR->getSiteId() , $OR->getReservaespaiid() );
                    $this->redirect('@hospici_llista_reserves?estat=RESERVA_ANULADA');
                } else {
                    $this->redirect('@hospici_llista_reserves?estat=ERROR_TECNIC');
                }                
            else:                 
                $this->redirect('@hospici_llista_reserves?estat=ERROR_TECNIC');
            endif; 
                                                                                
        break;
                                                                               
    }
            
    //Si ja hi hem fet operacions... carreguem l'actual, sinó en fem un de nou.
    if(isset($FU) && $FU instanceof UsuarisForm) $this->FUsuari = $FU;
    else $this->FUsuari = UsuarisPeer::initialize($this->IDU,$this->IDS,false,true);
    
    $this->LMatricules = MatriculesPeer::h_getMatriculesUsuari($this->IDU);
    $this->LReserves = ReservaespaisPeer::h_getReservesUsuaris($this->IDU,$this->IDS);    
    $this->LEntrades = EntradesReservaPeer::getEntradesUsuari($this->IDU);        
    $this->LFormularis = FormularisRespostesPeer::getFormularisUsuari($this->IDU);    
    // $this->LMissatges = MissatgesPeer::getMissatgesUsuari();    
        
  }  



 /**
  * 
  * Funció que tracta el TPV després d'haver comprat unes entrades.
  * */
  public function executeGetTPVEntrades(sfWebRequest $request)
  {

    //Comprovem que vingui la crida per POST i que la resposta sigui 0000. Tot OK. 
    //if( $request->getParameter('Ds_Response') == '0000' )
    if( $request->getParameter('Ds_Response') == '0000' )                                
    {
        
        $idER = $request->getParameter('Ds_MerchantData',null);
        
        $OER  = EntradesReservaPeer::retrieveByPK($idER);
                            
        if($OER instanceof EntradesReserva)
        {
            $idS = $OER->getSiteid();
            
            $from = OptionsPeer::getString( 'MAIL_FROM' , $idS );
            
            //Un cop sabem que la matrícula existeix, comprovem la signatura i si és correcta, marquem com a pagat.
            if( MatriculesPeer::valTPV( $request->getParameter('Ds_Amount') , $request->getParameter('Ds_Order') , $request->getParameter('Ds_MerchantCode') , $request->getParameter('Ds_Currency') , $request->getParameter('Ds_Response') , $request->getParameter('Ds_Signature'), OptionsPeer::getString( 'TPV_PASSWORD' , $idS ) ) ) 
            {

                $MailEnt    = OptionsPeer::getMailEntrada($OER);
                $subject    = 'Hospici :: Nova entrada';
                $preu       = strval($request->getParameter('Ds_Amount')) / 100;                
                
                $OER->setEstat(EntradesReservaPeer::PAGAT);
                $OER->setTpvOperacio($request->getParameter('Ds_AuthorisationCode'));
                $OER->setTpvOrder($request->getParameter('Ds_Order'));
                $OER->setPagat($preu);
                $OER->save();
                myUser::addLogTimeline( 'compra targ.' , 'Entrades (Hospici)' , $OER->getUsuariid() , $OER->getSiteId() , $OER->getIdentrada() );                            
                                                
                $email = $OER->getEmail();
                if($email <> "") $this->sendMail( $from , $email , $subject , $MailEnt );
                $this->sendMail( $from , OptionsPeer::getString( 'MAIL_ADMIN' , $idS ) , $subject , $MailEnt );
                                
            } else {

     			$this->sendMail($from,'informatica@casadecultura.org','HASH ERRONI',serialize($_POST));
                
            }
                                        
        } else {
            
            $this->sendMail('informatica@casadecultura.org','informatica@casadecultura.org','CODI MATRÍCULA ERRONI',serialize($_POST));
            
        }
                            
    } else {
    
        $this->sendMail('informatica@casadecultura.org','informatica@casadecultura.org','NO HA ENTRAT AMB TPV',serialize($_POST));
        
    }
    
    return sfView::NONE;

  }


  public function executeGetTPV(sfWebRequest $request)
  {
    
    //Comprovem que vingui la crida per POST i que la resposta sigui 0000. Tot OK. 
    //if( $request->getParameter('Ds_Response') == '0000' )
    if( $request->getParameter('Ds_Response') == '0000' )                                
    {
    
        $idM = $request->getParameter('Ds_MerchantData',null);
        
        $OM     = MatriculesPeer::retrieveByPK($idM);
                            
        if($OM instanceof Matricules)
        {                                                
            
            $from   = OptionsPeer::getString('MAIL_FROM',$OM->getSiteId());
            
            //Un cop sabem que la matrícula existeix, comprovem la signatura i si és correcta, marquem com a pagat.
            if( MatriculesPeer::valTPV( $request->getParameter('Ds_Amount') , $request->getParameter('Ds_Order') , $request->getParameter('Ds_MerchantCode') , $request->getParameter('Ds_Currency') , $request->getParameter('Ds_Response') , $request->getParameter('Ds_Signature'), OptionsPeer::getString('TPV_PASSWORD',$OM->getSiteid() )))
            {
                                                                        
                $MailMat    = MatriculesPeer::MailMatricula( $OM , $OM->getSiteid() );
                $subject    = 'Hospici :: Nova matrícula';
                $preu       = strval($request->getParameter('Ds_Amount')) / 100;
                
                $OM->setEstat(MatriculesPeer::ACCEPTAT_PAGAT);
                $OM->setTpvOperacio($request->getParameter('Ds_AuthorisationCode'));
                $OM->setTpvOrder($request->getParameter('Ds_Order'));
                $OM->setPagat($preu);
                $OM->save();    
                myUser::addLogTimeline( 'matricula targ.' , 'Matricules (Hospici)' , $OM->getUsuarisUsuariid() , $OM->getSiteId() , $OM->getIdmatricules() );                        
                
                $this->sendMail( $from , $OM->getUsuaris()->getEmail() , $subject , $MailMat );
                $this->sendMail( $from , 'informatica@casadecultura.org' , $subject , $MailMat );
                $this->sendMail( $from , OptionsPeer::getString( 'MAIL_SECRETARIA' , $OM->getSiteid() ) , $subject , $MailMat );                
                                
            } else {

     			$this->sendMail($from,'informatica@casadecultura.org','HASH ERRONI',serialize($_POST));
                
            }
                                        
        } else {
            
            $this->sendMail('informatica@casadecultura.org','informatica@casadecultura.org','CODI MATRÍCULA ERRONI',serialize($_POST));
            
        }
                            
    } else {
    
        $this->sendMail('informatica@casadecultura.org','informatica@casadecultura.org','NO HA ENTRAT AMB TPV',serialize($_POST));
        
    }
    
    return sfView::NONE;

  }
  
  
  /**
   * hospiciActions::executeCursos()
   * 
   * Part de mostra de cursos a l'hospici
   * 
   * @param mixed $request   
   * @return void
   */
  public function executeCursos(sfWebRequest $request)
  {        
    
    $this->setLayout('hospici');
    $this->setTemplate('indexCursos');
    $this->accio = $request->getParameter('accio','index');            
    
    //Carrego la cerca
    $this->CERCA = $this->getUser()->getSessionPar('cerca',array());
    $C = $this->CERCA;    
    $this->DESPLEGABLES = array();
    $this->AUTH = $this->getUser()->isAuthenticated();
    $this->CURSOS_MATRICULATS = MatriculesPeer::h_getMatriculesCursosUsuariArray($this->getUser()->getSessionPar('idU'));    
    $this->MISSATGE = "";  
    $this->IDU = $this->getUser()->getSessionPar('idU');    
    
    if($this->accio == 'cerca_cursos' || $this->accio == 'inici'):
        
        /**
         * @param $P = Pàgina actual del llistat
         * @param $C = Cerca amb els paràmetres corresponents 
         * */
        //Agafo els paràmetres si é sun post o bé si canvi de pàgina o sinó doncs cerca en blanc.         
        if($request->getMethod() == 'POST') $C = $request->getParameter('cerca',array());        
        $C['P'] = $request->getParameter('P',1);

        //Si em trobo el paràmetre SITE, impilca que he entrat per llistat d'entitats i vull veure tot el d'una.
        if($request->hasParameter('SITE')) $C['SITE'] = $request->getParameter('SITE');
        
        $C2 = $this->getCercaCursosComplet($C);
                                
        //Faig la cerca dels cursos de l'Hospici i ho retorno amb valors
        //La cerca hauria de tornar els cursos, segons els paràmetres i a més els llistats amb els valors.    
        $RET = CursosPeer::getCursosCercaHospici($C2['TEXT'],$C2['SITE'],$C2['POBLE'],$C2['CATEGORIA'],$C2['DATA'],$C2['P']);        
        $this->LLISTAT_CURSOS = $RET['PAGER'];        
        $LCURSOS = $RET['LCURSOS'];
        $this->DESPLEGABLES['SELECT_POBLACIONS'] = CursosPeer::getPoblacionsCursosHospici($LCURSOS);
        $this->DESPLEGABLES['SELECT_ENTITATS']   = CursosPeer::getEntitatCursosHospici($LCURSOS);
        $this->DESPLEGABLES['SELECT_CATEGORIES'] = CursosPeer::getCategoriaCursosHospici($LCURSOS);
        $this->DESPLEGABLES['SELECT_DATES']      = CursosPeer::getDatesCursosHospici($LCURSOS);                
                                                                
        //Guardem a sessió la cerca "actual"
        $this->CERCA = $C2;    
        $this->getUser()->setSessionPar('cerca',$this->CERCA);
                             
        $this->MODE = 'CERCA';            
            
    elseif($this->accio == 'detall_curs'):
                    
        $this->CURS = CursosPeer::retrieveByPK($request->getParameter('idC'));        
        $this->MODE = 'DETALL';                       
        
        switch($request->getParameter('mis')){
            case 'ERR_USUARI': $this->MISSATGE = "Hi ha hagut algun problema carregant el seu usuari. Si us plau posi's en contacte amb informatica@casadecultura.org.";
            case 'ERR_CURS': $this->MISSATGE = "Hi ha hagut algun problema carregant el curs al que es vol matricular. Si us plau posi's en contacte amb informatica@casadecultura.org.";
            case 'ERR_JA_TE_UNA_MATRICULA': $this->MISSATGE = "Vostè ja està matriculat a aquest curs. Si us plau posi's en contacte amb informatica@casadecultura.org.";
        }        
    endif;                                        
    
  }

  /**
   * hospiciActions::executeEspais()
   * 
   * Part de mostra dels espais per reservar a l'hospici
   * 
   * @param mixed $request
   * @return void
   */
  public function executeEspais(sfWebRequest $request)
  {    
  
    $this->setLayout('hospici');
    $this->setTemplate('indexReservaEspais');
    $this->accio = $request->getParameter('accio','index');        
    
    //Carrego la cerca
    $this->CERCA = $this->getUser()->getSessionPar('cerca',array());    
    $this->DESPLEGABLES = array();
    $this->AUTH = $this->getUser()->isAuthenticated();      
    
    if($this->accio == 'cerca_espais' || $this->accio == 'inici'):
        
        //Agafo els paràmetres                
        if($request->getMethod() == 'POST') $C = $request->getParameter('cerca',array());
        $C['P'] = $request->getParameter('P',1);
        
        //Si em trobo el paràmetre SITE, impilca que he entrat per llistat d'entitats i vull veure tot el d'una.
        if($request->hasParameter('SITE')) $C['SITE'] = $request->getParameter('SITE');
        
        $C2 = $this->getCercaEspaisComplet($C);
                                        
        //Faig la cerca dels cursos de l'Hospici i ho retorno amb valors
        //La cerca hauria de tornar els cursos, segons els paràmetres i a més els llistats amb els valors.        
        $this->LLISTAT_ESPAIS = EspaisPeer::getEspaisCercaHospici($C2);                                 
        $this->DESPLEGABLES['SELECT_POBLACIONS'] = EspaisPeer::getPoblacionsHospici($C2);        
        $this->DESPLEGABLES['SELECT_ENTITATS']   = EspaisPeer::getEntitatsHospici($C2);
        $this->DESPLEGABLES['SELECT_CATEGORIES'] = EspaisPeer::getCategoriesHospici($C2);                        
                                                                
        //Guardem a sessió la cerca "actual"        
        $this->CERCA = $C2;    
        $this->getUser()->setSessionPar('cerca',$this->CERCA);
                             
        $this->MODE = 'CERCA';            
            
    elseif($this->accio == 'detall_espai'):
                    
                $this->ESPAI = EspaisPeer::retrieveByPK($request->getParameter('idE'));
                $this->DATA = $request->getParameter('data',time());                
                $month = date('m',$this->DATA); $year = date('Y',$this->DATA);                                
                $this->OCUPACIO = EspaisPeer::getEstadistiquesEspais(
                                                                        array($request->getParameter('idE')), 
                                                                        $this->ESPAI->getSiteId(), 
                                                                        $month,
                                                                        $year);
                                                                                        
                $d = mktime(0,0,0,$month+1,1,$year);
                $month = date('m',$d); $year = date('Y',$d);
                $this->OCUPACIO2 = EspaisPeer::getEstadistiquesEspais(
                                                                        array($request->getParameter('idE')), 
                                                                        $this->ESPAI->getSiteId(), 
                                                                        $month,
                                                                        $year);                                                                        
                $this->MODE = 'DETALL';                                        
    endif;                                        
    
  }

  /**
   * hospiciActions::executeEntitats()
   * 
   * Part de mostra dels espais per reservar a l'hospici
   * 
   * @param mixed $request
   * @return void
   */
  public function executeEntitats(sfWebRequest $request)
  {    
  
    $this->setLayout('hospici');
    $this->setTemplate('indexEntitats');
    $this->accio = $request->getParameter('accio','index');        
    
    //Carrego la cerca
    $this->CERCA = $this->getUser()->getSessionPar('cerca',array());
    $this->DESPLEGABLES = array();
    $this->AUTH = $this->getUser()->isAuthenticated();      
            
    //Comença la cerca *************************************************
            
    //Agafo els paràmetres
    $C = $request->getParameter('cerca',array());
    $C2 = $this->getCercaEspaisComplet($C);
                                    
    //Faig la cerca dels cursos de l'Hospici i ho retorno amb valors
    //La cerca hauria de tornar els cursos, segons els paràmetres i a més els llistats amb els valors.        
    $this->LLISTAT_ENTITATS = SitesPeer::getEntitatsCercaHospici($C2);
    $this->DESPLEGABLES['SELECT_POBLACIONS'] = SitesPeer::getPoblacionsCercaHospici($C2);                
    $this->DESPLEGABLES['SELECT_CATEGORIES'] = SitesPeer::getCategoriesCercaHospici($C2);                        
                                                            
    //Guardem a sessió la cerca "actual"        
    $this->CERCA = $C2;    
    $this->getUser()->setSessionPar('cerca',$this->CERCA);
                         
    $this->MODE = 'CERCA';            
                                                                                 
  }


  /**
   * hospiciActions::executeFormularis()
   * 
   * Part de mostra dels formularis a l'hospici
   * 
   * @param mixed $request
   * @return void
   */
  public function executeForms(sfWebRequest $request)
  {    
   
    $this->setLayout('hospici');
    $this->setTemplate('indexFormularis');
    $this->accio = $request->getParameter('accio','index');        
    
    //Carrego la cerca
    $this->CERCA = $this->getUser()->getSessionPar('cerca',array());    
    $this->DESPLEGABLES = array();
    $this->AUTH = $this->getUser()->isAuthenticated();
    $this->IDU  = $this->getUser()->getSessionPar('idU');      
    
    if($this->accio == 'cerca_formularis' || $this->accio == 'inici'):
        
        //Agafo els paràmetres                
        if($request->getMethod() == 'POST') $C = $request->getParameter('cerca',array());
        $C['P'] = $request->getParameter('P',1);
        
        //Si em trobo el paràmetre SITE, implica que he entrat per llistat d'entitats i vull veure els formularis.
        if($request->hasParameter('SITE')) $C['SITE'] = $request->getParameter('SITE');
        
        $C2 = $this->getCercaFormularisComplet($C);

        //La cerca hauria de tornar el llistat dels formularis que compleixen.        
        $this->LLISTAT_FORMS = FormularisPeer::getFormularisCercaHospici($C2);                                                 
        $this->DESPLEGABLES['SELECT_ENTITATS'] = FormularisPeer::getEntitatsHospici($C2);
                                                                
        //Guardem a sessió la cerca "actual"        
        $this->CERCA = $C2;    
        $this->getUser()->setSessionPar('cerca',$this->CERCA);
                             
        $this->MODE = 'CERCA';            
            
    elseif($this->accio == 'detall_formularis'):
                                    
                $idU = $this->getUser()->getSessionPar('idU',0);
                $idF = $request->getParameter('idF',0);
                $this->FORM = FormularisPeer::retrieveByPK($idF);
                $this->FORM_TEXT = FormularisRespostesPeer::getFormulariDetall( $idU , $idF );                                                                                                                                                        
                $this->MODE = 'DETALL';
                                
    endif;                          
                                                                                 
  }

  private function sendMail($from,$to,$subject,$body = "",$files = array())
  {
   	
    $swift_message = $this->getMailer()->compose($from,$to,$subject,$body);    
    foreach($files as $F):
    	$swift_message->attach(Swift_Attachment::fromPath($F['tmp_name']));
    endforeach;    
    $swift_message->setBody($body,'text/html');    
    return $this->getMailer()->send($swift_message);
		
  }


    /**
     * Gestió de formularis a través de mail     
     * */
   public function executeFormularis(sfWebRequest $request)
   {               
    
        $this->setLayout('gestio');
        $this->DEFAULT = false;
        $this->IDU = $this->getUser()->getSessionPar('idU');
        $this->IDS = $this->getUser()->getSessionPar('idS');
    
        //Entren crides i es mostra una reposta en web si ha anat bé o no.        
        $PARAMETRES = Encript::Desencripta($request->getParameter('PAR'));
        $PAR = unserialize($PARAMETRES);
        switch($PAR['formulari']){
        
            //Paràmetres [id = IDReservaEspais]
            //Només es podrà si l'estat actual és ESPERA_ACCEPTACIÓ_CONDICIONS
            case 'Reserva_Espais_Mail_Accepta_Condicions':                    
                    $OR = ReservaespaisPeer::retrieveByPK($PAR['id']);
                    
                    //Fem un login i després acceptem les condicions
                    $OU = UsuarisPeer::retrieveByPK($OR->getUsuarisUsuariid());
                    $this->makeLogin($OU->getDNI(),$OU->getPasswd());
                    
                    if($OR instanceof Reservaespais && $OR->setAcceptada()):
                        myUser::addLogTimeline( 'acceptada' , 'Reserva (Hospici)' , $this->IDU , $OR->getSiteId() , $OR->getReservaespaiid() );
                        $this->redirect('@hospici_llista_reserves?estat=RESERVA_ACCEPTADA');                        
                    else:
                        $this->redirect('@hospici_llista_reserves?estat=ERROR_TECNIC');                        
                    endif;                                          
                                       
                    UsuarisPeer::addSite( $OR->getUsuarisUsuariid() , $OR->getSiteid() );    
                break;
                
            //Des del mail la persona no accepta i rebutja les condicions. 
            case 'Reserva_Espais_Mail_Rebutja_Condicions':                    
                    $OR = ReservaespaisPeer::retrieveByPK($PAR['id']);

                    //Fem un login i després acceptem les condicions
                    $OU = UsuarisPeer::retrieveByPK($OR->getUsuarisUsuariid());
                    $this->makeLogin($OU->getDNI(),$OU->getPasswd());
                                        
                    if($OR instanceof Reservaespais && $OR->setRebutjada()):        
                        myUser::addLogTimeline( 'no_acceptada' , 'Reserva (Hospici)' , $this->IDU , $OR->getSiteId() , $OR->getReservaespaiid() );
                        $this->redirect('@hospici_llista_reserves?estat=RESERVA_ANULADA');                        
                    else:
                        $this->redirect('@hospici_llista_reserves?estat=ERROR_TECNIC');                        
                    endif;
                    
                    UsuarisPeer::addSite( $OR->getUsuarisUsuariid() , $OR->getSiteid() );
                break;
            default:
            break;
        }    
   }

  /**
   * RSS que mostra les activitats que vindran en 7 dies.  
   * 
   * */ 
  public function executeRSS( sfWebRequest $request ){
    
      require_once '../lib/vendor/rss/FeedWriter.php';
      require_once '../lib/vendor/rss/FeedItem.php';
            
      $IDS = $request->getParameter( 'IDS' , 0 );      
      $OS = SitesPeer::retrieveByPK($IDS);
      if($OS instanceof Sites):
            
          $Feed = new FeedWriter(ATOM);
                
          $Feed->setTitle( 'Canal RSS del site: ' . $OS->getNom() );
          $Feed->setLink( $OS->getWeburl() );
          $Feed->setDescription( 'En aquest canal veurà les activitats a 7 dies vista del site: ' . $OS->getNom() );       
                      
          $temps = strtotime( '+7 day' , time() );      
          $data = date( 'Y-m-d', $temps );      
          
          $LACT = ActivitatsPeer::getActivitatsDia( $IDS , $data , 1 , "activitats" );
          
          foreach($LACT->getResults() as $OA):
          
              
              $newItem = $Feed->createNewItem();
              
              //Mirem que sigui el primer horari... si ho és el mostrem...
              if( $OA->getPrimeraData() == $data ):
                                                                                       
                  $newItem->setTitle(  html_entity_decode( $OA->getTmig() ) );
                  if($IDS == 1) $newItem->setLink( 'http://www.casadecultura.org/activitats/0/'.$OA->getActivitatid().'/'.$OA->getNomForUrl() );
                  else $newItem->setLink( 'http://www.hospici.cat/detall_activitat/'.$OA->getActivitatid().'/'.$OA->getNomForUrl() );                    
                  $newItem->setDate( time() );
                  
                  //Regstrem els horaris que s'usaran                                        
                  $PH = $OA->getPrimerHorari(); $UH = $OA->getUltimHorari();
                  $horaris = "Del dia ".$PH->getDia('d/m').' al '.$UH->getDia('d/m'); 
                  if( $PH->getDia() == $UH->getDia() ) $horaris = "El dia ".$PH->getDia('d/m');
                  $A_E = $PH->getArrayEspais(); $horaris .= ' a '.$A_E[0];
                  
                  $image = '<p>
                                <img class="center" src="http://www.hospici.cat/images/activitats/A-'.$OA->getActivitatid().'-L.jpg"  alt="Imatge"/>
                                <br /><b>'.$horaris.'</b>
                            </p>';
                                                                           
                  $D = $image . $OA->getDmig();
                            
                  $newItem->setDescription( $D );
                                      
                  //Now add the feed item
                  $Feed->addItem($newItem);
                      
              endif;
              
          endforeach;            
          
          $Feed->genarateFeed();
          
      endif;
            
      return sfView::NONE;
  }

  /**
   * RSS que mostra les activitats que vindran en 7 dies.  
   * 
   * */ 
  public function executeGetActXML( sfWebRequest $request ){
                
      //Entrem el SiteID del que volem recuperar l'xml i el carreguem. 
      $IDS = $request->getParameter( 'IDS' , 0 );            
      $OS = SitesPeer::retrieveByPK($IDS);
      
      //Si existeix el site que demanem, seguim. 
      if($OS instanceof Sites):
            
        $this->setLayout(null);
        $this->setTemplate(null);
        $LOH = ActivitatsPeer::getActivitatsProperes( $IDS , date('Y-m-d',time()), 1 , 'horari' , 50 , true );        
        
        //Creem l'objecte XML                                                                                                                                                                                                                                                
        $i = 1;          
        $document = "<document>";                    
        foreach($LOH as $OH):
                                                        
            $OA = $OH->getActivitats();
            $LE = $OH->getArrayEspais();            
                                                                                                                        
            $document .= "<caixa>";
            $document .= "  <id_activitat>".$OA->getActivitatid()."</id_activitat>";
            $document .= "  <data_inicial>".$OH->getDia('Y-m-d')."</data_inicial>";
            $document .= "  <data_fi>".$OH->getDia('Y-m-d')."</data_fi>";
            $document .= "  <tipus_activitat>".$OA->getNomTipusActivitat()."</tipus_activitat>";
            $document .= "  <cicle>".$OA->getCicles()->getTmig()."</cicle>";
            $document .= "  <tipologia>".$OA->getCategories()."</tipologia>";
            $document .= "  <importancia>".$OA->getImportancia()."</importancia>";                        
            $document .= "  <titol>".$OA->getTmig()."</titol>";
            $document .= "  <text>".htmlspecialchars($OA->getDmig())."</text>";
            $document .= "  <url>".$this->getController()->genUrl('http://www.hospici.cat/detall_activitat/'.$OA->getActivitatid().'/'.$OA->getNomForUrl() , true )."</url>";
            $document .= "  <hora_inici>".$OH->getHorainici("H.i")."</hora_inici>";
            $document .= "  <hora_fi>".$OH->getHorafi("H.i")."</hora_fi>";
            $document .= "  <espais>".implode(",",$LE)."</espais>";
            $document .= "  <organitzador>".htmlspecialchars( $OA->getOrganitzador() )."</organitzador>";
            $document .= "  <info_practica>".htmlspecialchars( $OA->getInfopractica() )."</info_practica>";
            $document .= "  <poblacio>".$OS->getPobleString()."</poblacio>";
            $document .= "  <url_img_s>http://www.hospici.cat/images/activitats/A-".$OA->getActivitatid()."-M.jpg</url_img_s>";
            $document .= "  <url_img_m>http://www.hospici.cat/images/activitats/A-".$OA->getActivitatid()."-L.jpg</url_img_m>";
            $document .= "  <url_img_l>http://www.hospici.cat/images/activitats/A-".$OA->getActivitatid()."-XL.jpg</url_img_l>";                                                
            $document .= "</caixa>";                                                                                                
                                                                                                                                   
        endforeach;
            
        $document .= "</document>";
 		        
        $response = sfContext::getInstance()->getResponse();	    
        $response->setHttpHeader('Content-type','text/xml');        
        $response->setContent($document);
        $response->sendHttpHeaders();
                            
      endif;
            
      return sfView::NONE;
  }


}