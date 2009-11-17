<?php

/**
 * Noticies form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class NoticiesForm extends BaseNoticiesForm
{
	
  public function setup()
  {
  	
  	$path = sfConfig::get('sf_web_dir').'/images/noticies';
  	$web  = sfConfig::get('sf_webroot').'images/noticies/';
  	
    $this->setWidgets(array(
      'idNoticia'      	=> new sfWidgetFormInputHidden(),
      'TitolNoticia'   	=> new sfWidgetFormInput(array(),array('style'=>'width:400px')),
      'TextNoticia'    	=> new sfWidgetFormTextareaTinyMCE(),
      'DataPublicacio' 	=> new sfWidgetFormDate(array('format'=>'%day%/%month%/%year%')),
      'DataDesaparicio' => new sfWidgetFormDate(array('format'=>'%day%/%month%/%year%')),
      'Activa'         	=> new sfWidgetFormChoice(array('choices'=>array(0=>'No',1=>'Sí'))),
      'Imatge'         	=> new sfWidgetFormInputFileEditableMy(array('file_src'=>$web.$this->getObject()->getImatge(), 'is_image'=>true , 'with_delete'=>false)),
      'Adjunt'         	=> new sfWidgetFormInputFileEditableMy(array('file_src'=>$web.$this->getObject()->getAdjunt(),'with_delete'=>false)),
      'idActivitat'    	=> new sfWidgetFormInput(),
      
    ));

    $this->setValidators(array(
      'idNoticia'      	=> new sfValidatorPropelChoice(array('model' => 'Noticies', 'column' => 'idNoticia', 'required' => false)),
      'TitolNoticia'   	=> new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'TextNoticia'    	=> new sfValidatorString(array('required' => false)),
      'DataPublicacio' 	=> new sfValidatorDate(array('required' => false)),
      'Activa'         	=> new sfValidatorBoolean(array('required' => false)),
      'Imatge'         	=> new sfValidatorFile(array('path'=> $path , 'required'=>false)),
      'Adjunt'         	=> new sfValidatorFile(array('path'=> $path , 'required'=>false)),
      'idActivitat'    	=> new sfValidatorInteger(array('required' => false)),
      'DataDesaparicio' => new sfValidatorDate(array('required' => false)),
    ));
    
    $this->widgetSchema->setLabels(array(		
      	'TitolNoticia'   	=> 'Títol: ',
      	'TextNoticia'    	=> 'Text: ',
      	'DataPublicacio' 	=> 'Data publicació: ',
    	'DataDesaparicio' 	=> 'Data desaparició: ',
      	'Activa'         	=> 'Activa? ',
      	'Imatge'         	=> 'Imatge: ',
      	'Adjunt'         	=> 'Doc. adjunt: ',
      	'idActivitat'    	=> 'Activitat relacionada: ',    
    ));

    $this->widgetSchema->setNameFormat('noticies[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
    
  }

  public function getModelName()
  {
    return 'Noticies';
  }

}