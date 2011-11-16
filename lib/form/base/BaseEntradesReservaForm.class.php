<?php

/**
 * EntradesReserva form base class.
 *
 * @method EntradesReserva getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseEntradesReservaForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idEntrada'                   => new sfWidgetFormInputHidden(),
      'entrades_preus_horari_id'    => new sfWidgetFormInputText(),
      'entrades_preus_activitat_id' => new sfWidgetFormInputText(),
      'usuari_id'                   => new sfWidgetFormInputText(),
      'nom_reserva'                 => new sfWidgetFormTextarea(),
      'quantitat'                   => new sfWidgetFormInputText(),
      'data'                        => new sfWidgetFormDateTime(),
      'estat'                       => new sfWidgetFormInputText(),
      'actiu'                       => new sfWidgetFormInputText(),
      'site_id'                     => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'idEntrada'                   => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdentrada()), 'empty_value' => $this->getObject()->getIdentrada(), 'required' => false)),
      'entrades_preus_horari_id'    => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'entrades_preus_activitat_id' => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
      'usuari_id'                   => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'nom_reserva'                 => new sfValidatorString(array('required' => false)),
      'quantitat'                   => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
      'data'                        => new sfValidatorDateTime(array('required' => false)),
      'estat'                       => new sfValidatorInteger(array('min' => -32768, 'max' => 32767, 'required' => false)),
      'actiu'                       => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
      'site_id'                     => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('entrades_reserva[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'EntradesReserva';
  }


}
