<?php

/**
 * Agendatelefonica form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseAgendatelefonicaForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'AgendaTelefonicaID' => new sfWidgetFormInputHidden(),
      'Nom'                => new sfWidgetFormInput(),
      'NIF'                => new sfWidgetFormInput(),
      'DataAlta'           => new sfWidgetFormDate(),
      'Notes'              => new sfWidgetFormTextarea(),
      'Tags'               => new sfWidgetFormInput(),
      'Entitat'            => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'AgendaTelefonicaID' => new sfValidatorPropelChoice(array('model' => 'Agendatelefonica', 'column' => 'AgendaTelefonicaID', 'required' => false)),
      'Nom'                => new sfValidatorString(array('max_length' => 30, 'required' => false)),
      'NIF'                => new sfValidatorString(array('max_length' => 15, 'required' => false)),
      'DataAlta'           => new sfValidatorDate(array('required' => false)),
      'Notes'              => new sfValidatorString(array('required' => false)),
      'Tags'               => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'Entitat'            => new sfValidatorString(array('max_length' => 50, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('agendatelefonica[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Agendatelefonica';
  }


}
