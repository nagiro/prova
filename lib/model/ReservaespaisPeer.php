<?php

/**
 * Subclass for performing query and update operations on the 'reservaespais' table.
 *
 * 
 *
 * @package lib.model
 */ 
class ReservaespaisPeer extends BaseReservaespaisPeer
{

  const EN_ESPERA = 0;
  const ACCEPTADA = 1;
  const DENEGADA  = 2; 
  const ANULADA   = 3;
  const PENDENT_CONFIRMACIO = 4;
  const ESBORRADA = 5;  

  
  static function selectEstat()
  {
     return array(
                    self::EN_ESPERA => 'En espera' ,
                    self::ACCEPTADA => 'Acceptada' ,
                    self::DENEGADA  => 'Denegada',
                    self::ANULADA   => 'Anul·lada',
                    self::PENDENT_CONFIRMACIO => 'Pendent d\'acceptar condicions',
                    self::ESBORRADA => 'Esborrada', 
     );
  }
  
  /**
    * Mostra les reserves pendents que tenim
    *
    * @param int $Pagina
    * @return Reservaespais
    */
   static function getReservesPendents()
   {
      $C = new Criteria();
      $C->add( ReservaespaisPeer::ESTAT , ReservaespaisPeer::EN_ESPERA , CRITERIA::EQUAL);
      return ReservaespaisPeer::doSelect($C);
   }
   
   static function getReservesSelect($CERCA = "" , $Pagina = 1)
   {
      $C = new Criteria();
      if(!empty($CERCA)):
      
	      $C1 = $C->getNewCriterion(self::NOM , '%'.$CERCA.'%', CRITERIA::LIKE);
	      $C2 = $C->getNewCriterion(self::REPRESENTACIO , '%'.$CERCA.'%', CRITERIA::LIKE);
	      $C3 = $C->getNewCriterion(self::RESPONSABLE , '%'.$CERCA.'%', CRITERIA::LIKE);
	      $C4 = $C->getNewCriterion(self::PERSONALAUTORITZAT , '%'.$CERCA.'%', CRITERIA::LIKE);
	      $C5 = $C->getNewCriterion(self::ORGANITZADORS , '%'.$CERCA.'%', CRITERIA::LIKE);
	      $C6 = $C->getNewCriterion(self::DATAACTIVITAT , '%'.$CERCA.'%', CRITERIA::LIKE);
	      	      	      
	      $C7 = $C->getNewCriterion(UsuarisPeer::NOM , '%'.$CERCA.'%', CRITERIA::LIKE);
	      $C8 = $C->getNewCriterion(UsuarisPeer::DNI , '%'.$CERCA.'%', CRITERIA::LIKE);
	      $C9 = $C->getNewCriterion(UsuarisPeer::COG1 , '%'.$CERCA.'%', CRITERIA::LIKE);
	      $C10 = $C->getNewCriterion(UsuarisPeer::COG2 , '%'.$CERCA.'%', CRITERIA::LIKE);
	            
	      $C1->addOr($C2); $C1->addOr($C3); $C1->addOr($C4); $C1->addOr($C5); $C1->addOr($C6); 
	      $C1->addOr($C7); $C1->addOr($C8); $C1->addOr($C9); $C1->addOr($C10);
	      
	      $C->add($C1);                            
	      
	  endif;
            
      $C->add(self::ESTAT, self::ESBORRADA, CRITERIA::NOT_EQUAL);
      $C->addDescendingOrderByColumn(self::DATAALTA);
      
                 
      $P = new sfPropelPager('Reservaespais', 20);
      $P->setPeerMethod('doSelectJoinUsuaris');
      $P->setCriteria($C);
      $P->setPage($Pagina);
      $P->init();
      return $P;      
            
   }
   
   
   /**
    * Funció que retorna un pager amb totes les reserves que s'han demanat ordenades per data d'entrada
    *
    * @param int $Pagina
    * @return sfPropelPager
    */
   static function getReserves($Pagina = 0)
   {
        $C = new Criteria();           
        $P = new sfPropelPager('Reservaespais', 10);
        $P->setCriteria($C);
        $P->setPage($Pagina);
        $P->init();
        return $P; 
   }
   
   /**
    * Funció que retorna les reserves que ha fet un usuari
    *
    * @param int $idU
    * @return Reservaespais
    */
   static function getReservesUsuaris($idU)
   {
      $C = new Criteria();
      $C->add(ReservaespaisPeer::USUARIS_USUARIID , $idU);
      return ReservaespaisPeer::doSelect($C);
   }
   
   /**
    * Desa un registre
    *
    * @param array $D
    * @param int $IDU
    * @param int $IDR
    * @return bool/Reservaespais
    */
   static function save( $D = array(), $IDU = 0 , $IDR = 0 )   
   {
      $R = new Reservaespais(); $RETURN = array();
      
      if($IDR > 0) { $R = ReservaespaisPeer::retrieveByPK($IDR);  $R->setNew(false);  }
       
      if($IDU > 0) $R->setUsuarisUsuariid($IDU);
      if(!empty($D['REPRESENTACIO'])) $R->setRepresentacio($D['REPRESENTACIO']);
      if(!empty($D['RESPONSABLE'])) $R->setResponsable($D['RESPONSABLE']);
      if(!empty($D['PERSONALAUTORITZAT'])) $R->setPersonalautoritzat($D['PERSONALAUTORITZAT']);
      if(!empty($D['PREVISIOASSISTENTS'])) $R->setPrevisioassistents($D['PREVISIOASSISTENTS']);
      if(!empty($D['ESCICLE'])) $R->setEscicle($D['ESCICLE']);
      if(!empty($D['EXEMPCIO'])) $R->setExempcio($D['EXEMPCIO']);
      if(!empty($D['PRESSUPOST'])) $R->setPressupost($D['PRESSUPOST']);
      if(!empty($D['COLLABORACIO'])) $R->setColaboracioccg($D['COLLABORACIO']);
      if(!empty($D['COMENTARIS'])) $R->setComentaris($D['COMENTARIS']);
      if(!empty($D['ESTAT'])) $R->setEstat($D['ESTAT']); else $R->setEstat(self::EN_ESPERA);
      if(!empty($D['DATAALTA'])) $R->setDataalta(date('Y-m-d',time()));
      if(!empty($D['ORGANITZADORS'])) $R->setOrganitzadors($D['ORGANITZADORS']);
      if(!empty($D['DATAACTIVITAT'])) $R->setDataactivitat($D['DATAACTIVITAT']);
      if(!empty($D['HORARIACTIVITAT'])) $R->setHorariactivitat($D['HORARIACTIVITAT']);
      if(!empty($D['TIPUSACTE'])) $R->setTipusacte($D['TIPUSACTE']);
      if(!empty($D['NOM'])) $R->setNom($D['NOM']);
      if(!empty($D['ISENREGISTRABLE'])) $R->setIsenregistrable($D['ISENREGISTRABLE']);
      if(!empty($D['ESPAIS'])) $R->setEspaissolicitats(implode('@',$D['ESPAIS']));
      if(!empty($D['MATERIAL'])) $R->setMaterialsolicitat(implode('@',$D['MATERIAL']));
      $R->setDataalta(date('Y-m-d',time()));
      $ERRORS = $R->check(); if(empty($ERRORS)) { $R->save(); }      
      return $R;
            
   }
      
   static function getNextCodi()
   {
   		$C = new Criteria();
   		$C->addDescendingOrderByColumn(self::RESERVAESPAIID);   		
   		$OO = self::doSelectOne($C);
           		   		   		
   		$O2 = "";
   		if($OO instanceof Reservaespais):
            $O2 = $OO->getReservaespaiid().date('m',time()).date('Y',time());
        else: 
            $O2 = '0'.date('m',time()).date('Y',time());
        endif;  

   		return $O2;
   }
   
   static public function sendMailAnulacio($OR)
   {
    
    $Nom = $OR->getUsuaris()->getNomComplet();
    $DNI = $OR->getUsuaris()->getDni();
    $CODI = $OR->getCodi();
    
    $BODY = "El senyor/a {$Nom} amb DNI {$DNI} ha anul·lat la reserva amb codi {$CODI}"; 
          
	return $BODY; 
    
   }
   
   static public function sendMailNovaReserva($OR)
   {
    
    $Nom = $OR->getUsuaris()->getNomComplet();
    $DNI = $OR->getUsuaris()->getDni();
    $CODI = $OR->getCodi();
    
    $BODY = "El senyor/a {$Nom} amb DNI {$DNI} ha efectuat la reserva d'espai amb codi {$CODI}"; 
          
	return $BODY; 
        
   }
   
   static public function sendMailCondicions($OR, $PAREA, $PARER)
   {
  	
    $miss = $OR->getCondicionsccg();  	
  	$text = "";
  	$text .= '

        <table width="640px" style="font-family: sans-serif; font-size:14px; margin:0 auto; border:0px solid #B33330;">
        <tr><td align="center" style=" padding:20px;"><img width="200px" src="http://servidor.casadecultura.org/downloads/logos/CCG_BLANC.jpg" /></td></tr>
        <tr><td style="border-top:2px solid #B33330;padding: 20px; text-align: left;">
            '.$miss.'
            <br /><br />            
            <p><a target="_NEW" href="'.sfConfig::get('sf_webrooturl').'web/Formularis?PAR='.$PAREA.'">Si accepteu les condicions cliqueu aquest enllaç</a><br />
            <br />
            <a target="_NEW" href="'.sfConfig::get('sf_webrooturl').'web/Formularis?PAR='.$PARER.'">Si  voleu anul·lar la vostra sol·licitud o no accepteu les condicions, cliqueu aquest enllaç</a>
            </p>					
        <br /><br />
        <p>Cordialment, <br />Casa de Cultura de Girona</p>
        <br /><br />
        <p><span style="font-size:10px; font-style: italic; color: gray;">En cas de resposta afirmativa, les vostres dades seran incorporades a un fitxer titularitat de la Fundaci&oacute; Casa de Cultura creat sota la seva responsabilitat per a gestionar les activitats que s&rsquo;hi porten a terme i per a informar-ne a persones que hi estiguin interessades. La Casa de Cultura es compromet a complir els seus deures de mantenir reserva i d&rsquo;adoptar les mesures legalment previstes i les t&egrave;cnicament necess&agrave;ries per evitar-ne un acc&eacute;s o qualsevol classe de tractament no autoritzat. Podran ser cedides a altres persones amb les quals la Casa de Cultura col&bull;labora en la programaci&oacute; i organitzaci&oacute; d&rsquo;activitats, exclusivament a l&rsquo;efecte de fer-vos arribar la informaci&oacute; que vost&egrave; manifesta estar interessat en rebre. Per qualsevol altre cessi&oacute; requerir&iacute;em pr&egrave;viament el seu consentiment. En qualsevol cas podeu exercir els vostres drets d&rsquo;acc&eacute;s, rectificaci&oacute; i cancel&bull;laci&oacute; tot adre&ccedil;ant-se a: Sr/a. Director/a de la Casa de Cultura, Pla&ccedil;a de l&rsquo;Hospital 6, 17002 GIRONA, tel&egrave;fon 972 202 013 i correu electr&ograve;nic  secretaria@casadecultura.org.</span></p>
                
        </td></tr>
        </table>';
      				
   	return $text; 
    
   }

   static public function getCondicionsGeneric($OR)
   {
  	
  	$text = "";
  	$text .= '

        <p>Senyors,</p>
        <br />
        <p>D’acord amb la sol·licitud rebuda, la Fundació Casa de Cultura de Girona ha acordat la següent cessió d’espai a '.$OR->getRepresentacio().':</p> 
        <br /><br />
        <p><b>Espai:</b> '.$OR->getEspaisString().'<br />
        <b>Activitat:</b> '.$OR->getNom().'<br />
        <b>Dies:</b> '.$OR->getDataactivitat().'<br />
        <b>Horari:</b> '.$OR->getHorariactivitat().'<br />
        <b>Equipament:</b> No s’ha sol·licitat equipament<br /></p>
        <br /><br />
        <p><b>Despeses</b></p>
        <p>La Casa de Cultura de Girona, amb la voluntat de donar suport a aquesta activitat, eximeix l’organització de les despeses de cessió d’aquest espai que, segons les tarifes aprovades per la Junta Rectora de la Fundació, tindria un cost de 550 euros (IVA no inclòs).</p> 
        
        <p>Aquesta decisió de la Fundació de la Casa de Cultura no pressuposa l’exempció per a futures activitats, que seran avaluades en cada cas.</p>
        <br /><br />
        <p><b>Acceptació de condicions</b></p>
        <p>La cessió d’espai i equipaments no compromet el personal de la Casa de Cultura a donar assistència tècnica permanent a la vostra activitat ni a incloure-la en els seus materials de difusió.</p> 

    ';      				
   	return $text; 
    
   }

   
}
