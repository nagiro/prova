<?php

/**
 * Espais form base class.
 *
 * @method Espais getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseEspaisForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'EspaiID' => new sfWidgetFormInputHidden(),
      'Nom'     => new sfWidgetFormInputText(),
      'Ordre'   => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'EspaiID' => new sfValidatorChoice(array('choices' => array($this->getObject()->getEspaiid()), 'empty_value' => $this->getObject()->getEspaiid(), 'required' => false)),
      'Nom'     => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'Ordre'   => new sfValidatorInteger(array('min' => -32768, 'max' => 32767)),
    ));

    $this->widgetSchema->setNameFormat('espais[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Espais';
  }


}
