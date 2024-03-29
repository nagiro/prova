<?php

class myUser extends sfBasicSecurityUser
{

      
  static public function getDiaText( $data , $dim = false ){
    list($year,$month,$day) = explode('-',$data);
    $data = mktime(0,0,0,$month,$day,$year);
    if($dim):
        switch(date('N',$data)){
            case 1: return 'Dl';
            case 2: return 'Dm';
            case 3: return 'Dc';
            case 4: return 'Dj';
            case 5: return 'Dv';
            case 6: return 'Ds';
            case 7: return 'Dg';
        }    
    else: 
        switch(date('N',$data)){
            case 1: return 'Dilluns';
            case 2: return 'Dimarts';
            case 3: return 'Dimecres';
            case 4: return 'Dijous';
            case 5: return 'Divendres';
            case 6: return 'Dissabte';
            case 7: return 'Diumenge';
        }        
    endif; 
  }

  public function Paginacio($pager,$url){
    
    $RET = "";
    if ($pager->haveToPaginate()):
        $RET .= link_to('&laquo;', $url.'&P='.$pager->getFirstPage());
        $RET .= link_to('&lt;', $url.'&P='.$pager->getPreviousPage());
        $links = $pager->getLinks(20);                 
        foreach ($links as $page):
            $RET .= ($page == $pager->getPage()) ? $page : link_to($page, $url.'&P='.$page);
            if ($page != $pager->getCurrentMaxLink()): $RET .= '-'; endif;
        endforeach;
      $RET .= link_to('&gt;', $url.'&P='.$pager->getNextPage());
      $RET .= link_to('&raquo;', $url.'&P='.$pager->getLastPage());
    endif;

    return $RET;

  }
    	
  /**
   * myUser::ParReqSesForm()
   * 
   * Comprova els paràmetres del request i l'actualtiza amb la sessió.
   * Si existeix al request, el guarda en sessió i el retorna.
   * Si no existeix al request, retorna el de sessió. 
   * Si tampoc existeix a la sessió retorna el default.  
   * 
   * @param mixed $request
   * @param mixed $nomCamp
   * @param mixed $default
   * @return
   */
  public function ParReqSesForm($request,$nomCamp,$default)
  {
  	  	
  	$A = $this->getAttribute('sessio',array());
            	
  	if($request->hasParameter($nomCamp)):
  		$par = $request->getParameter($nomCamp);
  	  	$A[$nomCamp] = $par;        
  	elseif(!isset($A[$nomCamp])):    
  	 	$A[$nomCamp] = $default;          		  		  		
  	endif;
               		
    $A[$nomCamp] = ($A[$nomCamp] == 'images')?$default:$A[$nomCamp];                       
                       		  	
  	$this->setAttribute('sessio',$A);  	  	  	  	  	 
               	  	    
  	return $A[$nomCamp];  	  	
  	
  }
  
  /**
   * myUser::setSessionPar()
   *
   * Actualitza un paràmetre de la sessió
   *  
   * @param mixed $nomCamp
   * @param mixed $value
   * @return
   */
  public function setSessionPar($nomCamp,$value)
  {
  	
  	$A = $this->getAttribute('sessio');  	
  	$A[$nomCamp] = $value;  	  	
  	$this->setAttribute('sessio',$A);
  	
  	return $value;
  	
  }
  
  /**
   * myUser::getSessionPar()
   * 
   * Carrega un paràmetre de la sessió 
   * 
   * @param mixed $nomCamp
   * @param string $default
   * @return
   */
  public function getSessionPar($nomCamp,$default = "")
  {
  	
  	$A = $this->getAttribute('sessio',array());
  	if(isset($A[$nomCamp])){ $NOM = $A[$nomCamp]; if($NOM == 'images') $NOM = $default; return $NOM; }
  	else return $default;
  	
  }

  /**
   * myUser::addLogAction()
   * 
   * Afegeix un registre al log amb alguna acció. Versió no estàtica. .
   * 
   * @param mixed $accio
   * @param mixed $model
   * @param mixed $dadesBefore
   * @param mixed $dadesAfter
   * @return void
   */
  public function addLogAction($accio,$model,$dadesBefore = null ,$dadesAfter = null)
  {        
    return self::addLogActionStatic($this->getSessionPar('idU'),$accio,$model,$dadesBefore,$dadesAfter);      	
  }  

  /**
   * myUser::addLogAction()
   * 
   * Afegeix un registre al log amb alguna acció.
   * 
   * @param mixed $accio
   * @param mixed $model
   * @param mixed $dadesBefore
   * @param mixed $dadesAfter
   * @return void
   */
  static public function addLogActionStatic($idU, $accio,$model,$dadesBefore = null ,$dadesAfter = null)
  {    
    
  	$time = date('Y-m-d H:i',time());
  
    $REG = "\n";
    $REG .= "<data>".$time."</data>";
    $REG .= "<usuari>".$idU."</usuari>";
    $REG .= "<accio>".$accio."</accio>";
  	$REG .= "<model>".$model."</model>";
    $REG .= "<before>".serialize($dadesBefore)."</before>";
    $REG .= "<after>".serialize($dadesAfter)."</after>";
          	  	  	  	  		  	
    file_put_contents('log.txt', $REG, FILE_APPEND);
  	
  }  



  /**
   * myUser::gestionaOrdre()
   * 
   * Funció estàtica que gestionar un ordre. 
   * Posa a la posició destí el que està a l'actual usant el mètode getOrdre()
   * 
   * @param mixed $desti
   * @param mixed $actual
   * @param mixed $idS
   * @param mixed $LO
   * @return
   */
  static public function gestionaOrdre( $desti , $actual , $idS , $LO )
  {   
     //Si el destí i actual són iguals, llavors no fem res. '
     if($desti == $actual) return null;
                                                                                  
     //Canvia l'ordre segons els intermitjos.
     foreach($LO as $O):
     
        $Ordre = $O->getOrdre();
                
        if($Ordre == $actual) $O->setOrdre($desti);                
        elseif($Ordre < $actual && $Ordre >= $desti && $actual > 0 ) $O->setOrdre($Ordre+1);
        elseif($Ordre <= $desti  && $Ordre >= $actual && $actual > 0 ) $O->setOrdre($Ordre-1);
        elseif($actual == 0 && $Ordre >= $desti) $O->setOrdre($Ordre+1); //És un nou node.        
        
	    $O->save();
     
     endforeach;
  }

  /**
   * myUser::selectOrdre()
   * 
   * Retorna un menú de Select amb els ordres actuals. 
   * Si és nou a més hi ha Ordre+1 que serà el nou ordre per defecte. 
   * 
   * @param mixed $idS
   * @param mixed $LOP
   * @param bool $NOU
   * @return
   */
  static function selectOrdre( $idS , $LOP  , $NOU = false )
  {     
     $RET = array();          
     
     $last = 1; $i = 1;
     
     foreach($LOP as $OP){
       $RET[$OP->getOrdre()] = $i++;
       $last = $OP->getOrdre()+1;         
     }          
     
     //Si és nou hi afegim un número més.
     if($NOU) { $RET[$last] = $last; }
     
     return $RET;            
  }

  /**
   * myUser::resizeImage()
   * 
   * Funció estàtica que canvia la mida d'una imatge carregada amb un input file. 
   *  
   * @param mixed $x
   * @param mixed $y
   * @param mixed $BASE
   * @param mixed $imatge_actual
   * @param mixed $new_name
   * @param mixed $borrar
   * @return
   */
  static public function resizeImage($x,$y,$BASE,$imatge_actual,$new_name,$borrar)
  {	    
	if(!empty($imatge_actual) && file_exists($BASE.$imatge_actual)):          				
	  	$img = new sfImage($BASE.$imatge_actual,'image/jpg');  	
	    $img->resize($x,$y);
	    $nomf = $new_name.'.jpg';
	    $img->saveAs($BASE.$nomf);
	    if( $imatge_actual <> $new_name && $borrar ) unlink( $BASE.$imatge_actual );
        return $nomf;
    endif;
    return false;
  }
  
  /**
   * myUser::getFacebookHeaders()
   * 
   * Genera els headesr per a poder usar els botons de Like
   * 
   * @param mixed $title
   * @param mixed $url_web
   * @param mixed $url_img
   * @param mixed $site_name
   * @param mixed $facebookID
   * @return
   */
  static public function getFacebookHeaders($title, $url_web, $url_img, $site_name, $facebookID )
  {
    $RS = '';
    $RS .= '<meta property="og:title" content="'.addslashes($title).'" />';
    $RS .= '<meta property="og:type" content="activity" />';
    $RS .= '<meta property="og:url" content="'.$url_web.'" />';
    $RS .= '<meta property="og:image" content="'.$url_img.'" />';
    $RS .= '<meta property="og:site_name" content="'.addslashes($site_name).'" />';
    $RS .= '<meta property="fb:admins" content="'.$facebookID.'" />';
    return $RS;
  }
  
  static public function text2url($string)
  {                
	$string = preg_replace("`\[.*\]`U","",$string);
	$string = preg_replace('`&(amp;)?#?[a-z0-9]+;`i','-',$string);
	$string = htmlentities($string, ENT_COMPAT, 'utf-8');
	$string = preg_replace( "`&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);`i","\\1", $string );
	$string = preg_replace( array("`[^a-z0-9]`i","`[-]+`") , "-", $string);
	return strtolower(trim($string, '-')); 
  }  
  
  
  /**
   * Genera un objecte facebook per a l'aplicatiu de la CCG
   * @return Object Facebook()
   * */
  static public function getFbObject()
  {    
    $facebook = new Facebook(array(
      'appId' => '118293361522662',
      'secret' => '186aca12e3c6d36c2a8f45c9acc8545b',
      'cookie' => true
    ));
    
    return $facebook;
  }  
  

  /**
   * Facebook Auth
   * @return array('id' = 0,'logUrl')
   * */    
  static public function f_FbAuth($logout = false , $redirect_uri = null)
  {            
    
    $RET = array( 'user' => 0 , 'logUrl' => '' );
    $A = array('redirect_uri'=>$redirect_uri);
    
    #Creem l'objecte facebook        
    $facebook = myUser::getFbObject();       
    
    # Carreguem l'usuari que tenim en sessió (0 si no existeix)
    $uid = $facebook->getUser();
    
    # Generem la url de login
    $RET['logUrl'] = $facebook->getLoginUrl($A);

    # Si l'usuari existeix en sessió, carreguem les seves dades
    if($uid){
        try {
            #Provem a veure si l'usuari existeix
            $RET['user'] = $facebook->api('/me');
          } catch (FacebookApiException $e) {}
    }     
    
    return $RET;
  
  }
  
  static public function sendMail($from,$to,$subject,$body = "",$files = array())
    {    
        //Si entrem un mail que no és en format array, l'inicialitzem
        $mails = $to;
        if(!is_array($to)) $mails = array($to);
        
        //Definim el mailer
    //        $t = Swift_SmtpTransport::newInstance('smtp.casadecultura.org',587);
    //        $t->setUsername('informatica@casadecultura.org');
    //        $t->setPassword('gi1807bj');
        $t = Swift_MailTransport::newInstance();
        $mailer = Swift_Mailer::newInstance($t);
        
        //Enviem tots els correus         
        foreach($mails as $to):
        
            //Comencem l'enviament de correus als que el tinguin correcte.
       	    try{
                
        		$sm = Swift_Message::newInstance($subject,$body,'text/html','utf8');
                $sm->setFrom($from);
                $sm->setTo($to);
        		
        		foreach($files as $F):
        			$sm->attach(Swift_Attachment::fromPath($F['tmp_name']));
        		endforeach;        		        			    
            	
        		$OK = $mailer->send($sm,$errors);                                                
            
            } catch (Exception $e) { $OK = false; myUser::addLogActionStatic(0,'ErrorEnviantMailSaveMissatgeGlobal',$e->getMessage(),null); }                        
            
        endforeach;
    	
        return array('OK'=>$OK,'MAILS_INC'=>$errors);
    }
    
    static public function Html2PDF($HTML){                        
        include(OptionsPeer::getString( 'SF_DOMPDF_CONFIG' , 1 ) );                                                                
        $dompdf = new DOMPDF();
        $dompdf->load_html($HTML);
        $dompdf->set_paper("A4","portrait");
        $dompdf->render();
        $dompdf->stream("/tmp/document.pdf");
    }           
    
    /**
     * Agafa tots els usuaris de l'entitat i hi guarda la línia.   
     * @param $accio = Quina acció ha realitzat ( Alta , baixa, etc... )
     * @param $ON = A quina part de l'aplicatiu
     * @param $qui = Qui ha fet aquesta acció
     * @param $idS = Entitat que està fent l'acció
     * @param Accions: Contactes, Taulell, Material, Cessió, Reserva d'espais, Incidències, Horaris ( canvi ), Cursos, Matrícula, Cicle, Entrada, Usuari, email-llista, Notícia, 
     * */
    static public function addLogTimeline( $accio , $ON , $qui , $idS , $idElement )
    {
   	 
        $A_OUS = UsuarisSitesPeer::getSitesUsers($idS);                                
        
        //Per cada usuari, guardem al seu registre
        foreach($A_OUS as $OUS):
        
            $time = time();
      
            $REG  = "<dades>";
            $REG .=  "<quan>".$time."</quan>";
            $REG .=  "<accio>".$accio."</accio>";
            $REG .=  "<lloc>".$ON."</lloc>";
            $REG .=  "<qui>".$qui."</qui>";
          	$REG .=  "<site>".$idS."</site>";        
            $REG .=  "<id>".$idElement."</id>";
            $REG .= "</dades>".PHP_EOL;
                  	  	  	  	  		  	
            file_put_contents(getcwd().'/timelines/log_'.$OUS->getUsuariId().'.txt', $REG, FILE_APPEND);
            file_put_contents(getcwd().'/timelines/log_general.txt', $REG, FILE_APPEND);
        
        endforeach;                     

    }
    

    /**
     * Agafa un fitxer de timeline i retorna les dades en format d'array.   
     * @param $accio = Quina acció ha realitzat ( Alta , baixa, etc... )
     * @param $ON = A quina part de l'aplicatiu
     * @param $qui = Qui ha fet aquesta acció
     * @param $idS = Entitat que està fent l'acció
     * @param Accions: Contactes, Taulell, Material, Cessió, Reserva d'espais, Incidències, Horaris ( canvi ), Cursos, Matrícula, Cicle, Entrada, Usuari, email-llista, Notícia, 
     * */
    static public function getLogTimeline( $idU , $idS )
    {
   	         
        $ARXIU = file_get_contents(getcwd().'/timelines/log_'.$idU.'.txt');        
        $dades = simplexml_load_string('<info>'.$ARXIU.'</info>');                
        $RET = array();
        
        foreach($dades->dades as $id => $E):
                
            $L = (string)$E->lloc;                        
            $RET[$L][] = $E;                                    
        
        endforeach;
        
        if($idU == 1):

            $ARXIU = file_get_contents(getcwd().'/timelines/log_0.txt');        
            $dades = simplexml_load_string('<info>'.$ARXIU.'</info>');                            
            
            foreach($dades->dades as $id => $E):
                    
                $L = (string)$E->lloc;                        
                $RET[$L][] = $E;                                    
            
            endforeach;

        endif;
        
        
        return $RET;
                             
    }

    /**
     * Aquesta funció deixa el fitxer de l'usuari buit.          
     * */
    static public function setEmptyTimeline( $idU )
    {   
        //Si és l'usuari 1, també buida les novetats de l'Hospici.
        if($idU == 1){ file_put_contents(getcwd().'/timelines/log_0.txt',""); }
        return file_put_contents(getcwd().'/timelines/log_'.$idU.'.txt',"");                                                              
    }

    
}