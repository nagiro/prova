<?php

/**
 * Apps form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseAppsForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'app_id'            => new sfWidgetFormInputHidden(),
      'Nom'               => new sfWidgetFormTextarea(),
      'usuaris_apps_list' => new sfWidgetFormPropelChoiceMany(array('model' => 'Usuaris')),
    ));

    $this->setValidators(array(
      'app_id'            => new sfValidatorPropelChoice(array('model' => 'Apps', 'column' => 'app_id', 'required' => false)),
      'Nom'               => new sfValidatorString(),
      'usuaris_apps_list' => new sfValidatorPropelChoiceMany(array('model' => 'Usuaris', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('apps[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Apps';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['usuaris_apps_list']))
    {
      $values = array();
      foreach ($this->object->getUsuarisAppss() as $obj)
      {
        $values[] = $obj->getUsuariId();
      }

      $this->setDefault('usuaris_apps_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->saveUsuarisAppsList($con);
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
    $c->add(UsuarisAppsPeer::APP_ID, $this->object->getPrimaryKey());
    UsuarisAppsPeer::doDelete($c, $con);

    $values = $this->getValue('usuaris_apps_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new UsuarisApps();
        $obj->setAppId($this->object->getPrimaryKey());
        $obj->setUsuariId($value);
        $obj->save();
      }
    }
  }

}
