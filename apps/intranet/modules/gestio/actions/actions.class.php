<?php

/**
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
   * Executes index action
   */
  public function executeIndex()
  {    
    //Mirem si l'usuari Ã©s de la CCG o no      
      //Si Ã©s de la CCG hem de mostrar la gestiÃ³ completa
    //altrament
      //Si Ã©s un usuari normal nomÃ©s ha de poder veure lo seu      
  }
  
  /**
   * Primera crida de l'aplicatiu per a registrats   
   */        
  public function executeMain()
  { 
    $this->setLayout('gestio');
    
    $idU = $this->getUser()->getAttribute('idU');    
    
    //Carreguem quantes incidÃ¨ncies noves hi ha
    $this->NINCIDENCIES = IncidenciesPeer::QuantesAvui(); 
    //Carreguem quantes matrÃ­cules noves hi ha
    $this->NMATRICULES  = MatriculesPeer::QuantesAvui();
    //Carreguem quant material nou hi ha
    $this->NMATERIAL    = MaterialPeer::QuantAvui();
    //Carreguem quants missatges nous hi ha
    $this->NMISSATGES   = MissatgesPeer::QuantsAvui($idU);
    //Carreguem quantes feines s'han fet
    $this->NFEINES      = TasquesPeer::QuantesAvui(false,$idU);    
    //Carreguem quantes feines ens toca fer
    $this->NFINES       = TasquesPeer::QuantesAvui(true,$idU);
    //Carreguem quantes activitats hi ha
    $this->NACTIVITATS  = ActivitatsPeer::QuantesAvui();
    
    //Carreguem els missatges d'avui    
    $this->MISSATGES = MissatgesPeer::getMissatgesAvui($idU);
        
    //Carreguem les tasques d'avui
    $this->TASQUES = TasquesPeer::getCercaTasques(1,$idU,0,true);
    
    //Carreguem les activitats d'avui :D
    $this->ACTIVITATS = HorarisPeer::getActivitats(date('Y-m-d',time()) , null , null , null , null);
    $this->ACTIVITATS = $this->ACTIVITATS['ACTIVITATS'];
  
  }
  
  /**
   * FEM UN LOGIN
   */       
  public function executeLogin()
  {
    $this->setLayout('gestio');
    
  	if($this->getRequest()->hasParameter('DNI') && $this->getRequest()->hasParameter('PASSWD'))
  	{
  	  
  		$c = new Criteria();
  		$c->add( UsuarisPeer::DNI , $this->getRequestParameter('DNI') , CRITERIA::EQUAL );
  		$c->add( UsuarisPeer::PASSWD , $this->getRequestParameter('PASSWD') , CRITERIA::EQUAL );
  		$Usuari = UsuarisPeer::doSelectOne($c);  		
  		if(!is_null($Usuari)): 
  			$this->getUser()->setAuthenticated(true);
  			$this->getUser()->setAttribute('idU',$Usuari->getUsuariid());  			  			
  			$this->getUser()->setAttribute('UserLevel',$Usuari->getNivellsIdnivells());
  			RegistreactivitatPeer::AfegirRegistre($this->getUser()->getAttribute('idU'),RegistreactivitatPeer::LOGIN,null,null);
			  $this->redirect('gestio/main');
  		else:
  			$this->getUser()->setAuthenticated(false);
  			$this->getUser()->setAttribute('idU',null);  			
  		endif;
  	}  	  
  }
  
  /**
   * FEM UN LOGOUT
   */     
  public function executeLogout()
  {
    $this->setLayout('gestio');
  	if($this->getUser()->hasAttribute('idU'))
  		RegistreactivitatPeer::AfegirRegistre($this->getUser()->getAttribute('idU'),RegistreactivitatPeer::LOGOUT,null,null);
    	$this->getUser()->setAuthenticated(false);
    	$this->getUser()->setAttribute('idU',0);  	
  }
  
  /**
   * RETORNA CORRECTE SI EL DNI TÃ‰ UN FORMAT CORRECTE.
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

    $this->CERCA  = $this->ParReqSesForm($request,'cerca',array('text'=>""));    
    $this->IDU    = $this->ParReqSesForm($request,'IDU');            
    $this->PAGINA = $this->ParReqSesForm($request,'PAGINA',1);
    $accio  = $this->ParReqSesForm($request,'accio','FC');
            
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
    
    
    
    $this->getUser()->setAttribute('accio',$accio);
    $this->getUser()->setAttribute('pagina',$this->PAGINA);        
    
    switch($accio){
    
    	//Nou usuari 
       case 'N':
             $this->MODE['NOU'] = true;
             $this->getUser()->setAttribute('FidU',0);                          
             $this->FUsuari = new UsuarisForm();             
             break;
             
       //Edita un usuari
       case 'E':
             $this->MODE['EDICIO'] = true;    
             $USUARI = UsuarisPeer::retrieveByPK($this->IDU);
             $this->FUsuari = new UsuarisForm($USUARI);                          
             break;
       
       //Mostra les llistes a les que estÃ  subscrit un usuari
       case 'L': 
             $this->USUARI = UsuarisPeer::retrieveByPK($this->IDU);
             $this->LLISTAT_LLISTES = LlistesPeer::getLlistesDisponibles($this->IDU);
             $this->MODE['LLISTES'] = true;
             break;
             
       //Mostra els cursos d'un usuari
       case 'C':
             $this->USUARI = UsuarisPeer::retrieveByPK($this->IDU);
             $this->MODE['CURSOS'] = true;
             break;

       //Mostra els registres que ha fet
       case 'R':
             $this->USUARI = UsuarisPeer::retrieveByPK($this->IDU);
             $this->MODE['REGISTRES'] = true;
             break;
       
       //Guarda un usuari 
       case 'S':       	
       		 $OUsuari = UsuarisPeer::retrieveByPk($this->IDU);
       		 if($OUsuari instanceof Usuaris) $this->FUsuari = new UsuarisForm($OUsuari); 
       		 else $this->FUsuari = new UsuarisForm();
       		        		  
             $this->FUsuari->bind($request->getParameter('usuaris'));             
		     if($this->FUsuari->isValid()) $this->FUsuari->save();		     
		     $this->MODE['EDICIO'] = true;      
		     
             break;
              
       //Desvincula un usuari de la llista de correu      
       case 'DL':   
             $D = $request->getParameter('D');
             foreach($D['IDL'] as $IDL) LlistesPeer::desvincula($this->IDU,$IDL);
             $this->redirect("gestio/gUsuaris?accio=L");                            
             break;
             
       //Vincula un usuari a la llista de correu
       case 'VL':
             $D = $request->getParameter('D');
             foreach($D['IDL'] as $IDL) LlistesPeer::vincula($this->IDU,$IDL);
             $this->redirect("gestio/gUsuaris?accio=L");                            
             break;
                           
		//GestiÃ³ de permisos d'aplicacions pels usuaris
        case 'GA':        	
        	$this->USUARI = UsuarisPeer::retrieveByPk($this->IDU);
        	$this->LLISTAT_PERMISOS = UsuarisAppsPeer::getPermisos($this->IDU);        				
        	$this->MODE['GESTIO_APLICACIONS'] = true;
        	break;
        	
        //Guarda la gestiÃ³ d'aplicacions
        case 'SGA':
        	        	
        	UsuarisAppsPeer::save($request->getParameter('PERMIS'),$this->IDU);        	        	
        	$this->USUARI = UsuarisPeer::retrieveByPk($this->IDU);
        	$this->LLISTAT_PERMISOS = UsuarisAppsPeer::getPermisos($this->IDU);        				
        	$this->MODE['GESTIO_APLICACIONS'] = true;
        	break;
    }

    $this->PAGER_USUARIS = UsuarisPeer::cercaTotsCamps( $this->CERCA['text'] , $this->PAGINA );
                    
  }  

  //******************************************************************************************
  // GESTIO DE LES PROMOCIONS ****************************************************************
  //******************************************************************************************
  
  public function executeGPromocions(sfWebRequest $request)
  {
  
    $this->setLayout('gestio');
        
    $this->ERRORS = array(); $this->EDICIO = false; $this->NOU = false; $this->LLISTES = false; $this->CURSOS = false; $this->PROMOCIO = new Promocions();
    
    if($request->getParameter('accio')=='N'):      
      $this->FPromocio = new PromocionsForm();
      $this->getUser()->setAttribute('idP',0);    
      $this->NOU = true;
    elseif($request->getParameter('accio')=='E'):
      $OPromocio = PromocionsPeer::retrieveByPK($request->getParameter('IDP'));
      $this->getUser()->setAttribute('idP',$OPromocio->getPromocioId());
      $this->FPromocio = new PromocionsForm($OPromocio);
      $this->EDICIO = true;
    elseif($request->getParameter('BDELETE')): //Esborra
      $this->PROMOCIO = PromocionsPeer::retrieveByPK($request->getParameter('IDP'));
      $this->PROMOCIO->delete();      
    endif;
    
    if($request->hasParameter('BSAVE')):
      $IDP = $this->getUser()->getAttribute('idP');
      if($IDP == 0) $OPromocio = new Promocions();
      else $OPromocio = PromocionsPeer::retrieveByPK($IDP);
      $this->FPromocio = new PromocionsForm($OPromocio);
      $this->FPromocio->bind($request->getParameter('promocions'),$request->getFiles('promocions'));
      
      if($this->FPromocio->isValid()) { try { $this->FPromocio->save(); } catch (Exception $e) { echo $e->getMessage(); } }
      else echo "No Ã©s vÃ lida";
         
      $this->EDICIO = true;      
    endif;
    
    $C = new Criteria();
    $C->addAscendingOrderByColumn(PromocionsPeer::ORDRE);
    $this->PROMOCIONS = PromocionsPeer::doSelect($C);
    if(is_null($this->PROMOCIONS)) $this->PROMOCIONS = new Promocions();
        
  }
          
  //******************************************************************************************
  // GESTIO DEL WEB **************************************************************************
  //******************************************************************************************
  
  public function executeGEstructura(sfWebRequest $request) 
  {
    $this->setLayout('gestio');
    $this->ERRORS = array(); $this->NOU = false; $this->EDICIO = false; $this->HTML = false;
           
    if($request->getParameter('accio')=='N'):
      $this->getUser()->setAttribute('idN',0);  
      $this->FNode = new NodesForm();                
      $this->NOU = true;
    elseif($request->getParameter('accio')=='E'):               
      $ONode = NodesPeer::retrieveByPK($request->getParameter('idN'));  
      $this->FNode = new NodesForm($ONode);
      $this->getUser()->setAttribute('idN',$ONode->getIdnodes());      
      $this->EDICIO = true;
    elseif($request->getParameter('accio')=='H'):          
      	$NODE = NodesPeer::retrieveByPK($request->getParameter('idN'));
      	$nom = sfConfig::get('sf_web_dir').$NODE->getHTML();
		if(file_exists($nom)):
			$handle = fopen($nom, "r");
			$contents = fread($handle, filesize($nom));
			fclose($handle);
		else:
			$contents = "No s'ha trobat la pÃ gina.";
		endif;      
      
		$this->FHtml = new EditorHtmlForm();
		$this->FHtml->bind(array('titol'=>$NODE->getTitolmenu(),'html'=>$contents));				
      	$this->getUser()->setAttribute('idN',$NODE->getIdnodes());
      	$this->NODE = $NODE;                       
      	$this->HTML = true;
    elseif($request->getParameter('accio')=='D'):
      $this->NODE = NodesPeer::retrieveByPK($request->getParameter('idN'));      
      $this->NODE->delete();
      $this->NODE = new Nodes();                 
    endif;
    
    if($request->hasParameter('BSAVE')):
      $IDN = $this->getUser()->getAttribute('idN');
      $ONode = NodesPeer::retrieveByPK($IDN);
      if($IDN > 0) $this->FNode = new NodesForm($ONode);
      else $this->FNode = new NodesForm();      
            
      $this->FNode->bind($request->getParameter('nodes'));
      if($this->FNode->isValid()) $this->FNode->save();             
      $this->EDICIO = false;                
    elseif($request->hasParameter('SaveHTML')):
      $idN = $this->getUser()->getAttribute('idN');
      $this->FHtml = new EditorHtmlForm();
      $this->FHtml->bind($request->getParameter('editor'));
	  $this->NODE = NodesPeer::retrieveByPK($idN);
	  $this->NODE->setNew(false);                        
      $fd = fopen(sfConfig::get('sf_web_dir').'/pagines/'.$idN.'.php',"w");
      fwrite($fd,$this->FHtml->getValue('html'));
      $this->NODE->setHTML('/pagines/'.$idN.'.php');
      $this->NODE->setTitolmenu($this->FHtml->getValue('titol'));      
      $this->NODE->save();                        
      $this->HTML = true;                
    endif;

    $this->NODES = NodesPeer::retornaMenu(true);
    
  }  
      
  //******************************************************************************************
  // GESTIO DE LES LLISTES *******************************************************************
  //******************************************************************************************
  
  public function executeGLlistes(sfWebRequest $request)
  {
    $this->setLayout('gestio');

    $this->IDL    = $this->ParReqSesForm($request,'IDL');    
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
    
    switch($accio)
    {
    	//Edito un missatge o en creo un de nou.
    	case 'EM':
    			$OMissatge = MissatgesmailingPeer::retrieveByPK($request->getParameter('IDM'));
    			
    			if($OMissatge instanceof Missatgesmailing):
    			
    				$this->FMissatge = new MissatgesmailingForm($OMissatge);
    				$this->getUser()->setAttribute('IDM',$OMissatge->getIdmissatge());
    				
    			else:
    			
    				$OMissatge = new Missatgesmailing();
    				$OMissatge->setDataAlta(date('Y-m-d',time()));    				
    				$this->FMissatge = new MissatgesmailingForm($OMissatge);
    				$this->getUser()->setAttribute('IDM',null);
    				    				
    			endif;     		
    			$this->MODE = 'MISSATGES';    			
    		break;
    		
    	//Guardo un missatge editat. 
    	case 'SM':
    			
    			if($this->saveMissatge($request)):
    				$this->MODE = 'MISSATGES';
    			else: 
    				$this->MODE = 'MISSATGES';
    			endif; 
                                                                     	
    		break;
    		
    	//Esborro un missatge guardat
    	case 'DM':
    			
    			$OMissatge = MissatgesmailingPeer::retrieveByPK($this->getUser()->getAttribute('IDM'));
    			
    			if($OMissatge instanceof Missatgesmailing):
    			
    				$OMissatge->delete();
    				$this->redirect('gestio/gLlistes?accio=C');
    				
    			else:
    			 
    				$this->redirect('gestio/gLlistes');
    				
    			endif;
    		
    		break;
    
    	//Mostro les llistes a les que puc enviar el missatge
    	case 'LM':
    		
    			if($this->saveMissatge($request)):
    				$this->LLISTES_ENVIAMENT = MissatgesllistesPeer::getLlistesArray($this->getUser()->getAttribute('IDM'));    				     				
    				    				
	    			$this->MODE = 'MISSATGES_LLISTES';    				
    			else: 
    				$this->MODE = 'MISSATGES'; 			
    			endif;     			    			

    		break;
    		
    	//Guardo les llistes a les que enviarÃ© el missatge
    	case 'SLM':
    		    			
    			$this->saveMissatgeLlistes($request);
    			$this->LLISTES_ENVIAMENT = MissatgesllistesPeer::getLlistes($this->getUser()->getAttribute('IDM'));    			
    			$this->MODE = 'MISSATGES_LLISTES';
    					
    		break;
    		
    		//Segueixo amb l'enviament del missatge
    	case 'SLEE':
    		
    			$this->saveMissatgeLlistes($request);
    			$this->MODE = "FER_PROVA";
    		
    		break;

    	//Envio un missatge de prova a l'adreÃ§a que digui l'usuari
    	case 'SP':
    		
    		try   { MissatgesmailingPeer::sendProvaMessageId($this->getUser()->getAttribute('IDM'),$request->getParameter('email')); }
    		catch (Exception $e) { $e->getMessage(); }	
    		
    		$this->MODE = "FER_PROVA";
   		
    		break;

    	//Envio el missatge a tothom
    	case 'SMT':
    		
    		try   { MissatgesmailingPeer::sendMessageId($this->getUser()->getAttribute('IDM')); }
    		catch (Exception $e) { $e->getMessage(); }	
    		
    		$this->MODE = "FER_PROVA";
   		
    		break;
    		
    		
    	//Hem acabat l'ediciÃ³... no fem res, nomÃ©s tornem a les llistes
    	case 'SFI':
    			$this->redirect('gestio/gLlistes');
    		break;    		
    		    		
      case 'N':      			
      			$this->FLlista = new LlistesForm();
      			$this->getUser()->setAttribute('idL',0);                 
                $this->MODE = 'NOU';
                break;
      case 'E': 
                $OLlista = LlistesPeer::retrieveByPK($request->getParameter('IDL'));
                $this->getUser()->setAttribute('idL',$OLlista->getIdllistes());
                $this->FLlista = new LlistesForm($OLlista);                
                $this->MODE = 'EDICIO'; 
                break;                      
      case 'VINCULA':               
               $ALTA_USUARIS = $request->getParameter('ALTA_USUARI');
               foreach($ALTA_USUARIS as $U) UsuarisllistesPeer::Vincula($U,$this->IDL);                             
            break;
      case 'DESVINCULA':                              
               $BAIXA_USUARIS = $request->getParameter('BAIXA_USUARI');               
               foreach($BAIXA_USUARIS as $U) UsuarisllistesPeer::Desvincula($U,$this->IDL);               
            break;
      
      case 'MV':                               
                $this->LLISTA_MISSATGES = LlistesPeer::getMissatges($this->IDL , LlistesPeer::TOTS,$this->PAGINA3);         
                $this->MISSATGE = MissatgesllistesPeer::retrieveByPK($this->getRequestParameter('IDM'));                
                $this->MODE = 'MISSATGES';        
                break;                
      case 'S': 
                $IDL = $this->getUser()->getAttribute('idL');
                $OLlista = LlistesPeer::retrieveByPK($IDL);
                if($OLlista instanceof Llistes) $this->FLlista = new LlistesForm($OLlista);
                else $this->FLlista = new LlistesForm();                
                $this->FLlista->bind($request->getParameter('llistes'));
                if($this->FLlista->isValid()) $this->FLlista->save();
                $this->MODE = 'EDICIO';                
                break;       	         	       
      case 'L': 
               $IDL = $this->getRequestParameter('IDL');               
               $this->LLISTA = LlistesPeer::retrieveByPK($IDL); 
               $this->LMISSATGES = LlistesPeer::getMissatges($IDL,null,$this->PAGINA);                             
               $this->MODE = 'LLISTAT';
               break;
      case 'SEND':               
               $this->MAILS = LlistesPeer::EnviaMissatge($this->getRequestParameter('IDM'));
               $this->ENVIAT = true;                               
               break;
      case 'U_EMAIL':
      		
      		break;
      case 'U':
      			$this->gestionaUsuariLlistes($request);
      		break;       
      case 'VINCULA':
      			$this->gestionaUsuariLlistes($request);
      		break;
      case 'DESVINCULA':
      			$this->gestionaUsuariLlistes($request);
      		break;
	  //Imprimeix etiquetes               
      case 'P': 
      		return $this->printEtiquetes($this->IDL);     	
      		break;
    
    }        
  
    //Inicialitzem els valors comuns
	$this->LLISTES = LlistesPeer::doSelect(new Criteria());
	$this->MISSATGES = MissatgesmailingPeer::getMissatges($this->PAGINA);
  
  }

  public function gestionaUsuariLlistes($request)
  {

  		$this->CERCA  = $this->ParReqSesForm($request,'cerca',array('text'=>'','select'=>''));	    	    	    
	    $this->FCerca = new CercaTextChoiceForm();
	    $this->FCerca->bind($this->CERCA);
	    $this->FCerca->setChoice(array('llista'=>'Usuaris pertanyents','nollista'=>'Usuaris no pertanyents'));	    	    
	    		          
    	if($this->CERCA['select'] == 'llista'):
    		$this->USUARIS_LLISTA = UsuarisllistesPeer::getUsuarisLlista( $this->CERCA['text'] ,  $this->IDL , $this->PAGINA );
    		$this->LLISTA = true;
    	else:
         	$this->USUARIS_DISPONIBLES = UsuarisllistesPeer::getUsuarisNoLlista( $this->CERCA['text'] , $this->IDL , $this->PAGINA );
         	$this->LLISTA = false;
    	endif;
    	
    	$this->MODE = 'USUARIS';
  	
  }
  
  
  public function saveMissatgeLlistes(sfWebRequest $request)
  {
  	
	  	foreach($request->getParameter('LLISTES_ENVIAMENT') as $L):
	    	
	    	$IDM = $this->getUser()->getAttribute('IDM');
	    	$OML = MissatgesllistesPeer::retrieveByPK($IDM,$L);    				
	    	if (!($OML instanceof Missatgesllistes)){
	    		$OML = new Missatgesllistes();
	    		$OML->setIdmissatgesllistes($this->getUser()->getAttribute('IDM'));
	    		$OML->setLlistesIdllistes($L);
	    		$OML->setEnviat(null);		
	    		$OML->save();
	    	}
	    endforeach;
  
  }
  
  public function saveMissatge(sfWebRequest $request)
  {
  	
  	$OMissatge = MissatgesmailingPeer::retrieveByPK($this->getUser()->getAttribute('IDM'));
                
    if($OMissatge instanceof Missatgesmailing):
    	$this->FMissatge = new MissatgesmailingForm($OMissatge);
    else: 
        $OMissatge = new Missatgesmailing();                	                	
    	$this->FMissatge = new MissatgesmailingForm($OMissatge);
	endif;              
	
    $this->FMissatge->bind($request->getParameter('missatgesmailing'));
    if($this->FMissatge->isValid()):
 	   $this->FMissatge->save();
       $this->getUser()->setAttribute('IDM',$this->FMissatge->getObject()->getIdmissatge());
       return true;
    else: 
    	return false; 
    endif; 
 
  }

  public function executePrintEntrades()
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
   	
	for($i = 1; $i< 121; $i++):
	
		if($fila > 3) $text = "<br />"; else $text = "";
		if($fila > 6) $text .= ""; 
				$text = $text."
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>$i</b>
				<br />								
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PRIMAVERA LÃ�RICA<br />
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Marjan Nikolovski i Milica Sperovik<br />				
				<br />
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Divendres, 16 d'abril, 20.00 h<br />
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Auditori Josep Viader<br />				
				<br />				
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Preu: 5â‚¬ / ReduÃ¯t: 3â‚¬<br />
																					
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
  
  
  //******************************************************************************************
  // GESTIO DE LES ACTIVITATS *******************************************************************
  //******************************************************************************************
  
  
  public function executeGHoraris()
  {
    $this->setLayout('pla');
    
    $this->DI = array('DIES'=>array() , 'HORAI' => '' , 'HORAF' => '' , 'HORAPRE' => '' , 'HORAPOST' => '' , 'ESPAIS' => array() , 'MATERIAL' => array());
    
    $this->ACCIO = null; $this->VARIAMES = 0; $this->VARIAANY = 0; $this->PAGINA = 0; 
    $this->LEVEL1 = false; $this->ERRORS = array();
        
    $this->DATAI = date('Y-m-d',time());
    $this->DATAF = $this->sumarmesos($this->DATAI,6);
    $this->IDA = $this->getRequestParameter('IDA');
    $this->ACTIVITAT = ActivitatsPeer::retrieveByPK($this->IDA);
    
    $accio = $this->getRequestParameter('ACCIO');
    if($this->getRequest()->hasParameter('Extra')) $accio = 'E';
    elseif($this->getRequest()->hasParameter('Save')) $accio = 'G';
    elseif($this->getRequest()->hasParameter('Seguir')) $accio = 'S';
    else $accio = 'C';
        
    if($accio == 'S' || $accio == 'E' || $accio == 'G'):      
      $this->LEVEL1 = true;
      $this->DI = $this->getRequestParameter('DI');
      $this->LINIA = array();                  
      if(!isset($this->DI['MATERIAL'])) $this->DI['MATERIAL'] = array();
      if(!isset($this->DI['ESPAIS'])) $this->DI['ESPAIS'] = array();      
      foreach($this->DI['DIES'] as $D):
        if($accio == 'S'):
          $this->LINIA[] = array( 'DIA' => date('Y-m-d',$D) , 'HORAPRE' => $this->DI['HORAPRE'] , 'HORAPOST' => $this->DI['HORAPOST'] , 'HORAI' => $this->DI['HORAI'] , 'HORAF' => $this->DI['HORAF'] , 'MATERIAL' => $this->DI['MATERIAL'] , 'ESPAIS' => $this->DI['ESPAIS'] );
        else:
          $this->D = $this->getRequestParameter('D');
          $this->LINIA = $this->getRequestParameter('D');
        endif;
        $this->ERRORS = $this->ValidaHoraris();        
      endforeach;      
      
      if($accio == 'E'):        
        $this->LINIA[] = array( 'DIA' => date('Y-m-d',time()) , 'HORAPRE' => $this->DI['HORAPRE'] , 'HORAPOST' => $this->DI['HORAPOST'] , 'HORAI' => $this->DI['HORAI'] , 'HORAF' => $this->DI['HORAF'] , 'MATERIAL' => $this->DI['MATERIAL'] , 'ESPAIS' => $this->DI['ESPAIS'] );
      endif;
                 
      if($accio == 'G'):                        
       $this->ERRORS = $this->ValidaHoraris();
       if(empty($this->ERRORS)) $this->GuardaHorari();
              
      endif;
      
    endif;   
             

  }
  
  
  //**************************************************************************************************************************************************
  //**************************************************************************************************************************************************
  
  public function executeGTasques(sfWebRequest $request)  
  {
     
    $this->setLayout('gestio');

    $this->NOU = false; 
    $this->EDICIO = false; 
    $this->CERCA = "";
    $accio = "";    
    
    $this->FCerca = new CercaChoiceForm();
    $this->FCerca->setChoice(array(1=>'Tasques d\'avui',2=>'Tasques de la setmana',3=>'Tasques del mes'));
	$this->FCerca->bind($request->getParameter('cerca'));	
	$this->CERCA = $this->FCerca->getValue('text');        

    if($request->hasParameter('PAGINA'))  $this->PAGINA = $request->getParameter('PAGINA');
    else $this->PAGINA = 1;
    
        
    if($request->isMethod('POST') || $request->isMethod('GET')):
    
    	$accio = $request->getParameter('accio');
	    if($request->hasParameter('BNOU'))		$accio = "N";    
	    if($request->hasParameter('BSAVE')) 	$accio = 'S';               
	    if($request->hasParameter('BDELETE')) 	$accio = 'D';	    

	endif;
	    
    switch($accio){    	
    	case 'N':
    		$this->getUser()->setAttribute('IDT',0);		//Posem el valor de IDT a 0    		
    		$OT = new Tasques();
    		$this->FTasca = new TasquesForm($OT);
    		$this->NOU = true;
    		break;
    	case 'E':    		
    		$this->getUser()->setAttribute('IDT',$request->getParameter('IDT'));    					
    		$this->FTasca = new TasquesForm(TasquesPeer::retrieveByPK($this->getUser()->getAttribute('IDT')));
    		$this->EDICIO = true;
    		break;    		    
    	case 'S':    		
    		$IDT = $this->getUser()->getAttribute('IDT');
    		$OT = ($IDT > 0)?TasquesPeer::retrieveByPK($IDT):new Tasques();
    		$this->FTasca = new TasquesForm($OT);
    		$this->FTasca->bind($request->getParameter('tasques'));
    		if($this->FTasca->isValid()) { $this->FTasca->save(); $this->redirect('gestio/gTasques');  }
    		$this->EDICIO = true;    		    		
    		break;	
    	case 'D':    	    
    	    TasquesPeer::retrieveByPK($this->getUser()->getAttribute('IDT'))->delete();
    	    $this->CONSULTA = true;    	        	   
    	    break;
    	case 'F':
    	    $this->IDT = $this->getRequestParameter('IDT');    	    
    	    TasquesPeer::retrieveByPK($this->IDT)->FeinaFeta();
    	    $this->redirect('gestio/gTasques');    	        	    
    	    break;  
    	default:  
    		$this->getUser()->setAttribute('IDT',0);		
    		break;
    }
	      
    $this->TASQUES_ENCOMANADES = TasquesPeer::getCercaTasques($this->CERCA, $this->getUser()->getAttribute('idU'), $this->PAGINA , false);
	$this->TASQUES_PERFER      = TasquesPeer::getCercaTasques($this->CERCA, $this->getUser()->getAttribute('idU'), $this->PAGINA , true);
        
  }
  
  
  //**************************************************************************************************************************************************
  //**************************************************************************************************************************************************
         
  public function netejaParametresSessio()
  {
  	$this->getUser()->setAttribute('text',"");
  	$this->getUser()->setAttribute('PAGINA',1);
  	$this->getUser()->setAttribute('DATAI',time());
  	$this->getUser()->setAttribute('DIA',time());
  	$this->getUser()->setAttribute('IDA',0);
  	$this->getUser()->setAttribute('accio','C');
  
  }

  public function executeSelectCodiCurs(sfWebRequest $request)
  {
  	
  	$C = new Criteria();
  	$RESPOSTA = CursosPeer::getCodisAjax($request->getParameter('q'), $request->getParameter('limit'));
 	  	    
    return $this->renderText(json_encode($RESPOSTA));
      
  }

  public function executeSelectCeditA(sfWebRequest $request)
  {
  	
  	$C = new Criteria();
  	$RESPOSTA = CessiomaterialPeer::getCeditAAjax($request->getParameter('q'), $request->getParameter('limit')); 	  	    
    return $this->renderText(json_encode($RESPOSTA));
      
  }
  
  
  public function executeSelectMaterial(sfWebRequest $request)
  {
  	
  	$C = new Criteria();
  	$C->add(MaterialPeer::MATERIALGENERIC_IDMATERIALGENERIC, $request->getParameter('id'));
  	$RESPOSTA = array(0=>array('key'=>-1,'value'=>0));  	
  	foreach(MaterialPeer::doSelect($C) as $M) $RESPOSTA[] = array('key'=>$M->getIdmaterial() ,'value'=>$M->getIdentificador().'-'.$M->getNom());
  	$RESPOSTA[0]['value'] = (sizeof($RESPOSTA)-1).' resultats.';  	  	  
    $this->getResponse()->setContent(json_encode($RESPOSTA));
    return sfView::NONE;
    
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
    
    $this->CERCA  	= $this->ParReqSesForm($request,'cerca',array('text'=>""));
    $this->PAGINA 	= $this->ParReqSesForm($request,'PAGINA',1);
    $this->DATAI  	= $this->ParReqSesForm($request,'DATAI',time());    
    $this->DIA    	= $this->ParReqSesForm($request,'DIA',time());
    $this->IDA    	= $this->ParReqSesForm($request,'IDA',0);            
    $accio  		= $this->ParReqSesForm($request,'accio','C');
    $this->ACTIVITAT_NOVA = false;    
        
    //Inicialitzem el formulari de cerca
    $this->FCerca = new CercaForm();            
	$this->FCerca->bind(array('text'=>$this->CERCA['text']));
	
	//Inicialitzem variables
	$this->MODE = array();

    if($request->isMethod('POST')){
	    if($request->hasParameter('BCERCA')) { $accio = 'C'; $this->PAGINA = 1; }   
	    elseif($request->hasParameter('BNOU')) 	    		$accio = 'NA';
	    elseif($request->hasParameter('BCICLE')) 			$accio = 'CICLE';
	    elseif($request->hasParameter('BCICLESAVE'))		$accio = 'CICLE_SAVE';
	    elseif($request->hasParameter('BACTIVITAT')) 		$accio = 'ACTIVITAT';
	    elseif($request->hasParameter('BACTIVITATSAVE')) 	$accio = 'ACTIVITAT_SAVE';
	    elseif($request->hasParameter('BHORARI')) 			$accio = 'HORARI';
	    elseif($request->hasParameter('BHORARISAVE')) 		$accio = 'HORARI_SAVE';
	    elseif($request->hasParameter('BHORARIDELETE')) 	$accio = 'HORARI_DELETE';
	    elseif($request->hasParameter('BDESCRIPCIO')) 		$accio = 'DESCRIPCIO';
	    elseif($request->hasParameter('BDESCRIPCIOSAVE')) 	$accio = 'DESCRIPCIO_SAVE';
	    elseif($request->hasParameter('BDESCRIPCIODELETE')) $accio = 'DESCRIPCIO_DELETE';	    	    
    }                
    
    //Quan cliquem per primer cop a qualsevol de les cerques, la pÃ gina es posa a 1
    if($request->getParameter('accio') == 'C') $this->PAGINA = 1;
    if($request->getParameter('accio') == 'CD') { $this->PAGINA = 1; }    
    if($request->hasParameter('DATAI')) { $this->DIA = ""; } 
    
    //Aquest petit bloc és per si es modifica amb un POST el que s'ha enviat per GET
    $this->getUser()->setAttribute('accio',$accio);    
    $this->getUser()->setAttribute('PAGINA',$this->PAGINA);   //Guardem la pÃ gina per si hem fet una consulta nova
    $this->getUser()->setAttribute('DATAI',$this->DATAI);  
    $this->DATAF = mktime(0,0,0,date('m',$this->DATAI)+3,date('d',$this->DATAI),date('Y',$this->DATAI));  //La data final sempre Ã©s 3 mesos superior a la inicial    
   
    switch($accio){
    	
    	//Consulta inicial del calendari sense prèmer cap dia, només amb un factor de cerca
    	case 'C':
                $HORARIS = HorarisPeer::getActivitats(null,$this->CERCA['text'],$this->DATAI,$this->DATAF,null);
                $this->ACTIVITATS = $HORARIS['ACTIVITATS'];                                                                
                $this->CALENDARI = $HORARIS['CALENDARI'];
                $this->MODE['CONSULTA'] = true;
                $this->MODE['LLISTAT'] = true;                                              
                break;
    		break;

    	//Consulta que em mostra les activitats quan canvio de mensualitat o any 
    	case 'CC':    		
                $HORARIS = HorarisPeer::getActivitats(null , $this->CERCA['text'], $this->DATAI, $this->DATAF, null);
                $this->ACTIVITATS = $HORARIS['ACTIVITATS'];                
                $this->CALENDARI = $HORARIS['CALENDARI'];
                $this->MODE['CONSULTA'] = true;
                $this->MODE['LLISTAT'] = true;                                              
            break;
    		
    		
    	//Consulta que em mostra les activitats d'un dia seleccionat del calendari
    	case 'CD':    		
                $HORARIS = HorarisPeer::getActivitats($this->DIA , $this->CERCA['text'], $this->DATAI, $this->DATAF, null);
                $this->ACTIVITATS = $HORARIS['ACTIVITATS'];                
                $this->CALENDARI = $HORARIS['CALENDARI'];
                $this->MODE['CONSULTA'] = true;
                $this->MODE['LLISTAT'] = true;                                                              
    		break;    	
    		    		
		//Entrem al primer pas d'una activitat.    		
    	case 'NA':
    			$this->FCicle = new ActivitatsPas1Form();
    			$this->MODE['NOU'] = true;    			
    			$this->getUser()->setAttribute('IDA',null);    		
    		break;
    		
    	//Pas DOS entrem la descripció del conjunt o passem als horaris
    	case 'CICLE':
    		
    			//És una activitat nova!!
    			if(!$request->hasParameter('IDA')):
    				$RA = $request->getParameter('activitats');
    				    				
    				//Si és una sola activitat, passem directament als horaris.    			
	    			if($RA['cicle'] == 1):
	    				$this->getUser()->setAttribute('isCicle',0);
	    				$this->getUser()->setAttribute('IDC',0);
	    				$this->redirect('gestio/gActivitats?accio=ACTIVITAT');
	    				    			
	    			
	    			//Si és un cicle, apareix una descripció nova del cicle
	    			else:    			
	    				$OC = new Cicles();
	    				$OC->setNom($RA['nom']);
	    				$this->FCicle = new CiclesForm($OC);		    					    					    										
						$this->MODE['CICLE'] = true;
						$this->getUser()->setAttribute('isCicle',1);	
						$this->getUser()->setAttribute('IDC',0);											    					    			
	    			endif; 

	    		//Carreguem la descripció del cicle associat a l'activitat i si no en té passem directament al llistat
    			else:    				
    				$FActivitats = ActivitatsPeer::initilize($this->IDA);    				
    				$cicle = $FActivitats['Cicles_CicleID']->getValue();
    				if(!is_null($cicle)):
	    				$this->FCicle = CiclesPeer::initialize($cicle);
	    				$this->MODE['CICLE'] = true;	
	    				$this->getUser()->setAttribute('isCicle',1);
	    				$this->getUser()->setAttribute('IDC',$this->FCicle->getObject()->getCicleid());
	    			else: 	    				
	    				$this->getUser()->setAttribute('isCicle',0);
	    				$this->getUser()->setAttribute('IDC',0);
	    				$this->redirect('gestio/gActivitats?accio=ACTIVITAT');
	    			endif; 
    			endif; 
    		 
    		break;
    	    		
    	//Guardem el projecte o activitat
    	case 'CICLE_SAVE':
				$RC = $request->getParameter('cicles');
				$this->FCicle = CiclesPeer::initialize($RC['CicleID']);
				$this->FCicle->bind($RC,$request->getFiles('cicles'));
				if($this->FCicle->isValid()):
					$this->FCicle->save();
					$this->getUser()->setAttribute('IDC',$this->FCicle->getObject()->getCicleid());
					$this->redirect('gestio/gActivitats?accio=ACTIVITAT');
				else:
					$this->MODE['ACTIVITAT'] = true; 					
				endif;     			
    		break;
    		
    	//Entrem les activitats... que necessitem
    	case 'ACTIVITAT':
    		    		    		
    		//Una activitat d'un cicle
    		if($this->getUser()->getAttribute('isCicle')):
    			$this->CICLE = CiclesPeer::retrieveByPK($this->getUser()->getAttribute('IDC'))->getNom();
    			$this->MODE['ACTIVITAT_CICLE'] = true;
    			$this->ACTIVITATS = ActivitatsPeer::getActivitatsCicles($this->getUser()->getAttribute('IDC'));
    			$this->FActivitat = ActivitatsPeer::initilize($this->IDA,$this->getUser()->getAttribute('isCicle'),$this->getUser()->getAttribute('IDC'));
    			if($request->hasParameter('new')):
    				$this->FActivitat = ActivitatsPeer::initilize(null,$this->getUser()->getAttribute('isCicle'),$this->getUser()->getAttribute('IDC'));    				
    				$this->getUser()->setAttribute('IDA',0);
    			endif;
    			
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
    			
    			$this->FActivitat = ActivitatsPeer::initilize($this->IDA,$this->getUser()->getAttribute('isCicle'),$this->getUser()->getAttribute('IDC'));
    		endif;
    		     			
    		break;
    		
    	//Guardem l'activitat
    	case 'ACTIVITAT_SAVE':
    		
	    		$this->FActivitat = ActivitatsPeer::initilize($this->IDA,$this->getUser()->getAttribute('isCicle'),$this->getUser()->getAttribute('IDC'));
	    		$this->FActivitat->bind($request->getParameter('activitats'));
	    		if($this->FActivitat->isValid()):
	    			$this->FActivitat->save();
	    			$this->getUser()->setAttribute('IDA',$this->FActivitat->getObject()->getActivitatid());
	    			$this->redirect('gestio/gActivitats?accio=ACTIVITAT');
	    		else: 
	    			if($this->getUser()->getAttribute('isCicle')):
	    				$this->MODE['ACTIVITAT_CICLE'] = true;
    					$this->ACTIVITATS = ActivitatsPeer::getActivitatsCicles($this->getUser()->getAttribute('IDC'));
    					$this->CICLE = CiclesPeer::retrieveByPK($this->getUser()->getAttribute('IDC'))->getNom();
					else:
						$this->MODE['ACTIVITAT_ALONE'] = true;
	    				$this->ACTIVITATS = array(1=>ActivitatsPeer::retrieveByPK($this->IDA));
	    				$this->CICLE = 'No pertany a cap cicle';
	    			endif;
	    		endif; 
    			
    		break;
    		
    	//Entrem els horaris de les activitats
    	case 'HORARI':
    		
				$this->CarregaActivitats(); 
    			    			    			
 				$OActivitat = ActivitatsPeer::retrieveByPK($this->IDA);    			
    			$this->HORARIS = $OActivitat->getHorariss();
    			$this->NOMACTIVITAT = $OActivitat->getNom();    			
    			    			
    			$OHorari = new Horaris();
    			$OHorari->setActivitatsActivitatid($this->getUser()->getAttribute('IDA'));    			    			
    			if($request->hasParameter('nou')) $this->FHorari = new HorarisForm($OHorari);     			
    			$this->HORARI = $OHorari;    			   
				$this->ESPAISOUT = array(); $this->MATERIALOUT = array();    			 		
    			$this->getUser()->setAttribute('IDH',0);
    			if($request->hasParameter('IDH')):
    				$H = HorarisPeer::retrieveByPK($request->getParameter('IDH'));
    				$this->getUser()->setAttribute('IDH',$request->getParameter('IDH'));    				
    				$this->FHorari = new HorarisForm($H);
    				$this->HORARI  = $H;    				
    				foreach($H->getHorarisespaiss() as $HE):    					
    					$this->ESPAISOUT[] = $HE->getEspaisEspaiid();
    					//miro que sigui més gran que 0 perquè sinó pot ser que no tingui material associat
    					if($HE->getMaterialIdmaterial() > 0):
    						$OMaterial = MaterialPeer::retrieveByPK($HE->getMaterialIdmaterial());    			    			
			    			$this->MATERIALOUT[] = array('material'=>$HE->getMaterialIdmaterial(),'generic'=>$OMaterial->getMaterialgenericIdmaterialgeneric());    						 
    					endif;
    				endforeach;    				
    			endif;    		    
    					    			
 				 $this->MODE['HORARI'] = true;
    		break;
		
    	case 'HORARI_SAVE':
    		
	    		$OActivitat = ActivitatsPeer::retrieveByPK($this->IDA);
	    		$this->NOMACTIVITAT = $OActivitat->getNom();
	    		$this->HORARIS = $OActivitat->getHorariss();
	    		
	    		$idH = $this->getUser()->getAttribute('IDH');
	    		$OHorari = HorarisPeer::retrieveByPK($idH);
	    		if($idH == 0) 	$this->FHorari = new HorarisForm();
	    		else			$this->FHorari = new HorarisForm($OHorari);
	    		
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
	    		$RET = $this->GuardaHorari($request->getParameter('horaris'),$this->MATERIALOUT,$this->ESPAISOUT);
	    		if(empty($RET)):
	    			$this->MISSATGE = array(1=>'Horari guardat correctament');
	    			$this->redirect('gestio/gActivitats?accio=HORARI');
	    		else:
	    			$this->MISSATGE = $RET;
	    		endif; 
	    		
	    		$this->CarregaActivitats();
	    		
	    		$this->MODE['HORARI'] = true;
	    			    			    		    	    			
    		break;
    		
    	case 'HORARI_DELETE':

    			$RH = $request->getParameter('horaris');
    			HorarisPeer::retrieveByPK($RH['HorarisID'])->delete();    			
	   			$this->redirect('gestio/gActivitats?accio=HORARI');
	   			
    		break;
    		
    	case 'DESCRIPCIO':
    		
    			$this->CarregaActivitats();
    			
    			$OActivitat = ActivitatsPeer::retrieveByPK($this->IDA);
    			$this->NOMACTIVITAT = $OActivitat->getNom();
    			$this->FActivitat = new ActivitatsTextosForm($OActivitat);
    			$this->MODE['DESCRIPCIO'] = true;
    				    			     			    			
    		break;
    	
    	case 'DESCRIPCIO_SAVE':
    			
    			$this->CarregaActivitats();
    			$OActivitat = ActivitatsPeer::retrieveByPK($this->IDA);
    			$this->FActivitat = new ActivitatsTextosForm($OActivitat);
    			$this->FActivitat->bind($request->getParameter('activitats'),$request->getFiles('activitats'));
    			if($this->FActivitat->isValid()): 
    				$this->FActivitat->save();
    				$this->redirect('gestio/gActivitats?accio=ACTIVITAT');
    			endif; 
    			
    			$THIS->MODE['DESCRIPCIO'] = true;
    		
    		break;
    	
    	case 'DESCRIPCIO_DELETE':
    			
    		break;
    					
    }
     
  }  

  private function CarregaActivitats()
  {
  	
  	if($this->getUser()->getAttribute('isCicle')):
  		$this->CICLE = CiclesPeer::retrieveByPK($this->getUser()->getAttribute('IDC'))->getNom();
    	$this->MODE['ACTIVITAT_CICLE'] = true;
    	$this->ACTIVITATS = ActivitatsPeer::getActivitatsCicles($this->getUser()->getAttribute('IDC'));
    else:
    	$this->CICLE = 'No hi ha cicle';
    	$this->MODE['ACTIVITAT_ALONE'] = true;
    	$this->ACTIVITATS = array(1=>ActivitatsPeer::retrieveByPK($this->IDA));
    endif;
  	
  }
  
  public function GuardaHorari($horaris, $material, $espais)
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
  	  		if(!($any > 2000 && $mes < 13 && $dia < 31 )) $ERRORS[] = "La data que has entrat Ã©s incorrecta";
  			$DBDD['DIES'][] = "$any-$mes-$dia";  		  		
  		endforeach;  	     		
	endif;  	
  	  	       
	
  	$DBDD['HoraPre']  = strval($horaris['HoraPre']['hour'])*60+strval($horaris['HoraPre']['minute']);
  	$DBDD['HoraIn']   = strval($horaris['HoraInici']['hour'])*60+strval($horaris['HoraInici']['minute']);
  	$DBDD['HoraFi']   = strval($horaris['HoraFi']['hour'])*60+strval($horaris['HoraFi']['minute']);
  	$DBDD['HoraPost'] = strval($horaris['HoraPost']['hour'])*60+strval($horaris['HoraPost']['minute']);
  	
    if( $DBDD['HoraPre'] > $DBDD['HoraIn'] )   $ERRORS[] = "L'hora de preparació no pot ser més gran que la d'inici.";
    if( $DBDD['HoraIn']  >= $DBDD['HoraFi'] )   $ERRORS[] = "L'hora d'inici no pot ser més gran o igual que la d'acabament.";
    if( $DBDD['HoraFi']  > $DBDD['HoraPost'] ) $ERRORS[] = "L'hora d'acabament no pot ser més gran que la de desmuntatge.";                
    
    if(empty($espais)) $ERRORS[] = "Has d'entrar algun espai";
        
    //Mirem que la data no es solapi amb alguna altra activitat al mateix espai
    foreach($DBDD['DIES'] as $D):
        	    
    	foreach($espais as $E=>$idE):
	    	if( HorarisPeer::validaDia( $D , $idE , $DBDD['HoraPre'] , $DBDD['HoraPost'] , $horaris['HorarisID'] ) > 0 ):
	    		$Espai = EspaisPeer::retrieveByPK($idE)->getNom();
	    		$ERRORS[] = "El dia $D coincideix a l'espai $Espai amb una altra activitat";
	    	endif;
				    	
	    	foreach($material as $M):
	    		if( HorarisPeer::validaMaterial( $D , $idE , $M['material'] , $DBDD['HoraPre'] , $DBDD['HoraPost'] , $horaris['HorarisID']) > 0 ):
	    			$Espai = EspaisPeer::retrieveByPK($idE)->getNom();
	    			$Mater = MaterialPeer::retrieveByPK($M['material'])->getNom();
	    			$ERRORS[] = "El material $Mater de l'aula $Espai està reservat el dia $D";
    			endif;	    	
	    	endforeach;     	
    	endforeach;
        	    	
    endforeach;
       
    //Si no hem trobat cap error, guardem els registres d'ocupaciÃ³.    
    if(empty($ERRORS)):

 		HorarisPeer::save( $horaris , $DBDD , $material , $espais );
       
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

  	sfConfig::set('sf_web_debug', false);
  	sfLoader::loadHelpers('Partial');
  	
  	$C = new Criteria();
  	$AGENDES = AgendatelefonicadadesPeer::doSearch( $request->getParameter('text') );  	
  
  	return $this->renderText(get_partial('listAgenda', array('AGENDES' => $AGENDES)));  	           	  	        
      
  }  
  
  
  public function executeGAgenda($request)  
  {  		  	
  	$this->setLayout('gestio');

  	//Inicialitzem les variables
  	$this->CERCA  	= $this->ParReqSesForm($request,'cerca',array('text'=>""));  	
  	$this->accio  	= $this->ParReqSesForm($request,'accio',"");
  	$this->AID  	= $this->ParReqSesForm($request,'AID', null);
  	$this->MODE     = "";  	           	
  	
  	//Tractem el formulari de cerca
  	$this->FCerca = new CercaForm();  	  
  	$this->FCerca->bind($this->CERCA);
        
  	//Definim l'acciÃ³ segons el botÃ³ premut  	
    if( $this->getRequest()->hasParameter('BNOU') ) $this->accio = 'N';
    if( $this->getRequest()->hasParameter('BSAVE') ) $this->accio = 'S';
    if( $this->getRequest()->hasParameter('BDELETE') ) $this->accio = 'D';
    if( $this->getRequest()->hasParameter('BCERCA')) $this->accio = 'L';  

    $this->getUser()->setAttribute('accio',$this->accio);
    
    switch( $this->accio )
    {
      case 'N':
                $this->MODE = 'NOU';
                $this->getUser()->setFlash('AID',0);
                $this->FAgenda = new AgendatelefonicaForm();                          
                break;                
      case 'E':
                $this->MODE = 'EDICIO';
                $AID = $request->getParameter('AID');
                $this->getUser()->setAttribute('AID',$AID);                                
                $OAT = AgendatelefonicaPeer::retrieveByPK($AID);
                $this->FAgenda = new AgendatelefonicaForm($OAT);
                if(($OAT instanceof Agendatelefonica )):
                	$this->DADES = $OAT->getAgendatelefonicadadess();
                else:
                	$this->DADES = array();
                endif;
                                                
                break;
      case 'S':      			
      			$AID = $this->getUser()->getAttribute('AID');
      			$OAT = AgendatelefonicaPeer::retrieveByPK($AID);      			      		
      			if( $OAT instanceof Agendatelefonica ):
      				$this->FAgenda = new AgendatelefonicaForm($OAT);
      			else:
      				$this->FAgenda = new AgendatelefonicaForm(new Agendatelefonica());
      			endif;

      			$this->FAgenda->bind($request->getParameter('agendatelefonica'));
      			if($this->FAgenda->isValid()):
					$this->FAgenda->save();					
					$this->getUser()->setAttribute('AID',$this->FAgenda->getObject()->getAgendatelefonicaid());										
					AgendatelefonicadadesPeer::update($request->getParameter('Dades'),$this->getUser()->getAttribute('AID')); //Actualitzem tambÃ© les dades relacionades
					$this->MISSATGE = "El registre s'ha modificat correctament.";
					$this->redirect('gestio/gAgenda?accio=L');
				else: 
					$this->DADES = $OAT->getAgendatelefonicadadess();
					$this->MODE = 'EDICIO';
				endif; 
				      			      															                                     
                break;         
      case 'D': 
                $this->AID = $this->getUser()->getAttribute('AID');
                $A = AgendatelefonicaPeer::retrieveByPK($this->AID);
                if(!is_null($A)) $A->delete();  
                break; 
      default: 
                $this->AGENDA = new Agendatelefonica();
                break;
    
    }    
    
    if(!empty($this->CERCA)):       
       $this->AGENDES = AgendatelefonicadadesPeer::doSearch( $this->CERCA['text'] );
    else:
       $this->AGENDES = array();
    endif;
        
  }  
  
  //**************************************************************************************************************************************************
  //**************************************************************************************************************************************************
  
  
  public function executeGMissatges(sfWebRequest $request)  
  {
  	   	
    $this->setLayout('gestio');
    
    //Actualitzem el requadre de cerca
    $this->FCerca = new CercaForm();
    $this->FCerca->bind($request->getParameter('cerca'));
    $this->CERCA = $request->getParameter('cerca[text]');    
    
    if($request->isMethod('POST') || $request->isMethod('GET')):
    	
    	$accio = $request->getParameter('accio');
    	if( $request->hasParameter('BCERCA') ) 		$accio = 'C';
	    if( $request->hasParameter('BNOU') )  		$accio = 'N';
	    if( $request->hasParameter('BSAVE') ) 		$accio = 'S';
	    if( $request->hasParameter('BDELETE') )		$accio = 'D';
	    
    endif;

    //Inicialitzacions pel template
    $this->CONSULTA = true; 
    $this->NOU 		= false; 
    $this->EDICIO 	= false; 
    $this->accio 	= NULL;
                                      
    switch( $accio )
    {
      case 'N':
                $this->NOU = true;
                $OM = new Missatges();
                $OM->setUsuarisUsuariid($this->getUser()->getAttribute('idU'));
                $this->FMissatge = new MissatgesForm($OM);
                $this->getUser()->setAttribute('IDM',0);              	                                                
                break;                
      case 'E':
                $this->EDICIO = true;
                $IDM = $request->getParameter('IDM');
                $this->getUser()->setAttribute('IDM',$IDM);
                $OM = MissatgesPeer::retrieveByPK($IDM);
                $this->FMissatge = new MissatgesForm($OM);                
                break;
      case 'S':
      			$IDM = $this->getUser()->getAttribute('IDM');
                $OM = ($IDM > 0)?MissatgesPeer::retrieveByPk($IDM):new Missatges();
                $this->FMissatge = new MissatgesForm($OM);                 
                $this->FMissatge->bind($request->getParameter('missatges'));                
                if ($this->FMissatge->isValid()) { $this->FMissatge->save(); $this->redirect('gestio/gMissatges'); }                              	                                                                                
                $this->EDICIO = true;      
                break;
      case 'D':
      			$this->IDM = $this->getUser()->getAttribute('IDM');                
                $M = MissatgesPeer::retrieveByPK($this->IDM);
                if(!is_null($M)) $M->delete();                
                break;                    
      default: 
                $this->MISSATGE = new Missatges();
                $this->getUser()->setAttribute('IDM',0);
                break;
    
    }
    
                    
    $this->MISSATGES = MissatgesPeer::doSearch( $this->CERCA );
    
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
  //Exemple: $this->ParReqSesForm($request,'cerca',array('text'=>""));
  public function ParReqSesForm(sfWebRequest $request, $nomCamp, $default = "") 
  {
  	  	
  	$RET = ""; 	    	
  	
  	if(is_array($default)):
  	
	  	//Si existeix el parÃ metre carreguem el nom actual
	  	if($request->hasParameter($nomCamp)):
	  	
	  		$CAMP = $request->getParameter($nomCamp);
	  		
	  		//Mirem els elements del formulari i els guardem a la sessiÃ³  		  		
	  		foreach( $CAMP as $NOM => $VALOR ):
	  			$this->getUser()->setAttribute($nomCamp.$NOM,$VALOR);  				
	  		endforeach;  				  		  		 
	  		
	  		$RET = $CAMP;  		
	  
	  	//Si no existeix el parÃ metre mirem si ja el tenim a la sessiÃ³
	  	elseif($this->existeixAtributArray($nomCamp,$default)):
	  		$RET = array();
	  		foreach($default as $NOM => $VALOR):
	  			$RET[$NOM] = $this->getUser()->getAttribute($nomCamp.$NOM);
	  		endforeach;
	  		
	  	//Si no el tenim a la sessiÃ³ i tampoc l'hem passat per parÃ metre carreguem el valor per defecte. 
	  	else: 
	  	
	  		foreach($default as $NOM => $VALOR):
	  			$this->getUser()->setAttribute($NOM.$nomCamp, $default);
	  		endforeach;
	  		
	  		$RET = $default;
	  		
	  	endif;
	  	
	else:
		
		//Si existeix el parÃ metre carreguem el nom actual
	  	if($request->hasParameter($nomCamp)):
	  	
	  		$CAMP = $request->getParameter($nomCamp);	  		
	  		$this->getUser()->setAttribute($nomCamp,$CAMP);  					  		  				  		  		 	  		
	  		$RET = $CAMP;  		
	  
	  	//Si no existeix el parÃ metre mirem si ja el tenim a la sessiÃ³
	  	elseif($this->getUser()->hasAttribute($nomCamp)):
	  		
	  		$RET = $this->getUser()->getAttribute($nomCamp);
	  			  		
	  	//Si no el tenim a la sessiÃ³ i tampoc l'hem passat per parÃ metre carreguem el valor per defecte. 
	  	else:
	  	 	  		  		
	  		$this->getUser()->setAttribute($nomCamp, $default);	  			  	
	  		$RET = $default;
	  		
	  	endif;
	
	endif;
  	
  	return $RET;
  }
  
  public function ParSesForm($valor, $nomCamp, $default = "") 
  {

  	$RET = ""; 	    	
  	   	
  	if($this->getUser()->hasAttribute($nomCamp)):
  		$RET = $this->getUser()->getAttribute($nomCamp); 
  	else:   	
  		$this->getUser()->setAttribute($nomCamp, $default);
  		$RET = $default;
  	endif;
  	
  	return $RET;
  }
  
  
  
  /**
   * GestiÃ³ de l'inventari i del material
   * In:  PAGINA , TIPUS, BCERCA, BNOU, BSAVE, BDELETE, IDM , D
   * Out: MATERIAL , MATERIALS , IDM 
   * 
   */
  
  public function executeGMaterial(sfWebRequest $request)  
  {
    
    $this->setLayout('gestio');    
        
    $this->PAGINA = $this->ParReqSesForm($request,'PAGINA',1);
    $this->CERCA = $this->ParReqSesForm($request,'cerca',array('text'=>1));    
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
    	case 'N':
    			$OMaterial = new Material();
    			$OMaterial->setMaterialgenericIdmaterialgeneric($this->TIPUS);
    			$this->FMaterial = new MaterialForm($OMaterial);    			
    			$this->getUser()->setAttribute('IDM',0);
    			$this->NOU = true;
    			
    		break;
    	case 'E':    			
    			$this->getUser()->setAttribute('IDM',$request->getParameter('IDM'));
    			$OMaterial = MaterialPeer::retrieveByPK($this->getUser()->getAttribute('IDM'));
				$this->FMaterial = new MaterialForm($OMaterial);
				$this->getUser()->setAttribute('IDM',$OMaterial->getIdmaterial());   			
    			$this->EDICIO = true;
    		break;
    	case 'S':
    			$OMaterial = new Material();
    			if($this->getUser()->getAttribute('IDM') > 0): $OMaterial = MaterialPeer::retrieveByPK($this->getUser()->getAttribute('IDM')); endif;      			    		        		  
    		    $this->FMaterial = new MaterialForm($OMaterial);
    		    $this->FMaterial->bind($request->getParameter('material'));
    		    if($this->FMaterial->isValid()):
    		    	$this->FMaterial->save();
    		    	$this->redirect('gestio/gMaterial?accio=C');
    		    endif;     		        		    
    			$this->EDICIO = true;
    		break;
    	case 'D':     			
    	        MaterialPeer::retrieveByPK($this->getUser()->getAttribute('IDM'))->delete();  	        
    	        break;    	         	 
    }
        
    $this->MATERIALS = MaterialPeer::getMaterial($this->TIPUS, $this->PAGINA);
    
  }
    
  //**************************************************************************************************************************************************
  //**************************************************************************************************************************************************
    
  public function executeGCursos(sfWebRequest $request)  
  {

	$this->setLayout('gestio');

    $this->CERCA  = $this->ParReqSesForm($request,'cerca',array('text'=>'','select'=>1));
    $this->PAGINA = $this->ParReqSesForm($request,'PAGINA',1);
    $accio  = $this->ParReqSesForm($request,'accio','CA');    
    
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
    $this->getUser()->setAttribute('accio',$accio);
    $this->getUser()->setAttribute('PAGINA',$this->PAGINA);   //Guardem la pÃ gina per si hem fet una consulta nova  
            
    switch($accio){
    	
    	//Entrem un curs nou. Agafarem el codi per fer-ne un duplicat o bÃ© un codi nou.
    	case 'NC':    			    				    			    			
    			$this->getUser()->setAttribute('IDC',null);
    			$OCurs = new Cursos();    			     			
				$this->FCursCodi = new CursosCodiForm($OCurs,array('url'=>$this->getController()->genUrl('gestio/SelectCodiCurs')));
				$this->MODE = 'NOU';
    		break;

		//Si el codi existeix, carrego les dades, altrament nomÃ©s guardo.    		
    	case 'SC':
				$parametres = $request->getParameter('cursos_codi'); 			//Agafo el codi
				$codi = $parametres['Codi'];
				if(!empty($parametres['CodiT'])) $codi = $parametres['CodiT'];				
				$OCurs = CursosPeer::getCopyCursByCodi($parametres['Codi']); 	//Carrego una cÃ²pia de l'objecte de l'Ãºltim curs amb aquest codi
    			$OCurs->save();
    			$this->getUser()->setAttribute('IDC',$OCurs->getIdcursos());    			    		
    		    $this->FCurs = new CursosForm($OCurs);							//Passem al formulari el curs copiat.    		        		        		    
				$this->MODE = 'EDICIO_CONTINGUT';       		    	   		    	     		        		        		        		        			
    		break;    		
    		
    	//Editem un curs que ja existeix. 
    	case 'EC':
    			$OCurs = CursosPeer::retrieveByPK($request->getParameter('IDC'));
    			if($OCurs instanceof Cursos):
    				$this->FCurs = new CursosForm($OCurs);
    				$this->getUser()->setAttribute('IDC',$OCurs->getIdcursos());
    				$this->MODE = 'EDICIO_CONTINGUT';    				    				       	
    			endif; 
    			$this->MODE = 'EDICIO_CONTINGUT';    			
    		break;
    	    		
    	//Guarda el contingut del curs
    	case 'SCC':    			    		        		  
    		    $this->FCurs = new CursosForm(CursosPeer::retrieveByPK($this->getUser()->getAttribute('IDC')));
    		    $this->FCurs->bind($request->getParameter('cursos'));
    		    if($this->FCurs->isValid()):
    		    	$this->FCurs->save();
    		    	$this->getUser()->setAttribute('IDC',$this->FCurs->getObject()->getIdcursos());
    		    else:
    		    	echo "Problema";     		    
    		    endif;    		        		    
    			$this->MODE = 'EDICIO_CONTINGUT';
    		break;
    	//Esborra un curs	
    	case 'D': 
    			$OCurs = CursosPeer::retrieveByPK($this->getUser()->getAttribute('IDC'));
    			if($OCurs instanceof Cursos):
    				$OCurs->delete();    	        	
				endif;
				$this->redirect('gestio/gCursos?accio=CA');
    	    break;
		case 'CI' :	
				$this->CURSOS = CursosPeer::getCursos(CursosPeer::PASSAT , $this->PAGINA , $this->CERCA['text']);
				$this->MODE = 'CONSULTA';				 
			break;		
		case 'CA' :				
				$this->CURSOS = CursosPeer::getCursos(CursosPeer::ACTIU , $this->PAGINA , $this->CERCA['text'] );				
				$this->MODE = 'CONSULTA';
			break;					
		case 'L': 
				$this->MATRICULES = CursosPeer::getMatricules($request->getParameter('IDC'));
				$this->MODE = 'LLISTAT_ALUMNES'; 
			break;
    }           
  }
	 
	
  
  public function executeGReserves(sfWebRequest $request)
  {
  	
    $this->setLayout('gestio');
        
    $this->PAGINA = $this->ParReqSesForm($request,'PAGINA',1);
    $this->CERCA  = $this->ParReqSesForm($request,'cerca',array('text'=>''));
    $this->IDR    = $this->ParReqSesForm($request,'IDR',0);
    
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
	endif;                
	
    switch($accio){
    	case 'N':
    			$OReserva = new Reservaespais();    			
    			$this->FReserva = new ReservaespaisForm($OReserva);    			
    			$this->MODE['NOU'] = true;
    		break;
    	case 'E':    			    			
    			$OReserva = ReservaespaisPeer::retrieveByPK($this->IDR);
				$this->FReserva = new ReservaespaisForm($OReserva);   			
    			$this->MODE['EDICIO'] = true;
    		break;
    	case 'S':    			    		        		  
    		    $this->FReserva = new ReservaespaisForm(ReservaespaisPeer::retrieveByPK($this->IDR));
    		    $this->FReserva->bind($request->getParameter('reservaespais'));    		    
    		    if($this->FReserva->isValid()):
    		    	$this->FReserva->save();
    		    	$this->redirect('gestio/gReserves?accio=NN');
    		    endif;     		        		    
    			$this->MODE['EDICIO'] = true;
    		break;
    	case 'D': 
    	        ReservaespaisPeer::retrieveByPK($this->IDR)->delete();    	        
    	        break;    	         	 
    }
        
    $this->RESERVES = ReservaespaisPeer::getReservesSelect($this->CERCA['text'],$this->PAGINA);    
  		
  }

  /**
   * MatrÃ­cules
   *
   */
   
  
  public function executeGMatricules(sfWebRequest $request)
  {
  
    $this->setLayout('gestio');

    $this->CERCA  = $this->ParReqSesForm($request,'cerca',array('text'=>"",'select'=>2));    
    $this->PAGINA = $this->ParReqSesForm($request,'PAGINA',1);
    $accio  = $this->ParReqSesForm($request,'accio','CA');       
    
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
    
    //Aquest petit bloc Ã©s per si es modifica amb un POST el que s'ha enviat per GET
    $this->getUser()->setAttribute('accio',$accio);
    $this->getUser()->setAttribute('PAGINA',$this->PAGINA);   //Guardem la pÃ gina per si hem fet una consulta nova  
    
    switch($accio){

    	//Crea un usuari nou per poder seguir fent la matrícula
    	case 'ADD_USER':    		

    			$OU = new Usuaris();
    			$OU->setNivellsIdnivells(2);
    			$OU->setHabilitat(true);
    		
    			$this->FUsuari = new UsuarisMatriculesForm($OU);    							    	    		
    			$this->MODE = 'MAT_NOU_USUARI';
    			  	
    		break;
    		
    	//Guarda el nou usuari
    	case 'SAVE_NEW_USER':
    			    			    			
    			$this->FUsuari = new UsuarisMatriculesForm(new Usuaris());    			
    			$this->FUsuari->bind($request->getParameter('usuaris'));
    			if($this->FUsuari->isValid()):
    				$this->FUsuari->save();    			
    				$this->redirect('gestio/gMatricules?accio=NU');
    			endif; 
    			    							    	    		
    			$this->MODE = 'MAT_NOU_USUARI';
    			  	
    		break;
    	
    	
    	case 'NU':
    		
				//Si no és nou, sempre tindrem el número de matrícula. Si és nou, serà  null.     		
    			if($request->hasParameter('IDM')) $this->getUser()->setAttribute('IDM',$request->getParameter('IDM'));
    			else $this->getUser()->setAttribute('IDM',null);
    		
				$OMatricula = MatriculesPeer::retrieveByPk($this->getUser()->getAttribute('IDM'));
    			if(!($OMatricula instanceof Matricules)) $OMatricula = new Matricules();

    			if($request->hasParameter('IDU')) $OMatricula->setUsuarisUsuariid($request->getParameter('IDU'));
    			
    			$this->FMatricula = new MatriculesUsuariForm($OMatricula,array('url'=>$this->getController()->genUrl('gestio/SelectUser')));
    			$this->MODE = 'MAT_USUARI';
  	
    		break;
    		
    	//Comprovem les dades que hem entrat de l'usuari
    	case 'SNU':
    		
    			$OMatricula = MatriculesPeer::retrieveByPk($this->getUser()->getAttribute('IDM'));
    			if(!($OMatricula instanceof Matricules)) $OMatricula = new Matricules();
    			
    			$this->FMatricula = new MatriculesUsuariForm($OMatricula,array('url'=>$this->getController()->genUrl('gestio/SelectUser')));    			
    			$this->FMatricula->bind($request->getParameter('matricules_usuari'));    			
    			if($this->FMatricula->isValid()):
    				$this->FMatricula->save();
    				$this->getUser()->setAttribute('IDM',$this->FMatricula->getObject()->getIdmatricules());
    				$this->redirect('gestio/gMatricules?accio=NC');
    			endif;
    			$this->MODE = 'MAT_USUARI';
    			     			
    		break;
    	
    	//Fem una nova matrícula i escollim el curs al que ens volem matricular
    	case 'NC':
    		
				$this->CURSOS = MatriculesPeer::getCursosMatriculacio();    		    			    			    			
    			$this->MODE = 'NOU';
    			
    		break;

    	//Guardem la matrícula al curs que hem escollit
    	case 'SAVE_CURS':    		
    			$OMatricula = MatriculesPeer::retrieveByPk($this->getUser()->getAttribute('IDM'));    			
    			$OMatricula->setCursosIdcursos($request->getParameter('IDC'));
    			$OMatricula->setDatainscripcio(date('Y-m-d H:m',time()));
    			$Preu = CursosPeer::CalculaPreu($OMatricula->getCursosIdcursos(),$OMatricula->getTreduccio());
    			$OMatricula->setEstat(MatriculesPeer::EN_PROCES);
    			$OMatricula->setPagat($Preu);    			
    			$OMatricula->save();
    			$this->redirect('gestio/gMatricules?accio=FP');
    		break;

    	//Mostra la prematrícula i carreguem les dades del pagament
    	case 'FP':    		
    			$this->MATRICULA = MatriculesPeer::retrieveByPk($this->getUser()->getAttribute('IDM'));
    			    			    			    		     
    		    $PREU = CursosPeer::CalculaTotalPreus(array($this->MATRICULA->getCursosIdcursos()),$this->MATRICULA->getTreduccio());
    		    $NOM  = UsuarisPeer::retrieveByPK($this->MATRICULA->getUsuarisUsuariid())->getNomComplet();
    		    $MATRICULA = $this->MATRICULA->getIdmatricules();
    		    $this->CURS_PLE = CursosPeer::isPle($this->MATRICULA->getCursosIdcursos()); //Passem si el curs es ple
    		    $this->getUser()->setAttribute('isPle',$this->CURS_PLE); //Guardem si el curs Ã©s ple
    			
    			$this->TPV = MatriculesPeer::getTPV($PREU,$NOM,$MATRICULA);    			    			
    			$this->MODE = 'VALIDACIO_CURS';
    		break;
    		    		
    	//Entenem que hem fet un pagament a caixa i mostrem missatge de finalitzaciÃ³.  
    	case 'PAGAMENT':
    			$MATRICULA = MatriculesPeer::retrieveByPK($this->getUser()->getAttribute('IDM'));    			
    			MatriculesPeer::setMatriculaPagada($this->getUser()->getAttribute('IDM'),$this->getUser()->getAttribute('isPle'));
    			$MATRICULA->save();
    			$this->MISSATGE = "La matrícula s'ha realitzat correctament.";
    			$this->MODE = 'PAGAMENT';
    		break;
    	//Si hem fet un pagament amb targeta, anem a la segÃ¼ent pantalla. 
    	case 'OK':
    		 if($this->getRequestParameter('Ds_Response') == '0000'):
                 $matricula = $this->getRequestParameter('Ds_MerchantData');
                 MatriculesPeer::setMatriculaPagada($matricula,$this->getUser()->getAttribute('isPle'));                 
                 $this->MISSATGE = "La matrícula s'ha realitzat correctament.";                 
              else:			            
                 $this->MISSATGE = "Hi ha hagut algun problema realitzant la matrícula. Si us plau torna-ho a intentar.";              
              endif;
              $this->MODE = 'PAGAMENT';
              break;
        //Esborra una matrícula    		    		
    	case 'D':
    			$idM = $this->getUser()->getAttribute('IDM');
    			MatriculesPeer::retrieveByPK($idM)->delete();     	            	       
    	    break;
    	    
   	    //Edita una matrícula
    	case 'E':
    			$this->MATRICULA = MatriculesPeer::retrieveByPk($request->getParameter('IDM'));
    			$this->getUser()->setAttribute('IDM',$request->getParameter('IDM'));
    			$this->FMATRICULA = new MatriculesForm($this->MATRICULA);
    			$this->MODE = 'EDICIO';
    		break;
    		
    	//Guardem una matrícula modificada
    	case 'SAVE_MATRICULA':    			
    			$OMatricula = MatriculesPeer::retrieveByPk($this->getUser()->getAttribute('IDM'));
//    			if(!($OMatricula instanceof Matricules)) $OMatricula = new Matricules();
    			
    			$this->FMATRICULA = new MatriculesForm($OMatricula);    			
    			$this->FMATRICULA->bind($request->getParameter('matricules'));    			
    			if($this->FMATRICULA->isValid()):
    				$this->FMATRICULA->save();    				
    				$this->redirect('gestio/gMatricules?accio=CA');
    			endif;
    			$this->MODE = 'EDICIO';    		
    		break;    	
    			
		case 'CA':					
				$this->ALUMNES = MatriculesPeer::cercaAlumnes($this->CERCA['text'] , $this->PAGINA );
				$this->SELECT = 2;
				$this->MODE = 'CONSULTA';				 
			break;		
		case 'CC':
				$this->CURSOS = MatriculesPeer::cercaCursos($this->CERCA['text'] , $this->PAGINA );
				$this->SELECT = 1;
				$this->MODE = 'CONSULTA';
			break;
		case 'LMA':
				$this->MATRICULES = MatriculesPeer::getMatriculesUsuari($request->getParameter('IDA'));				
				$this->MODE = 'LMATRICULES'; 
			break;
		case 'LMC':
				$this->MATRICULES = MatriculesPeer::getMatriculesCurs($request->getParameter('IDC'));
				$this->MODE = 'LMATRICULES';
			break;		
    }
  	
  
  }
  
  public function GuardaMatricula(sfFormPropel $Matricula)
  {
  	$Matricula->updateObject();
  	$OM = $Matricula->getObject();
  	
  	//Agafem el DNI, busquem el valor que tÃ© l'usuari i guardem la seva matrícula 
  	$OM->setUsuarisUsuariid(UsuarisPeer::cercaDNI($Matricula->getValue('Usuaris_usuariID'))->getUsuariid())->save();
  	
  }
  
        
  public function executeGNoticies(sfWebRequest $request)  
  { 
  	    
    $this->setLayout('gestio');
    $this->PAGINA = $this->ParReqSesForm($request,'PAGINA',1);
	$this->CERCA = $this->ParReqSesForm($request,'text','cerca');
	$this->accio = $this->ParReqSesForm($request,'accio','ca');
	$this->MODE = 'CERCA';
	
	
    if($request->isMethod('POST')){	      	    
	    if($request->hasParameter('BSAVE')) 		$this->accio = 'S';		//Hem entrat una matrícula i passem a la fase de verificaciÃ³
	    elseif($request->hasParameter('BDELETE')) 	$this->accio = 'D';
	    elseif($request->hasParameter('BADD'))		$this->accio = 'N';
	    elseif($request->hasParameter('BEDIT'))		$this->accio = 'E';
    }                    
    
	switch($this->accio){
		case 'N':
			$ONoticia = new Noticies();
			$ONoticia->setDatapublicacio(date('Y-m-d',time()));
			$ONoticia->setDatadesaparicio(date('Y-m-d',time()));
			$this->FORMULARI = new NoticiesForm($ONoticia);
			$this->MODE = 'FORMULARI';
			$this->getUser()->setAttribute('idN',0); 
			break;
		case 'E': 			
			$this->getUser()->setAttribute('idN',$request->getParameter('NOTICIA'));
			$this->FORMULARI = new NoticiesForm(NoticiesPeer::retrieveByPK($this->getUser()->getAttribute('idN')));			
			$this->MODE = 'FORMULARI';			
			break;
		case 'S':

			$idN = $this->getUser()->getAttribute('idN');					
			$this->FORMULARI = new NoticiesForm(NoticiesPeer::retrieveByPK($idN));							
			$this->FORMULARI->bind($request->getParameter('noticies'),$request->getFiles('noticies'));
			
			if($this->FORMULARI->isValid()):

				$this->FORMULARI->save();
				$this->getUser()->setAttribute('idN',$this->FORMULARI->getObject()->getIdnoticia());
				$this->redirect('gestio/gNoticies?accio=CA');
			endif; 
			
			$this->MODE = 'FORMULARI';
						
			break;
		case 'D':
			$ON = NoticiesPeer::retrieveByPk($this->getUser()->getAttribute('idN'));
			if($ON instanceof Noticies) $ON->delete();		
			break;
		case 'UPDATE':			
				NoticiesPeer::migraNoticiesActivitats();
				NoticiesPeer::netejaNoticies();
				$this->getUser()->setAttribute('accio','ca');
//				return sfView::NONE;
			break;
						
	}
             
    $this->NOTICIES = NoticiesPeer::getNoticies("",$this->PAGINA);
          
  }
  
  public function executeGIncidencies(sfWebRequest $request)
  {
     
	$this->setLayout('gestio');
	        
	    $this->PAGINA = $this->ParReqSesForm($request,'PAGINA',1);
	    $this->CERCA = $this->ParReqSesForm($request,'cerca',array('text'=>''));
	    
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
		if($request->hasParameter('BCERCA'))    $accio = 'C';
		if($request->hasParameter('BNOU')) 	    $accio = 'N';
		if($request->hasParameter('BSAVE')) 	$accio = 'S';
		if($request->hasParameter('BDELETE')) 	$accio = 'D';
	endif;                
		
	switch($accio){
	    case 'N':
	    		$OIncidencia = new Incidencies();
	    		$OIncidencia->setDataalta(time());
	    		$OIncidencia->setQuiinforma($this->getUser()->getAttribute('idU'));	    			    		    			    			    	    		
	    		$this->FIncidencia = new IncidenciesForm($OIncidencia);    			
	    		$this->MODE['NOU'] = true;
	    	break;
	    case 'E':    			
	    		$this->getUser()->setAttribute('IDI',$request->getParameter('IDI'));
	    		$OIncidencia = IncidenciesPeer::retrieveByPK($this->getUser()->getAttribute('IDI'));
	    		$this->FIncidencia = new IncidenciesForm($OIncidencia);   			
				$this->MODE['EDICIO'] = true;
			break;
		case 'S':    			    		        		  
			    $this->FIncidencia = new IncidenciesForm(IncidenciesPeer::retrieveByPK($this->getUser()->getAttribute('IDI')));
			    $this->FIncidencia->bind($request->getParameter('incidencies'));
			    if($this->FIncidencia->isValid()):
			    	$this->FIncidencia->save();
			    	$this->redirect('gestio/gIncidencies?accio=C');
			    endif; 
			    $this->MODE['EDICIO'] = true;    		        		        			
			break;
		case 'D': 
		        IncidenciesPeer::retrieveByPK($request->getRequest('IDI'))->delete();    	        
		        break;    	         	 
	}
	
	    
	$this->INCIDENCIES = IncidenciesPeer::getIncidencies($this->CERCA['text'], $this->PAGINA);
  
  }  
    
  public function executeGCessio(sfWebRequest $request)  
  {
    
  	$this->setLayout('gestio');
        
    $this->PAGINA = $this->ParReqSesForm($request,'PAGINA',1);
       		                  
    //Inicialitzem el formulari de cerca
    $this->CERCA = $this->ParReqSesForm($request,'cerca',array('text'=>'','select'=>''));
    $this->FCerca = new CercaTextChoiceForm();       
    $this->FCerca->setChoice(array(1=>'Cedit',0=>'Retornat')); 
	$this->FCerca->bind($this->CERCA);	
	$this->MODE = "";
	$this->ERROR_OCUPAT = "";
	$this->IDC = $this->ParReqSesForm($request,'IDC',0);
		
    
    if($request->isMethod('POST') || $request->isMethod('GET')):
	    $accio = $request->getParameter('accio');
	    if($request->hasParameter('BCERCA'))    		$accio = 'C';
	    if($request->hasParameter('BNOU_CESSIO')) 	    $accio = 'NC';
	    if($request->hasParameter('BESCULL_MATERIAL'))  $accio = 'EM';
	    if($request->hasParameter('B_SAVE_CESSIO'))  	$accio = 'SC';	    	    	    	    	    	    	    
	    if($request->hasParameter('BDELETE_CESSIO')) 	$accio = 'DC';
	    
	    if($request->hasParameter('BSAVE_RETORN'))		$accio = 'SR';
	    
	endif;              
	
	
    switch($accio){
    	
    	//Nova Cessió
    	case 'NC':
    			$OCessio = new Cessio();
    			$OCessio->setRetornat(false);
	    		$OCessio->setEstatRetornat("");
	    		$OCessio->setDataretornat(null);
    			$OCessio->setDatacessio(date('m/d/Y',time()));
    			$OCessio->setDataretorn(date('m/d/Y',time()));
    			$OCessio->setMotiu("la realització d’unes jornades sobre ....");
    			$OCessio->setCondicions("La cessió d'aquest material és gratuït en concepte de col•laboració, que es compromet a restituir-lo en les condicions d'ús que li va ser lliurat un cop hagi finalitzat el període de la instal•lació indicada.");    			    			    	    			
    			$this->FCessio = new CessioForm($OCessio);
    			$this->getUser()->setAttribute('IDC',0);    			
    			$this->MODE = 'NOU_CESSIO';
    		break;
    		
    	//Escull el material
    	case 'EM':
    			//Guardem les primeres dades
    			$RCESSIO = $request->getParameter('cessio');
    			if(!empty($RCESSIO['cessio_id'])):
    				$this->MATERIALOUT = CessiomaterialPeer::getSelectMaterialOut($RCESSIO['cessio_id']); 
    			endif; 
    			$this->getUser()->setAttribute('cessio',$request->getParameter('cessio'));
    			
    			$OCESSIO = CessioPeer::retrieveByPK($RCESSIO['cessio_id']);    			     		
    			if($OCESSIO instanceof Cessio) $this->MAT_NO_INV = $OCESSIO->getMaterialNoInventariat();
    			else $this->MAT_NO_INV = "";
    			    			
    			$this->MODE = 'ESCULL_MATERIAL';
    			    			
    		break;
    		
    	//Edita Cessio
    	case 'EC':    			    			
    			$OCessio = CessioPeer::retrieveByPK($this->IDC);
				$this->FCessio = new CessioForm($OCessio,array('url'=>$this->getController()->genUrl('gestio/SelectCeditA')));				   			
    			$this->MODE = 'EDICIO_CESSIO';
    		break;

    	//Edita Retorn
    	case 'ER':
    		    			    		    
    			$OCessio = CessioPeer::retrieveByPK($this->IDC);
    			
    			$OCessio->setRetornat(true);
    			if(!($OCessio instanceof Cessio)):
    				$OCessio->setEstatRetornat("");
    				$OCessio->setDataretornat(date('Y-m-d',time()));
    			endif; 
    			
				$this->FCessio = new CessiomaterialRetornForm($OCessio,array('url'=>$this->getController()->genUrl('gestio/SelectCeditA')));				   			
				$this->MODE = 'EDICIO_RETORN';
    		break;

    	//Valida el material amb AJAX per saber si estÃ  en Ãºs
    	case 'VM':
    			$RCESSIO = $this->getUser()->getAttribute('cessio');
    			if(HorarisPeer::isMaterialEnUs($request->getParameter('idM'),$RCESSIO['data_cessio'],$RCESSIO['data_retorn'])):
    				return $this->renderText("El material escollit estÃ  en Ãºs");
    			else: 
    				//return $this->renderText("El material escollit estÃ  disponible");
    				return sfView::NONE;
    			endif; 
    		break;
    		
    	//Guarda cessió
    	case 'SC':
    			$ERROR = false; 
				$RCESSIO = $this->getUser()->getAttribute('cessio');
				$RMATERIAL = $request->getParameter('material');
				
    			$OCESSIO = CessioPeer::retrieveByPK($RCESSIO['cessio_id']);    			    			    				    		    			    			    			
    		    $FCESSIO = new CessioForm($OCESSIO);
    		    $FCESSIO->bind($RCESSIO);
    		    $FCESSIO->save();
    		    $IDC = $FCESSIO->getObject()->getCessioid();
    		    
				CessiomaterialPeer::delete($IDC);
    		    
    		    foreach($RMATERIAL as $D => $idM):    		    	
    		    
    		    	$OMC = new Cessiomaterial();
    		    	$OMC->setMaterialIdmaterial($idM);
    		    	$OMC->setCessioId($IDC);
    		    	$OMC->save();
    		     		    
    		    endforeach;
     		    
    		    if($request->hasParameter('material_no_inventariat')):
    		    	$FCESSIO->getObject()->setMaterialNoInventariat($request->getParameter('material_no_inventariat'));
    		    	$FCESSIO->getObject()->save();
    		    endif; 
    		    
    		    $this->MODE = 'FINALITZAT';    		        		        			
    		break;
    		
    	//Esborra cessiÃ³
    	case 'DC': 
    	        CessioPeer::retrieveByPK($this->getUser()->getAttribute('IDC'))->delete();    	        
    	        break;
    	        
    	//Guarda retorn
    	case 'SR':
    		
				$RCESSIO = $request->getParameter('cessio');				
    			$OCESSIO = CessioPeer::retrieveByPK($RCESSIO['cessio_id']);    		
    		    $this->FCessio = new CessiomaterialRetornForm($OCESSIO);
    		    $this->FCessio->bind($RCESSIO);
    		    if($this->FCessio->isValid()): 
    		    	$this->FCessio->save();
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

  
  public function executeGDocuments(sfWebRequest $request)
  {
  
    $this->setLayout('gestio');

    $this->IDD	= $this->ParReqSesForm($request,'IDD',0);    
    $accio  	= $this->ParReqSesForm($request,'accio','GP');
    $this->MODE = 'CERCA';       
    	
    if($request->isMethod('POST')){
	    if($request->hasParameter('B_VEURE_PERMISOS')) 			$accio = 'VP';   
	    elseif($request->hasParameter('B_NOU')) 	    		$accio = 'ND';
	    elseif($request->hasParameter('B_SAVE_NOU'))    		$accio = 'SND';	    
	    elseif($request->hasParameter('B_UPDATE_PERMISOS')) 	$accio = 'SAVE_UPDATE_PERMISOS';	    
	    elseif($request->hasParameter('B_NEW_USER')) 			$accio = 'NUP';
	    elseif($request->hasParameter('B_NOU_USUARI_PERMISOS'))	$accio = 'SAVE_NOU_USUARI_PERMISOS';
	    elseif($request->hasParameter('B_EDITA_DIRECTORI'))		$accio = 'EDITA_DIRECTORI';
	    elseif($request->hasParameter('B_SAVE_EDITA_DIRECTORI'))$accio = 'SAVE_EDITA_DIRECTORI';
	    elseif($request->hasParameter('B_DELETE_DIRECTORI')) 	$accio = 'DELETE_DIRECTORI';
    }                
    
    //Aquest petit bloc Ã©s per si es modifica amb un POST el que s'ha enviat per GET
    $this->getUser()->setAttribute('accio',$accio);      
    
    switch($accio){

    	//Visualitza permisos que tenen els usuaris en el directori
    	case 'VP':    		
			
    		$this->LLISTAT_PERMISOS = AppDocumentsPermisosDirPeer::getLlistatPermisos($this->IDD);    		
    		$this->MODE = "CONSULTA";
  	
    		break;
    		
    	//Crea un directori nou
    	case 'ND':
    			$this->MODE = "NOU";	    			    						  	
    		break;
    		
    	//Guarda un directori nou
    	case 'SND':
    			$NOMDIR = $request->getParameter('NOMDIR');
    			if(!empty($NOMDIR)):
    				AppDocumentsDirectorisPeer::save($NOMDIR, $this->IDD);
    			endif; 
    			$this->MODE = "CONSULTA";	    			    						  	
    		break;
    
    	//Editem un directori
    	case 'EDITA_DIRECTORI':    			    			
    			$OD = AppDocumentsDirectorisPeer::retrieveByPK($this->IDD);
    			$this->FDIRECTORI = new AppDocumentsDirectorisForm($OD);    			    		
    			$this->MODE = "EDITA_DIRECTORI";						  	
    		break;

    	//Editem un directori
    	case 'SAVE_EDITA_DIRECTORI':    			    			
    			$OD = AppDocumentsDirectorisPeer::retrieveByPK($this->IDD);
    			if(!($OD instanceof AppDocumentsDirectoris)) $OD = new AppDocumentsDirectoris();
    			 
    			$this->FDIRECTORI = new AppDocumentsDirectorisForm($OD);
    			$this->FDIRECTORI->bind($request->getParameter('app_documents_directoris'));
    			if($this->FDIRECTORI->isValid()):
    				$this->FDIRECTORI->save();
    				$this->redirect('gestio/gDocuments?accio=VP');
    			endif;     			    		
    			$this->MODE = "EDITA_DIRECTORI";						  	
    		break;
    		
    	//Esborra un directori
    	case 'DELETE_DIRECTORI':    			    			
    			$OD = AppDocumentsDirectorisPeer::retrieveByPK($this->IDD);
    			if($OD instanceof AppDocumentsDirectoris):
    				$OD->delete();
    				$this->redirect('gestio/gDocuments?accio=VP');
    			endif; 

    			$this->FDIRECTORI = new AppDocumentsDirectorisForm($OD);    			
    			$this->MODE = "EDITA_DIRECTORI";						    									  	
    		break;    		
    		
    		
	   	//Actualitza un directori
    	case 'UD':
    			$this->MODE = "NOU";						  	
    		break;

    	//Guarda els nous permisos
    	case 'SAVE_UPDATE_PERMISOS':				
				foreach($request->getParameter('nivell') as $idU=>$idN):					
					AppDocumentsPermisosDirPeer::save($idU,$idN,$this->IDD);
				endforeach;
				$this->redirect('gestio/gDocuments?accio=VP');
    		break;
    		
    	case 'SAVE_NOU_USUARI_PERMISOS':
    		
    		$OP  = $request->getParameter('app_documents_permisos_dir');
    		$OPD = AppDocumentsPermisosDirPeer::retrieveByPK($OP['idUsuari'],$OP['idDirectori']);
    		
    		if(!($OPD instanceof AppDocumentsPermisosDir)) $OPD = new AppDocumentsPermisosDir();
    		
    		$this->FPERMISOS = new AppDocumentsPermisosDirForm($OPD,array('app'=>3,'IDD'=>$this->IDD));
    		$this->FPERMISOS->bind($OP);
    		if($this->FPERMISOS->isValid()):
    			$this->FPERMISOS->save();
    			$this->redirect('gestio/gDocuments?accio=VP');
    		endif;     		
    		$this->MODE = 'NOU_USUARI';    		
    		break;
    		
    	//Afegim un usuari a un directori
    	case 'NUP':    			    			
    			$this->FPERMISOS = new AppDocumentsPermisosDirForm(new AppDocumentsPermisosDir(),array('app'=>3,'IDD'=>$this->IDD));    			
    			$this->MODE = "NOU_USUARI";						  	
    		break;
    		
    	
    }
  	
    $this->LLISTAT_PERMISOS = AppDocumentsPermisosDirPeer::getLlistatPermisos($this->IDD);
    
  }

  
  public function executeGBlogs(sfWebRequest $request)
  {
  
    $this->setLayout('gestio');

    
    //Add,Edit,Delete Multimedia
    //Add,Edit,Delete Page
    //Add,Edit,Delete Entry
    
    //Principal view -> Blogs
    //You Select a blog -> Choice Menus - Pages
    //Edit Page - Menu 
            
    $this->APP_BLOG			= $this->ParReqSesForm($request,'APP_BLOG',-1);
    $this->APP_PAGE			= $this->ParReqSesForm($request,'APP_PAGE',-1);    
    $this->APP_ENTRY		= $this->ParReqSesForm($request,'APP_ENTRY',-1);
    $this->APP_MENU			= $this->ParReqSesForm($request,'APP_MENU',-1);
    $this->APP_MULTIMEDIA	= $this->ParReqSesForm($request,'APP_MULTIMEDIA',-1);
    $this->APP_FORM			= $this->ParReqSesForm($request,'APP_FORM',1);
    $this->APP_FORM_ENTRY   = $this->ParReqSesForm($request,'APP_FORM_ENTRY',0);
            
    $accio  	= $this->ParReqSesForm($request,'accio','GP');
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
    
    $this->getUser()->setAttribute('accio',$accio);      
    
    switch($accio){
    	case 'NEW_MENU':
    			$this->FORM_MENU = AppBlogsMenuPeer::initialize( -1 , $this->APP_BLOG );
    			$this->getUser()->setAttribute('APP_MENU',-1);
    		break;
    	case 'EDIT_MENU':
    			$this->FORM_MENU = AppBlogsMenuPeer::initialize( $this->APP_MENU , $this->APP_BLOG );    			
    		break;      
    	case 'DELETE_MENU':
    			$this->FORM_MENU = AppBlogsMenuPeer::initialize( $this->APP_MENU , $this->APP_BLOG );
    			$this->FORM_MENU->getObject()->delete();
    			$this->redirect('gestio/gBlogs?accio=VIEW_CONTENT');
    		break;
    	case 'SAVE_MENU':    			
    			$this->FORM_MENU = AppBlogsMenuPeer::initialize( $this->APP_MENU , $this->APP_BLOG );
    			$this->FORM_MENU->bind($request->getParameter('app_blogs_menu'));
    			if($this->FORM_MENU->isValid()):
    				try { 
    					$this->FORM_MENU->save();
    					$this->APP_MENU = $this->FORM_MENU->getObject()->getId();
	    				$this->getUser()->setAttribute('APP_MENU',$this->APP_MENU);
	    				$this->redirect('gestio/gBlogs?accio=VIEW_CONTENT');     				
    				} catch (Exception $e) { echo $e->getMessage(); }    					    			    				    
    			endif; 
    		break;
    	case 'NEW_PAGE':
    			$this->FORM_PAGE = AppBlogsPagesPeer::initialize( -1 , $this->APP_BLOG );
    			$this->getUser()->setAttribute('APP_PAGE',-1);
    		break;
    	case 'EDIT_PAGE':
    			$this->FORM_PAGE = AppBlogsPagesPeer::initialize( $this->APP_PAGE , $this->APP_BLOG );
    		break;
    	case 'DELETE_PAGE':
    			try { 
    					$this->FORM_PAGE = AppBlogsPagesPeer::initialize( $this->APP_PAGE , $this->APP_BLOG );
    					$this->FORM_PAGE->getObject()->delete();
    					$this->redirect('gestio/gBlogs?accio=VIEW_CONTENT');    					     				
    				} catch (Exception $e) { echo $e->getMessage(); }
    		break;
    	case 'SAVE_PAGE':
    			$this->FORM_PAGE = AppBlogsPagesPeer::initialize( $this->APP_PAGE , $this->APP_BLOG );    			
    			$this->FORM_PAGE->bind($request->getParameter('app_blogs_pages'));
    			if($this->FORM_PAGE->isValid()):
    				try { 
    					$this->FORM_PAGE->save();
    					$this->APP_PAGE = $this->FORM_PAGE->getObject()->getId();
	    				$this->getUser()->setAttribute('APP_PAGE',$this->APP_PAGE);
	    				$this->redirect('gestio/gBlogs?accio=VIEW_CONTENT');     				
    				} catch (Exception $e) { echo $e->getMessage(); }    					    			    				    
    			endif;     			
    		break;
    	case 'NEW_ENTRY':
    			$this->FORM_ENTRY = AppBlogsEntriesPeer::initialize( $this->APP_ENTRY , 'CA', $this->APP_PAGE );
    			$this->getUser()->setAttribute('APP_ENTRY',-1);
    			$this->GALLERY = array();
    		break;
    	case 'EDIT_ENTRY':
    			$this->FORM_ENTRY = AppBlogsEntriesPeer::initialize( $this->APP_ENTRY , 'CA', $this->APP_PAGE );
    			$this->GALLERY = AppBlogsEntriesPeer::getFiles( $this->APP_ENTRY , 'CA'); 
    		break;
    	case 'DELETE_ENTRY':
    			$this->FORM_ENTRY = AppBlogsEntriesPeer::initialize( $this->APP_ENTRY , 'CA' , $this->APP_PAGE );
    			$this->FORM_ENTRY->getObject()->delete();
    			$this->redirect('gestio/gBlogs?accio=VIEW_CONTENT');
    		break;
    	case 'SAVE_ENTRY':
    			$this->FORM_ENTRY = AppBlogsEntriesPeer::initialize( $this->APP_ENTRY , 'CA', $this->APP_PAGE );    			    			    			
    			$this->FORM_ENTRY->bind($request->getParameter('app_blogs_entries'));    			
    			if($this->FORM_ENTRY->isValid()):
    				try { 
    					$this->FORM_ENTRY->save();    								    							
    					$this->APP_ENTRY = $this->FORM_ENTRY->getObject()->getId();
	    				$this->getUser()->setAttribute('APP_ENTRY',$this->APP_ENTRY);
	    				$this->GUARDA_IMATGES($request->getFiles('arxiu'),$request->getParameter('desc'),$this->APP_ENTRY);
	    				$this->redirect('gestio/gBlogs?accio=VIEW_CONTENT');     				
    				} catch (Exception $e) { echo $e->getMessage(); }    					    			    				    
    			endif;
    			$this->GALLERY = AppBlogsEntriesPeer::getFiles( $this->APP_ENTRY , 'CA');     			    		    			
    		break;
    	case 'NEW_BLOG':
    			$this->FORM_BLOG = AppBlogsBlogsPeer::initialize( $this->APP_BLOG );
    		break;
    	case 'EDIT_BLOG':
    			$this->FORM_BLOG = AppBlogsBlogsPeer::initialize( $this->APP_BLOG );
    		break;      
    	case 'DELETE_BLOG':
    			$this->FORM_BLOG = AppBlogsBlogsPeer::initialize( $this->APP_BLOG );
    			$this->FORM_BLOG->getObject()->delete();
    			$this->redirect('gestio/gBlogs?accio=VIEW_CONTENT');
    		break;    		
    	case 'DELETE_IMAGE':    			
    			AppBlogsMultimediaPeer::deleteMultimeda($this->APP_MULTIMEDIA);     		
    		break;
    	case 'SAVE_BLOG':
    			$this->FORM_BLOG = AppBlogsBlogsPeer::initialize( $this->APP_BLOG );
    			$this->FORM_BLOG->bind($request->getParameter('app_blogs_blogs'));
    			if($this->FORM_BLOG->isValid()):
    				try { 
    					$this->FORM_BLOG->save();
    					$this->APP_BLOG = $this->FORM_BLOG->getObject()->getId();
    					$this->getUser()->setAttribute('APP_BLOG',$this->APP_BLOG);
    					$this->redirect('gestio/gBlogs?accio=VIEW_CONTENT');     				
    				} catch (Exception $e) { echo $e->getMessage(); }
    				    				
    			endif; 
    		break;
    	case 'VIEW_CONTENT':
    			$this->TREE	= AppBlogsMenuPeer::getOptionsMenus( $this->APP_BLOG ,$this->APP_MENU , false );
    			$this->MENUS_ARRAY = AppBlogsMenuPeer::getOptionsMenus( $this->APP_BLOG ,$this->APP_MENU );    			
    			$this->PAGES_ARRAY = AppBlogsPagesPeer::getOptionsPages( $this->APP_BLOG , null , $this->APP_PAGE );
    			$this->ENTRIES_ARRAY = AppBlogsEntriesPeer::getOptionsEntries( $this->APP_PAGE );
    			$this->FORMS_ARRAY = AppBlogsFormsPeer::getOptionsForms( $this->APP_BLOG , $this->APP_FORM );
    		break;
    		
    	case 'AJAX_PAGE':
    			$APP_PAGE = $request->getParameter('APP_PAGE');
    			$HTML = AppBlogsEntriesPeer::getOptionsEntries($APP_PAGE);
    			return $this->renderText($HTML);	
    		break;
    		
    	case 'AJAX_MENU':
    			$APP_MENU = $request->getParameter('APP_MENU');    			
    			$HTML = AppBlogsPagesPeer::getOptionsPages($this->APP_BLOG,$APP_MENU);
    			return $this->renderText($HTML);	
    		break;    		
    		
    	case 'AJAX_ESTAT_FORM':
    			$APP_FORM_ENTRY = $request->getParameter('APP_FORM_ENTRY');
    			$ESTAT    = $request->getParameter('ESTAT');
    			$OO = AppBlogsFormsEntriesPeer::retrieveByPK($APP_FORM_ENTRY);
    			$OO->setEstat($ESTAT);
    			$OO->save();
    			return $this->renderText('Canvi fet correctament');
    		break;
    		
    	case 'AJAX_SAVE_OBJECCIONS':
    			$APP_FORM_ENTRY = $request->getParameter('APP_FORM_ENTRY');    			
    			$OO = AppBlogsFormsEntriesPeer::retrieveByPK($APP_FORM_ENTRY);
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
    			$this->getUser()->setAttribute('APP_BLOG',-1);
    			$this->getUser()->setAttribute('APP_PAGE',-1);
    			$this->getUser()->setAttribute('APP_ENTRY',-1);
    			$this->getUser()->setAttribute('APP_MENU',-1);
    			$this->getUser()->setAttribute('APP_MULTIMEDIA',-1);    			
    		break;

    	case 'VIEW_STADISTICS':

    			//Veure estructura d'arbre
				$this->PAGES_WITHOUT_CONTENT 	= AppBlogsPagesPeer::getPagesWithoutContent($this->APP_BLOG);
				$this->MENUS_WITHOUT_PAGES   	= AppBlogsMenuPeer::getMenusWithoutPages($this->APP_BLOG);
				$this->TREE 					= AppBlogsMenuPeer::getOptionsMenus($this->APP_BLOG,null,false);    			
    		break;

    	case 'VIEW_FORM':

    			//Carrega les dades del formulari
    			$C = new Criteria();
    			$C->add(AppBlogsFormsEntriesPeer::FORM_ID,$this->APP_FORM);
    			$C->addAscendingOrderByColumn(AppBlogsFormsEntriesPeer::ESTAT);
    			//$C->add(AppBlogsFormsEntriesPeer::ESTAT, AppBlogsFormsEntriesPeer::ESTAT_CAP);    			
				$this->VIEW_FORM_ENTRIES = AppBlogsFormsEntriesPeer::getEntries($this->APP_FORM);
				$this->VIEW_FIELDS = AppBlogsFormsEntriesPeer::getFields($this->APP_FORM);
				    			
    		break;
    		    		    		
    }  	
    
    $this->BLOGS_ARRAY = AppBlogsBlogsPeer::getOptionsBlogs($this->APP_BLOG);
       
  }
  
  private function GUARDA_IMATGES($images, $descripcions , $entry_id)
  {
  	
  	foreach($images as $K=>$I):
	
  		if($I['error'] == 0):
  	
	  		$OO = new AppBlogsMultimedia();
	  		$OO->setName($I['name']);  		
	  		$OO->setDate(date('Y-m-d',time()));
	  		$OO->setDesc($descripcions[$K]);
	  		$OO->setUrl('');
	  		$OO->save();
	  		  		
	  		$extensio = $this->file_extension($I['name']);
	  		$nom = $entry_id.'-'.$OO->getId().$extensio; 
	  		
	  		move_uploaded_file($I['tmp_name'], sfConfig::get('sf_websysroot').'images/blogs/'.$nom);
	  		
	  		$OO->setUrl($nom);
	  		$OO->save();
	  		
	  		$OOME = new AppBlogMultimediaEntries();
	  		$OOME->setEntriesId($entry_id);
	  		$OOME->setMultimediaId($OO->getId());
	  		$OOME->save();
	  		
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
    $this->CERCA = $request->getParameter('cerca[text]');    
    
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
                $OM->setUsuarisUsuariid($this->getUser()->getAttribute('idU'));
                $this->FMissatge = new MissatgesForm($OM);
                $this->getUser()->setAttribute('IDM',0);              	                                                
                break;                
      case 'E':
                $this->EDICIO = true;
                $IDM = $request->getParameter('IDM');
                $this->getUser()->setAttribute('IDM',$IDM);
                $OM = MissatgesPeer::retrieveByPK($IDM);
                $this->FMissatge = new MissatgesForm($OM);                
                break;
      case 'S':
      			$IDM = $this->getUser()->getAttribute('IDM');
                $OM = ($IDM > 0)?MissatgesPeer::retrieveByPk($IDM):new Missatges();
                $this->FMissatge = new MissatgesForm($OM);                 
                $this->FMissatge->bind($request->getParameter('missatges'));                
                if ($this->FMissatge->isValid()) { $this->FMissatge->save(); $this->redirect('gestio/gMissatges'); }                              	                                                                                
                $this->EDICIO = true;      
                break;
      case 'D':
      			$this->IDM = $this->getUser()->getAttribute('IDM');                
                $M = MissatgesPeer::retrieveByPK($this->IDM);
                if(!is_null($M)) $M->delete();                
                break;                    
*/  
    }
    
                    
    $this->DVDS = ArxiuDvdPeer::cerca($this->CERCA);
    
  }
    
  //**************************************************************************************************************************************************
  //**************************************************************************************************************************************************
  
  
}
