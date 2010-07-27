<?php

/**
 * web actions.
 *
 * @package    intranet
 * @subpackage web
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 * 
 */

class webActions extends sfActions
{

  public function gestionaNodes($NO)
  {  	
  	
	$NODES = $this->getUser()->getSessionPar('NODES',array());
	
	if(in_array($NO,$NODES)):
		unset($NODES[$NO]);
	else:
		$NODES[$NO] = $NO;
	endif;				
	
	$this->getUser()->setSessionPar('NODES',$NODES);
	return $NODES;
		
  }
	
  public function LoadWEB(sfWebRequest $request)
  {
	
  	//Carrego els banners i les fotos que mostraré
  	//Si s'entra un menú, carrego el contingut que toca segons el menú
  		//Si el menú és només títol, mostro l'estructura de directoris
  		//Si el menú té contingut, 
  			//Si el contingut és automàtic, mostro el contingut automàtic
  			//Si el contingut és manual, mostro el contingut manual
  	//Si s'entra una cerca, carrego les activitats que corresponen a la cerca i marco el calendari els dies
  	//Si s'entra un dia del calendari, cerco les activitats d'aquell dia
  	//Si no es cap, carrego les notícies de les últimes activitats...
  	
  	$this->setLayout('layout');   	
  	$this->FOTOS = $this->getFotos();
  	$this->BANNERS = $this->getBanners();  	
	$this->MENU = NodesPeer::retornaMenu();	
	$this->USUARI = $this->getUser()->getSessionPar('idU',0);
	$this->SELECCIONAT = 0;	  	
	$this->LLISTAT_ACTIVITATS = array();
	$this->ACTIVITATS_CALENDARI = array();
	
	if($this->getUser()->isAuthenticated()){ $this->TIPUS_MENU = 'ADMIN'; } else { $this->TIPUS_MENU = 'WEB'; }
    $this->DATACAL = $this->getUser()->ParReqSesForm($request,'DATACAL',time());            
    $this->PAGINA = $this->getUser()->ParReqSesForm($request,'p',1);

    //Gestió de menús
    $idN = $request->getParameter('node',0);   	
    $this->OBERT = $this->gestionaNodes($idN);    
      	
  	$this->accio = $request->getParameter('accio');  	  	
  	
  	if($request->hasParameter('BCERCA_x')):    	 
    	$this->CERCA = $this->getUser()->ParReqSesForm($request,'CERCA',"");
    	$this->accio = 'c';
    else: 
    	$this->CERCA = "";
    endif;
  	
  	  	
  	switch($this->accio){  		  		  		
  		//Contingut manual
  		case 'mc':
				$this->NODE = NodesPeer::selectPagina($idN);
				$this->ACCIO = 'web';								    				
  			break;
  			
  		//Contingut automàtic de cicles		
  		case 'ac':
  			$this->NODE = NodesPeer::selectPagina($idN);
  			if(!$this->NODE->isNew()):
  				$cat = $this->NODE->getCategories();
				$this->LLISTAT_CICLES = ActivitatsPeer::getCiclesCategoria($cat);
	     		$this->ACCIO = 'llistatCiclesCategoria';
	     		$ACT = ActivitatsPeer::selectCategories(true);
	     		$this->TITOL = "Cicles i activitats a \"".$ACT[$cat].'"';
	     		$this->CAT   = $cat;	     		
	     	endif;   			  			
  			break;
  			
  		//Contingut automàtic d'activitats d'un cicle
		 case 'aca':
		 		$this->CAT = $request->getParameter('cat','');
		 		$this->IDC = $request->getParameter('idc',1);
		 		$this->PAGINA = $request->getParameter('p',1);
		 		
		 		
		 		$OC = CiclesPeer::retrieveByPK($this->IDC);
		 		$this->TITOL = 'Llistat d\'activitats del cicle '.$OC->getNom();
		 				 		
		 		$this->LLISTAT_ACTIVITATS = ActivitatsPeer::getActivitatsCicles($this->IDC,true,$this->PAGINA);
  				$this->ACCIO = 'llistatActivitatsCicleCategoria';	     			     			     			
	     		   			  			
  			break;
  			
  		//Cerca  			
  		case 'c':  			  			
  			$this->LLISTAT_ACTIVITATS = ActivitatsPeer::getActivitatsCerca( $this->CERCA , $this->DATACAL  , $this->PAGINA );  						
	    	$this->ACCIO = 'llistat_activitats_cerca';
	    	$this->TITOL = 'ACTIVITATS TROBADES AMB LA CERCA "'.$this->CERCA.'"';
	    	$this->MODE  = 'CERCA';			
  			break;
  			
  		//Cerca un dia
		case 'ca':						
			$this->LLISTAT_ACTIVITATS = ActivitatsPeer::getActivitatsDia(date('Y-m-d',$this->DATACAL),$this->PAGINA);			
	    	$this->ACCIO = 'llistat_activitats';
	    	$this->TITOL = 'ACTIVITATS EL DIA '.date('d/m/Y',$this->DATACAL);
	    	$this->MODE  = 'DIA';			
  			break;

  		//Mostra una sola activitat
		case 'caa':
			$this->LLISTAT_ACTIVITATS = array(ActivitatsPeer::retrieveByPK($request->getParameter('idA')));
  			$this->ACCIO = 'mostra_activitat';
  			$this->TITOL = 'Informació de l\'activitat';	     			     			     		
			break;		
			
  		//Canvi data del calendari
		case 'cdc':
				$this->DATACAL = $this->getUser()->ParReqSesForm($request,'DATACAL',time());
				$this->redirect('web/index?accio=c');							
			break;
  		//Mostrem notícies		  	
		default:
			
			$this->IDN = $request->getParameter('idn',0);
			$this->PAGINA = $request->getParameter('p',1);
			
	   		if($this->IDN > 0):	   			
	   			$this->NOTICIA = NoticiesPeer::getNoticia($this->IDN);
	   			$this->NOTICIES = null;
	   		else: 	   			 
	   			$this->NOTICIA = null;
	   			$this->NOTICIES = NoticiesPeer::getNoticies('%',$this->PAGINA,true);
	   		endif; 	   	                 
	 		$this->ACCIO = 'noticies';	         	 		
	 		$this->getUser()->setSessionPar('NODES',array());	 	   				
			break;
			
			break;					  			
  	}
  	  	              
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
          
	  $this->sendMail('informatica@casadecultura.org','informatica@casadecultura.org',' CCG :: Formulari contacte Web ',$BODY);
               
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
	 $this->getUser()->setSessionPar('idU',NULL);
	 $this->redirect('web/index');
  }
  
  public function executeRegistre(sfWebRequest $request)
  {

     $this->LoadWEB($request);
     $this->setTemplate('index');     
     $this->ACCIO = 'registre';     
     $rand = array(1=>rand(0,10),2=>rand(0,10));
	 $this->getUser()->setSessionPar('rand',$rand);		    
	 $this->FUSUARI = new ClientUsuarisForm(new Usuaris(),array('rand'=>$rand));
     $this->ESTAT = '---'; 
  }
  
  public function executeRegistrat(sfWebRequest $request)
  {
  	$this->LoadWEB($request);
  	
  	//Inicialitzem l'usuari per defecte.
  	$this->FUSUARI = new ClientUsuarisForm(new Usuaris(),array('rand'=>$this->getUser()->getSessionPar('rand')));  	     
    $this->FUSUARI->bind($request->getParameter('usuaris'));
  	
  	//Comprovem que el DNI no existeixi. Si ja existeix informem l'usuari
    $C = new Criteria();
    $C->add(UsuarisPeer::DNI , $this->FUSUARI->getValue('DNI'));
  	
  	$DUPLICAT = (UsuarisPeer::doCount($C) > 0);  	
  	if($this->FUSUARI->isValid() && !$DUPLICAT){
  		$this->FUSUARI->save();  		
  		$this->ESTAT = 'ALTA_OK';  		
  	} else { $this->ESTAT = "ERROR_VALID"; }  	
  	  	
 
  	 if($DUPLICAT) $this->ESTAT = 'DUPLICAT';       
     $this->setTemplate('index'); 
     $this->ACCIO = 'registre';           
     
  }
  
  
  public function executeRemember(sfWebRequest $request)
  {
  	
  	 $this->LoadWEB($request);
     $this->setTemplate('index');
	 $this->ACCIO = 'remember';
	 	 	 	  	 
	 if($request->getMethod('post') && $request->hasParameter('BREMEMBER')):
	 
	 	$this->FREMEMBER = new RememberForm(null,array('rand'=>$this->getUser()->getSessionPar('rand')));
	 	$this->FREMEMBER->bind($request->getParameter('remember'));
	 	$temp = $request->getParameter('remember');
	 	$dni = $temp['DNI'];
	 		 
	 	
    	$OUsuari = UsuarisPeer::cercaDNI($dni);
    	if($OUsuari instanceof Usuaris && $this->FREMEMBER->isValid()): 
 				    			    	
 			$BODY = "Benvolgut/da, <br /> La seva contrasenya és : <b>{$OUsuari->getPasswd()}</b>. <br /><br />Cordialment,<br /> Casa de Cultura de Girona. ";
			$this->ENVIAT = $this->sendMail('informatica@casadecultura.org',$OUsuari->getEmail(),' CCG :: Recordatori de contrasenya ',$BODY);          

		elseif($this->FREMEMBER->isValid()):
		
			$this->ERROR = "El DNI no existeix o suma incorrecte.";
			$this->ENVIAT = false; 			
			
		else:
		 
			$this->ERROR = "";
			$this->ENVIAT = false;
			 								 		 			
		endif;
					 		 
	 else:
	 
	 	//Inicialitzem el formulari
		$rand = array(1=>rand(0,10),2=>rand(0,10));
		$this->getUser()->setSessionPar('rand',$rand);		    	 	
		$this->FREMEMBER = new RememberForm(null,array('rand'=>$rand));
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
     	$L = $request->getParameter('login');     		 
     	$this->FLogin = new LoginForm();
     	$this->FLogin->bind($L);
     	if($this->FLogin->isValid()):     		 
     		 $USUARI = UsuarisPeer::getUserLogin($L['nick'], $L['password']);     		 
     		 if($USUARI instanceof Usuaris):
     		 	$this->getUser()->setSessionPar('idU',$USUARI->getUsuariid());     		 	      		
     		 	$this->getUser()->setAuthenticated(true);
    			if($USUARI->getNivellsIdnivells() == 1) { $this->getUser()->addCredential('admin'); }
     		 	if($USUARI->getNivellsIdnivells() == 2) { $this->getUser()->addCredential('user'); }

     		 	//Guardem un registre del login
     		 	$this->getUser()->addLogAction('login','login',$L);
     		 	
     		 	$this->redirectif( $USUARI->getNivellsIdnivells() == 1 , 'gestio/main' );
     		 	$this->redirectif( $USUARI->getNivellsIdnivells() > 1 , 'web/gestio?accio=landing');     		 	
     		 else:     		 	
     		 	$this->getUser()->addLogAction('error','login',$L);     		 
     		 	$this->ERROR = "El DNI o la contrasenya són incorrectes";
     		 endif;
        else:
        	 $this->getUser()->addLogAction('error','login',$L);
        	 $this->ERROR = "El DNI o la contrasenya són incorrectes";
			 $this->ACCIO = 'login';
        endif;     		 
     endif;
               
  }
  
  
  public function executeIndex(sfWebRequest $request)
  {      
    
  	//Carrego les notícies de les últimes activitats... 
  	//Carrego els banners que mostraré
  	//Si s'entra un menú, carrego el contingut que toca segons el menú
  		//Si el menú és només títol, mostro l'estructura de directoris
  		//Si el menú té contingut, 
  			//Si el contingut és automàtic, mostro el contingut automàtic
  			//Si el contingut és manual, mostro el contingut manual
  	//Si s'entra una cerca, carrego les activitats que corresponen a la cerca i marco el calendari els dies
  	//Si s'entra un dia del calendari, cerco les activitats d'aquell dia
  	
  	
    $this->LoadWEB($request);
/*    $this->NOTICIA = null;    
    
    $accio = $this->getUser()->ParReqSesForm($request,'accio','cp');    
    $this->PAGINA = $this->getUser()->ParReqSesForm($request,'pagina',1);
    $this->DATACALENDARI = $this->getUser()->ParReqSesForm($request,'DATACALENDARI',time());
    
    if($request->hasParameter('BCERCA_x') || ( !empty($this->CERCA) && ( !$request->hasParameter('accio') ))) $accio = 'se';                
       
    switch($accio){

      //Consulta una pàgina determinada
      case 'cp':
      	
			$idN = $this->getUser()->ParReqSesForm($request,'node',"");      		      	
      		$this->PAGINA = NodesPeer::selectPagina($idN);      		
      		
      		$this->SELECCIONAT = $idN;            
            $this->gestionaNodes($idN);            
            
      		if($this->PAGINA instanceof Nodes && !$this->PAGINA->getIscategoria()):
      			$CAT = $this->PAGINA->getCategories();
      			if(!sizeof($CAT)){
     				list($cat,$mode) = explode('-',$CAT);
      			} else {  $cat = 'cap'; }
     			if(empty($cat) || $cat == 'cap'):
     				$this->ACCIO  = 'web';
     			else:     				
     				$this->LLISTAT_ACTIVITATS = ActivitatsPeer::getActsCategoria($cat,$mode);
     				$this->ACCIO = 'llistat_activitats';
     				$ACT = ActivitatsPeer::selectCategories(true);
     				$this->TITOL = "Llistat d'activitats a \"".$ACT[$CAT].'"';
     				$this->MODE  = 'LLISTAT';
     			endif; 
      																		            	            	
            elseif($this->PAGINA instanceof Nodes && $this->PAGINA->getIscategoria()):
                        	  
            	$this->ACCIO = 'mostra_estructura';
            	$this->TITOL = $this->PAGINA->getTitolmenu();  
            	$this->NODES = NodesPeer::getNodes(false);          	
            	       	            	
            else:
             
		   	    $this->NOTICIES = NoticiesPeer::getNoticies('%',1,true);		   	                 
		 		$this->ACCIO = 'noticies';
		 			         	            		 		
            endif; 
                                                
            break;

      case 'caa':
      	
      			$this->DESCRIPCIO = ActivitatsPeer::retrieveByPK($request->getParameter('idA'));
      			$this->ACCIO = 'showActivitatCategoria';
      			$this->TITOL = 'DESCRIPCIÓ DE L\'ACTIVITAT';
      			
      		break;
      
      case 'cc':
      	
      			$this->DESCRIPCIO = CiclesPeer::retrieveByPK($request->getParameter('idC'));
      			$this->ACCIO = 'showActivitatCategoria';
      			$this->TITOL = 'DESCRIPCIÓ DEL CICLE';
      			
      		break;
            
       //Mostra les activitats quan cliquem un dia del calendari
	   case 'ca':
	   		        	    		        	    
	    	$this->LLISTAT_ACTIVITATS = ActivitatsPeer::getActivitatsDia(date('Y-m-d',$this->DATACALENDARI),$this->PAGINA);
	    	$this->ACCIO = 'llistat_activitats';
	    	$this->TITOL = 'ACTIVITATS EL DIA '.date('d/m/Y',$this->DATACALENDARI);
	    	$this->MODE  = 'LLISTAT';
	    	
	       	break;

       //Mostra les activitats quan cliquem la cerca
	   case 'se':
	   	 
	   		$DATA = $this->DATACALENDARI;
		    $Di = mktime(0,0,0,date('m',$DATA), 01 , date('Y',$DATA)); 
		    $Df = mktime(0,0,0, date('m',$DATA)+6 , 01 , date('Y',$DATA));		    		     		               
			$this->LLISTAT_ACTIVITATS = HorarisPeer::getCercaWeb(null,$this->CERCA,$Di,$Df,$this->PAGINA);	    		    		    
			$this->ACCIO = 'llistat_activitats';
	    	$this->TITOL = 'CERCA D\'ACTIVITATS AMB LES PARAULES "'.$this->CERCA.'"';
	    	$this->MODE  = 'CERCA';	    						 		 			   		
	   		break;
	   	   
	   //Retorna
	   case 'ret':
		   		$this->redirect('web/index?accio=ca&DATACALENDARI='.$this->getUser()->getSessionPar('DATACALENDARI'));
	   		break;
	   //Per defecte mostrem les notícies
	   case 'no':	   		
	   default: 	   	
	   		if($request->hasParameter('idN')):	   			
	   			$this->NOTICIA = NoticiesPeer::retrieveByPK($request->getParameter('idN'));
	   		else: 
	   			$pagina = ($request->hasParameter('pagina'))?$request->getParameter('pagina'):1; 
	   			$this->NOTICIES = NoticiesPeer::getNoticies('%',$pagina,true);
	   		endif; 	   	                 
	 		$this->ACCIO = 'noticies';	         
	 		$this->getUser()->setSessionPar('HEFETCERCA',false);
	 		$this->getUser()->setSessionPar('NODES',array());	 	   	
			break;		
   }
   
   $this->OBERT = $this->getUser()->getSessionPar('NODES',array());
*/                          
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
     $this->GUARDADA = false;
     
     $accio = $this->getRequestParameter('accio');
     
     switch($accio){
	   case 'landing':
		    $this->MODUL = 'landing_page';
		    $this->ACCIO = 'gestio';		    		         		
     		break;
       case 'gd':
		    $this->MODUL = 'gestiona_dades';
		    $this->ACCIO = 'gestio';
		    $OU = UsuarisPeer::retrieveByPK($this->getUser()->getSessionPar('idU'));
		    
		    //Entrem la info per la gestió del captcha
		    $rand = array(1=>rand(0,10),2=>rand(0,10));
		    $this->getUser()->setSessionPar('rand',$rand);		    
		    $this->FUSUARI = new ClientUsuarisForm($OU,array('rand'=>$rand));
		           	       	     
	        break;
	   case 'gc':
	        $this->MODUL = 'gestiona_cursos';
            $this->ACCIO = 'gestio';                        
            $this->MATRICULES = MatriculesPeer::getMatriculesUsuari($this->getUser()->getSessionPar('idU'));                                                               
            break;
	   case 'gl':
			$this->MODUL = 'gestiona_llistes';
			$this->ACCIO = 'gestio';
			$this->LLISTES = UsuarisllistesPeer::getLlistesUsuari($this->getUser()->getSessionPar('idU'));            
			break;
	   case 'gr':
	   		$OO = new Reservaespais();
	   		$OO->setCodi(ReservaespaisPeer::getNextCodi());
	   		$this->FRESERVA = new ClientReservesForm($OO);
	        $this->MODUL = 'gestiona_reserves';
	        $this->ACCIO = 'gestio';	        
	        $this->RESERVES = ReservaespaisPeer::getReservesUsuaris($this->getUser()->getSessionPar('idU'));
	        $this->getUser()->setSessionPar('idR',0);
	        if($request->hasParameter('idR')){
	        	$OR = ReservaespaisPeer::retrieveByPK($this->getRequestParameter('idR'));
	        	$this->FRESERVA = new ClientReservesForm($OR);
	        	$this->getUser()->setSessionPar('idR',$OR->getReservaespaiid());	        		        
	        } 	        
	        break;
	   case 'sd':
	   		$this->MODUL = 'gestiona_dades'; $this->ACCIO = 'gestio';		    		    
	   		$OU = UsuarisPeer::retrieveByPK($this->getUser()->getSessionPar('idU'));
	   		$this->FUSUARI = new ClientUsuarisForm($OU,array('rand'=>$this->getUser()->getSessionPar('rand')));
	   		$this->FUSUARI->bind($request->getParameter('usuaris'));
	   		if($this->FUSUARI->isValid()) { $this->FUSUARI->save(); $this->MISSATGE[] = "Dades modificades correctament"; }
	   		else { $this->MISSATGE[] = 'Hi ha algun error a les dades'; }     
	        break;       	                    	             	        
	   case 'sl':
	        UsuarisllistesPeer::saveUsuarisLlistes($request->getParameter('LLISTA'), $this->getUser()->getSessionPar('idU'));
	        $this->MODUL = 'gestiona_llistes'; $this->ACCIO = 'gestio';
		    $this->LLISTES = UsuarisllistesPeer::getLlistesUsuari($this->getUser()->getSessionPar('idU'));
		    $this->MISSATGE[] = "Dades modificades correctament";
	        break;
	   case 'sr':
	   	
	   		//Carreguem el formulari que hem carregat per edició o res per nou	
			$OR = ReservaespaisPeer::retrieveByPK($this->getUser()->getSessionPar('idR'));
			
			//Si en trobem un, creem el formulari altrament un de nou
			if($OR instanceof Reservaespais) $this->FRESERVA = new ClientReservesForm($OR);
			else $this->FRESERVA = new ClientReservesForm(new Reservaespais());

			//Entrem les dades del formulari	
			$this->FRESERVA->bind($request->getParameter('reservaespais'));
			
			//Si és correcte el guardem
			if($this->FRESERVA->isValid()):
				$this->FRESERVA->setUser($this->getUser()->getSessionPar('idU'));
				$this->FRESERVA->save();
				$this->renderText('OK');
				return sfView::NONE;				
			else:
				$this->renderText('KO');
				return sfView::NONE;
			endif;			
							
	        break;

	   //Anul·la la reserva
	   case 'ar':
	   		$RE = ReservaespaisPeer::retrieveByPK($this->getUser()->getSessionPar('idR'));	   			   		
	   		if($RE instanceof Reservaespais):
	   			$RE->setEstat(ReservaespaisPeer::ANULADA);
	   			$RE->save();
	   		endif;
	   		
			//Posem les dades de càrrega del mòdul
	        $this->RESERVES = ReservaespaisPeer::getReservesUsuaris($this->getUser()->getSessionPar('idU'));
	        $this->MODUL = 'gestiona_reserves'; $this->ACCIO = 'gestio';		    	   		
	   		break;
	   		
	   case 'im':   //Iniciem la matrícula
	   		          	   				   		   		                         
            $D = $request->getParameter('D');
                         
            $USUARI = UsuarisPeer::retrieveByPK($this->getUser()->getSessionPar('idU'));
            $this->DADES_MATRICULA['DNI'] = $USUARI->getDni();
            $this->DADES_MATRICULA['NOM'] = $USUARI->getNomComplet();
            $this->DADES_MATRICULA['IDU'] = $this->getUser()->getSessionPar('idU');
            $this->DADES_MATRICULA['MODALITAT'] = MatriculesPeer::PAGAMENT_TARGETA;
            $this->DADES_MATRICULA['DESCOMPTE'] = $D['DESCOMPTE'];
            $this->DADES_MATRICULA['DATA'] = date('d-m-Y h:m',time());
            $this->DADES_MATRICULA['COMENTARI'] = "MATRÍCULA INTERNET";
            //Apliquem els descomptes i gratuït si ja està el grup ple
            $this->DADES_MATRICULA['PREU'] = CursosPeer::CalculaPreu($D['CURS'],$D['DESCOMPTE']);
            $this->DADES_MATRICULA['CURS'] = $D['CURS'];
              
            //Retorna id de matrícula
            $matricules = $this->guardaMatricula($this->DADES_MATRICULA); 
              
            //Carreguem el TPV
            $this->TPV = MatriculesPeer::getTPV($this->DADES_MATRICULA['PREU'] , $this->DADES_MATRICULA['NOM'] , $matricules );
            $this->ACCIO = "verifica";
            $this->MODUL = "gestiona_verificacio";                                                      
	        break;
     }
     
  }

  //Guardem el TPV
  public function executeGetTPV(sfWebRequest $request)
  {
  	
  	//Si arribem aquí és perquè hem fet un pagament amb tarjeta i segur que tenim lloc.   
  	if($request->getParameter('Ds_Response') == '0000'):
  		$idM = $request->getParameter('Ds_MerchantData');
  		$OM = MatriculesPeer::retrieveByPK($idM);
  		if($OM instanceof Matricules):
  			$OM->setEstat(MatriculesPeer::ACCEPTAT_PAGAT); //Si arriba aquí és que hi ha trobat plaça
  			$OM->save();
  			$this->sendMail('informatica@casadecultura.org',
  							$OM->getUsuaris()->getEmail(),  							
  							'Matrícula Casa de Cultura de Girona',
  							MatriculesPeer::MailMatricula($OM));  			
			$this->sendMail('informatica@casadecultura.org',
  							'informatica@casadecultura.org',
  							'Matrícula Casa de Cultura de Girona',
  							MatriculesPeer::MailMatricula($OM));  							
  		else:
	  		$this->sendMail('informatica@casadecultura.org',
	  						'informatica@casadecultura.org',
	  						'Matrícula cobrada i Error en objecte',
	  						'Hi ha hagut algun error en una matrícula que s\'ha cobrat i no s\'ha pogut guardar com a pagada');   			  			  			
  		endif; 
  	else: 
  		$OM->setEstat(MatriculesPeer::ERROR); //Si arriba aquí és que no ha pagat correctament
  		$OM->save();
  	endif;
  	 
  	return sfView::NONE;
  	
  } 
    
  public function executeMatriculaFinal(sfWebRequest $request)
  {
  	
  	$this->LoadWEB($request);
    $this->setTemplate('index');
    $this->ACCIO = 'final_matricula';
    
  	if($request->hasParameter('OK')):
  		$this->MISSATGE = "OK";
  	else: 
  		$this->MISSATGE = "KO";
  	endif; 
  }
  
  private function guardaMatricula( $DADES_MATRICULA , $EDIT = false , $IDMATRICULA = 0 )
  {
  	
     //Quan guardem la matrícula mirem
     // Si el curs és ple, guardem Estat "En llista d'espera"
     // Si queden places, guardem en procès i quan hagi pagat se li guardarà.  
     
     $M = new Matricules();
     if($EDIT) { $M = MatriculesPeer::retrieveByPK($IDMATRICULA); $M->setNew(false); }     
     
     if(CursosPeer::isPle($DADES_MATRICULA['CURS'])):
		$M->setEstat(MatriculesPeer::EN_ESPERA);
	 else:  
     	$M->setEstat(MatriculesPeer::EN_PROCES);
     endif;
     
     $M->setUsuarisUsuariid($DADES_MATRICULA['IDU']);
     $M->setComentari("Pagament internet");
     $M->setDatainscripcio($DADES_MATRICULA['DATA']);     
     $M->setTreduccio($DADES_MATRICULA['DESCOMPTE']);
     $M->setTpagament(MatriculesPeer::PAGAMENT_TARGETA);
     $M->setCursosIdcursos($DADES_MATRICULA['CURS']);
     $M->save();
     
     return $M->getIdmatricules();
     
  }
      
  
  private function getFotos()
  {
  	$FOTOS = array();
  	srand (time());
  	while(sizeof($FOTOS) < 4):    	
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
	
	while(sizeof($BANNERS) < 3 && (sizeof($TEMP)) > 3):
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
   
  
   public function executeFuncionament(sfWebRequest $request)
   {
      $this->LoadWEB($request);
      $this->setTemplate('index');
      $this->ACCIO = 'funcionament';      
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
   
}
