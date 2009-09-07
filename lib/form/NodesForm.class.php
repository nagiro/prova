<?php

/**
 * Nodes form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class NodesForm extends sfFormPropel
{

  public function setup()
  {
    $this->setWidgets(array(
      'idNodes'     => new sfWidgetFormInputHidden(),
      'TitolMenu'   => new sfWidgetFormInput(array(),array('style'=>'width:400px')),
      'Nivell'      => new sfWidgetFormChoice(array('choices'=>array(1=>'1',2=>'2',3=>'3'))),      
      'Ordre'       => new sfWidgetFormChoice(array('choices'=>NodesPeer::selectOrdre($this->isNew()))),      
      'isCategoria' => new sfWidgetFormInputCheckbox(array(),array('value'=>true)),
      'isPhp'       => new sfWidgetFormInputHidden(),
      'isActiva'    => new sfWidgetFormInputCheckbox(array(),array('value'=>true)),
      'HTML'        => new sfWidgetFormInputHidden(),
      'Url'         => new sfWidgetFormInput(array(),array('style'=>'width:400px')),
    ));

    $this->setValidators(array(
      'idNodes'     => new sfValidatorPropelChoice(array('model' => 'Nodes', 'column' => 'idNodes', 'required' => false)),
      'TitolMenu'   => new sfValidatorString(array('required' => false)),
      'HTML'        => new sfValidatorString(array('required' => false)),
      'isCategoria' => new sfValidatorPass(),
      'isPhp'       => new sfValidatorPass(),
      'isActiva'    => new sfValidatorPass(),
      'Ordre'       => new sfValidatorInteger(array('required' => false)),
      'Nivell'      => new sfValidatorInteger(),
      'Url'			=> new sfValidatorString(array('required'=>false)),
    ));

    
    $this->widgetSchema->setDefaults(array(      
      'TitolMenu'   => 'Entreu el títol...',
      'Nivell'      => '1',      
      'Ordre'       => '1',      
      'isCategoria' => false,
      'isActiva'    => true,      
      'Url'         => "",
    ));
    
    $this->widgetSchema->setLabels(array(      
      'TitolMenu'   => 'Títol',
      'Nivell'      => 'Nivell',      
      'Ordre'       => 'Ordre',      
      'isCategoria' => 'És una categoria?',
      'isPhp'       => 'Hi ha codi php?',
      'isActiva'    => 'Està activa?',
      'URL'         => 'Adreça?',
    ));
    
    $this->widgetSchema->setNameFormat('nodes[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Nodes';
  }
  
  public function save($conn = null)
  {  	
  	$ONodes = $this->getObject();  	
  	NodesPeer::gestionaOrdre($this->getValue('Ordre'),$ONodes->getOrdre());
  	parent::save();  
  }


}
