<?php

class LoginForm extends BaseForm
{
  public function configure()
  {
    $this->setWidgets(array(        
      	'nick'   	 => new sfWidgetFormInputText(array(),array('style'=>'width:100px;')),
    	'password' 	 => new sfWidgetFormInputPassword(array(),array('style'=>'width:100px;')),    	      
    ));        

    
    $this->setValidator('password' , new sfValidatorString(array('required'=>false)));	    	    
    $this->setValidator('nick',new sfValidatorString(array('required'=>false)));        					
    					
    $this->widgetSchema->setlabels(array('nick'=>'DNI: ', 'password'=>'CONTRASENYA: '));

    $this->widgetSchema->setNameFormat('login[%s]');
        
  }
  
}

?>