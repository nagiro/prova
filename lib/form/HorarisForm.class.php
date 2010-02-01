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
  	
  	$minutes = array('00'=>'00','15'=>'15','30'=>'30','45'=>'45');
  	$hours = array(	'08'  =>'8 AM',
  					'09'  =>'9 AM',
  					'10' =>'10 AM',
  					'11' =>'11 AM',
  					'12' =>'12 AM',
  					'13' =>'1 PM',
  					'14' =>'2 PM',
  					'15' =>'3 PM',
  					'16' =>'4 PM',
  					'17' =>'5 PM',
  					'18' =>'6 PM',
  					'19' =>'7 PM',
  					'20' =>'8 PM',
  					'21' =>'9 PM',
  					'22' =>'10 PM',
  					'23' =>'11 PM',  					
  				  );
  	
    $this->setWidgets(array(
      'HorarisID'              => new sfWidgetFormInputHidden(),
      'Activitats_ActivitatID' => new sfWidgetFormInputHidden(),
      'Dia'                    => new sfWidgetFormInputDatePropi(array(),array('id'=>'multi999Datepicker','style'=>'width:400px')),
      'HoraPre'                => new sfWidgetFormTime(array('can_be_empty'=>false,'minutes'=>$minutes,'hours'=>$hours)),
      'HoraInici'              => new sfWidgetFormTime(array('can_be_empty'=>false,'minutes'=>$minutes,'hours'=>$hours)),
      'HoraFi'                 => new sfWidgetFormTime(array('can_be_empty'=>false,'minutes'=>$minutes,'hours'=>$hours)),
      'HoraPost'               => new sfWidgetFormTime(array('can_be_empty'=>false,'minutes'=>$minutes,'hours'=>$hours)),
      'Avis'                   => new sfWidgetFormInput(array(),array('style'=>'width:400px')),
      'Espectadors'            => new sfWidgetFormInput(array(),array('style'=>'width:50px')),
      'Places'                 => new sfWidgetFormInput(array(),array('style'=>'width:50px')),
    ));

    $this->setValidators(array(
      'HorarisID'              => new sfValidatorPropelChoice(array('model' => 'Horaris', 'column' => 'HorarisID', 'required' => false)),
      'Activitats_ActivitatID' => new sfValidatorPropelChoice(array('model' => 'Activitats', 'column' => 'ActivitatID')),
      'Dia'                    => new sfValidatorString(array('required' => false)),
      'HoraInici'              => new sfValidatorTime(array('required' => false)),
      'HoraFi'                 => new sfValidatorTime(array('required' => false)),
      'HoraPre'                => new sfValidatorTime(array('required' => false)),
      'HoraPost'               => new sfValidatorTime(array('required' => false)),
      'Avis'                   => new sfValidatorString(array('required'=>false)),
      'Espectadors'            => new sfValidatorInteger(array('required'=>false)),
      'Places'                 => new sfValidatorInteger(array('required'=>false)),
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
