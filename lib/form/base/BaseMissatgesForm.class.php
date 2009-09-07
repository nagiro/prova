<?php

/**
 * Missatges form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseMissatgesForm extends BaseFormPropel
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
      'MissatgeID'       => new sfValidatorPropelChoice(array('model' => 'Missatges', 'column' => 'MissatgeID', 'required' => false)),
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
