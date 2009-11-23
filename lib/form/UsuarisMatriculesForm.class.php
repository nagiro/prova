<?php

/**
 * Usuaris form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class UsuarisMatriculesForm extends UsuarisForm
{
  public function setup()
  {

  	parent::setup();
  	
    $this->setWidget('Nivells_idNivells',new sfWidgetFormInputHidden());
    $this->setWidget('Habilitat', new sfWidgetFormInputHidden());
    
    $this->setValidator('DNI', new sfValidatorCallback(array('callback'=>array('UsuarisMatriculesForm','ComprovaDNI'), 'arguments' => array() , 'required'=>true)));         

  }

  static public function ComprovaDNI($A,$valor)
  {
  	  	
  	$DNI = trim($valor);
  	$OUsuari = UsuarisPeer::cercaDNI($DNI);
  	if($OUsuari instanceof Usuaris) throw new sfValidatorError($A, "Error: El DNI ja existeix.");
  	return $valor;
  	  	
  } 
    
}
