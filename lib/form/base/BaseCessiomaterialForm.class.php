<?php

/**
 * Cessiomaterial form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseCessiomaterialForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idCessioMaterial'    => new sfWidgetFormInputHidden(),
      'Material_idMaterial' => new sfWidgetFormPropelChoice(array('model' => 'Material', 'add_empty' => false)),
      'Cedita'              => new sfWidgetFormTextarea(),
      'DataCessio'          => new sfWidgetFormDate(),
      'DataRetorn'          => new sfWidgetFormDate(),
      'Estat'               => new sfWidgetFormTextarea(),
      'Retornat'            => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'idCessioMaterial'    => new sfValidatorPropelChoice(array('model' => 'Cessiomaterial', 'column' => 'idCessioMaterial', 'required' => false)),
      'Material_idMaterial' => new sfValidatorPropelChoice(array('model' => 'Material', 'column' => 'idMaterial')),
      'Cedita'              => new sfValidatorString(),
      'DataCessio'          => new sfValidatorDate(array('required' => false)),
      'DataRetorn'          => new sfValidatorDate(array('required' => false)),
      'Estat'               => new sfValidatorString(array('required' => false)),
      'Retornat'            => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('cessiomaterial[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Cessiomaterial';
  }


}
