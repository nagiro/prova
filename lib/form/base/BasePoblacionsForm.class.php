<?php

/**
 * Poblacions form base class.
 *
 * @method Poblacions getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePoblacionsForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idPoblacio' => new sfWidgetFormInputHidden(),
      'Nom'        => new sfWidgetFormTextarea(),
      'Comarca'    => new sfWidgetFormTextarea(),
      'CodiPostal' => new sfWidgetFormTextarea(),
      'site_id'    => new sfWidgetFormInputText(),
      'actiu'      => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'idPoblacio' => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdpoblacio()), 'empty_value' => $this->getObject()->getIdpoblacio(), 'required' => false)),
      'Nom'        => new sfValidatorString(),
      'Comarca'    => new sfValidatorString(),
      'CodiPostal' => new sfValidatorString(),
      'site_id'    => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'actiu'      => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('poblacions[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Poblacions';
  }


}
