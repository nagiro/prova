<?php

/**
 * Espais form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class EspaisForm extends BaseEspaisForm
{
    
  public function setup()
  {
    
    $Sino = array(0=>'No',1=>'Sí');
    
    $this->setWidgets(array(
      'EspaiID'     => new sfWidgetFormChoice(array('choices'=>EspaisPeer::select($this->getOption('IDS'))),array()),
      'Nom'         => new sfWidgetFormInputText(array(),array('style'=>'width:400px')),
      'Ordre'       => new sfWidgetFormInputText(array(),array('style'=>'width:50px')),
      'site_id'     => new sfWidgetFormInputHidden(),
      'actiu'       => new sfWidgetFormInputHidden(),
      'isLlogable'  => new sfWidgetFormChoice(array('choices'=>$Sino)), 
    ));

    $this->setValidators(array(
      'EspaiID' => new sfValidatorChoice(array('choices' => array($this->getObject()->getEspaiid()), 'empty_value' => $this->getObject()->getEspaiid(), 'required' => false)),
      'Nom'     => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'Ordre'   => new sfValidatorInteger(array('min' => -32768, 'max' => 32767)),
      'site_id' => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'actiu'   => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
      'isLlogable'=> new sfValidatorPass(array(),array()),
    ));

    $this->widgetSchema->setNameFormat('espais[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
    
    $this->widgetSchema->setLabels(array(
      'EspaiID' => 'Espai ',
      'Nom'     => 'Nom ',
      'Ordre'   => 'Ordre ',      
      'isLlogable' => 'Es lloga?',
    ));
    
  }

  public function getModelName()
  {
    return 'Espais';
  }

}
