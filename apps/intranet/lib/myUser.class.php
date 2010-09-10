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
  
}
