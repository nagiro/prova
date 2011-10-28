<?php

/**
 * LlistesLlistesEmails form base class.
 *
 * @method LlistesLlistesEmails getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseLlistesLlistesEmailsForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idLlista' => new sfWidgetFormInputHidden(),
      'idEmail'  => new sfWidgetFormInputHidden(),
      'alta'     => new sfWidgetFormDate(),
      'baixa'    => new sfWidgetFormDate(),
      'actiu'    => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'idLlista' => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdllista()), 'empty_value' => $this->getObject()->getIdllista(), 'required' => false)),
      'idEmail'  => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdemail()), 'empty_value' => $this->getObject()->getIdemail(), 'required' => false)),
      'alta'     => new sfValidatorDate(array('required' => false)),
      'baixa'    => new sfValidatorDate(array('required' => false)),
      'actiu'    => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
    ));

    $this->widgetSchema->setNameFormat('llistes_llistes_emails[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'LlistesLlistesEmails';
  }


}
