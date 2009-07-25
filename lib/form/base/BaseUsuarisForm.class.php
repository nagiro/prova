<?php

/**
 * Usuaris form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseUsuarisForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'UsuariID'          => new sfWidgetFormInputHidden(),
      'Nivells_idNivells' => new sfWidgetFormPropelChoice(array('model' => 'Nivells', 'add_empty' => false)),
      'DNI'               => new sfWidgetFormInput(),
      'Passwd'            => new sfWidgetFormInput(),
      'Nom'               => new sfWidgetFormInput(),
      'Cog1'              => new sfWidgetFormInput(),
      'Cog2'              => new sfWidgetFormInput(),
      'Email'             => new sfWidgetFormInput(),
      'Adreca'            => new sfWidgetFormTextarea(),
      'CodiPostal'        => new sfWidgetFormInput(),
      'Poblacio'          => new sfWidgetFormPropelChoice(array('model' => 'Poblacions', 'add_empty' => true)),
      'Poblaciotext'      => new sfWidgetFormTextarea(),
      'Telefon'           => new sfWidgetFormTextarea(),
      'Mobil'             => new sfWidgetFormTextarea(),
      'Entitat'           => new sfWidgetFormTextarea(),
      'Habilitat'         => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'UsuariID'          => new sfValidatorPropelChoice(array('model' => 'Usuaris', 'column' => 'UsuariID', 'required' => false)),
      'Nivells_idNivells' => new sfValidatorPropelChoice(array('model' => 'Nivells', 'column' => 'idNivells')),
      'DNI'               => new sfValidatorString(array('max_length' => 12, 'required' => false)),
      'Passwd'            => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'Nom'               => new sfValidatorString(array('max_length' => 30, 'required' => false)),
      'Cog1'              => new sfValidatorString(array('max_length' => 30, 'required' => false)),
      'Cog2'              => new sfValidatorString(array('max_length' => 30, 'required' => false)),
      'Email'             => new sfValidatorString(array('max_length' => 30, 'required' => false)),
      'Adreca'            => new sfValidatorString(array('required' => false)),
      'CodiPostal'        => new sfValidatorInteger(array('required' => false)),
      'Poblacio'          => new sfValidatorPropelChoice(array('model' => 'Poblacions', 'column' => 'idPoblacio', 'required' => false)),
      'Poblaciotext'      => new sfValidatorString(array('required' => false)),
      'Telefon'           => new sfValidatorString(array('required' => false)),
      'Mobil'             => new sfValidatorString(array('required' => false)),
      'Entitat'           => new sfValidatorString(array('required' => false)),
      'Habilitat'         => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('usuaris[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Usuaris';
  }


}
