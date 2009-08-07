<?php

/**
 * Matricules form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class MatriculesForm extends sfFormPropel
{
  public function setup()
  {  	
  	
  	$this->setWidgets(array(
      'idMatricules'     => new sfWidgetFormInputHidden(),
  	  'Usuaris_usuariID' => new sfWidgetFormInput(),
  	  'Cursos_idCursos'  => new sfWidgetFormChoice(array('choices'=>CursosPeer::getSelectCursosActius())),
      'Estat'            => new sfWidgetFormChoice(array('choices'=>MatriculesPeer::getEstatsSelect())),
      'Comentari'        => new sfWidgetFormTextarea(),
      'DataInscripcio'   => new sfWidgetFormDateTime(array('date'=>array('format'=>'%day%/%month%/%year%'))),
      'Descompte'        => new sfWidgetFormInput(),
      'tReduccio'        => new sfWidgetFormChoice(array('choices'=>MatriculesPeer::selectDescomptes())),
      'tPagament'        => new sfWidgetFormChoice(array('choices'=>MatriculesPeer::selectPagament())),
    ));

    $this->setValidators(array(
      'idMatricules'     => new sfValidatorPropelChoice(array('model' => 'Matricules', 'column' => 'idMatricules', 'required' => false)),
      'Usuaris_usuariID' => new sfValidatorPropelChoice(array('model'=>'Usuaris','column'=>'DNI'),array('invalid'=>'El DNI és incorrecte')),
      'Cursos_idCursos'  => new sfValidatorString(),
      'Estat'            => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'Comentari'        => new sfValidatorString(array('required' => false)),
      'DataInscripcio'   => new sfValidatorDateTime(array('required' => false)),
      'Descompte'        => new sfValidatorNumber(array('required' => false),array('invalid'=>'No és un número')),
      'tReduccio'        => new sfValidatorString(array('max_length' => 1)),
      'tPagament'        => new sfValidatorString(array('max_length' => 1)),
    ));

    $this->setDefaults(array('Usuaris_usuariID'=>'99999999A'));

    $this->widgetSchema->setLabels(array(                  
      'Usuaris_usuariID' => 'DNI: ',
      'Cursos_idCursos'  => 'Curs: ',
      'Estat'            => 'Estat: ',
      'Comentari'        => 'Comentari: ',
      'DataInscripcio'   => 'Data d\'inscripció: ',
      'Descompte'        => 'Te descompte? ',
      'tReduccio'        => 'Te reducció? ',
      'tPagament'        => 'Com ha pagat? ',
    ));    
    
    $this->widgetSchema->setNameFormat('matricules[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Matricules';
  }
  

}
