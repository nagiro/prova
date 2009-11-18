<?php

/**
 * Cessiomaterial form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class CessiomaterialForm extends sfFormPropel
{
	
  public function setup()
  {
    $this->setWidgets(array(
      'idCessioMaterial'    => new sfWidgetFormInputHidden(),
      'Material_idMaterial' => new sfWidgetFormChoice(array('choices'=>MaterialgenericPeer::selectMaterial())),
      'Cedita'              => new sfWidgetFormInput(array(),array('style'=>'width:300px')),
      'Estat'               => new sfWidgetFormInput(array(),array('style'=>'width:300px')),
      'DataCessio'          => new sfWidgetFormJQueryDate(array('format'=>'%day%/%month%/%year%'),array()),
      'DataRetorn'          => new sfWidgetFormJQueryDate(array('format'=>'%day%/%month%/%year%'),array()),
      'Retornat'            => new sfWidgetFormChoice(array('choices'=>array(1=>'Sí',0=>'No')))
    ));

    $this->setValidators(array(
      'idCessioMaterial'    => new sfValidatorPropelChoice(array('model' => 'Cessiomaterial', 'column' => 'idCessioMaterial', 'required' => false)),
      'Material_idMaterial' => new sfValidatorPropelChoice(array('model' => 'Material', 'column' => 'idMaterial')),
      'Cedita'              => new sfValidatorString(),
      'DataCessio'          => new sfValidatorDate(array('required' => false)),
      'DataRetorn'          => new sfValidatorDate(array('required' => false)),
      'Estat'               => new sfValidatorString(array('required' => false)),
      'Retornat'            => new sfValidatorBoolean(array('required' => false)),
    ));

    $this->widgetSchema->setLabels(array(      
      'Material_idMaterial' => 'Material: ',
      'Cedita'              => 'Cedit a:', 
      'DataCessio'          => 'Data de cessió: ',
      'DataRetorn'          => 'Data de retorn: ',
      'Estat'               => 'Estat: ',
      'Retornat'            => 'Retornat? ',
    ));           
    
    $this->widgetSchema->setNameFormat('cessiomaterial[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
   
  }

  public function getModelName()
  {
    return 'Cessiomaterial';
  }

}
