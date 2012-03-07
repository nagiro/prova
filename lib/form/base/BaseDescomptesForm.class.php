<?php

/**
 * Descomptes form base class.
 *
 * @method Descomptes getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseDescomptesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idDescompte'     => new sfWidgetFormInputHidden(),
      'Nom'             => new sfWidgetFormTextarea(),
      'Descripcio'      => new sfWidgetFormTextarea(),
      'Percentatge'     => new sfWidgetFormInputText(),
      'Percentatge_txt' => new sfWidgetFormTextarea(),
      'Tipus'           => new sfWidgetFormInputText(),
      'actiu'           => new sfWidgetFormInputText(),
      'site_id'         => new sfWidgetFormInputText(),
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

    parent::setup();
  }

  public function getModelName()
  {
    return 'Descomptes';
  }


}
