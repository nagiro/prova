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
      'Llistes_idLlistes' => new sfWidgetFormPropelChoice(array('model' => 'Llistes', 'add_empty' => true)),
      'Usuaris_UsuarisID' => new sfWidgetFormPropelChoice(array('model' => 'Usuaris', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'idUsuarisLlistes'  => new sfValidatorPropelChoice(array('model' => 'Usuarisllistes', 'column' => 'idUsuarisLlistes', 'required' => false)),
      'Llistes_idLlistes' => new sfValidatorPropelChoice(array('model' => 'Llistes', 'column' => 'idLlistes', 'required' => false)),
      'Usuaris_UsuarisID' => new sfValidatorPropelChoice(array('model' => 'Usuaris', 'column' => 'UsuariID', 'required' => false)),
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
