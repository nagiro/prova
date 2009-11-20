<?php

/**
 * Cursos form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class CursosCodiForm extends sfFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idCursos'        => new sfWidgetFormInputHidden(),
      'Codi'            => new sfWidgetFormJQueryAutocompleter(array('config'=>'{ max:100 , width:500 }' , 'url'=>$this->getOption('url'))),
      'TitolCurs'		=> new sfWidgetFormInput(array(),array('disabled'=>'disabled','style'=>'width:400px')),
    ));

    $this->setValidators(array(
      'idCursos'        => new sfValidatorPropelChoice(array('model' => 'Cursos', 'column' => 'idCursos', 'required' => false)),
      'Codi'            => new sfValidatorString(array('required' => false)),
      'TitolCurs'		=> new sfValidatorPass(),    
    ));

    
    $this->widgetSchema->setLabels(array(      
      'Codi'            => 'Codi del curs: ',
      'TitolCurs'		=> 'Titol actual: ',
    ));
    
    
    $this->widgetSchema->setNameFormat('cursos_codi[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
    
  }

  public function getModelName()
  {
    return 'Cursos';
  }

}
