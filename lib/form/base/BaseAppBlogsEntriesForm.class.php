<?php

/**
 * AppBlogsEntries form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseAppBlogsEntriesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                               => new sfWidgetFormInputHidden(),
      'page_id'                          => new sfWidgetFormPropelChoice(array('model' => 'AppBlogsPages', 'add_empty' => false)),
      'lang'                             => new sfWidgetFormInput(),
      'title'                            => new sfWidgetFormInput(),
      'body'                             => new sfWidgetFormTextarea(),
      'date'                             => new sfWidgetFormDate(),
      'app_blog_multimedia_entries_list' => new sfWidgetFormPropelChoiceMany(array('model' => 'AppBlogsMultimedia')),
    ));

    $this->setValidators(array(
      'id'                               => new sfValidatorPropelChoice(array('model' => 'AppBlogsEntries', 'column' => 'id', 'required' => false)),
      'page_id'                          => new sfValidatorPropelChoice(array('model' => 'AppBlogsPages', 'column' => 'id')),
      'lang'                             => new sfValidatorString(array('max_length' => 4)),
      'title'                            => new sfValidatorString(array('max_length' => 255)),
      'body'                             => new sfValidatorString(),
      'date'                             => new sfValidatorDate(),
      'app_blog_multimedia_entries_list' => new sfValidatorPropelChoiceMany(array('model' => 'AppBlogsMultimedia', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('app_blogs_entries[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AppBlogsEntries';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['app_blog_multimedia_entries_list']))
    {
      $values = array();
      foreach ($this->object->getAppBlogMultimediaEntriess() as $obj)
      {
        $values[] = $obj->getMultimediaId();
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
    $c->add(AppBlogMultimediaEntriesPeer::ENTRIES_ID, $this->object->getPrimaryKey());
    AppBlogMultimediaEntriesPeer::doDelete($c, $con);

    $values = $this->getValue('app_blog_multimedia_entries_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new AppBlogMultimediaEntries();
        $obj->setEntriesId($this->object->getPrimaryKey());
        $obj->setMultimediaId($value);
        $obj->save();
      }
    }
  }

}
