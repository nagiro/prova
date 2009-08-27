<?php

/**
 * Missatgesllistes form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class MissatgesllistesForm extends sfFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idMissatgesLlistes' => new sfWidgetFormInputHidden(),
      'Llistes_idLlistes'  => new sfWidgetFormInputHidden(),
      'Titol'              => new sfWidgetFormInput(array(),array('style'=>'width:500px')),
      'Text'               => new sfWidgetFormTextareaTinyMCE(array(),array()),
      'Date'               => new sfWidgetFormInputHidden(),
      'Enviat'             => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'idMissatgesLlistes' => new sfValidatorPropelChoice(array('model' => 'Missatgesllistes', 'column' => 'idMissatgesLlistes', 'required' => false)),
      'Llistes_idLlistes'  => new sfValidatorPropelChoice(array('model' => 'Llistes', 'column' => 'idLlistes')),
      'Titol'              => new sfValidatorString(),
      'Text'               => new sfValidatorString(),
      'Date'               => new sfValidatorDateTime(array('required' => false)),
      'Enviat'             => new sfValidatorDate(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('missatgesllistes[%s]');
    
    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Missatgesllistes';
  }

}
