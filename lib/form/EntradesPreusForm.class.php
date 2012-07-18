<?php

/**
 * EntradesPreus form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
class EntradesPreusForm extends BaseEntradesPreusForm
{
  public function setup()
  {
    
    $this->setWidgets(array(
      'horari_id'       => new sfWidgetFormInputHidden(),
      'activitat_id'    => new sfWidgetFormInputHidden(),
      'actiu'           => new sfWidgetFormChoice( array( 'choices' => array( 0 => 'No' , 1 => 'Sí' ) ) , array( 'style' => 'width:50px' ) ),
      'Preu'            => new sfWidgetFormInputText(array(),array('style'=>'width:50px')),
      'Places'          => new sfWidgetFormInputText(array(),array('style'=>'width:50px')),            
      'descomptes'      => new sfWidgetFormChoice( array( 'renderer_class' => 'sfWidgetFormSelectManyMyList' , 'choices' => DescomptesPeer::getDescomptesArray($this->getOption('IDS'),false) , 'multiple'=>true ),array( 'style' => 'height:150px' )),
      'PagamentExtern'  => new sfWidgetFormChoice( array( 'renderer_class' => 'sfWidgetFormSelectManyMyList' , 'choices' => TipusPeer::getTipusPagamentArray() , 'multiple'=>true ) , array( 'style' => 'height:150px' ) ),
      'PagamentIntern'  => new sfWidgetFormChoice( array( 'renderer_class' => 'sfWidgetFormSelectManyMyList' , 'choices' => TipusPeer::getTipusPagamentArray() , 'multiple'=>true ) , array( 'style' => 'height:150px' ) ),
      'site_id'         => new sfWidgetFormInputHidden(),      
    ));

    $this->setValidators(array(
      'horari_id'       => new sfValidatorChoice(array('choices' => array($this->getObject()->getHorariId()), 'empty_value' => $this->getObject()->getHorariId(), 'required' => false)),
      'Preu'            => new sfValidatorInteger(array('min' => -32768, 'max' => 32767, 'required' => false)),      
      'Places'          => new sfValidatorInteger(array('min' => -32768, 'max' => 32767, 'required' => false)),      
      'activitat_id'    => new sfValidatorChoice(array('choices' => array($this->getObject()->getActivitatId()), 'empty_value' => $this->getObject()->getActivitatId(), 'required' => false)),
      'descomptes'      => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'PagamentExtern'  => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'PagamentIntern'  => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'site_id'         => new sfValidatorInteger(array('min' => -32768, 'max' => 32767)),
      'actiu'           => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
    ));

    $this->widgetSchema->setNameFormat('entrades_preus[%s]');

    $this->widgetSchema->setLabels(array(      
      'Preu'            => 'Preu',      
      'Places'          => 'Places',
      'Tipus'           => 'Tipus',
      'descomptes'      => 'Descomptes',
      'PagamentExtern'  => 'P. Extranet',
      'PagamentIntern'  => 'P. Intranet',
      'actiu'           => 'Actiu',          
    ));

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
    $this->widgetSchema->setFormFormatterName('SpanHorizontal');
    
  }
 
  public function save($conn = null)
  {

    //Actualitzem l'objecte
	$this->updateObject();
  	$OEP = $this->getObject();
    
    //Guardem els descomptes  	  	  	  	       
  	if(!is_null($this['descomptes']->getValue())) $OEP->setDescomptes(implode('@',$this['descomptes']->getValue()));    
    if(!is_null($this['PagamentExtern']->getValue())) $OEP->setPagamentextern(implode('@',$this['PagamentExtern']->getValue()));
    if(!is_null($this['PagamentIntern']->getValue())) $OEP->setPagamentintern(implode('@',$this['PagamentIntern']->getValue()));
  	  	
  	return $OEP->save();

  }
  
  
}