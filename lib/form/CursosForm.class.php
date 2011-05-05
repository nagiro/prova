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
      'Codi'            => new sfWidgetFormInputText(array(),array('style'=>'width:100px;')),
      'TitolCurs'       => new sfWidgetFormInputText(array(),array('style'=>'width:100%;')),
      'isActiu'         => new sfWidgetFormChoice(array('choices'=>array(1=>'Sí',0=>'No'))),
      'VisibleWEB'      => new sfWidgetFormChoice(array('choices'=>array(1=>'Sí',0=>'No'))),
      'Places'          => new sfWidgetFormInputText(array(),array('style'=>'width:10%;')),      
      'Descripcio'      => new sfWidgetFormTextareaTinyMCE(array(),array('style'=>'width:100%;')),
      'Preu'            => new sfWidgetFormInputText(array(),array('style'=>'width:10%;')),
      'Preur'           => new sfWidgetFormInputText(array(),array('style'=>'width:10%;')),
      'Horaris'         => new sfWidgetFormInputText(array(),array('style'=>'width:50%;')),
      'Categoria'       => new sfWidgetFormChoice(array('choices'=>CursosPeer::getSelectCategories())),
      'OrdreSortida'    => new sfWidgetFormInputText(array(),array('style'=>'width:10%;')),
      'DataAparicio'    => new sfWidgetFormJQueryDateMy(array('format'=>'%day%/%month%/%year%'),array()),
      'DataDesaparicio' => new sfWidgetFormJQueryDateMy(array('format'=>'%day%/%month%/%year%'),array()),
      'DataFiMatricula' => new sfWidgetFormJQueryDateMy(array('format'=>'%day%/%month%/%year%'),array()),
      'DataInici'       => new sfWidgetFormJQueryDateMy(array('format'=>'%day%/%month%/%year%'),array()),
      'site_id'         => new sfWidgetFormInputHidden(),
      'actiu'           => new sfWidgetFormInputHidden(),
      'isEntrada'       => new sfWidgetFormChoice(array('choices'=>array(0=>'No',1=>'Sí')),array()),
    ));

    $this->setValidators(array(
      'idCursos'        => new sfValidatorPropelChoice(array('model' => 'Cursos', 'column' => 'idCursos', 'required' => false)),
      'TitolCurs'       => new sfValidatorString(array('required' => false)),
      'isActiu'         => new sfValidatorBoolean(array('required' => false)),
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
      'VisibleWEB'      => new sfValidatorInteger(array('required' => true)),
      'site_id'         => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'actiu'           => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'isEntrada'       => new sfValidatorBoolean(array('required'=>true),array()),
    ));

    
    $this->widgetSchema->setLabels(array(      
      'TitolCurs'       => 'Títol del curs: ',
      'isActiu'         => 'Està actiu? ',
      'Places'          => 'Núm de places: ',
      'Descripcio'      => 'Descripció: ',
      'Preu'            => 'Preu: ',
      'Preur'           => 'Preu reduït: ',
      'Horaris'         => 'Descripció d\'horaris: ',
      'Categoria'       => 'Categoria: ',
      'OrdreSortida'    => 'Ordre de sortida: ',
      'DataAparicio'    => 'Data d\'aparició: ',
      'DataDesaparicio' => 'Data de desaparició: ',
      'DataFiMatricula' => 'Data de fi de matriculació: ',
      'DataInici'       => 'Data d\'inici del curs: ',
      'VisibleWEB'      => 'Visible al web?',
      'isEntrada'       => 'Reserva per internet?',
    ));
    
    
    $this->widgetSchema->setNameFormat('cursos[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
    
    $this->widgetSchema->setFormFormatterName('Span');
    
  }

  public function getModelName()
  {
    return 'Cursos';
  }

}
