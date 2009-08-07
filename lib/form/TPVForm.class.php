<?php

class CercaForm extends sfForm
{
  public function configure()
  {
    $this->setWidgets(array(
      'text'    => new sfWidgetFormInput()      
    ));
    
        
    $this->setDefault('text','Entra el text a cercar');    
    $this->setValidator('text',new sfValidatorString(array('required'=>false)));

    $this->widgetSchema->setlabels(array('text'=>'CERCA:'));
    $this->widgetSchema->setNameFormat('cerca[%s]');
    
    
  }
}

?>
