<?php

/**
 * MissatgesEmails form base class.
 *
 * @method MissatgesEmails getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseMissatgesEmailsForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idEmail' => new sfWidgetFormInputHidden(),
      'email'   => new sfWidgetFormInputText(),
      'alta'    => new sfWidgetFormDate(),
      'baixa'   => new sfWidgetFormDate(),
      'actiu'   => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'idEmail' => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdemail()), 'empty_value' => $this->getObject()->getIdemail(), 'required' => false)),
      'email'   => new sfValidatorString(array('max_length' => 50)),
      'alta'    => new sfValidatorDate(array('required' => false)),
      'baixa'   => new sfValidatorDate(array('required' => false)),
      'actiu'   => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'MissatgesEmails', 'column' => array('email')))
    );

    $this->widgetSchema->setNameFormat('missatges_emails[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'MissatgesEmails';
  }


}
