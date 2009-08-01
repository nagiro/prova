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
  
  public function executeGUsuaris()
  {    

    $this->setLayout('gestio');

    $this->CERCA = $this->getRequestParameter('CERCA'); 
    $this->PAGINA = $this->getRequestParameter('PAGINA');
    $this->ERRORS = null;    $this->EDICIO = false; $this->NOU = false; 
    $this->LLISTES = false;  $this->CURSOS = false; $this->REGISTRES = false;    
    
    $this->IDU = $this->getRequestParameter('IDU');
        
    $accio = $this->getRequestParameter('accio');
    
    if($this->hasRequestParameter('NOU')) $accio = "N";
    if($this->hasRequestParameter('BCERCA')) $accio = "FC";
    if($this->hasRequestParameter('BDESVINCULA')) $accio = "DL";
    if($this->hasRequestParameter('BVINCULA')) $accio = "VL";
    
    switch($accio){
       case 'N':
             $this->NOU = true;
             $this->CERCA = null;
             $this->IDU = 0;
             $this->USUARI = new Usuaris();
             break;
       case 'E':
             $this->EDICIO = true;    
             $this->USUARI = UsuarisPeer::retrieveByPK($this->IDU);
             $this->IDU = $this->USUARI->getUsuariid();
             $this->EDICIO = true;
             break;
       case 'L': 
             $this->USUARI = UsuarisPeer::retrieveByPK($this->IDU);
             $this->LLISTAT_LLISTES = LlistesPeer::getLlistesDisponibles($this->IDU);
             $this->LLISTES = true;
             break;
       case 'C':
             $this->USUARI = UsuarisPeer::retrieveByPK($this->IDU);
             $this->CURSOS = true;
             break; 
       case 'R':
             $this->USUARI = UsuarisPeer::retrieveByPK($this->IDU);
             $this->REGISTRES = true;
             break;
       case 'S':
             $this->RET = $this->GuardaUsuari($this->IDU);
		     $this->USUARI = $this->RET['USUARI'];
		     $this->ERRORS = $this->RET['ERRORS'];
		     $this->IDU = $this->USUARI->getUsuariid();
		     $this->EDICIO = true;      
             break;       
       case 'DL':   //Desvincula una llista de correu
             $D = $this->getRequestParameter('D');
             foreach($D['IDL'] as $IDL) LlistesPeer::desvincula($D['IDU'],$IDL);
             $this->redirect("gestio/gUsuaris?CERCA={$this->CERCA}&PAGINA={$this->PAGINA}&IDU={$D['IDU']}&accio=L");                            
             break;
       case 'VL':   //Vincula a una llista de correu
             $D = $this->getRequestParameter('D');
             foreach($D['IDL'] as $IDL) LlistesPeer::vincula($D['IDU'],$IDL);
             $this->redirect("gestio/gUsuaris?CERCA={$this->CERCA}&PAGINA={$this->PAGINA}&IDU={$D['IDU']}&accio=L");                            
             break;              
    }

    $this->PAGER_USUARIS = UsuarisPeer::cercaTotsCamps( $this->CERCA , $this->PAGINA );
        
            
  }
  
  //Guarda usuari, retorna un array amb [E] = ERRORS i [U] = USUARI
  public function GuardaUsuari($idU = NULL)
  {
  
    $U = new Usuaris();
    $new = is_null($idU); //Si no hi ha idU és un registre nou 
    if(!$new) { $U = UsuarisPeer::retrieveByPK($idU); $U->setNew(false); }
         
    $U->setNivellsIdnivells($this->getRequestParameter('NIVELL'));
    $U->setDNI($this->getRequestParameter('DNI'));    
    $U->setPasswd($this->getRequestParameter('PASSWD'));
    $U->setNom($this->getRequestParameter('NOM'));
    $U->setCog1($this->getRequestParameter('COG1'));
    $U->setCog2($this->getRequestParameter('COG2'));
    $U->setEmail($this->getRequestParameter('EMAIL'));
    $U->setAdreca($this->getRequestParameter('ADRECA'));
    $U->setCodiPostal($this->getRequestParameter('CODIPOSTAL'));
    $U->setPoblacio($this->getRequestParameter('POBLACIO'));
    $U->setPoblaciotext($this->getRequestParameter('POBLACIOT'));
    $U->setTelefon($this->getRequestParameter('TELEFON'));
    $U->setMobil($this->getRequestParameter('MOBIL'));
    $U->setEntitat($this->getRequestParameter('ENTITAT'));
    $U->setHabilitat(TRUE);    
    
    //Comprovem les dades i després retornem l'objecte o bé els errors
    $RET['ERRORS'] = $U->Check($new);
    if(empty($RET['ERRORS'])) $U->save();      
    $RET['USUARI'] = $U;
    
    return $RET;
  
  }
  

  //******************************************************************************************
  // GESTIO DE LES PROMOCIONS ****************************************************************
  //******************************************************************************************
  
  public function executeGPromocions()
  {
  
    $this->setLayout('gestio');
        
    $this->ERRORS = array(); $this->EDICIO = false; $this->NOU = false; $this->LLISTES = false; $this->CURSOS = false; $this->PROMOCIO = new Promocions();
    
    if($this->getRequestParameter('accio')=='N'):      
      $this->PROMOCIO = new Promocions();    
      $this->NOU = true;
    elseif($this->getRequestParameter('accio')=='E'):
      $this->PROMOCIO = PromocionsPeer::retrieveByPK($this->getRequestParameter('idP'));
      $this->EDICIO = true;
    elseif($this->getRequestParameter('accio')=='P'): //Puja
      $this->pujaPromocio($this->getRequestParameter('idP'));
    elseif($this->getRequestParameter('accio')=='B'): //Baixa
      $this->baixaPromocio($this->getRequestParameter('idP'));
    elseif($this->getRequestParameter('accio')=='D'): //Esborra
      $this->PROMOCIO = PromocionsPeer::retrieveByPK($this->getRequestParameter('idP'));
      $this->PROMOCIO->delete();      
    endif;
    
    if($this->getRequest()->hasParameter('SavePromocio')):
      $this->RET = $this->guardaPromocio($this->getRequestParameter('idP'),$this->getRequestParameter('NOU'));
      $this->PROMOCIO = $this->RET['PROMOCIO'];
      $this->ERRORS = $this->RET['ERRORS'];      
      $this->EDICIO = true;      
    endif;
    
    $C = new Criteria();
    $C->addAscendingOrderByColumn(PromocionsPeer::ORDRE);
    $this->PROMOCIONS = PromocionsPeer::doSelect($C);
    if(is_null($this->PROMOCIONS)) $this->PROMOCIONS = new Promocions();
        
  }
      
  private function pujaPromocio($idPromocio)
  {
    $C = new Criteria();
    $P1 = PromocionsPeer::retrieveByPK($idPromocio);  
    $O1 = $P1->getOrdre(); $O2 = $O1-1;
    $C->add(PromocionsPeer::ORDRE, $O2);          
    
    
    $P2 = PromocionsPeer::doSelectOne($C);
    if(!is_null($P2)):
      $P2->setNew(false); $P2->setOrdre($O1); $P2->save();
      $P1->setNew(false); $P1->setOrdre($O2); $P1->save();    
    endif;
  }
  
  private function baixaPromocio($idPromocio)
  {
    $C = new Criteria();
    $P1 = PromocionsPeer::retrieveByPK($idPromocio);            
    $O1 = $P1->getOrdre(); $O2 = $O1+1;
    $C->add(PromocionsPeer::ORDRE, $O2);
        
    $P2 = PromocionsPeer::doSelectOne($C);
    if(!is_null($P2)):
      $P2->setNew(false); $P2->setOrdre($O1); $P2->save();
      $P1->setNew(false); $P1->setOrdre($O2); $P1->save();
    endif;
  }
    
  private function guardaPromocio($idPromocions, $NOU)
  {
    $P = new Promocions();

    if($NOU):    
      $MAX = PromocionsPeer::getMaximOrdre();
      $P->setOrdre($MAX);
    else:
      $P = PromocionsPeer::retrieveByPK($idPromocions); 
      $P->setNew(false);
    endif;    
                    
    $P->setNom($this->getRequestParameter('NOM'));                		
    $P->setIsactiva($this->getRequestParameter('ISACTIVA'));    
    $P->setIsfixa($this->getRequestParameter('ISFIXA'));
    $P->setUrl($this->getRequestParameter('URL'));
    $P->save();    
                  
    //Creem el nom del fitxer
    $aFiles = $this->getRequest()->getFiles();                                  
    if(strlen($aFiles['ARXIU']['name']) > 5){			   
	    $fileName = $P->getPromocioid().'.'.self::findexts($aFiles['ARXIU']['name']);
			$this->getRequest()->moveFile('ARXIU', sfConfig::get('sf_web_dir').'/images/banners/'.$fileName);  						   
			
	    //Actualitzem amb el nou nom
	    $P->setExtensio($fileName);
    }    
    $P->save();
         
    $RET = array();
    $RET['PROMOCIO'] = $P;
    $RET['ERRORS'] = array();
            
    return $RET;
    
  }  
  
  //Funció que retorna l'extensió del document
  private function findexts ($filename) 
  { 
    $filename = strtolower($filename) ; 
    $exts = split("[/\\.]", $filename) ; 
    $n = count($exts)-1; 
    $exts = $exts[$n]; 
    return $exts; 
  }
    
  //******************************************************************************************
  // GESTIO DEL WEB **************************************************************************
  //******************************************************************************************
  
  public function executeGEstructura() 
  {
    $this->setLayout('gestio');
    $this->ERRORS = array(); $this->NOU = false; $this->EDICIO = false; $this->HTML = false;
           
    if($this->getRequestParameter('accio')=='N'):
      $this->NODE = new Nodes();                  
      $this->NOU = true;
    elseif($this->getRequestParameter('accio')=='E'):
      $this->NODE = NodesPeer::retrieveByPK($this->getRequestParameter('idN'));
      $this->EDICIO = true;
    elseif($this->getRequestParameter('accio')=='H'):
      $this->NODE = NodesPeer::retrieveByPK($this->getRequestParameter('idN'));
      $this->HTML = true;
    elseif($this->getRequestParameter('accio')=='D'):
      $this->NODE = NodesPeer::retrieveByPK($this->getRequestParameter('idN'));
      $this->NODE->delete();
      $this->NODE = new Nodes();                 
    endif;
    
    if($this->getRequest()->hasParameter('SaveNode')): 
      $this->RET = $this->SaveNode($this->getRequestParameter('idN'), $this->getRequestParameter('NOU'));
      $this->NODE = $this->RET['NODE'];
      $this->ERRORS = $this->RET['ERRORS'];      
      $this->EDICIO = true;                
    elseif($this->getRequest()->hasParameter('SaveHTML')):      
      $this->RET = $this->SaveHTML($this->getRequestParameter('idN'));
      $this->NODE = $this->RET['NODE'];
      $this->ERRORS = $this->RET['ERRORS'];      
      $this->HTML = true;                
    endif;

    $this->NODES = NodesPeer::retornaMenu();
    
  }  
  
  public function gestionaOrdre($Ordre)
  {
     foreach(NodesPeer::retornaMenu() as $N):
        if($N->getOrdre() >= $Ordre):
           $N->setOrdre($N->getOrdre()+1);
           $N->save();      
        endif;
     endforeach;
  }
  
  public function SaveNode( $idNode , $NOU )
  {

    if($NOU) $N = new Nodes(); 
    else { $N = NodesPeer::retrieveByPK($idNode); $N->setNew(false); }      
            
    $N->setTitolmenu($this->getRequestParameter('TITOLMENU'));    
    $N->setisCategoria($this->hasRequestParameter('ISCATEGORIA'));
    $N->setisPhp($this->hasRequestParameter('ISPHP'));
    $N->setisActiva($this->hasRequestParameter('ISACTIVA'));    
    NodesPeer::gestionaOrdre($this->getRequestParameter('ORDRE'), $N->getOrdre());            
    $N->setOrdre($this->getRequestParameter('ORDRE'));
    $N->setNivell($this->getRequestParameter('NIVELL'));
    
    //Comprovem les dades i després retornem l'objecte o bé els errors
    $RET['ERRORS'] = $N->Check($NOU);
    if(empty($RET['ERRORS'])) $N->save();      
    $RET['NODE'] = $N;
    
    return $RET;
  
  }
  
  public function SaveHTML($idNode)
  {
      $N = NodesPeer::retrieveByPK($idNode); 
      $N->setNew(false);
      $N->setHTML($this->getRequestParameter('HTML'));
      $N->save();
      $RET['ERRORS'] = array();
      $RET['NODE'] = $N;      
      return $RET;
  }
  
  //******************************************************************************************
  // GESTIO DE LES LLISTES *******************************************************************
  //******************************************************************************************
  
  public function executeGLlistes()
  {
    $this->setLayout('gestio');
    $this->LLISTES = array(); $this->LLISTA = new Llistes(); $this->IDL = null;
    $this->ERRORS = array(); $this->NOU = false; $this->EDICIO = false; $this->USUARIS = false; $this->MISSATGES = array();
    $this->CERCA = ""; $this->MISSATGE = new Missatgesllistes(); $this->LLISTAT = false;
    $this->PAGINA = 1; $this->PAGINA2 = 1; $this->PAGINA3 = 1; $this->ENVIAT = false;
  
    if($this->hasRequestParameter('PAGINA'))  $this->PAGINA = $this->getRequestParameter('PAGINA');
    else $this->PAGINA = 1;
    if($this->hasRequestParameter('PAGINA2'))  $this->PAGINA2 = $this->getRequestParameter('PAGINA2');
    else $this->PAGINA2 = 1;
    if($this->hasRequestParameter('PAGINA3'))  $this->PAGINA3 = $this->getRequestParameter('PAGINA3');
    else $this->PAGINA3 = 1;
    
    $accio = $this->getRequestParameter('accio');
    if($this->hasRequestParameter('BCERCA')) $accio = 'U';
    if($this->hasRequestParameter('BSAVE')) $accio = 'SM';
    if($this->hasRequestParameter('BSEND')) $accio = 'SEND';
    if($this->hasRequestParameter('BVINCULA')) $accio = 'VINCULA';
    if($this->hasRequestParameter('BDESVINCULA')) $accio = 'DESVINCULA';            
    
    switch($accio)
    {
      case 'N': 
                $this->LLISTA = new Llistes();
                $this->NOU = true;
                break;
      case 'E': 
                $this->LLISTA = LlistesPeer::retrieveByPK($this->getRequestParameter('IDL'));                
                $this->EDICIO = true; 
                break;                      
      case 'VINCULA':
               $this->IDL = $this->getRequestParameter('IDL');
               $ALTA_USUARIS = $this->getRequestParameter('ALTA_USUARI');
               foreach($ALTA_USUARIS as $U) UsuarisllistesPeer::Vincula($U,$this->IDL);                             
            break;
      case 'DESVINCULA':               
               $this->IDL = $this->getRequestParameter('IDL');
               $BAIXA_USUARIS = $this->getRequestParameter('BAIXA_USUARI');               
               foreach($BAIXA_USUARIS as $U) UsuarisllistesPeer::Desvincula($U,$this->IDL);               
            break;
      case 'M':
                $this->IDL = $this->getRequestParameter('IDL');
                $this->LLISTA_MISSATGES = LlistesPeer::getMissatges($this->IDL , LlistesPeer::TOTS,$this->PAGINA3);
                $this->MISSATGE = new Missatgesllistes(); 
                $this->MISSATGES = true;
                break;
      case 'MV':                
                $this->IDL = $this->getRequestParameter('IDL');
                $this->LLISTA_MISSATGES = LlistesPeer::getMissatges($this->IDL , LlistesPeer::TOTS,$this->PAGINA3);         
                $this->MISSATGE = MissatgesllistesPeer::retrieveByPK($this->getRequestParameter('IDM'));
                $this->MISSATGES = true;                
                break;                
      case 'S': 
                $RET = $this->saveLlista();
                $this->LLISTA = $RET['LLISTA'];
                $this->ERRORS = $RET['ERRORS'];
                break; 
      case 'SU':
                
                $RET = $this->saveUsuaris();
                $this->ERRORS = $RET['ERRORS'];
                $this->USUARIS = true;                
                break;
      case 'SM':
                $RET = $this->saveMissatges();
                $this->ERRORS = $RET['ERRORS'];
                $this->MISSATGE = $RET['MISSATGE'];
                $this->IDL = $this->getRequestParameter('IDL');
                $this->LLISTA_MISSATGES = LlistesPeer::getMissatges( $this->IDL , LlistesPeer::TOTS , $this->PAGINA3 );                         
                $this->MISSATGES = true;
                break;
      case 'L': 
               $IDL = $this->getRequestParameter('IDL');
               $this->LLISTA = LlistesPeer::retrieveByPK($IDL);
               $this->LMISSATGES = $this->LLISTA->getMissatgesllistess();               
               $this->LLISTAT = true;
               break;
      case 'SEND':               
               $this->MAILS = LlistesPeer::EnviaMissatge($this->getRequestParameter('IDM'));
               $this->ENVIAT = true;                               
               break;
    
    }        
  
        //Inicialitzem els valors comuns
    $this->LLISTES = LlistesPeer::doSelect(new Criteria());

    if($accio == 'U' || $accio == 'VINCULA' || $accio == 'DESVINCULA'):
         if($this->hasRequestParameter('CERCA_TIPUS')):
            $this->CERCA_TIPUS = $this->getRequestParameter('CERCA_TIPUS');
            $this->CERCA       = $this->getRequestParameter('CERCA');
            if($this->CERCA_TIPUS == 'llista'):
               $this->CERCA_LLISTA = $this->CERCA;
               $this->CERCA_DISPON = "";
            else:
               $this->CERCA_LLISTA = "";
               $this->CERCA_DISPON = $this->CERCA;
            endif;
         else: $this->CERCA_TIPUS = 'llista';
               $this->CERCA       = "";
               $this->CERCA_LLISTA = "";
               $this->CERCA_DISPON = "";
         endif;

         $this->IDL = $this->getRequestParameter('IDL');                

         $this->USUARIS_LLISTA = UsuarisllistesPeer::getUsuarisLlista( $this->CERCA_LLISTA ,  $this->IDL , $this->PAGINA );
         $this->USUARIS_DISPONIBLES = UsuarisllistesPeer::getUsuarisNoLlista( $this->CERCA_DISPON , $this->IDL , $this->PAGINA2 );
         $this->USUARIS = true;                
    endif;
  
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
	    if($request->getParameter('BSAVE')) 	$accio = 'S';            
	    if($request->getParameter('BDELETE'))	$accio = 'D';    

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
    		if($this->FTasca->isValid()) $this->FTasca->save();
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
         
  public function executeGActivitats()
  {    
    
    $this->setLayout('gestio');
    $this->CALENDARI = NULL; $this->VARIAMES = 0; $this->VARIAANY = 0; 
    $this->IDA = NULL; $this->ACCIO = NULL; $this->ACTIVITATS = array(); $this->ACTIVITAT = new Activitats(); 
    $this->NOU = false; $this->EDICIO = false; $this->LLISTA = FALSE; $this->HORARIS = false; $this->CONSULTA = false; $this->LINIES = array();
    $this->D = array('AVIS'=>'' , 'ESPECTADORS'=>'' , 'DIA'=>'' , 'HORAPRE'=>'' , 'HORAIN'=>'' , 'HORAFI'=>'' , 'HORAPOST'=>'' , 'ESPAIS'=>ARRAY() , 'MATERIAL'=>ARRAY());
    $this->REDICIO = false; $this->CANVI_EDICIO_HORARI = false; $this->TEXTOS = false; $this->FEINES = false; $this->TASQUES = new Tasques();  $this->CICLES = false;        
    
    if($this->getRequest()->hasParameter('PAGINA')) $this->PAGINA = $this->getRequestParameter('PAGINA'); else $this->PAGINA = 1;
    if($this->getRequest()->hasParameter('CERCA')) $this->CERCA = $this->getRequestParameter('CERCA'); ELSE $this->CERCA = "";
    
	if($this->getRequest()->hasParameter('DATAI')) $this->DATAI = $this->getRequestParameter('DATAI');
	else $this->DATAI = date('Y-m-01',time());
	
    $this->DATAF = $this->sumarmesos($this->DATAI,6);
    $this->IDA = $this->getRequestParameter('IDA');
    if( $this->IDA > 0 ) $this->ACTIVITAT = ActivitatsPeer::retrieveByPK($this->getRequestParameter('IDA'));
    
    $accio = $this->getRequestParameter('accio');
    if($this->getRequest()->hasParameter('BCERCA')) $accio = 'CC';
    if($this->getRequest()->hasParameter('BNOU')) $accio = 'N';    
    if($this->getRequest()->hasParameter('BGUARDAH')) $accio = 'GH';
    if($this->getRequest()->hasParameter('BEDITAH')) $accio = 'EH';
    if($this->getRequest()->hasParameter('BVERIFICA')) $accio = 'VH';
    if($this->getRequest()->hasParameter('BELIMINA')) $accio = 'VE';    
    if($this->getRequest()->hasParameter('BGUARDAT')) $accio = 'ST';
    if($this->getRequest()->hasParameter('BFEINES')) $accio = 'SF';
    if($this->getRequest()->hasParameter('BAFEGIRESPAI')) $accio = '+';
    if($this->hasRequestParameter('BCICLESAVE')) $accio = 'ACS';
        
    switch($accio)
    {
       case 'AC':
                $this->LLISTA_CICLES = CiclesPeer::doSelect(new Criteria());
                $this->CICLE = new Cicles();
                $this->CICLES = true;
                if($this->hasRequestParameter('IDA')) $this->EDICIO = true; else $this->EDICIO = false;                
                break;
       case 'ACS':
                $this->saveCicle();
                $this->LLISTA_CICLES = CiclesPeer::doSelect(new Criteria());
                $this->CICLE = new Cicles();
                $this->CICLES = true;
                break;
       case 'C':       			               
                $DIA = $this->getRequestParameter('DIA');
                $MES = $this->getRequestParameter('MES');
                $ANY = $this->getRequestParameter('ANY');
                if(empty($DIA)) $DIA = NULL; else $DIA = $ANY.'-'.$MES.'-'.$DIA;
                $HORARIS = HorarisPeer::getActivitats($DIA , $this->CERCA, $this->DATAI, $this->DATAF, $this->IDA);                                
                $this->ACTIVITATS = $HORARIS['ACTIVITATS'];                
                $this->CALENDARI = $HORARIS['CALENDARI'];
                $this->CONSULTA = true;
                $this->LLISTA = true;
                $this->DIA = $DIA;                                               
                break;
         //Consulta quan prems un mes
       case 'CC':       			               
                $DIA = $this->getRequestParameter('DIA');
                $MES = $this->getRequestParameter('MES');
                $ANY = $this->getRequestParameter('ANY');
                if(empty($DIA)) $DIA = NULL; else $DIA = $ANY.'-'.$MES.'-'.$DIA;
                $this->CALENDARI = HorarisPeer::getCalendari($DIA , $this->CERCA, $this->DATAI, $this->DATAF, $this->IDA ,true );                                                                                
                $this->CONSULTA = true;
                $this->LLISTA = false;
                $this->DIA = $DIA;                                               
                break;                
      case 'N':
                $this->ACTIVITAT = new Activitats();
                $this->NOU = true;
                break;
      case 'S': 
                $RET = $this->guardaActivitat();
                $this->ACTIVITAT = $RET['ACTIVITAT'];
                $this->ERRORS = $RET['ERRORS'];
                $this->EDICIO = true;                
                break;
      case 'E':         
                $this->EDICIO = true;                
                break;
      case 'H':                                 
                //Carreguem els que ja tenim a l'estructura i després treballem només amb els que s'entren.
                $this->L = $this->CarregaHorarisLlista(); 
                $this->HORARI = $this->ACTIVITAT->getHorariss();                                
                $this->HORARIS = true;
                break;                
      case 'VH': 
                //Guarda els horaris                           
                $this->ERRORS = $this->GuardaHorari();   
                $this->L = $this->CarregaHorarisLlista();             
                $this->HORARI = $this->ACTIVITAT->getHorariss();                                
                $this->HORARIS = true;
                break;                         
      case 'VE': 
                //Esborra un horari
                $D = $this->getRequestParameter('D');                           
                if(isset($D['idH'])) HorarisPeer::retrieveByPK($D['idH'])->delete();
                $this->L = $this->CarregaHorarisLlista();             
                $this->HORARI = $this->ACTIVITAT->getHorariss();                                
                $this->HORARIS = true;
                break;                
       case 'GH':
                $this->GuardaHorari();                
                $this->redirect('gestio/gActivitats');
                break;
       case 'EH':                                
                if($this->getRequest()->hasParameter('REDICIO')):                                    //Sí té el botó premut. Si no hi ha botó, no faig res
                  $this->REDICIO = $this->getRequestParameter('REDICIO');                            //Agafa el valor que estic editant
                  $L = $this->getRequestParameter('L');                                              //Carrego les dades del llistat
                  $this->D = $L[$this->REDICIO];                                                     //Ho passo a D per editar.
                  $this->CANVI_EDICIO_HORARI = true;                                                 //Activo la edició d'horari
                endif;
                  $this->HORARIS = true;                                                             //Obro el formulari d'HORARIS
                  $this->LINIES = $this->getRequestParameter('L');                                   //Torno a carregar les mateixes Linies ( encara no he fet cap canvi )
                break; 
       case 'T':                
                $this->ACTIVITAT = $this->ACTIVITAT;                              
                $this->TEXTOS = TRUE;       
                break;        
       case 'ST':
                $this->ACTIVITAT = $this->GuardaText($this->IDA);
                $this->TEXTOS = true;
                break;
       case '+':
       			 //Guarda els horaris       			               			      
                $this->D = $this->getRequestParameter('D');                                                                               
                $this->HORARIS = true;
                break;                
       			
     default:   $this->CALENDARI = HorarisPeer::getCalendari( null , null , $this->DATAI, $this->DATAF, null , true );         			                					
    			$this->LLISTA = false;
    			$this->CONSULTA = true;
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
  
  public function GuardaHorari()
  {
      
      //Captem el paràmetre D amb les dades.
     $D = $this->getRequestParameter('D');
     
     //Agafo el codi de l'activitat que estem guardant
     $IdA = $this->getRequestParameter('IDA');

     //Segmentem els dies per crear per cada dia, un registre a la BDD
     $DIES = explode(" ", $D['DIA']); if(sizeof($DIES)>1) array_pop($DIES); //Traiem l'últim que és un espai en blanc      

     //Migrem les dades a format línia de BDD          
     foreach($DIES as $DIA):
        $this->LINIES[] = array('DIA'=>$DIA,'HORAPRE'=>$D['HORAPRE'],'HORAIN'=>$D['HORAIN'],'HORAFI'=>$D['HORAFI'],'HORAPOST'=>$D['HORAPOST'],'ESPAIS'=>$D['ESPAIS'], 'MATERIAL'=>$D['MATERIAL'], 'AVIS'=>$D['AVIS'], 'ESPECTADORS'=>$D['ESPECTADORS']);     
      endforeach;
     
    $ERRORS = array();
    
   
   //Per cada línia que hem de guardar a la BDD comprovem la validesa de les dades. Si hi ha algun error, no es guardaran les dades.  
    foreach($this->LINIES as $K=>$L):
        
      if( empty($L['DIA']) ) $ERRORS[] = "No has entrat cap dia";
      if( empty($L['HORAPRE'])  ) $ERRORS[] = "No has entrat cap hora PRE";
      if( empty($L['HORAIN'])   ) $ERRORS[] = "No has entrat cap hora IN";
      if( empty($L['HORAFI'])   ) $ERRORS[] = "No has entrat cap hora FI";
      if( empty($L['HORAPOST']) ) $ERRORS[] = "No has entrat cap hora POST";
      if( $L['HORAPRE']   > $L['HORAIN'] ) $ERRORS[] = "L'hora de preparació no pot ser més gran que la d'inici.";
      if( $L['HORAIN']    > $L['HORAFI'] ) $ERRORS[] = "L'hora d'inici no pot ser més gran que la d'acabament.";
      if( $L['HORAFI']    > $L['HORAPOST'] ) $ERRORS[] = "L'hora d'acabament no pot ser més gran que la de desmuntatge.";
      
      list($any,$mes,$dia) = explode("-",$L['DIA']);
      if(!($any > 2000 && $mes < 13 && $dia < 31 )) $ERRORS[] = "La data que has entrat és incorrecta";      
      
      list($hora,$minuts) = explode(":",$L['HORAPRE']);
      if(!($hora < 24 && $minuts < 60)) $ERRORS[] = "L'hora PRE és incorrecta";
      list($hora,$minuts) = explode(":",$L['HORAIN']);
      if(!($hora < 24 && $minuts < 60)) $ERRORS[] = "L'hora IN és incorrecta";
      list($hora,$minuts) = explode(":",$L['HORAFI']);
      if(!($hora < 24 && $minuts < 60)) $ERRORS[] = "L'hora FI és incorrecta";
      list($hora,$minuts) = explode(":",$L['HORAPOST']);
      if(!($hora < 24 && $minuts < 60)) $ERRORS[] = "L'hora POST és incorrecta";
      
       
      //Mirem que la data no es solapi amb alguna altra activitat al mateix espai                                         
      $C = new Criteria();
      $C->add(HorarisPeer::DIA,$L['DIA']);
      
      // -------
      //----
      $C1 = $C->getNewCriterion(HorarisPeer::HORAPRE,$L['HORAPRE'],CRITERIA::GREATER_EQUAL);          
      $C2 = $C->getNewCriterion(HorarisPeer::HORAPRE, $L['HORAPOST'],CRITERIA::LESS_EQUAL);
      $C1->addAnd($C2);
      
      // -------
      //      ----
      $C3 = $C->getNewCriterion(HorarisPeer::HORAPOST,$L['HORAPRE'],CRITERIA::GREATER_EQUAL);          
      $C4 = $C->getNewCriterion(HorarisPeer::HORAPOST, $L['HORAPOST'],CRITERIA::LESS_EQUAL);
      $C3->addAnd($C4);
      
      // ------
      //   --
      $C5 = $C->getNewCriterion(HorarisPeer::HORAPRE, $L['HORAPRE'] ,CRITERIA::LESS_EQUAL);          
      $C6 = $C->getNewCriterion(HorarisPeer::HORAPOST, $L['HORAPOST'],CRITERIA::GREATER_EQUAL);
      $C5->addAnd($C6);

      // -------
      //---------
      $C7 = $C->getNewCriterion(HorarisPeer::HORAPRE, $L['HORAPRE'] ,CRITERIA::GREATER_EQUAL);          
      $C8 = $C->getNewCriterion(HorarisPeer::HORAPOST, $L['HORAPOST'],CRITERIA::LESS_EQUAL);
      $C7->addAnd($C8);
      
      
      $C->addOr($C1); $C1->addOr($C3); $C1->addOr($C5); $C1->addOr($C7);
      $C->add( HorarisPeer::ACTIVITATS_ACTIVITATID , $IdA , Criteria::NOT_EQUAL );
      
      $HORARIS_SOLAPAMENT_TEMPORAL = HorarisespaisPeer::doSelectJoinHoraris($C);
      
      //Un cop capturats els horaris que encaixen amb altres, mirem si el material també encaixa
      foreach($HORARIS_SOLAPAMENT_TEMPORAL as $H):
         $idE = $H->getEspaisEspaiid();                  
	     if( isset($idE) && in_array( $idE , $L['ESPAIS'] ) ) $ERRORS[$idE.$L['DIA'].'ESPAI'] = "Solapament temporal a ".EspaisPeer::retrieveByPK( $idE )->getNom().' el dia '.$L['DIA'];	     

	     $idM = $H->getMaterialIdmaterial();	     
         if( isset($idM) && in_array( $idM , $L['MATERIAL'] ) ) $ERRORS[$idM.$L['DIA'].'MATERIAL'] = "El material ".MaterialPeer::retrieveByPK( $idM )->getNom().' no disponible el dia '.$L['DIA'];

      endforeach;
                  
    endforeach;
           
    //Si no hem trobat cap error, guardem els registres d'ocupació. 
    if(empty($ERRORS)):
            
      //Si tinc un registre a D que és idH vol dir que estic fent una edició d'un horari. Simplement l'esborro perquè l'estic modificant
      if(!empty($D['idH'])): HorarisPeer::retrieveByPK($D['idH'])->delete(); endif; 
            
      //Com que abans he esborrat l'antic, ara entro el nou que pot tenir més línies      
      foreach( $this->LINIES as $L ):               
        $H = new Horaris();
        $H->setNew(true);  
        $H->setActivitatsactivitatid($IdA);
        $H->setDia($L['DIA']);
        $H->setHorapre($L['HORAPRE']);
        $H->setHorainici($L['HORAIN']);
        $H->setHorafi($L['HORAFI']);
        $H->setHorapost($L['HORAPOST']);
        $H->setAvis($L['AVIS']);
        $H->setEspectadors($L['ESPECTADORS']);
        $H->setPlaces(null);
        $H->save();        
                
        foreach($L['ESPAIS'] as $K=>$V):
           $HE = new Horarisespais(); $HE->setNew(true);
           if( $V > 0 ):
	           $HE->setHorarisHorarisid($H->getHorarisid());
	           $HE->setEspaisEspaiid($V);
	           if(!empty($L['MATERIAL'][$K])) $HE->setMaterialIdmaterial($L['MATERIAL'][$K]);            //Entrem com a material el que hi ha a la mateixa línia de l'espai
	           $HE->save();
	       endif;                
        endforeach;

       endforeach;

       else:
       
       $this->D = $this->getRequestParameter('D');
       
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

  
  public function CarregaHorarisLlista()
  {
    $this->LINIES = array();
    $OA = ActivitatsPeer::retrieveByPK($this->IDA);
    $i = 0;
    $C = new Criteria();
    $C->addDescendingOrderbyColumn(HorarisPeer::DIA);
    foreach($OA->getHorariss($C) as $OH):
      $this->LINIES[$i] = array();
      $this->LINIES[$i]['DIA'] = $OH->getDia("Y-m-d");
      $this->LINIES[$i]['HORAPRE'] = $OH->getHorapre("H:i");
      $this->LINIES[$i]['HORAIN'] = $OH->getHorainici("H:i");
      $this->LINIES[$i]['HORAFI'] = $OH->getHorafi("H:i");
      $this->LINIES[$i]['HORAPOST'] = $OH->getHorapost("H:i");
      $this->LINIES[$i]['AVIS'] = $OH->getAvis();
      $this->LINIES[$i]['ESPECTADORS'] = $OH->getEspectadors();                              
      foreach($OH->getHorarisespaiss() as $OHE): 
        $this->LINIES[$i]['ESPAIS'][] = $OHE->getEspaisespaiid();  
        $this->LINIES[$i]['MATERIAL'][] = $OHE->getMaterialIdmaterial();      
      endforeach;      
      $this->LINIES[$i]['idH'] = $OH->getHorarisid();
      $i++;
    endforeach;
  }
  
  public function guardaActivitat()
  {
    $IDA = $this->getRequestparameter('IDA');
    $A = new Activitats();
    if($IDA > 0): $A = ActivitatsPeer::retrieveByPK($IDA); $A->setNew(false); endif;
        
    $A->setCiclesCicleid($this->getRequestParameter('CICLE'));
    $A->setTipusactivitatIdtipusactivitat($this->getRequestParameter('TIPUS'));
    $A->setNom($this->getRequestParameter('NOM'));
    $A->setPreu($this->getRequestParameter('PREU'));
    $A->setPreureduit($this->getRequestParameter('PREUREDUIT'));
    $A->setPublicable($this->getRequestParameter('PUBLICABLE'));
    $A->setEstat($this->getRequestParameter('ESTAT'));
    $A->save();
  
    $RET['ERRORS'] = array();
    $RET['ACTIVITAT'] = $A;
    
    return $RET;
    
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

    if($this->hasRequestParameter('CERCA_ANY')) $this->CERCA_ANY = date('Y',time());

    $this->CERCA_ANY = $this->getRequestParameter('CERCA_ANY');
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
    if( $this->getRequest()->hasParameter('BSAVE') ) $accio = 'S';
    if( $this->getRequest()->hasParameter('BDELETE') ) $accio = 'D';

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
                $this->AID = $this->getRequestParameter('AID');
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
   	sfCoreAutoload::make(); 
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
	    if( $request->hasParameter('BDELETE') ) 	$accio = 'D';
	    
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
                if ($this->FMissatge->isValid()) $this->FMissatge->save();                	                                                                                
                $this->EDICIO = true;      
                break;
      case 'D':
                $this->IDM = $response->getParameter('IDM');
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
  
  public function ParReqSesForm($request, $nomCamp, $default = "",  $formulari = null) 
  {

  	$RET = "";
  	
  	if(!is_null($formulari)): 

  	  	if($request->hasParameter($formulari)):

  	  		$C = $request->getParameter($formulari);
  			$RET = $C[$nomCamp]; 
  			$this->getUser()->setAttribute('cerca',$this->TIPUS); 

  		elseif($this->getUser()->hasAttribute($nomCamp)): 
  			
  			$RET = $this->getUser()->getAttribute('cerca');
  			
  		else:
  		
  			$RET = $default;

  		endif;
  	
  	else:
  		if($request->hasParameter($nomCamp)):
  			 
  			$RET = $request->getParameter($nomCamp); 
  			$this->getUser()->setAttribute('cerca',$this->TIPUS); 

  		elseif($this->getUser()->hasAttribute($nomCamp)): 
  			
  			$RET = $this->getUser()->getAttribute('cerca');
  			
  		else:
  		
  			$RET = $default;

  		endif;
  			
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
	    if($request->hasParameter('BSAVE')) 	$accio = 'S';
	    if($request->hasParameter('BDELETE')) 	$accio = 'D';
	endif;                
	
    switch($accio){
    	case 'N':
    			$OMaterial = new Material();
    			$OMaterial->setMaterialgenericIdmaterialgeneric($this->TIPUS);
    			$this->FMaterial = new MaterialForm($OMaterial);    			
    			$this->NOU = true;
    		break;
    	case 'E':    			
    			$this->getUser()->setAttribute('IDM',$request->getParameter('IDM'));
    			$OMaterial = MaterialPeer::retrieveByPK($this->getUser()->getAttribute('IDM'));
				$this->FMaterial = new MaterialForm($OMaterial);   			
    			$this->EDICIO = true;
    		break;
    	case 'S':    			    		        		  
    		    $this->FMaterial = new MaterialForm(MaterialPeer::retrieveByPK($this->getUser()->getAttribute('IDM')));
    		    $this->FMaterial->bind($request->getParameter('material'));
    		    if($this->FMaterial->isValid()) $this->FMaterial->save();    		        		    
    			$this->EDICIO = true;
    		break;
    	case 'D': 
    	        MaterialPeer::retrieveByPK($request->getRequest('IDM'))->delete();    	        
    	        break;    	         	 
    }
        
    $this->MATERIALS = MaterialPeer::getMaterial($this->TIPUS, $this->PAGINA);
    
  }
    
  //**************************************************************************************************************************************************
  //**************************************************************************************************************************************************
  
  public function executeGCursos()  
  {
    
    $this->setLayout('gestio');
    
    $this->CERCA = ""; $this->NOU = false; $this->EDICIO = false; $this->LLISTAT = false;

    if($this->hasRequestParameter('PAGINA'))
         $this->PAGINA = $this->getRequestParameter('PAGINA');
    else $this->PAGINA = 1;
    
    $this->accio = $this->getRequestParameter('accio');
    $this->IDC = $this->getRequestParameter('IDC');
    if($this->getRequest()->hasParameter('BCERCAACTIUS')) $this->accio = 'CA';
    if($this->getRequest()->hasParameter('BCERCAINACTIUS')) $this->accio = 'CI';
    if($this->getRequest()->hasParameter('BNOU')) $this->accio = 'NC';    
    if($this->getRequest()->hasParameter('BSAVE')) $this->accio = 'S';
    if($this->getRequest()->hasParameter('BDELETE')) $this->accio = 'D';
       
	switch($this->accio){						
		case 'CI' : $this->CURSOS = CursosPeer::getCursos(CursosPeer::PASSAT , $this->PAGINA ); $this->ISACTIU = false; break;		//Cursos inactius
		case 'CAC': $this->MATRICULES = CursosPeer::getMatricules($this->getRequestParameter('IDC')); break;		//Cerca alumnes d'un curs
		case 'NC' : $this->CURS = new Cursos(); $this->NOU = true; break;		// Intentem donar d'alta un nou curs.
		case 'S'  : $this->saveCurs($this->getRequestParameter('IDC'));  break;
		case 'D'  : CursosPeer::retrieveByPK($this->getRequestParameter('IDC'))->delete(); break;			 		
		case 'E'  : $this->CURS = CursosPeer::retrieveByPK($this->getRequestParameter('IDC')); $this->EDICIO = true; break;
		case 'L'  : $this->CURS = CursosPeer::retrieveByPK($this->getRequestParameter('IDC')); $this->LLISTAT = true; break;
	}
	 
	
	if($this->accio <> 'CI'){
	   $this->CURSOS = CursosPeer::getCursos(CursosPeer::ACTIU , $this->PAGINA);
	   $this->ISACTIU = true;
	}
	
  }
  
  private function saveCurs($IDC = 0){
  	
  	$D = $this->getRequestParameter('D');
  	$CURS = new Cursos();
  	  	
  	if(!empty($IDC)) { $CURS = CursosPeer::retrieveByPK($IDC); $CURS->setNew(false);  } else $CURS->setNew(true);
  	
  	$CURS->setTitolcurs($D['TITOL']);
  	$CURS->setIsactiu($D['ACTIU']);
  	$CURS->setPlaces($D['PLACES']);
  	$CURS->setCodi($D['CODI']);
  	$CURS->setDescripcio($D['DESCRIPCIO']);
 	$CURS->setPreu($D['PREU']);
  	$CURS->setPreur($D['PREUR']);
  	$CURS->setHoraris($D['HORARIS']);
  	$CURS->setCategoria($D['CATEGORIA']);
  	$CURS->setDataaparicio($D['DATAAPARICIO']);
  	$CURS->setDatadesaparicio($D['DATADESAPARICIO']);
  	$CURS->setDatafimatricula($D['DATAFIMATRICULA']);
  	$CURS->setDatainici($D['DATAINICI']);
    $CURS->save();  	  	
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
  
  public function executeGMatricules()
  {
           
     $this->setLayout('gestio');
     
     $this->CERCA = ""; $this->NOU = false; $this->EDICIO = false; $this->CONSULTA = false;
     $this->LLISTAT = false; $this->USUARI_MATRICULA = new Usuaris(); $this->VERIFICACIO = false;
     $accio = $this->getRequestParameter('accio'); $this->DADES_MATRICULA = array(); $this->TPV = ARRAY();
     $this->LMATRICULATS = false; $this->EDITA_MATRICULA = false;

     //Inicialitzem la pàgina si n'hi ha
     if($this->hasRequestParameter('PAGINA')) $this->PAGINA = $this->getRequestParameter('PAGINA');
     else $this->PAGINA = 1;
     
     //Carreguem les variables
     if(!$this->hasRequestParameter('accio')) $accio = 'C';
     $this->CERCA_TIPUS = $this->getRequestParameter('CERCA_TIPUS'); 
     $this->CERCA       = $this->getRequestParameter('CERCA');                               
     
     //Analitzem les accions per botons         
     if($this->hasRequestParameter('BCERCA')) { $accio = "C"; $PAGINA = 1; }
     if($this->hasRequestParameter('BNOU')) $accio = 'N';
     if($this->hasRequestParameter('BVERIFICACIO')) $accio = 'V';
     if($this->hasRequestParameter('BMATRICULAR')) $accio = 'M';
          
     switch($accio){
        case 'C':                                    
              $this->CONSULTA = true;   
              if($this->CERCA_TIPUS == 'alumnes') $this->ALUMNES = MatriculesPeer::cercaAlumnes($this->CERCA,$this->PAGINA);                  
              else                                $this->CURSOS  = MatriculesPeer::cercaCursos($this->CERCA,$this->PAGINA);              
              break;
              
              //Llistem les matrícules que ha realitzat un alumne
        case 'LMA':              
              $this->IDA = $this->getRequestParameter('IDA');                                                        
              $this->IDC = "";
              $this->MATRICULATS = MatriculesPeer::getMatriculesUsuari($this->IDA);
              $this->LMATRICULATS = true;
              break;
              
             //Llistem les matrícules que hi ha en un curs determinat   
        case 'LMC':                           
              $this->IDC = $this->getRequestParameter('IDC');           
              $this->IDA = "";
              $this->MATRICULATS = MatriculesPeer::getMatriculesCurs($this->IDC);
              $this->LMATRICULATS = true;
              break;
        case 'EM':
              $this->IDM        = $this->getRequestParameter('IDM');
              $this->OMATRICULA = MatriculesPeer::retrieveByPK($this->IDM);
              $this->LCURSOS    = CursosPeer::getTotsCursos($this->PAGINA);              
              $this->EDITA_MATRICULA = true;
              break;
        case 'N': 
              $this->NOU = true;
              $this->USUARI_MATRICULA = UsuarisPeer::retrieveByPK($this->getRequestParameter('IDU'));
              $this->CURSOS = CursosPeer::getCursos(true);
              break;
        case 'V':
              //Mostrem la informació que l'usuari ha escollit per a ell i si verifica passa al pagament              
              $D = $this->getRequestParameter('D');
              $USUARI = UsuarisPeer::retrieveByPK($D['IDU']);
              $this->DADES_MATRICULA['DNI'] = $USUARI->getDni();
              $this->DADES_MATRICULA['NOM'] = $USUARI->getNomComplet();
              $this->DADES_MATRICULA['IDU'] = $D['IDU'];
              $this->DADES_MATRICULA['MODALITAT'] = $D['MODALITAT'];
              $this->DADES_MATRICULA['DESCOMPTE'] = $D['DESCOMPTE'];
              $this->DADES_MATRICULA['DATA'] = date('d-m-Y h:m',time());
              $this->DADES_MATRICULA['COMENTARI'] = $D['COMENTARI'];
              $this->DADES_MATRICULA['PREU'] = CursosPeer::CalculaTotalPreus($D['CURSOS'],$D['DESCOMPTE']);
              $this->DADES_MATRICULA['CURSOS'] = implode('@',$D['CURSOS']);

              //Generem els registres de matrícula
              $matricules = $this->guardaMatricula($this->DADES_MATRICULA); 
              
              //Carreguem les dades del TPV
              $this->TPV = MatriculesPeer::getTPV($this->DADES_MATRICULA['PREU'] , $this->DADES_MATRICULA['NOM'] , $matricules );                            
              
              //Comprovem si el pagament és amb targeta o metàl·lic per passar o anar al tpv
              $redirect = ($this->DADES_MATRICULA['MODALITAT'] == MatriculesPeer::PAGAMENT_METALIC || $this->DADES_MATRICULA['MODALITAT'] == MatriculesPeer::PAGAMENT_TRANSFERENCIA);
              
              //Si el pagament és en metàl·lic, marquem com a pagat i mostrem les matrícules de l'usuari. 
              if($redirect):                  
                 foreach($matricules as $M): MatriculesPeer::setMatriculaPagada($M); endforeach;
                 $this->redirect('gestio/gUsuaris?CERCA='.$this->DADES_MATRICULA['DNI'].'&IDU='.$this->DADES_MATRICULA['IDU'].'&accio=C');    
              endif; 
              
              $this->VERIFICACIO = true;
              
              break;              
        case 'M': break;
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
        default: $this->CONSULTA = true;
     }
     
     $this->CERCA = $this->getRequestParameter('CERCA');
     $this->IDM   = $this->getRequestParameter('IDM');
     $this->MATRICULES = MatriculesPeer::cercaMatricules($this->CERCA);
     
  }
  
  private function guardaMatricula( $DADES_MATRICULA , $EDIT = false , $IDMATRICULA = 0 )
  {
     $matricules = ARRAY();     
     
     foreach(explode('@',$DADES_MATRICULA['CURSOS']) as $C):

        $M = new Matricules();	     
	    $M->setUsuarisUsuariid($DADES_MATRICULA['IDU']);          
	    $M->setEstat(MatriculesPeer::PROCES_PAGAMENT);        
	    $M->setComentari($DADES_MATRICULA['COMENTARI']);
	    $M->setDatainscripcio($DADES_MATRICULA['DATA']);     
	    $M->setTreduccio($DADES_MATRICULA['DESCOMPTE']);
	    $M->setTpagament($DADES_MATRICULA['MODALITAT']);
	          
        $M->setCursosIdcursos($C);
        $M->save();
        $matricules[] = $M->getIdmatricules();
         
     endforeach;
     
     return $matricules;
     
  }
      
  public function executeGNoticies()
  {     
     $this->setLayout('gestio');
     
     if($this->hasRequestParameter('BDESACTIVA')) 
     {
        foreach($this->getRequestParameter('NOTICIA') AS $N):
           $A = ActivitatsPeer::retrieveByPK($N);           
           $A->setPublicaweb(false);
           $A->save();
        endforeach;
     }
     
     $C = new Criteria();
     $C->add(ActivitatsPeer::PUBLICAWEB , true);
     $this->NOTICIES = ActivitatsPeer::doSelect($C);
          
  }
  
  public function executeGIncidencies()
  {
     
     $this->setLayout('gestio');
     $this->CERCA  = $this->getRequestParameter('CERCA');
     $this->PAGINA = $this->getRequestParameter('PAGINA');
     $this->accio  = $this->getRequestParameter('accio');
     $this->IDI    = $this->getRequestParameter('IDI');
     $this->NOU = false; $this->EDICIO = false; $this->IDU = $this->getUser()->getAttribute('idU');
     
    if($this->getRequest()->hasParameter('BNOU')) $this->accio = 'N';    
    if($this->getRequest()->hasParameter('BSAVE')) $this->accio = 'S';
    if($this->getRequest()->hasParameter('BDELETE')) $this->accio = 'D';
       
	switch($this->accio){								
		case 'N' : $this->INCIDENCIA = new Incidencies(); $this->NOU = true; $this->IDI = 0; break;
		case 'E' : $this->INCIDENCIA = IncidenciesPeer::retrieveByPK($this->IDI); $this->IDI = $this->INCIDENCIA->getIdincidencia(); $this->EDICIO = true; break;
		case 'S' : $this->INCIDENCIA = IncidenciesPeer::save( $this->getRequestParameter("D") , $this->IDI );  $this->EDICIO = true; break;					 		
	}
               
     $this->INCIDENCIES = IncidenciesPeer::getIncidencies( $this->CERCA , $this->PAGINA );
          
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
