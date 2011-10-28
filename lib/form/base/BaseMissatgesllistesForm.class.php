<?php

/**
 * MissatgesLlistes form base class.
 *
 * @method MissatgesLlistes getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseMissatgesLlistesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idLlistes' => new sfWidgetFormInputHidden(),
      'idEmail'   => new sfWidgetFormInputText(),
      'enviat'    => new sfWidgetFormDate(),
      'site_id'   => new sfWidgetFormInputText(),
      'actiu'     => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'idLlistes' => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdllistes()), 'empty_value' => $this->getObject()->getIdllistes(), 'required' => false)),
      'idEmail'   => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'enviat'    => new sfValidatorDate(array('required' => false)),
      'site_id'   => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'actiu'     => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'MissatgesLlistes', 'column' => array('idEmail')))
    );

    $this->widgetSchema->setNameFormat('missatges_llistes[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'MissatgesLlistes';
  }


}
