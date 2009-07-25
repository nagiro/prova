<?php

/**
 * Reservaespais form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseReservaespaisForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'ReservaEspaiID'     => new sfWidgetFormInputHidden(),
      'Representacio'      => new sfWidgetFormTextarea(),
      'Responsable'        => new sfWidgetFormTextarea(),
      'PersonalAutoritzat' => new sfWidgetFormTextarea(),
      'PrevisioAssistents' => new sfWidgetFormInput(),
      'EsCicle'            => new sfWidgetFormInput(),
      'Exempcio'           => new sfWidgetFormInput(),
      'Pressupost'         => new sfWidgetFormInput(),
      'ColaboracioCCG'     => new sfWidgetFormInput(),
      'Comentaris'         => new sfWidgetFormTextarea(),
      'Estat'              => new sfWidgetFormInput(),
      'Usuaris_usuariID'   => new sfWidgetFormPropelChoice(array('model' => 'Usuaris', 'add_empty' => true)),
      'Organitzadors'      => new sfWidgetFormTextarea(),
      'DataActivitat'      => new sfWidgetFormTextarea(),
      'HorariActivitat'    => new sfWidgetFormTextarea(),
      'TipusActe'          => new sfWidgetFormTextarea(),
      'Nom'                => new sfWidgetFormTextarea(),
      'isEnregistrable'    => new sfWidgetFormInput(),
      'EspaisSolicitats'   => new sfWidgetFormTextarea(),
      'MaterialSolicitat'  => new sfWidgetFormTextarea(),
      'DataAlta'           => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'ReservaEspaiID'     => new sfValidatorPropelChoice(array('model' => 'Reservaespais', 'column' => 'ReservaEspaiID', 'required' => false)),
      'Representacio'      => new sfValidatorString(array('required' => false)),
      'Responsable'        => new sfValidatorString(array('required' => false)),
      'PersonalAutoritzat' => new sfValidatorString(array('required' => false)),
      'PrevisioAssistents' => new sfValidatorInteger(array('required' => false)),
      'EsCicle'            => new sfValidatorInteger(array('required' => false)),
      'Exempcio'           => new sfValidatorInteger(array('required' => false)),
      'Pressupost'         => new sfValidatorInteger(array('required' => false)),
      'ColaboracioCCG'     => new sfValidatorInteger(array('required' => false)),
      'Comentaris'         => new sfValidatorString(array('required' => false)),
      'Estat'              => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'Usuaris_usuariID'   => new sfValidatorPropelChoice(array('model' => 'Usuaris', 'column' => 'UsuariID', 'required' => false)),
      'Organitzadors'      => new sfValidatorString(),
      'DataActivitat'      => new sfValidatorString(),
      'HorariActivitat'    => new sfValidatorString(),
      'TipusActe'          => new sfValidatorString(),
      'Nom'                => new sfValidatorString(),
      'isEnregistrable'    => new sfValidatorInteger(),
      'EspaisSolicitats'   => new sfValidatorString(),
      'MaterialSolicitat'  => new sfValidatorString(),
      'DataAlta'           => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('reservaespais[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Reservaespais';
  }


}
