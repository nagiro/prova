<?php

/**
 * Llistes form base class.
 *
 * @method Llistes getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseLlistesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idLlistes' => new sfWidgetFormInputHidden(),
      'Nom'       => new sfWidgetFormTextarea(),
      'isActiva'  => new sfWidgetFormInputText(),
      'site_id'   => new sfWidgetFormInputText(),
      'actiu'     => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'idLlistes' => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdllistes()), 'empty_value' => $this->getObject()->getIdllistes(), 'required' => false)),
      'Nom'       => new sfValidatorString(),
      'isActiva'  => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
      'site_id'   => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'actiu'     => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('llistes[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Llistes';
  }


}
