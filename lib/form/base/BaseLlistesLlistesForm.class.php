<?php

/**
 * LlistesLlistes form base class.
 *
 * @method LlistesLlistes getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseLlistesLlistesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idLlista' => new sfWidgetFormInputHidden(),
      'nom'      => new sfWidgetFormTextarea(),
      'site_id'  => new sfWidgetFormInputText(),
      'actiu'    => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'idLlista' => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdllista()), 'empty_value' => $this->getObject()->getIdllista(), 'required' => false)),
      'nom'      => new sfValidatorString(array('required' => false)),
      'site_id'  => new sfValidatorInteger(array('min' => -32768, 'max' => 32767, 'required' => false)),
      'actiu'    => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
    ));

    $this->widgetSchema->setNameFormat('llistes_llistes[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'LlistesLlistes';
  }


}
