<?php

/**
 * Matricules form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class MatriculesUsuariForm extends sfFormPropel
{
	
  public function setup()
  {  	
  	
  	$this->setWidgets(array(
      'idMatricules'     => new sfWidgetFormInputHidden(),  	    	  
  	  'Cursos_idCursos'  => new sfWidgetFormInputHidden(),  	  
      'Estat'            => new sfWidgetFormInputHidden(),
      'Comentari'        => new sfWidgetFormInputHidden(),
      'DataInscripcio'   => new sfWidgetFormInputHidden(),
      'Pagat'        	 => new sfWidgetFormInputHidden(),
  	  'Usuaris_usuariID' => new sfWidgetFormJQueryAutocompleter(array('config'=>'{ max:20 , width:500 }' , 'url'=>$this->getOption('url'))),
      'tReduccio'        => new sfWidgetFormChoice(array('choices'=>MatriculesPeer::selectDescomptes())),
      'tPagament'        => new sfWidgetFormChoice(array('choices'=>MatriculesPeer::selectPagament())),
    ));

    $this->setValidators(array(      
      'idMatricules'     => new sfValidatorPropelChoice(array('model' => 'Matricules', 'column' => 'idMatricules', 'required' => false)),
      'Usuaris_usuariID' => new sfValidatorCallback(array('callback'=>array('MatriculesUsuariForm','ComprovaUsuari'), 'arguments' => array() , 'required'=>true)),
      'Cursos_idCursos'  => new sfValidatorPropelChoice(array('required' => false,'model' => 'Cursos', 'column' => 'idCursos')),
      'Estat'            => new sfValidatorInteger(array('required' => false)),
      'Comentari'        => new sfValidatorString(array('required' => false)),
      'DataInscripcio'   => new sfValidatorDateTime(array('required' => false)),
      'Pagat'            => new sfValidatorNumber(array('required' => false)),
      'tReduccio'        => new sfValidatorInteger(),
      'tPagament'        => new sfValidatorInteger(),    
    ));

    $this->widgetSchema->setLabels(array(                  
      'Usuaris_usuariID' => 'Usuari: ',
      'Cursos_idCursos'  => 'Curs: ',
      'Estat'            => 'Estat: ',
      'Comentari'        => 'Comentari: ',
      'DataInscripcio'   => 'Data d\'inscripció: ',
      'Descompte'        => 'Te descompte? ',
      'tReduccio'        => 'Te reducció? ',
      'tPagament'        => 'Com ha pagat? ',
    ));    
    
    $this->widgetSchema->setNameFormat('matricules_usuari[%s]');

    $this->setDefaults(array('Estat' => MatriculesPeer::EN_PROCES));
    
    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

  }

  public function getModelName()
  {
    return 'Matricules';
  }
  
  static public function ComprovaUsuari($A,$valor)
  {
  	
	throw new sfValidatorError($A, "Error: L'usuari no ha cursat cap curs amb anterioritat");
  	return $valor;  	
  }

}
