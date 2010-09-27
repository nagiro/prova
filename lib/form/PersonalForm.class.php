<?php

/**
 * Personal form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
class PersonalForm extends sfFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idPersonal'     => new sfWidgetFormInputHidden(),
      'idUsuari'       => new sfWidgetFormInputHidden(),
      'idData'         => new sfWidgetFormInputHidden(),
      'tipus'          => new sfWidgetFormChoice(array('choices'=>PersonalPeer::getTipusArray())),
      'text'           => new sfWidgetFormTextarea(),
      'data_revisio'   => new sfWidgetFormDate(),
      'data_alta'      => new sfWidgetFormInputHidden(),
      'data_baixa'     => new sfWidgetFormInputHidden(),
      'usuariUpdateId' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'idPersonal'     => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdpersonal()), 'empty_value' => $this->getObject()->getIdpersonal(), 'required' => false)),
      'idUsuari'       => new sfValidatorPropelChoice(array('model' => 'Usuaris', 'column' => 'UsuariID')),
      'idData'         => new sfValidatorDate(),
      'tipus'          => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'text'           => new sfValidatorString(array('required' => false)),
      'data_revisio'   => new sfValidatorDate(array('required' => false)),
      'data_alta'      => new sfValidatorDateTime(array('required' => false)),
      'data_baixa'     => new sfValidatorDate(array('required' => false)),
      'usuariUpdateId' => new sfValidatorPropelChoice(array('model' => 'Usuaris', 'column' => 'UsuariID', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('personal[%s]');

    $this->widgetSchema->setLabels(array(            
      'tipus' => 'Tipus',
      'text'   => 'Text',
      'data_revisio' => 'Revisat a ',      
    ));
            
    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
    
  }

  public function getModelName()
  {
    return 'Personal';
  }
  
}
