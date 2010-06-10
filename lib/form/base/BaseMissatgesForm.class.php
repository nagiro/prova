<?php

/**
 * Missatges form base class.
 *
 * @method Missatges getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseMissatgesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'MissatgeID'       => new sfWidgetFormInputHidden(),
      'Usuaris_UsuariID' => new sfWidgetFormPropelChoice(array('model' => 'Usuaris', 'add_empty' => false)),
      'Titol'            => new sfWidgetFormTextarea(),
      'Text'             => new sfWidgetFormTextarea(),
      'Date'             => new sfWidgetFormDateTime(),
      'Publicacio'       => new sfWidgetFormDate(),
    ));

    $this->setValidators(array(
      'MissatgeID'       => new sfValidatorChoice(array('choices' => array($this->getObject()->getMissatgeid()), 'empty_value' => $this->getObject()->getMissatgeid(), 'required' => false)),
      'Usuaris_UsuariID' => new sfValidatorPropelChoice(array('model' => 'Usuaris', 'column' => 'UsuariID')),
      'Titol'            => new sfValidatorString(array('required' => false)),
      'Text'             => new sfValidatorString(array('required' => false)),
      'Date'             => new sfValidatorDateTime(array('required' => false)),
      'Publicacio'       => new sfValidatorDate(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('missatges[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Missatges';
  }


}
