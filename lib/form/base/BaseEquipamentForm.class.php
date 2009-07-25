<?php

/**
 * Equipament form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseEquipamentForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'EquipamentID'       => new sfWidgetFormInputHidden(),
      'Factures_FacturaID' => new sfWidgetFormPropelChoice(array('model' => 'Factures', 'add_empty' => false)),
      'Tipus'              => new sfWidgetFormInput(),
      'DataCompra'         => new sfWidgetFormDate(),
      'Dades'              => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'EquipamentID'       => new sfValidatorPropelChoice(array('model' => 'Equipament', 'column' => 'EquipamentID', 'required' => false)),
      'Factures_FacturaID' => new sfValidatorPropelChoice(array('model' => 'Factures', 'column' => 'FacturaID')),
      'Tipus'              => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'DataCompra'         => new sfValidatorDate(array('required' => false)),
      'Dades'              => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('equipament[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Equipament';
  }


}
