<?php

/**
 * Sites form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
class SitesForm extends BaseSitesForm
{
    
  public function setup()
  {
    $this->setWidgets(array(
      'site_id'            => new sfWidgetFormChoice(array('choices'=>SitesPeer::getSelect())),
      'nom'                => new sfWidgetFormInputText(array(),array('style'=>'width:500px')),
      'actiu'              => new sfWidgetFormInputHidden(array(),array()),      
    ));

    $this->setValidators(array(
      'site_id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->getSiteId()), 'empty_value' => $this->getObject()->getSiteId(), 'required' => false)),
      'nom'                => new sfValidatorString(),      
      'actiu'              => new sfValidatorPass(),
    ));

    $this->widgetSchema->setNameFormat('sites[%s]');
    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
    $this->widgetSchema->setLabels(array('site_id'=>"Site ",'nom'=>'Nom '));
    
  }

  public function getModelName()
  {
    return 'Sites';
  }
}
