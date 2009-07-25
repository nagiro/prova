<?php

/**
 * Agendatelefonicadades form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseAgendatelefonicadadesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'AgendaTelefonicaDadesID'             => new sfWidgetFormInputHidden(),
      'AgendaTelefonica_AgendaTelefonicaID' => new sfWidgetFormPropelChoice(array('model' => 'Agendatelefonica', 'add_empty' => false)),
      'Tipus'                               => new sfWidgetFormTextarea(),
      'Dada'                                => new sfWidgetFormTextarea(),
      'Notes'                               => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'AgendaTelefonicaDadesID'             => new sfValidatorPropelChoice(array('model' => 'Agendatelefonicadades', 'column' => 'AgendaTelefonicaDadesID', 'required' => false)),
      'AgendaTelefonica_AgendaTelefonicaID' => new sfValidatorPropelChoice(array('model' => 'Agendatelefonica', 'column' => 'AgendaTelefonicaID')),
      'Tipus'                               => new sfValidatorString(array('required' => false)),
      'Dada'                                => new sfValidatorString(array('required' => false)),
      'Notes'                               => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('agendatelefonicadades[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Agendatelefonicadades';
  }


}
