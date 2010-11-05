<?php

/**
 * Missatges form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class MissatgesForm extends sfFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'MissatgeID'       => new sfWidgetFormInputHidden(),
      'Usuaris_UsuariID' => new sfWidgetFormInputHidden(),
      'Titol'            => new sfWidgetFormInputText(array(),array('class'=>'text')),
      'Text'             => new sfWidgetFormTextareaTinyMCE(array(),array('class'=>'text','style'=>'height:150px;')),
      'Date'             => new sfWidgetFormInputHidden(),
      'Publicacio'       => new sfWidgetFormJQueryDate(array('format'=>'%day%/%month%/%year%'),array()),
      'site_id'          => new sfWidgetFormInputHidden(array(),array()),           
    ));

    $this->setValidators(array(
      'MissatgeID'       => new sfValidatorPropelChoice(array('model' => 'Missatges', 'column' => 'MissatgeID', 'required' => false)),
      'Usuaris_UsuariID' => new sfValidatorPropelChoice(array('model' => 'Usuaris', 'column' => 'UsuariID')),
      'Titol'            => new sfValidatorString(array('required' => true)),
      'Text'             => new sfValidatorString(array('required' => false)),
      'Date'             => new sfValidatorDate(array('required' => false)),
      'Publicacio'       => new sfValidatorDate(array('required' => false)),
      'site_id'          => new sfValidatorPass(array('required' => false)),
    ));
        
    $this->widgetSchema->setNameFormat('missatges[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    
    $this->widgetSchema->setLabels(array(
    	'Titol' 	=> 'Títol: ',
    	'Text' 		=> 'Text: ',
    	'Publicacio'=> 'Data de publicació: ', 
    ));
    
    $this->widgetSchema->setAttribute('width','60px');
   
    
    $this->setDefaults(array(
    	'Titol' 		=> '',
    	'Text'  		=> '',
    	'Date'			=> date('Y-m-d',time()),
    	'Publicacio' 	=> date('Y-m-d',time()),    	    	
    ));
    
    $this->widgetSchema->setFormFormatterName('Span');
    
  }
  
  public function save($conn = null)
  {
  	
  	$this->updateObject();
  	$OM = $this->getObject();  	  	  	  	  	
  	$OM->setDate(date('Y-m-d',time()));
  	$OM->save();
  	  	  	  	  	   	
  }
  
	public function getModelName()
  	{
		return 'Missatges';
  	}
  
}
