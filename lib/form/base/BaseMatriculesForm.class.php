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
      'Usuaris_UsuariID' => new sfWidgetFormPropelChoice(array('model' => 'Usuaris', 'add_empty' => true)),
      'Cursos_idCursos'  => new sfWidgetFormPropelChoice(array('model' => 'Cursos', 'add_empty' => true)),
      'Estat'            => new sfWidgetFormInput(),
      'Comentari'        => new sfWidgetFormTextarea(),
      'DataInscripcio'   => new sfWidgetFormDateTime(),
      'Pagat'            => new sfWidgetFormInput(),
      'tReduccio'        => new sfWidgetFormInput(),
      'tPagament'        => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'idMatricules'     => new sfValidatorPropelChoice(array('model' => 'Matricules', 'column' => 'idMatricules', 'required' => false)),
      'Usuaris_UsuariID' => new sfValidatorPropelChoice(array('model' => 'Usuaris', 'column' => 'UsuariID', 'required' => false)),
      'Cursos_idCursos'  => new sfValidatorPropelChoice(array('model' => 'Cursos', 'column' => 'idCursos', 'required' => false)),
      'Estat'            => new sfValidatorInteger(array('required' => false)),
      'Comentari'        => new sfValidatorString(array('required' => false)),
      'DataInscripcio'   => new sfValidatorDateTime(array('required' => false)),
      'Pagat'            => new sfValidatorNumber(array('required' => false)),
      'tReduccio'        => new sfValidatorInteger(),
      'tPagament'        => new sfValidatorInteger(),
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
