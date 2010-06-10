<?php

/**
 * AppDocumentsPermisos filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseAppDocumentsPermisosFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idNivell'        => new sfWidgetFormPropelChoice(array('model' => 'Nivells', 'add_empty' => true)),
      'DataModificacio' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'idNivell'        => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Nivells', 'column' => 'idNivells')),
      'DataModificacio' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('app_documents_permisos_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AppDocumentsPermisos';
  }

  public function getFields()
  {
    return array(
      'idUsuari'        => 'ForeignKey',
      'idArxiu'         => 'ForeignKey',
      'idNivell'        => 'ForeignKey',
      'DataModificacio' => 'Date',
    );
  }
}