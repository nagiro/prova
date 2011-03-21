<?php

/**
 * Subclass for performing query and update operations on the 'espais' table.
 *
 * 
 *
 * @package lib.model
 */ 
class EspaisPeer extends BaseEspaisPeer
{

  static public function getCriteriaActiu($C,$idS)
  {
    $C->add(self::ACTIU, true);
    $C->add(self::SITE_ID, $idS);
    return $C;
  }

  static public function initialize( $idE , $idS )
  {
    $OE = self::retrieveByPK($idE);            
	if(!($OE instanceof Espais)):
		$OE = new Espais();   		                    
        $OE->setSiteId($idS);        
        $OE->setActiu(true);        		            			    			    			        					
	endif;    
    
    return new EspaisForm($OE,array('IDS'=>$idS)); 
  }

  static public function select( $idS , $with_new = false )
  {
  	$C = new Criteria();
    $C = self::getCriteriaActiu($C,$idS);
    
  	$C->addAscendingOrderByColumn(self::ORDRE);
  	
    $Espais = self::doSelect($C);
    $RET = array();
    if($with_new) $RET['0'] = 'Nou espai...';
    foreach($Espais as $E):
      $RET[$E->getEspaiid()] = $E->getNom();    
    endforeach;
    
    return $RET;    
      
  }
  
  static public function selectJavascript( $idS , $sel = -1 )
  {

  	$C = new Criteria();
    $C = self::getCriteriaActiu($C,$idS);
    
  	$C->addAscendingOrderByColumn(self::ORDRE);
  	
    $Espais = self::doSelect($C);
  	
    $RET = "";
    foreach($Espais as $E):
    	$idE = $E->getEspaiid();
    	if($sel == $idE): $RET .= '<OPTION SELECTED value="'.$idE.'">'.$E->getNom().'</OPTION>';
    	else: $RET .= '<OPTION value="'.$idE.'">'.$E->getNom().'</OPTION>';
    	endif;    
    endforeach;    
    
    $RET = str_replace("'","\'",$RET);    
    
    return $RET;    
  	
  }


  /**
   * Usat al formulari ClientReservesPeer
   * */  
  static public function selectFormReserva($idS)
  {
    $RET = array();
    $C = new Criteria();
    $C = self::getCriteriaActiu($C,$idS);
    $C->add(EspaisPeer::ISLLOGABLE, true);
    $C->addAscendingOrderByColumn(self::ORDRE);
    foreach(self::doSelect($C) as $E):
    
        $RET[$E->getEspaiid()] = $E->getNom();
    
//        if($E->getEspaiid() >= 1 && $E->getEspaiid() < 6) $RET[$E->getEspaiid()] = $E->getNom();
//        if($E->getEspaiid() >= 9 && $E->getEspaiid() < 16) $RET[$E->getEspaiid()] = $E->getNom();
//        if($E->getEspaiid() == 19) $RET[$E->getEspaiid()] = $E->getNom();          
    
    endforeach;
    return $RET;
  }

  static public function getEspaisSite($idS)
  {
    $C = new Criteria();
    $C = self::getCriteriaActiu($C,$idS);
    $C->addAscendingOrderByColumn(self::ORDRE);
    return self::doSelect($C);
  }

  /**
   * EspaisPeer::getEstadistiquesEspais()
   * 
   * Entrem uns paràmetres de cerca i retorna un array amb l'ocupació d'espais
   * 
   * @param mixed $espais
   * @param mixed $site
   * @param mixed $month
   * @param mixed $year
   * @return
   */
  static public function getEstadistiquesEspais($espais = array(), $site, $month, $year)
  {
    
    $RET= array();
    if(!empty($espais)){
        $SQL = "
            SELECT H.Dia as d, HOUR(H.HoraPre) as hi, HOUR(H.HoraPost) as hf, E.EspaiID as idE, E.Nom as e_nom
              FROM espais E, horarisespais HE, horaris H 
             WHERE H.HorarisID = HE.Horaris_HorarisID 
               AND HE.Espais_EspaiID = E.EspaiID
               AND H.actiu = 1 AND E.actiu = 1 AND HE.actiu = 1
               AND H.site_id = $site                  
               AND MONTH(H.Dia) = '$month'
               AND YEAR(H.Dia) = '$year'
               AND HE.Espais_EspaiID in (".implode(',',$espais).")
             ORDER BY H.Dia Asc, idE, H.HoraPre Asc";
                                           
        $con = Propel::getConnection();
        $stmt = $con->prepare($SQL);
        $stmt->execute(); 
        $RET = array();
                 
        while($rs = $stmt->fetch(PDO::FETCH_OBJ)){
            $RET[$rs->d][$rs->idE][$rs->hi] = $rs->hf;    
        } 	
                        
        for($i = 1; $i < 31; $i++):
            $data = date('Y-m-d',strtotime($year.'-'.$month.'-'.$i));        
            foreach($espais as $idE):
                if(!isset($RET[$data][$idE])) $RET[$data][$idE][8] = 8; 
            endforeach;        
            ksort($RET[$data]);
        endfor;
        ksort($RET);
    }
    
    return $RET;
    
  }

}
