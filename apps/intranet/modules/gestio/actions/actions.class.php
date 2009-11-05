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
    $this->setLayout('gestio');
    
    $idU = $this->getUser()->getAttribute('idU');    
    
    //Carreguem quantes incidències noves hi ha
    $this->NINCIDENCIES = IncidenciesPeer::QuantesAvui(); 
    //Carreguem quantes matrícules noves hi ha
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
   * RETORNA CORRECTE SI EL DNI TÉ UN FORMAT CORRECTE.
   **/    
  public function ValidaDNI($DNI,$new = true)
  {
  		$DNI = trim($DNI);
  		$correcte = ereg('((^[A-Z]{1}[0-9]{7}[A-Z0-9]{1}$|^[T]{1}[A-Z0-9]{8}$)|^[0-9]{8}[A-Z]{1}$)',$DNI);
  		
  		if($new):
  			$C = new Criteria();
  			$C->add(UsuarisPeer::DNI, $DNI, CRITERIA::EQUAL);
  			$correcte = (UsuarisPeer::doCount($C)==0); //Només serà correcte si no existeix  		
  		endif;

  		return $correcte;
  }
  

  //******************************************************************************************
  // GESTIO DELS USUARIS *********************************************************************
  //******************************************************************************************
  
  public function executeGUsuaris(sfWebRequest $request)
  {    
	
    $this->setLayout('gestio');

    $this->CERCA  = $this->ParReqSesForm($request,'text',"",'cerca');    
    $this->IDU    = $this->ParReqSesForm($request,'IDU');            
    $this->PAGINA = $this->ParReqSesForm($request,'PAGINA',1);
    $accio  = $this->ParReqSesForm($request,'accio','FC');
            
    //Inicialitzem el formulari de cerca
    $this->FCerca = new CercaForm();            
	$this->FCerca->bind(array('text'=>$this->CERCA));
	
	//Inicialitzem variables
	$this->MODE = array('CONSULTA'=>true,'EDICIO'=>false,'NOU'=>false,'LLISTES'=>false,'CURSOS'=>false,'REGISTRES'=>false);    
		
    if($request->hasParameter('BNOU')) 			{ $accio = "N"; }
    if($request->hasParameter('BCERCA')) 		{ $accio = "FC"; $this->PAGINA = 1; }
    if($request->hasParameter('BDESVINCULA')) 	{ $accio = "DL"; }
    if($request->hasParameter('BVINCULA')) 		{ $accio = "VL"; }
    if($request->hasParameter('BSAVE_x'))     	{ $accio = "S"; }
    
    $this->getUser()->setAttribute('accio',$accio);
    $this->getUser()->setAttribute('pagina',$this->PAGINA);        
    
    switch($accio){
       case 'N':
             $this->MODE['NOU'] = true;
             $this->getUser()->setAttribute('FidU',0);                          
             $this->FUsuari = new UsuarisForm();             
             break;
       case 'E':
             $this->MODE['EDICIO'] = true;    
             $USUARI = UsuarisPeer::retrieveByPK($this->IDU);
             $this->FUsuari = new UsuarisForm($USUARI);                          
             break;
       case 'L': 
             $this->USUARI = UsuarisPeer::retrieveByPK($this->IDU);
             $this->LLISTAT_LLISTES = LlistesPeer::getLlistesDisponibles($this->IDU);
             $this->MODE['LLISTES'] = true;
             break;
       case 'C':
             $this->USUARI = UsuarisPeer::retrieveByPK($this->IDU);
             $this->MODE['CURSOS'] = true;
             break; 
       case 'R':
             $this->USUARI = UsuarisPeer::retrieveByPK($this->IDU);
             $this->MODE['REGISTRES'] = true;
             break;
       case 'S':       	
       		 $OUsuari = UsuarisPeer::retrieveByPk($this->IDU);
       		 if($OUsuari instanceof Usuaris) $this->FUsuari = new UsuarisForm($OUsuari); 
       		 else $this->FUsuari = new UsuarisForm();
       		        		  
             $this->FUsuari->bind($request->getParameter('usuaris'));             
		     if($this->FUsuari->isValid()) $this->FUsuari->save();		     
		     $this->MODE['EDICIO'] = true;      
		     
             break;       
       case 'DL':   //Desvincula una llista de correu
             $D = $request->getParameter('D');
             foreach($D['IDL'] as $IDL) LlistesPeer::desvincula($this->IDU,$IDL);
             $this->redirect("gestio/gUsuaris?accio=L");                            
             break;
       case 'VL':   //Vincula a una llista de correu
             $D = $request->getParameter('D');
             foreach($D['IDL'] as $IDL) LlistesPeer::vincula($this->IDU,$IDL);
             $this->redirect("gestio/gUsuaris?accio=L");                            
             break;              
    }

    $this->PAGER_USUARIS = UsuarisPeer::cercaTotsCamps( $this->CERCA , $this->PAGINA );
                    
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
    elseif($request->getParameter('accio')=='D'): //Esborra
      $this->PROMOCIO = PromocionsPeer::retrieveByPK($request->getParameter('IDP'));
      $this->PROMOCIO->delete();      
    endif;
    
    if($request->hasParameter('BSAVE_x')):
      $IDP = $this->getUser()->getAttribute('idP');
      if($IDP == 0) $OPromocio = new Promocions();
      else $OPromocio = PromocionsPeer::retrieveByPK($IDP);
      $this->FPromocio = new PromocionsForm($OPromocio);
      $this->FPromocio->bind($request->getParameter('promocions'),$request->getFiles('promocions'));
      
      if($this->FPromocio->isValid()) { try { $this->FPromocio->save(); } catch (Exception $e) { echo $e->getMessage(); } }
      else echo "merda";
         
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
			$contents = "No s'ha trobat la pàgina.";
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
    
    if($request->hasParameter('BSAVE_x')):
      $IDN = $this->getUser()->getAttribute('idN');
      $ONode = NodesPeer::retrieveByPK($IDN);
      if($IDN > 0) $this->FNode = new NodesForm($ONode);
      else $this->FNode = new NodesForm();      
            
      $this->FNode->bind($request->getParameter('nodes'));
      if($this->FNode->isValid()) $this->FNode->save();             
      $this->EDICIO = true;                
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

    $this->NODES = NodesPeer::retornaMenu();
    
  }  
      
  //******************************************************************************************
  // GESTIO DE LES LLISTES *******************************************************************
  //******************************************************************************************
  
  public function executeGLlistes(sfWebRequest $request)
  {
    $this->setLayout('gestio');

    $this->IDL    = $this->ParReqSesForm($request,'IDL');    
    $this->PAGINA = $request->getParameter('PAGINA');
    
    //Inicialitzem variables
	$this->MODE = array('CONSULTA'=>true,'EDICIO'=>false,'NOU'=>false,'LLISTAT'=>false,'ENVIAT'=>FALSE,'MISSATGES'=>false,'USUARIS'=>false);    
    
    $accio = $request->getParameter('accio');
    if($request->hasParameter('BCERCA')) $accio = 'U';
    if($request->hasParameter('BSAVE_LLISTA_x')) $accio = 'S';
    if($request->hasParameter('BSAVE_MISSATGE_x')) $accio = 'SM';
    if($request->hasParameter('BSEND')) $accio = 'SEND';
    if($request->hasParameter('BVINCULA')) $accio = 'VINCULA';
    if($request->hasParameter('BDESVINCULA')) $accio = 'DESVINCULA';            
    
    switch($accio)
    {
      case 'N':      			
      			$this->FLlista = new LlistesForm();
      			$this->getUser()->setAttribute('idL',0);                 
                $this->MODE['NOU'] = true;
                break;
      case 'E': 
                $OLlista = LlistesPeer::retrieveByPK($request->getParameter('IDL'));
                $this->getUser()->setAttribute('idL',$OLlista->getIdllistes());
                $this->FLlista = new LlistesForm($OLlista);                
                $this->MODE['EDICIO'] = true; 
                break;                      
      case 'VINCULA':               
               $ALTA_USUARIS = $request->getParameter('ALTA_USUARI');
               foreach($ALTA_USUARIS as $U) UsuarisllistesPeer::Vincula($U,$this->IDL);                             
            break;
      case 'DESVINCULA':                              
               $BAIXA_USUARIS = $request->getParameter('BAIXA_USUARI');               
               foreach($BAIXA_USUARIS as $U) UsuarisllistesPeer::Desvincula($U,$this->IDL);               
            break;
      case 'M':
      			$OMissatge = MissatgesllistesPeer::retrieveByPK($request->getParameter('IDM'));
      			if($OMissatge instanceof Missatgesllistes) $this->FMissatge = new MissatgesllistesForm($OMissatge);
      			else $this->FMissatge = new MissatgesllistesForm();      			      			       			                               
                $this->MODE['MISSATGES'] = true;
                break;
      case 'MV':                               
                $this->LLISTA_MISSATGES = LlistesPeer::getMissatges($this->IDL , LlistesPeer::TOTS,$this->PAGINA3);         
                $this->MISSATGE = MissatgesllistesPeer::retrieveByPK($this->getRequestParameter('IDM'));                
                $this->MODE['MISSATGES'] = true;        
                break;                
      case 'S': 
                $IDL = $this->getUser()->getAttribute('idL');
                $OLlista = LlistesPeer::retrieveByPK($IDL);
                if($OLlista instanceof Llistes) $this->FLlista = new LlistesForm($OLlista);
                else $this->FLlista = new LlistesForm();                
                $this->FLlista->bind($request->getParameter('llistes'));
                if($this->FLlista->isValid()) $this->FLlista->save();
                $this->MODE['EDICIO'] = true;                
                break; 
      case 'SM':      	         	        
                $OMissatgeLlista = MissatgesllistesPeer::retrieveByPK($request->getParameter('IDM'));
                if($OMissatgeLlista instanceof Missatgesllistes) $this->FMissatge = new MissatgesllistesForm($OMissatgeLlista);
                else $this->FMissatge = new MissatgesllistesForm();

                $ML = $request->getParameter('missatgesllistes');
                $ML['Date'] = time();
                $ML['Enviat'] = null;
                $ML['Llistes_idLlistes'] = $this->getUser()->getAttribute('idL');

                $this->FMissatge->bind($ML);
                if($this->FMissatge->isValid()) $this->FMissatge->save();
                $this->MODE['MISSATGES'] = true;                
                break;                 
      case 'L': 
               $IDL = $this->getRequestParameter('IDL');
               $this->LLISTA = LlistesPeer::retrieveByPK($IDL);
               $this->LMISSATGES = $this->LLISTA->getMissatgesllistess();               
               $this->MODE['LLISTAT'] = true;
               break;
      case 'SEND':               
               $this->MAILS = LlistesPeer::EnviaMissatge($this->getRequestParameter('IDM'));
               $this->ENVIAT = true;                               
               break;
      case 'U_EMAIL':
      		
      		break;
               
	  //Imprimeix etiquetes               
      case 'P': 
      		return $this->printEtiquetes($this->IDL);     	
      		break;
    
    }        
  

    //Inicialitzem els valors comuns
	$this->LLISTES = LlistesPeer::doSelect(new Criteria());
    
    if($accio == 'U' || $accio == 'VINCULA' || $accio == 'DESVINCULA'):
        	    
	    $this->CERCA  = $this->ParReqSesForm($request,'cerca',array(''));
	    $this->getUser()->setAttribute('cerca',array());
	    $this->FCerca = new CercaTextChoiceForm();
	    $this->FCerca->bind($this->CERCA);
	    $this->FCerca->setChoice(array('llista'=>'Usuaris pertanyents','nollista'=>'Usuaris no pertanyents'));
	    $this->CERCA = $this->FCerca->getValue('text');
	            
    	if($this->FCerca->getValue('select') == 'llista'):
    		$this->USUARIS_LLISTA = UsuarisllistesPeer::getUsuarisLlista( $this->CERCA ,  $this->IDL , $this->PAGINA );
    		$this->LLISTA = true;
    	else:
         	$this->USUARIS_DISPONIBLES = UsuarisllistesPeer::getUsuarisNoLlista( $this->CERCA , $this->IDL , $this->PAGINA );
         	$this->LLISTA = false;
    	endif;
    	
    	$this->MODE['USUARIS'] = true;
    	                
    endif;
  
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
          $ERRORS[] = 'El DNI '.$D.' és incorrecte.';
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

    $this->FCerca = new CercaChoiceForm();
    $this->FCerca->setChoice(array(1=>'Tasques d\'avui',2=>'Tasques de la setmana',3=>'Tasques del mes'));
	$this->FCerca->bind($request->getParameter('cerca'));
	$this->CERCA = $this->FCerca->getValue('cerca[text]');
    
    $this->NOU = false; 
    $this->EDICIO = false; 
    $this->CERCA = "";
    $accio = "";    

    if($request->hasParameter('PAGINA'))  $this->PAGINA = $request->getParameter('PAGINA');
    else $this->PAGINA = 1;
    
        
    if($request->isMethod('POST') || $request->isMethod('GET')):
    
    	$accio = $request->getParameter('accio');
	    if($request->getParameter('BNOU'))		$accio = "N";    
	    if($request->getParameter('BSAVE_x')) 	$accio = 'S';               

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
  
  public function executeGActivitats(sfWebRequest $request)
  {

  	//$this->netejaParametresSessio();
  	
    $this->setLayout('gestio');

    $this->CERCA  	= $this->ParReqSesForm($request,'text',"",'cerca');
    $this->PAGINA 	= $this->ParReqSesForm($request,'PAGINA',1);
    $this->DATAI  	= $this->ParReqSesForm($request,'DATAI',time());    
    $this->DIA    	= $this->ParReqSesForm($request,'DIA',time());
    $this->IDA    	= $this->ParReqSesForm($request,'IDA',0);        
    $accio  		= $this->ParReqSesForm($request,'accio','C');
    $this->ACTIVITAT_NOVA = false;    
    
    //Inicialitzem el formulari de cerca
    $this->FCerca = new CercaForm();            
	$this->FCerca->bind(array('text'=>$this->CERCA));
	
	//Inicialitzem variables
	$this->MODE = array('CONSULTA'=>false,'NOU'=>false,'EDICIO'=>false,'LLISTAT'=>false,'CICLES'=>FALSE,'TEXTOS'=>FALSE,'HORARIS'=>FALSE);

    if($request->isMethod('POST')){
	    if($request->hasParameter('BCERCA')) { $accio = 'C'; $this->PAGINA = 1; }   
	    elseif($request->hasParameter('BNOU')) 	    $accio = 'NA';
	    elseif($request->hasParameter('BSAVE')) 	$accio = 'S';
	    elseif($request->hasParameter('BDELETE')) 	$accio = 'D';
	    elseif($request->hasParameter('BSAVEACTIVITAT')) $accio = 'SA';
	    elseif($request->hasParameter('BSAVEHORARIS_x')) $accio = 'SH';
	    elseif($request->hasParameter('BDELETEHORARIS')) $accio = 'DH';
	    elseif($request->hasParameter('BSAVEDESCRIPCIO_x')) $accio = 'ST';
	    elseif($request->hasParameter('BSAVECICLE')) $accio = 'SC';
    }                
    
    //Quan cliquem per primer cop a qualsevol de les cerques, la pàgina es posa a 1
    if($request->getParameter('accio') == 'C') $this->PAGINA = 1;
    if($request->getParameter('accio') == 'CD') { $this->PAGINA = 1; }    
    if($request->hasParameter('DATAI')) { $this->DIA = ""; } 
    
    //Aquest petit bloc és per si es modifica amb un POST el que s'ha enviat per GET
    $this->getUser()->setAttribute('accio',$accio);    
    $this->getUser()->setAttribute('PAGINA',$this->PAGINA);   //Guardem la pàgina per si hem fet una consulta nova
    $this->getUser()->setAttribute('DATAI',$this->DATAI);  
    $this->DATAF = mktime(0,0,0,date('m',$this->DATAI)+3,date('d',$this->DATAI),date('Y',$this->DATAI));  //La data final sempre és 3 mesos superior a la inicial    
   
    switch($accio){
    	
    	//Consulta inicial del calendari sense prèmer cap dia, només amb un factor de cerca
    	case 'C':
                $HORARIS = HorarisPeer::getActivitats(null,$this->CERCA,$this->DATAI,$this->DATAF,null);
                $this->ACTIVITATS = $HORARIS['ACTIVITATS'];                                                                
                $this->CALENDARI = $HORARIS['CALENDARI'];
                $this->MODE['CONSULTA'] = true;
                $this->MODE['LLISTAT'] = true;                                              
                break;
    		break;

    	//Consulta que em mostra les activitats quan canvio de mensualitat o any 
    	case 'CC':    		
                $HORARIS = HorarisPeer::getActivitats(null , $this->CERCA, $this->DATAI, $this->DATAF, null);
                $this->ACTIVITATS = $HORARIS['ACTIVITATS'];                
                $this->CALENDARI = $HORARIS['CALENDARI'];
                $this->MODE['CONSULTA'] = true;
                $this->MODE['LLISTAT'] = true;
    		break;
    		
    		
    	//Consulta que em mostra les activitats d'un dia seleccionat del calendari
    	case 'CD':    		
                $HORARIS = HorarisPeer::getActivitats($this->DIA , $this->CERCA, $this->DATAI, $this->DATAF, null);
                $this->ACTIVITATS = $HORARIS['ACTIVITATS'];                
                $this->CALENDARI = $HORARIS['CALENDARI'];
                $this->MODE['CONSULTA'] = true;
                $this->MODE['LLISTAT'] = true;
    		break;
    		
    	//Consulta una activitat
    	case 'CA':    			
    			$OActivitat = ActivitatsPeer::retrieveByPK($this->IDA);    			
    			$this->FActivitat = new ActivitatsForm($OActivitat);
    			$this->getUser()->setAttribute('IDA',$this->IDA);
    			$this->MODE['EDICIO'] = true;
    		break;

    	//Consulta els horaris
    	case 'CH':
    			$OActivitat = ActivitatsPeer::retrieveByPK($this->getUser()->getAttribute('IDA'));    			
    			$this->HORARIS = $OActivitat->getHorariss();
    			$this->MODE['HORARIS'] = true;
    			    			
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
    		break;    	
    		
    	//Consulta els textos del web
    	case 'T':                
                $OActivitat = ActivitatsPeer::retrieveByPK($this->getUser()->getAttribute('IDA'));
                $this->FActivitat = new ActivitatsTextosForm($OActivitat);                
                $this->MODE['TEXTOS'] = TRUE;       
            break;
            
		//Guarda els textos del web            
    	case 'ST':
    			$OActivitat = ActivitatsPeer::retrieveByPK($this->getUser()->getAttribute('IDA'));
    			$this->FActivitat = new ActivitatsTextosForm($OActivitat);    			
    			$this->FActivitat->bind($request->getParameter('activitats'),$request->getFiles('activitats'));
    			if($this->FActivitat->isValid()) $this->FActivitat->save();
    			$this->MODE['TEXTOS'] = true;
    		break;
    		
    	//Save Horaris
    	case 'SH':  		
			
			$OActivitat = ActivitatsPeer::retrieveByPK($this->getUser()->getAttribute('IDA'));    			
    		$this->HORARIS = $OActivitat->getHorariss();
    		
    		$idH = $this->getUser()->getAttribute('IDH');
    		$OHorari = HorarisPeer::retrieveByPK($idH);
    		if($idH == 0 ) $this->FHorari = new HorarisForm();
    		else   		   $this->FHorari = new HorarisForm($OHorari);

    		$this->MATERIALOUT = array();
    		$material = $request->getParameter('material');
    		if(!is_array($material)) $material = array();    		
    		foreach($material as $M=>$idM):
    			$OMaterial = MaterialPeer::retrieveByPK($idM);    			    			
    			$this->MATERIALOUT[] = array('material'=>$idM,'generic'=>$OMaterial->getMaterialgenericIdmaterialgeneric());    			    		
    		endforeach;    		    		    		
			$espais = $request->getParameter('espais');
    		if(!is_array($espais)) $espais = array();  
    		$this->ESPAISOUT   = $espais;     		    		    		
    		
    		$this->FHorari->bind($request->getParameter('horaris'));
    		$RET = $this->GuardaHorari($request->getParameter('horaris'),$request->getParameter('material'),$this->ESPAISOUT);    		   			
   			if(empty($RET)) $this->MISSATGE = array(1=>"Horari guardat correctament");
   			else 			$this->MISSATGE = $RET;    		

    		$this->MODE['HORARIS'] = true;   			
   			
    		break;

		//Gestiona una nova activitat    		
    	case 'NA':    			
    			$OActivitat = new Activitats();    			
    			$this->FActivitat = new ActivitatsForm($OActivitat);    			
    			$this->MODE['NOU'] = true;
    			$this->ACTIVITAT_NOVA = true;
    			$this->getUser()->setAttribute('IDA',0);
    		break;

    	//Guarda una activitat
    	case 'SA':
    		
    			$idA = $this->getUser()->getAttribute('IDA');
    			if($idA == 0) $OActivitat = new Activitats();
    			else $OActivitat = ActivitatsPeer::retrieveByPK($idA); 
    			
				$this->FActivitat = new ActivitatsForm($OActivitat);
				$this->FActivitat->bind($request->getParameter('activitats'));
				
				if($this->FActivitat->isValid()) $this->FActivitat->save();

				$OActivitat = $this->FActivitat->getObject();
				$this->getUser()->setAttribute('IDA',$OActivitat->getActivitatid());
				
    			$this->MODE['EDICIO'] = true;
    		
    		break;

    	//Visualitzem els cicles	    		
		case 'AC' :								
				$this->LLISTA_CICLES = CiclesPeer::getCiclesActius();				
				$this->MODE['CICLES'] = true;
			break;					        
		case 'DC':
				$OCicles = CiclesPeer::retrieveByPK($request->getParameter('idC'));
				$OCicles->setBaixa(true);
				$OCicles->save();				
				$this->LLISTA_CICLES = CiclesPeer::getCiclesActius();				
				$this->MODE['CICLES'] = true;
			break;
		case 'SC':
				$OCicles = new Cicles();
				$OCicles->setNew(true);
				$OCicles->setNom($request->getParameter('NOM'));
				$OCicles->setDescripcio($request->getParameter('DESCRIPCIO'));
				$OCicles->setBaixa(0);
				$OCicles->save();
				$this->LLISTA_CICLES = CiclesPeer::getCiclesActius();				
				$this->MODE['CICLES'] = true;
			break;
    }
  
  }  
  
  public function saveCicle()
  {
     $C = new Cicles();
     $C->setNew(true);
     $NOM = $this->getRequestParameter('NOM');
     if(!empty($NOM)):
	     $C->setNom($NOM);
	     $C->setDescripcio($this->getRequestParameter('DESCRIPCIO'));
	     $C->save();
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
  	  		if(!($any > 2000 && $mes < 13 && $dia < 31 )) $ERRORS[] = "La data que has entrat és incorrecta";
  			$DBDD['DIES'][] = "$any-$mes-$dia";  		  		
  		endforeach;  	     		
	endif;  	
  	  	        
  	$DBDD['HoraPre']  = $horaris['HoraPre']['hour'].':'.$horaris['HoraPre']['minute'];
  	$DBDD['HoraIn']   = $horaris['HoraInici']['hour'].':'.$horaris['HoraInici']['minute'];
  	$DBDD['HoraFi']   = $horaris['HoraFi']['hour'].':'.$horaris['HoraFi']['minute'];
  	$DBDD['HoraPost'] = $horaris['HoraPost']['hour'].':'.$horaris['HoraPost']['minute'];
  			              
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
			
	    	if(!is_array($material)) $material = array();
	    	foreach($material as $M=>$idM):
	    		if( HorarisPeer::validaMaterial( $D , $idE , $idM , $DBDD['HoraPre'] , $DBDD['HoraPost'] , $horaris['HorarisID']) > 0 ):
	    			$Espai = EspaisPeer::retrieveByPK($idE)->getNom();
	    			$Mater = MaterialPeer::retrieveByPK($idM)->getNom();
	    			$ERRORS[] = "El material $Mater de l'aula $Espai està reservat el dia $D";
    			endif;
	    	
	    	endforeach;     	
    	endforeach;
        	    	
    endforeach;
       
    //Si no hem trobat cap error, guardem els registres d'ocupació. 
    if(empty($ERRORS)):

 		HorarisPeer::save( $horaris , $DBDD , $material , $espais );
       
    endif;
  
    return $ERRORS;
     
  }
  
  public function GuardaText($idA)
  {

    $A = ActivitatsPeer::retrieveByPK($idA);
            
    $A->setTnoticia($this->getRequestParameter('TITOL_NOTICIA'));                
    $A->setDnoticia($this->getRequestParameter('TEXT_NOTICIA'));    
    $A->setTweb($this->getRequestParameter('TITOL_WEB'));
    $A->setDweb($this->getRequestParameter('TEXT_WEB'));    
    $A->setTgeneral($this->getRequestParameter('TITOL_GENERAL'));
    $A->setDgeneral($this->getRequestParameter('TEXT_GENERAL'));            
    $A->setPublicaweb($this->hasRequestParameter('PUBLICA'));
            
    $aFiles = $this->getRequest()->getFiles();                                  
    if(strlen($aFiles['IMATGE']['name']) > 5):    	
		$fileName = $idA.'I.'.self::findexts($aFiles['IMATGE']['name']);		//Codi d'activitat+I+.+ext (1I.png) 
    	$this->getRequest()->moveFile('IMATGE', sfConfig::get('sf_web_dir').'/images/noticies/'.$fileName);
    	$A->setImatge($fileName);
    endif;

    if(strlen($aFiles['PDF']['name']) > 5):    	
		$fileName = $idA.'P.'.self::findexts($aFiles['PDF']['name']);		//Codi d'activitat+P+.+ext (1I.png) 
    	$this->getRequest()->moveFile('PDF', sfConfig::get('sf_web_dir').'/images/noticies/'.$fileName);
    	$A->setPdf($fileName);
    endif;        
    
    $A->save();
    
    return $A;
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
	if(!empty($this->CERCA_ESPAI)):    
	    for($i=0;$i<32;$i++) $this->DIES[$i] = $i;
	    $this->MESOS = array('1'=>'Gener','2'=>'Febrer','3'=>'Març','4'=>'Abril','5'=>'Maig','6'=>'Juny','7'=>'Juliol','8'=>'Agost','9'=>'Setembre','10'=>'Octubre','11'=>'Novembre','12'=>'Desembre');
	    $this->DADES_MESOS_DIES = HorarisPeer::getMesosDiesEspai($this->CERCA_ANY,$this->CERCA_ESPAI);	    
    else:
       //Consulta l'ocupació d'espais per mesos        
	    $this->ESPAIS = EspaisPeer::select();
	    $this->MESOS = array('1'=>'Gener','2'=>'Febrer','3'=>'Març','4'=>'Abril','5'=>'Maig','6'=>'Juny','7'=>'Juliol','8'=>'Agost','9'=>'Setembre','10'=>'Octubre','11'=>'Novembre','12'=>'Desembre');
	    $this->DADES_MESOS_ESPAIS = HorarisPeer::getMesosEspais($this->CERCA_ANY);    
	endif;
      
  }
  

  //**************************************************************************************************************************************************
  //**************************************************************************************************************************************************
  
  public function executeagendaAC(){
     $CERCA = $this->getRequestParameter('CERCA');    
     $this->AGENDA = AgendatelefonicadadesPeer::doSearch( $CERCA );
 
  }
  
  public function executeGAgenda($request)  
  {  		  	
  	$this->setLayout('gestio');

  	//Inicialitzem les variables
  	$this->MODE = array( 'CONSULTA' => true , 'NOU' => false , 'EDICIO' => false );           	
  	$this->accio = NULL; $this->AID = 0;
    $this->AGENDA = new Agendatelefonica(); $this->AGENDES = array();
  	
  	//Tractem el formulari de cerca
  	$this->FCerca = new CercaForm();
  	$this->CERCA = $request->getParameter('cerca[text]');  	
  	$this->FCerca->bind($request->getParameter($this->FCerca->getName()));
    
    //Carreguem l'acció que s'hagi fet 
  	$accio = $request->getParameter('accio');
        
  	//Definim l'acció segons el botó premut  	
    if( $this->getRequest()->hasParameter('BNOU') ) $accio = 'N';
    if( $this->getRequest()->hasParameter('BSAVE_x') ) $accio = 'S';    

    switch( $accio )
    {
      case 'N':
                $this->MODE['NOU'] = true;
                $this->getUser()->setFlash('AID',0);
                $this->FAgenda = new AgendatelefonicaForm();                          
                break;                
      case 'E':
                $this->MODE['EDICIO'] = true;
                $AID = $request->getParameter('AID');
                $this->getUser()->setAttribute('AID',$AID);                                
                $OAT = AgendatelefonicaPeer::retrieveByPK($AID);
                $this->FAgenda = new AgendatelefonicaForm($OAT);                                
                break;
      case 'S':      			
      			$AID = $this->getUser()->getAttribute('AID');      			      		
      			if($AID > 0):
      				$this->FAgenda = new AgendatelefonicaForm(AgendatelefonicaPeer::retrieveByPK($AID));
      			else:
      				$this->FAgenda = new AgendatelefonicaForm(new Agendatelefonica());
      			endif;

      			$this->FAgenda->bind($request->getParameter('agendatelefonica'));
				$this->FAgenda->save();
				$this->MISSATGE = "El registre s'ha modificat correctament.";      			      															                
                $this->MODE['EDICIO'] = true;      
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
       $this->AGENDES = AgendatelefonicadadesPeer::doSearch( $this->CERCA );
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
	    if( $request->hasParameter('BSAVE_x') ) 		$accio = 'S';
	    
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
    
  public function ParReqSesForm(sfWebRequest $request, $nomCamp, $default = "",  $formulari = null) 
  {

  	$RET = ""; 	    	
  	
  	//Recuperem el nom del camp tant si és dins un formulari com si és fora. 
  	if(!is_null($formulari)) $PAR = $formulari.'['.$nomCamp.']';
  	else $PAR = $nomCamp;
    	
  	//Si existeix el paràmetre carreguem el nom actual
  	if($request->hasParameter($PAR)):
  	
  		$CAMP = $request->getParameter($PAR);
  		$this->getUser()->setAttribute($nomCamp,$CAMP);
  		$RET = $CAMP;
  
  	//Si no existeix el paràmetre mirem si ja el tenim a la sessió
  	elseif($this->getUser()->hasAttribute($nomCamp)):
  		
  		$RET = $this->getUser()->getAttribute($nomCamp);
  		
  	//Si no el tenim a la sessió i tampoc l'hem passat per paràmetre carreguem el valor per defecte. 
  	else: 
  	
  		$this->getUser()->setAttribute($nomCamp, $default);
  		$RET = $default;

  	
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
   * Gestió de l'inventari i del material
   * In:  PAGINA , TIPUS, BCERCA, BNOU, BSAVE, BDELETE, IDM , D
   * Out: MATERIAL , MATERIALS , IDM 
   * 
   */
  
  public function executeGMaterial(sfWebRequest $request)  
  {
    
    $this->setLayout('gestio');    
        
    $this->PAGINA = $this->ParReqSesForm($request,'PAGINA',1);
    $this->TIPUS = $this->ParReqSesForm($request,'text',1,'cerca');
    
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
	    if($request->hasParameter('BSAVE_x')) 	$accio = 'S';	    
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
    		    if($this->FMaterial->isValid()) $this->FMaterial->save();    		        		    
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

    $this->CERCA  = $this->ParReqSesForm($request,'text',"",'cerca');
    $this->SELECT = $this->ParReqSesForm($request,'select',1,'cerca');
    $this->PAGINA = $this->ParReqSesForm($request,'PAGINA',1);
    $accio  = $this->ParReqSesForm($request,'accio','CA');    
    
    //Inicialitzem el formulari de cerca
    $this->FCerca = new CercaTextChoiceForm();       
    $this->FCerca->setChoice(array(1=>'Actius',2=>'Inactius')); 
	$this->FCerca->bind(array('text'=>$this->CERCA,'select'=>$this->SELECT));
	
	//Inicialitzem variables
	$this->MODE = array('CONSULTA'=>true,'NOU'=>false,'EDICIO'=>false,'LLISTAT_ALUMNES'=>false);

    if($request->isMethod('POST')){
	    if($request->hasParameter('BCERCA')) { $accio = ( $this->SELECT == 1 )?'CA':'CI'; $this->PAGINA = 1; }   
	    elseif($request->hasParameter('BNOU')) 	    $accio = 'NC';
	    elseif($request->hasParameter('BSAVE_x')) 	$accio = 'S';	    
    }                
    
    //Aquest petit bloc és per si es modifica amb un POST el que s'ha enviat per GET
    $this->getUser()->setAttribute('accio',$accio);
    $this->getUser()->setAttribute('PAGINA',$this->PAGINA);   //Guardem la pàgina per si hem fet una consulta nova  
    
    switch($accio){
    	case 'NC':    			
    			$OCurs = new Cursos();    			
    			$this->FCurs = new CursosForm($OCurs);    			
    			$this->MODE['NOU'] = true;
    		break;
    	case 'E':    			
    			$this->getUser()->setAttribute('IDC',$request->getParameter('IDC'));
    			$OCurs = CursosPeer::retrieveByPK($this->getUser()->getAttribute('IDC'));
				$this->FCurs = new CursosForm($OCurs);   			
    			$this->MODE['EDICIO'] = true;
    		break;
    	case 'S':    			    		        		  
    		    $this->FCurs = new CursosForm(CursosPeer::retrieveByPK($this->getUser()->getAttribute('IDC')));
    		    $this->FCurs->bind($request->getParameter('cursos'));
    		    if($this->FCurs->isValid()) $this->FCurs->save();    		        		    
    			$this->MODE['EDICIO'] = true;
    		break;
    	case 'D': 
    	        CursosPeer::retrieveByPK($this->getUser()->getAttribute('IDC'))->delete();
				$this->CURSOS = CursosPeer::getCursos(CursosPeer::ACTIU , $this->PAGINA );
				$this->MODE['CONSULTA'] = true;				     	            	          	        
    	    break;
		case 'CI' :	
				$this->CURSOS = CursosPeer::getCursos(CursosPeer::PASSAT , $this->PAGINA , $this->CERCA);
				$this->MODE['CONSULTA'] = true;				 
			break;		
		case 'CA' :
				$this->CURSOS = CursosPeer::getCursos(CursosPeer::ACTIU , $this->PAGINA , $this->CERCA );
				$this->MODE['CONSULTA'] = true;
			break;					
		case 'L': 
				$this->MATRICULES = CursosPeer::getMatricules($request->getParameter('IDC'));
				$this->MODE['LLISTAT_ALUMNES'] = true; 
			break;
    }
        
  }
	 
	
  
  public function executeGReserves(sfWebRequest $request)
  {
  	
    $this->setLayout('gestio');
        
    $this->PAGINA = $this->ParReqSesForm($request,'PAGINA',1);
    $this->CERCA = $this->ParReqSesForm($request,'text',1,'cerca');
    
    //Inicialitzem el formulari de cerca
    $this->FCerca = new CercaForm();        
	$this->FCerca->bind($request->getParameter('cerca'));
	
	//Inicialitzem variables
	$this->MODE = array('CONSULTA'=>true,'NOU'=>false,'EDICIO'=>false);
        
    if($request->isMethod('POST') || $request->isMethod('GET')):
	    $accio = $request->getParameter('accio');
	    if($request->hasParameter('BCERCA'))    $accio = 'C';
	    if($request->hasParameter('BNOU')) 	    $accio = 'N';
	    if($request->hasParameter('BSAVE_x')) 	$accio = 'S';
	    if($request->hasParameter('BDELETE')) 	$accio = 'D';
	endif;                
	
    switch($accio){
    	case 'N':
    			$OReserva = new Reservaespais();    			
    			$this->FReserva = new ReservaespaisForm($OReserva);    			
    			$this->MODE['NOU'] = true;
    		break;
    	case 'E':    			
    			$this->getUser()->setAttribute('IDR',$request->getParameter('IDR'));
    			$OReserva = ReservaespaisPeer::retrieveByPK($this->getUser()->getAttribute('IDR'));
				$this->FReserva = new ReservaespaisForm($OReserva);   			
    			$this->MODE['EDICIO'] = true;
    		break;
    	case 'S':    			    		        		  
    		    $this->FReserva = new ReservaespaisForm(ReservaespaisPeer::retrieveByPK($this->getUser()->getAttribute('IDR')));
    		    $this->FReserva->bind($request->getParameter('reservaespais'));    		    
    		    if($this->FReserva->isValid()) $this->FReserva->save();    		        		    
    			$this->MODE['EDICIO'] = true;
    		break;
    	case 'D': 
    	        ReservaespaisPeer::retrieveByPK($request->getRequest('IDR'))->delete();    	        
    	        break;    	         	 
    }
        
    $this->RESERVES = ReservaespaisPeer::getReservesSelect($this->CERCA,$this->PAGINA);
    
  		
  }

  /**
   * Matrícules
   *
   */
   
  
  public function executeGMatricules(sfWebRequest $request)
  {
  
    $this->setLayout('gestio');

    $this->CERCA  = $this->ParReqSesForm($request,'text',"",'cerca');
    $this->SELECT = $this->ParReqSesForm($request,'select',2,'cerca');
    $this->PAGINA = $this->ParReqSesForm($request,'PAGINA',1);
    $accio  = $this->ParReqSesForm($request,'accio','CA');       
    
    //Inicialitzem el formulari de cerca
    $this->FCerca = new CercaTextChoiceForm();       
    $this->FCerca->setChoice(array(1=>'Cursos',2=>'Alumnes')); 
	$this->FCerca->bind(array('text'=>$this->CERCA,'select'=>$this->SELECT));
	
	//Inicialitzem variables
	$this->MODE = array('CONSULTA'=>false,'NOU'=>false,'EDICIO'=>false, 'LMATRICULES'=>false , 'VERIFICA' => false);

    if($request->isMethod('POST')){
	    if($request->hasParameter('BCERCA')) { $accio = ( $this->SELECT == 2 )?'CA':'CC'; $this->PAGINA = 1; }   
	    elseif($request->hasParameter('BNOU')) 	    $accio = 'N';
	    elseif($request->hasParameter('BSUBMIT')) 	$accio = 'S';		//Hem entrat una matrícula i passem a la fase de verificació
	    elseif($request->hasParameter('BDELETE')) 	$accio = 'D';
    }                
    
    //Aquest petit bloc és per si es modifica amb un POST el que s'ha enviat per GET
    $this->getUser()->setAttribute('accio',$accio);
    $this->getUser()->setAttribute('PAGINA',$this->PAGINA);   //Guardem la pàgina per si hem fet una consulta nova  
    
    switch($accio){
    	case 'N': 
    			$this->getUser()->setAttribute('IDM',0);   			
    			$OMatricula = new Matricules();
    			$OMatricula->setDatainscripcio(time());
    			$OMatricula->setDescompte(0);    			    			
    			$this->FMatricula = new MatriculesForm($OMatricula);    			
    			$this->MODE['NOU'] = true;
    		break;
    	case 'E':    			
    			$IDM = $request->getParameter('IDM');
    			$this->getUser()->setAttribute('IDM',$IDM);
    			$OMatricula = MatriculesPeer::retrieveByPK($IDM);
				$this->FMatricula = new MatriculesForm($OMatricula);   			
    			$this->MODE['EDICIO'] = true;
    		break;
    	case 'S':
    			$OMatricula = ($this->getUser()->getAttribute('IDM') == 0)?new Matricules():MatriculesPeer::retrieveByPK($this->getUser()->getAttribute('IDM'));    		    
    			$this->FMatricula = new MatriculesForm($OMatricula);
    		    $this->FMatricula->bind($request->getParameter('matricules'));
    		        		    
    		    if($this->FMatricula->isValid()) { 
    		    	
    		    	$this->GuardaMatricula($this->FMatricula);
    		    	
    		    	$CURS = $this->FMatricula->getValue('Cursos_idCursos');
    		    	$DESCOMPTE = $this->FMatricula->getValue('Descompte');
    		    	$U = UsuarisPeer::cercaDNI($this->FMatricula->getValue('Usuaris_usuariID')); 
    		    	$PREU = CursosPeer::CalculaTotalPreus(array($CURS),$DESCOMPTE);
    		    	$NOM  = $U->getNomComplet();
    		    	$MATRICULA = $this->FMatricula->getValue('idMatricules');    		    	
    		    	
    		    	$this->TPV = MatriculesPeer::getTPV($PREU,$NOM,$MATRICULA);
    		    	
    		    	$this->MODE['VERIFICA'] = true;
    		    	
    		    } else $this->MODE['EDICIO'] = true;
    		    
    		break;
    	case 'OK':
    		 if($this->getRequestParameter('Ds_Response') == '0000'):
                 $matricules = $this->getRequestParameter('Ds_MerchantData');
                 foreach(explode("@",$matricules) as $M):
                    MatriculesPeer::setMatriculaPagada($M);                 
                 endforeach;
              else:
                 foreach(explode('@',$matricules) as $M):        
                    MatriculesPeer::retrieveByPK($M)->delete();
                 endforeach;              
              endif;
              break;    		    		
    	case 'D': 
    	        CursosPeer::retrieveByPK($request->getRequest('IDC'))->delete();    	        
    	    break;
		case 'CA':					
				$this->ALUMNES = MatriculesPeer::cercaAlumnes($this->CERCA , $this->PAGINA );
				$this->SELECT = 2;
				$this->MODE['CONSULTA'] = true;				 
			break;		
		case 'CC':
				$this->CURSOS = MatriculesPeer::cercaCursos($this->CERCA , $this->PAGINA );
				$this->SELECT = 1;
				$this->MODE['CONSULTA'] = true;
			break;
		case 'LMA':
				$this->MATRICULES = MatriculesPeer::getMatriculesUsuari($request->getParameter('IDA'));				
				$this->MODE['LMATRICULES'] = true; 
			break;
		case 'LMC':
				$this->MATRICULES = MatriculesPeer::getMatriculesCurs($request->getParameter('IDC'));
				$this->MODE['LMATRICULES'] = true;
			break;		
    }
  	
  
  }
  
  public function GuardaMatricula(sfFormPropel $Matricula)
  {
  	$Matricula->updateObject();
  	$OM = $Matricula->getObject();
  	
  	//Agafem el DNI, busquem el valor que té l'usuari i guardem la seva matrícula 
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
	    if($request->hasParameter('BSUBMIT')) 		$this->accio = 'S';		//Hem entrat una matrícula i passem a la fase de verificació
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
						
	}
             
    $this->NOTICIES = NoticiesPeer::getNoticies("",$this->PAGINA);
          
  }
  
  public function executeGIncidencies(sfWebRequest $request)
  {
     
	$this->setLayout('gestio');
	        
	    $this->PAGINA = $this->ParReqSesForm($request,'PAGINA',1);
	    $this->CERCA = $this->ParReqSesForm($request,'text',1,'cerca');
	    
	    //Inicialitzem el formulari de cerca
	    $this->FCerca = new CercaForm();
		$this->FCerca->bind($request->getParameter('cerca'));
		
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
			    if($this->FIncidencia->isValid()) $this->FIncidencia->save();
			    $this->MODE['EDICIO'] = true;    		        		        			
			break;
		case 'D': 
		        IncidenciesPeer::retrieveByPK($request->getRequest('IDI'))->delete();    	        
		        break;    	         	 
	}
	
	    
	$this->INCIDENCIES = IncidenciesPeer::getIncidencies($this->CERCA, $this->PAGINA);
  
  }

    
  public function executeGCessio(sfWebRequest $request)  
  {
    
  	$this->setLayout('gestio');
        
    $this->PAGINA = $this->ParReqSesForm($request,'PAGINA',1);
    $this->CERCA = $this->ParReqSesForm($request,'text',1,'cerca');
    
    //Inicialitzem el formulari de cerca
    $this->FCerca = new CercaForm();
	$this->FCerca->bind($request->getParameter('cerca'));
	
	//Inicialitzem variables
	$this->MODE = array('CONSULTA'	=> true,
						'NOU'		=> false, 
						'EDICIO' 	=> false, 
						'CESSIO' 	=> false
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
    			$OCessio = new Cessiomaterial();
    			$OCessio->setDatacessio(date('m/d/Y',time()));
    			$OCessio->setDataretorn(date('m/d/Y',time()));    			    			    	    			
    			$this->FCessiomaterial = new CessiomaterialForm($OCessio);
    			$this->getUser()->setAttribute('IDC',0);    			
    			$this->MODE['NOU'] = true;
    		break;
    	case 'E':    			
    			$this->getUser()->setAttribute('IDC',$request->getParameter('IDC'));
    			$OCessio = CessiomaterialPeer::retrieveByPK($this->getUser()->getAttribute('IDC'));
				$this->FCessiomaterial = new CessiomaterialForm($OCessio);				   			
    			$this->MODE['EDICIO'] = true;
    		break;
    	case 'S':    			    	    				        		  
    		    $this->FCessiomaterial = new CessiomaterialForm(CessiomaterialPeer::retrieveByPK($this->getUser()->getAttribute('IDC')));
    		    $this->FCessiomaterial->bind($request->getParameter('cessiomaterial'));
    		    if($this->FCessiomaterial->isValid()) $this->FCessiomaterial->save();
    		    $this->MODE['EDICIO'] = true;    		        		        			
    		break;
    	case 'D': 
    	        CessiomaterialPeer::retrieveByPK($request->getRequest('IDC'))->delete();    	        
    	        break;    	         	 
    }

    
    $this->CESSIONS = CessiomaterialPeer::getCessions($this->PAGINA);
  
  }  
  
}
