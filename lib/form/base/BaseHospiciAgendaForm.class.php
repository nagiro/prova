<?php

/**
 * HospiciAgenda form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseHospiciAgendaForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'agenda_id'    => new sfWidgetFormInputHidden(),
      'titol'        => new sfWidgetFormTextarea(),
      'text'         => new sfWidgetFormTextarea(),
      'data_inicial' => new sfWidgetFormDate(),
      'data_final'   => new sfWidgetFormDate(),
      'lloc'         => new sfWidgetFormTextarea(),
      'hora_inicial' => new sfWidgetFormTime(),
      'hora_final'   => new sfWidgetFormTime(),
      'link'         => new sfWidgetFormTextarea(),
      'ciutat'       => new sfWidgetFormTextarea(),
      'reserva'      => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'agenda_id'    => new sfValidatorPropelChoice(array('model' => 'HospiciAgenda', 'column' => 'agenda_id', 'required' => false)),
      'titol'        => new sfValidatorString(),
      'text'         => new sfValidatorString(),
      'data_inicial' => new sfValidatorDate(),
      'data_final'   => new sfValidatorDate(),
      'lloc'         => new sfValidatorString(),
      'hora_inicial' => new sfValidatorTime(),
      'hora_final'   => new sfValidatorTime(),
      'link'         => new sfValidatorString(),
      'ciutat'       => new sfValidatorString(),
      'reserva'      => new sfValidatorInteger(),
    ));

    $this->widgetSchema->setNameFormat('hospici_agenda[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'HospiciAgenda';
  }


}
