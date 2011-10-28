<?php

/**
 * LlistesEmails form base class.
 *
 * @method LlistesEmails getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseLlistesEmailsForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idEmail' => new sfWidgetFormInputHidden(),
      'email'   => new sfWidgetFormInputText(),
      'alta'    => new sfWidgetFormDate(),
      'baixa'   => new sfWidgetFormDate(),
      'actiu'   => new sfWidgetFormInputText(),
      'site_id' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'idEmail' => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdemail()), 'empty_value' => $this->getObject()->getIdemail(), 'required' => false)),
      'email'   => new sfValidatorString(array('max_length' => 50)),
      'alta'    => new sfValidatorDate(array('required' => false)),
      'baixa'   => new sfValidatorDate(array('required' => false)),
      'actiu'   => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'site_id' => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'LlistesEmails', 'column' => array('email')))
    );

    $this->widgetSchema->setNameFormat('llistes_emails[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'LlistesEmails';
  }


}
