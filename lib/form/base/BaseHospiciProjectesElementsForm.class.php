<?php

/**
 * HospiciProjectesElements form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseHospiciProjectesElementsForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'element_id'  => new sfWidgetFormInputHidden(),
      'tipus'       => new sfWidgetFormInputHidden(),
      'projecte_id' => new sfWidgetFormInputHidden(),
      'nivell'      => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'element_id'  => new sfValidatorPropelChoice(array('model' => 'HospiciProjectesElements', 'column' => 'element_id', 'required' => false)),
      'tipus'       => new sfValidatorPropelChoice(array('model' => 'HospiciProjectesElements', 'column' => 'tipus', 'required' => false)),
      'projecte_id' => new sfValidatorPropelChoice(array('model' => 'HospiciProjectesElements', 'column' => 'projecte_id', 'required' => false)),
      'nivell'      => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('hospici_projectes_elements[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'HospiciProjectesElements';
  }


}
