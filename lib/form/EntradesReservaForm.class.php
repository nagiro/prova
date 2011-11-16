<?php

/**
 * EntradesReserva form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Albert Johé i Martí
 */
class EntradesReservaForm extends BaseEntradesReservaForm
{
        
  public function setup()
  {
    $this->setWidgets(array(
      'idEntrada'                   => new sfWidgetFormInputHidden(),
      'entrades_preus_horari_id'    => new sfWidgetFormInputHidden(),
      'entrades_preus_activitat_id' => new sfWidgetFormInputHidden(),
      'usuari_id'                   => new sfWidgetFormJQueryAutocompleter(array('url'=>$this->getOption('ajax')),array('style'=>'width:400px;')),
      'nom_reserva'                 => new sfWidgetFormInputText(array(),array('style'=>'width:400px')),
      'quantitat'                   => new sfWidgetFormChoice(array('choices'=>array('1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5')),array('style'=>'width:50px')),
      'data'                        => new sfWidgetFormShowText(),
      'estat'                       => new sfWidgetFormChoice(array('choices'=>EntradesReservaPeer::selectEstats()),array('style'=>'width:100px')),
      'actiu'                       => new sfWidgetFormInputHidden(),
      'site_id'                     => new sfWidgetFormInputHidden(),
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

    $this->widgetSchema->setLabels(array(
      'nom_reserva'                 => 'Nom: ',
      'quantitat'                   => 'Entrades:',
      'data'                        => 'Data: ',
      'estat'                       => 'Estat: ',      
    ));

    $this->widgetSchema->setNameFormat('entrades_reserva[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
    
    $this->widgetSchema->setFormFormatterName('Span');

  }

}
