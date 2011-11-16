<?php

/**
 * EntradesPreus form base class.
 *
 * @method EntradesPreus getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseEntradesPreusForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'horari_id'    => new sfWidgetFormInputHidden(),
      'Preu'         => new sfWidgetFormInputText(),
      'Preur'        => new sfWidgetFormInputText(),
      'Places'       => new sfWidgetFormInputText(),
      'Tipus'        => new sfWidgetFormInputText(),
      'activitat_id' => new sfWidgetFormInputHidden(),
      'site_id'      => new sfWidgetFormInputText(),
      'actiu'        => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'horari_id'    => new sfValidatorChoice(array('choices' => array($this->getObject()->getHorariId()), 'empty_value' => $this->getObject()->getHorariId(), 'required' => false)),
      'Preu'         => new sfValidatorInteger(array('min' => -32768, 'max' => 32767, 'required' => false)),
      'Preur'        => new sfValidatorInteger(array('min' => -32768, 'max' => 32767, 'required' => false)),
      'Places'       => new sfValidatorInteger(array('min' => -32768, 'max' => 32767, 'required' => false)),
      'Tipus'        => new sfValidatorInteger(array('min' => -32768, 'max' => 32767, 'required' => false)),
      'activitat_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->getActivitatId()), 'empty_value' => $this->getObject()->getActivitatId(), 'required' => false)),
      'site_id'      => new sfValidatorInteger(array('min' => -32768, 'max' => 32767)),
      'actiu'        => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
    ));

    $this->widgetSchema->setNameFormat('entrades_preus[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'EntradesPreus';
  }


}
