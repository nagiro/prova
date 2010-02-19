<?php

/**
 * AppBlogsMultimedia form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseAppBlogsMultimediaForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                               => new sfWidgetFormInputHidden(),
      'name'                             => new sfWidgetFormInput(),
      'desc'                             => new sfWidgetFormTextarea(),
      'url'                              => new sfWidgetFormInput(),
      'date'                             => new sfWidgetFormDate(),
      'app_blog_multimedia_entries_list' => new sfWidgetFormPropelChoiceMany(array('model' => 'AppBlogsEntries')),
    ));

    $this->setValidators(array(
      'id'                               => new sfValidatorPropelChoice(array('model' => 'AppBlogsMultimedia', 'column' => 'id', 'required' => false)),
      'name'                             => new sfValidatorString(array('max_length' => 50)),
      'desc'                             => new sfValidatorString(),
      'url'                              => new sfValidatorString(array('max_length' => 255)),
      'date'                             => new sfValidatorDate(),
      'app_blog_multimedia_entries_list' => new sfValidatorPropelChoiceMany(array('model' => 'AppBlogsEntries', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('app_blogs_multimedia[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AppBlogsMultimedia';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['app_blog_multimedia_entries_list']))
    {
      $values = array();
      foreach ($this->object->getAppBlogMultimediaEntriess() as $obj)
      {
        $values[] = $obj->getEntriesId();
      }

      $this->setDefault('app_blog_multimedia_entries_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->saveAppBlogMultimediaEntriesList($con);
  }

  public function saveAppBlogMultimediaEntriesList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['app_blog_multimedia_entries_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (is_null($con))
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(AppBlogMultimediaEntriesPeer::MULTIMEDIA_ID, $this->object->getPrimaryKey());
    AppBlogMultimediaEntriesPeer::doDelete($c, $con);

    $values = $this->getValue('app_blog_multimedia_entries_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new AppBlogMultimediaEntries();
        $obj->setMultimediaId($this->object->getPrimaryKey());
        $obj->setEntriesId($value);
        $obj->save();
      }
    }
  }

}
