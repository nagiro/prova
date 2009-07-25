<?php

/**
 * Poblacions form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BasePoblacionsForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idPoblacio' => new sfWidgetFormInputHidden(),
      'Nom'        => new sfWidgetFormTextarea(),
      'Comarca'    => new sfWidgetFormTextarea(),
      'CodiPostal' => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'idPoblacio' => new sfValidatorPropelChoice(array('model' => 'Poblacions', 'column' => 'idPoblacio', 'required' => false)),
      'Nom'        => new sfValidatorString(),
      'Comarca'    => new sfValidatorString(),
      'CodiPostal' => new sfValidatorString(),
    ));

    $this->widgetSchema->setNameFormat('poblacions[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Poblacions';
  }


}
