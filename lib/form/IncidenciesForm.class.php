<?php

/**
 * Incidencies form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class IncidenciesForm extends sfFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idIncidencia'  => new sfWidgetFormInputHidden(),
      'quiinforma'    => new sfWidgetFormChoice(array('choices'=>UsuarisPeer::selectTreballadors())),
      'quiresol'      => new sfWidgetFormChoice(array('choices'=>UsuarisPeer::selectTreballadors())),
      'titol'         => new sfWidgetFormInput(),
      'descripcio'    => new sfWidgetFormTextarea(),
      'estat'         => new sfWidgetFormChoice(array('choices'=>IncidenciesPeer::getEstatSelect())),
      'dataalta'      => new sfWidgetFormDate(array('format'=>'%day%/%month%/%year%')),
      'dataresolucio' => new sfWidgetFormDate(array('format'=>'%day%/%month%/%year%')),
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
