<?php

/**
 * Tasques form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class TasquesForm extends sfFormPropel
{

 public function setup()
  {
    $this->setWidgets(array(
      'TasquesID'              => new sfWidgetFormInputHidden(),
      'Activitats_ActivitatID' => new sfWidgetFormInputHidden(),
      'QuiMana'                => new sfWidgetFormChoice(array('choices'=>UsuarisPeer::selectTreballadors())),
      'QuiFa'                  => new sfWidgetFormChoice(array('choices'=>UsuarisPeer::selectTreballadors())),
      'Titol'                  => new sfWidgetFormInput(array(), array('class'=>'text')),
      'Accio'                  => new sfWidgetFormTextarea(array(),array('class'=>'text','rows'=>'5')),
      'Reaccio'                => new sfWidgetFormInputHidden(),
      'Estat'                  => new sfWidgetFormInputHidden(),
      'Aparicio'               => new sfWidgetFormDate(array('format'=>'%day%/%month%/%year%')),
      'Desaparicio'            => new sfWidgetFormDate(array('format'=>'%day%/%month%/%year%')),
      'DataResolucio'          => new sfWidgetFormInputHidden(),
      'isFeta'                 => new sfWidgetFormChoice(array('choices'=>array(0=>'No',1=>'Sí'))),
      'AltaRegistre'           => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'TasquesID'              => new sfValidatorPropelChoice(array('model' => 'Tasques', 'column' => 'TasquesID', 'required' => false)),
      'Activitats_ActivitatID' => new sfValidatorPropelChoice(array('model' => 'Activitats', 'column' => 'ActivitatID', 'required' => false)),
      'QuiMana'                => new sfValidatorPropelChoice(array('model' => 'Usuaris', 'column' => 'UsuariID', 'required' => false)),
      'QuiFa'                  => new sfValidatorPropelChoice(array('model' => 'Usuaris', 'column' => 'UsuariID')),
      'Titol'                  => new sfValidatorString(array('required' => false)),
      'Accio'                  => new sfValidatorString(array('required' => false)),
      'Reaccio'                => new sfValidatorString(array('required' => false)),
      'Estat'                  => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'Aparicio'               => new sfValidatorDate(array('required' => false)),
      'Desaparicio'            => new sfValidatorDate(array('required' => false)),
      'DataResolucio'          => new sfValidatorDateTime(array('required' => false)),
      'isFeta'                 => new sfValidatorBoolean(array('required' => false)),
      'AltaRegistre'           => new sfValidatorDate(array('required' => false)),
    ));

    $this->widgetSchema->setLabels(array(      
      'QuiMana'                => 'Qui mana la feina?',
      'QuiFa'                  => 'Qui fa la feina?',
      'Titol'                  => 'Títol: ',
      'Accio'                  => 'Què s\'ha de fer?',
      'Aparicio'               => 'Data aparició:',
      'Desaparicio'            => 'Data desaparició:',      
      'isFeta'                 => 'Feta?',      
    ));
    
    
    
    $this->widgetSchema->setNameFormat('tasques[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setDefault('Aparicio',date('Y-m-d',time()));
    $this->setDefault('Desaparicio',date('Y-m-d',time()));    
    $this->setDefault('isFeta',false);
    $this->setDefault('AltaRegistre',date('Y-m-d',time()));
    
  }

  public function getModelName()
  {
    return 'Tasques';
  }
    
}
