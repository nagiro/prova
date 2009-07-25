<?php

/**
 * Matricules form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseMatriculesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idMatricules'     => new sfWidgetFormInputHidden(),
      'Usuaris_UsuariID' => new sfWidgetFormPropelChoice(array('model' => 'Usuaris', 'add_empty' => false)),
      'Cursos_idCursos'  => new sfWidgetFormPropelChoice(array('model' => 'Cursos', 'add_empty' => false)),
      'Estat'            => new sfWidgetFormInput(),
      'Comentari'        => new sfWidgetFormTextarea(),
      'DataInscripcio'   => new sfWidgetFormDateTime(),
      'Descompte'        => new sfWidgetFormInput(),
      'tReduccio'        => new sfWidgetFormInput(),
      'tPagament'        => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'idMatricules'     => new sfValidatorPropelChoice(array('model' => 'Matricules', 'column' => 'idMatricules', 'required' => false)),
      'Usuaris_UsuariID' => new sfValidatorPropelChoice(array('model' => 'Usuaris', 'column' => 'UsuariID')),
      'Cursos_idCursos'  => new sfValidatorPropelChoice(array('model' => 'Cursos', 'column' => 'idCursos')),
      'Estat'            => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'Comentari'        => new sfValidatorString(array('required' => false)),
      'DataInscripcio'   => new sfValidatorDateTime(array('required' => false)),
      'Descompte'        => new sfValidatorNumber(array('required' => false)),
      'tReduccio'        => new sfValidatorString(array('max_length' => 1)),
      'tPagament'        => new sfValidatorString(array('max_length' => 1)),
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
