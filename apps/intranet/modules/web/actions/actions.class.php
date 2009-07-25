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
   
  public function LoadWEB()
  {

    $this->setLayout('layout'); $this->ERRORS = array(); $this->FOTOS = array();
    $this->ACCIO = 'noticies'; $this->TIPUS_MENU = 'WEB';  $this->CERCA = "";      
    $this->ACTIVITATS_CALENDARI = array(); $this->LLISTES = array(); $this->RESERVES = ARRAY(); 
    $this->MATRICULES = array(); $this->CURSOS = array(); $this->USUARI = new Usuaris(); $this->MISSATGE = array();
    $this->RESERVA = new Reservaespais(); $this->DADES_MATRICULA = array();
    $this->OBERT = 0; $this->SELECCIONAT = 0;

    //Escollim les 4 fotos de la capçalera
	$this->FOTOS = $this->getFotos();	

	//Escollim els 3 banners de portada	
	$this->BANNERS = $this->getBanners();

	//Carreguem el menú
	$this->MENU = NodesPeer::retornaMenu();

	//Comprovem si està autentificat o no per mostrar el menú.
    if($this->getUser()->isAuthenticated()){
    	$this->TIPUS_MENU = 'ADMIN';
    }
   
    $this->DATACALENDARI = time();
    $this->CERCA         = $this->getRequestParameter('CERCA');
    
        //Emmagatzemo la data
    if($this->hasRequestParameter('DATACALENDARI')) $this->DATACALENDARI = $this->getRequestParameter('DATACALENDARI');
    elseif($this->getUser()->hasAttribute('DATACAL')) { $this->DATACALENDARI = $this->getUser()->getAttribute('DATACAL'); if(!is_double($this->DATACALENDARI)) $this->DATACALENDARI = time(); }    
    else $this->DATACALENDARI = time();    
    $this->getUser()->setAttribute('DATACAL', $this->DATACALENDARI);

    //Emmagatzemo la CERCA    
    if($this->hasRequestParameter('CERCA')) $this->CERCA = $this->getRequestParameter('CERCA');
    elseif($this->getUser()->hasAttribute('CERCA')) $this->CERCA = $this->getUser()->getAttribute('CERCA');
    else $this->CERCA = "";    
    $this->getUser()->setAttribute('CERCA',$this->CERCA);
    
    
    
  }

  public function executeCursos()
  {
     $this->LoadWeb();
     $this->setTemplate('index');
     $this->ACCIO = 'cursos';
     
  }

  public function executeEnviaContacte()
  {

     $this->LoadWeb();
     $this->setTemplate('index');
     $this->ACCIO = 'contacte';
     $this->ENVIAT = true;
     
     // Class initialization
     $mail = new sfMail();
     $mail->initialize();
     $mail->setMailer('sendmail');
     $mail->setCharset('utf-8');
 
     // Definition of the required parameters
     $mail->setSender('contacte_web@casadecultura.cat', 'Formulari contacte WEB');
     $mail->setFrom('contacte_web@casadecultura.cat', 'Formulari contacte WEB');
     $mail->addReplyTo('informatica@casadecultura.org'); 
     $mail->addAddress('informatica@casadecultura.org');
 
     $mail->setSubject('CCG :: Formulari contacte WEB');
     
     $mail->setBody("El senyor/a {$this->getRequestParameter('COGNOMS')}, {$this->getRequestParameter('NOM')}".
                    " amb telèfon {$this->getRequestParameter('TELEFON')} i correu electrònic {$this->getRequestParameter('EMAIL')}".
                    " vol fer el següent comentari : {$this->getRequestParameter('COMENTARI')} ");
 
     // Send the Email
     $mail->send();
     
  }
  
  public function executeContacte()
  {
     $this->LoadWeb();
     $this->setTemplate('index');
     $this->ACCIO = 'contacte';     
     $this->ENVIAT = false;
  }
  
  public function executeLogout()
  {
     $this->getUser()->setAuthenticated(false);
	 $this->getUser()->setAttribute('idU',NULL);
	 $this->redirect('web/index');
  }
  
  public function executeRegistre()
  {
     $this->LoadWEB();
     $this->setTemplate('index');     
     $this->ACCIO = 'registre';
     $this->DADES_USUARI = new Usuaris();
     $this->ESTAT = '---'; 
  }
  
  public function executeRegistrat()
  {
     
     $U = new Usuaris();
         
     $U->setDni($this->getRequestParameter('DNI'));
     $U->setPasswd($this->getRequestParameter('PASSWD'));
     $U->setNom($this->getRequestParameter('NOM'));
     $U->setCog1($this->getRequestParameter('COG1'));
     $U->setCog2($this->getRequestParameter('COG2'));
     $U->setEmail($this->getRequestParameter('EMAIL'));
     $U->setTelefon($this->getRequestParameter('TELEFON'));
     $U->setMobil($this->getRequestParameter('MOBIL'));
     $U->setAdreca($this->getRequestParameter('ADRECA'));
     $U->setCodipostal($this->getRequestParameter('CODIPOSTAL'));
     $U->setPoblacio($this->getRequestParameter('POBLACIO'));
     $U->setPoblaciotext($this->getRequestParameter('POBLACIOT'));
     $U->setNivellsIdnivells(2);
     $U->setHabilitat(1);     

     //Comprovem que el DNI no existeixi. Si ja existeix informem l'usuari
     $C = new Criteria();
     $C->add(UsuarisPeer::DNI , $this->getRequestParameter('DNI'));
     
     if(UsuarisPeer::doCount($C) > 0):
         $this->LoadWEB(); $this->setTemplate('index'); $this->ACCIO = 'registre';      
         $this->DADES_USUARI = $U;
         $this->ESTAT = 'ERROR';                           
      else:
	     $U->save();     
	     $this->LoadWEB(); $this->setTemplate('index'); $this->ACCIO = 'registre';      
         $this->DADES_USUARI = $U;                  
         $this->ESTAT = 'OK';         
     endif;
     
  }
  
  
  public function executeLogin(sfWebRequest $request)
  {
     $this->LoadWEB();
     $this->setTemplate('index');

     $this->FLogin = new LoginForm();
     
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
     		 $this->getUser()->setAttribute('idU',$USUARI->getUsuariid());     		
	     	 $this->getUser()->setAuthenticated(true);
			 if($USUARI->getNivellsIdnivells() == 1) { $this->getUser()->addCredential('admin'); }
		     if($USUARI->getNivellsIdnivells() == 2) { $this->getUser()->addCredential('user'); }	    		   			    		
	         $this->redirectif( $USUARI->getNivellsIdnivells() == 1 , 'gestio/main' );
             $this->redirectif( $USUARI->getNivellsIdnivells() == 2 , 'web/index?accio=gd');	         
        else:
			 $this->ACCIO = 'login';
        endif;     		 
     endif;
               
  }
    
  
  public function executeIndex()
  {      
    
    $this->LoadWEB();    

    $accio = $this->getRequestParameter('accio');    
        
    if($this->hasRequestParameter('form_calendari_x') || $this->CERCA <> "" ) $accio = 'se';                
    
    switch($accio){

      //Consulta una pàgina determinada
      case 'cp':
            $this->PAGINA = NodesPeer::retrieveByPK($this->getRequestParameter('node'));
            $this->ACCIO  = 'web';
            $this->OBERT = $this->getRequestParameter('obert');
            $this->SELECCIONAT = $this->getRequestParameter('node');
            break;

       //Mostra les activitats quan cliquem un dia del calendari
	   case 'ca':
//	        if($this->CERCA <> '') $this->CarregaCerca(true,$this->DATACALENDARI);	        	    		        	    
	    	$this->ACTIVITATS_LLISTAT = ActivitatsPeer::getActivitatsDia(date('Y-m-d',$this->DATACALENDARI));
	    	$this->ACCIO = 'activitats';
	       break;

       //Mostra les activitats quan cliquem la cerca
	   case 'se': $this->CarregaCerca(false,$this->DATACALENDARI); break;
	   
	   //Per defecte mostrem les notícies
	   default: $this->CarregaNoticies();  break;	   
   }
                          
  }
  
  
  public function CarregaNoticies()
  {
     
     $this->ACTIVITATS_LLISTAT = ActivitatsPeer::getNoticies();             
	 $this->ACCIO = 'noticies';	         
	 $this->getUser()->setAttribute('HEFETCERCA',false);	 
	 
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
		 $this->QUANTES = sizeof($SOL['CALENDARI']);
		 $this->DATA    = $DATA;
		 $this->ACCIO = 'agenda';
		 $this->getUser()->setAttribute('HEFETCERCA',true);		 
	 endif;
	 	     	        
  }
  
  /**
   * Funció on anem a parar si premem un boto de l'apartat de "cursos"
   * 
   */
  
  public function executeMatriculat()  
  {
     
     $this->redirectif($this->hasRequestParameter('BNOUALUMNE'), 'web/registre' );     
     $this->redirectif($this->hasRequestParameter('BREGISTRAT'), 'web/gestio?accio=gc');
          
  }
  
  public function executeGestio()
  {
     $this->LoadWEB();
     $this->setTemplate('index');
     
     $accio = $this->getRequestParameter('accio');
          
     switch($accio){
       case 'gd':
		    $this->MODUL = 'gestiona_dades';
		    $this->ACCIO = 'gestio';
		    $this->USUARI = UsuarisPeer::retrieveByPK($this->getUser()->getAttribute('idU'));       	       	     
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
	        if($this->hasRequestParameter('idR')) $this->RESERVA = ReservaespaisPeer::retrieveByPK($this->getRequestParameter('idR'));	        
	        break;
	   case 'sd':
	        $this->saveUsuari();
	        $this->MODUL = 'gestiona_dades'; $this->ACCIO = 'gestio';
		    $this->USUARI = UsuarisPeer::retrieveByPK($this->getUser()->getAttribute('idU'));
		    $this->MISSATGE[] = "Dades modificades correctament";
	        break;       	                    	             	        
	   case 'sl':
	        UsuarisllistesPeer::saveUsuarisLlistes($this->getRequestParameter('LLISTA'), $this->getUser()->getAttribute('idU'));
	        $this->MODUL = 'gestiona_llistes'; $this->ACCIO = 'gestio';
		    $this->LLISTES = UsuarisllistesPeer::getLlistesUsuari($this->getUser()->getAttribute('idU'));
		    $this->MISSATGE[] = "Dades modificades correctament";
	        break;
	   case 'sr':	        	         
	        $this->RESERVA = ReservaespaisPeer::save($this->getRequestParameter('D'),$this->getUser()->getAttribute('idU') );	        
	        $this->RESERVES = ReservaespaisPeer::getReservesUsuaris($this->getUser()->getAttribute('idU'));
	        $this->MODUL = 'gestiona_reserves'; $this->ACCIO = 'gestio';
		    $this->LLISTES = UsuarisllistesPeer::getLlistesUsuari($this->getUser()->getAttribute('idU'));
		    if(sizeof($this->MISSATGE)==0) $this->MISSATGE[] = "Dades modificades correctament";		       
	        break;

	   case 'im':   //Iniciem la matrícula	                                    
            $D = $this->getRequestParameter('D');            
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
    
        
  private function saveUsuari()
  {
     $C = new Criteria();
     $C->add( UsuarisPeer::DNI , trim($this->getRequestParameter('DNI')) , CRITERIA::LIKE ); 
     $U = UsuarisPeer::doSelectOne($C);          
     $U->setPasswd($this->getRequestParameter('PASSWD'));
     $U->setNom($this->getRequestParameter('NOM'));
     $U->setCog1($this->getRequestParameter('COG1'));
     $U->setCog2($this->getRequestParameter('COG2'));
     $U->setEmail($this->getRequestParameter('EMAIL'));
     $U->setAdreca($this->getRequestParameter('ADRECA'));
     $U->setCodipostal($this->getRequestParameter('CODIPOSTAL'));
     $U->setPoblacio($this->getRequestParameter('POBLACIO'));
     $U->setPoblaciotext($this->getRequestParameter('POBLACIOTEXT'));
     $U->setTelefon($this->getRequestParameter('TELEFON'));
     $U->setMobil($this->getRequestParameter('MOBIL'));
     $U->setEntitat($this->getRequestParameter('ENTITAT'));      
     $U->save();
     
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
  
   public function executeEspais()
   {
      $this->LoadWEB();            
      $this->setTemplate('index');
      $this->ACCIO = 'espais';
   
   }
   
   public function executeReenviaContrasenya()
   {
      $this->LoadWEB();
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
  
   public function executeFuncionament()
   {
      $this->LoadWEB();
      $this->setTemplate('index');
      $this->ACCIO = 'funcionament';      
   }
   
}
