<?php

/**
 * AppBlogMultimediaEntries form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseAppBlogMultimediaEntriesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'entries_id'    => new sfWidgetFormInputHidden(),
      'multimedia_id' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'entries_id'    => new sfValidatorPropelChoice(array('model' => 'AppBlogsEntries', 'column' => 'id', 'required' => false)),
      'multimedia_id' => new sfValidatorPropelChoice(array('model' => 'AppBlogsMultimedia', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('app_blog_multimedia_entries[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AppBlogMultimediaEntries';
  }


}
