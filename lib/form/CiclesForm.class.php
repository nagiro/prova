<?php

/**
 * Cicles form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Albert Johé i Martí
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class CiclesForm extends BaseCiclesForm
{
	
  public function setup()
  {

  	//Guardo el nom de l'arxiu només
  	//Després hi aplico els directoris segons sigui configurat
  	
  	$this->WEB_IMAGE  = 'images/cicles/'; 
  	$this->WEB_PDF    = 'images/cicles/';
  	
    $this->setWidgets(array(	  
      'extingit' => new sfWidgetFormChoice(array('choices'=>array(0=>'No',1=>'Sí')),array()),
      'Visibleweb' => new sfWidgetFormChoice(array('choices'=>array(0=>'No',1=>'Sí')),array()),    
      'CicleID'  => new sfWidgetFormInputHidden(),
      'Nom'      => new sfWidgetFormInputText(array(),array('style'=>'width:300px')),
      /*'Imatge'   => new sfWidgetFormInputFileEditableMy(array('file_src'=>OptionsPeer::getString('SF_WEBROOT',1).$this->WEB_IMAGE.$this->getObject()->getImatge() , 'is_image'=>true,'with_delete'=>false),array('style'=>'width:100px')),*/
      /*'PDF'      => new sfWidgetFormInputFileEditableMy(array('file_src'=>OptionsPeer::getString('SF_WEBROOT',1).$this->WEB_PDF.$this->getObject()->getPdf() , 'is_image'=>false,'with_delete'=>false)),*/
      /*'tCurt'    => new sfWidgetFormInputText(array(),array('style'=>'width:300px')),*/
      /*'dCurt'    => new sfWidgetFormTextareaTinyMCE(),*/
      'tMig'     => new sfWidgetFormInputText(array(),array('style'=>'width:300px')),
      'dMig'     => new sfWidgetFormTextareaTinyMCE(),
      'tComplet' => new sfWidgetFormInputText(array(),array('style'=>'width:300px')),
      'dComplet' => new sfWidgetFormTextareaTinyMCE(),      
    ));

    $this->setValidators(array(
      'CicleID'  => new sfValidatorPropelChoice(array('model' => 'Cicles', 'column' => 'CicleID', 'required' => false)),
      'Nom'      => new sfValidatorString(array('required' => false)),
      /*'Imatge'   => new sfValidatorFile(array('path'=>$this->WEB_IMAGE , 'required' => false)),*/
      /*'PDF'      => new sfValidatorFile(array('path'=>$this->WEB_PDF , 'required' => false)),*/
      /*'tCurt'    => new sfValidatorString(array('required' => false)),*/
      /*'dCurt'    => new sfValidatorString(array('required' => false)),*/
      'tMig'     => new sfValidatorString(array('required' => false)),
      'dMig'     => new sfValidatorString(array('required' => false)),
      'tComplet' => new sfValidatorString(array('required' => false)),
      'dComplet' => new sfValidatorString(array('required' => false)),
      'extingit' => new sfValidatorChoice(array('choices'=>array(0,1)),array()),
      'Visibleweb' => new sfValidatorChoice(array('choices'=>array(0,1)),array()),
    ));
    
    $this->widgetSchema->setLabels(array(
      'extingit' => 'Extingit? ',      
      'Nom'      => 'Nom: ',
      'Imatge'   => 'Imatge: ',
      'PDF'      => 'PDF: ',
      'tCurt'    => 'Títol curt: ',
      'dCurt'    => 'Text curt: ',
      'tMig'     => 'Títol mig: ',
      'dMig'     => 'Text mig: ',
      'tComplet' => 'Títol complet: ',
      'dComplet' => 'Text complet: ',
      'Visibleweb'=> 'Visible WEB?',
      
    ));
    
    $this->widgetSchema->setNameFormat('cicles[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
    
	$this->widgetSchema->setFormFormatterName('Span');    
   
  }

  public function getModelName()
  {
    return 'Cicles';
  }
  
  public function save($conn = null)
  { 
 
  	parent::save();    
  	
    //Si guardem el cicle per primera vegada, mirem les imatges que s'han entrat i que no tenen cicle. Les assignarem a aquest.
    $dir = getcwd().'/images/cicles/';
    $mini = false; $normal = false; $big = false; $pdf = false; 
    $IDC = $this->getObject()->getCicleid();
    foreach ( glob( $dir.'C--*' ) as $K => $arxiu ) {
        $a = str_replace( $dir , "", $arxiu );
        //Si té un -M és la foto mini.
        if( substr_count( $arxiu , "-M" ) > 0)      rename( $arxiu , str_replace( '--' , '-'.$IDC.'-' , $arxiu ) );
        if( substr_count( $arxiu , "-L" ) > 0)      rename( $arxiu , str_replace( '--' , '-'.$IDC.'-' , $arxiu ) );
        if( substr_count( $arxiu , "-XL" ) > 0)     rename( $arxiu , str_replace( '--' , '-'.$IDC.'-' , $arxiu ) );
        if( substr_count( $arxiu , "-PDF" ) > 0)    rename( $arxiu , str_replace( '--' , '-'.$IDC.'-' , $arxiu ) );
    }        
    
    /*
  	$BASE = sfConfig::get('sf_web_dir').'/'.$this->WEB_IMAGE;  	
  	$OC = $this->getObject(); 	
  	if($OC instanceof Cicles):
  	  		
  		$I = $OC->getImatge();
  		if(!empty($I) && file_exists($BASE.$I)):  				
		  	$img = new sfImage($BASE.$I,'image/jpg');  	
		    $img->resize(100,100);
		    $nom = $OC->getCicleid().'.jpg';
		    $img->saveAs($BASE.$nom);
		    if( $I <> $nom ) unlink($BASE.$I);		    
		    $OC->setImatge($nom)->save();		    
	    endif;
	    
	    $P = $OC->getPdf();  		
  		if(!empty($P) && file_exists($BASE.$P)):  		
  			$nom = $OC->getCicleid().'.pdf';		
		  	rename($BASE.$P,$BASE.$nom);
		    if( $P <> $nom ) unlink($BASE.$P);		    
		    $OC->setPdf($nom)->save();		    
	    endif;	    	      	    	    	      	    
	endif;
    */
  }
	
}
