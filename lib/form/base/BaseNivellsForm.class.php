<?php

/**
 * Nivells form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseNivellsForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idNivells' => new sfWidgetFormInputHidden(),
      'Nom'       => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'idNivells' => new sfValidatorPropelChoice(array('model' => 'Nivells', 'column' => 'idNivells', 'required' => false)),
      'Nom'       => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('nivells[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Nivells';
  }


}
