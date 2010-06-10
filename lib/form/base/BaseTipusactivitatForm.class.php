<?php

/**
 * Tipusactivitat form base class.
 *
 * @method Tipusactivitat getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseTipusactivitatForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idTipusActivitat' => new sfWidgetFormInputHidden(),
      'Nom'              => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'idTipusActivitat' => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdtipusactivitat()), 'empty_value' => $this->getObject()->getIdtipusactivitat(), 'required' => false)),
      'Nom'              => new sfValidatorString(),
    ));

    $this->widgetSchema->setNameFormat('tipusactivitat[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Tipusactivitat';
  }


}
