<?php

/**
 * Activitats form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class ActivitatsForm extends sfFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'ActivitatID'                     => new sfWidgetFormInputHidden(),
      'Nom'                             => new sfWidgetFormInput(array(),array('style'=>'width:400px')),    
      'Cicles_CicleID'                  => new sfWidgetFormChoice(array('choices'=>CiclesPeer::getSelect())),
      'TipusActivitat_idTipusActivitat' => new sfWidgetFormChoice(array('choices'=>TipusactivitatPeer::getSelect())),
      'Preu'                            => new sfWidgetFormInput(),
      'PreuReduit'                      => new sfWidgetFormInput(),
      'Publicable'                      => new sfWidgetFormChoice(array('choices'=>array(1=>'Sí',0=>'No'))),
      'Estat'                           => new sfWidgetFormChoice(array('choices'=>ActivitatsPeer::getSelectEstats())),
    ));

    $this->setValidators(array(
      'ActivitatID'                     => new sfValidatorPropelChoice(array('model' => 'Activitats', 'column' => 'ActivitatID', 'required' => false)),
      'Cicles_CicleID'                  => new sfValidatorPropelChoice(array('model' => 'Cicles', 'column' => 'CicleID', 'required' => false)),
      'TipusActivitat_idTipusActivitat' => new sfValidatorPropelChoice(array('model' => 'Tipusactivitat', 'column' => 'idTipusActivitat', 'required' => false)),
      'Nom'                             => new sfValidatorString(array('required' => false)),
      'Preu'                            => new sfValidatorNumber(array('required' => false)),
      'PreuReduit'                      => new sfValidatorNumber(array('required' => false)),
      'Publicable'                      => new sfValidatorInteger(array('required' => false)),
      'Estat'                           => new sfValidatorString(array('max_length' => 1, 'required' => false)),
    ));

    $this->widgetSchema->setLabels(array(      
      'Nom'                             => 'Nom de l\'activitat: ',    
      'Cicles_CicleID'                  => 'A quin projecte pertany? ',
      'TipusActivitat_idTipusActivitat' => 'Quin format té? ',
      'Preu'                            => 'Preu: ',
      'PreuReduit'                      => 'Preu reduït: ',
      'Publicable'                      => 'Visible al web?',
      'Estat'                           => 'Estat actual: ',
    ));
    
    
    $this->widgetSchema->setNameFormat('activitats[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Activitats';
  }

}
