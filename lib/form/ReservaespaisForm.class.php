<?php

/**
 * Reservaespais form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class ReservaespaisForm extends sfFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'ReservaEspaiID'     => new sfWidgetFormInputHidden(),
      'Representacio'      => new sfWidgetFormInput(),
      'Responsable'        => new sfWidgetFormInput(),
      'PersonalAutoritzat' => new sfWidgetFormInput(),
      'PrevisioAssistents' => new sfWidgetFormInput(),
      'EsCicle'            => new sfWidgetFormInputCheckbox(),
      'Exempcio'           => new sfWidgetFormInputCheckbox(),
      'Pressupost'         => new sfWidgetFormInputCheckbox(),
      'ColaboracioCCG'     => new sfWidgetFormInputCheckbox(),
      'Comentaris'         => new sfWidgetFormTextarea(),
      'Estat'              => new sfWidgetFormChoice(array('choices'=>ReservaespaisPeer::selectEstat())),
      'Usuaris_usuariID'   => new sfWidgetFormInputHidden(),
      'Organitzadors'      => new sfWidgetFormInput(),
      'DataActivitat'      => new sfWidgetFormDate(),
      'HorariActivitat'    => new sfWidgetFormInput(),
      'TipusActe'          => new sfWidgetFormChoice(array('choices'=>array())),
      'Nom'                => new sfWidgetFormInput(),
      'isEnregistrable'    => new sfWidgetFormInputCheckbox(),
      'EspaisSolicitats'   => new sfWidgetFormChoice(array('choices'=>EspaisPeer::select(), 'multiple'=>true ,'expanded'=>true)),
      'MaterialSolicitat'  => new sfWidgetFormChoice(array('choices'=>MaterialgenericPeer::select(), 'multiple'=>true, 'expanded'=>true)),
      'DataAlta'           => new sfWidgetFormInputHidden(),
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
