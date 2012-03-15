<?php

/**
 * DadesBancaries form base class.
 *
 * @method DadesBancaries getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseDadesBancariesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idDada'   => new sfWidgetFormInputHidden(),
      'idUsuari' => new sfWidgetFormInputText(),
      'titular'  => new sfWidgetFormTextarea(),
      'nif'      => new sfWidgetFormTextarea(),
      'entitat'  => new sfWidgetFormTextarea(),
      'poblacio' => new sfWidgetFormTextarea(),
      'ccc'      => new sfWidgetFormTextarea(),
      'actiu'    => new sfWidgetFormInputText(),
      'site_id'  => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'idDada'   => new sfValidatorChoice(array('choices' => array($this->getObject()->getIddada()), 'empty_value' => $this->getObject()->getIddada(), 'required' => false)),
      'idUsuari' => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'titular'  => new sfValidatorString(array('required' => false)),
      'nif'      => new sfValidatorString(array('required' => false)),
      'entitat'  => new sfValidatorString(array('required' => false)),
      'poblacio' => new sfValidatorString(array('required' => false)),
      'ccc'      => new sfValidatorString(),
      'actiu'    => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
      'site_id'  => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
    ));

    $this->widgetSchema->setNameFormat('dades_bancaries[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'DadesBancaries';
  }


}
