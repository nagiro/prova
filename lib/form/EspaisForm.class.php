<?php

/**
 * Espais form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class EspaisForm extends BaseEspaisForm
{
    
  public function setup()
  {
    
    $this->WEB_IMATGE = 'images/espais/';   	    
    $Sino = array(0=>'No',1=>'Sí');
    $this->IDS = $this->getOption('IDS');
    
    $this->setWidgets(array(
      'EspaiID'     => new sfWidgetFormChoice(array('choices'=>EspaisPeer::select($this->IDS,true)),array()),
      'Nom'         => new sfWidgetFormInputText(array(),array('style'=>'width:400px')),
      'Ordre'       => new sfWidgetFormInputText(array(),array('style'=>'width:50px')),
      'site_id'     => new sfWidgetFormInputHidden(),
      'actiu'       => new sfWidgetFormInputHidden(),
      'isLlogable'  => new sfWidgetFormChoice(array('choices'=>$Sino)),
      'descripcio'  => new sfWidgetFormTextareaTinyMCE(array(),array()), 
    ));

    $this->setValidators(array(
      'EspaiID' => new sfValidatorPass(),
      'Nom'     => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'Ordre'   => new sfValidatorInteger(array('min' => -32768, 'max' => 32767)),
      'site_id' => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'actiu'   => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
      'isLlogable'=> new sfValidatorPass(array(),array()),
      'descripcio' => new sfValidatorString(array('required'=>false),array()),             
    ));

    $this->widgetSchema->setNameFormat('espais[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
    
    $this->widgetSchema->setLabels(array(
      'EspaiID' => 'Espai ',
      'Nom'     => 'Nom ',
      'Ordre'   => 'Ordre ',      
      'isLlogable' => 'Es lloga?',
      'descripcio' => 'Descripció ',      
    ));
      
    if(!$this->getObject()->isNew()):
        $subForm = new sfForm();
        $subForm->widgetSchema->setFormFormatterName('Horizontal');
        $OE = $this->getObject();
        $count = 1;
        
        foreach($OE->getFotos() as $OM){                        
            $form = new MultimediaForm($OM);            
            $subForm->embedForm($count++, $form);            
        }
        $form = MultimediaPeer::initialize(NULL,$this->IDS,MultimediaPeer::CONST_ESPAI,$OE->getEspaiid());        
        $subForm->embedForm(0, $form);
        $this->embedForm('Fotos',$subForm);            
    endif;
        
  }

  public function saveEmbeddedForms($con = null, $forms = null)
  {    
    if (null === $forms)
    {
      $photos = $this->getValue('Fotos');      
      $forms = $this->embeddedForms;
      if(empty($photos[0]['url'])) unset($forms['Fotos'][0]);
      if(isset($this->embeddedForms['Fotos'])):
          foreach ($this->embeddedForms['Fotos']->getEmbeddedForms() as $K=>$MultimediaForm)
          {         
            if($photos[$K]['delete']) $MultimediaForm->deleteEmbed();
            else $MultimediaForm->saveEmbed();        
          }        
      endif;
    }              
    return true;
  }

  public function getModelName()
  {
    return 'Espais';
  }

}