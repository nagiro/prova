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
    
    //Carrego el nivell de l'usuari a la taula,. Si l'estic veient per força n'he de tenir.
    $OUS = UsuarisSitesPeer::initialize($this->getObject()->getUsuariId(),$this->getObject()->getSiteId(),false)->getObject();
    if($OUS->isNew()): $NIVELL = NivellsPeer::REGISTRAT;
    else: $NIVELL = $OUS->getNivellId();
    endif;     
    
    $this->setWidgets(array(
      'UsuariID'          => new sfWidgetFormInputHidden(),
      'level'             => new sfWidgetFormChoice( array( 'choices'=> NivellsPeer::getSelect() ) , array() ),
      'DNI'               => new sfWidgetFormInputText(array(),array('style'=>'width:200px')),
      'Passwd'            => new sfWidgetFormInputPassword(array('always_render_empty'=>false),array('always_render_empty'=>false, 'style'=>'width:200px')),
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
      'Habilitat'         => new sfWidgetFormChoice(array('choices'=>array(1=>'Sí',0=>'No')),array()),
      'Actualitzacio'     => new sfWidgetFormInputHidden(array(),array()),
      'site_id'           => new sfWidgetFormInputHidden(array(),array()),
    ));
    
    $this->setDefault('level',$NIVELL);
    
    $C = new Criteria();
    $C->addAscendingOrderByColumn(PoblacionsPeer::NOM);
    
    $this->setValidators(array(
      'UsuariID'          => new sfValidatorPropelChoice(array('model' => 'Usuaris', 'column' => 'UsuariID', 'required' => false)),
      'level'             => new sfValidatorPropelChoice(array('model' => 'Nivells', 'column' => 'idNivells')),
      'DNI'               => new sfValidatorString(array('max_length' => 12, 'required' => true)),
      'Passwd'            => new sfValidatorString(array('max_length' => 20, 'required' => true)),
      'Nom'               => new sfValidatorString(array('required' => true)),
      'Cog1'              => new sfValidatorString(array('required' => true)),
      'Cog2'              => new sfValidatorString(array('required' => false)),
      'Email'             => new sfValidatorEmail(array('required' => true)),
      'Adreca'            => new sfValidatorString(array('required' => false)),
      'CodiPostal'        => new sfValidatorInteger(array('required' => false)),
      'Poblacio'          => new sfValidatorPropelChoice(array('model' => 'Poblacions', 'criteria' => $C , 'column' => 'idPoblacio', 'required' => false)),
      'Poblaciotext'      => new sfValidatorString(array('required' => false)),
      'Telefon'           => new sfValidatorString(array('required' => false)),
      'Mobil'             => new sfValidatorString(array('required' => false)),
      'Entitat'           => new sfValidatorString(array('required' => false)),
      'Habilitat'         => new sfValidatorBoolean(array('required' => false)),
      'Actualitzacio'     => new sfValidatorDate(array('required'=>false),array()),
      'site_id'           => new sfValidatorPass(array(),array()),
    ));

    
    $this->widgetSchema->setLabels(array(          
      'level'             => 'Nivell: ',
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
    
    //Les dades de l'usuari que es mantenen són sempre les noves. Guardem la data d'actualització i avall.'
    $this->updateObject();
    $OU = $this->getObject();
    $OU->setActualitzacio(date('Y-m-d',time())); //Guardem la data d'actualització.'
    $OU->save();        
    
    //Mirem si l'usuari està relacionat amb el SITE
    $OUS = UsuarisSitesPeer::initialize($OU->getUsuariId() , $OU->getSiteId())->getObject();    
    $OUS->setNivellid($this->getValue('level'));
    $OUS->save();        
    
  }
	
}