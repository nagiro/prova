<?php

/**
 * Horaris form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseHorarisForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'HorarisID'              => new sfWidgetFormInputHidden(),
      'Activitats_ActivitatID' => new sfWidgetFormPropelChoice(array('model' => 'Activitats', 'add_empty' => false)),
      'Dia'                    => new sfWidgetFormDate(),
      'HoraInici'              => new sfWidgetFormTime(),
      'HoraFi'                 => new sfWidgetFormTime(),
      'HoraPre'                => new sfWidgetFormTime(),
      'HoraPost'               => new sfWidgetFormTime(),
      'Avis'                   => new sfWidgetFormTextarea(),
      'Espectadors'            => new sfWidgetFormInput(),
      'Places'                 => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'HorarisID'              => new sfValidatorPropelChoice(array('model' => 'Horaris', 'column' => 'HorarisID', 'required' => false)),
      'Activitats_ActivitatID' => new sfValidatorPropelChoice(array('model' => 'Activitats', 'column' => 'ActivitatID')),
      'Dia'                    => new sfValidatorDate(array('required' => false)),
      'HoraInici'              => new sfValidatorTime(array('required' => false)),
      'HoraFi'                 => new sfValidatorTime(array('required' => false)),
      'HoraPre'                => new sfValidatorTime(array('required' => false)),
      'HoraPost'               => new sfValidatorTime(array('required' => false)),
      'Avis'                   => new sfValidatorString(),
      'Espectadors'            => new sfValidatorInteger(),
      'Places'                 => new sfValidatorInteger(),
    ));

    $this->widgetSchema->setNameFormat('horaris[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Horaris';
  }


}
