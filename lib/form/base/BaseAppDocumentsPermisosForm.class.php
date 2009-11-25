<?php

/**
 * AppDocumentsPermisos form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseAppDocumentsPermisosForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idUsuari'        => new sfWidgetFormInputHidden(),
      'idArxiu'         => new sfWidgetFormInputHidden(),
      'idNivell'        => new sfWidgetFormPropelChoice(array('model' => 'Nivells', 'add_empty' => true)),
      'DataModificacio' => new sfWidgetFormDate(),
    ));

    $this->setValidators(array(
      'idUsuari'        => new sfValidatorPropelChoice(array('model' => 'Usuaris', 'column' => 'UsuariID', 'required' => false)),
      'idArxiu'         => new sfValidatorPropelChoice(array('model' => 'AppDocumentsArxius', 'column' => 'idDocument', 'required' => false)),
      'idNivell'        => new sfValidatorPropelChoice(array('model' => 'Nivells', 'column' => 'idNivells', 'required' => false)),
      'DataModificacio' => new sfValidatorDate(),
    ));

    $this->widgetSchema->setNameFormat('app_documents_permisos[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AppDocumentsPermisos';
  }


}
