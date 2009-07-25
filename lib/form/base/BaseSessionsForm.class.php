<?php

/**
 * Sessions form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseSessionsForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'sess_id'   => new sfWidgetFormInput(),
      'sess_data' => new sfWidgetFormTextarea(),
      'sess_time' => new sfWidgetFormInput(),
      'id'        => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'sess_id'   => new sfValidatorString(array('max_length' => 64)),
      'sess_data' => new sfValidatorString(),
      'sess_time' => new sfValidatorInteger(),
      'id'        => new sfValidatorPropelChoice(array('model' => 'Sessions', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('sessions[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Sessions';
  }


}
