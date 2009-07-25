<?php

class CercaChoiceForm extends sfForm
{
  public function configure()
  {
    $this->setWidgets(array(
      'text'    => new sfWidgetFormChoice(array('choices'=>array()))      
    ));
    
        
    $this->setDefault('text','Entra el text a cercar');    
    $this->setValidator('text',new sfValidatorString(array('required'=>false)));

    $this->widgetSchema->setlabels(array('text'=>'CERCA'));
    $this->widgetSchema->setNameFormat('cerca[%s]');
    
    
  }
  
  public function setChoice(array $Choice)
  {
  	$this['text']->getWidget()->setOption('choices',$Choice);  	  
  }
  
}

?>
