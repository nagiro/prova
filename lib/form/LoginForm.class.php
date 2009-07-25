<?php

class LoginForm extends sfForm
{
  public function configure()
  {
    $this->setWidgets(array(
      	'nick'   	 => new sfWidgetFormInput(),
    	'password' 	 => new sfWidgetFormInputPassword(),    	      
    ));        

    
        $this->setValidator('password' , new sfValidatorCallback(
    									array(
    										'callback'=>array('LoginForm','verifica'),
    										'arguments'=>array()
    										), array('invalid'=>'USUARI O CONTRASENYA INCORRECTE')
    								)
    					);	    	    
    $this->setValidator('nick',new sfValidatorString(array('required'=>false)));    
					
    					
    $this->widgetSchema->setlabels(array('nick'=>'DNI: ', 'password'=>'CONTRASENYA: '));

    $this->widgetSchema->setNameFormat('login[%s]');
        
  }

  
  public static function verifica($validator, $valor, $arguments)
  {
  		
        $request = sfContext::getInstance()->getRequest();          	
  		$L = $request->getParameter('login');  		
  		if(!UsuarisPeer::isLogined($L['nick'], $L['password']))
  		{
  	 		throw new sfValidatorError($validator, 'invalid');
  		}
  		  	
  }
  
}

?>