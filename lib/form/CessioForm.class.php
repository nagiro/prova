<?php

/**
 * Cessio form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class CessioForm extends BaseCessioForm
{
 public function setup()
  {
    $this->setWidgets(array(
      'cessio_id'      => new sfWidgetFormInputHidden(),
      'usuari_id'      => new sfWidgetFormChoice(array('choices'=>UsuarisPeer::selectUsuaris()),array()),
      'representant'   => new sfWidgetFormInput(array(),array('style'=>'width:300px;')),
      'data_cessio'    => new sfWidgetFormJQueryDate(array('format'=>'%day%/%month%/%year%'),array()),
      'data_retorn'    => new sfWidgetFormJQueryDate(array('format'=>'%day%/%month%/%year%'),array()),
      'motiu'		   => new sfWidgetFormTextarea(array(),array()),
      'condicions'	   => new sfWidgetFormTextarea(array(),array()),
      'material_no_inventariat' => new sfWidgetFormInputHidden(array(),array()),    
      'estat'          => new sfWidgetFormTextarea(),
      'retornat'       => new sfWidgetFormInputHidden(),
      'estat_retornat' => new sfWidgetFormInputHidden(),
      'data_retornat'  => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'cessio_id'      => new sfValidatorPropelChoice(array('model' => 'Cessio', 'column' => 'cessio_id', 'required' => false)),
      'usuari_id'      => new sfValidatorPropelChoice(array('model' => 'Usuaris', 'column' => 'UsuariID')),
      'representant'   => new sfValidatorString(array('required'=>false),array()),
      'motiu'		   => new sfValidatorString(array('required'=>false),array()),
      'condicions'	   => new sfValidatorString(array('required'=>false),array()),
      'material_no_inventariat' => new sfValidatorString(array('required'=>false),array()),
      'data_cessio'    => new sfValidatorDate(array('required'=>false),array()),
      'data_retorn'    => new sfValidatorDate(array('required'=>false),array()),
      'estat'          => new sfValidatorString(array('required'=>false),array()),
      'retornat'       => new sfValidatorInteger(array('required'=>false),array()),
      'estat_retornat' => new sfValidatorString(array('required'=>false),array()),
      'data_retornat'  => new sfValidatorDate(array('required'=>false),array()),
    ));

    $this->widgetSchema->setLabels(array(      
      'usuari_id'      => 'Cedit a',
      'representant'   => 'Representant a ',
      'motiu'          => 'Motiu ',
      'condicions'	   => 'Condicions ',
      'data_cessio'    => 'Data cessió',
      'data_retorn'    => 'Data retorn',
      'estat'          => 'Observacions',
      'retornat'       => 'Retornat?',
      'estat_retornat' => 'Estat retorn',
      'data_retornat'  => 'Data retornat',
    ));
    
    
    $this->widgetSchema->setNameFormat('cessio[%s]');
	$this->widgetSchema->setFormFormatterName('Span');
    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

  }

  public function getModelName()
  {
    return 'Cessio';
  }

}
