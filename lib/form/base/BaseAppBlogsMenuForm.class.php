<?php

/**
 * AppBlogsMenu form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseAppBlogsMenuForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'        => new sfWidgetFormInputHidden(),
      'name'      => new sfWidgetFormInput(),
      'page_id'   => new sfWidgetFormPropelChoice(array('model' => 'AppBlogsPages', 'add_empty' => true)),
      'order'     => new sfWidgetFormInput(),
      'blog_id'   => new sfWidgetFormPropelChoice(array('model' => 'AppBlogsBlogs', 'add_empty' => false)),
      'father_id' => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'id'        => new sfValidatorPropelChoice(array('model' => 'AppBlogsMenu', 'column' => 'id', 'required' => false)),
      'name'      => new sfValidatorString(array('max_length' => 50)),
      'page_id'   => new sfValidatorPropelChoice(array('model' => 'AppBlogsPages', 'column' => 'id', 'required' => false)),
      'order'     => new sfValidatorInteger(),
      'blog_id'   => new sfValidatorPropelChoice(array('model' => 'AppBlogsBlogs', 'column' => 'id')),
      'father_id' => new sfValidatorInteger(),
    ));

    $this->widgetSchema->setNameFormat('app_blogs_menu[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AppBlogsMenu';
  }


}
