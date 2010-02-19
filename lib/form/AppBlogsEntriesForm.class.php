<?php

/**
 * AppBlogsEntries form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class AppBlogsEntriesForm extends BaseAppBlogsEntriesForm
{
	
  public function setup()
  {
    $this->setWidgets(array(
      'id'                               => new sfWidgetFormInputHidden(),
      'page_id'                          => new sfWidgetFormPropelChoice(array('model' => 'AppBlogsPages', 'add_empty' => false)),
      'lang'                             => new sfWidgetFormChoice(array('choices'=>array('CA'=>'Català'))),
      'title'                            => new sfWidgetFormInput(),
      'body'                             => new sfWidgetFormTextarea(),
      'date'                             => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'id'                               => new sfValidatorPropelChoice(array('model' => 'AppBlogsEntries', 'column' => 'id', 'required' => false)),
      'page_id'                          => new sfValidatorPropelChoice(array('model' => 'AppBlogsPages', 'column' => 'id')),
      'lang'                             => new sfValidatorString(array('max_length' => 4)),
      'title'                            => new sfValidatorString(array('max_length' => 255)),
      'body'                             => new sfValidatorString(),
      'date'                             => new sfValidatorDate(),
    ));

    $this->widgetSchema->setLabels(array(      
      'page_id'                          => 'Pagina: ',
      'lang'                             => 'Llengua: ',
      'title'                            => 'Títol: ',
      'body'                             => 'Cos: ',
      'date'                             => 'Data: ',       
    ));
    
    $this->widgetSchema->setNameFormat('app_blogs_entries[%s]');        

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

  }

  public function getModelName()
  {
    return 'AppBlogsEntries';
  }

}
