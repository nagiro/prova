<?php

/**
 * Proveidors form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseProveidorsForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'ProveidorID' => new sfWidgetFormInputHidden(),
      'NIF'         => new sfWidgetFormInput(),
      'Nom'         => new sfWidgetFormTextarea(),
      'Telefon'     => new sfWidgetFormInput(),
      'CE'          => new sfWidgetFormInput(),
      'CC'          => new sfWidgetFormInput(),
      'CP'          => new sfWidgetFormInput(),
      'Adreca'      => new sfWidgetFormTextarea(),
      'Alta'        => new sfWidgetFormDate(),
      'Ciutat'      => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'ProveidorID' => new sfValidatorPropelChoice(array('model' => 'Proveidors', 'column' => 'ProveidorID', 'required' => false)),
      'NIF'         => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'Nom'         => new sfValidatorString(array('required' => false)),
      'Telefon'     => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'CE'          => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'CC'          => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'CP'          => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'Adreca'      => new sfValidatorString(array('required' => false)),
      'Alta'        => new sfValidatorDate(array('required' => false)),
      'Ciutat'      => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('proveidors[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Proveidors';
  }


}
