<?php

/**
 * Tipusactivitat form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseTipusactivitatForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idTipusActivitat' => new sfWidgetFormInputHidden(),
      'Nom'              => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'idTipusActivitat' => new sfValidatorPropelChoice(array('model' => 'Tipusactivitat', 'column' => 'idTipusActivitat', 'required' => false)),
      'Nom'              => new sfValidatorString(),
    ));

    $this->widgetSchema->setNameFormat('tipusactivitat[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Tipusactivitat';
  }


}
