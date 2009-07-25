<?php

/**
 * Usuarisllistes form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseUsuarisllistesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idUsuarisLlistes'  => new sfWidgetFormInputHidden(),
      'Llistes_idLlistes' => new sfWidgetFormPropelChoice(array('model' => 'Llistes', 'add_empty' => false)),
      'Usuaris_UsuarisID' => new sfWidgetFormPropelChoice(array('model' => 'Usuaris', 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'idUsuarisLlistes'  => new sfValidatorPropelChoice(array('model' => 'Usuarisllistes', 'column' => 'idUsuarisLlistes', 'required' => false)),
      'Llistes_idLlistes' => new sfValidatorPropelChoice(array('model' => 'Llistes', 'column' => 'idLlistes')),
      'Usuaris_UsuarisID' => new sfValidatorPropelChoice(array('model' => 'Usuaris', 'column' => 'UsuariID')),
    ));

    $this->widgetSchema->setNameFormat('usuarisllistes[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Usuarisllistes';
  }


}
