<?php

/**
 * AppDocumentsArxius form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseAppDocumentsArxiusForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idDocument'                  => new sfWidgetFormInputHidden(),
      'idDirectori'                 => new sfWidgetFormPropelChoice(array('model' => 'AppDocumentsDirectoris', 'add_empty' => true)),
      'Nom'                         => new sfWidgetFormTextarea(),
      'DataCreacio'                 => new sfWidgetFormDate(),
      'app_documents_permisos_list' => new sfWidgetFormPropelChoiceMany(array('model' => 'Usuaris')),
    ));

    $this->setValidators(array(
      'idDocument'                  => new sfValidatorPropelChoice(array('model' => 'AppDocumentsArxius', 'column' => 'idDocument', 'required' => false)),
      'idDirectori'                 => new sfValidatorPropelChoice(array('model' => 'AppDocumentsDirectoris', 'column' => 'idDirectori', 'required' => false)),
      'Nom'                         => new sfValidatorString(),
      'DataCreacio'                 => new sfValidatorDate(),
      'app_documents_permisos_list' => new sfValidatorPropelChoiceMany(array('model' => 'Usuaris', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('app_documents_arxius[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AppDocumentsArxius';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['app_documents_permisos_list']))
    {
      $values = array();
      foreach ($this->object->getAppDocumentsPermisoss() as $obj)
      {
        $values[] = $obj->getIdusuari();
      }

      $this->setDefault('app_documents_permisos_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->saveAppDocumentsPermisosList($con);
  }

  public function saveAppDocumentsPermisosList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['app_documents_permisos_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (is_null($con))
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(AppDocumentsPermisosPeer::IDARXIU, $this->object->getPrimaryKey());
    AppDocumentsPermisosPeer::doDelete($c, $con);

    $values = $this->getValue('app_documents_permisos_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new AppDocumentsPermisos();
        $obj->setIdarxiu($this->object->getPrimaryKey());
        $obj->setIdusuari($value);
        $obj->save();
      }
    }
  }

}
