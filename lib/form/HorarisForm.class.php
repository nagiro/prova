<?php

/**
 * Horaris form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class HorarisForm extends sfFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'HorarisID'              => new sfWidgetFormInputHidden(),
      'Activitats_ActivitatID' => new sfWidgetFormInputHidden(),
      'Dia'                    => new sfWidgetFormInputDatePropi(array(),array('id'=>'multi999Datepicker','style'=>'width:400px')),
      'HoraPre'                => new sfWidgetFormTime(),
      'HoraInici'              => new sfWidgetFormTime(),
      'HoraFi'                 => new sfWidgetFormTime(),
      'HoraPost'               => new sfWidgetFormTime(),
      'Avis'                   => new sfWidgetFormInput(array(),array('style'=>'width:400px')),
      'Espectadors'            => new sfWidgetFormInput(array(),array('style'=>'width:50px')),
      'Places'                 => new sfWidgetFormInput(array(),array('style'=>'width:50px')),
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

    
    $this->widgetSchema->setLabels(array(
      'Dia'                    => 'Dies: ',
      'HoraInici'              => 'Hora d\'inici: ',
      'HoraFi'                 => 'Hora finalització: ',
      'HoraPre'                => 'Hora preparació: ',
      'HoraPost'               => 'Hora recollida: ',
      'Avis'                   => 'Avís: ',
      'Espectadors'            => 'Espectadors: ',
      'Places'                 => 'Places: ',
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
