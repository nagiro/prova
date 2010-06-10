<?php

/**
 * AppDocumentsPermisosDir filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseAppDocumentsPermisosDirFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idNivell'    => new sfWidgetFormPropelChoice(array('model' => 'Nivells', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'idNivell'    => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Nivells', 'column' => 'idNivells')),
    ));

    $this->widgetSchema->setNameFormat('app_documents_permisos_dir_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AppDocumentsPermisosDir';
  }

  public function getFields()
  {
    return array(
      'idUsuari'    => 'ForeignKey',
      'idDirectori' => 'ForeignKey',
      'idNivell'    => 'ForeignKey',
    );
  }
}
