<?php

/**
 * ArxiuDvd form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseArxiuDvdForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'tipus'        => new sfWidgetFormInput(),
      'volum'        => new sfWidgetFormInput(),
      'url'          => new sfWidgetFormTextarea(),
      'nom'          => new sfWidgetFormTextarea(),
      'data_creacio' => new sfWidgetFormDateTime(),
      'comentari'    => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorPropelChoice(array('model' => 'ArxiuDvd', 'column' => 'id', 'required' => false)),
      'tipus'        => new sfValidatorString(array('max_length' => 30)),
      'volum'        => new sfValidatorString(array('max_length' => 30, 'required' => false)),
      'url'          => new sfValidatorString(array('required' => false)),
      'nom'          => new sfValidatorString(array('required' => false)),
      'data_creacio' => new sfValidatorDateTime(array('required' => false)),
      'comentari'    => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('arxiu_dvd[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ArxiuDvd';
  }


}
