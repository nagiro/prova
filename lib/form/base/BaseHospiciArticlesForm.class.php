<?php

/**
 * HospiciArticles form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseHospiciArticlesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'article_id' => new sfWidgetFormInputHidden(),
      'titol'      => new sfWidgetFormTextarea(),
      'text'       => new sfWidgetFormTextarea(),
      'data_alta'  => new sfWidgetFormDate(),
      'hora_alta'  => new sfWidgetFormTime(),
    ));

    $this->setValidators(array(
      'article_id' => new sfValidatorPropelChoice(array('model' => 'HospiciArticles', 'column' => 'article_id', 'required' => false)),
      'titol'      => new sfValidatorString(),
      'text'       => new sfValidatorString(),
      'data_alta'  => new sfValidatorDate(),
      'hora_alta'  => new sfValidatorTime(),
    ));

    $this->widgetSchema->setNameFormat('hospici_articles[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'HospiciArticles';
  }


}
