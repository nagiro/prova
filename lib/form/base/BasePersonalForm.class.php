<?php

/**
 * Personal form base class.
 *
 * @method Personal getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePersonalForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idPersonal'     => new sfWidgetFormInputHidden(),
      'idUsuari'       => new sfWidgetFormPropelChoice(array('model' => 'Usuaris', 'add_empty' => false)),
      'idData'         => new sfWidgetFormDate(),
      'treballa'       => new sfWidgetFormInputText(),
      'feines'         => new sfWidgetFormTextarea(),
      'horari'         => new sfWidgetFormTextarea(),
      'missatge'       => new sfWidgetFormTextarea(),
      'data_revisio'   => new sfWidgetFormDate(),
      'data_alta'      => new sfWidgetFormDateTime(),
      'data_baixa'     => new sfWidgetFormDate(),
      'usuariUpdateId' => new sfWidgetFormPropelChoice(array('model' => 'Usuaris', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'idPersonal'     => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdpersonal()), 'empty_value' => $this->getObject()->getIdpersonal(), 'required' => false)),
      'idUsuari'       => new sfValidatorPropelChoice(array('model' => 'Usuaris', 'column' => 'UsuariID')),
      'idData'         => new sfValidatorDate(),
      'treballa'       => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'feines'         => new sfValidatorString(array('required' => false)),
      'horari'         => new sfValidatorString(array('required' => false)),
      'missatge'       => new sfValidatorString(array('required' => false)),
      'data_revisio'   => new sfValidatorDate(array('required' => false)),
      'data_alta'      => new sfValidatorDateTime(array('required' => false)),
      'data_baixa'     => new sfValidatorDate(array('required' => false)),
      'usuariUpdateId' => new sfValidatorPropelChoice(array('model' => 'Usuaris', 'column' => 'UsuariID', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('personal[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Personal';
  }


}
