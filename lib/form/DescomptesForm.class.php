<?php

/**
 * Descomptes form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
class DescomptesForm extends BaseDescomptesForm
{

  public function setup()
  {
    $this->setWidgets(array(
      'idDescompte'     => new sfWidgetFormChoice(array('choices'=>DescomptesPeer::getDescomptesArray($this->getOption('IDS'),true,true))),       
      'Nom'             => new sfWidgetFormInput(array(),array('style'=>'width:200px;')),
      'Descripcio'      => new sfWidgetFormInput(array(),array('style'=>'width:400px;')),
      'Percentatge'     => new sfWidgetFormInput(array(),array('style'=>'width:50px;')),
      'Percentatge_txt' => new sfWidgetFormInput(array(),array('style'=>'width:50px;')),
      'Tipus'           => new sfWidgetFormChoice(array('choices'=>array(1=>'Estàndard'))),
      'actiu'           => new sfWidgetFormChoice(array('choices'=>array(1=>'Sí',0=>'No')),array()),
      'site_id'         => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'idDescompte'     => new sfValidatorChoice(array('choices' => array($this->getObject()->getIddescompte()), 'empty_value' => $this->getObject()->getIddescompte(), 'required' => false)),      
      'Nom'             => new sfValidatorString(),
      'Descripcio'      => new sfValidatorString(array('required' => false)),
      'Percentatge'     => new sfValidatorNumber(),
      'Percentatge_txt' => new sfValidatorString(array('required' => false)),
      'Tipus'           => new sfValidatorInteger(array('min' => -32768, 'max' => 32767, 'required' => false)),
      'actiu'           => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
      'site_id'         => new sfValidatorInteger(array('min' => -32768, 'max' => 32767)),
    ));

    $this->widgetSchema->setNameFormat('descomptes[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
    
    $this->widgetSchema->setLabels(array(
      'idDescompte'     => 'Escull un descompte: ',  
      'Nom'             => 'Titol',
      'Descripcio'      => 'Descripció',
      'Percentatge'     => 'Descompte (%)',
      'Percentatge_txt' => 'Descompte text (20%)',
      'Tipus'           => 'Tipus'      
    ));

  }

}
