<?php

class EditorHtmlForm extends BaseForm
{
  public function configure()
  {
    $this->setWidgets(array(
      'titol' => new sfWidgetFormInputText(array(),array('style'=>'width:500px')),
      'html'  => new sfWidgetFormTextareaTinyMCE(array(),array()),            
    ));
    
        
        
    $this->setValidator('titol',new sfValidatorString(array('required'=>false)));
    $this->setValidator('html',new sfValidatorString(array('required'=>false)));

    $this->widgetSchema->setLabels(array('text'=>'Titol: ','html'=>'Cos: '));
    $this->widgetSchema->setNameFormat('editor[%s]');    
    
  }
  
  public function setChoice(array $Choice)
  {
  	$this['select']->getWidget()->setOption('choices',$Choice);  	  
  }
  
  
}

?>
