<?php

/**
 * HospiciArticlesComentaris form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseHospiciArticlesComentarisForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'comentari_id' => new sfWidgetFormInputHidden(),
      'article_id'   => new sfWidgetFormInput(),
      'qui'          => new sfWidgetFormTextarea(),
      'comentari'    => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'comentari_id' => new sfValidatorPropelChoice(array('model' => 'HospiciArticlesComentaris', 'column' => 'comentari_id', 'required' => false)),
      'article_id'   => new sfValidatorInteger(),
      'qui'          => new sfValidatorString(),
      'comentari'    => new sfValidatorString(),
    ));

    $this->widgetSchema->setNameFormat('hospici_articles_comentaris[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'HospiciArticlesComentaris';
  }


}
