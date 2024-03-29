<?php

/**
 * Cessio form base class.
 *
 * @method Cessio getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseCessioForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'cessio_id'               => new sfWidgetFormInputHidden(),
      'usuari_id'               => new sfWidgetFormInputText(),
      'nom'                     => new sfWidgetFormTextarea(),
      'dni'                     => new sfWidgetFormInputText(),
      'representant'            => new sfWidgetFormInputText(),
      'motiu'                   => new sfWidgetFormTextarea(),
      'condicions'              => new sfWidgetFormTextarea(),
      'material_no_inventariat' => new sfWidgetFormTextarea(),
      'data_cessio'             => new sfWidgetFormDate(),
      'data_retorn'             => new sfWidgetFormDate(),
      'estat'                   => new sfWidgetFormTextarea(),
      'retornat'                => new sfWidgetFormInputText(),
      'estat_retornat'          => new sfWidgetFormTextarea(),
      'data_retornat'           => new sfWidgetFormDate(),
      'site_id'                 => new sfWidgetFormInputText(),
      'actiu'                   => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'cessio_id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->getCessioId()), 'empty_value' => $this->getObject()->getCessioId(), 'required' => false)),
      'usuari_id'               => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'nom'                     => new sfValidatorString(),
      'dni'                     => new sfValidatorString(array('max_length' => 10)),
      'representant'            => new sfValidatorString(array('max_length' => 100)),
      'motiu'                   => new sfValidatorString(),
      'condicions'              => new sfValidatorString(),
      'material_no_inventariat' => new sfValidatorString(),
      'data_cessio'             => new sfValidatorDate(),
      'data_retorn'             => new sfValidatorDate(),
      'estat'                   => new sfValidatorString(),
      'retornat'                => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
      'estat_retornat'          => new sfValidatorString(),
      'data_retornat'           => new sfValidatorDate(),
      'site_id'                 => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'actiu'                   => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('cessio[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Cessio';
  }


}
