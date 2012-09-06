<?php

class myUser extends sfBasicSecurityUser
{
	
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
  
  
    
  static public function llistaCalendariV($DATAI, $CALENDARI)
  {
    
    //Inicialitzem variables i marquem els dies en blanc
    $Q = 3; 
    $mes  = date('m',$DATAI);
    $year = date('Y',$DATAI);
    $RET = "";
              
    $any = $year;
    $mesI = $mes;
    $mesF = $mes+$Q;      

    //Omplim els mesos
    $RET .= '<tr>'; $dies = array(); $IndexMes = 0;
    for($mes = $mesI; $mes < $mesF; $mes++):  
    
    	$mesReal = ($mes > 12)?($mes-12):$mes;
      	$anyReal = ($mes == 13)?$any+1:$any;
    
    	$week = 1; $IndexMes++; 
    	$diesMes = cal_days_in_month(CAL_GREGORIAN, $mesReal, $anyReal );
    	
    	for($dia = 1; $dia <= $diesMes; $dia++ ):
    	    	
    		$diaSetmana = jddayofweek(cal_to_jd(CAL_GREGORIAN, $mesReal , $dia , $anyReal) , 0 );
    		$diaSetmana = ($diaSetmana==0)?7:$diaSetmana;
    		    		 
    		$dies[$week][$diaSetmana][$IndexMes]['day'] = $dia;
    		$dies[$week][$diaSetmana][$IndexMes]['month'] = $mesReal;
    		$dies[$week][$diaSetmana][$IndexMes]['year'] = $anyReal;
    		
    		if($diaSetmana == 7) $week++;
    		
    	endfor;
    	    	
    	$RET .= "<TD class=\"titol_mes\" colspan=\"7\">".mesos($mesReal)."</TD><td width=\"20px\"></td>";
    	    
    endfor;
   
	$RET .= '</tr>';	

	$RET .= "<TR>";    
    for($i = 0; $i < $Q; $i++):
    	$RET .= "<TD>Dll</TD><TD>Dm</TD><TD>Dc</TD><TD>Dj</TD><TD>Dv</TD><TD>Ds</TD><TD>Dg</TD><TD></TD>";
    endfor;    
    $RET .= "</TR>";
        
    
    for($row = 1; $row <= 6; $row++):
    	$RET .= "<tr>";
	    for($col = 1; $col<=(7*$Q); $col++):    		
		
			$IndexMes = ceil($col / 7);
			$colR = $col - (7 * ($IndexMes-1));

			//Color de fons per diferenciar els mesos
			if($IndexMes % 2) $background = "beige"; else $background = "beige";
			
			//Color de fons per diferenciar els caps de setmana
			if( $colR == 6 || $colR == 7) $background="#CCCCCC";			 
						
			if(isset($dies[$row][$colR][$IndexMes])):

				$dades = $dies[$row][$colR][$IndexMes];
			
				$SPAN = ""; $color = "";
		        $CalDia = mktime(0,0,0,$dades['month'],$dades['day'],$dades['year']);
		        
		        if(isset($CALENDARI[$CalDia])):
		        	$SELECCIONAT = "SELECCIONAT";		        	
		        	$SPAN  = '<span><table id="TD1"><tr><th>Inici</th><th>Fi</th><th>Espai</th><th>Títol</th><th>Organitzador</th></tr>';				 
		          		foreach($CALENDARI[$CalDia] as $CAL) $SPAN .= '<tr><td>'.$CAL['HORAI'].'</td><td>'.$CAL['HORAF'].'</td><td>'.$CAL['ESPAIS'].'</td><td>'.$CAL['TITOL'].'</td><td>'.$CAL['ORGANITZADOR'].'</td></tr>';
		            $SPAN .= '</table></span>';
		        else: 
		        	$SELECCIONAT = "";
		        endif; 
		                                        
				$RET .= '<TD class="DIES" style="background-color:'.$background.';">'.link_to($dades['day'].$SPAN,"gestio/gActivitats?accio=CD&DIA=".$CalDia , array('class'=>"tt2 $SELECCIONAT")).'</TD>';
      																						
			else: 
				
				$RET .= '<TD class="DIES" style="background-color:'.$background.';"></TD>';
			
			endif; 			

			if($colR == 7): $RET .= '<td></td>'; endif; 
			
		endfor;        
		$RET .= "</tr>";
    endfor;
    
    $RET .= "</TR>";
	        
    return $RET;
      
  }
  
  

  static public function ParImpar($i){ if($i % 2 == 0) return "PAR"; else return "IPAR"; }
  
  
  /**
   * A partir d'una DataI generem els enllaços del menú
   * @param time() $DATAI
   * @return string
   */
  
  static public function getSelData($DATAI = NULL)
  {

     $MES = date('m',$DATAI); 
     $ANY = date('Y',$DATAI);            
     
     $RET = "";
     $RET = link_to($ANY-1,'gestio/gActivitats?accio=CC&DATAI='.mktime(0,0,0,1,1,$ANY-1),array('class'=>'negreta'))." ";
     for($any = $ANY ; $any < $ANY+2 ; $any++ ):
     	$RET .= link_to($any,'gestio/gActivitats?accio=CC&DATAI='.mktime(0,0,0,1,1,$any),array('class'=>'negreta'))." ";
     	for($mes = 1; $mes < 13; $mes++):
     		$RET .= link_to(mesosSimplificats($mes),"gestio/gActivitats?accio=CC&DATAI=".mktime(0,0,0,$mes,1,$any),array('class'=>'mesos_unit'))." ";
     	endfor;     
     endfor;
      
     return $RET;
     
  }
  
  static public function mesos($mes)  
  {
    switch($mes){
      case 1: $text = "Gener"; break;
      case 2: $text = "Febrer"; break;
      case 3: $text = "Març"; break;
      case 4: $text = "Abril"; break;
      case 5: $text = "Maig"; break;
      case 6: $text = "Juny"; break;
      case 7: $text = "Juliol"; break;
      case 8: $text = "Agost"; break;
      case 9: $text = "Setembre"; break;
      case 10: $text = "Octubre"; break;
      case 11: $text = "Novembre"; break;
      case 12: $text = "Desembre"; break;
    }
    
    return $text; //utf8_encode($text);
  
  }
  
  static public function mesosSimplificats($mes)  
  {
    switch($mes){
      case 1: $text = "G"; break;
      case 2: $text = "F"; break;
      case 3: $text = "M"; break;
      case 4: $text = "A"; break;
      case 5: $text = "M"; break;
      case 6: $text = "J"; break;
      case 7: $text = "J"; break;
      case 8: $text = "A"; break;
      case 9: $text = "S"; break;
      case 10: $text = "O"; break;
      case 11: $text = "N"; break;
      case 12: $text = "D"; break;
    }
    
    return utf8_encode($text);
  
  }
  
  static public function revDate($data){
    list($dia,$mes,$any) = explode('/',$data);
    return $any.'-'.$mes.'-'.$dia;
  }

    static public function ph_EstatCurs($AUTH, $OC, $url, $CURSOS_MATRICULATS){
        
        //L'usuari està autentificat?
        $AUTEN = (isset($AUTH) && $AUTH > 0);
                
        //Queden places al curs? 
        $HiHaPlaces =  !$OC->isPle();
        
        //Quan comença?                    
        $datai      =  $OC->getDatainmatricula('U');
        
        //La matrícula està activa
        $isActiu    =  $OC->getIsactiu();
        
        //L'alumne ja està matriculat?
        $JaMat      = (isset($CURSOS_MATRICULATS[$OC->getIdcursos()]));
        
        //Hi ha llista d'espera?
        $LLE        = $OC->getIsLlistaEspera(false);
                        
        $url        = url_for('@hospici_detall_curs?idC='.$OC->getIdcursos().'&titol='.$OC->getNomForUrl());
        $idS        = $OC->getSiteId();        
        $OS         = SitesPeer::retrieveByPK($idS);
        $nom        = $OS->getNom();
        $email      = $OS->getEmailString();
        $tel        = $OS->getTelefonString();
        $MatAntIdi  = CursosPeer::IsAnticAlumne($OC->getIdcursos(),$CURSOS_MATRICULATS);
        $dataiA     = mktime(0,0,0,9,12,2011);
        
        $RET = "";                                        
        
        //Si la data d'inici de matrícula és inferior a la d'avui, mostrem que encara no s'han iniciat les matrícules
        $avui = time();  

        //Si no està autentificat
        if( !$AUTEN ){
            
            return "NO_AUTENTIFICAT";
            
        //Ja està autentificat
        }else {

            //Ja ha estat matriculat
            if( $JaMat ){
                
                //Seleccionem la matrícula del curs que volem veure l'estat
                $OM = MatriculesPeer::retrieveByPK($CURSOS_MATRICULATS[$OC->getIdcursos()]);
                if($OM instanceof Matricules){
                    
                    //Si l'usuari ja està matriculat, doncs li marquem
                    if( MatriculesPeer::ACCEPTAT_NO_PAGAT == $OM->getEstat() || MatriculesPeer::ACCEPTAT_PAGAT == $OM->getEstat() ){
                        return "MATRICULAT";
                        
                    //L'usuari està en espera
                    } elseif(MatriculesPeer::EN_ESPERA == $OM->getEstat()) {
                        return "EN_ESPERA";
                        
                    //L'usuari està en espera'
                    } elseif(MatriculesPeer::RESERVAT == $OM->getEstat()) {
                        return "RESERVAT";
                    }
                } else {
                    
                    return "ANULADA";
                }                                                                                                
            
            //No està matriculat
            } else {
                
                //No queden places
                if( !$HiHaPlaces ){
                    
                    //No queden places però hi ha possibilitat de llista d'espera
                    if( $LLE ){
                        
                        return "LLISTA_ESPERA";
                        
                    }else{
                        
                        return "NO_HI_PLACES";
                            
                    }                                                        
                                        
                //Si no hi ha cap tipus de pagament extern, vol dir que no hi ha reserva en línia.
                } elseif( $OC->getPagamentextern() == "" ){
                    
                    return "NO_HI_HA_RESERVA_LINIA";
                
                //Encara no ha iniciat el període de matrícules.
                } elseif( $avui < $datai 
                            || ( data('d',$avui) == data('d',$datai) && data('m',$avui) == data('m',$datai) && date('H') < 9 ) ) {
                    
                    return "ABANS_PERIODE_MATRICULA";                    

                } elseif( $isActiu ) {
                    
                    return "CURS_INACTIU";

                //Si no és cap de les anteriors, pot matricular-se.
                } else {
                    
                    return "POT_MATRICULAR";
                                                                
                }                            
            }            
        }        
    }



    /**
     * Mostra les etiquetes amb els estats i accions dels cursos
     * @param $AUTEN Si l'usuari està autentificat o no
     * @param $OC Objecte Cursos
     * @param $url On s'ha d'anar si es clica l'enllaç
     * @return String
     * */
    static public function ph_getEtiquetaCursos($AUTH, $OC, $url, $CURSOS_MATRICULATS)
    {
        
        $ESTAT      = self::ph_EstatCurs($AUTH, $OC, $url, $CURSOS_MATRICULATS);
                
        $datai      =  $OC->getDatainmatricula('U');
        $avui       = time();        
        $JaMat      = (isset($CURSOS_MATRICULATS[$OC->getIdcursos()]));
        $url        = url_for('@hospici_detall_curs?idC='.$OC->getIdcursos().'&titol='.$OC->getNomForUrl());        
        
        $OS         = SitesPeer::retrieveByPK($OC->getSiteId());
        $nom        = $OS->getNom();
        $email      = $OS->getEmailString();
        $tel        = $OS->getTelefonString();
        $MatAntIdi  = CursosPeer::IsAnticAlumne($OC->getIdcursos(),$CURSOS_MATRICULATS);
        $dataiA     = mktime(0,0,0,9,12,2011);

        $RET = "";                                        
                          
        //Si no està autentificat
        if( $ESTAT == 'NO_AUTENTIFICAT' ){            
            $RET = ph_getRoundCorner('<a class="auth" href="'.$url.'">Autentifica\'t i matricula\'t</a>', '#FFCC00');
                        
        }elseif( $ESTAT == 'MATRICULAT' ){
            $RET  = '  <div class="tip" title="Vostè està matriculat correctament al curs.<br /><br /> Per a més informació ha de posar-se en contacte amb <b>'.$nom.'</b> enviant un correu electrònic a <b>'.$email.'</b> o bé trucant al <b>'.$tel.'</b>">';
            $RET .= ph_getRoundCorner('Ja hi esteu matriculat', '#29A729').'</div>';
            
        }elseif( $ESTAT == 'EN_ESPERA'){
            $RET  = '  <div class="tip" title="El curs està complet. La seva matrícula queda en llista d\'espera.<br /><br /> Per a més informació ha de posar-se en contacte amb <b>'.$nom.'</b> enviant un correu electrònic a <b>'.$email.'</b> o bé trucant al <b>'.$tel.'</b>">';
            $RET .= ph_getRoundCorner('En espera de plaça', '#F184DD').'</div>';

        }elseif( $ESTAT == 'RESERVAT'){
            $RET  = '  <div class="tip" title="Vostè ha realitzat la reserva al curs correctament. <br /><br /> Per a més informació ha de posar-se en contacte amb <b>'.$nom.'</b> enviant un correu electrònic a <b>'.$email.'</b> o bé trucant al <b>'.$tel.'</b>">';
            $RET .= ph_getRoundCorner('Plaça reservada', '#29A729').'</div>';            
                            
        }elseif( $ESTAT == 'ANULADA'){
            $RET  = '  <div class="tip" title="Vostè s\'ha matriculat en aquest curs, però s\'ha donat de baixa o el procés no s\'ha completat correctament. Matrícula sense efecte.<br /><br /> Per a més informació ha de posar-se en contacte amb <b>'.$nom.'</b> enviant un correu electrònic a <b>'.$email.'</b> o bé trucant al <b>'.$tel.'</b>">';
            $RET .= ph_getRoundCorner('Matrícula aunl·lada', '#CCCCCC').'</div>';               
        
        }elseif( $ESTAT == 'LLISTA_ESPERA'){                                    
            $RET  = '  <div class="tip" title="Aquest curs no disposa de més places.<br /><br /> Si vol pot matricular-s\'hi igualment i restarà en llista d\'espera. En el cas que s\'alliberi alguna plaça, que vostè pot ocupar, el trucarem el més aviat possible. Per a més informació, pot posar-se en contacte amb <b>'.$nom.'</b> enviant un correu electrònic a <b>'.$email.'</b> o bé trucant al telèfon <b>'.$tel.'</b>.<br /><br />Disculpi les molèsties.">';
            $RET .= ph_getRoundCorner('<a href="'.$url.'#matricula">Curs ple amb llista d\'espera</a>', '#EFAF01').'</div>';            

        }elseif( $ESTAT == 'NO_HI_PLACES'){                                    
            $RET  = '  <div class="tip" title="Aquest curs no disposa de més places.<br /><br /> Per a més informació, pot posar-se en contacte amb <b>'.$nom.'</b> enviant un correu electrònic a <b>'.$email.'</b> o bé trucant al telèfon <b>'.$tel.'</b>.<br /><br />Disculpi les molèsties.">';
            $RET .= ph_getRoundCorner('<a href="'.$url.'#matricula">Curs ple</a>', '#EF0101').'</div>';            
        
        }elseif( $ESTAT == 'NO_HI_HA_RESERVA_LINIA'){            
            $RET  = '  <div class="tip" title="Aquest curs no disposa de matrícula en línia.<br /><br /> Per poder-s\'hi matricular, ha de posar-se en contacte amb <b>'.$nom.'</b> enviant un correu electrònic a <b>'.$email.'</b> o bé trucant al telèfon <b>'.$tel.'</b>.<br /><br />Disculpi les molèsties.">';
            $RET .= ph_getRoundCorner('Matrícula presencial', '#CCCCCC').'</div>';
                        
        }elseif( $ESTAT == 'ABANS_PERIODE_MATRICULA_AA_IDIOMES'){                                    
            $RET  = '  <div class="tip" title="Vostè podrà matricular-se a aquest curs per internet a partir del dia '.date('d/m/Y',$dataiA).' si vol continuar els estudis d\'idiomes. Assegureu-vos que us matriculeu al curs que us correspon o la matrícula quedarà invalidada sense guardar plaça. <br /><br /> Per a més informació pot posar-se en contacte amb <b>'.$nom.'</b> enviant un correu electrònic a <b>'.$email.'</b> o bé trucant al <b>'.$tel.'</b>">';
            $RET .= ph_getRoundCorner('Tancada fins '.date('d/m/Y',$dataiA), '#CBAD85').'</div>';
            
        }elseif( $ESTAT == 'ABANS_PERIODE_MATRICULA'){                                    
            $RET  = '  <div class="tip" title="Vostè podrà matricular-se a aquest curs per internet a partir del dia '.date('d/m/Y',$datai).'.<br /><br /> Per a més informació pot posar-se en contacte amb <b>'.$nom.'</b> enviant un correu electrònic a <b>'.$email.'</b> o bé trucant al <b>'.$tel.'</b>">';
            $RET .= ph_getRoundCorner('Tancada fins '.date('d/m/Y',$datai), '#CBAD85').'</div>';
                        
        }elseif( $ESTAT == 'POT_MATRICULAR'){
            $RET = ph_getRoundCorner('<a href="'.$url.'#matricula">Matriculeu-vos</a>', '#FF8D00');
                        
        }elseif( $ESTAT == 'CURS_INACTIU'){
            $RET .= ph_getRoundCorner('Tancada fins '.date('d/m/Y',$datai), '#CBAD85').'</div>';
        }                
                
        return $RET;         
    }

    /**
     * Mostra les etiquetes amb els estats i accions dels horaris de les activitats
     * @param $AUTEN Si l'usuari està autentificat o no
     * @param $OC Objecte Cursos
     * @param $url On s'ha d'anar si es clica l'enllaç
     * @return String
     * */
    static public function ph_getEtiquetaActivitats($AUTH, $OA, $HORARIS_AMB_ENTRADES, $OH , $OEP )
    {
        
        $RET    = "";
        $idS    = $OH->getSiteId();
        $OS     = SitesPeer::retrieveByPK($idS);
        $nom    = $OS->getNom(); $email  = $OS->getEmailString(); $tel    = $OS->getTelefonString();
        
        //Està o no està autentificat? 
        $EstaAutentificat = (isset($AUTH) && $AUTH > 0);
        $url    = url_for('@hospici_detall_activitat?idA='.$OA->getActivitatid().'&titol='.$OA->getNomForUrl());
        
        if(!$EstaAutentificat){
            $RET = ph_getRoundCorner('<a class="auth" href="'.$url.'">Autentifica\'t i reserva</a>', '#FFCC00');
        } else {
            $JaHaCompratOReservat  = (isset($HORARIS_AMB_ENTRADES[$OH->getHorarisid()]));
            if( $JaHaCompratOReservat && !$OEP->getIsPle() ){
                $OER =  EntradesreservaPeer::retrieveByPK($HORARIS_AMB_ENTRADES[$OH->getHorarisid()]);
                if( $OER instanceof EntradesReserva ){

                    if($OER->getEstat() == EntradesreservaPeer::ESTAT_ENTRADA_CONFIRMADA){
                        $RET  = '<div class="tip" title="Vostè ha comprat o reservat '.$OER->getQuantitat().' entrades per aquesta activitat correctament. Tot i això pot comprar més entrades.<br /><br /> Per a més informació ha de posar-se en contacte amb <b>'.$nom.'</b> enviant un correu electrònic a <b>'.$email.'</b> o bé trucant al <b>'.$tel.'</b>">';
                        $RET  = myUser::ph_getEtiquetaActivitats_COMPRA($OEP,$RET).'</div>';                                                                    
                        
                    //L'usuari ha reservat                    
                    } elseif( $OER->getEstat() == EntradesreservaPeer::ESTAT_ENTRADA_RESERVADA ) {
                        $RET   = '  <div class="tip" title="Vostè ha reservat entrades que encara no han estat pagades o bé ha realitzat una prereserva d\'entrades. <br /><br /> En aquest cas, podrà adquirir més entrades un cop hagi realitzat el pagament corresponent en el cas que n\'hi hagi o bé per a més informació, posi\'s en contacte amb <b>'.$nom.'</b> enviant un correu electrònic a <b>'.$email.'</b> o bé trucant al <b>'.$tel.'</b>">';
                        $RET  .= ph_getRoundCorner('Reservat i no pagat', '#FF8D00').'</div>';
                    
                    //Té una entrada però ha estat anul·lada. 
                    } elseif($OER->getEstat() == EntradesreservaPeer::ESTAT_ENTRADA_ANULADA) {
                        $RET   = '  <div class="tip" title="Vostè ha reservat entrades però han estat anul·lades.<br /><br /> Per a més informació ha de posar-se en contacte amb <b>'.$nom.'</b> enviant un correu electrònic a <b>'.$email.'</b> o bé trucant al <b>'.$tel.'</b>">';
                        $RET  .= ph_getRoundCorner('Reserva anul·lada', '#FF1111').'</div>';
                    
                    //L'usuari està en espera'
                    } elseif($OER->getEstat() == EntradesreservaPeer::ESTAT_ENTRADA_EN_ESPERA) {
                        $RET   = '  <div class="tip" title="Vostè ha sol·licitat una reserva a una activiat que estava plena. Si s\'alliberen places, l\'informarem pertinentment. <br /><br /> Per a més informació ha de posar-se en contacte amb <b>'.$nom.'</b> enviant un correu electrònic a <b>'.$email.'</b> o bé trucant al <b>'.$tel.'</b>">';
                        $RET  .= ph_getRoundCorner('En espera', '#F184DD').'</div>';
                    }
                                        
                    //L'usuari està en espera
                    } else {
                        $RET   = '  <div class="tip" title="Hi ha hagut algun problema amb la seva compra. <br /><br /> Per a més informació ha de posar-se en contacte amb <b>'.$nom.'</b> enviant un correu electrònic a <b>'.$email.'</b> o bé trucant al <b>'.$tel.'</b>">';
                        $RET  .= ph_getRoundCorner('Error', '#FF1111').'</div>';
                    }
                    
            //Encara no ha fet cap compra o reserva d'entrades.                
            } else {
                                
                //Ja no queden entrades però hi ha llista d'espera
                if($OEP->getIsPle() && $OEP->hasLlistaEspera() ){
                    $RET  = '  <div class="tip" title="Aquesta activitat ha exhaurit les entrades però pot posar-se en llista d\'espera. Si en un futur s\'alliberen places, ens posarem en contacte amb vostè per si encara hi està interessat/da.<br /><br /> Per a més informació ha de posar-se en contacte amb <b>'.$nom.'</b> enviant un correu electrònic a <b>'.$email.'</b> o bé trucant al <b>'.$tel.'</b>">';
                    $RET .= ph_getRoundCorner( '<button name="BCOMPRA" style="background-color:inherit; border:0px; color:white;">Entrades exhaurides!</button>', '#EF0101' ).'</div>';                    
                } elseif( $OEP->getIsPle() && !$OEP->hasLlistaEspera() ) {
                    $RET  = '  <div class="tip" title="Aquesta activitat ha exhaurit les entrades.<br /><br /> Per a més informació ha de posar-se en contacte amb <b>'.$nom.'</b> enviant un correu electrònic a <b>'.$email.'</b> o bé trucant al <b>'.$tel.'</b>">';
                    $RET .= ph_getRoundCorner( 'Entrades exhaurides!', '#EF0101' ).'</div>';
                } else { 
                    $RET = myUser::ph_getEtiquetaActivitats_COMPRA($OEP,"");
                }                    
            }
        }                
                
        return $RET;         
    }

    static function ph_getEtiquetaActivitats_COMPRA($OEP,$RET){
        if( sizeof( $OEP->getPagamentextern() ) > 0 ){
            $RET .= ph_getRoundCorner('<button name="BCOMPRA" style="background-color:inherit; border:0px; color:white;">Compra!</button>', '#FF8D00');            
        } else {
            $RET .= ph_getRoundCorner('<a href="#">No disponible</a>', '#FF8D00');
        }      
        
        return $RET;                      
    }
    

    /**
     * Mostra les etiquetes amb els estats i accions del llistat d'activitats
     * @param $AUTEN Si l'usuari està autentificat o no
     * @param $OC Objecte Cursos
     * @param $url On s'ha d'anar si es clica l'enllaç
     * @return String
     * */
    static public function ph_getEtiquetaLlistatActivitats( $AUTH , $OA , $ACTIVITATS_AMB_ENTRADES )
    {
        //A partir d'una activitat mirem si l'usuari té alguna entrada per aquesta activitat.
        //Mirem si a alguna sessió es venen o reserven entrades i si en aquestes en queda alguna.  
        
        $idS    = $OA->getSiteId();
        $OS     = SitesPeer::retrieveByPK($idS);
        $nom    = $OS->getNom(); $email  = $OS->getEmailString(); $tel    = $OS->getTelefonString();
        
        //Està o no està autentificat? 
        $EstaAutentificat = (isset($AUTH) && $AUTH > 0);
        $url    = url_for('@hospici_detall_activitat?idA='.$OA->getActivitatid().'&titol='.$OA->getNomForUrl());
        
        if(!$EstaAutentificat){
            $RET = ph_getRoundCorner('<a class="auth" href="'.$url.'">Autentifica\'t i reserva</a>', '#FFCC00');
        } else {
            $JaHaCompratOReservat  = (isset($ACTIVITATS_AMB_ENTRADES[$OA->getActivitatid()]));
            if($JaHaCompratOReservat){
                $OER =  EntradesreservaPeer::retrieveByPK($ACTIVITATS_AMB_ENTRADES[$OH->getHorarisid()]);
                if( $OER instanceof EntradesReserva ){                    
                    if($OER->getEstat() == EntradesreservaPeer::ESTAT_ENTRADA_CONFIRMADA){
                        $RET  = '  <div class="tip" title="Vostè ha comprat o reservat entrades per aquesta activitat correctament.<br /><br /> Per a més informació ha de posar-se en contacte amb <b>'.$nom.'</b> enviant un correu electrònic a <b>'.$email.'</b> o bé trucant al <b>'.$tel.'</b>">';
                        $RET .= ph_getRoundCorner('Reserva confirmada', '#29A729').'</div>';
                    //L'usuari està en espera'
                    } elseif($OER->getEstat() == EntradesreservaPeer::ESTAT_ENTRADA_ANULADA) {
                        $RET  = '  <div class="tip" title="Vostè ha reservat entrades però han estat anul·lades.<br /><br /> Per a més informació ha de posar-se en contacte amb <b>'.$nom.'</b> enviant un correu electrònic a <b>'.$email.'</b> o bé trucant al <b>'.$tel.'</b>">';
                        $RET .= ph_getRoundCorner('Reserva anul·lada', '#F184DD').'</div>';
                    } elseif($OER->getEstat() == EntradesreservaPeer::ESTAT_ENTRADA_EN_ESPERA) {
                        $RET  = '  <div class="tip" title="Vostè ha sol·licitat una reserva o compra però encara no s\'ha tramitat. <br /><br /> Per a més informació ha de posar-se en contacte amb <b>'.$nom.'</b> enviant un correu electrònic a <b>'.$email.'</b> o bé trucant al <b>'.$tel.'</b>">';
                        $RET .= ph_getRoundCorner('En espera', '#F184DD').'</div>';
                    } 
                }
            //Encara no ha fet cap compra o reserva d'entrades.
            } else { 
                if(EntradesPreusPeer::isEntradesByActivitat($OA->getActivitatid()))
                    $RET = ph_getRoundCorner('<a href="'.$url.'#reserva">Compra o reserva!</a>', '#FF8D00');
                else $RET = ""; //"ph_getRoundCorner('<a href="'.$url.'#matricula">Consulta-les!</a>', '#FF8D00');                                         
            }                                                                    
        }                
                
        return $RET;         
    }



    /**
     * Mostra les etiquetes amb els estats i accions dels cursos
     * @param $AUTH Si l'usuari està autentificat o no     
     * @param $url On s'ha d'anar si es clica l'enllaç
     * @return String
     * */
    static public function ph_getEtiquetaReservaEspais($AUTH,$url){
        $RET = "";
        
        if( isset($AUTH) && $AUTH > 0 ):                                                                           
            $RET = '<div style="margin-top: 5px;">
                        <div class="requadre_mini" style="background-color: #FF8D00;">
                            <a href="'.$url.'">RESERVA L\'ESPAI</a>
                        </div>
                    </div>';                                                                                        
        else:
            $RET = '<div style="margin-top: 5px">
                        <div class="requadre_mini" style="background-color: #FFCC00;">                
                            <a class="auth" href="'.$url.'">Autentifica\'t i reserva</a>
                        </div>
                    </div>';
        endif;      
        
        return $RET;                  
        
    }


    /**
     * Mostra les etiquetes amb els estats i accions dels cursos
     * @param $AUTEN Si l'usuari està autentificat o no
     * @param $OC Objecte Cursos
     * @param $url On s'ha d'anar si es clica l'enllaç
     * @return String
     * */
    static public function ph_getEtiquetaFormulari( $AUTH, $OF , $idU )
    {
        
        $AUTEN  = (isset($AUTH) && $AUTH > 0);
        $isPle  = $OF->isOmplert($idU);                                         
        $url    = url_for('@hospici_formularis_detall?idF='.$OF->getIdformularis().'&titol='.$OF->getNomForUrl());
        $idS    = $OF->getSiteId();

        $OS     = SitesPeer::retrieveByPK($idS);
        $nom    = $OS->getNom();
        $email  = $OS->getEmailString();
        $tel    = $OS->getTelefonString();

        $RET    = "";                                                          

        //Si no està autentificat
        if( !$AUTEN ){
            
            $RET = ph_getRoundCorner('<a class="auth" href="'.$url.'">Autentifica\'t i omple\'l</a>', '#FFCC00');
            
        //Ja està autentificat
        }else {

            //Ja ha omplert el formulari
            if( $isPle ){
                                
                $RET  = '  <div class="tip" title="Vostè ja ha omplert aquest formulari correctament.<br /><br /> Per a més informació ha de posar-se en contacte amb <b>'.$nom.'</b> enviant un correu electrònic a <b>'.$email.'</b> o bé trucant al <b>'.$tel.'</b>">';
                $RET .= ph_getRoundCorner('<a class="link_compra" href="'.$url.'">Formulari omplert</a>', '#29A729').'</div>';                                                                                                                    
            
            //Encara no l'ha omplert            
            } else {
                              
                $RET = ph_getRoundCorner('<a href="'.$url.'">Omple el formulari</a>', '#FF8D00');
                                                                                    
            }
            
        }
                
        return $RET;         
    }
    
    static public function Html2PDF($HTML){                        
        include(OptionsPeer::getString( 'SF_DOMPDF_CONFIG' , 1 ) );                                                                
        $dompdf = new DOMPDF();
        $dompdf->load_html($HTML);
        $dompdf->set_paper("A4","portrait");
        $dompdf->render();
        $dompdf->stream("/tmp/document.pdf");
    }   


    
  
}