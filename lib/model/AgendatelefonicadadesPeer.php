<?php

/**
 * Subclass for performing query and update operations on the 'agendatelefonicadades' table.
 *
 * 
 *
 * @package lib.model
 */ 
class AgendatelefonicadadesPeer extends BaseAgendatelefonicadadesPeer
{    
   
  static function doSearch( $TEXT )
  {
    
     $C = new Criteria();
     $PARAULES = explode(" ",$TEXT); $PAR2 = array();
     foreach( $PARAULES as $P ) if( strlen( $P ) > 2 ): $PAR2[] = trim($P); endif;                      
     
     foreach( $PAR2 as $P ):
      
//      $text1Criterion = $C->getNewCriterion( AgendatelefonicadadesPeer::DADA , '%'.$P.'%', CRITERIA::LIKE);
      $text1Criterion = $C->getNewCriterion( AgendatelefonicaPeer::NOM , '%'.$P.'%', CRITERIA::LIKE);
      $text2Criterion = $C->getNewCriterion( AgendatelefonicaPeer::TAGS , '%'.$P.'%', CRITERIA::LIKE);
      $text3Criterion = $C->getNewCriterion( AgendatelefonicaPeer::ENTITAT , '%'.$P.'%', CRITERIA::LIKE);
      $text1Criterion->addOr($text2Criterion); $text1Criterion->addOr($text3Criterion);  $C->add($text1Criterion);          
     endforeach;
     
     $C->addGroupByColumn( AgendatelefonicaPeer::AGENDATELEFONICAID );
     $C->addAscendingOrderByColumn( AgendatelefonicaPeer::NOM );
     $C->setLimit(30);
     $ATD = AgendatelefonicaPeer::doSelect($C);
     
     return $ATD; 
  
  }
    
  static public function getSelectHTML($select = 0)
  {
  	$RET = '';
  	foreach(self::select() as $K=>$V):
  	
  		if($K == $select): $RET .= '<option selected value="'.$K.'">'.$V.'</option>';
  		else: $RET .= '<option value="'.$K.'">'.$V.'</option>';  		
  		endif;
  		  	
  	endforeach;
  	
  	$RET = str_replace("'","\'",$RET);
  	
  	return $RET;
  }
  
  static function select(  )
  {
    
     return array(
       	1=>'Telèfon',
  		2=>'Adreça',  
  		3=>'Compte corrent',
  		4=>'Fax',
  		5=>'Email',
  		6=>'Ciutat',
  		7=>'Codi Postal');
  
  }
  
  static function getTipus($idTipus)
  {
  	switch($idTipus){
  		case 1: return 'Telèfon'; break;
  		case 2: return 'Adreça'; break;  
  		case 3: return 'Compte corrent'; break;
  		case 4: return 'Fax'; break;
  		case 5: return 'Email'; break;
  		case 6: return 'Ciutat'; break;
  		case 7: return 'Codi Postal'; break;		
  	}
  }
  
  static public function inArray($Dades,$id)
  {

  	foreach($Dades as $K=>$V):
  	
  		if($K == $id) return true;
  	
  	endforeach;
  	
  	return false;
  	
  }
  
  static function update($DADES_NOVES,$idA)
  {
  	
  	$MERGE = array();
  	
  	//Carreguem totes les dades de l'agenda
  	$DADES_REALS = AgendatelefonicaPeer::retrieveByPK($idA)->getAgendatelefonicadadess();
  	
  	//Guardem els updates i deletes.
  	foreach($DADES_REALS as $K=>$V):
  	
  		if(self::inArray($DADES_NOVES,$V->getAgendatelefonicadadesid())):
			$MERGE[$V->getAgendatelefonicadadesid()]['accio'] = 'U';
			$MERGE[$V->getAgendatelefonicadadesid()]['dades'] = $V;
		else:
			$MERGE[$V->getAgendatelefonicadadesid()]['accio'] = 'D';
			$MERGE[$V->getAgendatelefonicadadesid()]['dades'] = $V;		 
  		endif;
  	
  	endforeach;
  	
  	
  	//Guardem al merge les dades que s'han d'afegir. 
  	foreach($DADES_NOVES as $K=>$V):
  		
  		if(!self::inArray($MERGE,$K)):					
			$MERGE[$K]['accio'] = 'A';
			$MERGE[$K]['dades'] = $V;		 
  		endif;  	  	
  	
  	endforeach;
  	
  	//Realitzem les accions sobre les dades
  	foreach($MERGE as $K=>$D):
  		  		
  			if($D['accio'] == 'U'):
  				
  				$D['dades']->setNew(false);
  				$D['dades']->setAgendatelefonicaAgendatelefonicaid($idA);
  				$D['dades']->setTipus($DADES_NOVES[$K]['Select']);
  				$D['dades']->setDada($DADES_NOVES[$K]['Dada']);
  				$D['dades']->setNotes($DADES_NOVES[$K]['Notes']);
  				$D['dades']->save();  			  			
  			  			
  			elseif($D['accio'] == 'D'):
  			
  				$D['dades']->delete();
  			
  			elseif($D['accio'] == 'A'):
  			
  				$DR = new Agendatelefonicadades();
  				
  				$DR->setNew(true);
  				$DR->setAgendatelefonicaAgendatelefonicaid($idA);
  				$DR->setTipus($D['dades']['Select']);
  				$DR->setDada($D['dades']['Dada']);
  				$DR->setNotes($D['dades']['Notes']);
  				$DR->save();  		
  			
  			endif; 
  			 	
  		endforeach;
  	
  }

}
