<?php

/**
 * Activitats form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class ActivitatsTextosForm extends sfFormPropel
{
  public function setup()
  {
  	
  	$URL_IMATGE = sfConfig::get('sf_web_dir').'/images/noticies'; 
  	$URL_PDF    = sfConfig::get('sf_web_dir').'/images/noticies'; 
  	
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
	  'PublicaWEB'                      => new sfWidgetFormChoice(array('choices'=>array(2=>'No',1=>'Sí'))),
      'tipusEnviament'					=> new sfWidgetFormChoice(array('choices'=>ActivitatsPeer::getTipusEnviamentsSelect())),
      'Imatge'                          => new sfWidgetFormInputFileEditableMy(array('file_src'=>sfConfig::get('sf_webroot').'images/noticies/'.$this->getObject()->getImatge() , 'is_image'=>true,'with_delete'=>false),array('style'=>'width:100px')),
      'PDF'                             => new sfWidgetFormInputFileEditableMy(array('file_src'=>sfConfig::get('sf_webroot').'images/noticies/'.$this->getObject()->getPdf() , 'is_image'=>false,'with_delete'=>false)),                  
      'tCurt'                           => new sfWidgetFormInput(array(),array('style'=>'width:300px')),
      'dCurt'                           => new sfWidgetFormTextareaTinyMCE(),
      'tMig'    	                    => new sfWidgetFormInput(array(),array('style'=>'width:300px')),
      'dMig'	                        => new sfWidgetFormTextareaTinyMCE(),
      'tComplet'                        => new sfWidgetFormInput(array(),array('style'=>'width:300px')),
      'dComplet'                        => new sfWidgetFormTextareaTinyMCE(),      
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
      'Imatge'                          => new sfValidatorFile(array('path'=>$URL_IMATGE , 'required' => false)),
      'PDF'                             => new sfValidatorFile(array('path'=>$URL_PDF , 'required' => false)),
      'PublicaWEB'                      => new sfValidatorInteger(array('required' => false)),
      'tCurt'                           => new sfValidatorString(array('required' => false)),
      'dCurt'                           => new sfValidatorString(array('required' => false)),
      'tMig'		                    => new sfValidatorString(array('required' => false)),
      'dMig'	                        => new sfValidatorString(array('required' => false)),
      'tComplet'                        => new sfValidatorString(array('required' => false)),
      'dComplet'                        => new sfValidatorString(array('required' => false)),
      'tipusEnviament'					=> new sfValidatorChoice(array('choices'=>ActivitatsPeer::getTipusEnviamentsSelectValidator())),
    ));

    $this->widgetSchema->setLabels(array(
      'Descripcio'                      => 'Descripció: ',
      'Imatge'                          => 'Imatge: ',
      'PDF'                             => 'PDF: ',
      'PublicaWEB'                      => 'Publicar externament? ',
      'tCurt'                           => 'Títol curt: ',
      'dCurt'                           => 'Text curt:<div class="textExplicacio">Twitter, Llistat activitats, Programa mensual</div>',
      'tMig'    	                    => 'Títol mig:',
      'dMig'	                        => 'Text mig: <div class="textExplicacio">Consulta activitat, Notícies, Facebook, Mitjans</div> ',
      'tComplet'                        => 'Títol complet: ',
      'dComplet'                        => 'Text complet: <div class="textExplicacio">Cursos, ús intern</div>',
      'tipusEnviament'					=> 'Període publicació: <div class="textExplicacio">Quan es publica el text als mitjans?</div>', 
    ));
    
    
    $this->widgetSchema->setNameFormat('activitats[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
    
    $this->widgetSchema->setFormFormatterName('Span');
    
    
  }

  public function getModelName()
  {
    return 'Activitats';
  }
  
	  
}
