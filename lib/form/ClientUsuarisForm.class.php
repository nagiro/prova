<?php

/**
 * Usuaris form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class ClientUsuarisForm extends sfFormPropel
{
  public function setup()
  {
  	  	
    $this->setWidgets(array(
      'UsuariID'          => new sfWidgetFormInputHidden(),
      'Nivells_idNivells' => new sfWidgetFormInputHidden(),
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
      'Habilitat'         => new sfWidgetFormInputHidden(),
      'captcha2'		  => new sfWidgetFormInputCaptcha(array(),array('value'=>$this->getOption('rand'))),      
    ));

    $rand = $this->getOption('rand');
    $sol = $rand[1]+$rand[2];
    $inv = "El resultat %value% no és correcte.";
         
    $this->setValidators(array(
      'UsuariID'          => new sfValidatorPropelChoice(array('model' => 'Usuaris', 'column' => 'UsuariID', 'required' => false)),
      'Nivells_idNivells' => new sfValidatorPropelChoice(array('model' => 'Nivells', 'column' => 'idNivells', 'required'=>false)),
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
      'Habilitat'         => new sfValidatorBoolean(array('required' => false)),
	  'captcha2'		  => new sfValidatorNumber(array('min'=>$sol,'max'=>$sol),array('invalid'=>$inv,'max'=>$inv,'min'=>$inv)),          
    ));

    
    $this->widgetSchema->setLabels(array(                
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
      'captcha2'		  => 'Verificació: ',      
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
  	$OU = $this->getObject();  	
  	$OU->setNivellsIdnivells(Nivells::USER);
  	$OU->setHabilitat(true);
  	$OU->save();  
  }
  
}
