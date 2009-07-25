<?php

/**
 * Cursos form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseCursosForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idCursos'        => new sfWidgetFormInputHidden(),
      'TitolCurs'       => new sfWidgetFormTextarea(),
      'isActiu'         => new sfWidgetFormInput(),
      'Places'          => new sfWidgetFormInput(),
      'Codi'            => new sfWidgetFormTextarea(),
      'Descripcio'      => new sfWidgetFormTextarea(),
      'Preu'            => new sfWidgetFormInput(),
      'Preur'           => new sfWidgetFormInput(),
      'Horaris'         => new sfWidgetFormTextarea(),
      'Categoria'       => new sfWidgetFormTextarea(),
      'OrdreSortida'    => new sfWidgetFormInput(),
      'DataAparicio'    => new sfWidgetFormDate(),
      'DataDesaparicio' => new sfWidgetFormDate(),
      'DataFiMatricula' => new sfWidgetFormDate(),
      'DataInici'       => new sfWidgetFormDate(),
    ));

    $this->setValidators(array(
      'idCursos'        => new sfValidatorPropelChoice(array('model' => 'Cursos', 'column' => 'idCursos', 'required' => false)),
      'TitolCurs'       => new sfValidatorString(array('required' => false)),
      'isActiu'         => new sfValidatorInteger(array('required' => false)),
      'Places'          => new sfValidatorInteger(array('required' => false)),
      'Codi'            => new sfValidatorString(array('required' => false)),
      'Descripcio'      => new sfValidatorString(array('required' => false)),
      'Preu'            => new sfValidatorInteger(array('required' => false)),
      'Preur'           => new sfValidatorInteger(array('required' => false)),
      'Horaris'         => new sfValidatorString(array('required' => false)),
      'Categoria'       => new sfValidatorString(array('required' => false)),
      'OrdreSortida'    => new sfValidatorInteger(array('required' => false)),
      'DataAparicio'    => new sfValidatorDate(array('required' => false)),
      'DataDesaparicio' => new sfValidatorDate(array('required' => false)),
      'DataFiMatricula' => new sfValidatorDate(array('required' => false)),
      'DataInici'       => new sfValidatorDate(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('cursos[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Cursos';
  }


}
