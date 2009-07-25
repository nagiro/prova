<?php

/**
 * Horarisespais form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseHorarisespaisForm extends BaseFormPropel
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
      'idHorarisEspais'     => new sfValidatorPropelChoice(array('model' => 'Horarisespais', 'column' => 'idHorarisEspais', 'required' => false)),
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
