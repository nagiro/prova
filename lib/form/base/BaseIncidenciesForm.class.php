<?php

/**
 * Incidencies form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseIncidenciesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idIncidencia'  => new sfWidgetFormInputHidden(),
      'quiinforma'    => new sfWidgetFormPropelChoice(array('model' => 'Usuaris', 'add_empty' => false)),
      'quiresol'      => new sfWidgetFormPropelChoice(array('model' => 'Usuaris', 'add_empty' => false)),
      'titol'         => new sfWidgetFormTextarea(),
      'descripcio'    => new sfWidgetFormTextarea(),
      'estat'         => new sfWidgetFormInput(),
      'dataalta'      => new sfWidgetFormDate(),
      'dataresolucio' => new sfWidgetFormDate(),
    ));

    $this->setValidators(array(
      'idIncidencia'  => new sfValidatorPropelChoice(array('model' => 'Incidencies', 'column' => 'idIncidencia', 'required' => false)),
      'quiinforma'    => new sfValidatorPropelChoice(array('model' => 'Usuaris', 'column' => 'UsuariID')),
      'quiresol'      => new sfValidatorPropelChoice(array('model' => 'Usuaris', 'column' => 'UsuariID')),
      'titol'         => new sfValidatorString(array('required' => false)),
      'descripcio'    => new sfValidatorString(array('required' => false)),
      'estat'         => new sfValidatorInteger(),
      'dataalta'      => new sfValidatorDate(),
      'dataresolucio' => new sfValidatorDate(),
    ));

    $this->widgetSchema->setNameFormat('incidencies[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Incidencies';
  }


}
