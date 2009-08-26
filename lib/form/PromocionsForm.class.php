<?php

/**
 * Promocions form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class PromocionsForm extends sfFormPropel
{
	
  public function setup()
  {
  	
    $this->setWidgets(array(
      'PromocioID' => new sfWidgetFormInputHidden(),
      'Nom'        => new sfWidgetFormInput(array(),array('style'=>'width:400px')),
      'Ordre'      => new sfWidgetFormChoice(array('choices'=>PromocionsPeer::selectOrdre($this->isNew()))),    
      'isActiva'   => new sfWidgetFormInputCheckbox(array(),array('value'=>true)),
      'isFixa'     => new sfWidgetFormInputCheckbox(array(),array('value'=>true)),
      'URL'        => new sfWidgetFormInputHidden(),      
    ));
    
    $this->setValidators(array(
      'PromocioID' => new sfValidatorPropelChoice(array('model' => 'Promocions', 'column' => 'PromocioID', 'required' => false)),
      'Nom'        => new sfValidatorString(array('required' => false)),
      'Ordre'      => new sfValidatorInteger(array('required' => false)),            
      'isActiva'   => new sfValidatorInteger(array('required' => false)),
      'isFixa'     => new sfValidatorInteger(),
      'URL'        => new sfValidatorString(array('required'=>false)),
    ));

    
    $OPromocio = $this->getObject();
  	if($OPromocio instanceOf Promocions)
  		 $this->setWidget('Extensio', new sfWidgetFormInputFileEditable(array('file_src'=>'/intranet/web/images/banners/'.$OPromocio->getExtensio(),'edit_mode'=>true,'is_image'=>true,'with_delete'=>false)));
	else $this->setWidget('Extensio', new sfWidgetFormInputFile());		  		
	$this->validatorSchema['Extensio'] = new sfValidatorFile(array('path' => '/intranet/web/images/banners', 'required' => false));
    
    
    $this->widgetSchema->setNameFormat('promocions[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Promocions';
  }
  
  public function save($conn = null)
  {
  	
  	 $file = $this->getValue('Extensio');  	 
  	 if($file instanceof sfWidgetFormInputFile)
  	 {
	   	 $filename = 'banner_'.sha1($file->getOriginalName());
  		 $extension = $file->getExtension($file->getOriginalExtension());
     	 $file->save('/intranet/web/images/banner/'.$filename.$extension);
  	 }
  	  	  	
  	 $OPromocions = $this->getObject();  	
  	 PromocionsPeer::gestionaOrdre($this->getValue('Ordre'),$OPromocions->getOrdre());
  	   		  	
  	 parent::save();
  	 
  	
  }  
  
}
