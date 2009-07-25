<?php

/**
 * Agendatelefonica form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class AgendatelefonicaForm extends BaseFormPropel
{
	
  public function setup()
  {
  	  	
  	
    $this->setWidgets(array(
      'AgendaTelefonicaID' => new sfWidgetFormInputHidden(),
      'Nom'                => new sfWidgetFormInput(array(),array('class'=>'cent')),
      'NIF'                => new sfWidgetFormInput(array(),array('class'=>'cent')),      
      'Notes'              => new sfWidgetFormTextarea(array(),array('class'=>'cent')),
      'Tags'               => new sfWidgetFormInput(array(),array('class'=>'cent')),
      'Entitat'            => new sfWidgetFormInput(array(),array('class'=>'cent'))
    ));

    $this->setValidators(array(
      'AgendaTelefonicaID' => new sfValidatorPropelChoice(array('model' => 'Agendatelefonica', 'column' => 'AgendaTelefonicaID', 'required' => false)),
      'Nom'                => new sfValidatorString(array('required' => false)),
      'NIF'                => new sfValidatorString(array('required' => false)),
      'Notes'              => new sfValidatorString(array('required' => false)),
      'Tags'               => new sfValidatorString(array('required' => false)),
      'Entitat'            => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('agendatelefonica[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
    
    
    //unset($this['dataalta']);
  
	$this->widgetSchema->setLabels(array(
	      	'Nom'    	=> 'Nom : ',
	      	'NIF'      	=> 'DNI : ',	      	
			'Notes'   	=> 'Notes : ',
			'Tags'   	=> 'Tags :',
			'Entitat'   => 'Entitat : ',
	
	));
	  
   	$this->widgetSchema->setHelp('is_public', 'Whether the job can also be published on affiliate websites or not.');  		


   	$i=0; $ENBLANC = false;
	foreach ($this->getObject()->getAgendatelefonicadadess() as $dades)
	{  		
		$FDades = new AgendatelefonicadadesForm($dades);	
		$FDades->widgetSchema->setFormFormatterName('Horizontal');		
		$this->embedForm('Dades '.$i++, $FDades);
		$dada = $dades->getDada();						
		if(strlen($dada) == 0) $ENBLANC = true;		
	}

	//Si no en tenim cap en blanc, n'afegim un
	if(!$ENBLANC):
	
		$ATD = new Agendatelefonicadades();
		$ATD->setAgendatelefonicaAgendatelefonicaid($this->getObject()->getAgendatelefonicaid());
		
		$FDades = new AgendatelefonicadadesForm($ATD);
		$FDades->widgetSchema->setFormFormatterName('Horizontal');		
		$this->embedForm('Dades '.$i++, $FDades);
			 
	endif;
	
    parent::setup();
  }

  
  public function getModelName()
  {
    return 'Agendatelefonica';
  }	
	
}
