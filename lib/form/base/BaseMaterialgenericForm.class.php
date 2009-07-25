<?php

/**
 * Materialgeneric form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseMaterialgenericForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idMaterialGeneric' => new sfWidgetFormInputHidden(),
      'Nom'               => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'idMaterialGeneric' => new sfValidatorPropelChoice(array('model' => 'Materialgeneric', 'column' => 'idMaterialGeneric', 'required' => false)),
      'Nom'               => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('materialgeneric[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Materialgeneric';
  }


}
