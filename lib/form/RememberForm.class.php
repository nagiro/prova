<?php

/**
 * Usuaris form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class RememberForm extends sfForm
{
  public function setup()
  {
    $this->setWidgets(array(
      'DNI'          	=> new sfWidgetFormInput(array(),array('style'=>'width:300px;')),            
      'captcha2'		=> new sfWidgetFormInputCaptcha(array(),array('value'=>$this->getOption('rand'))),         
    ));
        
    $rand = $this->getOption('rand');
    $sol = $rand[1]+$rand[2];
    $inv = "El resultat %value% no és correcte.";
        
    $this->setValidators(array(
      'DNI'          	=> new sfValidatorPass(array('required'=>true)),      
	  'captcha2'		=> new sfValidatorNumber(array('min'=>$sol,'max'=>$sol),array('invalid'=>$inv,'max'=>$inv,'min'=>$inv)),    
    ));
    
    $this->widgetSchema->setLabels(array(                
      'DNI'               => 'Entreu el DNI: ',
      'captcha2'		  => 'Validació: ',            
    ));
    
    $this->widgetSchema->setNameFormat('remember[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

  }
  
}
