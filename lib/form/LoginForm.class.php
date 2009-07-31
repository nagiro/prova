<?php

class LoginForm extends sfForm
{
  public function configure()
  {
    $this->setWidgets(array(
      	'nick'   	 => new sfWidgetFormInput(),
    	'password' 	 => new sfWidgetFormInputPassword(),    	      
    ));        

    
    $this->setValidator('password' , new sfValidatorString(array('required'=>false)));	    	    
    $this->setValidator('nick',new sfValidatorString(array('required'=>true)));    
					
    					
    $this->widgetSchema->setlabels(array('nick'=>'DNI: ', 'password'=>'CONTRASENYA: '));

    $this->widgetSchema->setNameFormat('login[%s]');
        
  }
  
}

?>