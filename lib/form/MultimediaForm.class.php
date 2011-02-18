<?php

/**
 * Multimedia form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class MultimediaForm extends BaseMultimediaForm
{
  public function setup()
  {
    
    $this->WEB_IMATGE = 'images/multimedia/';    
    
    $this->setWidgets(array(
      'multimedia_id' => new sfWidgetFormInputHidden(),
      'taula'         => new sfWidgetFormInputHidden(),
      'delete'        => new sfWidgetFormChoice(array('choices'=>array(0=>'No',1=>'Sí'))),
      'url'           => new sfWidgetFormInputFileEditableMy(array('file_src'=>sfConfig::get('sf_webroot').$this->WEB_IMATGE.$this->getObject()->getUrl() , 'is_image'=>true,'with_delete'=>false),array('style'=>'margin-left:20px; margin-right:20px; width:100px')),
      'site_id'       => new sfWidgetFormInputHidden(),
      'actiu'         => new sfWidgetFormInputHidden(),
      'id_extern'     => new sfWidgetFormInputHidden(),
            
    ));

    $this->setValidators(array(
      'multimedia_id' => new sfValidatorInteger(array('required' => false)),
      'taula'         => new sfValidatorString(array('max_length' => 20)),
      'url'           => new sfValidatorFile(array('path'=>$this->WEB_IMATGE , 'required' => false)),
      'site_id'       => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'actiu'         => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
      'id_extern'     => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'delete'        => new sfValidatorBoolean(array(),array()),
    ));    

    $this->widgetSchema->setNameFormat('multimedia[%s]');
    
    $this->widgetSchema->setLabels(array('delete'=>'Esborrar?','url'=>'Foto:'));
                
    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

  }  
    
  public function deleteEmbed($conn = null)
  {        
    $OM = $this->getObject();            
    unlink(sfConfig::get('sf_web_dir').'/'.$this->WEB_IMATGE.$OM->getUrl());
    $OM->delete();        
  }
    
  public function saveEmbed($conn = null)
  {        
    
    $OM = $this->getObject();    
    $OM->save();
              	
    myUser::resizeImage(800,600,sfConfig::get('sf_web_dir').'/'.$this->WEB_IMATGE,$OM->getUrl(),$OM->getMultimediaId().'-L',false);
    $nom = myUser::resizeImage(150,150,sfConfig::get('sf_web_dir').'/'.$this->WEB_IMATGE,$OM->getUrl(),$OM->getMultimediaId(),true);
        
    $OM->setUrl($nom);
  	$OM->save();    
      	  	       
  }
    
}