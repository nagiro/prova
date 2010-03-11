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
      'cessio_id'           => new sfWidgetFormPropelChoice(array('model' => 'Cessio', 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'idCessioMaterial'    => new sfValidatorPropelChoice(array('model' => 'Cessiomaterial', 'column' => 'idCessioMaterial', 'required' => false)),
      'Material_idMaterial' => new sfValidatorPropelChoice(array('model' => 'Material', 'column' => 'idMaterial')),
      'cessio_id'           => new sfValidatorPropelChoice(array('model' => 'Cessio', 'column' => 'cessio_id')),
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
