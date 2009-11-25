<?php

/**
 * Usuaris form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseUsuarisForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'UsuariID'                        => new sfWidgetFormInputHidden(),
      'Nivells_idNivells'               => new sfWidgetFormPropelChoice(array('model' => 'Nivells', 'add_empty' => true)),
      'DNI'                             => new sfWidgetFormInput(),
      'Passwd'                          => new sfWidgetFormInput(),
      'Nom'                             => new sfWidgetFormInput(),
      'Cog1'                            => new sfWidgetFormInput(),
      'Cog2'                            => new sfWidgetFormInput(),
      'Email'                           => new sfWidgetFormInput(),
      'Adreca'                          => new sfWidgetFormTextarea(),
      'CodiPostal'                      => new sfWidgetFormInput(),
      'Poblacio'                        => new sfWidgetFormPropelChoice(array('model' => 'Poblacions', 'add_empty' => true)),
      'Poblaciotext'                    => new sfWidgetFormTextarea(),
      'Telefon'                         => new sfWidgetFormTextarea(),
      'Mobil'                           => new sfWidgetFormTextarea(),
      'Entitat'                         => new sfWidgetFormTextarea(),
      'Habilitat'                       => new sfWidgetFormInput(),
      'usuaris_apps_list'               => new sfWidgetFormPropelChoiceMany(array('model' => 'Apps')),
      'app_documents_permisos_dir_list' => new sfWidgetFormPropelChoiceMany(array('model' => 'AppDocumentsDirectoris')),
      'app_documents_permisos_list'     => new sfWidgetFormPropelChoiceMany(array('model' => 'AppDocumentsArxius')),
    ));

    $this->setValidators(array(
      'UsuariID'                        => new sfValidatorPropelChoice(array('model' => 'Usuaris', 'column' => 'UsuariID', 'required' => false)),
      'Nivells_idNivells'               => new sfValidatorPropelChoice(array('model' => 'Nivells', 'column' => 'idNivells', 'required' => false)),
      'DNI'                             => new sfValidatorString(array('max_length' => 12, 'required' => false)),
      'Passwd'                          => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'Nom'                             => new sfValidatorString(array('max_length' => 30, 'required' => false)),
      'Cog1'                            => new sfValidatorString(array('max_length' => 30, 'required' => false)),
      'Cog2'                            => new sfValidatorString(array('max_length' => 30, 'required' => false)),
      'Email'                           => new sfValidatorString(array('max_length' => 30, 'required' => false)),
      'Adreca'                          => new sfValidatorString(array('required' => false)),
      'CodiPostal'                      => new sfValidatorInteger(array('required' => false)),
      'Poblacio'                        => new sfValidatorPropelChoice(array('model' => 'Poblacions', 'column' => 'idPoblacio', 'required' => false)),
      'Poblaciotext'                    => new sfValidatorString(array('required' => false)),
      'Telefon'                         => new sfValidatorString(array('required' => false)),
      'Mobil'                           => new sfValidatorString(array('required' => false)),
      'Entitat'                         => new sfValidatorString(array('required' => false)),
      'Habilitat'                       => new sfValidatorInteger(array('required' => false)),
      'usuaris_apps_list'               => new sfValidatorPropelChoiceMany(array('model' => 'Apps', 'required' => false)),
      'app_documents_permisos_dir_list' => new sfValidatorPropelChoiceMany(array('model' => 'AppDocumentsDirectoris', 'required' => false)),
      'app_documents_permisos_list'     => new sfValidatorPropelChoiceMany(array('model' => 'AppDocumentsArxius', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('usuaris[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Usuaris';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['usuaris_apps_list']))
    {
      $values = array();
      foreach ($this->object->getUsuarisAppss() as $obj)
      {
        $values[] = $obj->getAppId();
      }

      $this->setDefault('usuaris_apps_list', $values);
    }

    if (isset($this->widgetSchema['app_documents_permisos_dir_list']))
    {
      $values = array();
      foreach ($this->object->getAppDocumentsPermisosDirs() as $obj)
      {
        $values[] = $obj->getIddirectori();
      }

      $this->setDefault('app_documents_permisos_dir_list', $values);
    }

    if (isset($this->widgetSchema['app_documents_permisos_list']))
    {
      $values = array();
      foreach ($this->object->getAppDocumentsPermisoss() as $obj)
      {
        $values[] = $obj->getIdarxiu();
      }

      $this->setDefault('app_documents_permisos_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->saveUsuarisAppsList($con);
    $this->saveAppDocumentsPermisosDirList($con);
    $this->saveAppDocumentsPermisosList($con);
  }

  public function saveUsuarisAppsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['usuaris_apps_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (is_null($con))
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(UsuarisAppsPeer::USUARI_ID, $this->object->getPrimaryKey());
    UsuarisAppsPeer::doDelete($c, $con);

    $values = $this->getValue('usuaris_apps_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new UsuarisApps();
        $obj->setUsuariId($this->object->getPrimaryKey());
        $obj->setAppId($value);
        $obj->save();
      }
    }
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
    $c->add(AppDocumentsPermisosDirPeer::IDUSUARI, $this->object->getPrimaryKey());
    AppDocumentsPermisosDirPeer::doDelete($c, $con);

    $values = $this->getValue('app_documents_permisos_dir_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new AppDocumentsPermisosDir();
        $obj->setIdusuari($this->object->getPrimaryKey());
        $obj->setIddirectori($value);
        $obj->save();
      }
    }
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
    $c->add(AppDocumentsPermisosPeer::IDUSUARI, $this->object->getPrimaryKey());
    AppDocumentsPermisosPeer::doDelete($c, $con);

    $values = $this->getValue('app_documents_permisos_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new AppDocumentsPermisos();
        $obj->setIdusuari($this->object->getPrimaryKey());
        $obj->setIdarxiu($value);
        $obj->save();
      }
    }
  }

}
