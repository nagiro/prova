<?php

/**
 * Missatgesllistes form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseMissatgesllistesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idMissatgesLlistes' => new sfWidgetFormInputHidden(),
      'Llistes_idLlistes'  => new sfWidgetFormPropelChoice(array('model' => 'Llistes', 'add_empty' => false)),
      'Titol'              => new sfWidgetFormTextarea(),
      'Text'               => new sfWidgetFormTextarea(),
      'Date'               => new sfWidgetFormDateTime(),
      'Enviat'             => new sfWidgetFormDate(),
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
