<?php

/**
 * AppDocumentsDirectoris form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class AppDocumentsDirectorisForm extends sfFormPropel
{
	
  public function setup()
  {
  	
    $this->setWidgets(array(
      'idDirectori'                     => new sfWidgetFormInputHidden(),
      'Nom'                             => new sfWidgetFormInput(),
      'Pare'                            => new sfWidgetFormPropelChoice(array('model' => 'AppDocumentsDirectoris', 'add_empty' => true)), 
    ));

    $this->setValidators(array(
      'idDirectori'                     => new sfValidatorPropelChoice(array('model' => 'AppDocumentsDirectoris', 'column' => 'idDirectori', 'required' => false)),
      'Nom'                             => new sfValidatorString(),
      'Pare'                            => new sfValidatorPropelChoice(array('model' => 'AppDocumentsDirectoris', 'column' => 'idDirectori', 'required' => false)),      
    ));

    $this->widgetSchema->setNameFormat('app_documents_directoris[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
    
  }

  public function getModelName()
  {
    return 'AppDocumentsDirectoris';
  }
	
}
