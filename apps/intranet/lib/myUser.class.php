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
  	if(isset($A[$nomCamp])) return $A[$nomCamp];
  	else return $default;
  	
  }

}
