<?php

/**
 * Tasques form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseTasquesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'TasquesID'              => new sfWidgetFormInputHidden(),
      'Activitats_ActivitatID' => new sfWidgetFormPropelChoice(array('model' => 'Activitats', 'add_empty' => true)),
      'QuiMana'                => new sfWidgetFormPropelChoice(array('model' => 'Usuaris', 'add_empty' => true)),
      'QuiFa'                  => new sfWidgetFormPropelChoice(array('model' => 'Usuaris', 'add_empty' => false)),
      'Titol'                  => new sfWidgetFormTextarea(),
      'Accio'                  => new sfWidgetFormTextarea(),
      'Reaccio'                => new sfWidgetFormTextarea(),
      'Estat'                  => new sfWidgetFormInput(),
      'Aparicio'               => new sfWidgetFormDate(),
      'Desaparicio'            => new sfWidgetFormDate(),
      'DataResolucio'          => new sfWidgetFormDateTime(),
      'isFeta'                 => new sfWidgetFormInput(),
      'AltaRegistre'           => new sfWidgetFormDate(),
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
      'isFeta'                 => new sfValidatorInteger(array('required' => false)),
      'AltaRegistre'           => new sfValidatorDate(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('tasques[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Tasques';
  }


}
