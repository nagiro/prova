<?php

/**
 * Llistes form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseLlistesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idLlistes' => new sfWidgetFormInputHidden(),
      'Nom'       => new sfWidgetFormTextarea(),
      'isActiva'  => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'idLlistes' => new sfValidatorPropelChoice(array('model' => 'Llistes', 'column' => 'idLlistes', 'required' => false)),
      'Nom'       => new sfValidatorString(),
      'isActiva'  => new sfValidatorInteger(),
    ));

    $this->widgetSchema->setNameFormat('llistes[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Llistes';
  }


}
