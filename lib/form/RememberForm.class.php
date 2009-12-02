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
      'captcha'			=> new sfWidgetFormReCaptcha(array('public_key'=>'6LdiwAkAAAAAAHzLkRVPyQFqNrZPKKLS0GZRCYNL')),         
    ));
        
    $this->setValidators(array(
      'DNI'          	=> new sfValidatorPass(array('required'=>true)),      
	  'captcha'			=> new sfValidatorReCaptcha(array('private_key' => '6LdiwAkAAAAAAHdz8dyTPJTxA42K98I-iHLYE7Ug')),    
    ));

    
    $this->widgetSchema->setLabels(array(                
      'DNI'               => 'Entreu el DNI: ',            
    ));
    
    $this->widgetSchema->setNameFormat('remember[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

  }
  
}
