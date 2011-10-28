<?php

/**
 * Missatgesmailing form base class.
 *
 * @method Missatgesmailing getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseMissatgesmailingForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idMissatge' => new sfWidgetFormInputHidden(),
      'titol'      => new sfWidgetFormTextarea(),
      'text'       => new sfWidgetFormTextarea(),
      'data_alta'  => new sfWidgetFormDate(),
      'site_id'    => new sfWidgetFormInputText(),
      'actiu'      => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'idMissatge' => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdmissatge()), 'empty_value' => $this->getObject()->getIdmissatge(), 'required' => false)),
      'titol'      => new sfValidatorString(),
      'text'       => new sfValidatorString(),
      'data_alta'  => new sfValidatorDate(),
      'site_id'    => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'actiu'      => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
    ));

    $this->widgetSchema->setNameFormat('missatgesmailing[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Missatgesmailing';
  }


}
