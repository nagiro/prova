<?php

/**
 * LlistesMissatges form base class.
 *
 * @method LlistesMissatges getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseLlistesMissatgesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idMissatge'     => new sfWidgetFormInputHidden(),
      'titol'          => new sfWidgetFormTextarea(),
      'text'           => new sfWidgetFormTextarea(),
      'data_enviament' => new sfWidgetFormDate(),
      'site_id'        => new sfWidgetFormInputText(),
      'actiu'          => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'idMissatge'     => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdmissatge()), 'empty_value' => $this->getObject()->getIdmissatge(), 'required' => false)),
      'titol'          => new sfValidatorString(array('required' => false)),
      'text'           => new sfValidatorString(array('required' => false)),
      'data_enviament' => new sfValidatorDate(array('required' => false)),
      'site_id'        => new sfValidatorInteger(array('min' => -32768, 'max' => 32767, 'required' => false)),
      'actiu'          => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
    ));

    $this->widgetSchema->setNameFormat('llistes_missatges[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'LlistesMissatges';
  }


}
