<?php

/**
 * Espais form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseEspaisForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'EspaiID' => new sfWidgetFormInputHidden(),
      'Nom'     => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'EspaiID' => new sfValidatorPropelChoice(array('model' => 'Espais', 'column' => 'EspaiID', 'required' => false)),
      'Nom'     => new sfValidatorString(array('max_length' => 50, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('espais[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Espais';
  }


}
