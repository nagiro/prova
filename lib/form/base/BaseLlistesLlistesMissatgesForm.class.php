<?php

/**
 * LlistesLlistesMissatges form base class.
 *
 * @method LlistesLlistesMissatges getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseLlistesLlistesMissatgesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idLlista'   => new sfWidgetFormInputHidden(),
      'idMissatge' => new sfWidgetFormInputHidden(),
      'actiu'      => new sfWidgetFormInputText(),
      'site_id'    => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'idLlista'   => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdllista()), 'empty_value' => $this->getObject()->getIdllista(), 'required' => false)),
      'idMissatge' => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdmissatge()), 'empty_value' => $this->getObject()->getIdmissatge(), 'required' => false)),
      'actiu'      => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
      'site_id'    => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
    ));

    $this->widgetSchema->setNameFormat('llistes_llistes_missatges[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'LlistesLlistesMissatges';
  }


}
