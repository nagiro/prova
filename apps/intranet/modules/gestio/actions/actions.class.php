<?php

/**
 * 
 * Gestio actions.
 *
 * @package    intranet
 * @subpackage gestio
 * @author     Albert Johé i Martí
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class gestioActions extends sfActions
{
    
  public function executeURemember(sfWebRequest $request)
  {

    $this->setLayout('gestio');
    $this->ENVIAT = false;
    $this->IDS = $this->getUser()->getSessionPar('idS');                                                            
                                                                           
    $RP = $request->getParameter('remember');
    $this->FREMEMBER = new RememberForm();
    $this->ERROR = "";   	 	    

    if($request->hasParameter('BREMEMBER')):
        $this->FREMEMBER->bind($RP);         
        $OUsuari = UsuarisPeer::cercaDNI($this->FREMEMBER->getValue('DNI'));
        if($OUsuari instanceof Usuaris && $this->FREMEMBER->isValid()):
  	        $BODY = OptionsPeer::getString('MAIL_REMEMBER',$this->IDS);
            $BODY = str_replace('{{PASSWORD}}',$OUsuari->getPasswd(),$BODY);                        
            $this->ENVIAT = $this->sendMail(OptionsPeer::getString('MAIL_FROM',$this->IDS),'informatica@casadecultura.org', '[Hospici :: RECORDATORI]',$BODY);
            $this->ENVIAT = $this->sendMail(OptionsPeer::getString('MAIL_FROM',$this->IDS),$OUsuari->getEmail(),' Hospici :: Recordatori de contrasenya ',$BODY);
            if(!$this->ENVIAT['OK']):
                $this->ERROR = "Hi ha hagut algun problema enviant la contrassenya.<br /> Si us plau, torni-ho a provar més tard.";
                $this->ENVIAT = false; 			        			            
            endif;                   
        elseif($this->FREMEMBER->isValid()):        		
            $this->ERROR = "El DNI no existeix o suma incorrecte.";
            $this->ENVIAT = false; 			        			
        else:        		         
        	$this->ERROR = "";
        	$this->ENVIAT = false;        			 								 		 			
        endif;        					 		         	                                 
    endif; 
                            
  }
  

  public function executeUGestio(sfWebRequest $request)
  {

    $this->setLayout('gestio');
    $this->accio = $request->getParameter('accio','C');
    $this->IDU = $this->getUser()->getSessionPar('idU');
    $this->IDS = $this->getUser()->getSessionPar('idS');
    $this->DEFAULT = false;
    $this->MISSATGE = ""; 
    $this->ERROR = "";
    
    
    //Consultem tota la info de l'usuari.
    $this->FDADES      = UsuarisPeer::initialize($this->IDU,$this->IDS,false,true);    
    $this->LRESERVES   = ReservaespaisPeer::getReservesUsuaris( $this->IDU , $this->IDS );    
    $this->LMATRICULES = MatriculesPeer::getMatriculesUsuari( $this->IDU , $this->IDS );    
    $this->LENTITATS   = new SitesSelectForm(null,array('idU'=>$this->IDU));
    
    //Agafem el codi de facebook de l'usuari
    $this->FBI = UsuarisPeer::getUserFbCode($this->getUser()->getSessionPar('idU'));    
    $this->PARS = array();    
    $this->PARS = myUser::f_FbAuth(false,$this->getController()->genUrl('@fb_user_link',true)); //Carreguem les dades del facebook.                    
            
    if($request->hasParameter('BGESTIONAUSUARI')) $this->accio = 'GESTIONA_USUARI';
    if($request->hasParameter('BGUARDAUSUARI')) $this->accio = 'GUARDA_USUARI';
    if($request->hasParameter('BMATRICULA')) $this->accio = 'MATRICULA';
    if($request->hasParameter('BGESTIONAMATRICULES')) $this->accio = 'GESTIONA_MATRICULES';
    if($request->hasParameter('BGESTIONARESERVES')) $this->accio = 'GESTIONA_RESERVES';
    if($request->hasParameter('BGUARDARESERVA')) $this->accio = 'GUARDA_RESERVA';
    if($request->hasParameter('BACCEPTACONDICIONSRESERVA')) $this->accio = 'ACCEPTA_CONDICIONS_RESERVA';
    if($request->hasParameter('BANULACONDICIONSRESERVA')) $this->accio = 'ANULA_CONDICIONS_RESERVA';
    if($request->hasParameter('BGUARDACANVIENTITAT')) $this->accio = 'GUARDA_CANVI_ENTITAT';
            
    switch($this->accio)
    {
        case 'GESTIONA_USUARI':
                $this->FUSUARI = UsuarisPeer::initialize($this->IDU,$this->IDS,false,true);
            break;
        case 'GUARDA_USUARI':
                $RP = $request->getParameter('usuaris');
                $this->FUSUARI = UsuarisPeer::initialize($RP['UsuariID'],$RP['site_id'],false,true);
                $this->FUSUARI->bind($RP);
                if($this->FUSUARI->isValid()):                    
                    $this->getUser()->addLogAction($this->accio,'uGestio',$this->FUSUARI->getObject(),$RS);
                    $this->FUSUARI->save();
                    $OU = $this->FUSUARI->getObject();
                    UsuarisPeer::addSite( $this->IDU , $this->IDS );                                                            
                    $this->MISSATGE = array('Usuari guardat correctament.');
                else: 
                    $this->MISSATGE = array('Hi ha algun error al formulari.<br />Revisa els camps, si us plau.');                    
                endif;
            break;
            
        //Pas 1: Mostrem els cursos als que es pot matricular
        case 'GESTIONA_MATRICULES':
                $this->getUser()->addLogAction($this->accio,'uGestio');
                $this->LCURSOS = CursosPeer::getCursos(CursosPeer::CURSACTIU,1,"",$this->IDS);
                //Retorna la data d'inici de matrícula segons si és antic alumne o no. '
                $this->DATA_INICI = UsuarisPeer::initialize($this->IDU,$this->IDS,false,false)->getObject()->getDataIniciMatricula();
            break;
            
        //Pas 2: Hem escollit un curs i passem la validació a TPV
        case 'MATRICULA':
        
            //Agafem el curs que s'ha seleccionat
            $D = $request->getParameter('D');    
            
            //Si no s'ha seleccionat cap curs, tornem a la mateixa pàgina de GESTIONA_MATRICULES            
            if(!isset($D['CURS']) || empty($D['CURS'])) $this->redirect('gestio/uGestio?accio=GESTIONA_MATRICULES');
            
            //Passem els paràmetres a variables
            $idC = $D['CURS'];
            $idDescompte = $D['DESCOMPTE'];                                            
                                               
            //Carreguem les dades de l'usuari que està fent la matrícula  
            $USUARI = UsuarisPeer::retrieveByPK($this->getUser()->getSessionPar('idU'));
            
            //Carreguem els dades de la matrícula per guardar-la abans del pagament
            $this->DADES_MATRICULA = array();
            $this->DADES_MATRICULA['DNI'] = $USUARI->getDni();
            $this->DADES_MATRICULA['NOM'] = $USUARI->getNomComplet();
            $this->DADES_MATRICULA['IDU'] = $USUARI->getUsuariid();
            $this->DADES_MATRICULA['MODALITAT'] = MatriculesPeer::PAGAMENT_TARGETA;
            $this->DADES_MATRICULA['DESCOMPTE'] = $idDescompte;
            $this->DADES_MATRICULA['DATA'] = date('Y-m-d H:i',time());
            $this->DADES_MATRICULA['COMENTARI'] = "MATRÍCULA INTERNET";
            //Apliquem els descomptes i gratuït si ja està el grup ple
            $this->DADES_MATRICULA['PREU'] = CursosPeer::CalculaPreu( $idC , $idDescompte , $this->IDS );
            $this->DADES_MATRICULA['CURS'] = $idC;
            $this->ISPLE = CursosPeer::isPle( $idC , $this->IDS );
                          
            //Retorna id de matrícula
            $matricules = $this->guardaMatricula($this->DADES_MATRICULA,0,$this->IDS);
            
            //Si l'usuari no està vinculat, el vinculem amb el centre 
            UsuarisPeer::addSite( $this->IDU , $this->IDS ); 
              
            //Carreguem el TPV
            $this->TPV = MatriculesPeer::getTPV($this->DADES_MATRICULA['PREU'] , $this->DADES_MATRICULA['NOM'] , $matricules , $this->IDS );        
            break;

        //Pas 3: Acabem la matrícula i guardem els canvis
        case 'FI_MATRICULA':
                //Hem vinculat l'usuari al pas anterior quan guardem la matrícula
                $this->MISS = "";
                $this->TITOL = "Matrícules";
                if($request->hasParameter('OK')):
                    $this->MISS = "Matrícula realitzada correctament.";                    
                else:
                    $this->MISS = "Hi ha hagut algun problema realitzant la matrícula. <br />Si us plau posi's en contacte amb informatica@casadecultura.org o bé trucant al telèfon 972.20.20.13.";
                endif;                
            break;
        
        case 'GESTIONA_RESERVES':                
                $this->IDR = $request->getParameter('idR',0);
                $this->FRESERVA = ReservaespaisPeer::initialize( $this->IDR , $this->IDS , $this->IDU , true );                
            break;
            
        case 'GUARDA_RESERVA':

    	   		$PR = $request->getParameter('reservaespais');                                
                $this->FRESERVA = ReservaespaisPeer::initialize( $PR['ReservaEspaiID'] , $this->IDS , $this->IDU , true );                
    			$this->FRESERVA->bind($PR);                				                
                if($this->FRESERVA->isValid()):                                             
    				$this->FRESERVA->save();                							
                    $OO = $this->FRESERVA->getObject();                    
                    $FROM = OptionsPeer::getString('MAIL_FROM',$this->IDS);
                    $SEC  = OptionsPeer::getString('MAIL_SECRETARIA',$this->IDS);
                    $this->sendMail($FROM ,'informatica@casadecultura.org','HOSPICI :: NOVA RESERVA ESPAI',ReservaespaisPeer::sendMailNovaReserva($OO),array()); 
                    $this->sendMail($FROM , $SEC,'HOSPICI :: NOVA RESERVA ESPAI',ReservaespaisPeer::sendMailNovaReserva($OO),array());                      			                	                
                    $this->MISSATGE = array(1);				
    			else:
//                    $this->sendMail($FROM , 'informatica@casadecultura.org','HOSPICI :: ERROR AL FORMULARI RESERVA D\'ESPAIS',print_r($this->FRESERVA));
                    $this->MISSATGE = array('Hi ha hagut algun problema enviant la sol·licitud.');
    			endif;			
                
                //Vinculem l'usuari que ha intentat fer una reserva
                UsuarisPeer::addSite( $this->IDU , $this->IDS );
                                    
            break;

        case 'GESTIONA_CANVI_ENTITAT':
                $this->FENTITATS = new SitesSelectForm(null,array('idU'=>$this->IDU));                
            break;
            
        case 'GUARDA_CANVI_ENTITAT':
        
    	   		$PR = $request->getParameter('sites');
                if($PR['site_id_my'] > 0):
                    $this->getUser()->setSessionPar('idS',$PR['site_id_my']);
                    $this->redirect('gestio/uGestio?accio=');
                elseif($PR['site_id'] > 0):
                    $this->getUser()->setSessionPar('idS',$PR['site_id']);
                    $this->redirect('gestio/uGestio?accio=');
                endif;                                 
                                                    
            break;
            
        case 'ACCEPTA_CONDICIONS_RESERVA':
            $PR = $request->getParameter('reservaespais');
            $OR = ReservaespaisPeer::initialize( $PR['ReservaEspaiID'] , $this->IDS , $this->IDU , true )->getObject();
                        
            $PARA  = Encript::Encripta(serialize(array(  'formulari' => 'Reserva_Espais_Mail_Accepta_Condicions', 
                                                         'id' => $OR->getReservaespaiid())));            
            $this->redirect('gestio/uFormularis?PAR='.$PARA);                                                                   
            break;
            
        case 'ANULA_CONDICIONS_RESERVA':
            $PR = $request->getParameter('reservaespais');
            $OR = ReservaespaisPeer::initialize( $PR['ReservaEspaiID'] , $this->IDS , $this->IDU , true )->getObject();
            $PARR  = Encript::Encripta(serialize(array(  'formulari' => 'Reserva_Espais_Mail_Rebutja_Condicions', 
                                                         'id' => $OR->getReservaespaiid())));
            $this->redirect('gestio/uFormularis?PAR='.$PARR);
            break;

        //Vincula l'usuari del facebook            
        case 'FB_LINK':
                $idU = $this->getUser()->getSessionPar('idU');
                $OU = UsuarisPeer::retrieveByPK($idU);
                                                
                $FB_ID = $this->PARS['user']['id'];
                
                //Mirem si el número de facebook està associat a un altre usuari. Si és així, no fem res però emetem error.                 
                $OUF = UsuarisPeer::getUserFromFacebook($FB_ID);
                if($OUF instanceof Usuaris){ $this->ERROR = 'El compte de facebook actual està vinculat a un altre usuari. <br />Si us plau comuniqui-ho a informatica@casadecultura.org o bé entri al seu usuari de facebook i torni-ho a provar.';  }
                elseif($OU instanceof Usuaris){ 
                    $OU->setFacebookid($this->PARS['user']['id']); 
                    $OU->save(); 
                }                
                $this->FBI = UsuarisPeer::getUserFbCode($this->getUser()->getSessionPar('idU'));
                $this->DEFAULT = true;
            break;
            
        //Desvincula l'usuari del facebook
        case 'FB_UNLINK':
                $idU = $this->getUser()->getSessionPar('idU');
                $OU = UsuarisPeer::retrieveByPK($idU);                                                
                $OU->setFacebookid(NULL);
                $OU->save();            
                $this->FBI = UsuarisPeer::getUserFbCode($this->getUser()->getSessionPar('idU'));
                $this->DEFAULT = true;    
            break;

            
        default:
            $this->DEFAULT = true;
    }        
                            
  }

  private function guardaMatricula( $DADES_MATRICULA , $IDMATRICULA = 0 , $idS )
  {
  	
     //Quan guardem la matrícula mirem
     // Si el curs és ple, guardem Estat "En llista d'espera"
     // Si queden places, guardem en procès i quan hagi pagat se li guardarà.  
     
     $M = MatriculesPeer::initialize($IDMATRICULA,$idS,false)->getObject();
    
     //Si el curs és ple el posem en espera, altrament en procés                            
     if(CursosPeer::isPle($DADES_MATRICULA['CURS'],$this->IDS)):
		$M->setEstat(MatriculesPeer::EN_ESPERA);
	 else:  
     	$M->setEstat(MatriculesPeer::EN_PROCES);
     endif;
     
     $M->setUsuarisUsuariid($DADES_MATRICULA['IDU']);
     $M->setComentari($DADES_MATRICULA['COMENTARI']);
     $M->setDatainscripcio($DADES_MATRICULA['DATA']);     
     $M->setTreduccio($DADES_MATRICULA['DESCOMPTE']);
     $M->setTpagament($DADES_MATRICULA['MODALITAT']);
     $M->setCursosIdcursos($DADES_MATRICULA['CURS']);
     $M->setPagat($DADES_MATRICULA['PREU']);
     $M->setSiteid($idS);     
     $M->save();
     
     return $M->getIdmatricules();
     
  }

  
/**
 * Executem el login del modul administrador
 **/

  public function executeULogin(sfWebRequest $request)
  {        
     
     $this->setLayout('gestio');
     $this->accio = $request->getParameter('accio','');
     $this->IDS = $this->getUser()->ParReqSesForm($request,'idS',1);     //Per defecte entro al IDS = 1 que és la Casa de Cultura de Girona.               
     $this->FLogin = new LoginForm(array('site'=>$this->IDS,'nick'=>"",'password'=>''));      
     $this->ERROR = "";  
     $this->FB = myUser::f_FbAuth(false,$this->getController()->genUrl('@fb_login',true)); //Retorna l'usuari que s'ha autentificat amb facebook
                              
     if($request->hasParameter('BLOGIN')) $this->accio = "LOGIN";
     if($request->hasParameter('BNEWUSER')) $this->accio = "NEW_USER";
     if($request->hasParameter('BSAVENEWUSER')) $this->accio = "SAVE_NEW_USER";
     if($request->hasParameter('BREMEMBER')) $this->accio = "REMEMBER";     

     switch($this->accio){
        
        case 'LOGOUT':                                
                $this->getUser()->setSessionPar('idU',0);
                $this->getUser()->setSessionPar('idS',0);
                $this->getUser()->setSessionPar('idN',NivellsPeer::CAP);
                $this->getUser()->setAuthenticated(false);
                $this->getUser()->clearCredentials();                 
                $this->redirect('gestio/uLogin');
            break;
        
        //Fem un login via facebook
        case 'FB_LOGIN':
                $FB = myUser::f_FbAuth(false);
                $USUARI = UsuarisPeer::getUserFromFacebook($FB['user']['id']);
                if($USUARI instanceof Usuaris):        
                    $this->getUser()->setSessionPar( 'idS' , $this->IDS );                    
                    $this->makeLogin($USUARI, $this->IDS);                    
                else: 
                    $this->getUser()->addLogAction('error','fb_login',$FB);     		 
                    $this->ERROR = "No s'ha trobat cap usuari vinculat amb el seu compte de facebook.<br />Per vincular-lo ha d'accedir i fer-ho des del seu administrador o bé crear un compte nou.";                                         
                endif;
            break;
        
        //Fem un LOGIN
        case 'LOGIN':           
            $L = $request->getParameter('login');             
            $this->FLogin->bind($L);
 	        if($this->FLogin->isValid()):
                //Consultem l'usuari. Només miraré els permisos si és un "administrador" 
                $USUARI = UsuarisPeer::getUserLogin($L['nick'], $L['password'],null);                     		 
       		    if($USUARI instanceof Usuaris):                                    
                    $this->IDS = $L['site'];
                    if(is_numeric($this->IDS)):
                        $_SESSION[$USUARI->getNomComplet()] = $USUARI->getNomComplet();
                        $this->getUser()->setSessionPar( 'idS' , $this->IDS );                                        
                        $this->makeLogin( $USUARI , $this->IDS );                                                                    
                    else:
                        $this->getUser()->addLogAction('error','login',$L);     		 
                        $this->ERROR = "Hi ha hagut algun problema amb el SITE.<br />Contacti amb la Casa de Cultura si us plau.";                                                
                    endif;                                          
                else:
                    $this->getUser()->addLogAction('error','login',$L);     		 
                 	$this->ERROR = "L'usuari o la contrasenya són incorrectes";
                endif;                                                                                
            else: 
                $this->getUser()->addLogAction('error','login',$L);     		 
                $this->ERROR = "El DNI o la contrasenya són incorrectes";                      		 	                 		 	                     		 	                 	     		 	                 	                 		 		 
            endif;
                                                                        
            break;
            
        //Creem un nou usuari
        case 'NEW_USER':  
                      
                $this->FUSUARI = UsuarisPeer::initialize(0,$this->IDS,false,true);
                                                
            break;
        
        case 'SAVE_NEW_USER':   
            
                $PR = $request->getParameter('usuaris');                
                $this->FUSUARI = UsuarisPeer::initialize(0,$this->IDS,false,true);                							
    			$this->FUSUARI->bind($PR);				
                if($this->FUSUARI->isValid()):                            
                                     
    				$this->FUSUARI->save();
                    $OU = $this->FUSUARI->getObject();                                                            
                    UsuarisPeer::addSite( $OU->getUsuariId() , $this->IDS );                                        
                    $this->makeLogin($OU,$this->IDS);
                                                                                                      			                	                                    				
    			else:
                
                    $this->MISSATGE = array('Hi ha hagut algun problema enviant la sol·licitud.');
                    
    			endif;			       
            
            break;
            
        //Si fem um remember de contrassenya
        case 'REMEMBER':
                $this->redirect('gestio/uRemember');            
            break;
        
        default:
            if($this->getUser()->isAuthenticated() && $this->getUser()->getSessionPar('idU') > 0):                
                $USUARI = UsuarisPeer::retrieveByPK($this->getUser()->getSessionPar('idU'));
                $this->makeLogin( $USUARI , $this->IDS );
            endif;
        
     }
		   
  }  

  private function makeLogin( $USUARI , $IDS )
  {
      //Consulto el nivell que té l'usuari pel site. Si té nivell == 2 o no té nivell, és usuari normal. 
      //Si té nivell 1 serà administrador.
      $this->getUser()->addLogAction('login','login',null);
      $idN = $USUARI->getSiteNivell($IDS);
      
      //si el nivell és d'administrador, entrem a la intranet i guardem les dades de l'usuari.                                      
      if( $idN == NivellsPeer::ADMIN ):        
 	    $this->getUser()->setSessionPar('idU',$USUARI->getUsuariid());
        $this->getUser()->setSessionPar('idN',$idN);
        $this->getUser()->setAuthenticated(true);
        $this->getUser()->setSessionPar('idS',$IDS);
        $this->getUser()->addCredential('admin');        
        $this->redirect( '@gAdmin' );
        
      //Sempre que s'entri com un usuari, es redirigeix cap a l'hospici.
      elseif( $idN == NivellsPeer::REGISTRAT ):
        //$this->getUser()->addCredential('user');
        $s = Encript::Encripta( serialize( array( 'login'=>$USUARI->getDni() , 'pass'=>$USUARI->getPasswd() ) ) );
        $this->redirect('http://www.hospici.cat/login?id='.$s);        
        //$this->redirect( '@gUser' );
      else:   	 	
     	$this->ERROR = "El DNI o la contrasenya són incorrectes";
      endif;
    
  }




/**
 * Executem l'opció de canviar de site si en tenim més d'un. 
 **/

  public function executeGChangeSite(sfWebRequest $request)
  {     
    
    $this->setLayout('gestio');
     //Carreguem els sites que té l'usuari 
     $this->SITES = UsuarisSitesPeer::getSitesArray($this->getUser()->getSessionPar('idU'));
     $this->IDS   = $this->getUser()->getSessionPar('idS');
     $this->IDU   = $this->getUser()->getSessionPar('idU');
        
     if($request->hasParameter('BSAVE')):
           $this->IDS = $request->getParameter('IDS');
           $this->getUser()->setSessionPar('idS',$this->IDS);           
           $OU = UsuarisPeer::initialize($this->IDU,$this->IDS,false,false)->getObject();
           $this->makeLogin( $OU , $this->IDS );                                             
     endif;  
                    
  }

		
  /**
   * Executes index action
   */
  public function executeIndex()
  {    
    //Mirem si l'usuari és de la CCG o no      
      //Si és de la CCG hem de mostrar la gestió completa
    //altrament
      //Si és un usuari normal només ha de poder veure lo seu      
  }
  
  /**
   * Primera crida de l'aplicatiu per a registrats   
   */        
  public function executeMain(sfWebRequest $request)
  { 
  	                               	  	                                                   
  	
    $this->getUser()->addLogAction('inside','Main');
  	
    $this->setLayout('gestio');
    $this->IDS = $this->getUser()->getSessionPar('idS');
    
    $idU = $this->getUser()->getSessionPar('idU');    
        
    //Carreguem els missatges d'avui    
    $this->MISSATGES = MissatgesPeer::getMissatgesAvui( $this->getUser()->getSessionPar('idS') );
        
    $this->FEINES = PersonalPeer::getFeines( $idU , time() , $this->IDS );
    $this->NOTIFICACIONS = PersonalPeer::getNotificacions( $idU , time() , $this->IDS );
    $this->INCIDENCIES = IncidenciesPeer::getIncidenciesUsuari($idU , $this->IDS);
    
    //Carreguem les activitats d'avui :D
    $this->ACTIVITATS = HorarisPeer::getActivitats(time() , null , null , null , null, $this->IDS );
    $this->ACTIVITATS = $this->ACTIVITATS['ACTIVITATS'];
    $this->IDU = $idU;
    
    $PAR = $request->getParameter('accio',"");
    if($PAR == 'NETEJA_LLISTAT'):
        myUser::setEmptyTimeline($this->IDU);
        return $this->renderText();
    endif;        
    
   
  }
  
  /**
   * Aquesta funció és cridada per ajax des de la intranet
   * @param 
   * */
  public function executeAjaxDifusio(sfWebRequest $request){
    
        parse_str($request->getParameter('FORMULARI') , $RP );
        if( array_key_exists( 'calendars' , $RP ) ) $this->redirect('gestio/ConnectaGoogleCalendars?idA='.$RP['idA']);
        if( array_key_exists( 'facebook' , $RP ) ) return $this->renderText('El facebook encara no es pot utilitzar.');
        if( array_key_exists( 'twitter' , $RP ) ) return $this->renderText('El twitter encara no es pot utilitzar.');                                 
        if( array_key_exists( 'ddg' , $RP ) ) return $this->renderText('El Diari de Girona encara no es pot utilitzar.');
        if( array_key_exists( 'elpunt' , $RP ) ) return $this->renderText('El Punt - Avui encara no es pot utilitzar.');
        if( array_key_exists( 'ara' , $RP ) ) return $this->renderText('El diari Ara encara no es pot utilitzar.');
        if( array_key_exists( 'giroque' , $RP ) ) return $this->renderText('El web Giroquè encara no es pot utilitzar.');
        if( array_key_exists( 'femxarxa' , $RP ) ) return $this->renderText('El web Fem Xarxa encara no es pot utilitzar.');
        if( array_key_exists( 'forfree' , $RP ) ) return $this->renderText('El web Forfree encara no es pot utilitzar.');
        if( array_key_exists( 'ddgi' , $RP ) ) return $this->renderText('La Diputació de Girona encara no es pot utilitzar.');
        
                            
  }
  

  /**
   * Envia un mail de difusió on toqui. 
   * 
   * */ 
  public function SendMailDifusio(){
    
  }
  
  /**
   * Aquesta funció fa la crida a google i espera la resposta. 
   * 
   * */ 
  public function executeConnectaGoogleCalendars(sfWebRequest $request){                                           
              
    //Guardem IDS per si l'hem d'usar a la funció
    $IDS = $this->getUser()->getSessionPar('idS');
    
    //Si entra una IDA la guardem a la variable de sessió.
    if($request->hasParameter('idA')) $this->getUser()->setSessionPar('google_ida',$request->getParameter('idA'));

    //Si ha entrat el procés de validació, agafem el codi i el guardem. Altrament, carreguem el que tenim guardat ( dura 3600 s ) 
    if( $request->hasParameter('code') ):        
        $authCode = $request->getParameter('code');        
        $C = new Connectivitat( $this->getUser()->getSessionPar('idS') );
        $C->setCodeAuth( $request->getParameter('code') );            
        $this->getUser()->setSessionPar( 'google_auth_code' , $C->getAuthCode() );
    else:                     
        $C = new Connectivitat( $IDS );                                
        $C->setAuthCode( $this->getUser()->getSessionPar('google_auth_code', null ) );                        
    endif;                    
    
    //Si estem connectats i estic afegint una activitat, ho faig.
    if( $request->hasParameter('idA') ):           
                                
        $OA = ActivitatsPeer::retrieveByPK( $request->getParameter('idA') );
        
        foreach( $OA->getHorarisActius( $IDS ) as $OH ):
        
            $OS = SitesPeer::retrieveByPK( $IDS );
            
            $C->AddActivitat(   $OA->getActivitatid() , 
                                mktime( $OH->getHorainici('H') , $OH->getHorainici('i') , $OH->getHorainici('s') , $OH->getDia('m') , $OH->getDia('d') , $OH->getDia('Y') ) , 
                                mktime( $OH->getHorafi('H') , $OH->getHorafi('i') , $OH->getHorafi('s') , $OH->getDia('m') , $OH->getDia('d') , $OH->getDia('Y') ) ,
                                $OS->getNom() , 
                                $OS->getEmailString() ,
                                $OA->getTmig() ,
                                'http://www.hospici.cat/detall_activitat/'.$OA->getActivitatid().'/'.$OA->getNomForUrl() ,
                                implode( ',' , $OH->getArrayEspais() ) ,
                                $OA->getTmig() ,
                                $OA->getDMig() ,                                                                 
                                OptionsPeer::getString( 'google_calendar_id' , $IDS ) , 
                                1 , 
                                $this->getUser()->getSessionPar('idS') );                                                                                              
        endforeach;                
   
   endif;
   
        return $this->renderText("Activitat afegida al Google Calendars");
       
    return sfView::NONE;
    
  }
  
  /**
   * RETORNA CORRECTE SI EL DNI TÉ UN FORMAT CORRECTE.
   **/    
  public function ValidaDNI($DNI,$new = true)
  {
  		$DNI = trim($DNI);
  		$correcte = ereg('((^[A-Z]{1}[0-9]{7}[A-Z0-9]{1}$|^[T]{1}[A-Z0-9]{8}$)|^[0-9]{8}[A-Z]{1}$)',$DNI);
  		
  		if($new):
  			$C = new Criteria();
  			$C->add(UsuarisPeer::DNI, $DNI, CRITERIA::EQUAL);
  			$correcte = (UsuarisPeer::doCount($C)==0); //NomÃ©s serÃ  correcte si no existeix  		
  		endif;

  		return $correcte;
  }
  

  //******************************************************************************************
  // GESTIO DELS USUARIS *********************************************************************
  //******************************************************************************************
  
  public function executeGUsuaris(sfWebRequest $request)
  {    
	  	
    $this->setLayout('gestio');
    $this->IDS = $this->getUser()->getSessionPar('idS');
    $this->IDU = $request->getParameter('id_usuari');

    if($request->getParameter('accio') == 'CC'):
    	$this->getUser()->setSessionPar('cerca',array('text'=>""));
    	$this->getUser()->setSessionPar('PAGINA',1);
    	$this->redirect('gestio/gUsuaris?accio=FC');
    //Apartat afegit per quan es vingui d'un enllaç per crear un nou usuari, com per exemple de matrícules
    elseif($request->getParameter('accio') == 'N'):
        $this->getUser()->setSessionPar('cerca',array('text'=>""));
    	$this->getUser()->setSessionPar('PAGINA',1);
    endif; 
    
    $this->CERCA  = $this->getUser()->ParReqSesForm($request,'cerca',array('text'=>""));                    
    $this->PAGINA = $this->getUser()->ParReqSesForm($request,'PAGINA',1);
    $accio  = $this->getUser()->ParReqSesForm($request,'accio','FC');
    $extra  = "";
            
    //Inicialitzem el formulari de cerca
    $this->FCerca = new CercaForm();            
	$this->FCerca->bind($this->CERCA);
    
	$this->MODE = array('CONSULTA'=>true, 'NOU', 'EDICIO', 'LLISTES', 'CURSOS', 'REGISTRES', 'GESTIO_APLICACIONS');
		
    if($request->hasParameter('BNOU')) 					    { $accio = "N"; }
    if($request->hasParameter('BCERCA')) 				    { $accio = "FC"; $this->PAGINA = 1; }
    if($request->hasParameter('BDESVINCULA')) 			    { $accio = "DL"; }
    if($request->hasParameter('BVINCULA')) 				    { $accio = "VL"; }
    if($request->hasParameter('BSAVE'))     			    { $accio = "S"; }
  	if($request->hasParameter('BDELETE'))     			    { $accio = "D"; }    
    if($request->hasParameter('BACTUALITZA_PERMISOS')) 	    { $accio = "SGA"; }
    if($request->hasParameter('BGUARDA_DADES_BANCARIES'))   { $accio = "CCC"; $extra = 'SAVE'; }
            
    $this->getUser()->setSessionPar('accio',$accio);
    $this->getUser()->setSessionPar('pagina',$this->PAGINA);        
    
    switch($accio){
    
    	//Hem entrat a usuaris
    	case 'CC':
    			$this->getUser()->addLogAction('inside','gUsuaris');
    		break;
    		
    	//Nou usuari 
       case 'N':
             $this->MODE['NOU'] = true;
             $this->FUsuari = UsuarisPeer::initialize( 0 , $this->IDS , false );
             break;
             
       //Edita un usuari
       case 'E':
             $this->MODE['EDICIO'] = true;    
             $this->FUsuari = UsuarisPeer::initialize( $this->IDU , $this->IDS , false );                          
             break;
       
		//Esborra un usuari
        case 'D':
        	$RP = $request->getParameter('usuaris');
            $this->IDU = $RP['UsuariID']; 
            $this->FUsuari = UsuarisPeer::initialize( $this->IDU , $this->IDS , false );
            $this->FUsuari->getObject()->setActiu(false)->save();                    	        	
        	$this->getUser()->addLogAction($accio,'gUsuaris',$this->FUsuari->getObject());
            myUser::addLogTimeline( 'baixa' , 'usuaris' , $this->getUser()->getSessionPar('idU') , $this->IDS , $RP['UsuariID'] );        	        	
        	$this->redirect('gestio/gUsuaris?accio=FC');        	
        	break;
       
       //Mostra les llistes a les que està subscrit un usuari
       case 'L':
             $this->USUARI = UsuarisPeer::initialize($this->IDU , $this->IDS , false)->getObject();              
             $this->LLISTAT_LLISTES = LlistesPeer::getLlistesDisponibles( $this->IDU , $this->IDS );
             $this->MODE['LLISTES'] = true;
             break;
             
       //Mostra els cursos d'un usuari
       case 'C':
             $this->USUARI = UsuarisPeer::initialize($this->IDU , $this->IDS , false)->getObject();
             $this->MATRICULES = $this->USUARI->getMatricules();             
             $this->MODE['CURSOS'] = true;
             break;

       //Mostra les reserves que ha fet
       case 'R':
             $this->USUARI = UsuarisPeer::initialize($this->IDU , $this->IDS , false)->getObject();
             $this->RESERVES = $this->USUARI->getReserves();                                 
             $this->MODE['REGISTRES'] = true;
             break;
       
       //Guarda un usuari 
       case 'S':       
            $RP = $request->getParameter('usuaris');
            $this->IDU = $RP['UsuariID'];                                             
            $this->FUsuari = UsuarisPeer::initialize( $this->IDU , $this->IDS , false , false );                        
            $this->FUsuari->bind($RP);             
		    if($this->FUsuari->isValid())
		    { 		     	
	    	  $this->FUsuari->save();
              $this->getUser()->addLogAction($accio,'gUsuaris',null, $this->FUsuari->getObject());
              myUser::addLogTimeline( 'alta' , 'usuaris' , $this->getUser()->getSessionPar('idU') , $this->IDS , $this->FUsuari->getObject()->getUsuariId() );

              $this->MISSATGE = 'Usuari guardat correctament'; 
		    }                		     
		    $this->MODE['EDICIO'] = true;      		     
            break;
              
       //Desvincula un usuari de la llista de correu      
       case 'DL':   
             $D = $request->getParameter('D');
             foreach($D['IDL'] as $IDL) LlistesPeer::desvincula($this->IDU,$IDL);
             $this->getUser()->addLogAction($accio,'gUsuaris',$D);
             $this->redirect("gestio/gUsuaris?accio=L");                            
             break;
             
       //Vincula un usuari a la llista de correu
       case 'VL':
             $D = $request->getParameter('D');             
             foreach($D['IDL'] as $IDL) LlistesPeer::vincula($this->IDU,$IDL);
             $this->getUser()->addLogAction($accio,'gUsuaris',$D);
             $this->redirect("gestio/gUsuaris?accio=L");                            
             break;
                           
		//Gestió de permisos d'aplicacions pels usuaris
        case 'GA':    
            $this->USUARI = UsuarisPeer::initialize($this->IDU , $this->IDS , false)->getObject();                                                        	        	
        	$this->LLISTAT_PERMISOS = UsuarisAppsPeer::getPermisos( $this->IDU , $this->IDS );        				
        	$this->MODE['GESTIO_APLICACIONS'] = true;
        	break;
        	
        //Guarda la gestió d'aplicacions
        case 'SGA':
        	$PERM = $request->getParameter('PERMIS',array());
        	UsuarisAppsPeer::save($PERM,$this->IDU,$this->IDS);
            $this->USUARI = UsuarisPeer::initialize($this->IDU , $this->IDS , false)->getObject();                    	        	        	
        	$this->LLISTAT_PERMISOS = UsuarisAppsPeer::getPermisos($this->IDU,$this->IDS);
        	$this->getUser()->addLogAction($accio,'gUsuaris',$PERM);        				
        	$this->MODE['GESTIO_APLICACIONS'] = true;
        	break;
            
        //Gestiona les dades bancaries de l'usuari
        case 'CCC':
                        
            $this->USUARI = UsuarisPeer::initialize($this->IDU , $this->IDS , false)->getObject();
            $this->IDD = $request->getParameter('IDD', 0);
            $this->FDB = DadesBancariesPeer::initialize( $this->IDD , $this->IDU , $this->IDS );
            
            //var_dump($this->IDD);
            //die;
            
            if($extra == 'SAVE'):
            
                $this->FDB = DadesBancariesPeer::initialize( $this->IDD , $this->IDU , $this->IDS );                                                                                        
                $this->FDB->bind($request->getParameter('dades_bancaries',array()));                
      		    if($this->FDB->isValid())
      		    { 		     	      		        
                    $this->FDB->save();
                    $this->getUser()->addLogAction($accio.$extra,'gUsuaris',null, $this->FDB->getObject());
                    $this->MISSATGE = 'Dades bancàries guardades correctament.';
                    $this->IDD = $this->FDB->getObject()->getIddada(); 
                }   
                                                        
            endif;                        
                                    
            $this->CCC_USUARI = DadesBancariesPeer::getSelectBySelect(DadesBancariesPeer::getDadesUsuari($this->IDU),true);                                    
            if(!($this->FDB instanceof DadesBancariesForm)) $this->FDB = new DadesBancariesForm();            
            $this->MODE['CCC'] = true;
            
        	break;
            
    }
    
    $this->PAGER_USUARIS = UsuarisPeer::cercaTotsCamps( $this->CERCA['text'] , $this->PAGINA , $this->IDS );
                    
  }  

  //******************************************************************************************
  // GESTIO DE LES PROMOCIONS ****************************************************************
  //******************************************************************************************
  
  public function executeGPromocions(sfWebRequest $request)
  {
  
    $this->setLayout('gestio');
    $this->IDS = $this->getUser()->getSessionPar('idS');
    $this->IDP = $request->getParameter('IDP',0);
        
    $this->ERRORS = array(); $this->EDICIO = false; $this->NOU = false; $this->LLISTES = false; $this->CURSOS = false; $this->PROMOCIONS = array();

    $accio = $request->getParameter('accio','');
    if($request->hasParameter('BSAVE')) $accio = 'S';
    elseif($request->hasParameter('BDELETE')) $accio = 'D';
    
    switch($accio){
        
        case 'N':
            $this->FPromocio = PromocionsPeer::initialize( 0 , $this->IDS );                
            $this->NOU = true;        
            break;
            
        case 'E':            
            $this->FPromocio = PromocionsPeer::initialize( $this->IDP , $this->IDS );
            $this->EDICIO = true;        
            break;
            
        case 'D':
            $RP = $request->getParameter('promocions');
            $this->IDP = $RP['PromocioID'];
            $this->FPromocio = PromocionsPeer::initialize( $this->IDP , $this->IDS );            
            $OP = $this->FPromocio->getObject();
            $OP->setActiu(false);
            $OP->save();                       
            $this->getUser()->addLogAction($accio,'gPromocions',null,$OP);
            break;
            
        case 'S':
            $RP = $request->getParameter('promocions');
            $this->IDP = $RP['PromocioID'];
            $this->FPromocio = PromocionsPeer::initialize( $this->IDP , $this->IDS );                        
            $this->FPromocio->bind($RP,$request->getFiles('promocions'));              
            if($this->FPromocio->isValid()) {                  
                $this->getUser()->addLogAction('save','gPromocions',null,$this->FPromocio->getObject()); 
                $this->FPromocio->save();       
                $this->redirect('gestio/gPromocions?accio=CC');                         
            }                             
            $this->EDICIO = true;              
            break;
        case 'CC':
                $this->getUser()->addLogAction('inside','gPromocions');
            break;    
                                        
    }
    
    $this->PROMOCIONS = PromocionsPeer::getAllPromocions($this->IDS,false);                    
  }
          
  //******************************************************************************************
  // GESTIO DEL WEB **************************************************************************
  //******************************************************************************************
  
  public function executeGEstructura(sfWebRequest $request) 
  {
    $this->setLayout('gestio');
    $this->IDS = $this->getUser()->getSessionPar('idS');    
    
    $this->IDN = $request->getParameter('idN',0);
    
    $this->ERRORS = array(); $this->NOU = false; $this->EDICIO = false; $this->HTML = false;
    
    $accio = $request->getParameter('accio');
    if($request->hasParameter('SaveHTML')) $accio = 'SAVE_HTML';
    elseif($request->hasParameter('BSAVE')) $accio = 'SAVE';
    elseif($request->hasParameter('BDELETE')) $accio = 'D';
    
    
    switch($accio){
        case 'N':
            $this->FNode = NodesPeer::initialize( $this->IDN , $this->IDS );        
            $this->NOU = true;  
            break;
        case 'E':
            $this->FNode = NodesPeer::initialize( $this->IDN , $this->IDS );                              
            $this->EDICIO = true;
            break;
        case 'H':
            $this->FHtml = NodesPeer::initialize( $this->IDN , $this->IDS , true );                                	          			                        				      	                                   
            $this->HTML = true;
            break;
        case 'D':
            $this->FNode = NodesPeer::initialize( $this->IDN , $this->IDS );      
            $this->NODE = $this->FNode->getObject();
            $this->NODE->setActiu(false);
            $this->NODE->save();     
            $this->getUser()->addLogAction('delete','gEstructura',$this->NODE);
            break;
        case 'CC':
            $this->getUser()->addLogAction('inside','gEstructura');        
            break;
        case 'SAVE':
            $RP = $request->getParameter('nodes');
            $this->IDN = $RP['idNodes'];                  
            $this->FNode = NodesPeer::initialize( $this->IDN , $this->IDS );            
            $this->FNode->bind($RP);
            if($this->FNode->isValid()) {  $this->FNode->save(); $this->getUser()->addLogAction('save','gEstructura',null,$this->FNode->getObject()); }             
            $this->EDICIO = false;                     
            break;
        case 'SAVE_HTML':
            $RP = $request->getParameter('editor');
            $this->IDN = $RP['idNodes'];                      
            $this->FHtml = NodesPeer::initialize( $this->IDN , $this->IDS , true );                     
            $this->FHtml->bind($RP);        	              
            if($this->FHtml->isValid()):
                $this->FHtml->save();
                $this->getUser()->addLogAction('saveHTML','gEstructura',$this->FHtml->getObject());
            endif;                                                                             
            $this->HTML = true;                        
            break;       
    }    
        
    $this->NODES = NodesPeer::selectNodesPares($this->IDS, true);
    // $this->NODES = NodesPeer::retornaMenu($this->IDS,true);
    
  }  
      
  //******************************************************************************************
  // GESTIO DE LES LLISTES *******************************************************************
  //******************************************************************************************
  
  public function executeGLlistes(sfWebRequest $request)
  {
    $this->setLayout('gestio');
    $this->IDS = $this->getUser()->getSessionPar('idS');        
    
    $this->CERCA  = $this->getUser()->ParReqSesForm($request,'cerca',array('text'=>''));    	    	    	    
    $this->FCerca = new CercaForm();
    
    //Per si venim d'una cerca uqe no toca.
    if(!is_array($this->CERCA)) $this->CERCA = $this->getUser()->setSessionPar('cerca',array('text'=>''));
    $this->FCerca->bind($this->CERCA);

    $this->IDL = $request->getParameter('IDL',0);      
    $this->IDM = $request->getParameter('IDM',0);  
    $this->PAGINA = $request->getParameter('PAGINA');    
    $this->MODE   = "";
    
    $accio = $request->getParameter('accio');
    //if($request->hasParameter('BSAVE_MISSATGE')) $accio = 'SM';
    if($request->hasParameter('BDELETE_MISSATGE')) $accio = 'DM';
    if($request->hasParameter('BSEGUEIX_LLISTES')) $accio = 'LL';
    
//    if($request->hasParameter('BSAVE_LLISTES')) $accio = 'SL';
    if($request->hasParameter('BSEGUEIX_ENVIAMENT')) $accio = 'SE';    

    if($request->hasParameter('BSEND_PROVA')) $accio = 'SP';
    if($request->hasParameter('BSEND_LLISTES')) $accio = 'SLL';
    
    if($request->hasParameter('BSAVELIST')) $accio = 'SAVELIST';
    
    if($request->hasParameter('BCERCAMAIL')) $accio = 'CERCA_MAIL';
    if($request->hasParameter('BCERCAMAILDNI')) $accio = 'CERCA_MAIL_DNI';
    if($request->hasParameter('BCERCABAIXES')) $accio = 'CERCA_BAIXES';                


    switch($accio){
        
        //Esborrem un missatge
        case 'DM':
                $RM = $request->getParameter('llistes_missatges');
                $OM = LlistesMissatgesPeer::retrieveByPK($RM['idMissatge']);
                if($OM instanceof LlistesMissatges) $OM->setActiu(false)->save();
                $this->redirect('gestio/gLlistes');
            break;
            
        //Edita un missatge
        case 'EM':
                $this->FMissatge = LlistesMissatgesPeer::initialize($this->IDM,$this->IDS);
                $this->MODE = 'EDITA_MISSATGE';
            break;

        //Nou missatge            
        case 'NM':
                $this->FMissatge = LlistesMissatgesPeer::initialize($this->IDM,$this->IDS);
                $this->MODE = 'EDITA_MISSATGE';        
            break;
        
        //Guarda un missatge (Rel amb LL)
//        case 'SM':
//                $this->FMissatge = LlistesMissatgesPeer::initialize($this->IDM,$this->IDS);
//                $RM = $request->getParameter('llistes_missatges');                                          
//                $this->FMissatge = LlistesMissatgesPeer::initialize($RM['idMissatge'],$this->IDS);      	
//                $this->FMissatge->bind($RM);    
//                if($this->FMissatge->isValid()){                
//                    $this->FMissatge->save();
//                    $this->IDM = $this->FMissatge->getObject()->getIdmissatge();
//                    $this->getUser()->addLogAction('SAVE_MISS','gLlistes',null,$this->FMissatge->getObject());
//                    $this->MODE = 'EDITA_MISSATGE';
//                } else { $this->MODE = 'EDITA_MISSATGE'; }                
//            break;
            
        //Guarda un missatge i mostra les llistes (Rel amb SM)
        case 'LL':
                $this->FMissatge = LlistesMissatgesPeer::initialize($this->IDM,$this->IDS);
                $RM = $request->getParameter('llistes_missatges');                                          
                $this->FMissatge = LlistesMissatgesPeer::initialize($RM['idMissatge'],$this->IDS);      	
                $this->FMissatge->bind($RM);    
                if($this->FMissatge->isValid()){                
                    $this->FMissatge->save();
                    $this->IDM = $this->FMissatge->getObject()->getIdmissatge();
                    $this->getUser()->addLogAction('SAVE_MISS','gLlistes',null,$this->FMissatge->getObject());                    
                    $this->MODE = 'ESCULL_LLISTA';                                         
                    $this->LLISTES = LlistesLlistesPeer::getLlistesAll($this->IDS);                    
                    $this->LLISTES_ENV = LlistesLlistesPeer::getLlistesMissatge($this->IDM);                                        
                } else { $this->MODE = 'EDITA_MISSATGE'; }                
            break;
            
        case 'EL':
                $this->IDM = $request->getParameter('idM',0);
                $this->LLISTES = $request->getParameter('llistes',array());
                $this->MODE = 'ESCULL_LLISTA';
                $this->LLISTES = LlistesLlistesPeer::getLlistesAll($this->IDS);                    
                $this->LLISTES_ENV = LlistesLlistesPeer::getLlistesMissatge($this->IDM);                
            break;
            
//        case 'SL':
//                $this->IDM = $request->getParameter('idM',0);
//                $this->LLISTES = $request->getParameter('llistes',array());
//                $this->MODE = 'ESCULL_LLISTA';                                     
//                LlistesLlistesMissatgesPeer::doGuardar($this->IDM, $this->LLISTES);    
//                $this->LLISTES = LlistesLlistesPeer::getLlistesAll($this->IDS);                    
//                $this->LLISTES_ENV = LlistesLlistesPeer::getLlistesMissatge($this->IDM);
//            break;
            
        case 'SE':
                $this->IDM = $request->getParameter('idM',0);
                $this->LLISTES = $request->getParameter('llistes',array());                
                LlistesLlistesMissatgesPeer::doGuardar($this->IDM, $this->LLISTES,$this->IDS);
                $this->MISSATGE = LlistesMissatgesPeer::retrieveByPK($this->IDM);
                $this->LLISTES_ENV = LlistesLlistesPeer::getLlistesMissatge($this->IDM);                
                $this->MODE = 'EDITA_ENVIAMENT';        
            break;

        case 'SP':
                $email = $request->getParameter('email','informatica@casadecultura.org');
                $missatge = $request->getParameter('missatge');
                $llistes = $request->getParameter('llistes');
                $this->MISSATGE = LlistesMissatgesPeer::retrieveByPK($missatge);
                $this->MODE = 'EDITA_ENVIAMENT';            
                $this->LLISTES_ENV = LlistesLlistesPeer::getLlistesMissatge($missatge);
                if($this->MISSATGE instanceof LlistesMissatges) $this->sendMail(OptionsPeer::getString('MAIL_FROM',$this->IDS),$email,$this->MISSATGE->getTitol(), $this->MISSATGE->getText());
                else $this->sendMail(OptionsPeer::getString('MAIL_FROM',$this->IDS),$email,"No s'ha trobat el missatge amb codi ".$missatge,'');                        
            break;
            
        case 'SLL':
                $email = $request->getParameter('email','informatica@casadecultura.org');
                $missatge = $request->getParameter('missatge');
                $llistes = $request->getParameter('llistes');
                $this->MISSATGE = LlistesMissatgesPeer::retrieveByPK($missatge);
                $this->MODE = 'CARREGA_DADES';                          
                $this->EMAILS = LlistesLlistesEmailsPeer::getEmailsFromLlistesAll($llistes);                
                $this->MISSATGE = LlistesMissatgesPeer::retrieveByPK($missatge);                        
    //            try { 
    //                $MAILS = array();
    //                foreach($this->EMAILS as $OM):
    //                    $MAILS[$OM->getIdemail()] = $OM->getEmail();
    //                endforeach;
    //                $this->NUM_MAILS = sizeof($MAILS);                 
    //                $RET = $this->sendMail(OptionsPeer::getString('MAIL_FROM',$this->IDS),$MAILS,$this->MISSATGE->getTitol(),$this->MISSATGE->getText());
    //                $this->EMAIL_INC = $RET['MAILS_INC'];                                                            
    //            } catch (Exception $e) { echo $e->toString(); }            
                $this->MISSATGE->setDataEnviament(date('Y-m-d',time()));
                $this->MISSATGE->save();
                //Enviament a totes les llistes
                
                //Generem l'arxiu en bash per utilitzar amb el mutt.                
                $mail_dir = OptionsPeer::getString('SF_WEBSYSROOT',$this->IDS).'mailing/';
                $mail_dir_site = $mail_dir;
                $this->arxiu_mails = $mail_dir_site.$this->IDS.'-mails.csv';
                $this->arxiu_text  = $mail_dir_site.$this->IDS.'-missatge.csv';
                $this->arxiu_titol = $mail_dir_site.$this->IDS.'-titol.csv';
                $this->arxiu_bash  = $mail_dir_site.$this->IDS.'-bash.sh';
                                
                $fd = fopen($this->arxiu_mails,'w+');                
                foreach($this->EMAILS as $OM) fwrite($fd,$OM->getEmail().chr(10));
                fclose($fd);                
                                
                //Guardem els arxius que usarem.                 
                file_put_contents( $this->arxiu_text , $this->MISSATGE->getText() );
                file_put_contents( $this->arxiu_titol , $this->MISSATGE->getTitol() );
                $OS = SitesPeer::retrieveByPK($this->IDS);
                
                //Creem el bash que executarem amb el cron.                 
                $ARXIU  = '#!/bin/bash '.chr(10);                             
                $ARXIU .= "mails=$(cat {$this->arxiu_mails} | sort | uniq) ".chr(10);
                $ARXIU .= "contenido=$(cat {$this->arxiu_text}) ".chr(10);                                                
                $ARXIU .= "export EMAIL=\"{$OS->getNom()} <{$OS->getEmail()}>\"".chr(10);
                $ARXIU .= "for user in \$mails".chr(10);
                $ARXIU .= "do".chr(10);
                $ARXIU .= "echo \$contenido | mutt -e \"set content_type=text/html\" -F \"/home/informatica/www/phplist/CCG/templates/muttrc\" -s \"$(cat {$this->arxiu_titol})\" \$user ".chr(10);                
                $ARXIU .= "done".chr(10);
                file_put_contents( $this->arxiu_bash , $ARXIU );
                                                 
            break;          
           
        case 'EDITLIST':
                $this->LLISTA = LlistesLlistesPeer::retrieveByPK( $this->IDL );
                $this->EMAILS = LlistesLlistesEmailsPeer::getEmailsFromLlistes( array( $this->IDL ) , $request->getParameter('P',1) );
                $this->MODE = 'EDIT_LIST';
                
            break;
        
        case 'SAVELIST':
                if(empty($this->IDL)) $this->LLISTA = new LlistesLlistes();
                else $this->LLISTA = LlistesLlistesPeer::retrieveByPK($this->IDL);                        
                $this->LLISTA->setNom($request->getParameter('nom_llista'));
                $this->LLISTA->setSiteId($this->IDS);
                $this->LLISTA->setActiu(true);
                $this->LLISTA->save();
                $this->IDL = $this->LLISTA->getIdllista();            
                $this->INPUTS = LlistesLlistesEmailsPeer::addEmails( $request->getParameter('llistat_mails') , $this->IDL , $this->IDS );
                $this->EMAILS = LlistesLlistesEmailsPeer::getEmailsFromLlistes( array( $this->IDL ) , $request->getParameter('P',1) );
                myUser::addLogTimeline( 'alta' , 'usuaris_llistes' , $this->getUser()->getSessionPar('idU') , $this->IDS , $this->IDL );
                $this->MODE = 'EDIT_LIST';
                        
            break;
            
        case 'NEWLIST':
                $this->LLISTA = new LlistesLlistes();
                $this->EMAILS = LlistesLlistesEmailsPeer::getEmailsFromLlistes( array( $this->IDL ) , $request->getParameter('P',1) );
                $this->MODE = 'EDIT_LIST';
                
            break;
        
        case 'BML':
                LlistesLlistesEmailsPeer::baixaEmail( $request->getParameter('IDE') , $request->getParameter('IDL') );
                $this->LLISTA = LlistesLlistesPeer::retrieveByPK( $this->IDL );
                $this->EMAILS = LlistesLlistesEmailsPeer::getEmailsFromLlistes( array( $this->IDL ) , $request->getParameter('P',1) );
                $this->MODE = 'EDIT_LIST';
                        
            break;
        
        //FEM CERCA DE MAILS
        
        case 'CERCA_MAIL':
                $this->LLISTAT_EMAILS = LlistesEmailsPeer::cercaMail($request->getParameter('email') , $this->IDS );
            break;                                                 

        case 'CERCA_MAIL_DNI':
                $this->LLISTAT_EMAILS = LlistesEmailsPeer::cercaMailDNI($request->getParameter('dni') , $this->IDS );
            break;                                                 

        case 'BAIXA_GENERAL':
                LlistesEmailsPeer::baixaGeneral($request->getParameter('idM'),$this->IDS);
            break;                                                 

        case 'CERCA_BAIXES':
                $this->LLISTAT_EMAILS = LlistesEmailsPeer::getAllBaixes($this->IDS);
            break;                                                 



                        
    }
                                    
    //Inicialitzem els valors comuns	
	$this->MISSATGES = LlistesMissatgesPeer::getMissatgesAll( $this->IDS, $this->PAGINA );    
	$this->LLISTES = LlistesLlistesPeer::getLlistesAll( $this->IDS );    	
  
  }  
  
  private function execLlistesUpdateUsers($request,$MISSATGE = array())
  {
    $this->VINCULATS = UsuarisllistesPeer::getVinculatsArray( $this->IDL , $this->CERCA['text'] );
    $this->DESVINCULATS = UsuarisllistesPeer::getDesvinculatsArray( $this->IDL , $this->CERCA['text'] );
    $this->EMAILS = MissatgesEmailsPeer::getEmailsText($this->IDL);
    $this->MODE = "USUARIS";
    $this->MISSATGE = $MISSATGE;
  }
    
  private function sendProvaMissatge($idM,$mail,$idS)
  {    		
    $OM = MissatgesmailingPeer::retrieveByPK($idM);
    $RET = false; 
    try {
        $RET = $this->getMailer()->composeAndSend(OptionsPeer::getString('MAIL_FROM',$idS),$mail,$OM->getTitol(),$OM->getText());
    } catch (Exception $e) { $RET = false; }       
	return $RET;
  }

  private function sendTothomMissatge($idM,$idS)
  { 
    
    $OM = MissatgesmailingPeer::retrieveByPK($idM);
    
	if($OM instanceof Missatgesmailing):		
    	//Recuperem les llistes			
    	foreach($OM->getLlistesEnviament() as $L){    	       
            foreach($L->getMailsUsuaris() as $mail){                
    			$this->getMailer()->composeAndSend(OptionsPeer::getString('MAIL_FROM',$idS),$mail,$OM->getTitol(),$OM->getText());
    		}
    	}
			
    endif;
	
  }

  
  public function saveMissatgeLlistes(sfWebRequest $request)
  {            
	  	foreach($request->getParameter('LLISTES_ENVIAMENT') as $L):                           	    		    	
            $OML = MissatgesllistesPeer::initialize($this->IDM, $L , $this->IDS)->getObject()->save();	    	    					    	
	    endforeach;  
  }
  
/**
 * @deprecated Aquesta funció ja no s'utilitzarà. 
 * 
 * */
/*  
  public function executeGPrintEntrades(sfWebRequest $request)
  {

    $this->setLayout('gestio');
    $this->IDS = $this->getUser()->getSessionPar('idS');

    $this->IDE = $request->getParameter('IDE');    
    $this->PAGINA = $this->getUser()->ParReqSesForm($request,'PAGINA',1);        
    $this->MODE   = "";
    
    $accio = $request->getParameter('accio');
    if($request->hasParameter('BSAVE')) $accio = 'SAVE';
    if($request->hasParameter('BDELETE')) $accio = 'DELETE';        
            
    switch($accio)
    {    
    	case 'C':    			    	
    			$this->getUser()->addLogAction('inside','gEntrades');    	    		
    		break;
    	case 'NOU': 
    			$this->MODE = 'NOU';      
    			$this->FENTRADES = EntradesPeer::initialize( 0 , $this->IDS ); 			
    		break;
    		
    	case 'EDITA':
    			$this->MODE = 'EDITA';    			      
    			$this->FENTRADES = EntradesPeer::initialize( $this->IDE , $this->IDS );
    		break;
    		
    	case 'SAVE':    		
    			$PE = $request->getParameter('entrades');
    			$this->FENTRADES  = EntradesPeer::initialize( $PE['idEntrada'] , $this->IDS );
    			$this->FENTRADES->bind($PE);
    			if($this->FENTRADES->isValid()):
    				$this->FENTRADES->save();                                                                                                                                                                    		
    				$this->getUser()->addLogAction($accio,'gEntrades',$this->FENTRADES->getObject());		
    			else: 
    				$this->MODE = 'EDITA';
    			endif; 
    		break;
    
    	case 'DELETE':
    			$PE = $request->getParameter('entrades');
    			$this->FENTRADES = EntradesPeer::initialize( $PE['idEntrada'] , $this->IDS );
    			$this->getUser()->addLogAction($accio,'gEntrades',$FE->getObject());                
    			$this->FENTRADES->getObject()->setActiu(false)->save();
    		break;
    		    
    	case 'PRINT':
    			$FE = EntradesPeer::initialize( $this->IDE , $this->IDS );    			    			
    		    $this->executePrintEntrades($FE->getObject());			    		    					
    		break;    		    
    }        
    
    $this->ENTRADES = EntradesPeer::getList($this->PAGINA);
  	
  }
*/

    /**
     * Funció que permet gestionar la venta d'entrades
     *   
     * */
  public function executeGEntrades(sfWebRequest $request)
  {

    $this->setLayout('gestio');
    $this->IDS = $this->getUser()->getSessionPar('idS');
    $this->P   = $this->getUser()->ParReqSesForm($request,'P',1);
    $this->URL = $this->getController()->genUrl('gestio/ajaxUsuaris',true);    
    
    $accio = $request->getParameter('accio','LH');            

    //Treiem el llistat d'activitats amb les entrades venudes i tmabé els seus horaris si n'hi ha. Aquí només visualitzem... si hem de modificar clicquem un enllaç cap al calendari.
            
    switch($accio)
    {    
        
        //Llista els que han reservat
    	case 'LR':
                                                        
    			$this->MODE = 'LLISTA_ENTRADES';      
    			$this->LLISTAT_ENTRADES = EntradesReservaPeer::getEntradesVenudes( $request->getParameter('IDA') , $request->getParameter('IDH') , true );
                $this->LLISTAT_ENTRADES_ANULADES = EntradesReservaPeer::getEntradesNoComptades( $request->getParameter('IDA') , $request->getParameter('IDH') );
                                
                 			
    		break;    	
        
        //Anul·la la reserva
        case 'AR':	    	
                $IDR = $request->getParameter('IDR');
                $IDA = 0;
                
                try{
                    $OR = EntradesReservaPeer::retrieveByPK($IDR);
                    $OR->setEstat( EntradesReservaPeer::ESTAT_ENTRADA_ANULADA );                    
                    $OR->save();
                    $IDA = $OR->getEntradesPreusActivitatId();
                    $IDH = $OR->getEntradesPreusHorariId();        
                } catch (Exception $e) {}
                                
                $this->MODE = 'LLISTA_ENTRADES';
                $this->redirect('gestio/gEntrades?accio=LR&IDA='.$IDA.'&IDH='.$IDH);
            break;

        
        //Compra o reserva d'una entrada
        case 'VE':
                
                $this->MODE = 'EDITA_ENTRADA';
                
                //Comprem una entrada o guardem una modificació.
                if($request->hasParameter('BRESERVASAVE'))
                {
                    $RS = $request->getParameter('entrades_reserva');                                                            
                    $this->FReserva = EntradesReservaPeer::initialize( $this->IDS , $this->URL , $RS['idEntrada'] , $RS['entrades_preus_activitat_id'] , $RS['entrades_preus_horari_id'] );                                        
                    $this->FReserva->bind($RS);                    
                    if($this->FReserva->isValid()){
                        try{
                            $is_new = $this->FReserva->isNew();                                                        
                            $RET = $this->FReserva->saveMy();                            
                            $OER = $RET['OER'];                                                    
                            
                            //Si hem pagat amb targeta
                            switch($RET['status']){
                                //Hem fet una actualització de l'entrada
                                case 0:
                                    $this->redirect('gestio/gEntrades?accio=LR&IDA='. $OER->getEntradesPreusActivitatId() .'&IDH='. $OER->getEntradesPreusHorariId() );
                                break;
                                //Compra en metàl·lic o targeta
                                case 1: 
                                    $this->redirect('gestio/gEntrades?accio=OK&code=FACT&Ds_MerchantData='.$OER->getIdentrada());
                                break;
                                //Reserva d'entrada ok
                                case 2: 
                                    $this->redirect('gestio/gEntrades?accio=OK&code=FACT&Ds_MerchantData='.$OER->getIdentrada());
                                break;
                                //Pagament amb TPV
                                case 3: 
                                    if($is_new):
                                        $this->TPV = MatriculesPeer::getTPV( $OER->getPagat() , $OER->getNomUsuari() , $OER->getIdentrada() , $OER->getSiteId() , false , true );
                                        $this->URL = OptionsPeer::getString( 'TPV_URL' , $OER->getSiteId() );
                                        $this->setLayout('blank');
                                        $this->setTemplate('pagament');    
                                    endif;
                                break;
                                //En llista d'espera
                                case 4:
                                    $this->redirect('gestio/gEntrades?accio=OK&code=LLISTA_ESPERA&Ds_MerchantData='.$OER->getIdentrada());
                                break;
                                //Domiciliació
                                case 5:
                                    $this->redirect('gestio/gEntrades?accio=OK&code=DOMICILIACIO&Ds_MerchantData='.$OER->getIdentrada());
                                break;               
                                
                            }
                                                            
                        } catch (Exception $e){ $this->MISSATGE = $e->getMessage(); }
                        
                    }           
                }         
                //Entrem a comprar o editar una entrada normal.
                else 
                {
                                
                    $IDR = $request->getParameter('IDR',0);                    
                    $IDA = $request->getParameter('IDA',0);
                    $IDH = $request->getParameter('IDH',0);
                    
                    $this->FReserva = EntradesReservaPeer::initialize($this->IDS, $this->URL,$IDR,$IDA,$IDH,0);                     
                                        
                }
                                
            break;

        //Un cop hem fet una compra d'una entrada, hem de mostrar aquesta pantalla.
        case 'OK':
                $this->idER = $request->getParameter('Ds_MerchantData',0);
                $OER = EntradesReservaPeer::retrieveByPK($this->idER);
                                
                if($OER instanceof EntradesReserva):
                
                    switch($request->getParameter('code')){
                        case 'FACT':
                            $this->MISSATGE = "ENTRADA_METALIC";
                        break;
                        case 'LLISTA_ESPERA':
                            $this->MISSATGE = "ENTRADA_LLISTA_ESPERA";
                        break;
                        case 'DOMICILIACIO':
                            $this->MISSATGE = "ENTRADA_DOMICILIACIO";
                        break;
                        case 'TPV':
                            $this->MISSATGE = "ENTRADA_OK";
                        break;
                    }
                                                  
                    $email = $OER->getEmail();
                    $MailEnt = EntradesReservaPeer::DocReservaEntrades( $OER , $OER->getSiteId() );
                    if($email <> "") $this->sendMail( $from , $email , $subject , $MailEnt );
                    $this->sendMail( $from , OptionsPeer::getString( 'MAIL_ADMIN' , $idS ) , $subject , $MailEnt );                    
                     
                else: 
                    $this->MISSATGE = "ENTRADA_NO_TROBADA";
                endif;

                $this->MODE = 'MISSATGE';

            break;
        
        case 'KO':
        
                $this->MISSATGE = "PROBLEMA_PAGANT";
                $this->MODE = 'MISSATGE';
                
            break;
            
        case 'PRINT':

                $idER = $request->getParameter('idER');
                                
                $OER = EntradesReservaPeer::retrieveByPK($idER);                                
                
                $HTML = EntradesReservaPeer::DocReservaEntrades($OER, $this->IDS);                
                        
                myUser::Html2PDF($HTML);
                                
    			throw new sfStopException;			   	  	                                                                                                                                                                 
        
            break;

        case 'PRINT_LLISTAT':
							                            				                
                $HTML = EntradesReservaPeer::DocLlistatEntrades( $request->getParameter('IDH'), $request->getParameter('IDA') , $this->IDS );                                
                        
                myUser::Html2PDF($HTML);
                
                throw new sfStopException;

            break;                        
                  
        //Llisto els horaris que disposen d'entrades
        default:
                //Agafo els horaris que tenen entrades a la venta i els ordeno per data 
                $this->LLISTAT_ENTRADES_PREUS = EntradesPreusPeer::getActivitatsAmbEntrades( $this->IDS , $this->P );                                         
                $this->MODE   = "LLISTA_ACTIVITATS";
            break;
    }        
        	
  }
  
  public function executePrintEntrades($OE)
  {
  	
  	$config = sfTCPDFPluginConfigHandler::loadConfig();
	 
	//create new PDF document (document units are set by default to millimeters)
	$pdf = new sfTCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true);
	 
	// set document information
	$pdf->SetCreator('Intranet CCG');
	$pdf->SetAuthor('Intranet CCG');
	$pdf->SetTitle('Entrades CCG');
	$pdf->SetSubject("Entrades CCG");
	$pdf->SetFont('helvetica', '', 9);
	$pdf->SetMargins(0, 0, 0 , 0);
	$pdf->setPrintHeader(false);
	$pdf->setPrintFooter(false);
	$pdf->setAutoPageBreak(false);
	
	
   	//Consultem tots els usuaris de la llista que volem imprimir.
   	$fila = 1; $columna = 1; $pagina = 1; $pdf->AddPage();
   	$h = 50;
   	$w = 105;
           	
	for($i = 1; $i< $OE->getLocalitats(); $i++):
	
		if($fila > 3) $text = "<br />"; else $text = "";
		if($fila > 6) $text .= ""; 
				$text = $text."
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>$i</b>
				<br />								
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$OE->getTitol()."<br />
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$OE->getSubtitol()."<br />				
				<br />
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$OE->getData()."<br />
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$OE->getLloc()."<br />				
				<br />				
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$OE->getPreu()."<br />
																					
		";   		 		
  		if($fila    == 7): $pdf->AddPage(); $fila = 1; endif;  		  		
  		  		  		  		
  		if($columna == 1 && $fila == 1):  			
			$pdf->writeHTMLCell( $w , $h , 0 , 0 , $text , 0 , 0 );
			$columna++;  			
  		elseif($columna == 1 && $fila != 1):
			$pdf->writeHTMLCell( $w , $h , null , null , $text , 0 , 0 );
			$columna++;
  		elseif($columna == 2):
  			$pdf->writeHTMLCell( $w , $h , null , null , $text , 0 , 1 );
  			$columna = 1; $fila++;
  		endif;
  		 				
  	endfor;
	  	  
	$pdf->Output();
	 
	return sfView::NONE;
  	
  }
  
  public function printEtiquetes($idL)
  {
  	  	  	
	$config = sfTCPDFPluginConfigHandler::loadConfig();
	 
	//create new PDF document (document units are set by default to millimeters)
	$pdf = new sfTCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true);
	 
	// set document information
	$pdf->SetCreator('Intranet CCG');
	$pdf->SetAuthor('Intranet CCG');
	$pdf->SetTitle('Llistat de mailing postal');
	$pdf->SetSubject("Llistat correu");
	$pdf->SetFont('helvetica', '', 8);
	$pdf->SetMargins(0, 0, 0 , 0);
	$pdf->setPrintHeader(false);
	$pdf->setAutoPageBreak(false);

   	//Consultem tots els usuaris de la llista que volem imprimir.
   	$fila = 1; $columna = 1; $pagina = 1; $pdf->AddPage();
  	$OL = LlistesPeer::retrieveByPK($idL);
  	foreach($OL->getUsuarisllistess() as $UL):  		
  		$OU = $UL->getUsuaris();
  		$text  = "<br><br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>".$OU->getNomComplet()."</b>";
  		$text .= "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$OU->getAdreca();
  		$text .= "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$OU->getCodiPostal().' - '.$OU->getPoblacioString();   		 	
  	
  		if($fila    == 9): $pdf->AddPage(); $fila = 1; endif;  		  		
  		  		  		  		
  		if($columna == 1 && $fila == 1):
			$pdf->MultiCell( 70 , 37 , $text , 1 , 'L' , 0 , 0 , 0 , 0 , true , 0 , true , true , 0 );
			$columna++;  			
  		elseif($columna == 1 && $fila != 1):
			$pdf->MultiCell( 70 , 37 , $text , 1 , 'L' , 0 , 0 , '', '', true , 0 , true , true , 0 );
			$columna++;
  		elseif($columna == 2):
  			$pdf->MultiCell( 70 , 37 , $text , 1 , 'L' , 0 , 0 , '', '', true , 0 , true , true , 0 );
  			$columna++;
  		elseif($columna == 3):
  			$pdf->MultiCell( 70 , 37 , $text , 1 , 'L' , 0 , 1 , '', '', true , 0 , true , true , 0 );
  			$columna=1; $fila++;
  		endif;
  		 				
  	endforeach;
	  
	  
	$pdf->Output();
	 
	return sfView::NONE;
	  		   	
  }
  
  public function saveLlista()
  {
    $L = new Llistes();
    if(!$this->getRequestParameter('NOU')): $L = LlistesPeer::retrieveByPK($this->getRequestParameter('IDL')); $L->setNew(false); endif;    
    $L->setNom($this->getRequestParameter('NOM')); $L->save();    
    $RET['ERRORS'] = array(); $RET['LLISTA'] = $L;     
    return $RET; 
  }
  
  public function saveUsuaris()
  {    
    $USUARIS = $this->getRequestParameter('USUARIS');
    $IDL = $this->getRequestParameter('IDL');
    $ERRORS = array();        
    if(isset($USUARIS)):
      foreach($USUARIS as $U):            
        $C = new Criteria();
        $C->add(UsuarisllistesPeer::USUARIS_USUARISID,$U);
        $C->add(UsuarisllistesPeer::LLISTES_IDLLISTES,$IDL);
        $UL = UsuarisllistesPeer::doSelectOne($C);
        $UL->delete();        
      endforeach;
    endif;
    
    if($this->getRequestParameter('DNI') <> ''):
      $DNIs = explode(",", $this->getRequestParameter('DNI'));    
      foreach($DNIs as $D):        
        if($this->ValidaDNI(trim($D),false)):
          $C = new Criteria(); $C->add(UsuarisPeer::DNI, trim($D)); $U = UsuarisPeer::doSelectOne($C);
          $C = new Criteria(); $C->add(UsuarisllistesPeer::LLISTES_IDLLISTES,$IDL); $C->add(UsuarisllistesPeer::USUARIS_USUARISID,$U->getUsuariid()); $COUNT = UsuarisllistesPeer::doCount($C);
          if($COUNT == 0): 
            $UL = new Usuarisllistes();
            $UL->setLlistesIdllistes($IDL);
            $UL->setUsuarisUsuarisid($U->getUsuariid());
            $UL->save();
          endif;
        else:
          $ERRORS[] = 'El DNI '.$D.' Ã©s incorrecte.';
        endif; 
      endforeach;
    endif;
    
    $RET['ERRORS'] = $ERRORS;
    
    return $RET;
    
  }
  
  public function saveMissatges()
  {
    $M = new Missatgesllistes();
    if($this->getRequestParameter('IDM') > 0): $M = MissatgesllistesPeer::retrieveByPK($this->getRequestParameter('IDM')); $M->setNew(false); endif;    
    
    $M->setTitol($this->getRequestParameter('TITOL'));
    $M->setText($this->getRequestParameter('TEXT'));
    $M->setDate(time());
    $M->setLlistesIdllistes($this->getRequestParameter('IDL'));
    $M->save();
        
    $RET['ERRORS'] = array(); $RET['MISSATGE'] = $M;     
    return $RET; 
  }
  
  
  public function executeSelectCodiCurs(sfWebRequest $request)
  {
  	
  	$C = new Criteria();
  	$RESPOSTA = CursosPeer::getCodisAjax($request->getParameter('q'), $request->getParameter('limit'));
 	  	    
    return $this->renderText(json_encode($RESPOSTA));
      
  }

  public function executeAjaxSelectMaterial(sfWebRequest $request)
  {
      
    $this->IDS = $this->getUser()->getSessionPar('idS');       
    $idG   = $request->getParameter('generic');
    
    if($request->hasParameter('dies_franja')):

        $diai  = $request->getParameter('diai');
        $diaf  = $request->getParameter('diaf');                
        return $this->renderText(MaterialPeer::getOptionsMaterialLliureHores($diai,$diaf,'00:00','24:00',$this->IDS,$idG));
                
    
    else: 

        $dies  = $request->getParameter('dies');
        $hpre  = $request->getParameter('horapre');
        $hpost = $request->getParameter('horapost');            
        foreach(explode(',',$dies) as $d):
            list($d,$m,$y) = explode('/',$d);
            $dia = $y.'-'.$m.'-'.$d;        
            return $this->renderText(MaterialPeer::getOptionsMaterialLliureHores($dia,$dia,$hpre,$hpost,$this->IDS,$idG));             
        endforeach;
        
    endif;    	  	  	  	  	  	  	           
      
  }
  
  public function executeSelectUser(sfWebRequest $request)
  {

  	$C = new Criteria();
  	$RESPOSTA = UsuarisPeer::cercaTotsCampsSelect($request->getParameter('q'), $request->getParameter('limit'));
 	  	    
    return $this->renderText(json_encode($RESPOSTA));
  	  	
  } 
  
  public function executeGActivitats(sfWebRequest $request)
  {  	

    $this->setLayout('gestio');
    $this->IDS = $this->getUser()->getSessionPar('idS');    	

   	//Netegem cerca
  	if($request->getParameter('accio') == 'C'):      		
        $this->CERCA  = $this->getUser()->setSessionPar('cerca',array('text'=>''));
      	$this->PAGINA = $this->getUser()->setSessionPar('pagina',1);  			      
        $this->DATAI  = $this->getUser()->setSessionPar('DATAI',time());        	           			       
    endif;    
        
    //Afegit per si algú ha d'enviar algun error
    $this->ERROR =          $request->getParameter('ERROR');
    if($this->ERROR == "HORARI_NO_EXISTEIX"): $this->MISSATGE = array(0=>"L'Horari no existeix o no s'ha trobat.");
    elseif($this->ERROR == "ACTIVITAT_NO_EXISTEIX"): $this->MISSATGE = array(0=>"La activitat no existeix o no s'ha trobat. ");
    elseif($this->ERROR == "NO_HI_HA_MES_HORARIS"): $this->MISSATGE = array(0=>"No s'ha creat cap nova activitat, perquè només conté un horari.");
    endif;
            
    $this->CERCA  			= $this->getUser()->ParReqSesForm($request,'cerca',array('text'=>""));    
    
    $T = time();
    
    $this->PAGINA 			= $request->getParameter('PAGINA',1);    
    $this->DATAI            = $this->getUser()->ParReqSesForm($request,'DATAI',$T);                          
    $this->DIA    			= $request->getParameter('DIA',time());    
    $this->IDA    			= $request->getParameter('IDA',0);
    $this->accio 			= $request->getParameter('accio','C');            
    $this->ACTIVITAT_NOVA 	= false;        

    //Inicialitzem el formulari de cerca
    $this->FCerca = new CercaForm();            
    if(isset($this->CERCA['text'])) $this->FCerca->bind(array('text'=>$this->CERCA['text']));
    else $this->FCerca->bind(array('text'=>''));

	//Inicialitzem variables
	$this->MODE = array();

    if($request->isMethod('POST')){
	    if($request->hasParameter('BCERCA')) { $this->accio = 'C'; $this->PAGINA = 1; }   
	    elseif($request->hasParameter('BNOU')) 	    		   $this->accio = 'ACTIVITAT';
	    elseif($request->hasParameter('BCICLE'))               $this->accio = 'CICLE';
	    elseif($request->hasParameter('BCICLESAVE'))		   $this->accio = 'CICLE_SAVE';	    
	    elseif($request->hasParameter('B-GUARDA-ACTIVITAT'))   $this->accio = 'ACTIVITAT_SAVE';
	    elseif($request->hasParameter('B-ESBORRA-ACTIVITAT'))  $this->accio = 'ACTIVITAT_DELETE';	    
	    elseif($request->hasParameter('BGENERANOTICIA')) 	   $this->accio = 'GENERA_NOTICIA';	    
        elseif($request->hasParameter('BPREUSSAVE')) 	       $this->accio = 'PREUS';
	    
    }                
    
    //Quan cliquem per primer cop a qualsevol de les cerques, la pàgina es posa a 1
    if($request->getParameter('accio') == 'C') $this->PAGINA = 1;
    if($request->getParameter('accio') == 'CD') { $this->PAGINA = 1; }    
    if($request->hasParameter('DATAI')) { $this->DIA = ""; } 
    
    //Aquest petit bloc és per si es modifica amb un POST el que s'ha enviat per GET    
    //$this->getUser()->setSessionPar('PAGINA',$this->PAGINA);   //Guardem la pÃ gina per si hem fet una consulta nova                    
    
    $this->DATAF = mktime(0,0,0,date('m',$this->DATAI)+3,date('d',$this->DATAI),date('Y',$this->DATAI));  //La data final sempre Ã©s 3 mesos superior a la inicial        
	   
    switch($this->accio){
            	
    	//Consulta inicial del calendari sense prèmer cap dia, només amb un factor de cerca
    	case 'C':

    			$this->getUser()->addLogAction('inside','gActivitats');
    		
                $HORARIS = HorarisPeer::getActivitats(null,$this->CERCA['text'],$this->DATAI,$this->DATAF,null,$this->IDS);
                if($this->CERCA['text'] <> "") $this->ACTIVITATS = $HORARIS['ACTIVITATS'];
               	else $this->ACTIVITATS = array();                                                                 
                $this->CALENDARI = $HORARIS['CALENDARI'];                
                $this->MODE['CONSULTA'] = true;
                $this->MODE['LLISTAT'] = true;                                                                              
                break;
    		break;

    	//Consulta que em mostra les activitats quan canvio de mensualitat o any 
    	case 'CC':     			   		
                $HORARIS = HorarisPeer::getActivitats(null , $this->CERCA['text'], $this->DATAI, $this->DATAF, null, $this->IDS);
                //$this->ACTIVITATS = $HORARIS['ACTIVITATS'];
                $this->ACTIVITATS = array();                
                $this->CALENDARI = $HORARIS['CALENDARI'];                
                $this->MODE['CONSULTA'] = true;
                $this->MODE['LLISTAT'] = true;                                              
            break;
    		
    		
    	//Consulta que em mostra les activitats d'un dia seleccionat del calendari
    	case 'CD':    		
                $HORARIS = HorarisPeer::getActivitats($this->DIA , $this->CERCA['text'], null , null , null, $this->IDS);
                $this->ACTIVITATS = $HORARIS['ACTIVITATS'];                
                $this->CALENDARI = $HORARIS['CALENDARI'];
                $this->MODE['CONSULTA'] = true;
                $this->MODE['LLISTAT'] = true;                                                              
    		break;    	
    		    		
    	//Entrem les activitats... que necessitem
    	case 'ACTIVITAT':
        
            $this->IDA = $request->getParameter('IDA');
            
            //Carrego l'activitat i també les relacionades del cicle... si n'hi ha.
            $OA = ActivitatsPeer::retrieveByPK($this->IDA);
            if($OA instanceof Activitats):
                                
                $OC = $OA->getCicles();
                $idC = 0;
                if($OC instanceof Cicles) $idC = $OC->getCicleid();
                $FA = ActivitatsPeer::initialize( $this->IDA , $idC , $this->IDS );
                
                //Si l'activitat té un cicle, carreguem les activitats relacionades
                $L_OA_REL = array();
                $this->N = CiclesPeer::getActivitatsCicle($idC, $this->IDS);
                
                //Carreguem el formulari de preus
                $LOH = $OA->getHorarisActius($this->IDS);               //Carreguem els horaris actius de l'activitat.
                $this->FPREUS = array();                                                                
                
                if( ( $OC instanceof Cicles ) && ( $this->N < 50 ) ) $L_OA_REL = CiclesPeer::getActivitatsCicleList( $idC , $this->IDS );
                $this->OC = $OC; $this->OA = $OA; $this->L_OA_REL = $L_OA_REL; $this->FA = $FA;
                $this->MODE['ACTIVITAT_CICLE'] = true;
                    		            
            //Si no hi ha l'activitat, vol dir que és nova...
            else: 
                                        
                $FA = ActivitatsPeer::initialize( 0 , 0 , $this->IDS );                                
                $L_OA_REL = array(); $this->N = 0;
                                
                $this->OC = null; $this->OA = $FA->getObject(); $this->L_OA_REL = $L_OA_REL; $this->FA = $FA;
                $this->MODE['ACTIVITAT_CICLE'] = true;
            
            endif; 
    		     			
    		break;      
    		            
    	//Guardem l'activitat
    	case 'ACTIVITAT_SAVE':

    			$RP = $request->getParameter('activitats');                
    			$this->IDA = $RP['ActivitatID'];
    			$this->IDC = $RP['Cicles_CicleID'];
    		
	    		$this->FActivitat = ActivitatsPeer::initialize($this->IDA,$this->IDC, $this->IDS);	    		
	    		$this->FActivitat->bind($RP);
	    		if($this->FActivitat->isValid()):
	    			$nova = $this->FActivitat->isNew();                    
	    			$this->FActivitat->save();	    			
	    			$this->getUser()->addLogAction($this->accio,'gActivitats',$this->FActivitat->getObject());                                        
	    			$this->IDA = $this->FActivitat->getObject()->getActivitatid();                    	    
                    
                    if($RP['ActivitatID'] > 0) myUser::addLogTimeline( 'alta' , 'activitats' , $this->getUser()->getSessionPar('idU') , $this->IDS , $this->FActivitat->getObject()->getActivitatid() );
                    myUser::addLogTimeline( 'modificació' , 'activitats' , $this->getUser()->getSessionPar('idU') , $this->IDS , $this->FActivitat->getObject()->getActivitatid() );
                    			
	    			$this->redirect('gestio/gActivitats?accio=ACTIVITAT&IDA='.$this->IDA);	    			 	    				    		                                                             
	    		else:                 
                    $this->MISSATGE = "HI HA HAGUT ALGUN PROBLEMA CREANT L'ACTIVITAT.";                
                endif; 
    			
    		break;

    	//Esborrem una activitat
    	case 'ACTIVITAT_DELETE':

    			$RP = $request->getParameter('activitats');
    			$this->IDA = $RP['ActivitatID'];
    			$this->IDC = $RP['Cicles_CicleID'];
    		
	    		$this->FActivitat = ActivitatsPeer::initialize($this->IDA,$this->IDC,$this->IDS);
	    		$OA = $this->FActivitat->getObject();
	    		if($OA instanceof Activitats):
	    			$this->getUser()->addLogAction($this->accio,'gActivitats',$OA);
                    myUser::addLogTimeline( 'baixa' , 'activitats' , $this->getUser()->getSessionPar('idU') , $this->IDS , $RP['ActivitatID'] );                    
                    $OA->setInactiu();
	    			$this->redirect('gestio/gActivitats?accio=CC');
	    		endif; 	    		
	    		    			    			
    		break;
    		
    		
    	//Crida AJAX per carregar un horari
    	case 'HORARI':
    			                                  
                 $idH = $request->getParameter('idH');
                 $idA = $request->getParameter('idA');
                 $OH = HorarisPeer::retrieveByPK($idH);                 
                 if($OH instanceof Horaris):
                    return $this->renderPartial('formHorari',array("OH"=>$OH));
                 else:                     
                    return $this->renderPartial('formHorari',array("OH"=>HorarisPeer::initialize($idH , $idA, $this->IDS)->getObject()));
                 endif;
                 
    		break;
		
    	//Crida per AJAX que emmagatzema els horaris i fa les comprovacions pertinents
        case 'HORARI_SAVE':
    		    			                                                
                //Carreguem els paràmetres a la variable enviats per ajax. 
                parse_str($request->getParameter('FORMULARI') , $RP );                
                $ERRORS = array();                                                
                 
    			$IDA = $RP['horaris']['Activitats_ActivitatID'];                
    			$IDH = $RP['horaris']['HorarisID'];                
    			               		
                //Comprovem si existeix l'activitat... si no existeix li diem que primer l'han de guardar.                 
                $OA = ActivitatsPeer::retrieveByPK($IDA);
                                 
                //Si no podem carregar l'activitat, mostrem un error... 
                if( ! $OA instanceof Activitats ){
                
                    $ERRORS['OA'] = 'ERROR: ABANS DE CREAR UN HORARI HAS DE GUARDAR L\'ACTIVITAT.';
                    return $this->renderText( implode( '<br />' , $ERRORS ) );
                
                //Hem pogut carregar l'activitat relacionada i podem donar d'alta l'horari.
                } else {
                                
    	    		//Carreguem l'Horari que s'ha entrat... o en creem un de nou.
                    $OH = HorarisPeer::retrieveByPK($IDH);
    	    		if($OH instanceof Horaris) 	 $FHorari = new HorarisForm($OHorari);
    	    		else                         $FHorari = new HorarisForm();					                                
                    
                    //Fem un bind de les dades generals per si hi ha un error
                    $FHorari->bind($RP);                                      
                    
                    //Creem la variable EXTRES
                    $EXTRES = array('ESPAISOUT'=>array(),'MATERIALOUT'=>array());
                    
                    //Guardem a extres els espais que volem reservar de la nostra entitat
    	    		$EXTRES['ESPAISOUT'] =  $RP['espais'];                                                                            
                                    
    	    		//Comprovem l'existència del material i el guardem en format de save
    	    		foreach($RP['material'] as $M=>$idM):
    	    			$OM = MaterialPeer::retrieveByPK($idM);
                        if($OM instanceof Material) $EXTRES['MATERIALOUT'][] = array('material'=>$idM,'generic'=>$OM->getMaterialgenericIdmaterialgeneric());                        			
    	    		endforeach;
    	    		                    
                    //Tractem els espais externs, i el guardem si n'hi ha algun.                                
                    $EXTRES['ESPAIEXTERN'] = EspaisExternsPeer::initialize( $RP['espais_externs'] );
                    if($RP_EE['espais_externs']['Poble'] > 0):                                                             
                        $EXTRES['ESPAIEXTERN']->bind($RP['espais_externs']);                        
                        if( ! $EXTRES['ESPAIEXTERN']->isValid()) $ERRORS['EE'] = "ERROR: HI HA ALGUN ERROR EN L'ESPAI EXTERN.";                            
                        else $EXTRES['ESPAIEXTERN']->save();                        
                    endif;
                                        
                    //Si no hi ha cap error, passem a guardar.                                                                                 
                    if(empty($ERRORS)) $ERRORS = HorarisPeer::GuardaHorari( $RP['horaris'] , $EXTRES , $this->IDS );
                                    		
    	    		//Si no hi ha hagut cap error, ho guardem al log com un canvi en l'horari
                    if(empty($ERRORS)): 
    	    			$this->getUser()->addLogAction('HORARI_SAVE','gActivitats',$FHorari->getObject());
                        if($RP['horaris']['HorarisID'] > 0) myUser::addLogTimeline( 'modificació' , 'horaris' , $this->getUser()->getSessionPar('idU') , $this->IDS , $IDA );
                        else myUser::addLogTimeline( 'alta' , 'horaris' , $this->getUser()->getSessionPar('idU') , $this->IDS , $IDA );
                                                        	    			
                        return $this->renderText( implode( "\n" , $ERRORS ) );
                        //Hem d'informar que ha anat tot bé.                         	    			
    	    		else:                         
    	    			//Hem d'informar que hi ha hagut algun error                        
                        return $this->renderText( implode( "\n" , $ERRORS ) );
    	    		endif; 
    	    		    	    		    	    		    	    		
                }
	    			    			    		    	    			
    		break;
    		
    	//Funció AJAX que esborra un horari determinat. 
        case 'HORARI_DELETE':

                //Llegim el que s'envia per ajax.
    			parse_str($request->getParameter('FORMULARI') , $RP );                
    			$OH = HorarisPeer::retrieveByPK($RP['horaris']['HorarisID']);
    			if($OH instanceof Horaris):
	    			$this->getUser()->addLogAction($this->accio,'gActivitats',$OH);
                    myUser::addLogTimeline( 'baixa' , 'horaris' , $this->getUser()->getSessionPar('idU') , $this->IDS , $RP['horaris']['Activitats_ActivitatID'] );
	    			$OH->setInactiu();
                    return $this->renderText( "" );
                else: 
                    return $this->renderText( "ERROR: No s'ha trobat l'horari. ");    			    			
	    		endif; 	   			
	   			
    		break;
/*    		
    	case 'DESCRIPCIO':
    		
    			$this->CarregaActivitats($request,false);
    			$this->FActivitat = ActivitatsPeer::initializeDescription($this->IDA,$this->IDS);    			    			
    			$this->MODE['DESCRIPCIO'] = true;
    				    			     			    			
    		break;
*/    	
    	case 'DESCRIPCIO_SAVE':
    			
    			parse_str($request->getParameter('FORMULARI') , $RP );                
    			$RP = $RP['activitats'];                       
                $this->IDA = $RP['ActivitatID'];                
		    			
    			$this->FActivitat = ActivitatsPeer::initializeDescription($this->IDA,$this->IDS);    			
    			$this->FActivitat->bind($RP);
    			if($this->FActivitat->isValid()):                        				
                    $this->FActivitat->save();
    				$this->getUser()->addLogAction($this->accio,'gActivitats',$this->FActivitat->getObject());
    				return $this->renderText('');
                else: 
                    return $this->renderText('ERROR: No s\'ha trobat la descripció.');
    			endif; 
    			    			    		
    		break;

		case 'GENERA_NOTICIA':
    			
    			$RP = $request->getParameter('activitats');
    			$this->IDA = $RP['ActivitatID'];    			
    			$ONoticia = NoticiesPeer::getNoticiaActivitat($this->IDA,$this->IDS);    			
    			$this->redirect('gestio/gNoticies?accio=E&idn='.$ONoticia->getIdnoticia());
    			    			    		
    		break;
      
      case 'PREUS':
                        
                parse_str($request->getParameter('FORMULARI') , $RP );                
                $ERRORS = array();                                                                     			   
    			               		                        
                if($request->hasParameter('FORMULARI')):
                
                    //Aquí hem de guardar una possibilitat de comprar entrada.
                   $VALORS = $RP['entrades_preus'];
                   if( EntradesPreusPeer::doSave($VALORS) ):
                        return $this->renderText('');
                   else: 
                        return $this->renderText('Hi ha hagut algun error guardant l\'el preu.');
                   endif; 
                     
                else: 
                
                    $IDH = $request->getParameter('idH');
                    $IDA = $request->getParameter('idA');
                    $OH = HorarisPeer::retrieveByPK($IDH);
                    if( $OH instanceof Horaris ) $OP = EntradesPreusPeer::initialize( $OH->getSiteid() , $OH->getHorarisid() , $OH->getActivitatsActivitatid() );
                    else $OP = new EntradesPreus();                                                                                
                    return $this->renderPartial( 'formPreus' , array( 'OP' => $OP ) );
                
                endif; 
                                                                  
            break;
                        
        //Des d'un horari, creem una activitat nova amb les mateixes dades. Ja està entrat l'error a dalt.
        case 'DESDOBLAR':
                
                $IDH = $request->getParameter('IDH');
                $OH = HorarisPeer::retrieveByPK($IDH);
                if(!($OH instanceof Horaris)) $this->redirect("gestio/gActivitats?accio=ERROR_GREU&ERROR=HORARI_NO_EXISTEIX");
                                
                //Carreguem l'activitat i en fem una de nova.
                $OA = ActivitatsPeer::retrieveByPK($OH->getActivitatsActivitatid());
                if(!($OA instanceof Activitats)) $this->redirect("gestio/gActivitats?accio=ERROR_GREU&ERROR=ACTIVITAT_NO_EXISTEIX");
                                                
                //Comprovem que tingui algun altre horari, sinó donem error.
                $NH = $OA->countHorarisActius($this->IDS);
                if($NH <= 1) $this->redirect("gestio/gActivitats?accio=HORARI&IDA={$OA->getActivitatid()}&IDH={$OH->getHorarisid()}&ERROR=NO_HI_HA_MES_HORARIS");                
                                                                                                
                $NOVA_ACTIVITAT = $OA->copy();
                $NOVA_ACTIVITAT->save();                                                  
                 
                $OH->setActivitatsActivitatid($NOVA_ACTIVITAT->getActivitatid());
                $OH->save();
                                
                $this->redirect("gestio/gActivitats?accio=ACTIVITAT&IDA={$NOVA_ACTIVITAT->getActivitatid()}");
                                                                                                         
            break;
            
        //Mostra un error greu on apareix només el missatge
        case 'ERROR_GREU':
            $this->MODE['ERROR_GREU'] = true;            
            break;
    					
    }                                
    
  }  
    
  function sumarmesos($data,$mesos)
  { 
    list($year,$mon,$day) = explode('-',$data);
  	return date('Y-m-d',mktime(0,0,0,$mon+$mesos,$day,$year));		
  }  
        
  
  //**************************************************************************************************************************************************
  //**************************************************************************************************************************************************
  
  private function getCercaEstadistiquesComplet($C)
  {    
    if(!isset($C['ANY']))               $C['ANY'] = date('Y',time());
    if(!isset($C['MES']))               $C['MES'] = date('m',time());
    if(!isset($C['DIA']))               $C['DIA'] = date('d',time());
    if(!isset($C['ESPAI']))             $C['ESPAI'] = array();
    if(!isset($C['MATERIAL']))          $C['MATERIAL'] = array();    
    if(!isset($C['MATERIAL_GENERIC']))  $C['MATERIAL_GENERIC'] = 0;
    return $C;
  }  
  
  public function executeGEstadistiques(sfWebRequest $request)  
  {
    
    $this->setLayout('gestio');
    $this->IDS = $this->getUser()->getSessionPar('idS');            
    $this->CERCA = $request->getParameter('cerca',$this->CERCA);
    $this->CERCA = $this->getCercaEstadistiquesComplet($this->CERCA);
            

    if($request->hasParameter('BCERCA_ESP')):    
        $this->ESPAIS = EspaisPeer::select($this->IDS);
        $dit = mktime(0,0,0,$this->CERCA['MES'],1,$this->CERCA['ANY']);
        $month = date('m',$dit); $year = date('Y',$dit); $site = $this->IDS;                                         
        $this->OCUPACIO_ESPAIS = EspaisPeer::getEstadistiquesEspais($this->CERCA['ESPAI'], $site, $month, $year);
    elseif($request->hasParameter('BCERCA_MAT')):
        $this->MATERIAL = MaterialPeer::selectGeneric($this->CERCA['MATERIAL_GENERIC'],$this->IDS,null);
        $dit = mktime(0,0,0,$this->CERCA['MES'],1,$this->CERCA['ANY']);
        $month = date('m',$dit); $year = date('Y',$dit); $site = $this->IDS;
        $this->OCUPACIO_MATERIAL = MaterialPeer::getEstadistiquesMaterial($this->CERCA['MATERIAL'], $site, $month, $year);        
    endif;
          
  }
  

  //**************************************************************************************************************************************************
  //**************************************************************************************************************************************************
  
  public function executeagendaAC(){
     $CERCA = $this->getRequestParameter('CERCA');    
     $this->AGENDA = AgendatelefonicadadesPeer::doSearch( $CERCA );
 
  }
  
  
  public function executeSearchAjaxAgenda(sfWebRequest $request)
  {
/*
  	sfConfig::set('sf_web_debug', false);
  	sfLoader::loadHelpers('Partial');
  	  	
  	$C = new Criteria();
  	$this->CERCA  	= $this->getUser()->ParReqSesForm($request,'cerca',array('text'=>""));
  	$AGENDES = AgendatelefonicadadesPeer::doSearch( $this->CERCA );  	
  
  	return $this->renderText(get_partial('listAgenda', array('AGENDES' => $AGENDES)));  	           	  	        
 */     
  }  
  
  
  public function executeGAgenda($request)  
  {  		  	
  	$this->setLayout('gestio');
    $this->IDS = $this->getUser()->getSessionPar('idS');    
  	
  	//Netegem cerca
  	if($request->getParameter('accio') == 'C'):      		
      	$this->CERCA = $this->getUser()->setSessionPar('cerca',array('text'=>''));      	
    endif;
  	  
  	//Inicialitzem les variables
  	$this->CERCA  	= $this->getUser()->ParReqSesForm($request,'cerca',array('text'=>""));  	
  	$this->accio  	= $request->getParameter('accio','C');  	
  	$this->MODE     = "";  	           	
    $this->P        = $request->getParameter('P',1);
  	
  	//Tractem el formulari de cerca
  	$this->FCerca = new CercaForm();  	  
  	$this->FCerca->bind($this->CERCA);
        
  	//Definim l'acció segons el botó premut  	
    if( $this->getRequest()->hasParameter('BNOU') ) $this->accio = 'N';
    if( $this->getRequest()->hasParameter('BSAVE') ) $this->accio = 'S';
    if( $this->getRequest()->hasParameter('BDELETE') ) $this->accio = 'D';
    if( $this->getRequest()->hasParameter('BCERCA')) $this->accio = 'L';  

    $this->getUser()->setSessionPar('accio',$this->accio);
    
    switch( $this->accio )
    {    	
    	
      case 'C':
    			$this->getUser()->addLogAction('inside','gAgenda');                
    			$this->AGENDES = AgendatelefonicadadesPeer::doSearch( $this->CERCA['text'] , $this->IDS , $this->P );
    			break;
    	
      case 'N':
                $this->MODE = 'NOU';         
                $this->FAgenda = AgendatelefonicaPeer::initialize( 0 , $this->IDS );                                       
                break;                
      case 'E':
                $this->MODE = 'EDICIO';
                $AID = $request->getParameter('AID');                                                                                
                $this->FAgenda = AgendatelefonicaPeer::initialize( $AID , $this->IDS );
                $OAT = $this->FAgenda->getObject();                                                
                $this->DADES = $OAT->getAgendatelefonicadadesActiu();                                                                                
                break;
      case 'S':      			
                $RA = $request->getParameter('agendatelefonica');                
      			$AID = $RA['AgendaTelefonicaID'];
                $this->FAgenda = AgendatelefonicaPeer::initialize( $AID , $this->IDS );      			
      			$this->FAgenda->bind($RA);
      			if($this->FAgenda->isValid()):
					$this->FAgenda->save();
					
                    $this->getUser()->addLogAction($this->accio,'gAgenda',$this->FAgenda->getObject());
                    myUser::addLogTimeline( 'alta' , 'agenda' , $this->getUser()->getSessionPar('idU') , $this->IDS , $this->FAgenda->getObject()->getAgendatelefonicaId() );
                    
                    $this->AID = $this->FAgenda->getObject()->getAgendatelefonicaid();													
					AgendatelefonicadadesPeer::update( $request->getParameter('Dades') , $this->AID , $this->IDS ); //Actualitzem tambÃ© les dades relacionades
					$this->MISSATGE = "El registre s'ha modificat correctament.";
					$this->redirect('gestio/gAgenda?accio=L');
				else: 
					$this->DADES = $this->FAgenda->getObject()->getAgendatelefonicadadess();
					$this->MODE = 'EDICIO';
				endif; 
				      			      															                                     
                break;         
      case 'D': 
                $RA = $request->getParameter('agendatelefonica');                                                
      			$this->AID = $RA['AgendaTelefonicaID'];          
                $this->FAgenda = AgendatelefonicaPeer::initialize( $this->AID , $this->IDS );      
                if(!$this->FAgenda->isNew()):
                    $this->FAgenda->getObject()->setInactiu();                                                   
                    $this->getUser()->addLogAction($this->accio,'gAgenda',$this->FAgenda->getObject());                    
                    myUser::addLogTimeline( 'baixa' , 'agenda' , $this->getUser()->getSessionPar('idU') , $this->IDS , $this->FAgenda->getObject()->getAgendatelefonicaId() );
                endif;  
                break;       
      default:                 
                $this->AGENDES = AgendatelefonicadadesPeer::doSearch( $this->CERCA['text'] , $this->IDS , $this->P );
                break;
    
    }    
    
    if(!empty($this->CERCA)):       
       $this->AGENDES = AgendatelefonicadadesPeer::doSearch( $this->CERCA['text'] , $this->IDS , $this->P );
    else:
       $this->AGENDES = array();
    endif;
        
  }  
  
  //**************************************************************************************************************************************************
  //**************************************************************************************************************************************************
    
  public function executeGMissatges(sfWebRequest $request)  
  {
  	   	
    $this->setLayout('gestio');
    $this->IDS = $this->getUser()->getSessionPar('idS');
    $this->IDU = $this->getUser()->getSessionPar('idU');
    
    //Netegem cerca
  	if($request->getParameter('accio') == 'I'):      		
        $this->CERCA = $this->getUser()->setSessionPar('cerca',array('text'=>''));    		      			      	      		
      	$this->PAGINA = $this->getUser()->setSessionPar('p',1);      	      			
      	$this->accio = $this->getUser()->setSessionPar('accio',"");      	      			       
    endif;    
    
    //Actualitzem el requadre de cerca
    $this->FCerca = new CercaForm();
    $this->FCerca->bind($request->getParameter('cerca'));          
    $this->CERCA  	= $this->getUser()->ParReqSesForm($request,'cerca',array('text'=>""));  	  	
  	$this->PAGINA	= $this->getUser()->ParReqSesForm($request,'p',1);
  	$this->accio  	= $this->getUser()->ParReqSesForm($request,'accio',"");
  	$this->MODE     = array();
    
    if($request->isMethod('POST') || $request->isMethod('GET')):
    	
    	$accio = $request->getParameter('accio');
    	if( $request->hasParameter('BCERCA') ) 		$this->accio = 'C';
	    if( $request->hasParameter('BNOU') )  		$this->accio = 'N';
	    if( $request->hasParameter('BSAVE') ) 		$this->accio = 'S';
	    if( $request->hasParameter('BDELETE') )		$this->accio = 'D';
	    
    endif;

    $this->getUser()->setSessionPar('accio',$this->accio);
    
    switch( $this->accio )
    {
    
      //Entrem per primer cop a aquest apartat
      case 'I':      	            		
      			$this->MISSATGES = MissatgesPeer::doSearch( $this->CERCA['text'] , $this->PAGINA , false , $this->IDS );
      			$this->getUser()->addLogAction('inside','gMissatges');      			      			
      			break;
      
      case 'N':
      	
                $this->MODE['NOU'] = true;
                $this->FMissatge = MissatgesPeer::inicialitza(0 , $this->IDU , $this->IDS );                
                $this->getUser()->setSessionPar('IDM',0);           
                $this->IDU = $this->getUser()->getSessionPar('idU');   	                                                
                break;
                                                
      case 'E':
      	
                $this->MODE['EDICIO'] = true;                
                $IDM = $request->getParameter('IDM');
                $this->getUser()->setSessionPar('IDM',$IDM);
                $this->FMissatge = MissatgesPeer::inicialitza( $IDM , $this->IDU , $this->IDS );                
                $this->IDU = $this->getUser()->getSessionPar('idU');                      
                break;
                
      case 'S':
      			      			
      			$IDM = $this->getUser()->getSessionPar('IDM');
      			$this->FMissatge = MissatgesPeer::inicialitza($IDM , $this->IDU , $this->IDS );                
                $this->FMissatge->bind($request->getParameter('missatges'));                
                if ($this->FMissatge->isValid()) { 
                	$this->FMissatge->save();
                	$this->getUser()->addLogAction($accio,'gMisatges',$this->FMissatge->getObject());                    
                    myUser::addLogTimeline( 'alta' , 'taulell' , $this->getUser()->getSessionPar('idU') , $this->IDS , $this->FMissatge->getObject()->getMissatgeid() );
                    
                    //Si el missatge és global, enviarem un mail a tothom. 
                    if($this->FMissatge->getObject()->getIsglobal()):
                        $ADMIN = OptionsPeer::getString('MAIL_ADMIN',$this->IDS); //Carreguem el correu de l'administrador                    
                        $OM = $this->FMissatge->getObject(); //Carreguem el missatge que hem entrat                        
                        $MAILS = UsuarisPeer::getAdminMails(); //Carreguem els mails dels administradors
                        $BODY = OptionsPeer::getString('BODY_MAIL_MISSATGE_GLOBAL',$this->IDS);
                        $BODY = str_replace('{NOM}',$OM->getUsuaris()->getNomComplet(),$BODY);
                        $BODY = str_replace('{SITE}',$OM->getSiteNom(),$BODY);
                        $BODY = str_replace('{ENLLAC}',$this->getController()->genUrl('gestio/gMissatges?accio=E&IDM='.$OM->getMissatgeid(),true),$BODY);
                        $SUBJECT = 'Hospici : Nou missatge global';
                        self::sendMail($ADMIN,$MAILS,$SUBJECT,$BODY); //Enviem el missatge.                        
                    endif;

                	$this->redirect('gestio/gMissatges?accio=I'); 
                    
                }                              	                                                                                
                $this->MODE['EDICIO'] = true;              
                break;
      case 'D':
      			$this->IDM = $this->getUser()->getSessionPar('IDM');                
                $M = MissatgesPeer::retrieveByPK($this->IDM);
                if($M instanceof Missatges) { 
                    $M->setActiu(false); 
                    $M->save(); 
                    $this->getUser()->addLogAction($accio,'gMisatges',$M);
                    myUser::addLogTimeline( 'baixa' , 'taulell' , $this->getUser()->getSessionPar('idU') , $this->IDS , $this->IDM ); 
                }
                $this->redirect('gestio/gMissatges?accio=I');                
                break;
      case 'SF':
      			$this->MISSATGES = MissatgesPeer::doSearch( $this->CERCA['text'] , $this->PAGINA , true , $this->IDS );      			
      			break;
      default: 
                $this->MISSATGE = new Missatges();
                $this->getUser()->setSessionPar('IDM',0);
                $this->MISSATGES = MissatgesPeer::doSearch( $this->CERCA['text'] , $this->PAGINA , false , $this->IDS );
                break;
    
    }
        
  }
    
  //**************************************************************************************************************************************************
  //**************************************************************************************************************************************************
    
  public function existeixAtributArray($nom,$default)
  {
  	
  	$existeix = true;
  	
  	foreach($default as $K=>$V):
  	
  		if(!$this->getUser()->hasAttribute($nom.$K)):
  		
  			$existeix = false;
  			
  		endif;
  		
  	endforeach;
  	
  	return $existeix;
  	  
  }
  
  //Guardem els valors de l'array amb Default[$K]=>$V --> $NOM.$K
  //Exemple: $this->getUser()->ParReqSesForm($request,'cerca',array('text'=>""));
/*  public function ParReqSesForm($request, $nomCamp, $default = "") 
  {
  	  	  	
  	$RET = ""; 	    	
  	
	//Si hi ha paràmetre per post, el guardem.
  	if($request->hasParameter($nomCamp)):
  		  			  			  			  		  		  		
  		$sessio = $this->getUser()->getSessionPar($nomCamp,$default);
  	    $temp = $request->getParameter($nomCamp);
  	    var_dump($temp);  		
  	    $sessio = $temp;
  		$this->getUser()->setSessionPar($nomCamp,$sessio);  		
  		$RET = $request->getParameter($nomCamp);
  		
  		echo 'El paràmetre '.$nomCamp.' existeix i hi posem el valor: '.$temp.' i retorna '.$RET.'<br />';  		
  
  	//Si no hi ha paràmetre a POST però el tenim a SESSIÓ
  	elseif($this->getUser()->hasAttribute($nomCamp)):	  		  		
  		$RET = $this->getUser()->getSessionPar($nomCamp);
  		
  		echo 'L\'atribut de sessió existeix '.$nomCamp.' i té el valor: '.$RET.'<br />';	  		
  			  		
  	//Si no hi ha SESSIÓ ni POST 
  	else:
  	 	  		  		
  		$this->getUser()->setSessionPar($nomCamp, $default);	  			  	
  		$RET = $default;
  		
  		echo 'Entrem pel valor per defecte del camp '.$nomCamp.' i hi posem el valor: '.$RET.'<br />';
  		
  	endif;
	  	
  	return $RET;
  }
  
  public function ParSesForm($valor, $nomCamp, $default = "") 
  {

  	$RET = ""; 	    	
  	   	
  	if($this->getUser()->hasAttribute($nomCamp)):
  		$RET = $this->getUser()->getSessionPar($nomCamp); 
  	else:   	
  		$this->getUser()->setSessionPar($nomCamp, $default);
  		$RET = $default;
  	endif;
  	
  	return $RET;
  }
  
*/  
  
  /**
   * GestiÃ³ de l'inventari i del material
   * In:  PAGINA , TIPUS, BCERCA, BNOU, BSAVE, BDELETE, IDM , D
   * Out: MATERIAL , MATERIALS , IDM 
   * 
   */
  
  public function executeGMaterial(sfWebRequest $request)  
  {
    
    $this->setLayout('gestio');   
    $this->IDS = $this->getUser()->getSessionPar('idS'); 
        
    $this->PAGINA = $this->getUser()->ParReqSesForm($request,'PAGINA',1);
    $this->CERCA = $this->getUser()->ParReqSesForm($request,'cerca',array('text'=>1));        
    $this->TIPUS = $this->CERCA['text'];
    
    //Inicialitzem el formulari de cerca
    $this->FCerca = new CercaChoiceForm();
    $this->FCerca->setChoice(MaterialgenericPeer::select($this->IDS));    
	$this->FCerca->bind(array('text'=>$this->TIPUS));	
	
	//Inicialitzem variables
    $this->CONSULTA = true; 
    $this->NOU = false; 
    $this->EDICIO = false;

    
    if($request->isMethod('POST') || $request->isMethod('GET')):
	    $accio = $request->getParameter('accio');
	    if($request->hasParameter('BCERCA'))    $accio = 'C';
	    if($request->hasParameter('BNOU')) 	    $accio = 'N';
	    if($request->hasParameter('BSAVE')) 	$accio = 'S';	    
	    if($request->hasParameter('BDELETE')) 	$accio = 'D';
	endif;                
	
    switch($accio){
    	case 'C':
    		   	$this->getUser()->addLogAction('inside','gMaterial');
    			break;
    	case 'N':
                $this->FMaterial = MaterialPeer::inicialitza( 0 , $this->TIPUS , $this->IDS );    			    			    			    			
    			$this->NOU = true;    			
    		break;
    	case 'E':    			
    			$this->IDM = $request->getParameter('IDM');                
                $this->FMaterial = MaterialPeer::inicialitza( $this->IDM , $this->TIPUS , $this->IDS );                    			   			
    			$this->EDICIO = true;
    		break;
    	case 'S':
                $PM = $request->getParameter('material');
                $this->FMaterial = MaterialPeer::inicialitza( $PM['idMaterial'] , $this->TIPUS , $this->IDS );                                    			
    		    $this->FMaterial->bind($PM);
    		    if($this->FMaterial->isValid()):
    		    	$this->FMaterial->save();
                    
    		    	$this->getUser()->addLogAction($accio,'gMaterial',$this->FMaterial->getObject());                    
                    myUser::addLogTimeline( 'alta' , 'material' , $this->getUser()->getSessionPar('idU') , $this->IDS , $this->FMaterial->getObject()->getIdmaterial() );
                    
    		    	$this->redirect('gestio/gMaterial?accio=C');
    		    endif;     		        		    
    			$this->EDICIO = true;
    		break;
    	case 'D':
                $PM = $request->getParameter('material');
                $this->FMaterial = MaterialPeer::inicialitza( $PM['idMaterial'] , $this->TIPUS , $this->IDS );
                $OM = $this->FMaterial->getObject();
                if(!$OM->isNew()):
                    $OM->setActiu(false);
                    $OM->save(); 
                    $this->getUser()->addLogAction($accio,'gMaterial',$OM);
                    myUser::addLogTimeline( 'baixa' , 'material' , $this->getUser()->getSessionPar('idU') , $this->IDS , $PM['idMaterial'] );
                endif;                     	                            	            	          	        
    	        break;    	
        case 'AJAX_NEW_GRUP':
                $PM = $request->getParameter('GRUP');
                $OMG = MaterialgenericPeer::initialize(0,$this->IDS)->getObject();
                $OMG->setNom($PM);
                $OMG->save();
                return $this->renderText('Tot ok. ');                
            break;         	 
        case 'PRINT_ALTA':
        
                    $doc = new sfTinyDoc();
                    
                    $url_prop = OptionsPeer::getString('SF_WEBSYSROOT',$this->IDS).'documents/FullInventariAlta'.$this->IDS.'.docx';
                    $url_gen = OptionsPeer::getString('SF_WEBSYSROOT',$this->IDS).'documents/FullInventariAlta1.docx';
                    if(file_exists($url_prop)) $doc->createFrom($url_prop);
                    else $doc->createFrom($url_gen);
                                                          
                    //Carreguem l'article que volem imprimir.
                    $idM = $request->getParameter('IDM');
                    $OM = MaterialPeer::retrieveByPK($idM);
                    if($OM instanceof Material):
                    
                        $OU = UsuarisPeer::retrieveByPK($OM->getResponsable());
                    
                        $doc->loadXml('word/document.xml');
                        
                        $doc->mergeXmlField( 'grup'                     ,   $OM->getMaterialgeneric()->getNom()   );
                        $doc->mergeXmlField( 'identificador'            ,   $OM->getIdentificador()               );
                        $doc->mergeXmlField( 'identificador_comptable'  ,   $OM->getIdentificadorcomptable() );
                        $doc->mergeXmlField( 'nom'                      ,   $OM->getNom() );
                        $doc->mergeXmlField( 'ubicacio'                 ,   $OM->getUbicacio() );
                        $doc->mergeXmlField('responsable'               ,   $OU->getNomComplet() );
                        $doc->mergeXmlField('descripcio'                ,   $OM->getDescripcio());
                        $doc->mergeXmlField('num_serie'                 ,   $OM->getNumserie());
                        $doc->mergeXmlField('data_compra'               ,   $OM->getDatacompra('d/m/Y'));
                        $doc->mergeXmlField('data_garantia'             ,   $OM->getDatagarantia('d/m/Y'));
                        $doc->mergeXmlField('data_revisio'              ,   $OM->getDatarevisio('d/m/Y'));
                        $doc->mergeXmlField('num_factura'               ,   $OM->getNumfactura());
                        $doc->mergeXmlField('proveidor'                 ,   $OM->getProveidor());
                        $doc->mergeXmlField('preu'                      ,   $OM->getPreu());
                        $doc->mergeXmlField('amortitzacio'              ,   $OM->getAmortitzacio());
                        $doc->mergeXmlField('vida_util'                 ,   $OM->getVidautil());
                        $doc->mergeXmlField('notes'                     ,   $OM->getNotesmanteniment());
                        $doc->mergeXmlField('data_avui'                 ,   date('d/m/Y'));
                        
        				$doc->saveXml();
        				$doc->close();
        				$doc->sendResponse();
        				$doc->remove();
        				
        				throw new sfStopException;
                    
                    else: 
                    
                        echo "No he pogut trobar l'element a l'inventari. Torna a provar-ho! ";
                                        
                    endif;
        
            break;
            
        case 'PRINT_BAIXA':
        
            $doc = new sfTinyDoc();
                    
                    $url_prop = OptionsPeer::getString('SF_WEBSYSROOT',$this->IDS).'documents/FullInventariBaixa'.$this->IDS.'.docx';
                    $url_gen = OptionsPeer::getString('SF_WEBSYSROOT',$this->IDS).'documents/FullInventariBaixa1.docx';
                    if(file_exists($url_prop)) $doc->createFrom($url_prop);
                    else $doc->createFrom($url_gen);
                                                          
                    //Carreguem l'article que volem imprimir.
                    $idM = $request->getParameter('IDM');
                    $OM = MaterialPeer::retrieveByPK($idM);
                    if($OM instanceof Material):
                    
                        $OU = UsuarisPeer::retrieveByPK($OM->getResponsable());
                        
                        $diferencia_segons = $OM->getDatabaixa('U') - $OM->getDatacompra('U');
                        $dies = $diferencia_segons / (60 * 60 * 24);                        
                        $dism_diaria = floatval($OM->getAmortitzacio())/(365*100);
                        $total_amortitzat = intval($OM->getPreu() * ( $dies * $dism_diaria ));                                                                        
                    
                        $doc->loadXml('word/document.xml');
                        
                        $doc->mergeXmlField( 'grup'                     ,   $OM->getMaterialgeneric()->getNom()   );
                        $doc->mergeXmlField( 'identificador'            ,   $OM->getIdentificador()               );
                        $doc->mergeXmlField( 'identificador_comptable'  ,   $OM->getIdentificadorcomptable() );
                        $doc->mergeXmlField( 'nom'                      ,   $OM->getNom() );
                        $doc->mergeXmlField( 'ubicacio'                 ,   $OM->getUbicacio() );
                        $doc->mergeXmlField('responsable'               ,   $OU->getNomComplet() );                        
                        $doc->mergeXmlField('num_serie'                 ,   $OM->getNumserie());
                        $doc->mergeXmlField('data_compra'               ,   $OM->getDatacompra('d/m/Y'));                                                                                                
                        $doc->mergeXmlField('data_baixa'                ,   $OM->getDatabaixa('d/m/Y'));
                        $doc->mergeXmlField('preu_inicial'              ,   $OM->getPreu());
                        $doc->mergeXmlField('total_amortitzat'          ,   $total_amortitzat );
                        $doc->mergeXmlField('valor_actual'              ,   $OM->getPreu() - $total_amortitzat );
                        $doc->mergeXmlField('notes'                     ,   $OM->getNotesmanteniment());
                        $doc->mergeXmlField('data_avui'                 ,   date('d/m/Y'));
                        
        				$doc->saveXml();
        				$doc->close();
        				$doc->sendResponse();
        				$doc->remove();
        				
        				throw new sfStopException;
                    
                    else: 
                    
                        echo "No he pogut trobar l'element a l'inventari. Torna a provar-ho! ";
                                        
                    endif;
        
            break;
    }
        
    $this->MATERIALS = MaterialPeer::getMaterial($this->TIPUS, $this->PAGINA , $this->IDS );
    
  }
    
  //**************************************************************************************************************************************************
  //**************************************************************************************************************************************************
    
  public function executeGCursos(sfWebRequest $request)  
  {

	$this->setLayout('gestio');
    $this->IDS = $this->getUser()->getSessionPar('idS');

	//Netegem cerca
  	if($request->getParameter('accio') == 'C'):
        $this->CERCA = $this->getUser()->setSessionPar('cerca',array('text'=>'','select'=>1));
      	$this->PAGINA = $this->getUser()->setSessionPar('pagina',1);
        $this->redirect('gestio/gCursos?accio=CA');      			       
    endif;    
		
    $this->CERCA  = $this->getUser()->ParReqSesForm($request,'cerca',array('text'=>'','select'=>1));
    $this->PAGINA = $this->getUser()->ParReqSesForm($request,'PAGINA',1);
    $accio  = $this->getUser()->ParReqSesForm($request,'accio','CA');    
    
    //Inicialitzem el formulari de cerca
    $this->FCerca = new CercaTextChoiceForm();       
    $this->FCerca->setChoice(array(1=>'Matrícula oberta',2=>'Matrícula tancada')); 
	$this->FCerca->bind($this->CERCA);
	
	//Inicialitzem variables
	$this->MODE = '';

    if($request->isMethod('POST')){
	    if($request->hasParameter('BCERCA')) { 			    $accio = ( $this->CERCA['select'] == 1 )?'CA':'CI'; $this->PAGINA = 1; }   
	    elseif($request->hasParameter('BNOU')) 	    	    $accio = 'NC';
	    elseif($request->hasParameter('BSAVECODICURS'))     $accio = 'SC';
	    elseif($request->hasParameter('BSAVE'))     	    $accio = 'SCC';	    
	    elseif($request->hasParameter('BDELETE'))     	    $accio = 'D';
        elseif($request->hasParameter('BGENERAACTIVITAT'))  $accio = 'GA';
        
    }                
    
    //Aquest petit bloc és per si es modifica amb un POST el que s'ha enviat per GET
    $this->getUser()->setSessionPar('accio',$accio);
    $this->getUser()->setSessionPar('PAGINA',$this->PAGINA);   //Guardem la pÃ gina per si hem fet una consulta nova  
            
    switch($accio){
    	
    	//Entrem un curs nou. Agafarem el codi per fer-ne un duplicat o bé un codi nou.
    	case 'NC':    			    				    			    			
    			$this->getUser()->setSessionPar('IDC',null);                
    			$OCurs = new Cursos();    			     			
				$this->FCursCodi = new CursosCodiForm($OCurs,array('IDS'=>$this->IDS));
				$this->MODE = 'NOU';
    		break;

		//Si el codi existeix, carrego les dades, altrament només guardo.    		
    	case 'SC':
				$RP = $request->getParameter('cursos_codi'); 			                				
				$codi = ($RP['CodiT'] != "")?$RP['CodiT']:$RP['Codi']; 				
				$this->OC = CursosPeer::getCopyCursByCodi( $codi , $this->IDS );                      			                                                    			    			    		    		        		        		        		    
				$this->MODE = 'EDICIO_CONTINGUT';       		    	   		    	     		        		        		        		        			
    		break;    		
    		
    	//Editem un curs que ja existeix. 
    	case 'EC':                
                $this->OC = CursosPeer::retrieveByPK($request->getParameter('IDC'));    			    			    							 			
    			$this->MODE = 'EDICIO_CONTINGUT';    			
    		break;
    	    		
    	//Guarda el contingut del curs
    	case 'SCC':
                        
                $RP = $request->getParameter('cursos',0);                      
                $FOC = CursosPeer::initialize($RP['idCursos'] , $this->IDS );                
    		    $FOC->bind($RP);
                                
    		    if($FOC->isValid()):
                                                        
                    $FOC->updateObject();
                    $OC = $FOC->getObject();                                                            
                                        
                    //Si no s'assignen pagaments, no es pot vendre entrada
                    $OC->setPagamentExtern( implode( '@' , $RP['PagamentExtern'] ) );
                    $OC->setPagamentIntern( implode( '@' , $RP['PagamentIntern'] ) );
                    
                    //Si no hi ha cap descompte, ho deixem a 0 => Cap descompte.
                    if(empty($RP['ADescomptes'])) $OC->setAdescomptes( implode( '@' , array(0) ) );
                    else $OC->setAdescomptes( implode( '@' , $RP['ADescomptes'] ) );
                    $OC->save();
                    
                    //Si guardem el curs per primera vegada, mirem les imatges que s'han entrat i que no tenen curs. Les assignarem a aquest.
                    $dir = getcwd().'/images/cicles/';
                    $mini = false; $normal = false; $big = false; $pdf = false; 
                    $IDC = $OC->getIdcursos();
                    foreach ( glob( $dir.'C--*' ) as $K => $arxiu ) {
                        $a = str_replace( $dir , "", $arxiu );
                        //Si té un -M és la foto mini.
                        if( substr_count( $arxiu , "-M" ) > 0)      rename( $arxiu , str_replace( '--' , '-'.$IDC.'-' , $arxiu ) );
                        if( substr_count( $arxiu , "-L" ) > 0)      rename( $arxiu , str_replace( '--' , '-'.$IDC.'-' , $arxiu ) );
                        if( substr_count( $arxiu , "-XL" ) > 0)     rename( $arxiu , str_replace( '--' , '-'.$IDC.'-' , $arxiu ) );
                        if( substr_count( $arxiu , "-PDF" ) > 0)    rename( $arxiu , str_replace( '--' , '-'.$IDC.'-' , $arxiu ) );
                    }          		    	    		    	
                    
                    $this->OC = $OC;                    
                    $this->getUser()->addLogAction($accio,'gCursos',$OC->getIdcursos());
                    if($RP['idCursos'] > 0 ) myUser::addLogTimeline( 'alta' , 'cursos' , $this->getUser()->getSessionPar('idU') , $this->IDS , $OC->getIdcursos() );
                    else myUser::addLogTimeline( 'modificació' , 'cursos' , $this->getUser()->getSessionPar('idU') , $this->IDS , $OC->getIdcursos() );
                    
                else:
                                                         
                    $this->OC = $FOC->getObject();
                                        		    	     		    
    		    endif;    		        		    
    			$this->MODE = 'EDICIO_CONTINGUT';
                
    		break;
    	//Esborra un curs	
    	case 'D': 
                $RP = $request->getParameter('cursos');
                $this->FCurs = CursosPeer::initialize( $RP['idCursos'] , $this->IDS );
                $this->FCurs->getObject()->setActiu(false)->save();                            			    			
 				$this->getUser()->addLogAction($accio,'gCursos',$this->FCurs->getObject());
                 myUser::addLogTimeline( 'baixa' , 'cursos' , $this->getUser()->getSessionPar('idU') , $this->IDS , $RP['idCursos'] );    	        					
				$this->redirect('gestio/gCursos?accio=CA');
    	    break;
		case 'CI' :	
				$this->CURSOS = CursosPeer::getCursos(CursosPeer::PASSAT , $this->PAGINA , $this->CERCA['text'] , $this->IDS );
				$this->MODE = 'CI';				 
			break;		
		case 'CA' :				
				$this->CURSOS = CursosPeer::getCursos(CursosPeer::CURSACTIU , $this->PAGINA , $this->CERCA['text'] , $this->IDS );				
				$this->MODE = 'CA';
			break;					
		case 'L': 
				$this->MATRICULES = CursosPeer::getMatricules($request->getParameter('IDC') , $this->IDS , true , true , true );
                $this->IDC = $request->getParameter('IDC');
				$this->MODE = 'LLISTAT_ALUMNES'; 
			break;

		case 'C':
				$this->getUser()->addLogAction('inside','gCursos');
			break;
            
        //Edita una activitat relacionada amb un curs. Si no en té cap l'afegeix. '
        case 'GA' :
                //Mirem si ja té activitat. Si la té la recupera i sinó la crea. 
                $RP = $request->getParameter('cursos');
                $this->FCurs = CursosPeer::initialize( $RP['idCursos'] , $this->IDS );
                if($this->FCurs->isNew()){ //Si el curs és nou, vol dir que l'hem de guardar.
        		    $this->FCurs->bind($RP);                
        		    if($this->FCurs->isValid()):                    
        		    	$this->FCurs->save();
        		    	$this->getUser()->addLogAction($accio,'gCursos',$this->FCurs->getObject());
        		    endif;    		        		            			
                }
                
                //Un cop guardat el curs, recupero l'activitat relacionada amb el curs                
                $OA = $this->FCurs->getObject()->getActivitatVinculada();
                $this->redirect('gestio/gActivitats?accio=ACTIVITAT&IDA='.$OA->getActivitatid());                                				
			break;
    
        //Imprimeix un llistat dels alumnes del curs
        case 'IMPR_LLISTAT_ALUMNES_CURS':
    			
    				$IDC = $request->getParameter('IDC');
                    $OC = CursosPeer::retrieveByPK($IDC);
    				
                    //Si no existeix el curs, marxem, i sinó carreguem els alumnes.
                    if(!($OC instanceof Cursos)) $this->redirect('gestio/gCursos?accio=CC');                
                    $LMAT = CursosPeer::getMatricules( $IDC , $OC->getSiteid() , false , false );
                    
    				//Mirem si existeix un patró per nosaltres
                    $doc = new sfTinyDoc();
                    
                    $url_prop = OptionsPeer::getString('SF_WEBSYSROOT',$this->IDS).'documents/LlistatAlumnesCursos'.$OC->getSiteid().'.docx';
                    $url_gen = OptionsPeer::getString('SF_WEBSYSROOT',$this->IDS).'documents/LlistatAlumnesCursosGen.docx';
                    if(file_exists($url_prop)) $doc->createFrom($url_prop);
                    else $doc->createFrom($url_gen);
                                                          
                    //Comença la càrrega de la informació                                                     
                    $alumnes = array();
                    $i = 1;
                    foreach($LMAT as $OM):
                        $OU = $OM->getUsuaris();
                        $alumnes[$i++]['nom'] = $OU->getNomComplet();                                                
                    endforeach;
                       
                    
                    $doc->loadXml('word/document.xml');
                    $doc->mergeXmlField('curs',$OC->getTitolcurs());                                          
                    $doc->mergeXmlField('datallistat',date('d/m/Y',time()));
                    $doc->mergeXmlBlock('lalumnes', $alumnes);                                				                    
                    
    				$doc->saveXml();
    				$doc->close();
    				$doc->sendResponse();
    				$doc->remove();
    				
    				throw new sfStopException; 
         
            break;

            case 'EXCEL_ALL_CURSOS':
    			
			$doc = new PHPExcel();
            
            //Consultem tots els cursos actius i de cada un llistem els alumnes. Els que tinguin pagament amb domiciliació van a part.
            $LOC = CursosPeer::getCursos( CursosPeer::CURSACTIU , 0 , "" , $this->IDS , false , null , null );
            
            $fila = 1; $columna = 0;
            
            foreach($LOC as $OC):                
                foreach( CursosPeer::getMatricules( $OC->getIdcursos() , $this->IDS , true , false ) as $OM ):
                    $OU = $OM->getUsuaris();
                    if($OU instanceof Usuaris && $OM instanceof Matricules):                                         
                        $doc->getActiveSheet()->setCellValueByColumnAndRow( $columna+0  , $fila , $OC->getIdcursos() );
                        $doc->getActiveSheet()->setCellValueByColumnAndRow( $columna+1  , $fila , $OC->getCodi() );
                        $doc->getActiveSheet()->setCellValueByColumnAndRow( $columna+2  , $fila , $OC->getTitolcurs() );
                        $doc->getActiveSheet()->setCellValueByColumnAndRow( $columna+3  , $fila , $OU->getDni() );
                        $doc->getActiveSheet()->setCellValueByColumnAndRow( $columna+4  , $fila , $OU->getNomComplet() );
                        $doc->getActiveSheet()->setCellValueByColumnAndRow( $columna+5  , $fila , $OM->getPagat() );
                        $doc->getActiveSheet()->setCellValueByColumnAndRow( $columna+6  , $fila , $OM->getTPagamentString() );
                        $doc->getActiveSheet()->setCellValueByColumnAndRow( $columna+7  , $fila , $OM->getTreduccioString() );
                        $doc->getActiveSheet()->setCellValueByColumnAndRow( $columna+8  , $fila , $OM->getEstatString() );
                        $doc->getActiveSheet()->setCellValueByColumnAndRow( $columna+9  , $fila , (string)$OM->getCcc() );
                        $doc->getActiveSheet()->setCellValueByColumnAndRow( $columna+10 , $fila , $OM->getComentari() );
                        
                        $doc->getActiveSheet()->setCellValueByColumnAndRow( $columna+11 , $fila , $OU->getTelefonString() );
                        $doc->getActiveSheet()->setCellValueByColumnAndRow( $columna+12 , $fila , $OU->getMobil() );
                        $doc->getActiveSheet()->setCellValueByColumnAndRow( $columna+13 , $fila , $OU->getEmail() );
                        $doc->getActiveSheet()->setCellValueByColumnAndRow( $columna+14 , $fila , $OU->getDataNaixement('d-m-Y') );
                        $doc->getActiveSheet()->setCellValueByColumnAndRow( $columna+15 , $fila , $OU->getAdreca() );
                        $doc->getActiveSheet()->setCellValueByColumnAndRow( $columna+16 , $fila , $OU->getCodipostal() );
                        $doc->getActiveSheet()->setCellValueByColumnAndRow( $columna+17 , $fila++ , $OU->getPoblacioString() );                        
                                                                        
                    endif;
                endforeach;
            endforeach;            																
           						
			$nom = OptionsPeer::getString('SF_WEBSYSROOT').'tmp/'.$this->IDS.'CURSOS.xlsx';
			$web = OptionsPeer::getString('SF_WEBROOT').'tmp/'.$this->IDS.'CURSOS.xlsx';
			
			$objWriter = PHPExcel_IOFactory::createWriter($doc, 'Excel2007');			
			$objWriter->save($nom);
									
			$response = sfContext::getInstance()->getResponse();
    	    $response->setContentType('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            $response->setHttpHeader('Content-Disposition', 'attachment; filename="Excel_Categoria.xlsx');
            $response->setHttpHeader('Content-Length', filesize($nom));
            $response->setContent(file_get_contents($nom, false));
            $response->sendHttpHeaders();
            $response->sendContent();												
					
			throw new sfStopException;			   	  	 
                
            break;
            
            case 'FITXER_N19':
            
                $aeb19 = new AEB19Writter('.');
                //Número de compte de l'entitat que genera els rebuts.
                $cuenta = explode('-',OptionsPeer::getString('N19_CCC',$this->IDS));                                
                //CIF de la nostra entitat. 
                $cif = OptionsPeer::getString('N19_CIF',$this->IDS);
                //Nom de la nostra entitat
                $empresa = OptionsPeer::getString('N19_NOM_EMPRESA',$this->IDS);
                
                //Assignem els noms del presentador
                //El codi del presentador s'ha de presentar a la dreta així que ho fem manualment. 
                $aeb19->insertarCampo('codigo_presentador', str_pad($cif, 12, '0', STR_PAD_RIGHT));
                $aeb19->insertarCampo('fecha_fichero', date('dmy'));
                $aeb19->insertarCampo('nombre_presentador', $empresa);
                $aeb19->insertarCampo('entidad_receptora', $cuenta[0]);
                $aeb19->insertarCampo('oficina_presentador', $cuenta[1]);
                
                //La data del càrrec, que serà després de dos dies. 
                $fechaCargo = date('dmy', strtotime('+2 day'));
                
                //Assignem els camps de l'ordenant i guardem el registre. 
                $aeb19->insertarCampo('codigo_ordenante', str_pad($cif, 12, '0', STR_PAD_RIGHT));
                $aeb19->insertarCampo('fecha_cargo', $fechaCargo);
                $aeb19->insertarCampo('nombre_ordenante', $empresa);
                $aeb19->insertarCampo('cuenta_abono_ordenante', implode('', $cuenta));
                $aeb19->guardarRegistro('ordenante');
                
                //Establim el codi de l'ordenant pels registres obligatoris.
                $aeb19->insertarCampo('ordenante_domiciliacion' , str_pad($cif, 12, '0', STR_PAD_RIGHT));


                //Carreguem els cursos actius i només tractarem els que tinguin domiciliació. 
                $LOC = CursosPeer::getCursos(CursosPeer::CURSACTIU,1,"",$this->IDS,false,null,null);
                                                
                foreach($LOC as $OC):
                    if($OC->getIsentrada() == CursosPeer::TIPUS_PAGAMENT_DOMICILIACIO):                
                        foreach( CursosPeer::getMatricules( $OC->getIdcursos() , $this->IDS , false , false ) as $OM ):
                            $OU = $OM->getUsuaris();                            
                            $ODB = DadesBancariesPeer::retrieveByPK($OM->getIddadesbancaries());
                            $idFact = $OM->getIdmatricules();
                            if($OU instanceof Usuaris && $OM instanceof Matricules && $ODB instanceof DadesBancaries):
                                                                                                                                                 
                                //l'IVA que aplicarem a la factura 
                                $iva = 0.0;
                                $pagat = $OM->getPagat();
                                //L'Import de l'IVA
                                $importeIva = round($i * $iva, 2);
                                //Total de la factura amb IVA inclòs
                                $totalFactura = $pagat + $importeIva;
                                
                                //Con el codigo_referencia_domiciliacion podremos referenciar la domiciliación
                                $aeb19->insertarCampo('codigo_referencia_domiciliacion', "fra-$idFact");
                                //Cliente al que le domiciliamos
                                $aeb19->insertarCampo('nombre_cliente_domiciliacion', $ODB->getTitular() );
                                //Cuenta del cliente en la que se domiciliará la factura
                                $aeb19->insertarCampo('cuenta_adeudo_cliente', $ODB->getCcc());
                                //El importe de la domiciliación (tiene que ser en céntimos de euro y con el IVA aplicado)
                                $aeb19->insertarCampo('importe_domiciliacion', ($totalFactura * 100));
                                //Código para asociar la devolución en caso de que ocurra
                                $aeb19->insertarCampo('codigo_devolucion_domiciliacion', $OM->getIdmatricules() );
                                //Código interno para saber a qué corresponde la domiciliación
                                $aeb19->insertarCampo('codigo_referencia_interna', "fra-$idFact");
                    
                                //Preparamos los conceptos de la domiciliación, en un array
                                //Disponemos de 80 caracteres por línea (elemento del array). Más caracteres serán cortados
                                //El índice 8 y 9 contendrían el sexto registro opcional, que es distinto a los demás
                                $conceptosDom = array();
                                //Los dos primeros índices serán el primer registro opcional
                                $conceptosDom[] = str_pad("Pagament matrícula $idFact", 40, ' ', STR_PAD_RIGHT) . str_pad(" del curs {$OC->getCodi()}", 40, ' ', STR_PAD_RIGHT);                                
                                //$conceptosDom[] = str_pad('', 40, ' ', STR_PAD_RIGHT) . str_pad("", 40, ' ', STR_PAD_RIGHT);
                                //Los dos segundos índices serán el segundo registro opcional
                                //$conceptosDom[] = str_pad( $ODB->getTitular() , 40, ' ', STR_PAD_RIGHT);
                                //$conceptosDom[] = str_pad('', 40, ' ', STR_PAD_RIGHT) . 'Base imposable:' . str_pad(number_format($pagat, 2, ',', '.') . ' EUR', 25, ' ', STR_PAD_LEFT);
                                //Los dos terceros índices serán el tercer registro opcional
                                //$conceptosDom[] = str_pad('', 40, ' ', STR_PAD_RIGHT).
                                 //   'IVA ' . str_pad(number_format($iva * 100, 2, ',', '.'), 2, '0', STR_PAD_LEFT) . '%:'.
                                 //   str_pad(number_format($importeIva, 2, ',', '.') . ' EUR', 29, ' ', STR_PAD_LEFT);
                                //$conceptosDom[] = str_pad('', 40, ' ', STR_PAD_RIGHT).
                                //    'Total:' . str_pad(number_format($totalFactura, 2, ',', '.') . ' EUR', 34, ' ', STR_PAD_LEFT);                                                                                                        
                    
                                //Añadimos la domiciliación
                                $aeb19->guardarRegistro('domiciliacion', $conceptosDom);
                            else: 
                                if(!($OU instanceof Usuaris)) $RET[$idFact][] = "Matrícula $idFact incorrecte. Usuari no trobat."; 
                                if(!($OM instanceof Matricules)) $RET[$idFact][] = "Matrícula $idFact incorrecte. Matrícula no trobada.";
                                if(!($ODB instanceof DadesBancaries)) $RET[$idFact][] = "Matrícula $idFact incorrecte. Compte corrent no trobat.";
                                
                            endif;
                            
                        endforeach;
                    endif;
                endforeach;
                
      			$nom = OptionsPeer::getString('SF_WEBSYSROOT').'tmp/'.$this->IDS.'REBUTS.txt';
                fwrite( fopen( $nom , 'w' ) , $aeb19->construirArchivo() );
                $response = sfContext::getInstance()->getResponse();
        	    $response->setContentType('text/plain');
                $response->setHttpHeader('Content-Disposition', 'attachment; filename="Rebuts_Domiciliacio.txt');
                $response->setHttpHeader('Content-Length', filesize($nom));
                $response->setContent(file_get_contents($nom, false));
                $response->sendHttpHeaders();
                $response->sendContent();                                							
     					
    			throw new sfStopException;                			   	  	 
                       
            break;
            

    }                       
    
  }
	 	  
  public function executeGReserves(sfWebRequest $request)
  {
  	
    $this->setLayout('gestio');
    $this->IDS = $this->getUser()->getSessionPar('idS');
        
  	//Netegem cerca
//  	if($request->getParameter('accio') == 'C'):              		
//        $this->CERCA = $this->getUser()->setSessionPar('cerca',array('text'=>'','select'=>'0'));    		      			      	      		
//      	$this->PAGINA = $this->getUser()->setSessionPar('pagina',1);
//    endif;    
        
    $PAGINA = $this->getUser()->ParReqSesForm($request,'P',1);    
    $this->CERCA  = $this->getUser()->ParReqSesForm($request,'cerca',array('text'=>'','select'=>'0'));    
    
    //Inicialitzem el formulari de cerca
    $this->FCerca = new CercaTextChoiceForm();    
    $RET = ReservaespaisPeer::selectEstat();  
    $RET[-1] = 'Totes les reserves';          
    $this->FCerca->setChoice($RET);
	$this->FCerca->bind($this->CERCA);
	
	//Inicialitzem variables
	$this->MODE = array('CONSULTA'=>true,'NOU'=>false,'EDICIO'=>false);
        
    if($request->isMethod('POST') || $request->isMethod('GET')):
	    $accio = $request->getParameter('accio');
	    if($request->hasParameter('BCERCA'))    $accio = 'C';
	    if($request->hasParameter('BNOU')) 	    $accio = 'N';
	    if($request->hasParameter('BSAVE')) 	$accio = 'S';
	    if($request->hasParameter('BDELETE')) 	$accio = 'D';
        if($request->hasParameter('SEND_RESOLUTION')) $accio = "SR";
	endif;                
	
    switch($accio){
    	case 'N':
                $this->FReserva = ReservaespaisPeer::initialize( 0 , $this->IDS );    			
    			$this->MODE['NOU'] = true;
    		break;
            
    	case 'E':                
                $this->FReserva = ReservaespaisPeer::initialize( $request->getParameter('IDR') , $this->IDS );                				
    			$this->MODE['EDICIO'] = true;
    		break;
            
    	case 'S':    	
                if($this->saveReservaEspais($request,$accio)) $this->redirect('gestio/gReserves?accio=C');
    			$this->MODE['EDICIO'] = true;
    		break;
            
    	case 'D': 
                $OR = ReservaespaisPeer::initialize($this->IDR,$this->IDS)->getObject();                
    	        $OR->setEstat(ReservaespaisPeer::ESBORRADA);
                $OR->save();                                
    	        $this->getUser()->addLogAction($accio,'gReserves',$OR);    	        
    	        break;    	 
    	case 'C':
				$this->getUser()->addLogAction('inside','gReserves');                
    			break;
       
        //Guardo el formulari amb els canvis i envio un correu amb les condicions. 
        case 'SR':
        
            $RP = $request->getParameter('reservaespais');
            $this->FReserva = ReservaespaisPeer::initialize($RP['ReservaEspaiID'],$this->IDS);        	    		        		  	    
    	    $this->FReserva->bind($RP);    	            	    
    	    if($this->FReserva->isValid())
            {
                $this->FReserva->save();
                $OR = $this->FReserva->getObject();
                //El poso en pendent de confirmació per mail o web
                $OR->setEstat(ReservaespaisPeer::PENDENT_CONFIRMACIO);
                $OR->save();
                
                //Generem i enviem el mail amb les condicions
                $this->SendMailReservaEspais($OR,$this->IDS);
                            
                //Guardem l'acció
    	    	$this->getUser()->addLogAction($accio,'gReserves',$this->FReserva);	    	                                        
             }
             else 
             {
                $this->MODE['EDICIO'] = true;
             }
            break;        	 
    }
        
    $this->RESERVES = ReservaespaisPeer::getReservesSelect( $this->CERCA['text'] , $this->CERCA['select'] , $PAGINA , $this->IDS );    
  		
  }

    private function SendMailReservaEspais( $OR , $idS , $recordatori = false ){

        //Marquem quin formulari haurà d'executar i amb quina ID
        $PARA  = Encript::Encripta(serialize(array(  'formulari' => 'Reserva_Espais_Mail_Accepta_Condicions', 
                                                     'id' => $OR->getReservaespaiid())));
        $PARR  = Encript::Encripta(serialize(array(  'formulari' => 'Reserva_Espais_Mail_Rebutja_Condicions', 
                                                     'id' => $OR->getReservaespaiid())));                                                            
                    
        //Si no podem carregar un usuari, enviem el correu a informatica@casadecultura.org                                    
        if($OR instanceof Reservaespais){
            $OU = UsuarisPeer::retrieveByPK($OR->getUsuarisUsuariid());
            if($OU instanceof Usuaris) $email = $OU->getEmail();
            else $email = 'informatica@casadecultura.org';                            
        }                                                            

        //Enviem el correu a la persona amb les condicions.
        $from = OptionsPeer::getString('MAIL_FROM',$idS);
        $subject = "Hospici :: Acceptació de condicions de reserva d'espai";
        $body = ReservaespaisPeer::sendMailCondicions( $OR , $PARA , $PARR , $idS );
        
        //Si és un recordatori, només l'enviem a la persona interessada
        if(!$recordatori) $to = array($email,OptionsPeer::getString('MAIL_SECRETARIA',$idS),OptionsPeer::getString('MAIL_ADMIN',$idS));
        else{ $to = $email; $subject = "Hospici :: Recordatori d'acceptació de condicions de reserva d'espai."; }
        
        //Enviem el mail a l'usuari, a secretaria i a l'administrador
        $this->sendMail($from , $to , $subject , $body );
               
    }


    private function saveReservaEspais($request,$accio){
        
        $RP = $request->getParameter('reservaespais');
        $this->FReserva = ReservaespaisPeer::initialize($RP['ReservaEspaiID'],$this->IDS);        	    		        		  	    
	    $this->FReserva->bind($RP);    		    
	    if($this->FReserva->isValid()):
	    	$this->FReserva->save();
	    	$this->getUser()->addLogAction($accio,'gReserves',$this->FReserva);
            myUser::addLogTimeline( 'alta' , 'reserves' , $this->getUser()->getSessionPar('idU') , $this->IDS , $RP['ReservaEspaiID'] );	    	
            return true; 
        else:
            return false;  
	    endif;        
        
    }        		        		    



  /**
   * Matrícules
   *
   */     
  public function executeGMatricules(sfWebRequest $request)
  {    	
  	  	  	
    $this->setLayout('gestio');
    $this->IDS = $this->getUser()->getSessionPar('idS');

	//Netegem cerca
  	if($request->getParameter('accio') == 'C'):      		
        $this->CERCA = $this->getUser()->setSessionPar('cerca',array('text'=>'','select'=>2));    		      			      	      		
      	$this->PAGINA = $this->getUser()->setSessionPar('pagina',1);
      	$this->redirect('gestio/gMatricules?accio=CA');      			       
    endif;    
        
    $this->CERCA  = $this->getUser()->ParReqSesForm($request,'cerca',array('text'=>"",'select'=>2));    
    $this->PAGINA = $this->getUser()->ParReqSesForm($request,'PAGINA',1);
    $accio  = $this->getUser()->ParReqSesForm($request,'accio','CA');       
    
    //Inicialitzem el formulari de cerca
    $this->FCerca = new CercaTextChoiceForm();
    $this->FCerca->setChoice(array(1=>'Cursos',2=>'Alumnes',3=>'Matrícula')); 
	$this->FCerca->bind($this->CERCA);
	
	//Inicialitzem variables
	$this->MODE = array('CONSULTA'=>false,'NOU'=>false,'EDICIO'=>false, 'LMATRICULES'=>false , 'VERIFICA' => false);

    if($request->isMethod('POST')){
	    if($request->hasParameter('BCERCA')) {
	       switch($this->CERCA['select']){
	           case 1: $accio = 'CC'; break;
               case 2: $accio = 'CA'; break;               
               case 3: $accio = 'CM'; break;
	       }
	       $this->PAGINA = 1; 
        }   
	    elseif($request->hasParameter('BNOU')) 	    	 $accio = 'NU';	    
	    elseif($request->hasParameter('BSAVENEWUSER')) 	 $accio = 'SAVE_NEW_USER';	    
	    elseif($request->hasParameter('BSELCURS')) 		 $accio = 'SNU';
	    elseif($request->hasParameter('BSAVECURS')) 	 $accio = 'SAVE_CURS';
	    elseif($request->hasParameter('BPAGAMENT')) 	 $accio = 'PAGAMENT';	    
	    elseif($request->hasParameter('BSUBMIT')) 		 $accio = 'S';
	    elseif($request->hasParameter('BDELETE')) 		 $accio = 'D';
	    elseif($request->hasParameter('BSAVE')) 		 $accio = 'SAVE_MATRICULA';
        
        elseif($request->hasParameter('BSAVEMATRICULA')) $accio = 'SAVE_NEW_MATRICULA';
    }                
    
    //Aquest petit bloc és per si es modifica amb un POST el que s'ha enviat per GET
    $this->getUser()->setSessionPar('accio',$accio);
    $this->getUser()->setSessionPar('PAGINA',$this->PAGINA);   //Guardem la pÃ gina per si hem fet una consulta nova  
    
    switch($accio){


    	// Iniciem una nova matrícula
    	case 'NU':                            						
                $this->IDM = $request->getParameter('IDM',null);                
                $this->CURSOS = MatriculesPeer::getCursosMatriculacio($this->IDS);            				    			    			    			
    			$this->MODE = 'MAT_USUARI';  	
    		break;            
            
        //Consultem els usuaris disponibles
        case 'AJAX_USUARIS':    
                $RET = UsuarisPeer::cercaTotsCampsSelect($request->getParameter('q'),$request->getParameter('lim'),$this->IDS);                                          
                return $this->renderText(json_encode($RET));                
            break;
        
        //Carreguem les dades de pagament de la matrícula
        case 'EXTRES':
        
                $OC = CursosPeer::retrieveByPK( $request->getParameter( 'IDC' ) );
                $IDU = $request->getParameter( 'IDU' );
                                    
                //Si no hem trobat el curs, retornem un error
                if( !( $OC instanceof Cursos ) ):
                
                    return $this->renderPartial('matricules',array("OC"=>new Cursos(),"RET"=>array(),"ERROR"=>"ERROR: El curs no s'ha trobat."));
                    
                //Treiem les dades extres que s'han d'entrar
                else:
                                
                    $MostraPreu = ( !$OC->isPle());
                                                                                                                                                                                                                                                                   
                    return $this->renderPartial( 'matricules' , array( "IDU" => $IDU , "OC" => $OC , "RET"=>$OC->getDescomptesArray( $MostraPreu ) , "ERROR" => "" ) );
                
                endif;
                    
            break;
    		

        //Guardem les dades de la matrícula i carreguem les dades de pagament o bé redireccionem cap a OK. 
        case 'SAVE_NEW_MATRICULA':
        
                //La matrícula pot ser amb pagament de targeta de crèdit o bé en metàl·lic.
                $RS = $request->getParameter('matricules');
                                
                $RET = MatriculesPeer::saveNewMatricula( $RS['idU'] , $RS['idC'] , "" , $RS['descompte'] , $RS['mode_pagament'] , $RS['idDadesBancaries'] );                
                
                $AVISOS = $RET['AVISOS'];                                
                                                                     			
                //Si la matrícula surt amb algun estat que no sigui tpv, fem la redirecció i mostrem el missatge. 
                if(array_key_exists('ERR_USUARI',$AVISOS)) $this->redirect('gestio/gMatricules?accio=PAGAMENT&IDM=0&MISSATGE=ERR_USUARI'); 
                elseif(array_key_exists('ERR_CURS',$AVISOS)) $this->redirect('gestio/gMatricules?accio=PAGAMENT&IDM=0&MISSATGE=ERR_CURS');
                elseif(array_key_exists('ERR_JA_TE_UNA_MATRICULA',$AVISOS)) $this->redirect('gestio/gMatricules?accio=PAGAMENT&IDM=0&MISSATGE=ERR_JA_TE_UNA_MATRICULA');
                elseif(array_key_exists('CURS_PLE',$AVISOS)) $this->redirect('gestio/gMatricules?accio=PAGAMENT&IDM='.$RET['OM']->getIdmatricules().'&MISSATGE=CURS_PLE');
                elseif(array_key_exists('CURS_PLE_LLISTA_ESPERA',$AVISOS)) $this->redirect('gestio/gMatricules?accio=PAGAMENT&IDM='.$RET['OM']->getIdmatricules().'&MISSATGE=CURS_PLE_LLISTA_ESPERA');
                elseif(array_key_exists('RESERVA_OK',$AVISOS)) $this->redirect('gestio/gMatricules?accio=PAGAMENT&IDM='.$RET['OM']->getIdmatricules().'&MISSATGE=RESERVA_OK');                
                elseif(array_key_exists('MATRICULA_METALIC_OK',$AVISOS)) $this->redirect('gestio/gMatricules?accio=PAGAMENT&IDM='.$RET['OM']->getIdmatricules().'&MISSATGE=MATRICULA_METALIC_OK');
                elseif(array_key_exists('MATRICULA_DOMICILIACIO_OK',$AVISOS)) $this->redirect('gestio/gMatricules?accio=PAGAMENT&IDM='.$RET['OM']->getIdmatricules().'&MISSATGE=MATRICULA_DOMICILIACIO_OK');
                elseif(array_key_exists('MATRICULA_CODI_BARRES',$AVISOS)) $this->redirect('gestio/gMatricules?accio=PAGAMENT&IDM='.$RET['OM']->getIdmatricules().'&MISSATGE=MATRICULA_METALIC_OK');                                
        
                //La matrícula es paga amb TPV
                if(array_key_exists('PAGAMENT_TPV',$AVISOS)):
                    $NOM  = UsuarisPeer::retrieveByPK($RET['OM']->getUsuarisUsuariid())->getNomComplet();
        			$this->TPV = MatriculesPeer::getTPV( $RET['OM']->getPagat() , $NOM , $RET['OM']->getIdmatricules() , $RET['OM']->getSiteid() , false );
                    $this->URL = OptionsPeer::getString('TPV_URL',$RET['OM']->getSiteId());                    
                    $this->setLayout('blank');
                    $this->setTemplate('pagament');                                
                endif;                                                                                
                                                                
            break;
    		    		
    	//Entenem que hem fet un pagament correcte i mostrem pantalla de finalització.  
    	case 'PAGAMENT':        
                 
                $this->IDM = $request->getParameter('IDM');                            
                $this->OM = MatriculesPeer::retrieveByPK( $this->IDM );                    			 
                $this->MISSATGE = $request->getParameter('MISSATGE');                      			
    			$this->MODE = 'PAGAMENT';                
                $this->getUser()->addLogAction($accio,'gMatricules',$this->IDM);                                
                myUser::addLogTimeline( 'alta' , 'matricules' , $this->getUser()->getSessionPar('idU') , $this->IDS , $this->IDM );
                
                 					
    		break;
            
    	//Si hem fet un pagament amb targeta, anem a la següent pantalla. El TPV serà l'encarregat de donar-li l'estat oportú. 
    	case 'OK':        
              $this->IDM = $request->getParameter('Ds_MerchantData',0);
    		  if($request->hasParameter('OK') && $this->IDM > 0 ):
                 $this->MISSATGE = "PAGAMENT_TPV";
              else:
                 $this->MISSATGE = "PAGAMENT_TPV_KO";
              endif;
              $this->MODE = 'PAGAMENT';
              break;
              
        //Esborra una matrícula    		    		
    	case 'D':
                $RM = $request->getParameter('matricules');                  			    	 			    			    			    			    			
    			$OM = MatriculesPeer::retrieveByPK($RM['idMatricules']);
                $OM->setActiu(false);
                $OM->save(); 
    			$this->getUser()->addLogAction($accio,'gMatricules',$OM);
                myUser::addLogTimeline( 'baixa' , 'matricules' , $this->getUser()->getSessionPar('idU') , $this->IDS , $RM['idMatricules'] );
    			
    	    break;
    	    
   	    //Edita una matrícula
    	case 'E':                
                $this->IDM = $request->getParameter('IDM');                                
                $this->FMATRICULA = MatriculesPeer::initialize( $this->IDM , $this->IDS );     			    			    			    			
    			$this->MODE = 'EDICIO';
    		break;
    		
    	//Guardem una matrícula modificada
    	case 'SAVE_MATRICULA':    			
    			
                $RS = $request->getParameter('matricules');
                $this->FMATRICULA = MatriculesPeer::initialize($RS['idMatricules'] , $this->IDS );
    			$this->FMATRICULA->bind($RS);    			
    			if($this->FMATRICULA->isValid()):
    				$this->FMATRICULA->save();
    				$this->getUser()->addLogAction($accio,'gMatricules',$this->FMATRICULA->getObject());
                    myUser::addLogTimeline( 'modificació' , 'matricules' , $this->getUser()->getSessionPar('idU') , $this->IDS , $RS['idMatricules'] );    				
    				$this->redirect('gestio/gMatricules?accio=CA');
    			endif;
    			$this->MODE = 'EDICIO';    		
    		break;    	

        //Cerquem alumnes    			
		case 'CA':					
				$this->ALUMNES = MatriculesPeer::cercaAlumnes($this->CERCA['text'] , $this->PAGINA , $this->IDS );
				$this->SELECT = 2;
				$this->MODE = 'CONSULTA';				 
			break;		
            
        //Cerquem cursos
		case 'CC':
				$this->CURSOS = MatriculesPeer::cercaCursos($this->CERCA['text'] , $this->PAGINA , $this->IDS );
				$this->SELECT = 1;
				$this->MODE = 'CONSULTA';
			break;

		//Cerquem per matrícula
        case 'CM':					
				$C = new Criteria();
                $C->add(MatriculesPeer::IDMATRICULES, $this->CERCA['text']);
                $this->MATRICULES = MatriculesPeer::doSelect($C);                				
				$this->MODE = 'LMATRICULES'; 				 
			break;		

		case 'LMA':
				$this->MATRICULES = MatriculesPeer::getMatriculesUsuari($request->getParameter('IDA') , $this->IDS );                				
				$this->MODE = 'LMATRICULES'; 
			break;
            
		case 'LMC':
				$this->MATRICULES = MatriculesPeer::getMatriculesCurs($request->getParameter('IDC') , $this->IDS );
				$this->MODE = 'LMATRICULES';
			break;		
/**
 * @deprecated substituit per PRINT_PAGAMENT
 * 
		case 'P':
			
				$IDP = $request->getParameter('IDP');
				$OM = MatriculesPeer::retrieveByPK($IDP);
				$OU = $OM->getUsuaris();
				$OC = $OM->getCursos();
                $ODB = DadesBancariesPeer::retrieveByPK($OM->getIddadesbancaries());                
				
				$doc = new sfTinyDoc();
                
                $url_prop = OptionsPeer::getString('SF_WEBSYSROOT',$this->IDS).'documents/FullMatricula'.$this->IDS.'.docx';
                $url_gen = OptionsPeer::getString('SF_WEBSYSROOT',$this->IDS).'documents/FullMatriculaGen.docx';
                if(file_exists($url_prop)) $doc->createFrom($url_prop);
                else $doc->createFrom($url_gen);                                				
                
				$doc->loadXml('word/document.xml');
                                                
                $mat = 'MAT'.$OM->getIdmatricules();                 

                $doc->mergeXmlField('factura', $mat );
                $doc->mergeXmlField('client', $OU->getDni());
                $doc->mergeXmlField('data', $OM->getDatainscripcio('d/m/Y'));
                $doc->mergeXmlField('nom', $OU->getNomComplet());
                $doc->mergeXmlField('telèfon', $OU->getTelefonString());
                $doc->mergeXmlField('identificador', $OU->getDni());
                $doc->mergeXmlField('carrer', $OU->getAdreca());
                $doc->mergeXmlField('poble', $OU->getPoblacioString());
                $doc->mergeXmlField('postal', $OU->getCodipostal());
                $doc->mergeXmlField('concepte', $OC->getCodi().' - '.$OC->getTitolcurs());
                $doc->mergeXmlField('preu', $OM->getPagat());
                $doc->mergeXmlField('quantitat', '1');
                $doc->mergeXmlField('import', $OM->getPagat());
                $doc->mergeXmlField('base', $OM->getPagat());
                $doc->mergeXmlField('iva', '0%');
                $doc->mergeXmlField('total', $OM->getPagat());
                $doc->mergeXmlField('dia', $OC->getDatainici('d/m/Y'));
                $doc->mergeXmlField('horari', $OC->getHoraris());
                if(!is_null($ODB)):
                    $doc->mergeXmlField('ccc', $ODB->getCccFormat() );                
                    $doc->mergeXmlField('titular', $ODB->getTitular() );
                else:
                    $doc->mergeXmlField('ccc', '____ ____ __ __________' );                
                    $doc->mergeXmlField('titular', '___________________________________' );                    
                endif;
                
				$doc->saveXml();
				$doc->close();
				$doc->sendResponse();
				$doc->remove();
				
				throw new sfStopException; 
				
			break;
**/            
		case 'PB':
			
				$IDP = $request->getParameter('IDP');
				$OM = MatriculesPeer::retrieveByPK($IDP);
				$OU = $OM->getUsuaris();
				$OC = $OM->getCursos();                
				
				$doc = new sfTinyDoc();
                
                $url_prop = OptionsPeer::getString('SF_WEBSYSROOT',$this->IDS).'documents/FullBaixa'.$this->IDS.'.docx';
                $url_gen = OptionsPeer::getString('SF_WEBSYSROOT',$this->IDS).'documents/FullBaixaGen.docx';
                if(file_exists($url_prop)) $doc->createFrom($url_prop);
                else $doc->createFrom($url_gen);                                				
                
				$doc->loadXml('word/document.xml');
                                                
                $mat = 'MAT'.$OM->getIdmatricules();                 
                
                $doc->mergeXmlField('nom', $OU->getNomComplet());
                $doc->mergeXmlField('telèfon', $OU->getTelefonString());
                $doc->mergeXmlField('identificador', $OU->getDni());
                $doc->mergeXmlField('carrer', $OU->getAdreca());
                $doc->mergeXmlField('poble', $OU->getPoblacioString());
                $doc->mergeXmlField('postal', $OU->getCodipostal());
                $doc->mergeXmlField('concepte', $OC->getCodi().' - '.$OC->getTitolcurs());                
                $doc->mergeXmlField('data_baixa', $OM->getDataBaixa('d/m/Y'));                
                
				$doc->saveXml();
				$doc->close();
				$doc->sendResponse();
				$doc->remove();
				
				throw new sfStopException; 
				
			break;
            
        case 'PRINT_PAGAMENT':

                $idM = $request->getParameter('IDM');
                                
                $OM = MatriculesPeer::retrieveByPK($idM);                                
                
                $HTML = MatriculesPeer::DocMatriculaPagamentCaixer($OM, $this->IDS);                                
                        
                myUser::Html2PDF($HTML);
                                
    			throw new sfStopException;			   	  	                                                                                                                                                                 
        
            break;            
		case 'C':
				$this->getUser()->addLogAction('inside','gMatricules');
			break;
    }  	      
  }
  

  public function executeAjaxUsuaris(sfWebRequest $request)
  {
    $this->IDS = $this->getUser()->getSessionPar('idS');
    //La q és per el form autocomplete.
    if($request->hasParameter('q')) $RET = UsuarisPeer::cercaTotsCampsSelect($request->getParameter('q'),$request->getParameter('lim'),null);
    //Si uso el jqueryui autocomplete.
    elseif($request->hasParameter('term')) $RET = UsuarisPeer::cercaTotsCampsSelectJqueryUI($request->getParameter('term'),$request->getParameter('lim'),null);                                                   
    return $this->renderText(json_encode($RET));                
  }
  
  public function executeAjaxSites(sfWebRequest $request)
  {    
    $this->IDS = $this->getUser()->getSessionPar('idS');
    $RET = SitesPeer::cercaTotsCampsSelect($request->getParameter('q'),$request->getParameter('lim'),$this->IDS);                                                      
    return $this->renderText(json_encode($RET));                
  }

  public function executeAjaxUsuarisSite(sfWebRequest $request)
  {
    $this->IDS = $request->getParameter('IDS',0);
    $RET = SitesPeer::getSiteUsersCercaUser($request->getParameter('q'),$request->getParameter('lim'),$this->IDS);                                              
    return $this->renderText(json_encode($RET));                
  }

  
  //Envia el correu d'una matrícula
  public function SendMailMatricula($OM,$idS){
    MatriculesPeer::SendMailMatricula($OM, $idS); 
  }
        
  public function executeGNoticies(sfWebRequest $request)  
  { 
  	    
    $this->setLayout('gestio');
    $this->IDS = $this->getUser()->getSessionPar('idS');
        
    //Inicialitzem el formulari de cerca    
    $this->CERCA  = $this->getUser()->ParReqSesForm($request,'cerca',array('text'=>'','select'=>0));
    if(!isset($this->CERCA['select']))
    {
        $this->CERCA = array('text'=>'','select'=>0);
        $this->getUser()->setSessionPar('cerca',$this->CERCA);
    } 
    
    $this->FCerca = new CercaTextChoiceForm();       
    $this->FCerca->setChoice(array(0=>'Actuals',1=>'Totes'));     
	$this->FCerca->bind($this->CERCA);
        
    $this->PAGINA = $request->getParameter('p',1);
    $this->IDN    = $request->getParameter('idn');    
    
	$this->accio = $request->getParameter('accio');
	$this->MODE = 'CERCA';
	
	
    if($request->isMethod('POST')){	      	    
    	if($request->hasParameter('BNOU'))			$this->accio = 'N';
	    if($request->hasParameter('BSAVE')) 		$this->accio = 'S';		//Hem entrat una matrícula i passem a la fase de verificaciÃ³
	    elseif($request->hasParameter('BDELETE')) 	$this->accio = 'D';	    
	    elseif($request->hasParameter('BEDIT'))		$this->accio = 'E';
    }                    
    
	switch($this->accio){
		
		case 'CC':
			$this->getUser()->addLogAction('inside','gNoticies');			
            $this->CERCA  = $this->getUser()->ParReqSesForm($request,'cerca',array('text'=>'','select'=>0));			
			break;
			
		case 'N':
            $this->FORMULARI = NoticiesPeer::initialize(0,$this->IDS);									
			$this->MODE = 'FORMULARI';			
			break;
			
		case 'E':
            $this->FORMULARI = NoticiesPeer::initialize($this->IDN,$this->IDS);									
			$this->MODE = 'FORMULARI';			
			break;

		case 'S':
			
			$RS = $request->getParameter('noticies');
            $this->IDN = $RS['idNoticia'];
            $this->FORMULARI = NoticiesPeer::initialize($this->IDN,$this->IDS);													
			$this->FORMULARI->bind($RS,$request->getFiles('noticies'));
			
			if($this->FORMULARI->isValid()):
				$this->FORMULARI->save();
				$this->getUser()->addLogAction($this->accio,'gNoticies',$this->FORMULARI->getObject());                				
				$this->redirect('gestio/gNoticies?accio=CC');
			endif; 
			
			$this->MODE = 'FORMULARI';						
			break;
			
		case 'D':
            $RS = $request->getParameter('noticies');
            $this->IDN = $RS['idNoticia'];
            $this->FORMULARI = NoticiesPeer::initialize($this->IDN,$this->IDS);			        						
			$this->FORMULARI->getObject()->setActiu(false)->save();
            $this->getUser()->addLogAction($this->accio,'gNoticies',$this->FORMULARI->getObject());				
			break;
            
        //Order Down. Movem la fila un lloc avall.
        case 'O':
            $IDN = $request->getParameter('idN');
            $UP  = $request->getParameter('UP',0);
            NoticiesPeer::setNewOrder($IDN,$UP,$this->IDS);            
			break;
        
	}
	        
    $this->NOTICIES = NoticiesPeer::getNoticies($this->CERCA['text'],$this->PAGINA, false, $this->CERCA['select'] , $this->IDS);
          
  }
  
  public function executeGIncidencies(sfWebRequest $request)
  {
     
	$this->setLayout('gestio');
    $this->IDS = $this->getUser()->getSessionPar('idS');
    $this->IDU = $this->getUser()->getSessionPar('idU');
	        
  	//Netegem cerca
  	if($request->getParameter('accio') == 'C'):      		
        $this->CERCA = $this->getUser()->setSessionPar('cerca',array('text'=>''));    		      			      	      		
      	$this->PAGINA = $this->getUser()->setSessionPar('pagina',1);      			       
    endif;    
	
	
    $this->PAGINA = $this->getUser()->ParReqSesForm($request,'PAGINA',1);
    $this->CERCA = $this->getUser()->ParReqSesForm($request,'cerca',array('text'=>""));
    $this->accio = $this->getUser()->ParReqSesForm($request,'accio',"C");
    
    //Inicialitzem el formulari de cerca
    $this->FCerca = new CercaForm();
	$this->FCerca->bind($this->CERCA);
	
	//Inicialitzem variables
	$this->MODE = array('CONSULTA'	=> true,
						'NOU'		=> false, 
						'EDICIO' 	=> false
					);
	    
	if($request->isMethod('POST') || $request->isMethod('GET')):
		$accio = $request->getParameter('accio');
		if($request->hasParameter('BCERCA'))    $this->accio = 'C';
		if($request->hasParameter('BNOU')) 	    $this->accio = 'N';
		if($request->hasParameter('BSAVE')) 	$this->accio = 'S';
		if($request->hasParameter('BDELETE')) 	$this->accio = 'D';
	endif;                			
	
	switch($this->accio){
		case 'C':
				$this->getUser()->addLogAction('inside','gIncidencies');
			break;
	    case 'N':
                $this->FIncidencia = IncidenciesPeer::initialize( 0 , $this->IDU , $this->IDS );
	    		$this->MODE['NOU'] = true;
	    	break;
	    case 'E':
                $IDI = $request->getParameter('IDI');
                $this->FIncidencia = IncidenciesPeer::initialize( $IDI , $this->IDU , $this->IDS );    			
				$this->MODE['EDICIO'] = true;
			break;
		case 'S':
                $RP = $request->getParameter('incidencies');
                $this->FIncidencia = IncidenciesPeer::initialize( $RP['idIncidencia'] , $this->IDU , $this->IDS );			    
			    $this->FIncidencia->bind($RP);
			    if($this->FIncidencia->isValid()):
			    	$this->FIncidencia->save();
			    	$this->getUser()->addLogAction($accio,'gIncidencies',$this->FIncidencia->getObject());                    
                    myUser::addLogTimeline( 'alta' , 'incidencies' , $this->getUser()->getSessionPar('idU') , $this->IDS , $this->FIncidencia->getObject()->getIdincidencia() );
			    	$this->redirect('gestio/gIncidencies?accio=C');
			    endif; 
			    $this->MODE['EDICIO'] = true;    		        		        			
			break;
		case 'D': 
                $RP = $request->getParameter('incidencies');
                $this->FIncidencia = IncidenciesPeer::initialize( $RP['idIncidencia'] , $this->IDU , $this->IDS );
                $this->FIncidencia->getObject()->setActiu(false)->save();		        
		        $this->getUser()->addLogAction($accio,'gIncidencies',$this->FIncidencia->getObject());
                myUser::addLogTimeline( 'baixa' , 'incidencies' , $this->getUser()->getSessionPar('idU') , $this->IDS , $RP['idIncidencia'] );		            	        
		        break;        
        
            $this->INCIDENCIES = IncidenciesPeer::getIncidencies( $this->CERCA['text'] , $this->PAGINA , $this->IDS , true );    	         	 
	}
		
    if($accio == 'RESOLTES'): $this->INCIDENCIES = IncidenciesPeer::getIncidencies( $this->CERCA['text'] , $this->PAGINA , $this->IDS , false );
    else: $this->INCIDENCIES = IncidenciesPeer::getIncidencies( $this->CERCA['text'] , $this->PAGINA , $this->IDS , true );
    endif; 
  
  }  
    
  public function executeGCessio(sfWebRequest $request)  
  {
    
  	$this->setLayout('gestio');
    $this->IDS = $this->getUser()->getSessionPar('idS');
        
  	//Netegem cerca
  	if($request->getParameter('accio') == 'C'):      		
        $this->CERCA = $this->getUser()->setSessionPar('cerca',array('text'=>'','select'=>''));    		      			      	      		
      	$this->PAGINA = $this->getUser()->setSessionPar('pagina',1);      	      			      	      	      			       
    endif;    
  	
  	
    $this->PAGINA = $this->getUser()->ParReqSesForm($request,'PAGINA',1);
       		                  
    //Inicialitzem el formulari de cerca
    $this->CERCA = $this->getUser()->ParReqSesForm($request,'cerca',array('text'=>'','select'=>''));
    $this->FCerca = new CercaTextChoiceForm();       
    $this->FCerca->setChoice(array(1=>'Cedit',0=>'Retornat')); 
	$this->FCerca->bind($this->CERCA);	
	$this->MODE = "";
	$this->ERROR_OCUPAT = "";
	$this->IDC = $request->getParameter('IDC',0);    
		
    
    if($request->isMethod('POST') || $request->isMethod('GET')):
	    $accio = $request->getParameter('accio');
	    if($request->hasParameter('BCERCA'))    		$accio = ' ';
	    if($request->hasParameter('BNOU_CESSIO')) 	    $accio = 'NC';
	    if($request->hasParameter('BESCULL_MATERIAL'))  $accio = 'EM';
	    if($request->hasParameter('B_SAVE_CESSIO'))  	$accio = 'SC';	    	    	    	    	    	    	    
	    if($request->hasParameter('BDELETE_CESSIO')) 	$accio = 'DC';	    
	    if($request->hasParameter('BSAVE_RETORN'))		$accio = 'SR';
	    
	endif;              
	
	
    switch($accio){
    	case 'C':
			$this->getUser()->addLogAction('inside','gCessio');
            $this->CERCA['select'] = 1;
    		break;
    	//Nova Cessió
    	case 'NC':
                $this->FCessio = CessioPeer::inicialitza(0 , $this->IDS );    			    			
    			$this->MODE = 'NOU_CESSIO';
    		break;
    		
    	//Escull el material
    	case 'EM':
    			
    			$RCESSIO = $request->getParameter('cessio');                                
                $this->FCessio = CessioPeer::inicialitza($RCESSIO['cessio_id'] , $this->IDS );
                $this->FCessio->bind($RCESSIO);
                if($this->FCessio->isValid()):
                    $this->FCessio->save();
                    $this->LoadEscullMaterial($this->FCessio->getObject());                     
                else: 
                    $this->MODE = 'EDICIO_CESSIO';
                    $this->MISSATGE = array('Hi ha hagut algun error guardant la cessió');               
                endif;
                                    			    			                                                		    			                     			    			
    		break;
    		
    	//Edita Cessio
    	case 'EC':
    			
                $this->FCessio = CessioPeer::inicialitza($this->IDC , $this->IDS );                			    			    			
    			$this->MODE = 'EDICIO_CESSIO';
                
    		break;

    	//Edita Retorn
    	case 'ER':
    		    
                $this->FCessio = CessioPeer::inicialitza($this->IDC , $this->IDS , true);                			    			    			    			                			    		    
    			$OC = $this->FCessio->getObject();    			
    			if(!$OC->isNew()) $OC->setRetornat(true);    				    			    											   			
				$this->MODE = 'EDICIO_RETORN';
                
    		break;
    		
    	//Guarda cessió
    	case 'SC':    			                
				$RMATERIAL = $request->getParameter('material');
                $RMATERIALNOINV = $request->getParameter('material_no_inventariat');
                $this->FCessio = CessioPeer::inicialitza($this->IDC , $this->IDS );
                $ERROR = CessiomaterialPeer::update($RMATERIAL , $this->FCessio , $this->IDS );                                
                if(!empty($ERROR)):
                    $this->FCessio = CessioPeer::inicialitza($this->IDC , $this->IDS );
                    $OCESSIO = $this->FCessio->getObject();
                    $this->LoadEscullMaterial($OCESSIO,$RMATERIAL,$RMATERIALNOINV,true);
                    $this->MISSATGE = array();                    
                    foreach($ERROR as $idM => $text ):
                        $RET = MaterialPeer::OnOcupatMaterialHores( $idM , $OCESSIO->getDatacessio() , $OCESSIO->getDataRetorn() , '00:00' , '24:00' , $this->IDS , null , null , null );
                        foreach($RET as $idM => $O):
                            if($O instanceof Cessio):
                                $this->MISSATGE[] = 'El material '.$text.' està en ús a la cessió '.$O->getNom();
                            elseif($O instanceof Horaris):
                                $this->MISSATGE[] = 'El material '.$text.' està en ús en activitats el dia '.$O->getDia().' a les '.$O->getHorainici();
                            endif; 
                        endforeach;                                                    
                    endforeach;                                                                                                
                else:                                                                                                                 		        				
        		    if($request->hasParameter('material_no_inventariat')):
        		    	$this->FCessio->getObject()->setMaterialNoInventariat($RMATERIALNOINV);
        		    	$this->FCessio->getObject()->save();    		    
        		    endif;
                                                                           
    	            $this->getUser()->addLogAction($accio,'gCessio',$this->FCessio->getObject());                    
                    myUser::addLogTimeline( 'alta' , 'cessio' , $this->getUser()->getSessionPar('idU') , $this->IDS , $this->FCessio->getObject()->getCessioId() );
                                                            
        		    $this->MODE = 'FINALITZAT';
                endif; 
                    		        		        			
    		break;
    		
    	//Esborra cessió
    	case 'DC': 
    	        $OC = CessioPeer::retrieveByPK($this->getUser()->getSessionPar('IDC'));
    	        $this->getUser()->addLogAction($accio,'gCessio',$OC);
                myUser::addLogTimeline( 'baixa' , 'cessio' , $this->getUser()->getSessionPar('idU') , $this->IDS , $OC );                
    	        $OC->setActiu(false)->save();    	        
    	        break;
    	        
    	//Guarda retorn
    	case 'SR':
    		
				$RCESSIO = $request->getParameter('cessio');				
    			$OCESSIO = CessioPeer::retrieveByPK($RCESSIO['cessio_id']);    		
    		    $this->FCessio = new CessiomaterialRetornForm($OCESSIO);
    		    $this->FCessio->bind($RCESSIO);
    		    if($this->FCessio->isValid()): 
    		    	$this->FCessio->save();
    		    	$this->getUser()->addLogAction($accio,'gCessio',$this->FCessio->getObject());
                    myUser::addLogTimeline( 'retorn' , 'cessio' , $this->getUser()->getSessionPar('idU') , $this->IDS , $RCESSIO['cessio_id'] );
    		    	$this->redirect('gestio/gCessio?accio=C');
    		    endif;
    		    $this->MODE = 'EDICIO_RETORN';
    		        		        		        			
    		break;
    		
    	case 'PRINT':
    			$OCESSIO = CessioPeer::retrieveByPK($request->getParameter('IDC'));    			
    			$pdf = CessioPeer::printDocument($OCESSIO);
    			$pdf->output();
    			return sfView::NONE;
    		break;
    		    	    	         	     	         	 
    }        
                            
    $this->CESSIONS = CessioPeer::getCessions($this->PAGINA,$this->CERCA['select'],$this->CERCA['text'],$this->IDS);
  
  }

  public function LoadEscullMaterial( $OCESSIO , $RMATERIAL = null , $RMATERIALNOINV = "" , $ERROR_SELECT_MATERIAL = false )
  {                                               
    $this->MATERIALOUT = array();
    
    //Si és una cessió nova
    if(!$OCESSIO->isNew() && !$ERROR_SELECT_MATERIAL):        
        $this->MATERIALOUT = CessiomaterialPeer::getSelectMaterialOut($OCESSIO->getCessioId() , $this->IDS );
        $this->MAT_NO_INV = $OCESSIO->getMaterialNoInventariat();     			     			    			                
    
    //Si és una edició
    else:
        
        //Carreguem el material no inventariat i passem el material a visualitzar altre cop
        $this->MAT_NO_INV = $RMATERIALNOINV;                                                
        foreach($RMATERIAL as $G => $AM):
            $idMG = MaterialPeer::retrieveByPK($AM)->getMaterialgenericIdmaterialgeneric();                     
            $this->MATERIALOUT[] = array('material'=>$AM , 'generic' => $idMG );
        endforeach;                 

    endif;
    
    $this->IDC = $this->FCessio->getObject()->getCessioId();    	
    $this->MODE = 'ESCULL_MATERIAL';
  }

  
  public function executeGDocuments(sfWebRequest $request)
  {
  
    $this->setLayout('gestio');
    $this->IDS = $this->getUser()->getSessionPar('idS');

    $this->MISSATGE = array();
    $this->IDD = $request->getParameter('IDD',0);
            
    $accio  	= $this->getUser()->ParReqSesForm($request,'accio','GP');
    $this->MODE = 'CERCA';       
    	
    if($request->isMethod('POST')){
	    if($request->hasParameter('B_VEURE_PERMISOS')) 			$accio = 'VP';   
	    elseif($request->hasParameter('B_NOU')) 	    		$accio = 'ND';
	    elseif($request->hasParameter('B_SAVE_NOU'))    		$accio = 'SD';	    
	    elseif($request->hasParameter('B_UPDATE_PERMISOS')) 	$accio = 'SAVE_UPDATE_PERMISOS';	    
	    elseif($request->hasParameter('B_NEW_USER')) 			$accio = 'NUP';
	    elseif($request->hasParameter('B_NOU_USUARI_PERMISOS'))	$accio = 'SAVE_NOU_USUARI_PERMISOS';
	    elseif($request->hasParameter('B_EDITA_DIRECTORI'))		$accio = 'ND';
	    elseif($request->hasParameter('B_SAVE_EDITA_DIRECTORI'))$accio = 'SD';
	    elseif($request->hasParameter('B_DELETE_DIRECTORI')) 	$accio = 'DELETE_DIRECTORI';
    }                
    
    //Aquest petit bloc Ã©s per si es modifica amb un POST el que s'ha enviat per GET
    $this->getUser()->setSessionPar('accio',$accio);      
    
    switch($accio){

    	case 'GP':
			$this->getUser()->addLogAction('inside','gDocuments');
    		break;
    	
    	//Visualitza permisos que tenen els usuaris en el directori
    	case 'VP':    		
			
    		$this->LLISTAT_PERMISOS = AppDocumentsPermisosDirPeer::getLlistatPermisos( $this->IDD , $this->IDS );                		
    		$this->MODE = "CONSULTA";
  	
    		break;
    		
    	//Crea un directori nou
    	case 'ND':
                $this->FDir = AppDocumentsDirectorisPeer::initialize($this->IDD,$this->IDS);
    			$this->MODE = "NOU";	    			    						  	
    		break;
    		
    	//Guarda un directori
    	case 'SD':
    			$RP = $request->getParameter('app_documents_directoris');
                $this->FDir = AppDocumentsDirectorisPeer::initialize($RP['idDirectori'],$this->IDS);
                $this->FDir->bind($RP);
                if($this->FDir->isValid()):
                    $this->FDir->save();
                    $IDU = $this->getUser()->getSessionPar('idU');
                    $idD = $this->FDir->getObject()->getIddirectori();
                    $this->getUser()->addLogAction($accio,'gDocuments',$this->FDir->getObject());
                    
                    //A més donem permisos a l'usuari que l'ha creat perquè pugui accedir-hi                    
                    if(AppDocumentsPermisosDirPeer::addUser($IDU,$idD,$this->IDS)):
                        $this->getUser()->addLogAction($accio,'gDocuments',$this->IDD);
                        $this->MODE = "CONSULTA";
                    else:
                        $this->MISSATGE = array("Hi ha hagut algun error afegint l'usuari.");
                        $this->MODE = "NOU";
                    endif;                                                             
                else: 
                    $this->MISSATGE = array("Hi ha hagut algun error.");
                    $this->MODE = "NOU";
                endif; 
    				    			    						  	
    		break;
        		
    	//Esborra un directori
    	case 'DELETE_DIRECTORI':
                $RP = $request->getParameter('app_documents_directoris');
                $this->IDD = $RP['idDirectori'];
                $this->FDir = AppDocumentsDirectorisPeer::initialize($this->IDD,$this->IDS);
                $this->FDir->getObject()->setActiu(false)->save();
                $this->getUser()->addLogAction($accio,'gDocuments',$this->FDir->getObject());    			    			    			    			    										  	
    		break;    		
    		    		
	   	//Actualitza un directori
    	case 'UD':
    			$this->MODE = "NOU";						  	
    		break;

    	//Guarda els nous permisos
    	case 'SAVE_UPDATE_PERMISOS':                				
				foreach($request->getParameter('nivell') as $idU=>$idN):                                        					
					if(!AppDocumentsPermisosDirPeer::addUser($idU,$this->IDD,$this->IDS,$idN)) $this->MISSATGE[] = "Problema guardant els permisos dels usuaris.";					
				endforeach;
				$this->getUser()->addLogAction($accio,'gDocuments',$request->getParameter('nivell'));
                $this->redirect('gestio/gDocuments?accio=VP&IDD='.$this->IDD);
    		break;
    		
    	case 'SAVE_NOU_USUARI_PERMISOS':
    		
    		$RP  = $request->getParameter('app_documents_permisos_dir');
            $this->FPERMISOS = AppDocumentsPermisosDirPeer::initialize($RP['idUsuari'],$RP['idDirectori'],$this->IDS);    		
    		$this->FPERMISOS->bind($RP);
    		if($this->FPERMISOS->isValid()):
    			$this->FPERMISOS->save();
    			$this->getUser()->addLogAction($accio,'gDocuments',$this->FPERMISOS->getObject());
    			$this->redirect('gestio/gDocuments?accio=VP&IDD='.$this->IDD);
            else: 
                $this->MISSATGE[] = "Hi ha hagut algun problema guardant els permisos"; 
    		endif;     		
    		$this->MODE = 'NOU_USUARI';    		
    		break;
    		
    	//Afegim un usuari a un directori
    	case 'NUP':    			    			
                $this->FPERMISOS = AppDocumentsPermisosDirPeer::initialize($this->IDU,$this->IDD,$this->IDS);    			    			
    			$this->MODE = "NOU_USUARI";						  	
    		break;    		    	
    }
  	
    $this->LLISTAT_PERMISOS = AppDocumentsPermisosDirPeer::getLlistatPermisos( $this->IDD , $this->IDS );
    
  }

  
  public function executeGBlogs(sfWebRequest $request)
  {
  
    $this->setLayout('gestio');
    $this->IDS = $this->getUser()->getSessionPar('idS');

    
    //Add,Edit,Delete Multimedia
    //Add,Edit,Delete Page
    //Add,Edit,Delete Entry
    
    //Principal view -> Blogs
    //You Select a blog -> Choice Menus - Pages
    //Edit Page - Menu 
    

    $this->APP_BLOG			= $request->getParameter('APP_BLOG',-1);
    $this->APP_PAGE			= $request->getParameter('APP_PAGE',-1);    
    $this->APP_ENTRY		= $request->getParameter('APP_ENTRY',-1);
    $this->APP_MENU			= $request->getParameter('APP_MENU',-1);
    $this->APP_MULTIMEDIA	= $request->getParameter('APP_MULTIMEDIA',-1);
    $this->APP_FORM			= $request->getParameter('APP_FORM',1);
    $this->APP_FORM_ENTRY   = $request->getParameter('APP_FORM_ENTRY',0);
    $this->accio            = $request->getParameter('accio','VB');
             
//    $this->APP_BLOG			= $this->getUser()->ParReqSesForm($request,'APP_BLOG',-1);
//    $this->APP_PAGE			= $this->getUser()->ParReqSesForm($request,'APP_PAGE',-1);    
//    $this->APP_ENTRY		= $this->getUser()->ParReqSesForm($request,'APP_ENTRY',-1);
//    $this->APP_MENU			= $this->getUser()->ParReqSesForm($request,'APP_MENU',-1);
//    $this->APP_MULTIMEDIA	= $this->getUser()->ParReqSesForm($request,'APP_MULTIMEDIA',-1);
//    $this->APP_FORM			= $this->getUser()->ParReqSesForm($request,'APP_FORM',1);
//    $this->APP_FORM_ENTRY   = $this->getUser()->ParReqSesForm($request,'APP_FORM_ENTRY',0);
            
    $accio  	= $request->getParameter('accio','GP');
    $this->MODE = 'CERCA';       
    	
    if($request->isMethod('POST')){
	    if($request->hasParameter('B_NEW_MENU')) 				$accio = 'NEW_MENU';   
	    elseif($request->hasParameter('B_EDIT_MENU')) 		    $accio = 'EDIT_MENU';
	    elseif($request->hasParameter('B_DELETE_MENU')) 	   	$accio = 'DELETE_MENU';	
	    elseif($request->hasParameter('B_SAVE_MENU'))    		$accio = 'SAVE_MENU';    
	    elseif($request->hasParameter('B_NEW_PAGE')) 			$accio = 'NEW_PAGE';	    
	    elseif($request->hasParameter('B_EDIT_PAGE')) 			$accio = 'EDIT_PAGE';
	    elseif($request->hasParameter('B_DELETE_PAGE'))			$accio = 'DELETE_PAGE';
	    elseif($request->hasParameter('B_SAVE_PAGE'))    		$accio = 'SAVE_PAGE';
	    elseif($request->hasParameter('B_NEW_ENTRY'))			$accio = 'NEW_ENTRY';
	    elseif($request->hasParameter('B_EDIT_ENTRY'))			$accio = 'EDIT_ENTRY';
	    elseif($request->hasParameter('B_DELETE_ENTRY'))	 	$accio = 'DELETE_ENTRY';
	    elseif($request->hasParameter('B_SAVE_ENTRY'))	    	$accio = 'SAVE_ENTRY';
	    elseif($request->hasParameter('B_NEW_BLOG'))			$accio = 'NEW_BLOG';
	    elseif($request->hasParameter('B_EDIT_BLOG'))			$accio = 'EDIT_BLOG';
	    elseif($request->hasParameter('B_DELETE_BLOG')) 		$accio = 'DELETE_BLOG';
	    elseif($request->hasParameter('B_SAVE_BLOG'))    		$accio = 'SAVE_BLOG';
	    elseif($request->hasParameter('B_VIEW_CONTENT'))   		$accio = 'VIEW_CONTENT';
	    elseif($request->hasParameter('B_VIEW_STADISTICS'))		$accio = 'VIEW_STADISTICS';
	    elseif($request->hasParameter('B_VIEW_FORM'))			$accio = 'VIEW_FORM';
	    
    }                
                  
    switch($accio){
    	case 'NEW_MENU':      
    			$this->FORM_MENU = AppBlogsMenuPeer::initialize( 0 , $this->APP_BLOG , $this->IDS );    			
    		break;
    	case 'EDIT_MENU':                
    			$this->FORM_MENU = AppBlogsMenuPeer::initialize( $this->APP_MENU , $this->APP_BLOG , $this->IDS );    			
    		break;      
    	case 'DELETE_MENU':
    			$this->FORM_MENU = AppBlogsMenuPeer::initialize( $this->APP_MENU , $this->APP_BLOG , $this->IDS );
    			$this->getUser()->addLogAction($accio,'gBlogs',$this->FORM_MENU->getObject());
    			$this->FORM_MENU->getObject()->setInactiu();    			
    			$this->redirect('gestio/gBlogs?accio=VIEW_CONTENT');
    		break;
    	case 'SAVE_MENU':
                $RP = $request->getParameter('app_blogs_menu');
                $this->APP_MENU = $RP['id'];
                $this->APP_BLOG = $RP['blog_id'];
                
    			$this->FORM_MENU = AppBlogsMenuPeer::initialize( $this->APP_MENU , $this->APP_BLOG , $this->IDS );
    			$this->FORM_MENU->bind($RP);
    			if($this->FORM_MENU->isValid()):
    				try { 
    					$this->FORM_MENU->save();
    					$this->getUser()->addLogAction($accio,'gBlogs',$this->FORM_MENU->getObject());
    					$this->APP_MENU = $this->FORM_MENU->getObject()->getId();	    				
	    				
                        unset($this->APP_MENU); $this->reloadBlog();
                             				
    				} catch (Exception $e) { echo $e->getMessage(); }    					    			    				    
    			endif; 
    		break;
    	case 'NEW_PAGE':
    			$this->FORM_PAGE = AppBlogsPagesPeer::initialize( 0 , $this->APP_BLOG , $this->IDS );    			
    		break;
    	case 'EDIT_PAGE':                
    			$this->FORM_PAGE = AppBlogsPagesPeer::initialize( $this->APP_PAGE , $this->APP_BLOG , $this->IDS );
    		break;
    	case 'DELETE_PAGE':
    			try { 
                        $RP = $request->getParameter('app_blogs_pages');
                        $this->APP_PAGE = $RP['id'];
                        $this->APP_BLOG = $RP['blog_id'];
                        
    					$this->FORM_PAGE = AppBlogsPagesPeer::initialize( $this->APP_PAGE , $this->APP_BLOG , $this->IDS  );
    					$this->getUser()->addLogAction($accio,'gBlogs',$this->FORM_PAGE->getObject());
    					$this->FORM_PAGE->getObject()->setInactiu();
                            					
    					unset($this->FORM_PAGE); 
                        $this->reloadBlog();
                            					     				
    				} catch (Exception $e) { echo $e->getMessage(); }
    		break;
    	case 'SAVE_PAGE':                                
                $RP = $request->getParameter('app_blogs_pages');
                $this->APP_PAGE = $RP['id'];                
                $this->APP_BLOG = $RP['blog_id'];                
                                
    			$this->FORM_PAGE = AppBlogsPagesPeer::initialize( $this->APP_PAGE , $this->APP_BLOG , $this->IDS );    			
    			$this->FORM_PAGE->bind($RP);
    			if($this->FORM_PAGE->isValid()):
    				try { 
    					$this->FORM_PAGE->save();
    					$this->getUser()->addLogAction($accio,'gBlogs',$this->FORM_PAGE->getObject());
    					$this->APP_PAGE = $this->FORM_PAGE->getObject()->getId();
                        
                        //Ara assignem també aquesta pàgina al menú que tenim seleccionat. Si no n'hi ha cap, no fem res. 
                        if($this->APP_MENU > 0): 
                            $FM = AppBlogsMenuPeer::initialize($this->APP_MENU , $this->APP_BLOG , $this->IDS );
                            $FM->getObject()->setPageId($this->APP_PAGE)->save();                            
                        endif; 	    				
	    				
                        unset($this->FORM_PAGE); 
                        $this->reloadBlog();
                             				
    				} catch (Exception $e) { echo $e->getMessage(); }    					    			    				    
    			endif;     			
    		break;
    	case 'NEW_ENTRY':                
    			$this->FORM_ENTRY = AppBlogsEntriesPeer::initialize( $this->APP_ENTRY , 'CA', $this->APP_PAGE , $this->APP_BLOG , $this->IDS );    			
    			$this->GALLERY = array();
    		break;
    	case 'EDIT_ENTRY':
    			$this->FORM_ENTRY = AppBlogsEntriesPeer::initialize( $this->APP_ENTRY , 'CA', $this->APP_PAGE , $this->APP_BLOG , $this->IDS );
    			$this->GALLERY = AppBlogsEntriesPeer::getFiles( $this->APP_ENTRY , 'CA'); 
    		break;
    	case 'DELETE_ENTRY':
                $RS = $request->getParameter('app_blogs_entries');
                $this->APP_ENTRY = $RS['id'];
                $this->APP_PAGE  = $RS['page_id'];
                
    			$this->FORM_ENTRY = AppBlogsEntriesPeer::initialize( $this->APP_ENTRY , 'CA' , $this->APP_PAGE , $this->APP_BLOG , $this->IDS );
    			$this->getUser()->addLogAction($accio,'gBlogs',$this->FORM_ENTRY->getObject());
    			
                $this->FORM_ENTRY->getObject()->setInactiu();
                
    			$this->reloadBlog();
                
    		break;
    	case 'SAVE_ENTRY':
                $RS = $request->getParameter('app_blogs_entries');
                $this->APP_ENTRY = $RS['id'];
                $this->APP_PAGE  = $RS['page_id'];
        
    			$this->FORM_ENTRY = AppBlogsEntriesPeer::initialize( $this->APP_ENTRY , 'CA', $this->APP_PAGE , $this->APP_BLOG , $this->IDS );    			    			    			
    			$this->FORM_ENTRY->bind($RS);    			
    			if($this->FORM_ENTRY->isValid()):
    				try { 
    					$this->FORM_ENTRY->save();    							
    					$this->getUser()->addLogAction($accio,'gBlogs',$this->FORM_ENTRY->getObject());	    							
    					$this->APP_ENTRY = $this->FORM_ENTRY->getObject()->getId();	    				
	    				$this->GUARDA_IMATGES( $request->getFiles('arxiu') , $request->getParameter('desc') , $this->APP_ENTRY );
	    				
                        unset($this->FORM_ENTRY);
                        $this->reloadBlog();                        
                             				
    				} catch (Exception $e) { echo $e->getMessage(); }    					    			    				    
    			endif;
    			$this->GALLERY = AppBlogsEntriesPeer::getFiles( $this->APP_ENTRY , 'CA');     			    		    			
    		break;
    	case 'NEW_BLOG':
    			$this->FORM_BLOG = AppBlogsBlogsPeer::initialize( 0 , $this->IDS );
    		break;
    	case 'EDIT_BLOG':                
    			$this->FORM_BLOG = AppBlogsBlogsPeer::initialize( $this->APP_BLOG , $this->IDS );
    		break;
                  
    	case 'DELETE_BLOG':
                $RS = $request->getParameter('app_blogs_blogs');
                $this->APP_BLOG = $RS['id'];                
                                
    			$this->FORM_BLOG = AppBlogsBlogsPeer::initialize( $this->APP_BLOG , $this->IDS );
    			$this->getUser()->addLogAction($accio,'gBlogs',$this->FORM_BLOG->getObject());                
    			$this->FORM_BLOG->getObject()->setInactiu();
                unset($this->FORM_BLOG);
    		break;
                		
    	case 'DELETE_IMAGE':    			    			
                AppBlogsMultimediaPeer::initialize( $this->APP_MULTIMEDIA , $this->IDS )->getObject()->setInactiu();
                $this->getUser()->addLogAction($accio,'gBlogs',$this->APP_MULTIMEDIA);
    		break;
            
    	case 'SAVE_BLOG':
                $RS = $request->getParameter('app_blogs_blogs');
                $this->APP_BLOG = $RS['id'];                
                                
    			$this->FORM_BLOG = AppBlogsBlogsPeer::initialize( $this->APP_BLOG , $this->IDS );
    			$this->FORM_BLOG->bind($RS);
    			if($this->FORM_BLOG->isValid()):
    				try { 
    					$this->FORM_BLOG->save();
    					$this->getUser()->addLogAction($accio,'gBlogs',$this->FORM_BLOG->getObject());
    					$this->APP_BLOG = $this->FORM_BLOG->getObject()->getId();
                        unset($this->FORM_BLOG); $this->reloadBlog();     				
    				} catch (Exception $e) { echo $e->getMessage(); }    				    				
    			endif; 
    		break;
    	case 'VIEW_CONTENT':                
                $this->reloadBlog($this->APP_BLOG);
    		break;
    		
    	case 'AJAX_PAGE':
    			$APP_PAGE  = $request->getParameter('APP_PAGE');
                $APP_ENTRY = $request->getParameter('APP_ENTRY');                                                                                                 
    			$HTML = AppBlogsEntriesPeer::getOptionsEntries( $APP_PAGE , $APP_ENTRY , $this->IDS );
    			return $this->renderText($HTML);	
    		break;
    		
    	case 'AJAX_MENU':
                $APP_BLOG = $request->getParameter('APP_BLOG');
    			$APP_MENU = ($request->getParameter('APP_MENU') > 0)?$request->getParameter('APP_MENU'):0;
                $APP_PAGE = ($request->getParameter('APP_PAGE') > 0)?$request->getParameter('APP_PAGE'):0;                                                                    			
    			$HTML = AppBlogsPagesPeer::getOptionsPages( $APP_BLOG , $APP_MENU , $APP_PAGE , $this->IDS );
    			return $this->renderText($HTML);	
    		break;    		
    		
    	case 'AJAX_ESTAT_FORM':
    			$APP_FORM_ENTRY = $request->getParameter('APP_FORM_ENTRY');
    			$ESTAT = $request->getParameter('ESTAT');
    			$OO = AppBlogsFormsEntriesPeer::initialize( $APP_FORM_ENTRY , $this->IDS )->getObject();                
    			$OO->setEstat($ESTAT);
    			$OO->save();
    			return $this->renderText('Canvi fet correctament');
    		break;
    		
    	case 'AJAX_SAVE_OBJECCIONS':
    			$APP_FORM_ENTRY = $request->getParameter('APP_FORM_ENTRY');    			
    			$OO = AppBlogsFormsEntriesPeer::initialize( $APP_FORM_ENTRY , $this->IDS );
    			$OO->setObjeccions($request->getParameter('OBJECCIONS'));
    			$OO->save();
    			return $this->renderText('Canvi fet correctament');
    		break;    		
    		    		
    	case 'VB':
				$this->APP_BLOG  = -1;
    			$this->APP_PAGE  = -1;    
    			$this->APP_ENTRY = -1;
    			$this->APP_MENU	 = -1;
    			$this->APP_MULTIMEDIA = -1;
    			$this->APP_FORM = -1;
    			$this->getUser()->addLogAction('inside','gBlogs');    			
    		break;

    	case 'VIEW_STADISTICS':

    			//Veure estructura d'arbre
				$this->PAGES_WITHOUT_CONTENT 	= AppBlogsPagesPeer::getPagesWithoutContent( $this->APP_BLOG , $this->IDS );
				$this->MENUS_WITHOUT_PAGES   	= AppBlogsMenuPeer::getMenusWithoutPages( $this->APP_BLOG , $this->IDS );
				$this->TREE 					= AppBlogsMenuPeer::getOptionsMenus( $this->APP_BLOG , null , false , $this->IDS );    			
    		break;

    	case 'VIEW_FORM':

    			$datai = mktime(0,0,0,date('m',time())-2,date('d',time()),date('Y',time()));    		
				$this->VIEW_FORM_ENTRIES = AppBlogsFormsEntriesPeer::getEntries( $this->APP_FORM , date('Y-m-d',$datai) , $this->IDS );
				$this->VIEW_FIELDS = AppBlogsFormsEntriesPeer::getFields( $this->APP_FORM , $this->IDS );
				    			
    		break;
    		    		    		
    }  	
    
    $this->BLOGS_ARRAY = AppBlogsBlogsPeer::getOptionsBlogs( $this->APP_BLOG , $this->IDS );
       
  }
  
  private function reloadBlog()
  {
    
//    echo 'BLOG: '.$this->APP_BLOG;
//    echo 'MENU: '.$this->APP_MENU;
//    echo 'PAGE: '.$this->APP_PAGE;
//    echo 'ENTR: '.$this->APP_ENTRY;
//    echo 'IDS:'.$this->IDS;
    
    $this->TREE	= AppBlogsMenuPeer::getOptionsMenus( $this->APP_BLOG ,$this->APP_MENU , false , $this->IDS );
    $this->MENUS_ARRAY = AppBlogsMenuPeer::getOptionsMenus( $this->APP_BLOG ,$this->APP_MENU , true , $this->IDS );                    			
    $this->PAGES_ARRAY = AppBlogsPagesPeer::getOptionsPages( $this->APP_BLOG , $this->APP_MENU , $this->APP_PAGE , $this->IDS );
    $this->ENTRIES_ARRAY = AppBlogsEntriesPeer::getOptionsEntries( $this->APP_PAGE , $this->APP_ENTRY , $this->IDS );
    $this->FORMS_ARRAY = AppBlogsFormsPeer::getOptionsForms( $this->APP_BLOG , $this->APP_FORM , $this->IDS );
  }
  
  private function GUARDA_IMATGES($images, $descripcions , $entry_id)
  {
  	
  	foreach($images as $K=>$I):
	
  		if($I['error'] == 0):
  	
            $FOM = AppBlogsMultimediaPeer::initialize( 0 , $this->IDS );    
	  		$OO = $FOM->getObject();
	  		$OO->setName($I['name']);  		
	  		$OO->setDate(date('Y-m-d',time()));
	  		$OO->setDesc($descripcions[$K]);
	  		$OO->setUrl('');
	  		$OO->save();
	  		  		
	  		$extensio = $this->file_extension($I['name']);
	  		$nom = $entry_id.'-'.$OO->getId().$extensio; 
	  		
	  		move_uploaded_file($I['tmp_name'], OptionsPeer::getString('SF_WEBSYSROOT',$this->IDS).'images/blogs/'.$nom);
	  		
	  		$OO->setUrl($nom);
	  		$OO->save();
	  		
            $FOME = AppBlogMultimediaEntriesPeer::initialize($entry_id,$OO->getId());
            $FOME->getObject()->save();	  		
	  		
	  	endif;
  		       
  	endforeach;
  	
  }
  
  function file_extension($filename)
  {
	return substr($filename, strripos($filename, '.'));
  }

  //**************************************************************************************************************************************************
  //**************************************************************************************************************************************************
  
  
  public function executeGArxiuDvd(sfWebRequest $request)  
  {
  	   	
    $this->setLayout('gestio');
    
    //Actualitzem el requadre de cerca
    $this->FCerca = new CercaForm();
    $this->FCerca->bind($request->getParameter('cerca'));
    $temp = $request->getParameter('cerca');
    $this->CERCA = $temp['text'];    
    
    if($request->isMethod('POST') || $request->isMethod('GET')):
    	
    	$accio = $request->getParameter('accio');
    	if( $request->hasParameter('BCERCA') ) 		$accio = 'C';
//	    if( $request->hasParameter('BNOU') )  		$accio = 'N';
//	    if( $request->hasParameter('BSAVE') ) 		$accio = 'S';
//	    if( $request->hasParameter('BDELETE') )		$accio = 'D';
	    
    endif;

    //Inicialitzacions pel template
    $this->CONSULTA = true; 
    $this->NOU 		= false; 
    $this->EDICIO 	= false; 
    $this->accio 	= NULL;
                                      
    switch( $accio )
    {
/*      case 'N':
                $this->NOU = true;
                $OM = new Missatges();
                $OM->setUsuarisUsuariid($this->getUser()->getSessionPar('idU'));
                $this->FMissatge = new MissatgesForm($OM);
                $this->getUser()->setSessionPar('IDM',0);              	                                                
                break;                
      case 'E':
                $this->EDICIO = true;
                $IDM = $request->getParameter('IDM');
                $this->getUser()->setSessionPar('IDM',$IDM);
                $OM = MissatgesPeer::retrieveByPK($IDM);
                $this->FMissatge = new MissatgesForm($OM);                
                break;
      case 'S':
      			$IDM = $this->getUser()->getSessionPar('IDM');
                $OM = ($IDM > 0)?MissatgesPeer::retrieveByPk($IDM):new Missatges();
                $this->FMissatge = new MissatgesForm($OM);                 
                $this->FMissatge->bind($request->getParameter('missatges'));                
                if ($this->FMissatge->isValid()) { $this->FMissatge->save(); $this->redirect('gestio/gMissatges'); }                              	                                                                                
                $this->EDICIO = true;      
                break;
      case 'D':
      			$this->IDM = $this->getUser()->getSessionPar('IDM');                
                $M = MissatgesPeer::retrieveByPK($this->IDM);
                if(!is_null($M)) $M->delete();                
                break;                    
*/  
    }
    
                    
    $this->DVDS = ArxiuDvdPeer::cerca($this->CERCA);
    
  }

  //**************************************************************************************************************************************************
  // Informes
  //**************************************************************************************************************************************************
  
  public function executeGInformes(sfWebRequest $request)
  {
     
	$this->setLayout('gestio');
    $this->IDS = $this->getUser()->getSessionPar('idS');
    $this->POTVEURE = array(1=>true);
	//$this->POTVEURE = array(1=>UsuarisPeer::canSeeComptabilitat($this->getUser()->getSessionPar('idU')));
	$this->accio = $request->getParameter('accio');
	$this->getUser()->addLogAction('inside','gInformes');
    if($request->hasParameter('BGENERADOC')) $this->accio = 'RESUM_ACTIVITATS';
    if($request->hasParameter('BGENERAXML')) $this->accio = 'RESUM_ACTIVITATS';
	
	switch($this->accio){
		case 'MAT_DIA_PAG':
                $this->MODE = $request->getParameter('mode_pagament');
				$this->DADES = array();				
				foreach(MatriculesPeer::getMatriculesPagadesDia( $this->MODE , $this->IDS ) as $OM):
					$OU = $OM->getUsuaris();
					$OC = $OM->getCursos();
					$this->DADES[$OM->getIdmatricules()]['DATA'] = $OM->getDatainscripcio('d/m/Y');
					$this->DADES[$OM->getIdmatricules()]['IMPORT'] = $OM->getPagat();
					$this->DADES[$OM->getIdmatricules()]['DNI'] = $OU->getDni();
					$this->DADES[$OM->getIdmatricules()]['NOM'] = $OU->getNomComplet();
					$this->DADES[$OM->getIdmatricules()]['CURS'] = $OC->getCodi();
                    $this->DADES[$OM->getIdmatricules()]['HORA'] = $OM->getDatainscripcio('H:i');
                    $this->DADES[$OM->getIdmatricules()]['ORDER'] = $OM->getTpvOperacio();                    
                    $this->DADES[$OM->getIdmatricules()]['ESTAT'] = $OM->getEstat();
                    $this->DADES[$OM->getIdmatricules()]['ESTATS'] = $OM->getEstatString();
                    $this->DADES[$OM->getIdmatricules()]['PAGAMENT'] = $OM->getTpagamentString();                                                            
				endforeach;				 
			break;
		
        //Treu un resum de les activitats aplicant-hi les etiquetes corresponents
        case 'RESUM_ACTIVITATS':
                $RP = $request->getParameter('informe_activitats');
                $this->FACTIVITATS   = new InformeActivitatsForm(null,array('IDS'=>$this->IDS));
                $this->FACTIVITATS->bind($RP);                
                if($request->hasParameter('BGENERADOC')):
                    $this->LOA = ActivitatsPeer::getLlistatWord($this->FACTIVITATS,$this->IDS,true);
                elseif($request->hasParameter('BGENERAXML')):
                    $this->setLayout(null);
                    $this->setTemplate(null);
                    $LOH = ActivitatsPeer::getLlistatWord($this->FACTIVITATS,$this->IDS,false);
                    
                    //Creem l'objecte XML                                                                                                                                                                                                                                                
                    $i = 1;  
                    $document = "<document>\n";                    
                    foreach($LOH as $OH):
                                                                    
                        $OA = $OH->getActivitats();
                        $LE = $OH->getArrayEspais();
                                                                                                                        
                        $document .= "<caixa>\n";
                        $document .= "  <data_inicial>".$OA->getPrimerHorari()->getDia('Y-m-d')."</data_inicial>\n";
                        $document .= "  <data_fi>".$OA->getUltimHorari()->getDia('Y-m-d')."</data_fi>\n";
                        $document .= "  <tipus_activitat>".$OA->getNomTipusActivitat()."</tipus_activitat>\n";
                        $document .= "  <cicle>".$OA->getCicles()->getTmig()."</cicle>\n";
                        $document .= "  <tipologia>".$OA->getCategories()."</tipologia>\n";
                        $document .= "  <importancia>".$OA->getImportancia()."</importancia>\n";                        
                        $document .= "  <titol>".$OA->getTmig()."</titol>\n";
                        $document .= "  <text>".utf8_encode(strip_tags(html_entity_decode($OA->getDmig())))."</text>\n";
                        $document .= "  <url>".$this->getController()->genUrl('@web_menu_click_activitat?idCicle='.$OA->getCiclesCicleid().'&idActivitat='.$OA->getActivitatid().'&titol='.$OA->getNomForUrl() , true )."</url>\n";
                        $document .= "  <hora_inici>".$OH->getHorainici("H.i")."</hora_inici>\n";
                        $document .= "  <hora_fi>".$OH->getHorafi("H.i")."</hora_fi>\n";
                        $document .= "  <espais>".implode(",",$LE)."</espais>\n";
                        $document .= "  <organitzador>".html_entity_decode( $OA->getOrganitzador() )."</organitzador>\n";
                        $document .= "  <info_practica>".utf8_encode( strip_tags( html_entity_decode( $OA->getInfopractica() ) ) )."</info_practica>\n";
                        $document .= "  <url_img_s>http://www.hospici.cat/images/activitats/A-".$OA->getActivitatid()."-M.jpg</url_img_s>\n";
                        $document .= "  <url_img_m>http://www.hospici.cat/images/activitats/A-".$OA->getActivitatid()."-L.jpg</url_img_m>\n";
                        $document .= "  <url_img_l>http://www.hospici.cat/images/activitats/A-".$OA->getActivitatid()."-XL.jpg</url_img_l>\n";                                                
                        $document .= "</caixa>\n";                                                                                                
                                                                                                                                               
                    endforeach;
                        
                    $document .= "</document>\n";                                                   
                                                                                                                                                                                                                                                            
          			$nom = OptionsPeer::getString( 'SF_WEBSYSROOT' , $this->IDS ).'tmp/'.$this->IDS.'NEWS.txt';
                    fwrite( fopen( $nom , 'w' ) , $document );
                    $response = sfContext::getInstance()->getResponse();
            	    $response->setContentType('text/plain');
                    $response->setHttpHeader('Content-Disposition', 'attachment; filename="News.txt');
                    $response->setHttpHeader('Content-Length', filesize($nom));
                    $response->setContent(file_get_contents($nom, false));
                    $response->sendHttpHeaders();
                    $response->sendContent();                                							                    
         					
        			throw new sfStopException;                			   	  	 
                                        
                endif;    									 
			break;
        
        //Mostra les activitats a quatre mesos vista que estan marcats com a publicables per web.  
        case 'CONTINGUT_WEB':
                                
                //Carrego les activitats
                $dia = date('d'); $mes = date('m'); $any = date('Y'); $inici = mktime(0,0,0,$mes,$dia,$any); $fi = mktime(0,0,0,$mes+5,$dia,$any);                
                $LLISTAT_ACTIVITATS_WEB = array();
                
                $LOH = HorarisPeer::cerca(null,null,$inici,$fi,null,$this->IDS);
                foreach( $LOH as $id => $OH ):
                    $OA = $OH->getActivitats();
                    //Si és una activitat correcta... la consultem.
                    if($OA instanceof Activitats){
                        $id = $OA->getActivitatid();
                        //Si es pot publicar al web
                        if( !isset( $LLISTAT_ACTIVITATS_WEB[$id] ) && $OA->getPublicaweb()){
                            $LLISTAT_ACTIVITATS_WEB[$id]['OA']     = $OA;
                            $LLISTAT_ACTIVITATS_WEB[$id]['text']   = ( strlen( $OA->getTmig() ) > 5 );
                            $LLISTAT_ACTIVITATS_WEB[$id]['desc']   = ( strlen( $OA->getDmig() ) > 5 );                                                                    
                            $LLISTAT_ACTIVITATS_WEB[$id]['img_m']  = file_exists( getcwd().'/images/activitats/A-'.$id.'-M.jpg' );
                            $LLISTAT_ACTIVITATS_WEB[$id]['img_l']  = file_exists( getcwd().'/images/activitats/A-'.$id.'-L.jpg' );
                            $LLISTAT_ACTIVITATS_WEB[$id]['img_xl'] = file_exists( getcwd().'/images/activitats/A-'.$id.'-XL.jpg' );                            
                            $LLISTAT_ACTIVITATS_WEB[$id]['nivell'] = $OA->getImportancia();                            
                        } else {
                            $LLISTAT_ACTIVITATS_WEB[$id]['OA']     = $OA;
                            $LLISTAT_ACTIVITATS_WEB[$id]['text']   = ( strlen( $OA->getTmig() ) > 5 );
                            $LLISTAT_ACTIVITATS_WEB[$id]['desc']   = ( strlen( $OA->getDmig() ) > 5 );                                                                    
                            $LLISTAT_ACTIVITATS_WEB[$id]['img_m']  = file_exists( getcwd().'/images/activitats/A-'.$id.'-M.jpg' );
                            $LLISTAT_ACTIVITATS_WEB[$id]['img_l']  = file_exists( getcwd().'/images/activitats/A-'.$id.'-L.jpg' );
                            $LLISTAT_ACTIVITATS_WEB[$id]['img_xl'] = file_exists( getcwd().'/images/activitats/A-'.$id.'-XL.jpg' );
                            $LLISTAT_ACTIVITATS_WEB[$id]['nivell'] = $OA->getImportancia(); 
                        }                                        
                                        
                    }       
                     
                endforeach;
                $this->LLISTAT_ACTIVITATS_WEB = $LLISTAT_ACTIVITATS_WEB;                                                                			   	  	                                                             									 
			break;      

                                                                
	}	
	
  }    
  
  //**************************************************************************************************************************************************
  // Control de personal i feines
  //**************************************************************************************************************************************************
  
  public function executeGPersonal(sfWebRequest $request)
  {
  	
  	$this->setLayout('gestio');
    $this->IDS = $this->getUser()->getSessionPar('idS');    
    
  	$this->CALENDARI = array();
    $this->ERROR = array();
  	$this->USUARI = $this->getUser()->getSessionPar('idU');
        
    //Identificador de línia 
  	$this->IDP = $request->getParameter('IDPERSONAL');
    
    //Data i usuari a qui se li aplica l'assignació
  	$this->DATE  = $this->getUser()->ParReqSesForm($request,'DATE',time());
    $this->IDU   = $this->getUser()->ParReqSesForm($request,'IDU',time());
    
    //Data del calendari
  	$this->DATAI = $this->getUser()->ParReqSesForm($request,'DATAI',time());
  	        	
  	$accio = $request->getParameter('accio');
  	
  	if($request->hasParameter('BSAVE')):    $accio = "SAVE_CHANGE";  endif; 
    if($request->hasParameter('BDELETE')):  $accio = "DELETE_CHANGE";  endif;
  	
  	$this->CALENDARI = PersonalPeer::getHoraris( $this->DATAI , $this->IDS );                  				  
    
    //Sempre carreguem el calendari
        //Cliquem un dia i apareix el llistat
            //Veiem la descripció
  	
  	switch($accio){
  		case 'CC':
                $this->getUser()->addLogAction('inside','gPersonal');
  			break;
  		case 'EDIT_DATE':
                $this->GPersonal_LoadDadesDia();
  			break;  			
  		case 'NEW_CHANGE':
                $this->GPersonal_LoadDadesDia();
  				$this->FPERSONAL = PersonalPeer::initialize($this->USUARI , $this->DATE, $this->IDU , null , $this->IDS );  				
  			break;
  		case 'EDIT_CHANGE':
                $this->GPersonal_LoadDadesDia();
  				$this->FPERSONAL = PersonalPeer::initialize($this->USUARI , $this->DATE , $this->IDU , $this->IDP , $this->IDS );
  			break;  			
  		case 'SAVE_CHANGE':  				
  				$RP = $request->getParameter('personal');
  				list($year,$month,$day) = explode("-",$RP['idData']);  				  				    
  				$idP = $RP['idPersonal']; $idU = $RP['idUsuari']; $idD = mktime(0,0,0,$month,$day,$year);
  										
  				$this->FPERSONAL = PersonalPeer::initialize($this->USUARI , $idD , $idU , $idP , $this->IDS );
  				$this->FPERSONAL->bind($RP);
  				
  				$this->IDP  = $this->FPERSONAL->getObject()->getIdpersonal();
  				$this->IDU  = $idU;
  				$this->DATE = $idD; 
  				
  				if($this->FPERSONAL->isValid()):
  					$this->FPERSONAL->save();
  					$this->getUser()->addLogAction($accio,'gPersonal',$this->FPERSONAL->getObject());                    
                    myUser::addLogTimeline( 'alta' , 'personal' , $this->getUser()->getSessionPar('idU') , $this->IDS , $this->FPERSONAL->getObject()->getIdpersonal() );
  					$this->redirect('gestio/gPersonal?accio=EDIT_DATE&DATE='.$idD.'&IDU='.$idU);
  				else: 
  					$this->ERROR[] = "Hi ha algun problema amb el formulari.";
  				endif; 
                $this->GPersonal_LoadDadesDia();
  			break;
  		case 'DELETE_CHANGE':            
                $RP = $request->getParameter('personal');
                list($year,$month,$day) = explode("-",$RP['idData']);  				  				    
  				$idP = $RP['idPersonal']; $idU = $RP['idUsuari']; $idD = mktime(0,0,0,$month,$day,$year);
                $OP = PersonalPeer::retrieveByPK($RP['idPersonal']);                                                    				
                $OP->setDatabaixa(date('Y-m-d',time()));
                $OP->setUsuariupdateid($this->USUARI);
                $OP->setActiu(false);                
                $OP->save();
                $this->getUser()->addLogAction($accio,'gPersonal',$OP);
                myUser::addLogTimeline( 'baixa' , 'personal' , $this->getUser()->getSessionPar('idU') , $this->IDS , $RP['idData'] );
				$this->redirect('gestio/gPersonal?accio=EDIT_DATE&DATE='.$idD.'&IDU='.$idU);				  			
  			break;
  	}
  	
  }

  private function GPersonal_LoadDadesDia()
  {
    //Editem un dia, i podem esborrar un canvi o bé afegir-ne un de nou.
    $this->DADES_DIA_USUARI = PersonalPeer::getDadesUpdates($this->DATE, $this->IDU , $this->IDS );
    $this->DIA = $this->DATE;  
  } 
  
  
  public function executeGCicles(sfWebRequest $request)
  {

    $this->setLayout('gestio');
    $this->IDS = $this->getUser()->getSessionPar('idS');

    $this->IDC = $request->getParameter('IDC');                
    $this->MODE   = "";
    
    $this->PAGINA = $request->getParameter('PAGINA');
    
    //Inicialitzem el formulari de cerca
    $this->CERCA = $this->getUser()->ParReqSesForm($request,'cerca',array('text'=>'','select'=>1));
    $this->FCerca = new CercaTextChoiceForm();       
    $this->FCerca->setChoice(array(1=>'Actiu',0=>'Inactiu')); 
	$this->FCerca->bind($this->CERCA);	
    
    $accio = $request->getParameter('accio');
    if($request->hasParameter('BSAVE')) $accio = 'SAVE';
    if($request->hasParameter('BDELETE')) $accio = 'DELETE';
    if($request->hasParameter('BNOU')) $accio = 'NOU';
            
            
    switch($accio)
    {    
    	case 'C':			
            $this->CERCA  = $this->getUser()->setSessionPar('cerca',array('text'=>'','select'=>1));
           	$this->FCerca->bind($this->CERCA);    		      			      	      		            
            $this->getUser()->addLogAction('inside','gCicles');  			   
    		break;
    	case 'NOU': 
    			$this->MODE = 'NOU';      
    			$this->FCICLES = CiclesPeer::initialize( 0 , $this->IDS ); 			
    		break;
    		
    	case 'EDITA':
    			$this->MODE = 'EDITA';    			      
    			$this->FCICLES = CiclesPeer::initialize( $this->IDC , $this->IDS );
    		break;
    		
    	case 'LLISTA':
    			$this->FCICLES = CiclesPeer::initialize( $this->IDC , $this->IDS );
    			$this->LACTIVITATS = ActivitatsPeer::getActivitatsCicles( $this->IDC , $this->IDS , false , null , false );
    		break;
    		
    	case 'SAVE':    		    		
    			$PC = $request->getParameter('cicles');
    			$this->FCICLES = CiclesPeer::initialize($PC['CicleID'],$this->IDS);    			
    			$this->FCICLES->bind($PC,$request->getFiles('cicles'));
    			if($this->FCICLES->isValid()):
    				$this->FCICLES->save();                        				
    				$this->getUser()->addLogAction($accio,'gCicles',$this->FCICLES->getObject());
                    myUser::addLogTimeline( 'alta' , 'cicles' , $this->getUser()->getSessionPar('idU') , $this->IDS , $PC['CicleID'] );
    			else: 
    				$this->MODE = 'EDITA';
    			endif; 
    		break;
    
    	case 'DELETE':                
    			$PC = $request->getParameter('cicles');
    			$FC = CiclesPeer::initialize($PC['CicleID'],$this->IDS);
    			$this->getUser()->addLogAction($accio,'gCicles',$FC);
                myUser::addLogTimeline( 'baixa' , 'cicles' , $this->getUser()->getSessionPar('idU') , $this->IDS , $PC['CicleID'] );
    			$FC->getObject()->setActiu(false);
                $FC->getObject()->save();
    		break;
        case 'ACTIVACIO':
                $PC = $request->getParameter( 'IDC' );
                $OC = CiclesPeer::initialize( $PC , $this->IDS )->getObject();
                $OC->doActivaInactiva();
                $OC->save();                
            break;
    		    		    
    }        
                
    $this->CICLES = CiclesPeer::getList($this->PAGINA , $this->CERCA , $this->IDS);    
  	
  }
  
  
   private function sendMail($from,$to,$subject,$body = "",$files = array())
   {    
        //Ho he passat a myUser per fer-ho més compatible amb totes les parts del programa. 
        myUser::sendMail($from,$to,$subject,$body,$files);
   }   
   
   
  public function executeGConfig(sfWebRequest $request)
  {
    
    $this->setLayout('gestio');
    $this->IDS = $this->getUser()->getSessionPar('idS');
    $this->accio = $request->getParameter('accio','C');
    $ROPTIONS = $request->getParameter('options',array('option_id'=>'0'));
    $RESPAIS = $request->getParameter('espais',array('EspaiID'=>'0'));
    $RMATERIAL = $request->getParameter('materialgeneric',array('idMaterialGeneric'=>''));
    $RDESCOMPTE = $request->getParameter('descomptes',array('idDescompte'=>'0'));    
    
    $this->FOPTIONS = OptionsPeer::initialize($ROPTIONS['option_id'],$this->IDS,false);
    $this->FESPAIS  = EspaisPeer::initialize($RESPAIS['EspaiID'],$this->IDS);        
    $this->FMATERIAL = MaterialgenericPeer::initialize($RMATERIAL['idMaterialGeneric'],$this->IDS);
    $this->FENTITAT = SitesPeer::initialize($this->IDS);
    $this->FDESCOMPTE = DescomptesPeer::initialize( $RDESCOMPTE['idDescompte'] , $this->IDS );

    //Agafem el codi de facebook de l'usuari
    $this->FBI = UsuarisPeer::getUserFbCode($this->getUser()->getSessionPar('idU'));    
    $this->PARS = array();    
    $this->PARS = myUser::f_FbAuth(false,$this->getController()->genUrl('@fb_link',true)); //Carreguem les dades del facebook.
    $this->ERROR = "";                
    
    if($request->hasParameter('BNEWOPTION')) $this->accio = 'NEW_OPTION';
    if($request->hasParameter('BSAVEOPTION')) $this->accio = 'SAVE_OPTION';
    if($request->hasParameter('BSAVEESPAI')) $this->accio = 'SAVE_ESPAI';    
    if($request->hasParameter('BDELETEESPAI')) $this->accio = 'DELETE_ESPAI';
    if($request->hasParameter('BSAVEMATERIAL')) $this->accio = 'SAVE_MATERIAL';    
    if($request->hasParameter('BDELETEMATERIAL')) $this->accio = 'DELETE_MATERIAL';
    if($request->hasParameter('BSAVESITE')) $this->accio = 'SAVE_SITE';    
    if($request->hasParameter('BSAVEDESCOMPTE')) $this->accio = 'SAVE_DESCOMPTE';    
    
    switch($this->accio){
        case 'AJAX_OPCIO':
            return $this->renderText(OptionsPeer::getString($request->getParameter('IDO'),$this->IDS));               
            break;
        case 'NEW_OPTION':
            $this->FOPTIONS = OptionsPeer::initialize($ROPTIONS['option_id'],$this->IDS,true);
            break;                                
        case 'SAVE_OPTION':
            $this->FOPTIONS->bind($ROPTIONS);
            if($this->FOPTIONS->isValid()):
                $this->FOPTIONS->save();                
                $this->getUser()->addLogAction($this->accio,'gConfig',$this->FOPTIONS->getObject());
                $this->FOPTIONS = OptionsPeer::initialize($this->FOPTIONS->getObject()->getOptionId(),$this->IDS,false);                
            endif;                
            break;
        case 'SAVE_ESPAI':                    
            //Si entrem un espai que és 0, llavors vol dir que fem un nou espai
            if($RESPAIS['EspaiID'] == 0) unset($RESPAIS['EspaiID']);                                          
            $this->FESPAIS->bind($RESPAIS,$request->getFiles('espais'));
            if($this->FESPAIS->isValid()):
                $this->FESPAIS->save();
                $this->getUser()->addLogAction($this->accio,'gConfig',$this->FESPAIS->getObject());
                $this->FESPAIS  = EspaisPeer::initialize($this->FESPAIS->getObject()->getEspaiid(),$this->IDS);                
            endif;
              
            //Agafem els multimèdia dels paràmetres
            $AMR = $request->getParameter('multimedia');
            $FMR = $request->getFiles('multimedia');                        
            foreach($AMR as $K => $MR):
                
                if($MR['accio'] == 1 || $MR['accio'] == 0): //És nou o una modificació
                    $FM = MultimediaPeer::initialize($MR['multimedia_id'],$MR['site_id'],$MR['taula'],$MR['id_extern'],$K);
                    $FM->bind($MR,$FMR[$K]);
                    $FM->saveNewUpdate();
                elseif($MR['accio'] == 2): //S'ha d'esborrar
                    $FM = MultimediaPeer::initialize($MR['multimedia_id'],$MR['site_id'],$MR['taula'],$MR['id_extern'],$K);
                    $FM->delete();                    
                endif;   
            endforeach;
            
            break;
        case 'DELETE_ESPAI':                        
            $this->FESPAIS->getObject()->setActiu(false)->save();            
            $this->getUser()->addLogAction($this->accio,'gConfig',$this->FESPAIS->getObject());
            $this->FESPAIS  = EspaisPeer::initialize(0,$this->IDS);                        
            break;
            
        case 'SAVE_MATERIAL':
            //Si entrem un espai que és 0, llavors vol dir que fem un nou espai
            if($RMATERIAL['idMaterialGeneric'] == 0) unset($RMATERIAL['idMaterialGeneric']);                              
            $this->FMATERIAL->bind($RMATERIAL);
            if($this->FMATERIAL->isValid()):
                $this->FMATERIAL->save();                
                $this->getUser()->addLogAction($this->accio,'gConfig',$this->FMATERIAL->getObject());
                $this->FMATERIAL  = MaterialgenericPeer::initialize($this->FMATERIAL->getObject()->getIdmaterialgeneric(),$this->IDS);                
            endif;
            break;
        case 'DELETE_MATERIAL':                        
            $this->FMATERIAL->getObject()->setInactiu();                        
            $this->getUser()->addLogAction($this->accio,'gConfig',$this->FMATERIAL->getObject());
            $this->FMATERIAL  = MaterialgenericPeer::initialize( 0 , $this->IDS );            
            break;
            
        //Vincula l'usuari del facebook            
        case 'FB_LINK':      
                $idU = $this->getUser()->getSessionPar('idU');
                $OU = UsuarisPeer::retrieveByPK($idU);
                                                
                $FB_ID = $this->PARS['user']['id'];
                
                //Mirem si el número de facebook està associat a un altre usuari. Si és així, no fem res però emetem error.                 
                $OUF = UsuarisPeer::getUserFromFacebook($FB_ID);
                if($OUF instanceof Usuaris){ $this->ERROR = 'El compte de facebook actual està vinculat a un altre usuari. <br />Si us plau comuniqui-ho a informatica@casadecultura.org o bé entri al seu usuari de facebook i torni-ho a provar.';  }
                elseif($OU instanceof Usuaris){ 
                    $OU->setFacebookid($this->PARS['user']['id']); 
                    $OU->save(); 
                }                
                $this->FBI = UsuarisPeer::getUserFbCode($this->getUser()->getSessionPar('idU'));
            break;
            
        //Desvincula l'usuari del facebook
        case 'FB_UNLINK':
                $idU = $this->getUser()->getSessionPar('idU');
                $OU = UsuarisPeer::retrieveByPK($idU);                                                
                $OU->setFacebookid(NULL);
                $OU->save();            
                $this->FBI = UsuarisPeer::getUserFbCode($this->getUser()->getSessionPar('idU'));    
            break;
        
        //Guardem els canvis a una entitat
        case 'SAVE_SITE':            
            $RS = $request->getParameter('sites');
            $this->FENTITAT->bind($RS,$request->getFiles('sites'));                                                                  
            if($this->FENTITAT->isValid()):
                $this->FENTITAT->save();
                $this->getUser()->addLogAction($this->accio,'gConfig',$this->FENTITAT->getObject());
                $this->FENTITAT = SitesPeer::initialize($this->IDS);                
            endif;
            break;

        case 'SAVE_DESCOMPTE':
            //Si entrem un descompte que és 0, vol dir que creem un nou descompte                                          
            $this->FDESCOMPTE->bind($RDESCOMPTE);
            if($this->FDESCOMPTE->isValid()):
                $this->FDESCOMPTE->save();                
                $this->getUser()->addLogAction($this->accio,'gConfig',$this->FDESCOMPTE->getObject());
                $this->FDESCOMPTE  = DescomptesPeer::initialize($this->FDESCOMPTE->getObject()->getIddescompte(),$this->IDS);                
            endif;
            break;
    }       
  }   
  
  public function executeGConfigSuperAdmin(sfWebRequest $request)
  {
    
    $this->setLayout('gestio');
    $this->IDS = $this->getUser()->getSessionPar('idS');
    $this->accio = $request->getParameter('accio','C');
    
    $RSITES = $request->getParameter('sites',array('site_id'=>1));
    $this->FSITES = SitesPeer::initialize($RSITES['site_id']);                   
    $this->SITE = $request->getParameter('SITE','');
                       
    if($request->hasParameter('BSAVESITE')) $this->accio = 'SAVE_SITE';    
    if($request->hasParameter('BDELETESITE')) $this->accio = 'DELETE_SITE';    
    if($request->hasParameter('BSAVEUSERSITE')) $this->accio = 'SAVE_USER_SITE';    
    if($request->hasParameter('BDELETEUSERSITE')) $this->accio = 'DELETE_USER_SITE';
    if($request->hasParameter('BSEARCHUSERSITES')) $this->accio = 'SEARCH_USER_SITES';
    if($request->hasParameter('BSAVEUSERMENU')) $this->accio = 'SAVE_USER_MENU';
        
    switch($this->accio){
        
        case 'SAVE_SITE':
            $this->FSITES->bind($RSITES);
            if($this->FSITES->isValid()):
                $this->FSITES->save();                
                $this->getUser()->addLogAction($this->accio,'gConfigSuperAdmin',$this->FSITES->getObject());
                $this->FSITES  = SitesPeer::initialize($this->FSITES->getObject()->getSiteId());                
            endif;
            break;
            
        case 'DELETE_SITE':                        
            $this->FSITES->getObject()->setActiu(false)->save();            
            $this->getUser()->addLogAction($this->accio,'gConfigSuperAdmin',$this->FSITES->getObject());
            $this->FESPAIS  = SitesPeer::initialize(0,$this->IDS);                        
            break;
                        
        case 'SAVE_USER_SITE':
            $RP = $request->getParameter('dades');  
            foreach($RP as $RS):                
                if($RS['IDU'] > 0 && $RS['IDN'] > 0 && $this->SITE > 0 ):                    
                    $OUS = UsuarisSitesPeer::initialize( $RS['IDU'] , $this->SITE , false )->getObject();                                                                
                    $OUS->setNivellId($RS['IDN']);
                    $OUS->setActiu(true);
                    $OUS->save();
                endif;                                                                            
            endforeach;
            $this->LUSERSITES = UsuarisSitesPeer::getSitesUsers($this->SITE,true);                        
            break;
            
        case 'DELETE_USER_SITE': 
            $USUARI = $request->getParameter('USUARI');                               
            $SITE = $request->getParameter('SITE');            
            $OUS = UsuarisSitesPeer::initialize( $USUARI , $SITE )->getObject();
            if(!$OUS->isNew()):
                $OUS->setActiu(false);
                $OUS->save();
                $this->LUSERSITES = UsuarisSitesPeer::getUserSites($this->SITE);
            endif;
            break;
                  
        case 'SAVE_USER_MENU':
            $IDS = $request->getParameter('MENU_SITES');
            $IDU = $request->getParameter('MENU_USUARIS');
            $LMENUS = $request->getParameter('MENU_DISPONIBLES');                                    
            if(!empty($LMENUS)) UsuarisMenusPeer::doUpdateMy( $IDU[0] , $IDS[0] , $LMENUS );                                                                                    
            break;
        
        case 'SEARCH_USER_SITES':            
            $IDS = $this->FMENUUSUARI->getValue('IDS');            
            $IDU = $this->FMENUUSUARI->getValue('IDU');
            if(!empty($IDS)){
                $this->FMENUUSUARI->setWidgetUsers();
                if(!empty($IDU)) $this->LMENUSUSUARI = GestioMenusPeer::getMenusUsuariArray($IDU,$IDS);
            }    
            break;
        
        default:
            break;
                                        
    }
     

    //Cerquem per SITE, que és més fàcil
    //Mirem quins usuaris hi ha a un SITE relacionats com a adminstradors
    //Mirem quins menús tenen els usuaris d'un SITE en general (els menús del primer usuari)

    $OS = SitesPeer::retrieveByPK($this->SITE);
    if($OS instanceof Sites):         
        $this->LUSERSITES = UsuarisSitesPeer::getSitesUsers($this->SITE,true);              
        $this->LMENUSUSUARI = GestioMenusPeer::getMenusUsuariArray($this->USUARI,$this->SITE);                
    else: 
        $this->USUARI = 0; 
        $this->LUSERSITES = array();                                                          
        $this->LMENUSUSUARI = array();
    endif; 
    
    $this->FMENUUSUARI = new ConfigSuperAdminMenusForm(null,array('IDS'=>$this->IDS));
    $this->FMENUUSUARI->bind($request->getParameter('super_admin_menus'));        

      
  }
  
  public function executeGTrac(sfWebRequest $request)
  {
    
    $this->setLayout('gestio');
    $this->IDS = $this->getUser()->getSessionPar('idS');
    $this->IDU = $this->getUser()->getSessionPar('idU');
    $this->IDT = $request->getParameter('idT','0');
    $this->accio = $request->getParameter('accio','C');
    $PB = $this->getUser()->getSessionPar('PB');
    $PU = $this->getUser()->getSessionPar('PU');
    $PI = $this->getUser()->getSessionPar('PI');

    //Primer carreguem el formulari per poder cercar en les actualitzacions
    //Després podem afegir una possible millora o bé afegir un error.
    
    //També sortirà un llistat per mostrar el que he corregit i la versió            
    $this->LBUGS = TracPeer::getBugsList($PB);
    $this->LUPGRADES = TracPeer::getUpgradesList($PU);
    $this->LIMPROVEMENTS = TracPeer::getImprovementsList($PI);
               
    if($request->hasParameter('BSAVEUPGRADE')) $this->accio = 'SAVE_UPGRADE';
    if($request->hasParameter('BDELETEUPGRADE')) $this->accio = 'DELETE_UPGRADE';
    if($request->hasParameter('BSAVEBUG')) $this->accio = 'SAVE_BUG';
    if($request->hasParameter('BDELETEBUG')) $this->accio = 'DELETE_BUG';    
        
    switch($this->accio){
        
        case 'EDIT_UPGRADE':
            $this->FUPGRADES = TracPeer::initialize($this->IDS,$this->IDU,TracPeer::TYPE_UPGRADE , $this->IDT );            
            break;
            
        case 'EDIT_BUG':                        
            $this->FBUGS = TracPeer::initialize($this->IDS,$this->IDU,TracPeer::TYPE_BUG  , $this->IDT);                        
            break;
                        
        case 'EDIT_IMPROVEMENT':
            $this->FBUGS = TracPeer::initialize($this->IDS,$this->IDU,TracPeer::TYPE_IMPROVEMENT  , $this->IDT);                         
            break;
            
        case 'SAVE_BUG': 
            $RP = $request->getParameter('trac');
            $FOT = TracPeer::initialize($this->IDS, $this->IDU, $RP['type'] , $RP['idTrac'] );
            $FOT->bind($RP);
            if($FOT->isValid()):
                $FOT->save();
                $this->redirect('gestio/gTrac');
            else: 
                $this->FBUGS = $FOT;            
            endif;                                                 
            break;

        case 'DELETE_BUG': 
            $RP = $request->getParameter('trac');
            $FOT = TracPeer::initialize($this->IDS, $this->IDU, $RP['type'] , $RP['idTrac'] );
            $OT = $FOT->getObject();
            $OT->setInactiu()->save();
            $this->redirect('gestio/gTrac');                                                           
            break;           

        case 'SAVE_UPGRADE': 
            $RP = $request->getParameter('trac');            
            $FOT = TracPeer::initialize($this->IDS, $this->IDU, $RP['type'] , $RP['idTrac'] );
            $FOT->bind($RP);
            if($FOT->isValid()):
                $FOT->save();
                $this->redirect('gestio/gTrac');
            else: 
                $this->FUPGRADES = $FOT;            
            endif;                                                 
            break;
            
        case 'DELETE_UPGRADE': 
            $RP = $request->getParameter('trac');
            $FOT = TracPeer::initialize($this->IDS, $this->IDU, $RP['type'] , $RP['idTrac'] );
            $OT = $FOT->getObject();
            $OT->setInactiu()->save();          
            $this->redirect('gestio/gTrac');                                                 
            break;           

                                   
    }     
  }  
  
  /**
   * Executa processos en background... que llança el sistema
   * */
  public function executeSBackground(sfWebRequest $request)
  {
    
    $accio = $request->getParameter('accio','');
    
    switch($accio){
        case 'RECORDATORI_RESERVA_ESPAIS':
                $LOR = ReservaespaisPeer::getReservesRecordatoriNoResposta();                
                foreach($LOR as $OR){
                    $idS = $OR->getSiteId();
                    $this->SendMailReservaEspais( $OR , $idS , true );    
                }
                $this->sendMail('informatica@casadecultura.org','informatica@casadecultura.org','Hospici :: Remember condicions',var_dump($LOR));
        break;
    }
    
    return sfView::NONE;
  }  
   
  
  public function executeAjaxGetSitesUsersOptions(sfWebRequest $request)
  {
    
    $IDS = $request->getParameter('IDS');
    $NIVELL = $request->getParameter('IDN');
    return $this->renderText(UsuarisSitesPeer::getSitesUsersOptions($IDS, $NIVELL));
    
  }

  public function executeAjaxGetMenusUsuarisOptions(sfWebRequest $request)
  {
    
    $IDU = $request->getParameter( 'IDU' );        
    $IDS = $request->getParameter( 'IDS' );
    
    return $this->renderText( UsuarisMenusPeer::getMenusUsuarisOptions( $IDU , $IDS ) );
    
  }  
   
    /**
     * Aquest funció serveix per fer UPLOAD d'arxius a una activitat
     * */
  public function executeUpload(sfWebRequest $request){
  
    $base = getcwd();
    $Opcio = $request->getParameter('OPCIO');
                
    if( $Opcio == 'DELETE' ):
    
        //Abans d'esborrar un arxiu, comprovaré que l'activitat sigui del site de l'usuari.
        $url = $request->getParameter('NOM_ARXIU');        
        $A = explode('-',$url); $id = $A[1]; $B = explode('/',$A[0]); $tipus = $B[2];
        $IDS = $this->getUser()->getSessionPar('idS');        
           
        if($tipus == 'activitats'):                                     
            $OA = ActivitatsPeer::retrieveByPK($id);
            if( $OA instanceof Activitats && $IDS == $OA->getSiteid() ):                
                unlink( $base.$url );
                return $this->renderText( "ok" );                                         
            endif;            
        elseif( $tipus == 'cicles' ):
            $OC = CiclesPeer::retrieveByPK($id);            
            if( $OC instanceof Cicles && $IDS == $OC->getSiteid() ):                
                unlink( $base.$url );
                return $this->renderText( "ok" );                                         
            endif;                                
        elseif( $tipus == 'cursos' ):
            $OC = CursosPeer::retrieveByPK($id);            
            if( $OC instanceof Cursos && $IDS == $OC->getSiteid() ):                
                unlink( $base.$url );
                return $this->renderText( "ok" );                                         
            endif;            
        endif; 
                                
        return $this->renderText( "ko" );         
    
    elseif( $Opcio == 'UPLOAD' ):
     
        $nom = $request->getParameter('qqfile');        
        $parts = explode(".", $nom); $extensio = end($parts);                
        $url = $request->getParameter('NOM_ARXIU'); 
        $url .= '.'.$extensio;                        
        
        $input = fopen("php://input", "r");
        $temp = tmpfile();
        $realSize = stream_copy_to_stream($input, $temp);
        fclose($input);        
                
        $target = fopen( $base.$url , "w" );        
        fseek($temp, 0, SEEK_SET);
        $size = stream_copy_to_stream($temp, $target);
        fclose($target);
        
        $result = true; 
        
        if($realSize > 0 && $size == $realSize) $result = array('success' => true); 
        else $return = array('error' => 'Hi ha hagut algun error carregant l\'arxiu.'); 
                   
        return $this->renderText( htmlspecialchars(json_encode($result), ENT_NOQUOTES) );

    endif; 

  }  
   
}