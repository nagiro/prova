<?php

/**
 * Conceptes form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseConceptesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'ConcepteID' => new sfWidgetFormInputHidden(),
      'Any'        => new sfWidgetFormInput(),
      'Capitol'    => new sfWidgetFormTextarea(),
      'Apartat'    => new sfWidgetFormTextarea(),
      'Concepte'   => new sfWidgetFormTextarea(),
      'Quantitat'  => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'ConcepteID' => new sfValidatorPropelChoice(array('model' => 'Conceptes', 'column' => 'ConcepteID', 'required' => false)),
      'Any'        => new sfValidatorInteger(array('required' => false)),
      'Capitol'    => new sfValidatorString(array('required' => false)),
      'Apartat'    => new sfValidatorString(array('required' => false)),
      'Concepte'   => new sfValidatorString(array('required' => false)),
      'Quantitat'  => new sfValidatorNumber(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('conceptes[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Conceptes';
  }


}
