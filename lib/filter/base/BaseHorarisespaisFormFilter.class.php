<?php

/**
 * Horarisespais filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseHorarisespaisFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'Material_idMaterial' => new sfWidgetFormPropelChoice(array('model' => 'Material', 'add_empty' => true)),
      'Espais_EspaiID'      => new sfWidgetFormPropelChoice(array('model' => 'Espais', 'add_empty' => true)),
      'Horaris_HorarisID'   => new sfWidgetFormPropelChoice(array('model' => 'Horaris', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'Material_idMaterial' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Material', 'column' => 'idMaterial')),
      'Espais_EspaiID'      => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Espais', 'column' => 'EspaiID')),
      'Horaris_HorarisID'   => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Horaris', 'column' => 'HorarisID')),
    ));

    $this->widgetSchema->setNameFormat('horarisespais_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Horarisespais';
  }

  public function getFields()
  {
    return array(
      'idHorarisEspais'     => 'Number',
      'Material_idMaterial' => 'ForeignKey',
      'Espais_EspaiID'      => 'ForeignKey',
      'Horaris_HorarisID'   => 'ForeignKey',
    );
  }
}
