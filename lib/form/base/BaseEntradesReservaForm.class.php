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
      'email_reserva'               => new sfWidgetFormInputText(),
      'telefon_reserva'             => new sfWidgetFormInputText(),
      'quantitat'                   => new sfWidgetFormInputText(),
      'pagat'                       => new sfWidgetFormInputText(),
      'data'                        => new sfWidgetFormDateTime(),
      'estat'                       => new sfWidgetFormInputText(),
      'tipus_pagament'              => new sfWidgetFormInputText(),
      'actiu'                       => new sfWidgetFormInputText(),
      'site_id'                     => new sfWidgetFormInputText(),
      'descompte'                   => new sfWidgetFormInputText(),
      'tpv_operacio'                => new sfWidgetFormInputText(),
      'tpv_order'                   => new sfWidgetFormInputText(),
      'comentari'                   => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'idEntrada'                   => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdentrada()), 'empty_value' => $this->getObject()->getIdentrada(), 'required' => false)),
      'entrades_preus_horari_id'    => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'entrades_preus_activitat_id' => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'usuari_id'                   => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'nom_reserva'                 => new sfValidatorString(array('required' => false)),
      'email_reserva'               => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'telefon_reserva'             => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'quantitat'                   => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
      'pagat'                       => new sfValidatorNumber(array('required' => false)),
      'data'                        => new sfValidatorDateTime(array('required' => false)),
      'estat'                       => new sfValidatorInteger(array('min' => -32768, 'max' => 32767, 'required' => false)),
      'tipus_pagament'              => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'actiu'                       => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
      'site_id'                     => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'descompte'                   => new sfValidatorInteger(array('min' => -32768, 'max' => 32767, 'required' => false)),
      'tpv_operacio'                => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'tpv_order'                   => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'comentari'                   => new sfValidatorString(array('required' => false)),
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
