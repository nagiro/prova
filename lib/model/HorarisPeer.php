<?php

/**
 * Subclass for performing query and update operations on the 'horaris' table.
 *
 * 
 *
 * @package lib.model
 */ 
class HorarisPeer extends BaseHorarisPeer
{

  const DESCRIPCIO_WEB = "WEB"; 	

  /**
   * Funció que fa la cerca pel calendari de la pàgina principal i omple l'agenda
   *
   * @param unknown_type $DIA
   * @param unknown_type $TEXT
   * @param unknown_type $DATAI
   * @param unknown_type $DATAF
   * @param unknown_type $IDACTIVITAT
   * @return unknown
   */
  static public function getCerca($DIA, $TEXT, $DATAI, $DATAF, $IDACTIVITAT)
  {
     $HORARIS = self::cerca($DIA, $TEXT, $DATAI, $DATAF, $IDACTIVITAT);
     $RET = array( 'CALENDARI'=>array() , 'ACTIVITATS' => array() );    
     $RET['CALENDARI'] = self::calendari($HORARIS);     
     $ANT = "";
     foreach($HORARIS as $H):
        if($ANT <> $H->getActivitatsActivitatid()) {           
           $A = $H->getActivitats();
           
           $titol = $A->getTweb();
           if(!empty($titol)){           
	           $RET['ACTIVITATS'][$H->getActivitatsActivitatid()]['TITOL'] = $titol; 
	           $RET['ACTIVITATS'][$H->getActivitatsActivitatid()]['TEXT'] = $A->getDweb();
	           $RET['ACTIVITATS'][$H->getActivitatsActivitatid()]['DIES'][] = $H->getDia('d/m/Y');
           } 
        } else {
           if(isset($RET['ACTIVITATS'][$H->getActivitatsActivitatid()]))
              $RET['ACTIVITATS'][$H->getActivitatsActivitatid()]['DIES'][] = $H->getDia('d/m/Y');
        }
        
        $ANT = $H->getActivitatsActivitatid();        
     endforeach;
     
     return $RET;
     
  }
  
  static public function getActivitatsGrouped($DIA, $TEXT, $DATAI, $DATAF, $IDACTIVITAT)
  {
     $RET = array(); $ANT = "";
     $HORARIS = self::cerca($DIA, $TEXT, $DATAI, $DATAF, $IDACTIVITAT);
     $RET['CALENDARI'] = self::calendari($HORARIS);
     $RET['ACTIVITATS'] = array();
     
     foreach($HORARIS as $H):
        if($ANT <> $H->getActivitatsActivitatid()) $RET['ACTIVITATS'][] = $H->getActivitatsActivitatid();
        $ANT = $H->getActivitatsActivitatid();        
     endforeach;
     
     return $RET;
  }
 	
 
  static public function getCalendari($DIA , $TEXT, $DATAI, $DATAF, $IDACTIVITAT, $GESTIO)
  {
     return self::calendari(self::cerca($DIA , $TEXT, $DATAI, $DATAF, $IDACTIVITAT),$GESTIO);
  }
  
  static public function getActivitats($DIA , $TEXT, $DATAI, $DATAF, $IDACTIVITAT)
  {
    
    $HORARIS = self::cerca($DIA , $TEXT, $DATAI, $DATAF, $IDACTIVITAT);     
    $RET = ARRAY('ACTIVITATS'=>array(),'CALENDARI'=>array());
    $RET['CALENDARI'] = self::calendari($HORARIS);
    $RET['ACTIVITATS'] = self::activitats($HORARIS);
    
    return $RET;
  
  }
  
  static private function activitats($HORARIS)
  {

      $RET = array();
      foreach($HORARIS as $H):     
          $OActivitats = $H->getActivitats();            
	      $RET[$H->getHorarisid()]['ID'] = $OActivitats->getActivitatid();   //Guardem les activitats
	      $RET[$H->getHorarisid()]['NOM_ACTIVITAT'] = $OActivitats->getNom();   //Guardem les activitats	      
	      $RET[$H->getHorarisid()]['DIA'] = $H->getDia();   //Guardem les activitats
	      $RET[$H->getHorarisid()]['HORA_INICI'] = $H->getHorainici();   //Guardem les activitats
	      $RET[$H->getHorarisid()]['AVIS'] = $H->getAvis();   //Carreguem l'avís per si de cas      
	      foreach($H->getHorarisespaiss() as $HE):          
	      	$RET[$H->getHorarisid()]['ESPAIS'][] = (is_null($HE->getEspais()))?"":$HE->getEspais()->getNom();   //Guardem les activitats      	
	      	$RET[$H->getHorarisid()]['MATERIAL'][] = (is_null($HE->getMaterial()))?"":$HE->getMaterial()->getNom();      	
	      endforeach;
	   endforeach;
	   return $RET;
     
  }
  
  static private function calendari($HORARIS,$GESTIO = true)
  {     
      $RET = array(); $titol = "";
      foreach($HORARIS as $H):
         if($GESTIO): 
            $titol = $H->getActivitats()->getNom();
         else:	         
	        $titol = $H->getActivitats()->getTweb();	        	         
         endif;             
         if(!empty($titol)):              
            $dia = mktime(0,0,0,$H->getDia('m'),$H->getDia('d'),$H->getDia('Y'));
	        $RET[$dia][$H->getActivitatsActivitatid()]['TITOL'] =  $titol; //Guardem el dia que es fa l'activitat      
		    $RET[$dia][$H->getActivitatsActivitatid()]['HORA']  = $H->getHorainici(); //Guardem el dia que es fa l'activitat
	     endif;	     
      endforeach;
      return $RET;
  } 
  
  static private function cerca($DIA , $TEXT, $DATAI, $DATAF, $IDACTIVITAT)
  {
         
    $C = new Criteria();
    if( $DIA != NULL ) $C->add(self::DIA, $DIA);
    elseif( $DATAI != NULL && $DATAF != NULL ) {
      $data1 = $C->getNewCriterion(self::DIA, $DATAI , CRITERIA::GREATER_EQUAL);
      $data2 = $C->getNewCriterion(self::DIA, $DATAF , CRITERIA::LESS_EQUAL);
      $data1->addAnd($data2);
      $C->add($data1);
    }
    
    foreach(explode(' ',$TEXT) as $PARAULA):
      
      $PARAULA = trim($PARAULA);
    
      if( strlen($PARAULA) > 2 ) {
        $text1Criterion = $C->getNewCriterion(ActivitatsPeer::NOM, '%'.$TEXT.'%', CRITERIA::LIKE);
        $text2Criterion = $C->getNewCriterion(ActivitatsPeer::TGENERAL , '%'.$TEXT.'%' , CRITERIA::LIKE );
        $text3Criterion = $C->getNewCriterion(ActivitatsPeer::DGENERAL , '%'.$TEXT.'%' , CRITERIA::LIKE );
        $text1Criterion->addOr($text2Criterion);
        $text1Criterion->addOr($text3Criterion);
        $C->add($text1Criterion);
      }
    endforeach;
        
    if( $IDACTIVITAT != NULL ) $C->add(ActivitatsPeer::ACTIVITATSACTIVITATSID, $IDACTIVITAT, CRITERIA::EQUAL ); //Si enviem una idActivitat, la carreguem
    
    $C->addDescendingOrderByColumn(self::DIA);   //Ordenem per data
    $C->addDescendingOrderByColumn(self::HORAINICI);   //Ordenem per data
    $C->setLimit(200);    
    
    return self::doSelectJoinAll($C);
    
  } 
 
   /**
    * Espai per estadístics
    */
   
  
  static public function getMesosEspais($any)
  {
     $RET = array(array(array()));
     $SQL = "
     	SELECT MONTH(".self::DIA.") as mes,".HorarisespaisPeer::ESPAIS_ESPAIID." as espai,".self::ACTIVITATS_ACTIVITATID." as activitat
     	  FROM ".self::TABLE_NAME.", ".HorarisespaisPeer::TABLE_NAME."
     	 WHERE ".self::HORARISID." = ".HorarisespaisPeer::HORARIS_HORARISID."
     	   AND YEAR(".self::DIA.") = '$any'          
     ";
     $con = Propel::getConnection();
     $stmt = $con->createStatement();
     $rs = $stmt->executeQuery($SQL,ResultSet::FETCHMODE_ASSOC);

     while($rs->next()):
        if(isset($RET[$rs->get('mes')][$rs->get('espai')][$rs->get('activitat')]))                        
           $RET[$rs->get('mes')][$rs->get('espai')][$rs->get('activitat')] += 1;
        else
           $RET[$rs->get('mes')][$rs->get('espai')][$rs->get('activitat')] = 0;
     endwhile;
     
     return $RET;     
  } 
  
  
  static public function getMesosDiesEspai($any,$espai)
  {
     $RET = array();
     $SQL = "
     	SELECT MONTH(".self::DIA.") as mes, DAY(".self::DIA.") as dia ,".self::ACTIVITATS_ACTIVITATID." as activitat
     	  FROM ".self::TABLE_NAME.", ".HorarisespaisPeer::TABLE_NAME."
     	 WHERE ".self::HORARISID." = ".HorarisespaisPeer::HORARIS_HORARISID."
     	   AND YEAR(".self::DIA.") = '$any'          
           AND ".HorarisespaisPeer::ESPAIS_ESPAIID." = $espai
     ";
     $con = Propel::getConnection();
     $stmt = $con->createStatement();
     $rs = $stmt->executeQuery($SQL,ResultSet::FETCHMODE_ASSOC);

     while($rs->next()):                        
        if(isset($RET[$rs->get('mes')][$rs->get('dia')][$rs->get('activitat')]))
           $RET[$rs->get('mes')][$rs->get('dia')][$rs->get('activitat')] += 1;
        else
           $RET[$rs->get('mes')][$rs->get('dia')][$rs->get('activitat')] = 0;        
     endwhile;
     
     return $RET;     
  }  
  
}