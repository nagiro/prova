<?php

/**
 * Activitats form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class ActivitatsPas1Form extends sfForm
{
	
  public function setup()
  {
    $this->setWidgets(array(
      'cicle'                     		=> new sfWidgetFormChoice(array('choices'=>array(1=>'Són activitats soltes',2=>'És un cicle / festival / projecte')),array()),
      'nom'								=> new sfWidgetFormInput(array(),array()),      
    ));

    $this->setValidators(array(
	  'cicle'                     		=> new sfValidatorPass(),
      'nom'								=> new sfValidatorString(),    	      
    ));

    $this->widgetSchema->setLabels(array(
      'cicle'							=> 'Tipologia',
      'nom'								=> 'Nom genèric',      
    ));
    
    
    $this->widgetSchema->setNameFormat('activitats[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
    
    $this->widgetSchema->setFormFormatterName('Span');

  }

}
