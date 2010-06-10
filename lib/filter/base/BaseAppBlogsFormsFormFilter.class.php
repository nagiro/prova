<?php

/**
 * AppBlogsForms filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseAppBlogsFormsFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'blog_id'     => new sfWidgetFormPropelChoice(array('model' => 'AppBlogsBlogs', 'add_empty' => true)),
      'view_fields' => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'name'        => new sfValidatorPass(array('required' => false)),
      'blog_id'     => new sfValidatorPropelChoice(array('required' => false, 'model' => 'AppBlogsBlogs', 'column' => 'id')),
      'view_fields' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('app_blogs_forms_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AppBlogsForms';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'name'        => 'Text',
      'blog_id'     => 'ForeignKey',
      'view_fields' => 'Text',
    );
  }
}