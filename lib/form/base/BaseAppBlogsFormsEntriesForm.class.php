<?php

/**
 * AppBlogsFormsEntries form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseAppBlogsFormsEntriesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'      => new sfWidgetFormInputHidden(),
      'dades'   => new sfWidgetFormTextarea(),
      'date'    => new sfWidgetFormDateTime(),
      'form_id' => new sfWidgetFormPropelChoice(array('model' => 'AppBlogsForms', 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'      => new sfValidatorPropelChoice(array('model' => 'AppBlogsFormsEntries', 'column' => 'id', 'required' => false)),
      'dades'   => new sfValidatorString(),
      'date'    => new sfValidatorDateTime(),
      'form_id' => new sfValidatorPropelChoice(array('model' => 'AppBlogsForms', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('app_blogs_forms_entries[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AppBlogsFormsEntries';
  }


}
