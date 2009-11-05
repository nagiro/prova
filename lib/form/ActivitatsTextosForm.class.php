<?php

/**
 * Activitats form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class ActivitatsTextosForm extends sfFormPropel
{
  public function setup()
  {
  	
  	$URL_IMATGE = sfConfig::get('sf_web_dir').'/images/noticies'; 
  	$URL_PDF    = sfConfig::get('sf_web_dir').'/images/noticies'; 
  	
    $this->setWidgets(array(
      'ActivitatID'                     => new sfWidgetFormInputHidden(),
      'Cicles_CicleID'                  => new sfWidgetFormInputHidden(),
      'TipusActivitat_idTipusActivitat' => new sfWidgetFormInputHidden(),
      'Nom'                             => new sfWidgetFormInputHidden(),
      'Preu'                            => new sfWidgetFormInputHidden(),
      'PreuReduit'                      => new sfWidgetFormInputHidden(),
      'Publicable'                      => new sfWidgetFormInputHidden(),
      'Estat'                           => new sfWidgetFormInputHidden(),
      'Descripcio'                      => new sfWidgetFormInputHidden(),
	  'PublicaWEB'                      => new sfWidgetFormChoice(array('choices'=>array(1=>'Sí',2=>'No'))),
      'Imatge'                          => new sfWidgetFormInputFileEditableMy(array('file_src'=>sfConfig::get('sf_webroot').'images/noticies/'.$this->getObject()->getImatge() , 'is_image'=>true,'with_delete'=>false),array('style'=>'width:100px')),
      'PDF'                             => new sfWidgetFormInputFileEditableMy(array('file_src'=>sfConfig::get('sf_webroot').'images/noticies/'.$this->getObject()->getPdf() , 'is_image'=>false,'with_delete'=>false)),                  
      'tWEB'                            => new sfWidgetFormInput(array(),array('style'=>'width:300px')),
      'dWEB'                            => new sfWidgetFormTextareaTinyMCE(),
      'tNoticia'                        => new sfWidgetFormInput(array(),array('style'=>'width:300px')),
      'dNoticia'                        => new sfWidgetFormTextareaTinyMCE(),
      'tGENERAL'                        => new sfWidgetFormInput(array(),array('style'=>'width:300px')),
      'dGENERAL'                        => new sfWidgetFormTextareaTinyMCE(),
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
      'Descripcio'                      => new sfValidatorString(array('required' => false)),
      'Imatge'                          => new sfValidatorFile(array('path'=>$URL_IMATGE , 'required' => false)),
      'PDF'                             => new sfValidatorFile(array('path'=>$URL_PDF , 'required' => false)),
      'PublicaWEB'                      => new sfValidatorInteger(array('required' => false)),
      'tWEB'                            => new sfValidatorString(array('required' => false)),
      'dWEB'                            => new sfValidatorString(array('required' => false)),
      'tNoticia'                        => new sfValidatorString(array('required' => false)),
      'dNoticia'                        => new sfValidatorString(array('required' => false)),
      'tGENERAL'                        => new sfValidatorString(array('required' => false)),
      'dGENERAL'                        => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setLabels(array(
      'Descripcio'                      => 'Descripció: ',
      'Imatge'                          => 'Imatge: ',
      'PDF'                             => 'PDF: ',
      'PublicaWEB'                      => 'Publicar com notícia? ',
      'tWEB'                            => 'Títol calendari: ',
      'dWEB'                            => 'Text calendari: ',
      'tNoticia'                        => 'Títol notícia: ',
      'dNoticia'                        => 'Text notícia: ',
      'tGENERAL'                        => 'Títol general: ',
      'dGENERAL'                        => 'Text general: ',
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
