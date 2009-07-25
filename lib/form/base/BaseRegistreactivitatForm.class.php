<?php

/**
 * Registreactivitat form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseRegistreactivitatForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'LogID'     => new sfWidgetFormInputHidden(),
      'Timestamp' => new sfWidgetFormDateTime(),
      'Accio'     => new sfWidgetFormTextarea(),
      'Dades'     => new sfWidgetFormTextarea(),
      'idUsuari'  => new sfWidgetFormInput(),
      'Taula'     => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'LogID'     => new sfValidatorPropelChoice(array('model' => 'Registreactivitat', 'column' => 'LogID', 'required' => false)),
      'Timestamp' => new sfValidatorDateTime(array('required' => false)),
      'Accio'     => new sfValidatorString(array('required' => false)),
      'Dades'     => new sfValidatorString(array('required' => false)),
      'idUsuari'  => new sfValidatorInteger(array('required' => false)),
      'Taula'     => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('registreactivitat[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Registreactivitat';
  }


}
