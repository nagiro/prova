<?php

/**
 * Registreentrada form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseRegistreentradaForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'RegistreEntradaID' => new sfWidgetFormInputHidden(),
      'Projecte'          => new sfWidgetFormInput(),
      'Dades'             => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'RegistreEntradaID' => new sfValidatorPropelChoice(array('model' => 'Registreentrada', 'column' => 'RegistreEntradaID', 'required' => false)),
      'Projecte'          => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'Dades'             => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('registreentrada[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Registreentrada';
  }


}
