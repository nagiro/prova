<?php

/**
 * web actions.
 *
 * @package    intranet
 * @subpackage web
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */

class webActions extends sfActions
{
  /**
   * Executes index action
   * 
   */
   
  public function LoadWEB(sfWebRequest $request)
  {

    $this->setLayout('layout'); $this->ERRORS = array(); $this->FOTOS = array();
    $this->ACCIO = 'noticies'; $this->TIPUS_MENU = 'WEB';  $this->CERCA = "";      
    $this->ACTIVITATS_CALENDARI = array(); $this->LLISTES = array(); $this->RESERVES = ARRAY(); 
    $this->MATRICULES = array(); $this->CURSOS = array(); $this->FUSUARI = new ClientUsuarisForm(); $this->MISSATGE = array();
    $this->FRESERVA = new ClientReservesForm(); $this->DADES_MATRICULA = array();
    $this->OBERT = array(); $this->SELECCIONAT = 0;

    //Escollim les 4 fotos de la capçalera
	$this->FOTOS = $this->getFotos();	

	//Escollim els 3 banners de portada	
	$this->BANNERS = $this->getBanners();

	//Carreguem el menú
	$this->MENU = NodesPeer::retornaMenu();
	$this->OBERT = $this->getUser()->getAttribute('NODES',array());

	//Comprovem si està autentificat o no per mostrar el menú.
    if($this->getUser()->isAuthenticated()){
    	$this->TIPUS_MENU = 'ADMIN';
    }
   
    $this->DATACALENDARI = time();    
    
        //Emmagatzemo la data
    if($this->hasRequestParameter('DATACALENDARI')) $this->DATACALENDARI = $this->getRequestParameter('DATACALENDARI');
    elseif($this->getUser()->hasAttribute('DATACAL')) { $this->DATACALENDARI = $this->getUser()->getAttribute('DATACAL'); if(!is_double($this->DATACALENDARI)) $this->DATACALENDARI = time(); }    
    else $this->DATACALENDARI = time();    
    $this->getUser()->setAttribute('DATACAL', $this->DATACALENDARI);

    //Emmagatzemo la CERCA    
    if($request->hasParameter('CERCA')) $this->CERCA = $request->getParameter('CERCA');
    elseif($this->getUser()->hasAttribute('CERCA')) $this->CERCA = $this->getUser()->getAttribute('CERCA');
    else $this->CERCA = "";    
    $this->getUser()->setAttribute('CERCA',$this->CERCA);
    
  }

  public function executeCursos(sfWebRequest $request)
  {
     $this->LoadWeb($request);
     $this->setTemplate('index');
     $this->ACCIO = 'cursos';
     
  }

  public function executeEnviaContacte(sfWebRequest $request)
  {

     $this->LoadWeb($request);
     $this->setTemplate('index');
     $this->ACCIO = 'contacte';
     $this->ENVIAT = true;
     $FConsulta = new ConsultaForm();
     $FConsulta->bind($request->getParameter('consulta'));

     $BODY = "El senyor/a {$FConsulta->getValue('Cognoms')}, {$FConsulta->getValue('Nom')}".
             " amb telèfon {$FConsulta->getValue('Telefon')} i correu electrònic {$FConsulta->getValue('EMAIL')}".
             " vol fer el següent comentari : {$FConsulta->getValue('Missatge')} "; 
          
	try {
	 
	  $mailer = new Swift(new Swift_Connection_NativeMail());
	  $message = new Swift_Message(' CCG :: Formulari contacte Web ', $BODY, 'text/html');
	 
	  $mailer->send($message, 'informatica@casadecultura.org', 'web@casadecultura.cat');
	  $mailer->disconnect();
	} catch (Exception $e) {  $mailer->disconnect(); }     
          
  }
  
  public function executeContacte(sfWebRequest $request)
  {
     $this->LoadWeb($request);
     $this->setTemplate('index');
     $this->ACCIO = 'contacte';
     $this->FConsulta = new ConsultaForm();     
     $this->ENVIAT = false;
  }
  
  public function executeLogout()
  {
     $this->getUser()->setAuthenticated(false);
	 $this->getUser()->setAttribute('idU',NULL);
	 $this->redirect('web/index');
  }
  
  public function executeRegistre(sfWebRequest $request)
  {

     $this->LoadWEB($request);
     $this->setTemplate('index');     
     $this->ACCIO = 'registre';
     $this->FUSUARI = new ClientUsuarisForm();
     $this->ESTAT = '---'; 
  }
  
  public function executeRegistrat(sfWebRequest $request)
  {
  	//Inicialitzem l'usuari per defecte.  	  	
  	$this->FUSUARI = new ClientUsuarisForm(new Usuaris());
  	$this->FUSUARI->bind($request->getParameter('usuaris'));
  	
  	//Comprovem que el DNI no existeixi. Si ja existeix informem l'usuari
     $C = new Criteria();
     $C->add(UsuarisPeer::DNI , $this->FUSUARI->getValue('DNI'));
  	
  	$DUPLICAT = (UsuarisPeer::doCount($C) > 0);
  	if($this->FUSUARI->isValid() && !$DUPLICAT) $this->FUSUARI->save();

  	 if($DUPLICAT) $this->ESTAT = 'ERROR'; else $this->ESTAT = 'OK';  	     
     $this->LoadWEB($request); $this->setTemplate('index'); $this->ACCIO = 'registre';           
     
  }
  
  
  public function executeRemember(sfWebRequest $request)
  {
  	
  	 $this->LoadWEB($request);
     $this->setTemplate('index');
	 $this->ACCIO = 'remember';
	 $this->dni = $request->getParameter('dni');
	 
	 if($request->getMethod('post') && $request->hasParameter('BREMEMBER')):	 
	 	$dni = $request->getParameter('dni');
	    if(empty($dni)):	    
	    	$this->ERROR = "No ha entrat cap DNI.";
	    	$this->ENVIAT = false;
	    else: 
	    	$OUsuari = UsuarisPeer::cercaDNI($dni);
	    	if($OUsuari instanceof Usuaris): 
	 				    			    	
	 			$BODY = "Benvolgut/da, \n\n La seva contrasenya és : {$OUsuari->getPasswd()}.\n\n Cordialment, Casa de Cultura de Girona. ";          
				try {
						$mailer = new Swift(new Swift_Connection_NativeMail());
						$message = new Swift_Message(' CCG :: Recordatori de contrasenya ', $BODY, 'text/html');
	 
						$mailer->send($message, $OUsuari->getEmail(), 'informatica@casadecultura.org');
	  					$mailer->disconnect();
					} catch (Exception $e) {  $mailer->disconnect(); }
					$this->ENVIAT = true;
					 
			else: 
				$this->ERROR = "L'usuari amb aquest DNI no existeix.";
				$this->ENVIAT = false; 			
			endif;
		endif;	 		 	
	 else:
	 	$this->ERROR = "";
	 	$this->ENVIAT = false; 
	 endif;
         
  }
  
  public function executeLogin(sfWebRequest $request)
  {
     $this->LoadWEB($request);
     $this->setTemplate('index');

     $this->FLogin = new LoginForm();
     $this->ERROR = "";
     
     if($request->hasParameter('form_login_remember')):
     	$this->redirect('web/remember');     
     endif;
     
     if($request->hasParameter('form_login_new')):
     	$this->redirect('web/registre');
     else:
     	$this->ACCIO = 'login';
     endif; 
     
     if($request->isMethod('POST')):
     	$this->FLogin = new LoginForm();
     	$this->FLogin->bind($request->getParameter('login'));
     	if($this->FLogin->isValid()):
     		 $L = $request->getParameter('login');     		 
     		 $USUARI = UsuarisPeer::getUserLogin($L['nick'], $L['password']);     		 
     		 if($USUARI instanceof Usuaris):
     		 	$this->getUser()->setAttribute('idU',$USUARI->getUsuariid());     		
     		 	$this->getUser()->setAuthenticated(true);
     		 	if($USUARI->getNivellsIdnivells() == 1) { $this->getUser()->addCredential('admin'); }
     		 	if($USUARI->getNivellsIdnivells() == 2) { $this->getUser()->addCredential('user'); }	    		   			    		
     		 	$this->redirectif( $USUARI->getNivellsIdnivells() == 1 , 'gestio/main' );
     		 	$this->redirectif( $USUARI->getNivellsIdnivells() == 2 , 'web/gestio?accio=gd');
     		 else: 
     		 	$this->ERROR = "El DNI o la contrasenya són incorrectes";
     		 endif;
        else:
        	 $this->ERROR = "El DNI o la contrasenya són incorrectes";
			 $this->ACCIO = 'login';
        endif;     		 
     endif;
               
  }
    
  
  public function executeIndex(sfWebRequest $request)
  {      
    
    $this->LoadWEB($request);    

    $accio = $request->getParameter('accio');    
        
    if($request->hasParameter('BCERCA_x') || ( !empty($this->CERCA) && ( !$request->hasParameter('accio') ))) $accio = 'se';                
    
    switch($accio){

      //Consulta una pàgina determinada
      case 'cp':      		
            $this->PAGINA = NodesPeer::retrieveByPK($this->getRequestParameter('node'));
            $this->ACCIO  = 'web';
            $this->gestionaNodes($request->getParameter('node'));            
            $this->SELECCIONAT = $this->getRequestParameter('node');
            break;

       //Mostra les activitats quan cliquem un dia del calendari
	   case 'ca':	        	    		        	    
	    	$this->ACTIVITATS_LLISTAT = ActivitatsPeer::getActivitatsDia(date('Y-m-d',$this->DATACALENDARI));
	    	$this->ACCIO = 'activitats';
	       	break;

       //Mostra les activitats quan cliquem la cerca
	   case 'se': 
	   		$this->CarregaCerca(false,$this->DATACALENDARI); 
	   		break;
	   	   
	   //Per defecte mostrem les notícies
	   case 'no':	   		
	   default: 
	   	    $this->ACTIVITATS_LLISTAT = ActivitatsPeer::getNoticies();             
	 		$this->ACCIO = 'noticies';	         
	 		$this->getUser()->setAttribute('HEFETCERCA',false);
	 		$this->getUser()->setAttribute('NODES',array());	 	   	
			break;		
   }
   
   $this->OBERT = $this->getUser()->getAttribute('NODES',array());
                          
  }
  
  public function gestionaNodes($NO)
  {  	
	$NODES = $this->getUser()->getAttribute('NODES',array());
	
	if(in_array($NO,$NODES)):
		unset($NODES[$NO]);
	else:
		$NODES[$NO] = $NO;
	endif;
		
	$this->getUser()->setAttribute('NODES',$NODES);
		
  }
  
  
  /**
   * Funció crdidada des de Index que em retorna la cerca. Si entrem CONSULTADIA només tornarà 
   *
   */
  public function CarregaCerca($CONSULTADIA = false , $DATA )
  {      

     $Di = mktime(0,0,0,date('m',$DATA), 01 , date('Y',$DATA)); 
     $Df = mktime(0,0,0, date('m',$DATA)+1 , 01 , date('Y',$DATA));
     
     if($CONSULTADIA):
        $SOL = HorarisPeer::getCerca( null , $this->CERCA , $Di , $Df , null );	    		    		    
	    $this->ACTIVITATS_CALENDARI = $SOL['CALENDARI'];
	    $this->DATA    = $DATA;
	 else:      
	     //Passo les activitats i els horaris per marcar al calendari perquè he fet una cerca     
		 $SOL = HorarisPeer::getCerca( null , $this->CERCA , $Di , $Df , null );	    		    		    
		 $this->ACTIVITATS_CALENDARI = $SOL['CALENDARI']; 
		 if(!$CONSULTADIA) $this->ACTIVITATS_LLISTAT = $SOL['ACTIVITATS'];
		 $this->QUANTES = sizeof($SOL['ACTIVITATS']);
		 $this->DATA    = $DATA;
		 $this->ACCIO = 'agenda';
		 $this->getUser()->setAttribute('HEFETCERCA',true);		 
	 endif;
	 	     	        
  }
  
  /**
   * Funció on anem a parar si premem un boto de l'apartat de "cursos"
   * 
   */
  
  public function executeMatriculat(sfWebRequest $request)  
  {
     
     $this->redirectif($request->hasParameter('BNOUALUMNE'), 'web/registre' );     
     $this->redirectif($request->hasParameter('BREGISTRAT'), 'web/gestio?accio=gc');
          
  }
  
  public function executeGestio(sfWebRequest $request)
  {
     $this->LoadWEB($request);
     $this->setTemplate('index');
     
     $accio = $this->getRequestParameter('accio');
          
     switch($accio){
       case 'gd':
		    $this->MODUL = 'gestiona_dades';
		    $this->ACCIO = 'gestio';
		    $OU = UsuarisPeer::retrieveByPK($this->getUser()->getAttribute('idU'));
		    $this->FUSUARI = new ClientUsuarisForm($OU);       	       	     
	        break;
	   case 'gc':
	        $this->MODUL = 'gestiona_cursos';
            $this->ACCIO = 'gestio';                        
            $this->MATRICULES = MatriculesPeer::getMatriculesUsuari($this->getUser()->getAttribute('idU'));                                                               
            break;
	   case 'gl':
			$this->MODUL = 'gestiona_llistes';
			$this->ACCIO = 'gestio';
			$this->LLISTES = UsuarisllistesPeer::getLlistesUsuari($this->getUser()->getAttribute('idU'));            
			break;
	   case 'gr':
	        $this->MODUL = 'gestiona_reserves';
	        $this->ACCIO = 'gestio';	        
	        $this->RESERVES = ReservaespaisPeer::getReservesUsuaris($this->getUser()->getAttribute('idU'));
	        $this->getUser()->setAttribute('idR',0);
	        if($request->getParameter('idR')){
	        	$OR = ReservaespaisPeer::retrieveByPK($this->getRequestParameter('idR'));
	        	$this->FRESERVA = new ClientReservesForm($OR);
	        	$this->getUser()->setAttribute('idR',$OR->getReservaespaiid());	        		        
	        } 	        
	        break;
	   case 'sd':
	   		$this->MODUL = 'gestiona_dades'; $this->ACCIO = 'gestio';		    		    
	   		$OU = UsuarisPeer::retrieveByPK($this->getUser()->getAttribute('idU'));
	   		$this->FUSUARI = new ClientUsuarisForm($OU);
	   		$this->FUSUARI->bind($request->getParameter('usuaris'));
	   		if($this->FUSUARI->isValid()) { $this->FUSUARI->save(); $this->MISSATGE[] = "Dades modificades correctament"; }
	   		else $this->MISSATGE[] = 'Hi ha algun error a les dades';     
	        break;       	                    	             	        
	   case 'sl':
	        UsuarisllistesPeer::saveUsuarisLlistes($request->getParameter('LLISTA'), $this->getUser()->getAttribute('idU'));
	        $this->MODUL = 'gestiona_llistes'; $this->ACCIO = 'gestio';
		    $this->LLISTES = UsuarisllistesPeer::getLlistesUsuari($this->getUser()->getAttribute('idU'));
		    $this->MISSATGE[] = "Dades modificades correctament";
	        break;
	   case 'sr':
	   	
	   		//Carreguem el formulari que hem carregat per edició o res per nou	
			$OR = ReservaespaisPeer::retrieveByPK($this->getUser()->getAttribute('idR'));
			
			//Si en trobem un, creem el formulari altrament un de nou
			if($OR instanceof Reservaespais) $this->FRESERVA = new ClientReservesForm($OR);
			else $this->FRESERVA = new ClientReservesForm(new Reservaespais());

			//Entrem les dades del formulari	
			$this->FRESERVA->bind($request->getParameter('reservaespais'));
			
			//Si és correcte el guardem
			if($this->FRESERVA->isValid()):
				$this->FRESERVA->setUser($this->getUser()->getAttribute('idU'));
				$this->FRESERVA->save();
				$this->MISSATGE[] = "Dades modificades correctament";
			else:
				$this->MISSATGE[] = "Hi ha alguna dada incorrecta al formulari";	
			endif;			
			
			//Posem les dades de càrrega del mòdul
	        $this->RESERVES = ReservaespaisPeer::getReservesUsuaris($this->getUser()->getAttribute('idU'));
	        $this->MODUL = 'gestiona_reserves'; $this->ACCIO = 'gestio';		    
		    		       
	        break;

	   //Anul·la la reserva
	   case 'ar':
	   		$RE = ReservaespaisPeer::retrieveByPK($this->getUser()->getAttribute('idR'));	   			   		
	   		if($RE instanceof Reservaespais):
	   			$RE->setEstat(ReservaespaisPeer::ANULADA);
	   			$RE->save();
	   		endif;
	   		
			//Posem les dades de càrrega del mòdul
	        $this->RESERVES = ReservaespaisPeer::getReservesUsuaris($this->getUser()->getAttribute('idU'));
	        $this->MODUL = 'gestiona_reserves'; $this->ACCIO = 'gestio';		    	   		
	   		break;
	   		
	   case 'im':   //Iniciem la matrícula	                                    
            $D = $request->getParameter('D');            
            $USUARI = UsuarisPeer::retrieveByPK($this->getUser()->getAttribute('idU'));
            $this->DADES_MATRICULA['DNI'] = $USUARI->getDni();
            $this->DADES_MATRICULA['NOM'] = $USUARI->getNomComplet();
            $this->DADES_MATRICULA['IDU'] = $this->getUser()->getAttribute('idU');
            $this->DADES_MATRICULA['MODALITAT'] = MatriculesPeer::PAGAMENT_TARGETA;
            $this->DADES_MATRICULA['DESCOMPTE'] = $D['DESCOMPTE'];
            $this->DADES_MATRICULA['DATA'] = date('d-m-Y h:m',time());
            $this->DADES_MATRICULA['COMENTARI'] = "MATRÍCULA INTERNET";
            $this->DADES_MATRICULA['PREU'] = CursosPeer::CalculaTotalPreus($D['CURSOS'],$D['DESCOMPTE']);
            $this->DADES_MATRICULA['CURSOS'] = implode('@',$D['CURSOS']);
              
            $matricules = $this->guardaMatricula($this->DADES_MATRICULA); 
              
            //Carreguem el TPV
            $this->TPV = MatriculesPeer::getTPV($this->DADES_MATRICULA['PREU'] , $this->DADES_MATRICULA['NOM'] , $matricules );
            $this->ACCIO = "verifica";
            $this->MODUL = "gestiona_verificacio";                                                      
	        break;
     }
     
  }
  
  private function guardaMatricula( $DADES_MATRICULA , $EDIT = false , $IDMATRICULA = 0 )
  {
     $matricules = ARRAY();
     $M = new Matricules();
     if($EDIT) { $M = MatriculesPeer::retrieveByPK($IDMATRICULA); $M->setNew(false); }     
     
     $M->setUsuarisUsuariid($DADES_MATRICULA['IDU']);          
     $M->setEstat(MatriculesPeer::PROCES_PAGAMENT);        
     $M->setComentari("Pagament internet");
     $M->setDatainscripcio($DADES_MATRICULA['DATA']);     
     $M->setTreduccio($DADES_MATRICULA['DESCOMPTE']);
     $M->setTpagament(MatriculesPeer::PAGAMENT_TARGETA);
     
     foreach(explode('@',$DADES_MATRICULA['CURSOS']) as $C):
        $M->setCursosIdcursos($C);
        $M->save();
        $matricules[] = $M->getIdmatricules(); 
     endforeach;
     
     return $matricules;
     
  }
      
  
  private function getFotos()
  {
  	$FOTOS = array();
  	while(sizeof($FOTOS) < 4):
    	srand (time());
		$NumAleatori = rand(1,14);
		$FOTOS[$NumAleatori] = $NumAleatori;		
	endwhile;  	
	return $FOTOS;
  }
  
  private function getBanners()
  {
  	//Inicialitzacions
  	$TEMP = array('FIX'=>array() , 'VAR'=>array()); $BANNERS = array(); $C = new Criteria();
  	   	
	//Selecció i consulta de les promocions
  	$C->add(PromocionsPeer::ISACTIVA, true); $C->addAscendingOrderByColumn(PromocionsPeer::ORDRE);  	  	
  	$OP = PromocionsPeer::doSelect($C); $i = 0;
  	foreach($OP as $O):  		
		if($O->getIsfixa()):					
			$TEMP['FIX'][$O->getExtensio()]['URL'] = $O->getUrl();
			$TEMP['FIX'][$O->getExtensio()]['IMG'] = $O->getExtensio();				
		else:
			$TEMP['VAR'][$i]['URL'] = $O->getUrl();
			$TEMP['VAR'][$i++]['IMG'] = $O->getExtensio();
		endif;
	endforeach;
	
	//Entrem els BANNERS FIXOS
  	foreach($TEMP['FIX'] as $K=>$T):
  		$BANNERS[$T['IMG']] = $T;  	
  	endforeach;
  		  				
  	//Entrem els BANNERS VARIABLES
	$M_VAR = sizeof($TEMP['VAR'])-1;   //Agafem la mida de l'array de variables		
	
	while(sizeof($BANNERS) < 3):
    	srand (time());
		$NumAleatori = rand( 1 , $M_VAR );	
		$BANNERS[$TEMP['VAR'][$NumAleatori]['IMG']] = $TEMP['VAR'][$NumAleatori];		
	endwhile;	
	
	return $BANNERS;
  }
  
   public function executeEspais(sfWebRequest $request)
   {
      $this->LoadWEB($request);            
      $this->setTemplate('index');
      $this->ACCIO = 'espais';
   }
   
   public function executeReenviaContrasenya(sfWebRequest $request)
   {
      $this->LoadWEB($request);
      $this->setTemplate('index');
      $this->ACCIO = 'missatge';      
      
	   // class initialization
	  $mail = new sfMail();
	  $mail->initialize();
	  $mail->setMailer('sendmail');
	  $mail->setCharset('utf-8');
	  $C = new Criteria();
	  $C->add(UsuarisPeer::DNI, $this->getRequestParameter('DNI'));
	  $U = UsuarisPeer::doSelect($C);
	  $DNI      = $this->getRequestParameter('DNI');
	  if(sizeof($DNI) == 0) { $this->MISSATGE = 1; return;} 
	  $password = $U[0]->getPasswd();
	  $email    = $U[0]->getEmail();
	  	 
	  // definition of the required parameters
	  $mail->setSender('informatica@casadecultura.org', 'Casa de Cultura de Girona');
	  $mail->setFrom('informatica@casadecultura.org', 'Casa de Cultura de Girona');
	 
	  $mail->addAddress($email);
	 
	  $mail->setSubject('La seva contrasenya');
	  $mail->setBody("
	  Benvolgut/da,
	 
	  La contrassenya d'accés per al DNI $DNI és $password. 
	 
	  Cordialment,
	  Casa de Cultura de Girona.");
	 
	  // send the email
	  $mail->send();

	  $this->MISSATGE = 2;
      
   }
  
   public function executeFuncionament(sfWebRequest $request)
   {
      $this->LoadWEB($request);
      $this->setTemplate('index');
      $this->ACCIO = 'funcionament';      
   }
   
}
