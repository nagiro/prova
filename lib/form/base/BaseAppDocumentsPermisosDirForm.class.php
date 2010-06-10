<?php

/**
 * AppDocumentsPermisosDir form base class.
 *
 * @method AppDocumentsPermisosDir getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseAppDocumentsPermisosDirForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idUsuari'    => new sfWidgetFormInputHidden(),
      'idDirectori' => new sfWidgetFormInputHidden(),
      'idNivell'    => new sfWidgetFormPropelChoice(array('model' => 'Nivells', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'idUsuari'    => new sfValidatorPropelChoice(array('model' => 'Usuaris', 'column' => 'UsuariID', 'required' => false)),
      'idDirectori' => new sfValidatorPropelChoice(array('model' => 'AppDocumentsDirectoris', 'column' => 'idDirectori', 'required' => false)),
      'idNivell'    => new sfValidatorPropelChoice(array('model' => 'Nivells', 'column' => 'idNivells', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('app_documents_permisos_dir[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AppDocumentsPermisosDir';
  }


}
