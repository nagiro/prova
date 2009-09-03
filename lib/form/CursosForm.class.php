<?php

/**
 * Cursos form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class CursosForm extends sfFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idCursos'        => new sfWidgetFormInputHidden(),
      'TitolCurs'       => new sfWidgetFormInput(),
      'isActiu'         => new sfWidgetFormChoice(array('choices'=>array(1=>'Sí',0=>'No'))),
      'Places'          => new sfWidgetFormInput(),
      'Codi'            => new sfWidgetFormInput(),
      'Descripcio'      => new sfWidgetFormTextarea(),
      'Preu'            => new sfWidgetFormInput(),
      'Preur'           => new sfWidgetFormInput(),
      'Horaris'         => new sfWidgetFormInput(),
      'Categoria'       => new sfWidgetFormChoice(array('choices'=>CursosPeer::getSelectCategories())),
      'OrdreSortida'    => new sfWidgetFormInput(),
      'DataAparicio'    => new sfWidgetFormDate(),
      'DataDesaparicio' => new sfWidgetFormDate(),
      'DataFiMatricula' => new sfWidgetFormDate(),
      'DataInici'       => new sfWidgetFormDate(),
    ));

    $this->setValidators(array(
      'idCursos'        => new sfValidatorPropelChoice(array('model' => 'Cursos', 'column' => 'idCursos', 'required' => false)),
      'TitolCurs'       => new sfValidatorString(array('required' => false)),
      'isActiu'         => new sfValidatorString(array('required' => false)),
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

    
    $this->widgetSchema->setLabels(array(      
      'TitolCurs'       => 'Títol del curs: ',
      'isActiu'         => 'Està actiu? ',
      'Places'          => 'Núm de places: ',
      'Codi'            => 'Codi: ',
      'Descripcio'      => 'Descripció: ',
      'Preu'            => 'Preu: ',
      'Preur'           => 'Preu reduït: ',
      'Horaris'         => 'Descripció d\'horaris: ',
      'Categoria'       => 'Categoria: ',
      'OrdreSortida'    => 'Ordre de sortida: ',
      'DataAparicio'    => 'Data d\'aparició: ',
      'DataDesaparicio' => 'Data de desaparició: ',
      'DataFiMatricula' => 'Data de fi de matriculació: ',
      'DataInici'       => 'Data d\'inici del curs: '
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
