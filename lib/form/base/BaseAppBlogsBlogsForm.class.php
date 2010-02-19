<?php

/**
 * AppBlogsBlogs form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseAppBlogsBlogsForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'   => new sfWidgetFormInputHidden(),
      'name' => new sfWidgetFormInput(),
      'date' => new sfWidgetFormDate(),
    ));

    $this->setValidators(array(
      'id'   => new sfValidatorPropelChoice(array('model' => 'AppBlogsBlogs', 'column' => 'id', 'required' => false)),
      'name' => new sfValidatorString(array('max_length' => 50)),
      'date' => new sfValidatorDate(),
    ));

    $this->widgetSchema->setNameFormat('app_blogs_blogs[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AppBlogsBlogs';
  }


}
