<?php

/**
 * Cicles form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseCiclesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'CicleID'    => new sfWidgetFormInputHidden(),
      'Nom'        => new sfWidgetFormTextarea(),
      'Descripcio' => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'CicleID'    => new sfValidatorPropelChoice(array('model' => 'Cicles', 'column' => 'CicleID', 'required' => false)),
      'Nom'        => new sfValidatorString(array('required' => false)),
      'Descripcio' => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('cicles[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Cicles';
  }


}
