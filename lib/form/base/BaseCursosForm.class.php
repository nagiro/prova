<?php

/**
 * Cursos form base class.
 *
 * @method Cursos getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseCursosForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idCursos'        => new sfWidgetFormInputHidden(),
      'TitolCurs'       => new sfWidgetFormTextarea(),
      'isActiu'         => new sfWidgetFormInputText(),
      'Places'          => new sfWidgetFormInputText(),
      'Codi'            => new sfWidgetFormTextarea(),
      'Descripcio'      => new sfWidgetFormTextarea(),
      'Preu'            => new sfWidgetFormInputText(),
      'Horaris'         => new sfWidgetFormTextarea(),
      'Categoria'       => new sfWidgetFormTextarea(),
      'OrdreSortida'    => new sfWidgetFormInputText(),
      'DataAparicio'    => new sfWidgetFormDate(),
      'DataDesaparicio' => new sfWidgetFormDate(),
      'DataInMatricula' => new sfWidgetFormDate(),
      'DataFiMatricula' => new sfWidgetFormDate(),
      'DataInici'       => new sfWidgetFormDate(),
      'VisibleWEB'      => new sfWidgetFormInputText(),
      'site_id'         => new sfWidgetFormInputText(),
      'actiu'           => new sfWidgetFormInputText(),
      'activitat_id'    => new sfWidgetFormInputText(),
      'PDF'             => new sfWidgetFormTextarea(),
      'ADescomptes'     => new sfWidgetFormTextarea(),
      'PagamentExtern'  => new sfWidgetFormInputText(),
      'PagamentIntern'  => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'idCursos'        => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdcursos()), 'empty_value' => $this->getObject()->getIdcursos(), 'required' => false)),
      'TitolCurs'       => new sfValidatorString(array('required' => false)),
      'isActiu'         => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'Places'          => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'Codi'            => new sfValidatorString(array('required' => false)),
      'Descripcio'      => new sfValidatorString(array('required' => false)),
      'Preu'            => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'Horaris'         => new sfValidatorString(array('required' => false)),
      'Categoria'       => new sfValidatorString(array('required' => false)),
      'OrdreSortida'    => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'DataAparicio'    => new sfValidatorDate(array('required' => false)),
      'DataDesaparicio' => new sfValidatorDate(array('required' => false)),
      'DataInMatricula' => new sfValidatorDate(array('required' => false)),
      'DataFiMatricula' => new sfValidatorDate(array('required' => false)),
      'DataInici'       => new sfValidatorDate(array('required' => false)),
      'VisibleWEB'      => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
      'site_id'         => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'actiu'           => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'activitat_id'    => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'PDF'             => new sfValidatorString(array('required' => false)),
      'ADescomptes'     => new sfValidatorString(array('required' => false)),
      'PagamentExtern'  => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'PagamentIntern'  => new sfValidatorString(array('max_length' => 50, 'required' => false)),
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
