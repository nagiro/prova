<?php

/**
 * EntradesPreus form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
class EntradesPreusForm extends BaseEntradesPreusForm
{
  public function setup()
  {
    $this->setWidgets(array(
      'foreign_id' => new sfWidgetFormInputHidden(),
      'Preu'       => new sfWidgetFormInputText(),
      'Preur'      => new sfWidgetFormInputText(),
      'Places'     => new sfWidgetFormInputText(),
      'Tipus'      => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'foreign_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->getForeignId()), 'empty_value' => $this->getObject()->getForeignId(), 'required' => false)),
      'Preu'       => new sfValidatorInteger(array('min' => -32768, 'max' => 32767, 'required' => false)),
      'Preur'      => new sfValidatorInteger(array('min' => -32768, 'max' => 32767, 'required' => false)),
      'Places'     => new sfValidatorInteger(array('min' => -32768, 'max' => 32767, 'required' => false)),
      'Tipus'      => new sfValidatorInteger(array('min' => -32768, 'max' => 32767, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('entrades_preus[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);        

  }

  public function getModelName()
  {
    return 'EntradesPreus';
  }
  
}
