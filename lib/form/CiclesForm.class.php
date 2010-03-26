<?php

/**
 * Cicles form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class CiclesForm extends BaseCiclesForm
{
  public function setup()
  {

  	$URL_IMATGE = sfConfig::get('sf_web_dir').'/images/noticies'; 
  	$URL_PDF    = sfConfig::get('sf_web_dir').'/images/noticies';
  	
    $this->setWidgets(array(
      'CicleID'  => new sfWidgetFormInputHidden(),
      'Nom'      => new sfWidgetFormInput(array(),array('style'=>'width:300px')),
      'Imatge'   => new sfWidgetFormInputFileEditableMy(array('file_src'=>sfConfig::get('sf_webroot').'images/noticies/'.$this->getObject()->getImatge() , 'is_image'=>true,'with_delete'=>false),array('style'=>'width:100px')),
      'PDF'      => new sfWidgetFormInputFileEditableMy(array('file_src'=>sfConfig::get('sf_webroot').'images/noticies/'.$this->getObject()->getPdf() , 'is_image'=>false,'with_delete'=>false)),
      'tCurt'    => new sfWidgetFormInput(array(),array('style'=>'width:300px')),
      'dCurt'    => new sfWidgetFormTextareaTinyMCE(),
      'tMig'     => new sfWidgetFormInput(array(),array('style'=>'width:300px')),
      'dMig'     => new sfWidgetFormTextareaTinyMCE(),
      'tComplet' => new sfWidgetFormInput(array(),array('style'=>'width:300px')),
      'dComplet' => new sfWidgetFormTextareaTinyMCE(),
    ));

    $this->setValidators(array(
      'CicleID'  => new sfValidatorPropelChoice(array('model' => 'Cicles', 'column' => 'CicleID', 'required' => false)),
      'Nom'      => new sfValidatorString(array('required' => false)),
      'Imatge'   => new sfValidatorFile(array('path'=>$URL_IMATGE , 'required' => false)),
      'PDF'      => new sfValidatorFile(array('path'=>$URL_PDF , 'required' => false)),
      'tCurt'    => new sfValidatorString(array('required' => false)),
      'dCurt'    => new sfValidatorString(array('required' => false)),
      'tMig'     => new sfValidatorString(array('required' => false)),
      'dMig'     => new sfValidatorString(array('required' => false)),
      'tComplet' => new sfValidatorString(array('required' => false)),
      'dComplet' => new sfValidatorString(array('required' => false)),
    ));
    
    $this->widgetSchema->setNameFormat('cicles[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
    
	$this->widgetSchema->setFormFormatterName('Span');    
   
  }

  public function getModelName()
  {
    return 'Cicles';
  }
	
}
