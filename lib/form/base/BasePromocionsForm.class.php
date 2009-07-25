<?php

/**
 * Promocions form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BasePromocionsForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'PromocioID' => new sfWidgetFormInputHidden(),
      'Nom'        => new sfWidgetFormTextarea(),
      'Ordre'      => new sfWidgetFormInput(),
      'Extensio'   => new sfWidgetFormTextarea(),
      'isActiva'   => new sfWidgetFormInput(),
      'isFixa'     => new sfWidgetFormInput(),
      'URL'        => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'PromocioID' => new sfValidatorPropelChoice(array('model' => 'Promocions', 'column' => 'PromocioID', 'required' => false)),
      'Nom'        => new sfValidatorString(array('required' => false)),
      'Ordre'      => new sfValidatorInteger(array('required' => false)),
      'Extensio'   => new sfValidatorString(array('required' => false)),
      'isActiva'   => new sfValidatorInteger(array('required' => false)),
      'isFixa'     => new sfValidatorInteger(),
      'URL'        => new sfValidatorString(),
    ));

    $this->widgetSchema->setNameFormat('promocions[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Promocions';
  }


}
