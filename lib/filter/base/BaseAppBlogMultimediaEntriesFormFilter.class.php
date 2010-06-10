<?php

/**
 * AppBlogMultimediaEntries filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseAppBlogMultimediaEntriesFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
    ));

    $this->setValidators(array(
    ));

    $this->widgetSchema->setNameFormat('app_blog_multimedia_entries_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AppBlogMultimediaEntries';
  }

  public function getFields()
  {
    return array(
      'entries_id'    => 'ForeignKey',
      'multimedia_id' => 'ForeignKey',
    );
  }
}
