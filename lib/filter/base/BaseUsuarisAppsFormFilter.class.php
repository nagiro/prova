<?php

/**
 * UsuarisApps filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseUsuarisAppsFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'nivell_id' => new sfWidgetFormPropelChoice(array('model' => 'Nivells', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'nivell_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Nivells', 'column' => 'idNivells')),
    ));

    $this->widgetSchema->setNameFormat('usuaris_apps_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'UsuarisApps';
  }

  public function getFields()
  {
    return array(
      'usuari_id' => 'ForeignKey',
      'app_id'    => 'ForeignKey',
      'nivell_id' => 'ForeignKey',
    );
  }
}
