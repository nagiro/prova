<?php

/**
 * Activitats form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Albert Johé i Martí
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class ActivitatsTextosForm extends sfFormPropel
{
  public function setup()
  {
  	
  	$this->WEB_IMATGE = 'images/activitats/'; 
  	$this->WEB_PDF    = 'images/activitats/'; 
  	
    $this->setWidgets(array(
      'ActivitatID'                     => new sfWidgetFormInputHidden(),
      'Cicles_CicleID'                  => new sfWidgetFormInputHidden(),
      'TipusActivitat_idTipusActivitat' => new sfWidgetFormInputHidden(),
      'Nom'                             => new sfWidgetFormInputHidden(),
      'Preu'                            => new sfWidgetFormInputHidden(),
      'PreuReduit'                      => new sfWidgetFormInputHidden(), 
      'Publicable'                      => new sfWidgetFormInputHidden(),
      'Estat'                           => new sfWidgetFormInputHidden(),
      'Descripcio'                      => new sfWidgetFormInputHidden(),
	  'PublicaWEB'                      => new sfWidgetFormChoice( array( 'choices' => array( 2 => 'No' , 1=> 'Sí' ) ) ),
      /* 'tipusEnviament'					=> new sfWidgetFormChoice(array('choices'=>ActivitatsPeer::getTipusEnviamentsSelect())),*/
      /* 'Imatge'                          => new sfWidgetFormInputFileEditableMy(array('file_src'=>sfConfig::get('sf_webroot').$this->WEB_IMATGE.$this->getObject()->getImatge() , 'is_image'=>true,'with_delete'=>false),array('style'=>'width:100px')), */
      /* 'PDF'                             => new sfWidgetFormInputFileEditableMy(array('file_src'=>sfConfig::get('sf_webroot').$this->WEB_PDF.$this->getObject()->getPdf() , 'is_image'=>false,'with_delete'=>false)), */                  
      /* 'tCurt'                           => new sfWidgetFormInputText(array(),array('style'=>'width:300px')), */
      /* 'dCurt'                           => new sfWidgetFormTextareaTinyMCE(), */
      'tMig'    	                    => new sfWidgetFormInputText(array(),array('style'=>'width:300px')),
      'dMig'	                        => new sfWidgetFormTextareaTinyMCE(),
      'tComplet'                        => new sfWidgetFormInputText(array(),array('style'=>'width:300px')),
      'dComplet'                        => new sfWidgetFormTextareaTinyMCE(),
      'InfoPractica'                    => new sfWidgetFormTextareaTinyMCE(),
      'Categories'						=> new sfWidgetFormChoice(array('renderer_class'=>'sfWidgetFormSelectManyMy' , 'choices'=>ActivitatsPeer::selectCategoriaActivitat($this->getOption('IDS')) , 'multiple'=>true , 'expanded'=>true),array('class'=>'ul_cat')),
            
    ));

    $this->setValidators(array(
      'ActivitatID'                     => new sfValidatorPropelChoice(array('model' => 'Activitats', 'column' => 'ActivitatID', 'required' => false)),
      'Cicles_CicleID'                  => new sfValidatorPropelChoice(array('model' => 'Cicles', 'column' => 'CicleID', 'required' => false)),
      'TipusActivitat_idTipusActivitat' => new sfValidatorPropelChoice(array('model' => 'Tipusactivitat', 'column' => 'idTipusActivitat', 'required' => false)),
      'Nom'                             => new sfValidatorString(array('required' => false)),
      'Preu'                            => new sfValidatorNumber(array('required' => false)),
      'PreuReduit'                      => new sfValidatorNumber(array('required' => false)),
      'Publicable'                      => new sfValidatorInteger(array('required' => false)),
      'Estat'                           => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'Descripcio'                      => new sfValidatorString(array('required' => false)),
      'Imatge'                          => new sfValidatorFile(array('path'=>$this->WEB_IMATGE , 'required' => false)),
      'PDF'                             => new sfValidatorFile(array('path'=>$this->WEB_PDF , 'required' => false)),
      'PublicaWEB'                      => new sfValidatorInteger(array('required' => false)),
      'tCurt'                           => new sfValidatorString(array('required' => false)),
      'dCurt'                           => new sfValidatorString(array('required' => false)),
      'tMig'		                    => new sfValidatorString(array('required' => false)),
      'dMig'	                        => new sfValidatorString(array('required' => false)),
      'tComplet'                        => new sfValidatorString(array('required' => false)),
      'dComplet'                        => new sfValidatorString(array('required' => false)),
      'tipusEnviament'					=> new sfValidatorChoice(array('required'=>false, 'choices'=>ActivitatsPeer::getTipusEnviamentsSelectValidator())),
      'Categories'						=> new sfValidatorString(array('required'=>false)),
      'InfoPractica'                    => new sfValidatorString(array('required'=>false)),      
    ));

    $this->widgetSchema->setLabels(array(
      'Descripcio'                      => 'Descripció: ',
      'PublicaWEB'                      => 'Publicar web? ',
      /* 'tCurt'                           => 'Títol curt: ', */
      /* 'dCurt'                           => 'Text curt:<div class="textExplicacio">Twitter, Llistat activitats, Programa mensual</div>', */
      'tMig'    	                    => 'Títol mig:',
      'dMig'	                        => 'Text mig: <div class="textExplicacio">Consulta activitat, Notícies, Facebook, Mitjans</div> ',
      'tComplet'                        => 'Títol complet: ',
      'dComplet'                        => 'Text complet: <div class="textExplicacio">Cursos, és intern</div>',
      /* 'tipusEnviament'					=> 'PerÃ­ode publicaciÃ³: <div class="textExplicacio">Quan es publica el text als mitjans?</div>', */
      'Categories'						=> 'Categories: ', 
      'InfoPractica'                    => 'Informació pràctica (web)',
    ));
    
    
    $this->widgetSchema->setNameFormat('activitats[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
    
    $this->widgetSchema->setFormFormatterName('Span');
    
    
  }

  public function getModelName()
  {
    return 'Activitats';
  }

  
  public function save($conn = null)
  {
  	  	
  	$this->updateObject();
  	$OR = $this->getObject();	  	  	  	  	  	  	
  	if(!is_null($this['Categories']->getValue())) $OR->setCategories(implode('@',$this['Categories']->getValue()));        
  	$OR->save();  	
  	  	
  }
  
}
