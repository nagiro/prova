<?php

class myUser extends sfBasicSecurityUser
{
	
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
  
  public function setSessionPar($nomCamp,$value)
  {
  	
  	$A = $this->getAttribute('sessio');  	
  	$A[$nomCamp] = $value;  	  	
  	$this->setAttribute('sessio',$A);
  	
  	return $value;
  	
  }
  
  public function getSessionPar($nomCamp,$default = "")
  {
  	
  	$A = $this->getAttribute('sessio',array());
  	if(isset($A[$nomCamp])){ $NOM = $A[$nomCamp]; if($NOM == 'images') $NOM = $default; return $NOM; }
  	else return $default;
  	
  }

  public function addLogAction($accio,$model,$dadesBefore = null ,$dadesAfter = null)
  {
  	$idU = $this->getSessionPar('idU');
  	$time = date('Y-m-d H:i',time());
  	
  	$O = new Log();
  	if($idU > 0) $O->setUsuariid($idU);
  	else $O->setUsuariid(null);
  	$O->setAccio($accio);
  	$O->setModel($model);  	
  	if(!is_null($dadesBefore)) $O->setDadesbefore(serialize($dadesBefore));
  	if(!is_null($dadesAfter))  $O->setDadesafter(serialize($dadesAfter));  	
  	$O->setData($time);
  	$O->save();
  	
  }  

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


  
}
