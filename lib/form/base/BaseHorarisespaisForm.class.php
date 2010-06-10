<?php

/**
 * Horarisespais form base class.
 *
 * @method Horarisespais getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseHorarisespaisForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idHorarisEspais'     => new sfWidgetFormInputHidden(),
      'Material_idMaterial' => new sfWidgetFormPropelChoice(array('model' => 'Material', 'add_empty' => true)),
      'Espais_EspaiID'      => new sfWidgetFormPropelChoice(array('model' => 'Espais', 'add_empty' => true)),
      'Horaris_HorarisID'   => new sfWidgetFormPropelChoice(array('model' => 'Horaris', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'idHorarisEspais'     => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdhorarisespais()), 'empty_value' => $this->getObject()->getIdhorarisespais(), 'required' => false)),
      'Material_idMaterial' => new sfValidatorPropelChoice(array('model' => 'Material', 'column' => 'idMaterial', 'required' => false)),
      'Espais_EspaiID'      => new sfValidatorPropelChoice(array('model' => 'Espais', 'column' => 'EspaiID', 'required' => false)),
      'Horaris_HorarisID'   => new sfValidatorPropelChoice(array('model' => 'Horaris', 'column' => 'HorarisID', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('horarisespais[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Horarisespais';
  }


}
