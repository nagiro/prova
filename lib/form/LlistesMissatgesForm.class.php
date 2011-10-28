<?php

/**
 * LlistesMissatges form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
class LlistesMissatgesForm extends BaseLlistesMissatgesForm
{
    
  public function setup()
  {
    $this->setWidgets(array(
      'idMissatge'     => new sfWidgetFormInputHidden(),
      'titol'          => new sfWidgetFormInput(array(),array('style'=>'width:550px')),
      'text'           => new sfWidgetFormTextareaTinyMCE(),
      'data_enviament' => new sfWidgetFormInputHidden(),
      'site_id'        => new sfWidgetFormInputHidden(),
      'actiu'          => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'idMissatge'     => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdmissatge()), 'empty_value' => $this->getObject()->getIdmissatge(), 'required' => false)),
      'titol'          => new sfValidatorString(array('required' => false)),
      'text'           => new sfValidatorString(array('required' => false)),
      'data_enviament' => new sfValidatorDate(array('required' => false)),
      'site_id'        => new sfValidatorInteger(array('min' => -32768, 'max' => 32767, 'required' => false)),
      'actiu'          => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
    ));

    $this->widgetSchema->setNameFormat('llistes_missatges[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->widgetSchema->setLabels(array(      
      'titol'          => 'Títol: ',
      'text'           => 'Text: ',    
    ));

  }

  public function getModelName()
  {
    return 'LlistesMissatges';
  }
  
}
