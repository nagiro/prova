<?php

/**
 * Usuaris form base class.
 *
 * @method Usuaris getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseUsuarisForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'UsuariID'                        => new sfWidgetFormInputHidden(),
      'Nivells_idNivells'               => new sfWidgetFormPropelChoice(array('model' => 'Nivells', 'add_empty' => true)),
      'DNI'                             => new sfWidgetFormInputText(),
      'Passwd'                          => new sfWidgetFormInputText(),
      'Nom'                             => new sfWidgetFormInputText(),
      'Cog1'                            => new sfWidgetFormInputText(),
      'Cog2'                            => new sfWidgetFormInputText(),
      'Email'                           => new sfWidgetFormInputText(),
      'Adreca'                          => new sfWidgetFormTextarea(),
      'CodiPostal'                      => new sfWidgetFormInputText(),
      'Poblacio'                        => new sfWidgetFormPropelChoice(array('model' => 'Poblacions', 'add_empty' => true)),
      'Poblaciotext'                    => new sfWidgetFormTextarea(),
      'Telefon'                         => new sfWidgetFormTextarea(),
      'Mobil'                           => new sfWidgetFormTextarea(),
      'Entitat'                         => new sfWidgetFormTextarea(),
      'Habilitat'                       => new sfWidgetFormInputText(),
      'app_documents_permisos_dir_list' => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'AppDocumentsDirectoris')),
      'app_documents_permisos_list'     => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'AppDocumentsArxius')),
      'usuaris_apps_list'               => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'Apps')),
    ));

    $this->setValidators(array(
      'UsuariID'                        => new sfValidatorChoice(array('choices' => array($this->getObject()->getUsuariid()), 'empty_value' => $this->getObject()->getUsuariid(), 'required' => false)),
      'Nivells_idNivells'               => new sfValidatorPropelChoice(array('model' => 'Nivells', 'column' => 'idNivells', 'required' => false)),
      'DNI'                             => new sfValidatorString(array('max_length' => 12, 'required' => false)),
      'Passwd'                          => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'Nom'                             => new sfValidatorString(array('max_length' => 30, 'required' => false)),
      'Cog1'                            => new sfValidatorString(array('max_length' => 30, 'required' => false)),
      'Cog2'                            => new sfValidatorString(array('max_length' => 30, 'required' => false)),
      'Email'                           => new sfValidatorString(array('max_length' => 30, 'required' => false)),
      'Adreca'                          => new sfValidatorString(array('required' => false)),
      'CodiPostal'                      => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'Poblacio'                        => new sfValidatorPropelChoice(array('model' => 'Poblacions', 'column' => 'idPoblacio', 'required' => false)),
      'Poblaciotext'                    => new sfValidatorString(array('required' => false)),
      'Telefon'                         => new sfValidatorString(array('required' => false)),
      'Mobil'                           => new sfValidatorString(array('required' => false)),
      'Entitat'                         => new sfValidatorString(array('required' => false)),
      'Habilitat'                       => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'app_documents_permisos_dir_list' => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'AppDocumentsDirectoris', 'required' => false)),
      'app_documents_permisos_list'     => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'AppDocumentsArxius', 'required' => false)),
      'usuaris_apps_list'               => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'Apps', 'required' => false)),
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

    if (isset($this->widgetSchema['usuaris_apps_list']))
    {
      $values = array();
      foreach ($this->object->getUsuarisAppss() as $obj)
      {
        $values[] = $obj->getAppId();
      }

      $this->setDefault('usuaris_apps_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->saveAppDocumentsPermisosDirList($con);
    $this->saveAppDocumentsPermisosList($con);
    $this->saveUsuarisAppsList($con);
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

    if (null === $con)
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

    if (null === $con)
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

    if (null === $con)
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

}
