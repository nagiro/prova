<?php

/**
 * Usuaris form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class UsuarisForm extends sfFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'UsuariID'          => new sfWidgetFormInputHidden(),
      'Nivells_idNivells' => new sfWidgetFormPropelChoice(array('model' => 'Nivells', 'add_empty' => false)),
      'DNI'               => new sfWidgetFormInputText(array(),array('style'=>'width:200px')),
      'Passwd'            => new sfWidgetFormInputText(array(),array('style'=>'width:200px')),
      'Nom'               => new sfWidgetFormInputText(array(),array('style'=>'width:200px')),
      'Cog1'              => new sfWidgetFormInputText(array(),array('style'=>'width:200px')),
      'Cog2'              => new sfWidgetFormInputText(array(),array('style'=>'width:200px')),
      'Email'             => new sfWidgetFormInputText(array(),array('style'=>'width:200px')),
      'Adreca'            => new sfWidgetFormInputText(array(),array('style'=>'width:200px')),
      'CodiPostal'        => new sfWidgetFormInputText(array(),array('style'=>'width:200px')),
      'Poblacio'          => new sfWidgetFormPropelChoice(array('model' => 'Poblacions', 'add_empty' => true)),
      'Poblaciotext'      => new sfWidgetFormInputText(array(),array('style'=>'width:200px')),
      'Telefon'           => new sfWidgetFormInputText(array(),array('style'=>'width:200px')),
      'Mobil'             => new sfWidgetFormInputText(array(),array('style'=>'width:200px')),
      'Entitat'           => new sfWidgetFormInputText(array(),array('style'=>'width:200px')),
      'Habilitat'         => new sfWidgetFormInputCheckbox(array(),array('value'=>true , 'style'=>'width:200px')),
      'Actualitzacio'     => new sfWidgetFormInputHidden(array(),array()),
    ));

    $C = new Criteria();
    $C->addAscendingOrderByColumn(PoblacionsPeer::NOM);
    
    $this->setValidators(array(
      'UsuariID'          => new sfValidatorPropelChoice(array('model' => 'Usuaris', 'column' => 'UsuariID', 'required' => false)),
      'Nivells_idNivells' => new sfValidatorPropelChoice(array('model' => 'Nivells', 'column' => 'idNivells')),
      'DNI'               => new sfValidatorString(array('max_length' => 12, 'required' => true)),
      'Passwd'            => new sfValidatorString(array('max_length' => 20, 'required' => true)),
      'Nom'               => new sfValidatorString(array('max_length' => 30, 'required' => true)),
      'Cog1'              => new sfValidatorString(array('max_length' => 30, 'required' => true)),
      'Cog2'              => new sfValidatorString(array('max_length' => 30, 'required' => true)),
      'Email'             => new sfValidatorEmail(array('max_length' => 30, 'required' => true)),
      'Adreca'            => new sfValidatorString(array('required' => false)),
      'CodiPostal'        => new sfValidatorInteger(array('required' => false)),
      'Poblacio'          => new sfValidatorPropelChoice(array('model' => 'Poblacions', 'criteria' => $C , 'column' => 'idPoblacio', 'required' => false)),
      'Poblaciotext'      => new sfValidatorString(array('required' => false)),
      'Telefon'           => new sfValidatorString(array('required' => false)),
      'Mobil'             => new sfValidatorString(array('required' => false)),
      'Entitat'           => new sfValidatorString(array('required' => false)),
      'Habilitat'         => new sfValidatorBoolean(array('required' => false)),
      'Actualitzacio'     => new sfValidatorDate(array('required'=>false),array()),
    ));

    
    $this->widgetSchema->setLabels(array(          
      'Nivells_idNivells' => 'Nivell: ',
      'DNI'               => 'DNI: ',
      'Passwd'            => 'Contrasenya: ',
      'Nom'               => 'Nom: ',
      'Cog1'              => 'Primer cognom: ',
      'Cog2'              => 'Segon cognom: ',
      'Email'             => 'Correu electrònic: ',
      'Adreca'            => 'Adreça postal: ',
      'CodiPostal'        => 'Codi postal: ',
      'Poblacio'          => 'Població: ',
      'Poblaciotext'      => 'Població: ',
      'Telefon'           => 'Telèfon: ',
      'Mobil'             => 'Mòbil: ',
      'Entitat'           => 'Entitat: ',
      'Habilitat'         => 'Habilitat: ',        
    ));
    
    
    
    $this->widgetSchema->setNameFormat('usuaris[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

  }

  public function getModelName()
  {
    return 'Usuaris';
  }

  public function save($conn = null)
  {
    $this->updateObject();
    $this->getObject()->setActualitzacio(date('Y-m-d',time()));
    $this->getObject()->save();
  }
	
}
