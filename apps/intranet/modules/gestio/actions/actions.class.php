<?php

/**
 * 
 * gestio actions.
 *
 * @package    intranet
 * @subpackage gestio
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class gestioActions extends sfActions
{    
  
/**
 * Executem el login del modul administrador
 **/

  public function executeLogin(sfWebRequest $request)
  {        
    
     //Entrem un DNI i amb això hauríem d'entrar a l'administrador si és un usuari.
     $this->FLogin = new LoginForm();
     $this->ERROR = "";
     
     //Si premem recordar contrassenya... anem al mòdul. 
     if($request->hasParameter('form_login_remember')):
     	$this->redirect('gestio/remember');     
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

                //Carreguem el primer site de l'usuari si en pot veure
                $firstSite = UsuarisSitesPeer::getFirstSite($USUARI);
                if(is_null($firstSite)) $this->redirect('gestio/login');
                else $this->getUser()->setSessionPar('idS',$firstSite);

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
        endif;     		 
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
        
     if($request->hasParameter('BSAVE')):
           $this->getUser()->setSessionPar('idS',$request->getParameter('IDS'));
           $this->redirect('gestio/main');
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
  public function executeMain()
  { 
  	              	  	
  	$this->getUser()->addLogAction('inside','Main');
  	
    $this->setLayout('gestio');
    $this->IDS = $this->getUser()->getSessionPar('idS');
    
    $idU = $this->getUser()->getSessionPar('idU');    
    
    //Carreguem quantes incidÃ¨ncies noves hi ha
    $this->NINCIDENCIES = IncidenciesPeer::QuantesAvui($this->IDS); 
    //Carreguem quantes matrÃ­cules noves hi ha
    $this->NMATRICULES  = MatriculesPeer::QuantesAvui($this->IDS);
    //Carreguem quant material nou hi ha
//    $this->NMATERIAL    = MaterialPeer::QuantAvui();
    //Carreguem quants missatges nous hi ha
    $this->NMISSATGES   = MissatgesPeer::QuantsAvui($idU , $this->getUser()->getSessionPar('idS'));
    //Carreguem quantes feines s'han fet
    $this->NFEINES      = 0; //TasquesPeer::QuantesAvui(false,$idU);    
    //Carreguem quantes feines ens toca fer
    $this->NFINES       = 0; //TasquesPeer::QuantesAvui(true,$idU);
    //Carreguem quantes activitats hi ha
    $this->NACTIVITATS  = ActivitatsPeer::QuantesAvui();
    
    //Carreguem els missatges d'avui    
    $this->MISSATGES = MissatgesPeer::getMissatgesAvui( $this->getUser()->getSessionPar('idS') );
        
    $this->FEINES = PersonalPeer::getFeines( $idU , time() , $this->IDS );
    $this->NOTIFICACIONS = PersonalPeer::getNotificacions( $idU , time() , $this->IDS );
    
    //Carreguem les activitats d'avui :D
    $this->ACTIVITATS = HorarisPeer::getActivitats(time() , null , null , null , null, $this->IDS );
    $this->ACTIVITATS = $this->ACTIVITATS['ACTIVITATS'];    
  
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
    endif; 
    
    $this->CERCA  = $this->getUser()->ParReqSesForm($request,'cerca',array('text'=>""));                    
    $this->PAGINA = $this->getUser()->ParReqSesForm($request,'PAGINA',1);
    $accio  = $this->getUser()->ParReqSesForm($request,'accio','FC');
            
    //Inicialitzem el formulari de cerca
    $this->FCerca = new CercaForm();            
	$this->FCerca->bind($this->CERCA);
    
	$this->MODE = array('CONSULTA'=>true, 'NOU', 'EDICIO', 'LLISTES', 'CURSOS', 'REGISTRES', 'GESTIO_APLICACIONS');
		
    if($request->hasParameter('BNOU')) 					{ $accio = "N"; }
    if($request->hasParameter('BCERCA')) 				{ $accio = "FC"; $this->PAGINA = 1; }
    if($request->hasParameter('BDESVINCULA')) 			{ $accio = "DL"; }
    if($request->hasParameter('BVINCULA')) 				{ $accio = "VL"; }
    if($request->hasParameter('BSAVE'))     			{ $accio = "S"; }
  	if($request->hasParameter('BDELETE'))     			{ $accio = "D"; }    
    if($request->hasParameter('BACTUALITZA_PERMISOS')) 	{ $accio = "SGA"; }
    
    
    
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
            $this->FUsuari = UsuarisPeer::initialize( $this->IDU , $this->IDS , false );	       		       		                                       		  
            $this->FUsuari->bind($RP);             
		    if($this->FUsuari->isValid())
		    { 		     	
	    	  $this->FUsuari->save();
              $this->getUser()->addLogAction($accio,'gUsuaris',null, $this->FUsuari->getObject()); 
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
    
    $this->PROMOCIONS = PromocionsPeer::getAllPromocions($this->IDS);                    
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
    
    $this->NODES = NodesPeer::retornaMenu(true,$this->IDS);
    
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
    if($request->hasParameter('BCERCA')){ $accio = 'U'; $this->PAGINA = 1; }
    if($request->hasParameter('BSAVE')) $accio = 'S';
    if($request->hasParameter('BDELETE')) $accio = 'D';    
    if($request->hasParameter('BSAVE_MISSATGE')) $accio = 'SM';
    if($request->hasParameter('BSEGUEIX_LLISTES')) $accio = 'LM';    
    if($request->hasParameter('BSAVE_LLISTES')) $accio = 'SLM';
    if($request->hasParameter('BSEGUEIX_ENVIAMENT')) $accio = 'SLEE';
    if($request->hasParameter('BSEND_PROVA')) $accio = 'SP';
    if($request->hasParameter('BSEND_TOTHOM')) $accio = 'SMT';
    if($request->hasParameter('BFI')) $accio = 'SFI';        
    if($request->hasParameter('BSEND')) $accio = 'SEND';
    if($request->hasParameter('BVINCULA')) $accio = 'VINCULA';
    if($request->hasParameter('BDESVINCULA')) $accio = 'DESVINCULA';
    if($request->hasParameter('BACTUALITZAEMAILS')) $accio = 'UPDATE_EMAILS';            
    
    switch($accio)
    {
    	//Edito un missatge o en creo un de nou.
    	case 'EM':                                                            			
                $this->FMissatge = MissatgesmailingPeer::initialize($this->IDM,$this->IDS);                			                                                                                                                       
    			$this->MODE = 'MISSATGES';                    			
    		break;
    		
    	//Guardo un missatge editat. 
    	case 'SM':    			
    			if($this->saveMissatge($request)) $this->MODE = 'MISSATGES';
    			else $this->MODE = 'MISSATGES';    			                                                                      	
    		break;
    		
    	//Esborro un missatge guardat
    	case 'DM':    			
                $OM = MissatgesmailingPeer::initialize($this->IDM,$this->IDS)->getObject();    			
    			$OM->setActiu(false);
                $OM->save();    
                $this->getUser()->addLogAction($accio,'gLlistes',null,$this->FHtml->getObject());
   				$this->redirect('gestio/gLlistes?accio=C');    				    			    		
    		break;
    
    	//Mostro les llistes a les que puc enviar el missatge
    	case 'LM':
                        		
    			if($this->saveMissatge($request)):                    
    				$this->LLISTES_ENVIAMENT = MissatgesllistesPeer::getLlistesArray($this->IDM,$this->IDS);                         				     				    				    				
        			$this->MODE = 'MISSATGES_LLISTES';    				
    			else: 
    				$this->MODE = 'MISSATGES'; 			
    			endif;     			    			

    		break;
    		
    	//Guardo les llistes a les que enviaré el missatge
    	case 'SLM':
    		    			
    			$this->saveMissatgeLlistes($request);
    			$this->LLISTES_ENVIAMENT = MissatgesllistesPeer::getLlistes($this->IDM);    			
    			$this->MODE = 'MISSATGES_LLISTES';
    					
    		break;
    		
    		//Segueixo amb l'enviament del missatge
    	case 'SLEE':                        		
    			$this->saveMissatgeLlistes($request);
    			$this->MODE = "FER_PROVA";
    		
    		break;

    	//Envio un missatge de prova a l'adreça que digui l'usuari
    	case 'SP':
            		
    		$this->SendProvaMissatge( $this->IDM , $request->getParameter('email') , $this->IDS );    			    		
    		$this->MODE = "FER_PROVA";
   		
    		break;

    	//Envio el missatge a tothom
    	case 'SMT':    		
            $this->sendTothomMissatge( $this->IDM , $this->IDS );    			    		
    		$this->MODE = "FER_PROVA";
   		
    		break;
    		
    		
    	//Hem acabat l'edició... no fem res, només tornem a les llistes
    	case 'SFI':
    			$this->redirect('gestio/gLlistes');
    		break;    		
    		    		
      case 'N':      
                $this->FLlista = LlistesPeer::initialize(0,$this->IDS);			      			      			
                $this->MODE = 'NOU';
                break;
      case 'E':
                $this->IDL = $request->getParameter('IDL'); 
                $this->FLlista = LlistesPeer::initialize($this->IDL,$this->IDS);                                                                
                $this->MODE = 'EDICIO'; 
                break;                      
      case 'VINCULA':                               
               $ALTA_USUARI = $request->getParameter('ALTA_USUARI');                                                                           
               UsuarisllistesPeer::Vincula( $ALTA_USUARI , $this->IDL );
               $this->execLlistesUpdateUsers($request, array() ,$this->IDS);                             
            break;
      case 'DESVINCULA':                              
               $BAIXA_USUARI = $request->getParameter( 'BAIXA_USUARI' );                              
               UsuarisllistesPeer::Desvincula( $BAIXA_USUARI , $this->IDL );
               $this->execLlistesUpdateUsers( $request , array() , $this->IDS );        
            break;
      case 'UPDATE_EMAILS':
                $EMAILS = $request->getParameter('EMAILS');
                $R = MissatgesEmailsPeer::update( $this->IDL , $EMAILS );
                $M = array('Actualitzat correctament. ','Afegits: '.$R['Afegits'],'Esborrats: '.$R['Esborrats'],'Incorrectes: '.$R['Erronis'],'Existents: '.$R['Existents']);
                $this->execLlistesUpdateUsers( $request , $M , $this->IDS );
            break;
      
/*      case 'MV':                               
                $this->IDM = $request->getParameter('IDM');
                $this->LLISTA_MISSATGES = LlistesPeer::getMissatges( $this->IDL , LlistesPeer::TOTS , $this->PAGINA3 , $this->IDS );
                $this->MISSATGE = MissatgesllistesPeer::initialize($request->getParameter('IDM'),null,$this.->IDS);                                         
                $this->MODE = 'MISSATGES';        
                break;                */
      case 'S':
                $RP = $request->getParameter('llistes');
                $this->IDL = $RP['idLlistes'];
                $this->FLlista = LlistesPeer::initialize( $this->IDL , $this->IDS );                                                 
                $this->FLlista->bind($RP);
                if($this->FLlista->isValid()) $this->FLlista->save();
                $this->MODE = 'EDICIO';                
                break;       	         	       
      case 'L':                                              
               $this->LLISTA = LlistesPeer::initialize($this->IDL, $this->IDS)->getObject(); 
               $this->LMISSATGES = LlistesPeer::getMissatges($this->IDL,null,$this->PAGINA,$this->IDS);                             
               $this->MODE = 'LLISTAT';
               break;
      case 'SEND':
                $this->IDM = $request->getParameter('IDM');               
                $this->MAILS = LlistesPeer::EnviaMissatge($this->IDM,$this->IDS);
                $this->ENVIAT = true;                               
               break;
      case 'U_EMAIL':
      		
      		break;
      case 'U':
                $this->execLlistesUpdateUsers( $request , array() , $this->IDS );                    
      		break;       
	  //Imprimeix etiquetes               
      case 'P': 
      		return $this->printEtiquetes($this->IDL);     	
      		break;
    
    }        
  
    //Inicialitzem els valors comuns
	$this->LLISTES = LlistesPeer::getLlistesAll($this->IDS);
	$this->MISSATGES = MissatgesmailingPeer::getMissatges( $this->IDL , $this->PAGINA , $this->IDS );    
  
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
  
  public function saveMissatge(sfWebRequest $request)
  {
  	
    $RM = $request->getParameter('missatgesmailing');
    $this->IDM = $RM['idMissatge'];                      
    
    $this->FMissatge = MissatgesmailingPeer::initialize($this->IDM,$this->IDS);      	
    $this->FMissatge->bind($RM);    
    if($this->FMissatge->isValid()){ 
        $this->FMissatge->save();
        $this->IDM = $this->FMissatge->getObject()->getIdmissatge();
        $this->getUser()->addLogAction('SAVE_MISS','gLlistes',null,$this->FMissatge->getObject());           
        return true; 
    }         	   
    else { return false; }
                    	              
  }

  public function executeGEntrades(sfWebRequest $request)
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
/*
  public function executeSelectCeditA(sfWebRequest $request)
  {
  	
  	$C = new Criteria();
  	$RESPOSTA = CessiomaterialPeer::getCeditAAjax($request->getParameter('q'), $request->getParameter('limit')); 	  	    
    return $this->renderText(json_encode($RESPOSTA));
      
  }
*/
  
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
        
    $this->CERCA  			= $this->getUser()->ParReqSesForm($request,'cerca',array('text'=>""));    
    
    $this->PAGINA 			= $request->getParameter('PAGINA',1);
    $this->DATAI            = $this->getUser()->ParReqSesForm($request,'DATAI',time());                
    $this->DIA    			= $request->getParameter('DIA',time());    
    $this->IDA    			= $request->getParameter('IDA',0);
    $this->accio 			= $request->getParameter('accio','C');            
    
    $this->ACTIVITAT_NOVA 	= false;        

    //Inicialitzem el formulari de cerca
    $this->FCerca = new CercaForm();            
	$this->FCerca->bind(array('text'=>$this->CERCA['text']));

	//Inicialitzem variables
	$this->MODE = array();

    if($request->isMethod('POST')){
	    if($request->hasParameter('BCERCA')) { $this->accio = 'C'; $this->PAGINA = 1; }   
	    elseif($request->hasParameter('BNOU')) 	    		$this->accio = 'ACTIVITAT';
	    elseif($request->hasParameter('BCICLE')) 			$this->accio = 'CICLE';
	    elseif($request->hasParameter('BCICLESAVE'))		$this->accio = 'CICLE_SAVE';
	    elseif($request->hasParameter('BACTIVITAT')) 		$this->accio = 'ACTIVITAT';
	    elseif($request->hasParameter('BACTIVITATSAVE')) 	$this->accio = 'ACTIVITAT_SAVE';
	    elseif($request->hasParameter('BACTIVITATDELETE')) 	$this->accio = 'ACTIVITAT_DELETE';
	    elseif($request->hasParameter('BHORARI')) 			$this->accio = 'HORARI';
	    elseif($request->hasParameter('BHORARISAVE')) 		$this->accio = 'HORARI_SAVE';
	    elseif($request->hasParameter('BHORARIDELETE')) 	$this->accio = 'HORARI_DELETE';
	    elseif($request->hasParameter('BDESCRIPCIO')) 		$this->accio = 'DESCRIPCIO';
	    elseif($request->hasParameter('BDESCRIPCIOSAVE')) 	$this->accio = 'DESCRIPCIO_SAVE';
	    elseif($request->hasParameter('BDESCRIPCIODELETE')) $this->accio = 'DESCRIPCIO_DELETE';
	    elseif($request->hasParameter('BGENERANOTICIA')) 	$this->accio = 'GENERA_NOTICIA';	    
	    
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

    		$this->CarregaActivitats($request,$request->getParameter('form',true));
    		     			
    		break;
    		
    	//Guardem l'activitat
    	case 'ACTIVITAT_SAVE':

    			$RP = $request->getParameter('activitats');
    			$this->IDA = $RP['ActivitatID'];
    			$this->IDC = $RP['Cicles_CicleID'];
    		
	    		$this->FActivitat = ActivitatsPeer::initialize($this->IDA,$this->IDC, $this->IDS);	    		
	    		$this->FActivitat->bind($request->getParameter('activitats'));
	    		if($this->FActivitat->isValid()):
	    			$nova = $this->FActivitat->isNew();
	    			$this->FActivitat->save();	    			
	    			$this->getUser()->addLogAction($this->accio,'gActivitats',$this->FActivitat->getObject());
	    			$this->IDA = $this->FActivitat->getObject()->getActivitatid();
	    			if($nova):	    				
	    				$this->redirect('gestio/gActivitats?accio=HORARI&IDA='.$this->IDA.'&nou='.$this->IDA);
	    			else: 
	    				$this->redirect('gestio/gActivitats?accio=ACTIVITAT&IDA='.$this->IDA);
	    			endif; 	    			
	    		else: 
	    			if($this->getUser()->getSessionPar('isCicle')):
	    				$this->MODE['ACTIVITAT_CICLE'] = true;
    					$this->ACTIVITATS = ActivitatsPeer::getActivitatsCicles($this->IDC,$this->IDS);
    					$this->CICLE = CiclesPeer::retrieveByPK($this->IDC)->getNom();
					else:
						$this->MODE['ACTIVITAT_ALONE'] = true;
	    				$this->ACTIVITATS = array(1=>ActivitatsPeer::retrieveByPK($this->IDA));
	    				$this->CICLE = 'No pertany a cap cicle';
	    			endif;
	    		endif; 
    			
    		break;

    	//Esborrem una activitat
    	case 'ACTIVITAT_DELETE':

    			$RP = $request->getParameter('activitats');
    			$this->IDA = $RP['ActivitatID'];
    			$this->IDC = $RP['Cicles_CicleID'];
    		
	    		$this->FActivitat = ActivitatsPeer::initialize($this->IDA,$this->IDC);
	    		$OA = $this->FActivitat->getObject();
	    		if($OA instanceof Activitats):
	    			$this->getUser()->addLogAction($this->accio,'gActivitats',$OA);
	    			$OA->delete();
	    			$this->redirect('gestio/gActivitats?accio=CC');
	    		endif; 	    		
	    		    			    			
    		break;
    		
    		
    	//Entrem els horaris de les activitats
    	case 'HORARI':
    			
				$this->CarregaActivitats($request,false); 
    			    			    							
 				$OActivitat = ActivitatsPeer::retrieveByPK($this->IDA); 				    		
    			$this->HORARIS = $OActivitat->getHorarisActius($this->IDS);
    			$this->NOMACTIVITAT = $OActivitat->getNom();
    			    			    			    			
    			$OHorari = new Horaris();
    			$OHorari->setActivitatsActivitatid($this->IDA);    			    			
    			if($request->hasParameter('nou')) $this->FHorari = new HorarisForm($OHorari);     			
    			$this->HORARI = $OHorari;    			   
				$this->ESPAISOUT = array(); $this->MATERIALOUT = array();				    			 	
    			$this->getUser()->setSessionPar('IDH',0);
    			    			
    			if($request->hasParameter('IDH')):
    				$H = HorarisPeer::retrieveByPK($request->getParameter('IDH'));
    				$this->getUser()->setSessionPar('IDH',$request->getParameter('IDH'));    				
    				$this->FHorari = new HorarisForm($H);
    				$this->HORARI  = $H;                    
                    $this->ESPAISOUT = $H->getArrayHorarisEspaisActiusAgrupats();
                    $this->MATERIALOUT = $H->getArrayHorarisEspaisMaterial();                     
    			endif;    		    
    					    			
 				 $this->MODE['HORARI'] = true;
    		break;
		
    	case 'HORARI_SAVE':
    		
    			$RP = $request->getParameter('horaris');
    			$this->IDA = $RP['Activitats_ActivitatID'];
    			$this->IDH = $RP['HorarisID'];
    		
	    		$OActivitat = ActivitatsPeer::retrieveByPK($this->IDA);
	    		$this->NOMACTIVITAT = $OActivitat->getNom();
	    		$this->HORARIS = $OActivitat->getHorarisActius($this->IDS);
	    		
	    		$OHorari = HorarisPeer::retrieveByPK($this->IDH);
	    		if($this->IDH == 0) 	$this->FHorari = new HorarisForm();
	    		else					$this->FHorari = new HorarisForm($OHorari);
	    		                
	    		$this->MATERIALOUT = array();
	    		$material = $request->getParameter('material');
	    		if(!is_array($material)) $material = array();
	    		foreach($material as $M=>$idM):
	    			if($idM > 0):
	    				$OMaterial = MaterialPeer::retrieveByPK($idM);
	    				$this->MATERIALOUT[] = array('material'=>$idM,'generic'=>$OMaterial->getMaterialgenericIdmaterialgeneric());
	    			endif;
	    		endforeach;
	    		
	    		$espais = $request->getParameter('espais');
 	    		if(!is_array($espais)) $espais = array();
	    		$this->ESPAISOUT = $espais;
	    		
	    		$this->FHorari->bind($request->getParameter('horaris'));
	    		$RET = $this->GuardaHorari($request->getParameter('horaris'),$this->MATERIALOUT,$this->ESPAISOUT, $this->IDS);
	    		if(empty($RET)):
	    			$this->getUser()->addLogAction($this->accio,'gActivitats',$this->FHorari->getObject());
	    			$this->MISSATGE = array(1=>'Horari guardat correctament');
	    			$this->redirect('gestio/gActivitats?accio=HORARI&IDA='.$this->IDA);
	    		else:
	    			$this->MISSATGE = $RET;
	    		endif; 
	    		
	    		$this->CarregaActivitats($request,false);
	    		
	    		$this->MODE['HORARI'] = true;
	    			    			    		    	    			
    		break;
    		
    	case 'HORARI_DELETE':

    			$RH = $request->getParameter('horaris');    			
    			$OH = HorarisPeer::retrieveByPK($RH['HorarisID']);
    			if($OH instanceof Horaris):
	    			$this->getUser()->addLogAction($this->accio,'gActivitats',$OH);
	    			$OH->delete();    			    			
	    		endif; 
	   			$this->redirect('gestio/gActivitats?accio=HORARI&IDA='.$RH['Activitats_ActivitatID']);
	   			
    		break;
    		
    	case 'DESCRIPCIO':
    		
    			$this->CarregaActivitats($request,false);
    			$this->FActivitat = ActivitatsPeer::initializeDescription($this->IDA,$this->IDS);    			    			
    			$this->MODE['DESCRIPCIO'] = true;
    				    			     			    			
    		break;
    	
    	case 'DESCRIPCIO_SAVE':
    			
    			$RP = $request->getParameter('activitats');
    			$this->IDA = $RP['ActivitatID'];
    			
    			$this->CarregaActivitats($request,false);
    			$this->FActivitat = ActivitatsPeer::initializeDescription($this->IDA,$this->IDS);    			
    			$this->FActivitat->bind($RP,$request->getFiles('activitats'));
    			if($this->FActivitat->isValid()): 
    				$this->FActivitat->save();
    				$this->getUser()->addLogAction($this->accio,'gActivitats',$this->FActivitat->getObject());
    				$this->redirect('gestio/gActivitats?accio=DESCRIPCIO&IDA='.$this->IDA);
    			endif; 
    			
    			$THIS->MODE['DESCRIPCIO'] = true;
    		
    		break;

		case 'GENERA_NOTICIA':
    			
    			$RP = $request->getParameter('activitats');
    			$this->IDA = $RP['ActivitatID'];    			
    			$ONoticia = NoticiesPeer::getNoticiaActivitat($this->IDA,$this->IDS);    			
    			$this->redirect('gestio/gNoticies?accio=E&idn='.$ONoticia->getIdnoticia());
    			    			    		
    		break;
    					
    }                                
    
  }  

  private function CarregaActivitats($request,$with_form)
  {
    
        //Si és una activitat que pertany a un cicle se li haurà de passar el cicle. 
    
    	//Si una activitat pertany a un cicle ensenyo totes les del cicle
	    $OA = ActivitatsPeer::retrieveByPK($this->IDA);
	    
		//Editem una activitat d'un cicle.
	    if($OA instanceof Activitats && $OA->getCiclesCicleid() > 1):
	    	
	    	$this->IDC = $OA->getCiclesCicleid();
	    	$this->CICLE = CiclesPeer::retrieveByPK($this->IDC)->getNom();    			
	    	$this->ACTIVITATS = ActivitatsPeer::getActivitatsCicles($this->IDC,$this->IDS,false,1,false);
	    	if($with_form) $this->FActivitat = ActivitatsPeer::initialize($this->IDA,$this->IDC,$this->IDS);    			
	    	$this->MODE['ACTIVITAT_CICLE'] = true;
	    		    	
	    //Creem una activitat d'un cicle 
	    elseif($request->hasParameter('IDC')):
        
            $this->IDC = $request->getParameter('IDC');
	    	$this->CICLE = CiclesPeer::retrieveByPK($this->IDC)->getNom();    			
	    	$this->ACTIVITATS = ActivitatsPeer::getActivitatsCicles($this->IDC,$this->IDS,false,1,false);
	    	if($with_form) $this->FActivitat = ActivitatsPeer::initialize(null,$this->IDC,$this->IDS);    			
	    	$this->MODE['ACTIVITAT_CICLE'] = true;
            
        //Una sola activitat    	    	
        else:  
	    	$this->CICLE = "No pertany a cap cicle";   		
	    	$this->MODE['ACTIVITAT_ALONE'] = true;
	    	$OA = ActivitatsPeer::retrieveByPK($this->IDA);
	    	
	    	if($OA instanceof Activitats):
	    		$this->ACTIVITATS = array(1=>ActivitatsPeer::retrieveByPK($this->IDA));
	    	else:
	    		$this->ACTIVITATS = array();
	    	endif; 
	    	
	    	if($with_form) $this->FActivitat = ActivitatsPeer::initialize($this->IDA,false,$this->IDS);
	    	
	    endif;		
  	  	
  }
  
  public function GuardaHorari($horaris, $material, $espais , $idS )
  {
  	
  	$ERRORS = array();  	
  	$DBDD[] = array();  	  	
  	
	if( empty($horaris['Dia']) ): 
		$ERRORS[] = "No has entrat cap data";
		$DBDD['DIES'] = array(); 	
	else:
		$DIES = explode(',',$horaris['Dia']);
		foreach($DIES as $D):  		
  			list($dia,$mes,$any) = explode('/',$D);  		
  	  		if(!($any > 2000 && $mes < 13 && $dia < 32 )) $ERRORS[] = "La data que has entrat és incorrecta";
  			$DBDD['DIES'][] = "$any-$mes-$dia";  		  		
  		endforeach;  	     		
	endif;  	
  	  	       
	//Passem l'hora a format numèric per fer les comprovacions
  	$DBDD['HoraPre']  = strval($horaris['HoraPre']['hour'])*60+strval($horaris['HoraPre']['minute']);
  	$DBDD['HoraIn']   = strval($horaris['HoraInici']['hour'])*60+strval($horaris['HoraInici']['minute']);
  	$DBDD['HoraFi']   = strval($horaris['HoraFi']['hour'])*60+strval($horaris['HoraFi']['minute']);
  	$DBDD['HoraPost'] = strval($horaris['HoraPost']['hour'])*60+strval($horaris['HoraPost']['minute']);  	  	
  	
    if( $DBDD['HoraPre'] > $DBDD['HoraIn'] )    $ERRORS[] = "L'hora de preparació no pot ser més gran que la d'inici.";
    if( $DBDD['HoraIn']  >= $DBDD['HoraFi'] )   $ERRORS[] = "L'hora d'inici no pot ser més gran o igual que la d'acabament.";
    if( $DBDD['HoraFi']  > $DBDD['HoraPost'] && $DBDD['HoraPost'] > (8*60) )  $ERRORS[] = "L'hora d'acabament no pot ser més gran que la de desmuntatge.";                    
    
    //Un cop fetes les verificacions... tornem a posar els valors que guardarem
    $DBDD['HoraPre']  = $horaris['HoraPre']['hour'].':'.$horaris['HoraPre']['minute'];
  	$DBDD['HoraIn']   = $horaris['HoraInici']['hour'].':'.$horaris['HoraInici']['minute'];
  	$DBDD['HoraFi']   = $horaris['HoraFi']['hour'].':'.$horaris['HoraFi']['minute'];
  	$DBDD['HoraPost'] = $horaris['HoraPost']['hour'].':'.$horaris['HoraPost']['minute'];
      	
    if(empty($espais)) $ERRORS[] = "Has d'entrar algun espai";

    //Mirem que la data no es solapi amb alguna altra activitat al mateix espai
    foreach($DBDD['DIES'] as $D):
        	    
    	foreach($espais as $E=>$idE):    		
    		//Si l'usuari bloqueja un espai hem de mirar que no hi hagi cap activitat aquell dia. 
    		if($idE == 22)
    		{
				$RS = HorarisPeer::getActivitatsDia( $D , $idS );
				if(sizeof($RS) > 0) { $ERRORS[] = "El dia $D hi ha ".sizeof($RS)." activitat(s) que impedeixen el bloqueig."; }
			}
			else
			{			     
	    		//Mirem si encaixa amb alguna altra activitat solta
		    	if( HorarisPeer::validaDia( $D , $idE , $DBDD['HoraPre'] , $DBDD['HoraPost'] , $horaris['HorarisID'] , $idS ) > 0 )                
		    	{
		    		$Espai = EspaisPeer::retrieveByPK($idE)->getNom();
			    	$ERRORS[] = "El dia $D coincideix a l'espai $Espai amb una altra activitat";
		    	}
			    //Comprovem que no hi hagi un problema amb un dia bloquejat
			    elseif( HorarisPeer::validaDiaBloqueig( $D , $horaris['HorarisID'] , $this->IDS ) )
			    {			    		
		    			$ERRORS[] = "El dia $D hi ha una activitat que bloqueja tots els espais!";		    					    			    		 
			    }                	    			    	                                 
    		}    	            
    	endforeach;
                        
        foreach($material as $M=>$idM):
            
            if(!MaterialPeer::isLliure( $idM['material'] , $this->IDS , $D , $DBDD['HoraPre'] , $DBDD['HoraPost'] , $horaris['HorarisID'])):
                $OM = MaterialPeer::retrieveByPK($idM['material']);
                if($OM instanceof Material) $nom = $OM->toString(); else $nom = "n/d";
                $ERRORS[] = "El material ".$nom." està ocupat el dia ".$D;
            endif;
            
        endforeach;
        	    	
    endforeach;
       
    //Si no hem trobat cap error, guardem els registres d'ocupaciÃ³.    
    if(empty($ERRORS)):

 		HorarisPeer::save( $horaris , $DBDD , $material , $espais , $idS );
       
    endif;
  
    return $ERRORS;
     
  }
    
  function sumarmesos($data,$mesos)
  { 
    list($year,$mon,$day) = explode('-',$data);
  	return date('Y-m-d',mktime(0,0,0,$mon+$mesos,$day,$year));		
  }  
        
  
  //**************************************************************************************************************************************************
  //**************************************************************************************************************************************************
  
  public function executeGEspais()  
  {
    
    $this->setLayout('gestio');
    $this->DIES = array(); $this->ESPAIS = array();  $this->MESOS = array(); $this->DADES = array();

    if(!$this->hasRequestParameter('CERCA_ANY')) $this->CERCA_ANY = date('Y',time());
    else $this->CERCA_ANY = $this->getRequestParameter('CERCA_ANY'); 
    
    $this->CERCA_MES = $this->getRequestParameter('CERCA_MES');
    $this->CERCA_ESPAI = $this->getRequestParameter('CERCA_ESPAI');

	//Consulta l'ocupació d'un espai segons dies i mesos
	if(!empty($this->CERCA_ESPAI) && empty($this->CERCA_MES)):    
	    for($i=0;$i<32;$i++) $this->DIES[$i] = $i;
	    $this->MESOS = array('1'=>'Gener','2'=>'Febrer','3'=>'MarÃ§','4'=>'Abril','5'=>'Maig','6'=>'Juny','7'=>'Juliol','8'=>'Agost','9'=>'Setembre','10'=>'Octubre','11'=>'Novembre','12'=>'Desembre');
	    $this->DADES_MESOS_DIES = HorarisPeer::getMesosDiesEspai($this->CERCA_ANY,$this->CERCA_ESPAI);	    
    elseif(empty($this->CERCA_ESPAI) && !empty($this->CERCA_MES)):
       //Consulta l'ocupació d'espais per mesos        
	    $this->ESPAIS = EspaisPeer::select();
	    $this->MESOS = array('1'=>'Gener','2'=>'Febrer','3'=>'MarÃ§','4'=>'Abril','5'=>'Maig','6'=>'Juny','7'=>'Juliol','8'=>'Agost','9'=>'Setembre','10'=>'Octubre','11'=>'Novembre','12'=>'Desembre');
	    $this->DADES_MESOS_ESPAIS = HorarisPeer::getMesosEspais($this->CERCA_ANY);    
	elseif(!empty($this->CERCA_MES) && !empty($this->CERCA_ESPAI)):
		$this->DADES_MESOS_HORES = HorarisPeer::getMesosEspaisHores($this->CERCA_ANY,$this->CERCA_ESPAI,$this->CERCA_MES);
		//Busquem per cada dia del mes, les hores ocupades
	elseif($request->getParameter('accio') == 'CC'):
		$this->getUser()->addLogAction('inside','gEspais');    	
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
  	
  	//Netegem cerca
  	if($request->getParameter('accio') == 'C'):      		
      	$this->CERCA = $this->getUser()->setSessionPar('cerca',array('text'=>''));      	
    endif;
  	  
  	//Inicialitzem les variables
  	$this->CERCA  	= $this->getUser()->ParReqSesForm($request,'cerca',array('text'=>""));  	
  	$this->accio  	= $request->getParameter('accio','C');  	
  	$this->MODE     = "";  	           	
  	
  	//Tractem el formulari de cerca
  	$this->FCerca = new CercaForm();  	  
  	$this->FCerca->bind($this->CERCA);
        
  	//Definim l'acciÃ³ segons el botÃ³ premut  	
    if( $this->getRequest()->hasParameter('BNOU') ) $this->accio = 'N';
    if( $this->getRequest()->hasParameter('BSAVE') ) $this->accio = 'S';
    if( $this->getRequest()->hasParameter('BDELETE') ) $this->accio = 'D';
    if( $this->getRequest()->hasParameter('BCERCA')) $this->accio = 'L';  

    $this->getUser()->setSessionPar('accio',$this->accio);
    
    switch( $this->accio )
    {    	
    	
      case 'C':
    			$this->getUser()->addLogAction('inside','gAgenda');                
    			$this->AGENDES = AgendatelefonicadadesPeer::doSearch( $this->CERCA['text'] , $this->getUser()->getSessionPar('idS') );
    			break;
    	
      case 'N':
                $this->MODE = 'NOU';         
                $this->FAgenda = AgendatelefonicaPeer::initialize(0,$this->getUser()->getSessionPar('idS'));                                       
                break;                
      case 'E':
                $this->MODE = 'EDICIO';
                $AID = $request->getParameter('AID');                                                                
                $this->FAgenda = AgendatelefonicaPeer::initialize($AID,$this->getUser()->getSessionPar('idS'));
                $OAT = $this->FAgenda->getObject();                
                if($OAT->isNew()):
                    $this->DADES = array();                	
                else:
                	$this->DADES = $OAT->getAgendatelefonicadadess();
                endif;
                                                
                break;
      case 'S':      			
                $RA = $request->getParameter('agendatelefonica');                
      			$AID = $RA['AgendaTelefonicaID'];
                $this->FAgenda = AgendatelefonicaPeer::initialize($AID,$this->getUser()->getSessionPar('idS'));      			
      			$this->FAgenda->bind($RA);
      			if($this->FAgenda->isValid()):
					$this->FAgenda->save();
					$this->getUser()->addLogAction($this->accio,'gAgenda',$this->FAgenda->getObject());
                    $this->AID = $this->FAgenda->getObject()->getAgendatelefonicaid();													
					AgendatelefonicadadesPeer::update($request->getParameter('Dades'),$this->AID,$this->getUser()->getSessionPar('idS')); //Actualitzem tambÃ© les dades relacionades
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
                $this->FAgenda = AgendatelefonicaPeer::initialize($AID,$this->getUser()->getSessionPar('idS'));      
                if(!$this->FAgenda->isNew()):
                    $this->FAgenda->getObject()->setActiu(false);
                    $this->FAgenda->getObject()->save();                    
                    $this->getUser()->addLogAction($this->accio,'gAgenda',$this->FAgenda->getObject());
                endif;  
                break;       
      default:                 
                $this->AGENDES = AgendatelefonicadadesPeer::doSearch( $this->CERCA['text'] , $this->getUser()->getSessionPar('idS') );
                break;
    
    }    
    
    if(!empty($this->CERCA)):       
       $this->AGENDES = AgendatelefonicadadesPeer::doSearch( $this->CERCA['text'] , $this->getUser()->getSessionPar('idS') );
    else:
       $this->AGENDES = array();
    endif;
        
  }  
  
  //**************************************************************************************************************************************************
  //**************************************************************************************************************************************************
  
  
  public function executeGMissatges(sfWebRequest $request)  
  {
  	   	
    $this->setLayout('gestio');
    
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
      			$this->MISSATGES = MissatgesPeer::doSearch( $this->CERCA['text'] , $this->PAGINA , false , $this->getUser()->getSessionPar('idS') );
      			$this->getUser()->addLogAction('inside','gMissatges');      			      			
      			break;
      
      case 'N':
      	
                $this->MODE['NOU'] = true;
                $this->FMissatge = MissatgesPeer::inicialitza(0,$this->getUser()->getSessionPar('idU') , $this->getUser()->getSessionPar('idS'));                
                $this->getUser()->setSessionPar('IDM',0);           
                $this->IDU = $this->getUser()->getSessionPar('idU');   	                                                
                break;
                                                
      case 'E':
      	
                $this->MODE['EDICIO'] = true;                
                $IDM = $request->getParameter('IDM');
                $this->getUser()->setSessionPar('IDM',$IDM);
                $this->FMissatge = MissatgesPeer::inicialitza($IDM,$this->getUser()->getSessionPar('idU') , $this->getUser()->getSessionPar('idS'));                
                $this->IDU = $this->getUser()->getSessionPar('idU');                      
                break;
                
      case 'S':
      			      			
      			$IDM = $this->getUser()->getSessionPar('IDM');
      			$this->FMissatge = MissatgesPeer::inicialitza($IDM,$this->getUser()->getSessionPar('idU') , $this->getUser()->getSessionPar('idS'));                
                $this->FMissatge->bind($request->getParameter('missatges'));                
                if ($this->FMissatge->isValid()) { 
                	$this->FMissatge->save();
                	$this->getUser()->addLogAction($accio,'gMisatges',$this->FMissatge->getObject());   
                	$this->redirect('gestio/gMissatges?accio=I'); 
                }                              	                                                                                
                $this->MODE['EDICIO'] = true;              
                break;
      case 'D':
      			$this->IDM = $this->getUser()->getSessionPar('IDM');                
                $M = MissatgesPeer::retrieveByPK($this->IDM);
                if($M instanceof Missatges) { $M->setActiu(false); $M->save(); $this->getUser()->addLogAction($accio,'gMisatges',$M); }
                $this->redirect('gestio/gMissatges?accio=I');                
                break;
      case 'SF':
      			$this->MISSATGES = MissatgesPeer::doSearch( $this->CERCA['text'] , $this->PAGINA , true , $this->getUser()->getSessionPar('idS') );      			
      			break;
      default: 
                $this->MISSATGE = new Missatges();
                $this->getUser()->setSessionPar('IDM',0);
                $this->MISSATGES = MissatgesPeer::doSearch( $this->CERCA['text'] , $this->PAGINA , false , $this->getUser()->getSessionPar('idS') );
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
    $this->FCerca->setChoice(MaterialgenericPeer::select());    
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
	    if($request->hasParameter('BCERCA')) { 			$accio = ( $this->CERCA['select'] == 1 )?'CA':'CI'; $this->PAGINA = 1; }   
	    elseif($request->hasParameter('BNOU')) 	    	$accio = 'NC';
	    elseif($request->hasParameter('BSAVECODICURS')) $accio = 'SC';
	    elseif($request->hasParameter('BSAVE'))     	$accio = 'SCC';	    
	    elseif($request->hasParameter('BDELETE'))     	$accio = 'D';
    }                
    
    //Aquest petit bloc Ã©s per si es modifica amb un POST el que s'ha enviat per GET
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

		//Si el codi existeix, carrego les dades, altrament nomÃ©s guardo.    		
    	case 'SC':
				$RP = $request->getParameter('cursos_codi'); 			                				
				$codi = ($RP['CodiT'] != "")?$RP['CodiT']:$RP['Codi']; 				
				$this->FCurs = CursosPeer::getCopyCursByCodi( $codi , $this->IDS ); 	                    			                                                    			    			    		    		        		        		        		    
				$this->MODE = 'EDICIO_CONTINGUT';       		    	   		    	     		        		        		        		        			
    		break;    		
    		
    	//Editem un curs que ja existeix. 
    	case 'EC':
                $this->FCurs = CursosPeer::initialize( $request->getParameter('IDC') , $this->IDS );    			    			    							 			
    			$this->MODE = 'EDICIO_CONTINGUT';    			
    		break;
    	    		
    	//Guarda el contingut del curs
    	case 'SCC':
                $RP = $request->getParameter('cursos');
                $this->FCurs = CursosPeer::initialize( $RP['idCursos'] , $this->IDS );                                                                                        
    		    $this->FCurs->bind($RP);
    		    if($this->FCurs->isValid()):                    
    		    	$this->FCurs->save();
    		    	$this->getUser()->addLogAction($accio,'gCursos',$this->FCurs->getObject());    		    	     		    
    		    endif;    		        		    
    			$this->MODE = 'EDICIO_CONTINGUT';
    		break;
    	//Esborra un curs	
    	case 'D': 
                $RP = $request->getParameter('cursos');
                $this->FCurs = CursosPeer::initialize( $RP['idCursos'] , $this->IDS );
                $this->FCurs->getObject()->setActiva(false)->save();                            			    			
 				$this->getUser()->addLogAction($accio,'gCursos',$this->FCurs->getObject());    	        					
				$this->redirect('gestio/gCursos?accio=CA');
    	    break;
		case 'CI' :	
				$this->CURSOS = CursosPeer::getCursos(CursosPeer::PASSAT , $this->PAGINA , $this->CERCA['text'] , $this->IDS );
				$this->MODE = 'CI';				 
			break;		
		case 'CA' :				
				$this->CURSOS = CursosPeer::getCursos(CursosPeer::ACTIU , $this->PAGINA , $this->CERCA['text'] , $this->IDS );				
				$this->MODE = 'CA';
			break;					
		case 'L': 
				$this->MATRICULES = CursosPeer::getMatricules($request->getParameter('IDC') , $this->IDS );
				$this->MODE = 'LLISTAT_ALUMNES'; 
			break;
		case 'C':
				$this->getUser()->addLogAction('inside','gCursos');
			break;
    }           
  }
	 
	
  
  public function executeGReserves(sfWebRequest $request)
  {
  	
    $this->setLayout('gestio');
    $this->IDS = $this->getUser()->getSessionPar('idS');
        
  	//Netegem cerca
  	if($request->getParameter('accio') == 'C'):      		
        $this->CERCA = $this->getUser()->setSessionPar('cerca',array('text'=>'','select'=>''));    		      			      	      		
      	$this->PAGINA = $this->getUser()->setSessionPar('pagina',1);
    endif;    
        
    $this->PAGINA = $this->getUser()->ParReqSesForm($request,'PAGINA',1);
    $this->CERCA  = $this->getUser()->ParReqSesForm($request,'cerca',array('text'=>''));    
    
    //Inicialitzem el formulari de cerca
    $this->FCerca = new CercaForm();        
	$this->FCerca->bind($request->getParameter('cerca'));
	
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
                if($this->saveReservaEspais($request,$accio)) $this->redirect('gestio/gReserves?accio=NN');
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
       
        //Envio un correu amb les condicions. 
        case 'SR':
        
                //Primer guardem i el marquem pendent de confirmació 
                if($this->saveReservaEspais($request,$accio)):
                    
                    $RP = $request->getParameter('reservaespais');
                    $OR = ReservaespaisPeer::initialize($RP['ReservaEspaiID'],$this->IDS)->getObject();                                                            
                    $OR->setEstat(ReservaespaisPeer::PENDENT_CONFIRMACIO);
                    $OR->save();                    
                    
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
                    
                    //Enviem el correu a la persona. 
                    $this->sendMail(OptionsPeer::getString('MAIL_FROM',$this->IDS),
                                    $email,
                                    'Nova reserva d\'espai',
                                    ReservaespaisPeer::sendMailCondicions( $OR , $PARA , $PARR , $this->IDS ));
                                    
                    //També una còpia a informàtica
                    $this->sendMail(OptionsPeer::getString('MAIL_FROM',$this->IDS),
                                    OptionsPeer::getString('MAIL_SECRETARIA',$this->IDS),
                                    'Nova reserva d\'espai',
                                    ReservaespaisPeer::sendMailCondicions( $OR , $PARA , $PARR , $this->IDS ));
                                         
                endif; 
                break;        	 
    }
        
    $this->RESERVES = ReservaespaisPeer::getReservesSelect( $this->CERCA['text'] , $this->PAGINA , $this->IDS );    
  		
  }


    private function saveReservaEspais($request,$accio){
        
        $RP = $request->getParameter('reservaespais');
        $this->FReserva = ReservaespaisPeer::initialize($RP['ReservaEspaiID'],$this->IDS);        	    		        		  	    
	    $this->FReserva->bind($RP);    		    
	    if($this->FReserva->isValid()):
	    	$this->FReserva->save();
	    	$this->getUser()->addLogAction($accio,'gReserves',$this->FReserva);	    	
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
    $this->FCerca->setChoice(array(1=>'Cursos',2=>'Alumnes')); 
	$this->FCerca->bind($this->CERCA);	
	
	//Inicialitzem variables
	$this->MODE = array('CONSULTA'=>false,'NOU'=>false,'EDICIO'=>false, 'LMATRICULES'=>false , 'VERIFICA' => false);

    if($request->isMethod('POST')){
	    if($request->hasParameter('BCERCA')) { 			 $accio = ( $this->CERCA['select'] == 2 )?'CA':'CC'; $this->PAGINA = 1; }   
	    elseif($request->hasParameter('BNOU')) 	    	 $accio = 'NU';
	    elseif($request->hasParameter('BADDUSER')) 		 $accio = 'ADD_USER';
	    elseif($request->hasParameter('BSAVENEWUSER')) 	 $accio = 'SAVE_NEW_USER';	    
	    elseif($request->hasParameter('BSELCURS')) 		 $accio = 'SNU';
	    elseif($request->hasParameter('BSAVECURS')) 	 $accio = 'SAVE_CURS';
	    elseif($request->hasParameter('BPAGAMENT')) 	 $accio = 'PAGAMENT';	    
	    elseif($request->hasParameter('BSUBMIT')) 		 $accio = 'S';
	    elseif($request->hasParameter('BDELETE')) 		 $accio = 'D';
	    elseif($request->hasParameter('BSAVE')) 		 $accio = 'SAVE_MATRICULA';
    }                
    
    //Aquest petit bloc és per si es modifica amb un POST el que s'ha enviat per GET
    $this->getUser()->setSessionPar('accio',$accio);
    $this->getUser()->setSessionPar('PAGINA',$this->PAGINA);   //Guardem la pÃ gina per si hem fet una consulta nova  
    
    switch($accio){

    	//Crea un usuari nou per poder seguir fent la matrícula
    	case 'ADD_USER':    		
                $this->FUsuari = UsuarisPeer::initialize(0,$this->IDS,true);    			    		    			     							    	    		
    			$this->MODE = 'MAT_NOU_USUARI';    			  	
    		break;
    		
    	//Guarda el nou usuari
    	case 'SAVE_NEW_USER':    			    			    			
                $RU = $request->getParameter('usuaris');
    			$this->FUsuari = UsuarisPeer::initialize(0,$this->IDS,true);  			
    			$this->FUsuari->bind($RU);
    			if($this->FUsuari->isValid()):
    				$this->FUsuari->save();
    				$this->getUser()->addLogAction($accio,'gMatricules',$this->FUsuari->getObject());    				    				    			
    				$this->redirect('gestio/gMatricules?accio=NU');
    			endif;     			    							    	    		
    			$this->MODE = 'MAT_NOU_USUARI';    			  	
    		break;
    	
    	// Nova matrícula
    	case 'NU':            						
                $this->IDM = $request->getParameter('IDM',null);
                $this->FMatricula = MatriculesPeer::initialize($this->IDM,$this->IDS,true);            				    			    			    			
    			$this->MODE = 'MAT_USUARI';  	
    		break;
    		
    	//Comprovem les dades que hem entrat de l'usuari
    	case 'SNU':
                $RM = $request->getParameter('matricules_usuari');
                $this->FMatricula = MatriculesPeer::initialize(0,$this->IDS,true);    			    			
    			$this->FMatricula->bind($RM);    			
    			if($this->FMatricula->isValid()):
    				$this->FMatricula->save();
    				$this->getUser()->addLogAction($accio,'gMatricules',$this->FMatricula->getObject());
                    //Si tot OK, iniciem l'elecció del curs
                    $this->IDM = $this->FMatricula->getObject()->getIdmatricules();     				
    				$this->CURSOS = MatriculesPeer::getCursosMatriculacio($this->IDS);    		    			    			    			
    			    $this->MODE = 'NOU';
                else: 
                    $this->MODE = 'MAT_USUARI';
    			endif;    			    			     			
    		break;
    	
    	//Guardem la matrícula al curs que hem escollit
    	case 'SAVE_CURS':    
                $this->IDM = $request->getParameter('IDM'); //L'hem enviat ocult
                $this->IDC = $request->getParameter('IDC');
                                                                
                $this->FMatricula = MatriculesPeer::initialize($this->IDM,$this->IDS,false);
                                		
                $OMatricula = $this->FMatricula->getObject();    			    			
    			$OMatricula->setCursosIdcursos($this->IDC);
    			$OMatricula->setDatainscripcio(date('Y-m-d H:m',time()));
    			$Preu = CursosPeer::CalculaPreu($OMatricula->getCursosIdcursos(),$OMatricula->getTreduccio(), $this->IDS );
    			$OMatricula->setEstat(MatriculesPeer::EN_PROCES);
    			$OMatricula->setPagat($Preu);    			
    			$OMatricula->save();
    			$this->getUser()->addLogAction($accio,'gMatricules',$OMatricula);
    			$this->redirect('gestio/gMatricules?accio=FP&IDM='.$this->IDM);
    		break;

    	//Mostra la prematrícula i carreguem les dades del pagament
    	case 'FP':    		
                $this->FMatricula = MatriculesPeer::initialize($request->getParameter('IDM'),$this->IDS);                
    			$this->MATRICULA = $this->FMatricula->getObject();
                $this->IDM = $this->MATRICULA->getIdmatricules();
    			    			    			    		     
    		    $PREU = CursosPeer::CalculaTotalPreus(array($this->MATRICULA->getCursosIdcursos()),$this->MATRICULA->getTreduccio(),$this->IDS);
    		    $NOM  = UsuarisPeer::retrieveByPK($this->MATRICULA->getUsuarisUsuariid())->getNomComplet();
                $this->CURS_PLE = CursosPeer::isPle($this->MATRICULA->getCursosIdcursos(),$this->IDS); //Passem si el curs es ple
    		    $MATRICULA = $this->MATRICULA->getIdmatricules();
                    		        		        			
    			$this->TPV = MatriculesPeer::getTPV($PREU,$NOM,$MATRICULA,$this->IDS);    			    			
    			$this->MODE = 'VALIDACIO_CURS';
    		break;
    		    		
    	//Entenem que hem fet un pagament a caixa i mostrem missatge de finalització.  
    	case 'PAGAMENT':        
                $this->IDM = $request->getParameter('IDM');                                                  			    			
    			$this->OM = MatriculesPeer::setMatriculaPagada( MatriculesPeer::retrieveByPK( $this->IDM ) );                    			
    			$this->getUser()->addLogAction($accio,'gMatricules',$this->MATRICULA);    				
    			$this->MODE = 'PAGAMENT';
                $this->SendMailMatricula($this->OM,$this->IDS);       			  							
    		break;
            
    	//Si hem fet un pagament amb targeta, anem a la següent pantalla. 
    	case 'OK':
    		 if($this->getRequestParameter('Ds_Response') == '0000'):
                 $this->IDM = $this->getRequestParameter('Ds_MerchantData');                 
                 $this->OM = MatriculesPeer::setMatriculaPagada( MatriculesPeer::retrieveByPK( $this->IDM ) );
                 $this->getUser()->addLogAction($accio,'gMatricules',$this->OM);                 
                 $this->MISSATGE = "La matrícula s'ha realitzat correctament.";
                 $this->SendMailMatricula($this->OM);                                  
              else:			            
                 $this->MISSATGE = "Hi ha hagut algun problema realitzant la matrícula. Si us plau torna-ho a intentar.";              
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
    				$this->redirect('gestio/gMatricules?accio=CA');
    			endif;
    			$this->MODE = 'EDICIO';    		
    		break;    	
    			
		case 'CA':					
				$this->ALUMNES = MatriculesPeer::cercaAlumnes($this->CERCA['text'] , $this->PAGINA , $this->IDS );
				$this->SELECT = 2;
				$this->MODE = 'CONSULTA';				 
			break;		
		case 'CC':
				$this->CURSOS = MatriculesPeer::cercaCursos($this->CERCA['text'] , $this->PAGINA , $this->IDS );
				$this->SELECT = 1;
				$this->MODE = 'CONSULTA';
			break;
		case 'LMA':
				$this->MATRICULES = MatriculesPeer::getMatriculesUsuari($request->getParameter('IDA') , $this->IDS );				
				$this->MODE = 'LMATRICULES'; 
			break;
		case 'LMC':
				$this->MATRICULES = MatriculesPeer::getMatriculesCurs($request->getParameter('IDC') , $this->IDS );
				$this->MODE = 'LMATRICULES';
			break;		
		case 'P':
			
				$IDP = $request->getParameter('IDP');
				$OM = MatriculesPeer::retrieveByPK($IDP);
				$OU = $OM->getUsuaris();
				$OC = $OM->getCursos();
				
				$doc = new sfTinyDoc();
				$doc->createFrom(array('extension' => 'docx'));
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
                
				$doc->saveXml();
				$doc->close();
				$doc->sendResponse();
				$doc->remove();
				
				throw new sfStopException; 
				
			break;
		case 'C':
				$this->getUser()->addLogAction('inside','gMatricules');
			break;
    }  	      
  }
  
  //Envia el correu d'una matrícula
  public function SendMailMatricula($OM,$idS){
    if($OM->getEstat() == MatriculesPeer::ACCEPTAT_PAGAT):
        $this->sendMail(OptionsPeer::getString('MAIL_FROM',$this->IDS),
      					$OM->getUsuaris()->getEmail(),  							
      					'Resguard de matrícula',
      					MatriculesPeer::MailMatricula($OM,$idS));  			
    	$this->sendMail(OptionsPeer::getString('MAIL_FROM',$this->IDS),
    					'informatica@casadecultura.org',
    					'Resguard de matrícula',
    					MatriculesPeer::MailMatricula($OM,$idS));
     else: 
        $this->sendMail(OptionsPeer::getString('MAIL_FROM',$this->IDS),
      					$OM->getUsuaris()->getEmail(),  							
      					'Problema en realitzar matrícula',
      					MatriculesPeer::MailMatriculaFAIL($OM,$idS));  			
    	$this->sendMail(OptionsPeer::getString('MAIL_FROM',$this->IDS),
    					'informatica@casadecultura.org',
    					'Problema en realitzar matrícula',
    					MatriculesPeer::MailMatriculaFAIL($OM,$idS));     
     endif; 
  }
        
  public function executeGNoticies(sfWebRequest $request)  
  { 
  	    
    $this->setLayout('gestio');
    $this->IDS = $this->getUser()->getSessionPar('idS');
        
    //Inicialitzem el formulari de cerca    
    $this->CERCA  = $this->getUser()->ParReqSesForm($request,'cerca',array('text'=>'','select'=>1));
    if(!isset($this->CERCA['select']))
    {
        $this->CERCA = array('text'=>'','select'=>1);
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
            $this->CERCA  = $this->getUser()->ParReqSesForm($request,'cerca',array('text'=>'','select'=>1));			
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
            $this->getUser()->addLogAction($accio,'gNoticies',$this->FORMULARI->getObject());				
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
			    	$this->redirect('gestio/gIncidencies?accio=C');
			    endif; 
			    $this->MODE['EDICIO'] = true;    		        		        			
			break;
		case 'D': 
                $RP = $request->getParameter('incidencies');
                $this->FIncidencia = IncidenciesPeer::initialize( $RP['idIncidencia'] , $this->IDU , $this->IDS );
                $this->FIncidencia->getObject()->setActiu(false)->save();		        
		        $this->getUser()->addLogAction($accio,'gNoticies',$this->FIncidencia->getObject());		            	        
		        break;    	         	 
	}
		    
	$this->INCIDENCIES = IncidenciesPeer::getIncidencies( $this->CERCA['text'] , $this->PAGINA , $this->IDS );
  
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
        		    $this->MODE = 'FINALITZAT';
                endif; 
                    		        		        			
    		break;
    		
    	//Esborra cessió
    	case 'DC': 
    	        $OC = CessioPeer::retrieveByPK($this->getUser()->getSessionPar('IDC'));
    	        $this->getUser()->addLogAction($accio,'gCessio',$OC);
    	        $OC->delete();    	        
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
                            
    $this->CESSIONS = CessioPeer::getCessions($this->PAGINA,$this->CERCA['select'],$this->CERCA['text']);
  
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
    			$this->FORM_MENU->getObject()->setActiu(false)->save();    			
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
    					$this->FORM_PAGE->getObject()->setActiu(false)->save();
                            					
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
    			
                $this->FORM_ENTRY->getObject()->setActiu(false)->save();
                
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
    			$this->FORM_BLOG->getObject()->setActiu(false)->save();
                unset($this->FORM_BLOG);
    		break;
                		
    	case 'DELETE_IMAGE':    			
    			$this->getUser()->addLogAction($accio,'gBlogs',$this->APP_MULTIMEDIA);
                AppBlogsMultimediaPeer::initialize( $this->APP_MULTIMEDIA , $this->IDS )->getObject()->setActiu(false)->save();
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
    			$ESTAT    = $request->getParameter('ESTAT');
    			$OO = AppBlogsFormsEntriesPeer::initialize( $APP_FORM_ENTRY , $this->IDS );
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
	
	switch($this->accio){
		case 'MAT_DIA_PAG':
				$this->DADES = array();				
				foreach(MatriculesPeer::getMatriculesPagadesDia($request->getParameter('mode_pagament'),$this->IDS) as $OM):
					$OU = $OM->getUsuaris();
					$OC = $OM->getCursos();
					$this->DADES[$OM->getIdmatricules()]['DATA'] = $OM->getDatainscripcio('d/m/Y');
					$this->DADES[$OM->getIdmatricules()]['IMPORT'] = $OM->getPagat();
					$this->DADES[$OM->getIdmatricules()]['DNI'] = $OU->getDni();
					$this->DADES[$OM->getIdmatricules()]['NOM'] = $OU->getNomComplet();
					$this->DADES[$OM->getIdmatricules()]['CURS'] = $OC->getCodi();
                    $this->DADES[$OM->getIdmatricules()]['HORA'] = $OM->getDatainscripcio('H:i');                                                           
				endforeach;				 
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
  	$this->USUARI = $this->getUser()->getSessionPar('idU');
    
    //Usuari a qui se li aplica
  	$this->IDU = $request->getParameter('IDU');
    //Identificador de línia 
  	$this->IDP = $request->getParameter('IDPERSONAL');
    //Data a la que s'ha fet.
  	$this->DATE = $request->getParameter('DATE');
  	
  	if($request->hasParameter('DATAI')) $this->DATAI = $request->getParameter('DATAI');
  	else $this->DATAI = time();
  	
  	$accio = $request->getParameter('accio');
  	
  	if($request->hasParameter('BSAVE')):  $accio = "SAVE_CHANGE";  endif; 
    if($request->hasParameter('BDELETE')):  $accio = "DELETE_CHANGE";  endif;
  	
  	$this->CALENDARI = PersonalPeer::getHoraris( $this->DATAI , $this->IDS );
  	
  	switch($accio){
  		case 'CC':
			$this->getUser()->addLogAction('inside','gPersonal');
  			break;
  		case 'EDIT_DATE':
  				//Editem un dia, i podem esborrar un canvi o bé afegir-ne un de nou.
  				$this->DADES_DIA_USUARI = PersonalPeer::getDadesUpdates($this->DATE, $this->IDU , $this->IDS );
                $this->DIA = $this->DATE;  				  
  			break;  			
  		case 'NEW_CHANGE':
  				$this->FPERSONAL = PersonalPeer::initialize($this->USUARI , $this->DATE, $this->IDU , null , $this->IDS );  				
  			break;
  		case 'EDIT_CHANGE':
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
  					$this->redirect('gestio/gPersonal?accio=EDIT_DATE&DATE='.$idD.'&IDU='.$idU);
  				else: 
  					$this->ERROR[] = "Hi ha algun problema amb el formulari.";
  				endif; 
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
				$this->redirect('gestio/gPersonal?accio=EDIT_DATE&DATE='.$idD.'&IDU='.$idU);				  			
  			break;
  	}
  	
  }
  
  public function executeGCicles(sfWebRequest $request)
  {

    $this->setLayout('gestio');
    $this->IDS = $this->getUser()->getSessionPar('idS');

    $this->IDC = $request->getParameter('IDC');                
    $this->MODE   = "";
    
    $this->PAGINA = $request->getParameter('PAGINA');
    
    //Inicialitzem el formulari de cerca
    $this->CERCA  = $this->getUser()->ParReqSesForm($request,'cerca',array('text'=>""));
    $this->FCerca = new CercaForm();            
	$this->FCerca->bind(array('text'=>$this->CERCA['text']));
    
    $accio = $request->getParameter('accio');
    if($request->hasParameter('BSAVE')) $accio = 'SAVE';
    if($request->hasParameter('BDELETE')) $accio = 'DELETE';
    if($request->hasParameter('BNOU')) $accio = 'NOU';
            
            
    switch($accio)
    {    
    	case 'C':			
            $this->CERCA  = $this->getUser()->setSessionPar('cerca',array('text'=>''));    		      			      	      		            
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
    			else: 
    				$this->MODE = 'EDITA';
    			endif; 
    		break;
    
    	case 'DELETE':                
    			$PC = $request->getParameter('cicles');
    			$FC = EntradesPeer::initialize($PC['CicleID'],$this->IDS);
    			$this->getUser()->addLogAction($accio,'gCicles',$FC);
    			$FC->getObject()->setActiu(false);
                $FC->getObject()->save();
    		break;
    		    		    
    }        
    
    $this->CICLES = CiclesPeer::getList($this->PAGINA , $this->CERCA['text'] , $this->IDS);
  	
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
