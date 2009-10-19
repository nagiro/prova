<?php

/**
 * UsuarisApps form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseUsuarisAppsForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'usuari_id' => new sfWidgetFormInputHidden(),
      'app_id'    => new sfWidgetFormInputHidden(),
      'nivell_id' => new sfWidgetFormPropelChoice(array('model' => 'Nivells', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'usuari_id' => new sfValidatorPropelChoice(array('model' => 'Usuaris', 'column' => 'UsuariID', 'required' => false)),
      'app_id'    => new sfValidatorPropelChoice(array('model' => 'Apps', 'column' => 'app_id', 'required' => false)),
      'nivell_id' => new sfValidatorPropelChoice(array('model' => 'Nivells', 'column' => 'idNivells', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('usuaris_apps[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'UsuarisApps';
  }


}
