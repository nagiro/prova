<?php

/**
 * HospiciProjectes form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseHospiciProjectesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'projecte_id' => new sfWidgetFormInputHidden(),
      'nom'         => new sfWidgetFormTextarea(),
      'descripcio'  => new sfWidgetFormTextarea(),
      'habilitat'   => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'projecte_id' => new sfValidatorPropelChoice(array('model' => 'HospiciProjectes', 'column' => 'projecte_id', 'required' => false)),
      'nom'         => new sfValidatorString(),
      'descripcio'  => new sfValidatorString(),
      'habilitat'   => new sfValidatorInteger(),
    ));

    $this->widgetSchema->setNameFormat('hospici_projectes[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'HospiciProjectes';
  }


}
