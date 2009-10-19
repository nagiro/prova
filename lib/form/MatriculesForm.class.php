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
  	  'Usuaris_usuariID' => new sfWidgetFormInputHidden(),
  	  'Cursos_idCursos'  => new sfWidgetFormChoice(array('choices'=>CursosPeer::getSelectCursos())),
      'Estat'            => new sfWidgetFormChoice(array('choices'=>MatriculesPeer::getEstatsSelect())),
      'Comentari'        => new sfWidgetFormTextarea(),
      'DataInscripcio'   => new sfWidgetFormDateTime(array('date'=>array('format'=>'%day%/%month%/%year%'))),
      'Pagat'        	 => new sfWidgetFormInput(),
      'tReduccio'        => new sfWidgetFormChoice(array('choices'=>MatriculesPeer::selectDescomptes())),
      'tPagament'        => new sfWidgetFormChoice(array('choices'=>MatriculesPeer::selectPagament())),
    ));

    $this->setValidators(array(      
      'idMatricules'     => new sfValidatorPropelChoice(array('model' => 'Matricules', 'column' => 'idMatricules', 'required' => false)),
      'Usuaris_UsuariID' => new sfValidatorPropelChoice(array('model' => 'Usuaris', 'column' => 'UsuariID')),
      'Cursos_idCursos'  => new sfValidatorPropelChoice(array('model' => 'Cursos', 'column' => 'idCursos')),
      'Estat'            => new sfValidatorInteger(array('required' => false)),
      'Comentari'        => new sfValidatorString(array('required' => false)),
      'DataInscripcio'   => new sfValidatorDateTime(array('required' => false)),
      'Pagat'            => new sfValidatorNumber(array('required' => false)),
      'tReduccio'        => new sfValidatorInteger(),
      'tPagament'        => new sfValidatorInteger(),    
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
