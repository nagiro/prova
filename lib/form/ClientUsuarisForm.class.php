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
      'Passwd'            => new sfWidgetFormInputPassword(array('always_render_empty'=>false),array('style'=>'width:200px')),
      'Nom'               => new sfWidgetFormInputText(array(),array('style'=>'width:200px')),
      'Cog1'              => new sfWidgetFormInputText(array(),array('style'=>'width:200px')),
      'Cog2'              => new sfWidgetFormInputText(array(),array('style'=>'width:200px')),
      'Email'             => new sfWidgetFormInputText(array(),array('style'=>'width:200px')),
      'Adreca'            => new sfWidgetFormInputText(array(),array('style'=>'width:200px')),
      'CodiPostal'        => new sfWidgetFormInputText(array(),array('style'=>'width:200px')),
      'Poblacio'          => new sfWidgetFormChoice(array('choices'=>PoblacionsPeer::select())),
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
      'Passwd'            => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'Nom'               => new sfValidatorString(array('required' => false)),
      'Cog1'              => new sfValidatorString(array('required' => false)),
      'Cog2'              => new sfValidatorString(array('required' => false)),
      'Email'             => new sfValidatorString(array('required' => false)),
      'Adreca'            => new sfValidatorString(array('required' => false)),
      'CodiPostal'        => new sfValidatorInteger(array('required' => false)),
      'Poblacio'          => new sfValidatorPass(array('required'=>false)),
      'Poblaciotext'      => new sfValidatorString(array('required' => false)),
      'Telefon'           => new sfValidatorString(array('required' => false)),
      'Mobil'             => new sfValidatorString(array('required' => false)),
      'Entitat'           => new sfValidatorString(array('required' => false)),
      'Habilitat'         => new sfValidatorBoolean(array('required' => false)),
	  'captcha2'		  => new sfValidatorNumber(array('min'=>$sol,'max'=>$sol),array('invalid'=>$inv,'max'=>$inv,'min'=>$inv)),
      'DNI'               => new sfValidatorCallback(   array(  'callback'  =>'ClientUsuarisForm::validaDNI', 'arguments' => array('idU'=>$this->getObject()->getUsuariId()))),          
    ));

    $DNIV = $this->getValidator('DNI');        
    $DNIV->addMessage('duplicat','El DNI ja existeix.');    
    $DNIV->addMessage('incorrecte','El DNI entrat no és correcte.');
    
    
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
      'Poblaciotext'      => 'Població (Altres): ',
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
    $OU->setActualitzacio(date('Y-m-d',time()));
  	$OU->save();  
  }    
  
  static public function validaDNI($validator, $value, $arguments)
  {
    
    //Comprovem que el DNI ja no existeixi a no ser que sigui el mateix usuari.
    $C = new Criteria();
    $C->add(UsuarisPeer::USUARIID, $arguments['idU'], CRITERIA::NOT_EQUAL);
    $C->add(UsuarisPeer::DNI, $value);    
    if(UsuarisPeer::doCount($C) > 0):
        throw new sfValidatorError($validator, 'duplicat');
    endif; 
     
    if(self::valida_nif_cif_nie($value) <= 0):
        throw new sfValidatorError($validator, 'incorrecte');
    endif;    
       
    return $value;
  }
  
  static public function valida_nif_cif_nie($cif) {
    //Returns: 1 = NIF ok, 2 = CIF ok, 3 = NIE ok, -1 = NIF bad, -2 = CIF bad, -3 = NIE bad, 0 = ??? bad
       $cif = strtoupper($cif);
       for ($i = 0; $i < 9; $i ++)
          $num[$i] = substr($cif, $i, 1);
    //si no tiene un formato valido devuelve error
       if (!preg_match('((^[A-Z]{1}[0-9]{7}[A-Z0-9]{1}$|^[T]{1}[A-Z0-9]{8}$)|^[0-9]{8}[A-Z]{1}$)', $cif))
          return 0;
    //comprobacion de NIFs estandar
       if (preg_match('(^[0-9]{8}[A-Z]{1}$)', $cif))
          if ($num[8] == substr('TRWAGMYFPDXBNJZSQVHLCKE', substr($cif, 0, 8) % 23, 1))
             return 1;
          else
             return -1;
    //algoritmo para comprobacion de codigos tipo CIF
       $suma = $num[2] + $num[4] + $num[6];
       for ($i = 1; $i < 8; $i += 2)
          $suma += substr((2 * $num[$i]),0,1) + substr((2 * $num[$i]),1,1);
       $n = 10 - substr($suma, strlen($suma) - 1, 1);
    //comprobacion de NIFs especiales (se calculan como CIFs o como NIFs)
       if (preg_match('(^[KLM]{1})', $cif))
          if ($num[8] == chr(64 + $n) || $num[8] == substr('TRWAGMYFPDXBNJZSQVHLCKE', substr($cif, 1, 8) % 23, 1))
             return 1;
          else
             return -1;
    //comprobacion de CIFs
       if (preg_match('(^[ABCDEFGHJNPQRSUVW]{1})', $cif))
          if ($num[8] == chr(64 + $n) || $num[8] == substr($n, strlen($n) - 1, 1))
             return 2;
          else
             return -2;
    //comprobacion de NIEs
       //T
       if (preg_match('(^[T]{1})', $cif))
          if ($num[8] == preg_match('^[T]{1}[A-Z0-9]{8}$', $cif))
             return 3;
          else
             return -3;
       //XYZ
       if (preg_match('(^[XYZ]{1})', $cif))
          if ($num[8] == substr('TRWAGMYFPDXBNJZSQVHLCKE', substr(str_replace(array('X','Y','Z'), array('0','1','2'), $cif), 0, 8) % 23, 1))
             return 3;
          else
             return -3;
    //si todavia no se ha verificado devuelve error
       return 0;
    }  
    
}
