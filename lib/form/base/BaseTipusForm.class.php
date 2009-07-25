<?php

/**
 * Tipus form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseTipusForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idTipus'   => new sfWidgetFormInputHidden(),
      'tipusNom'  => new sfWidgetFormTextarea(),
      'tipusDesc' => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'idTipus'   => new sfValidatorPropelChoice(array('model' => 'Tipus', 'column' => 'idTipus', 'required' => false)),
      'tipusNom'  => new sfValidatorString(array('required' => false)),
      'tipusDesc' => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('tipus[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Tipus';
  }


}
