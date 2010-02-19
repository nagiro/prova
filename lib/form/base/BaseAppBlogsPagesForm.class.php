<?php

/**
 * AppBlogsPages form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseAppBlogsPagesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'      => new sfWidgetFormInputHidden(),
      'name'    => new sfWidgetFormInput(),
      'visible' => new sfWidgetFormInput(),
      'date'    => new sfWidgetFormDate(),
      'type'    => new sfWidgetFormInput(),
      'blog_id' => new sfWidgetFormPropelChoice(array('model' => 'AppBlogsBlogs', 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'      => new sfValidatorPropelChoice(array('model' => 'AppBlogsPages', 'column' => 'id', 'required' => false)),
      'name'    => new sfValidatorString(array('max_length' => 40)),
      'visible' => new sfValidatorInteger(),
      'date'    => new sfValidatorDate(),
      'type'    => new sfValidatorString(array('max_length' => 1)),
      'blog_id' => new sfValidatorPropelChoice(array('model' => 'AppBlogsBlogs', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('app_blogs_pages[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AppBlogsPages';
  }


}
