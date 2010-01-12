<?php

/**
 * Cessiomaterial form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class CessiomaterialRetornForm extends sfFormPropel
{
	
  public function setup()
  {
    $this->setWidgets(array(
      'idCessioMaterial'    => new sfWidgetFormInputHidden(),
      'Material_idMaterial' => new sfWidgetFormChoice(array('choices'=>MaterialgenericPeer::selectMaterialCedit(false))),
      'DataRetornat'        => new sfWidgetFormJQueryDate(array('format'=>'%day%/%month%/%year%'),array()),
      'EstatRetornat'		=> new sfWidgetFormTextarea(array(),array('style'=>'width:300px')),
      'Cedita'              => new sfWidgetFormInputHidden(array(),array()),
      'Estat'               => new sfWidgetFormInputHidden(array(),array()),
      'DataCessio'          => new sfWidgetFormInputHidden(array(),array()),      
      'DataRetorn'          => new sfWidgetFormInputHidden(array(),array()),
      'Retornat'            => new sfWidgetFormInputHidden(array(),array()),          
    ));

    $this->setValidators(array(
      'idCessioMaterial'    => new sfValidatorPropelChoice(array('model' => 'Cessiomaterial', 'column' => 'idCessioMaterial', 'required' => false)),
      'Material_idMaterial' => new sfValidatorPropelChoice(array('model' => 'Material', 'column' => 'idMaterial')),
      'Cedita'              => new sfValidatorString(array('required'=>false)),
      'DataCessio'          => new sfValidatorDate(array('required' => false)),
      'DataRetorn'          => new sfValidatorDate(array('required' => false)),
      'Estat'               => new sfValidatorString(array('required' => false)),
      'Retornat'            => new sfValidatorBoolean(array('required' => false)),
      'EstatRetornat'       => new sfValidatorString(array('required' => false)),
      'DataRetornat'        => new sfValidatorDate(array('required' => false)),    
    ));

    $this->widgetSchema->setLabels(array(      
      'Material_idMaterial' => 'Material: ',      
      'DataRetornat'        => 'Data de retorn: ',            
      'EstatRetornat'       => 'Observacions: ',
    ));           
    
    $this->widgetSchema->setNameFormat('cessiomaterial[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
   
  }

  public function getModelName()
  {
    return 'Cessiomaterial';
  }

}
