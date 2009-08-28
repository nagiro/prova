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
  	
  	$URL_IMATGE = sfConfig::get('web_dir').'/images/noticies/'.$this->getValue('Imatge');
  	$URL_PDF    = sfConfig::get('web_dir').'/images/noticies/'.$this->getValue('PDF');
  	
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
      'Imatge'                          => new sfWidgetFormInputFileEditable(array('file_src'=>$URL_IMATGE , 'is_image'=>true,'with_delete'=>false)),
      'PDF'                             => new sfWidgetFormInputFileEditable(array('file_src'=>$URL_PDF , 'is_image'=>false,'with_delete'=>false)),                  
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
      'Descripcio'                      => new sfValidatorString(),
      'Imatge'                          => new sfValidatorString(),
      'PDF'                             => new sfValidatorString(),
      'PublicaWEB'                      => new sfValidatorInteger(),
      'tWEB'                            => new sfValidatorString(),
      'dWEB'                            => new sfValidatorString(),
      'tNoticia'                        => new sfValidatorString(),
      'dNoticia'                        => new sfValidatorString(),
      'tGENERAL'                        => new sfValidatorString(),
      'dGENERAL'                        => new sfValidatorString(),
    ));

    $this->widgetSchema->setLabels(array(
      'Descripcio'                      => 'Descripció: ',
      'Imatge'                          => 'Imatge: ',
      'PDF'                             => 'PDF: ',
      'PublicaWEB'                      => 'Notícia activa? ',
      'tWEB'                            => 'Títol WEB: ',
      'dWEB'                            => 'Text WEB: ',
      'tNoticia'                        => 'Títol Notícia: ',
      'dNoticia'                        => 'Text Notícia: ',
      'tGENERAL'                        => 'Títol General: ',
      'dGENERAL'                        => 'Text General: ',
    ));
    
    
    $this->widgetSchema->setNameFormat('activitats[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Activitats';
  }
	
  public function save($conn= NULL)
  {
  
  	parent::save();
  }
  
}
