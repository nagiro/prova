<?php

/**
 * AppDocumentsDirectoris form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseAppDocumentsDirectorisForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idDirectori'                     => new sfWidgetFormInputHidden(),
      'Nom'                             => new sfWidgetFormTextarea(),
      'Pare'                            => new sfWidgetFormPropelChoice(array('model' => 'AppDocumentsDirectoris', 'add_empty' => true)),
      'app_documents_permisos_dir_list' => new sfWidgetFormPropelChoiceMany(array('model' => 'Usuaris')),
    ));

    $this->setValidators(array(
      'idDirectori'                     => new sfValidatorPropelChoice(array('model' => 'AppDocumentsDirectoris', 'column' => 'idDirectori', 'required' => false)),
      'Nom'                             => new sfValidatorString(),
      'Pare'                            => new sfValidatorPropelChoice(array('model' => 'AppDocumentsDirectoris', 'column' => 'idDirectori', 'required' => false)),
      'app_documents_permisos_dir_list' => new sfValidatorPropelChoiceMany(array('model' => 'Usuaris', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('app_documents_directoris[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AppDocumentsDirectoris';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['app_documents_permisos_dir_list']))
    {
      $values = array();
      foreach ($this->object->getAppDocumentsPermisosDirs() as $obj)
      {
        $values[] = $obj->getIdusuari();
      }

      $this->setDefault('app_documents_permisos_dir_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->saveAppDocumentsPermisosDirList($con);
  }

  public function saveAppDocumentsPermisosDirList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['app_documents_permisos_dir_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (is_null($con))
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(AppDocumentsPermisosDirPeer::IDDIRECTORI, $this->object->getPrimaryKey());
    AppDocumentsPermisosDirPeer::doDelete($c, $con);

    $values = $this->getValue('app_documents_permisos_dir_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new AppDocumentsPermisosDir();
        $obj->setIddirectori($this->object->getPrimaryKey());
        $obj->setIdusuari($value);
        $obj->save();
      }
    }
  }

}