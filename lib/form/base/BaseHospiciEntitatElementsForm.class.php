<?php

/**
 * HospiciEntitatElements form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseHospiciEntitatElementsForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'element_id' => new sfWidgetFormInputHidden(),
      'tipus'      => new sfWidgetFormInputHidden(),
      'entitat_id' => new sfWidgetFormInputHidden(),
      'nivell'     => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'element_id' => new sfValidatorPropelChoice(array('model' => 'HospiciEntitatElements', 'column' => 'element_id', 'required' => false)),
      'tipus'      => new sfValidatorPropelChoice(array('model' => 'HospiciEntitatElements', 'column' => 'tipus', 'required' => false)),
      'entitat_id' => new sfValidatorPropelChoice(array('model' => 'HospiciEntitatElements', 'column' => 'entitat_id', 'required' => false)),
      'nivell'     => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('hospici_entitat_elements[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'HospiciEntitatElements';
  }


}
