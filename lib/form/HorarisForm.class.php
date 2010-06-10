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
/*  	$hours = array(	'08'  =>'8',
  					'09'  =>'9',
  					'10' =>'10',
  					'11' =>'11',
  					'12' =>'12',
  					'13' =>'13',
  					'14' =>'14',
  					'15' =>'15',
  					'16' =>'16',
  					'17' =>'17',
  					'18' =>'18',
  					'19' =>'19',
  					'20' =>'20',
  					'21' =>'21',
  					'22' =>'22',
  					'23' =>'23',  					  					
  				  );
*/  	
    $this->setWidgets(array(
      'HorarisID'              => new sfWidgetFormInputHidden(),
      'Activitats_ActivitatID' => new sfWidgetFormInputHidden(),
      'Dia'                    => new sfWidgetFormInputDatePropi(array(),array('id'=>'multi999Datepicker','style'=>'width:400px')),
      'HoraPre'                => new sfWidgetFormTime(array('can_be_empty'=>false,'minutes'=>$minutes)),
      'HoraInici'              => new sfWidgetFormTime(array('can_be_empty'=>false,'minutes'=>$minutes)),
      'HoraFi'                 => new sfWidgetFormTime(array('can_be_empty'=>false,'minutes'=>$minutes)),
      'HoraPost'               => new sfWidgetFormTime(array('can_be_empty'=>false,'minutes'=>$minutes)),
      'Avis'                   => new sfWidgetFormInputText(array(),array('style'=>'width:400px')),
      'Espectadors'            => new sfWidgetFormInputText(array(),array('style'=>'width:50px')),
      'Places'                 => new sfWidgetFormInputText(array(),array('style'=>'width:50px')),
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

  }
  
  public function getModelName()
  {
    return 'Horaris';
  }

}
