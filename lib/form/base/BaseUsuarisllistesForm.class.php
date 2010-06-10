<?php

/**
 * Usuarisllistes form base class.
 *
 * @method Usuarisllistes getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseUsuarisllistesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idUsuarisLlistes'  => new sfWidgetFormInputHidden(),
      'Llistes_idLlistes' => new sfWidgetFormPropelChoice(array('model' => 'Llistes', 'add_empty' => true)),
      'Usuaris_UsuarisID' => new sfWidgetFormPropelChoice(array('model' => 'Usuaris', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'idUsuarisLlistes'  => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdusuarisllistes()), 'empty_value' => $this->getObject()->getIdusuarisllistes(), 'required' => false)),
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
