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
  	
  	$this->WEB_IMAGE  = 'images/noticies/'; 
  	$this->WEB_PDF    = 'images/noticies/';
  	
    $this->setWidgets(array(
      'idNoticia'      	=> new sfWidgetFormInputHidden(),
      'TitolNoticia'   	=> new sfWidgetFormInputText(array(),array('style'=>'width:400px')),
      'TextNoticia'    	=> new sfWidgetFormTextareaTinyMCE(),
      'DataPublicacio' 	=> new sfWidgetFormJQueryDate(array('format'=>'%day%/%month%/%year%'),array()),
      'DataDesaparicio' => new sfWidgetFormJQueryDate(array('format'=>'%day%/%month%/%year%'),array()),
      'Activa'         	=> new sfWidgetFormChoice(array('choices'=>array(0=>'No',1=>'Sí'))),
      'Imatge'         	=> new sfWidgetFormInputFileEditableMy(array('file_src'=>sfConfig::get('sf_webrooturl').$this->WEB_IMAGE.$this->getObject()->getImatge(), 'is_image'=>true , 'with_delete'=>false)),
      'Adjunt'         	=> new sfWidgetFormInputFileEditableMy(array('file_src'=>sfConfig::get('sf_webrooturl').$this->WEB_PDF.$this->getObject()->getAdjunt(),'with_delete'=>false)),
      'idActivitat'    	=> new sfWidgetFormInputHidden(),
      
    ));

    $this->setValidators(array(
      'idNoticia'      	=> new sfValidatorPropelChoice(array('model' => 'Noticies', 'column' => 'idNoticia', 'required' => false)),
      'TitolNoticia'   	=> new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'TextNoticia'    	=> new sfValidatorString(array('required' => false)),
      'DataPublicacio' 	=> new sfValidatorDate(array('required' => false)),
      'Activa'         	=> new sfValidatorBoolean(array('required' => false)),
      'Imatge'         	=> new sfValidatorFile(array('path'=> $this->WEB_IMAGE , 'required'=>false)),
      'Adjunt'         	=> new sfValidatorFile(array('path'=> $this->WEB_PDF , 'required'=>false)),
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
  
  public function save($conn = null)
  {
  	
  	parent::save();
  	
  	$BASE = sfConfig::get('sf_web_dir').'/'.$this->WEB_IMAGE;  	
  	$ON = $this->getObject(); 	
  	if($ON instanceof Noticies):
  	  		
  		$I = $ON->getImatge();
  		if(!empty($I) && file_exists($BASE.$I)):  				
		  	$img = new sfImage($BASE.$I,'image/jpg');  	
		    $img->resize(100,100);
		    $nom = $ON->getIdnoticia().'.jpg';
		    $img->saveAs($BASE.$nom);
		    if( $I <> $nom ) unlink($BASE.$I);		    
		    $ON->setImatge($nom)->save();		    
	    endif;
	    
	    $P = $ON->getAdjunt();  		
  		if(!empty($P) && file_exists($BASE.$P)):  		
  			$nom = $ON->getIdnoticia().'.pdf';		
		  	rename($BASE.$P,$BASE.$nom);
		    if( $I <> $nom ) unlink($BASE.$P);		    
		    $ON->setAdjunt($nom)->save();		    
	    endif;	    	      	    	    	      	    
	endif;
	
  }

}