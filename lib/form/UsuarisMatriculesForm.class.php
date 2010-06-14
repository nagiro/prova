<?php

/**
 * Usuaris form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class UsuarisMatriculesForm extends UsuarisForm
{
  public function setup()
  {

  	parent::setup();
  	
    $this->setWidget('Nivells_idNivells',new sfWidgetFormInputHidden());
    $this->setWidget('Habilitat', new sfWidgetFormInputHidden());
    
    $this->setValidator('DNI', new sfValidatorCallback(array('callback'=>array('UsuarisMatriculesForm','ComprovaDNI'), 'arguments' => array() , 'required'=>true)));         

  }

  static public function ComprovaDNI($A,$valor)
  {
  	  	
  	$DNI = trim($valor);
  	
  	if(self::valida_nif_cif_nie($DNI) <= 0) throw new sfValidatorError($A, "Error: El DNI és incorrecte.<br /> Recorda escriure'l amb el format 99999999A.");
  	
  	$OUsuari = UsuarisPeer::cercaDNI($DNI);
  	if($OUsuari instanceof Usuaris) throw new sfValidatorError($A, "Error: El DNI ja existeix.");
  	return $valor;
  	  	
  } 
  
  
  static public function valida_nif_cif_nie($cif) {
	//Copyright ©2005-2008 David Vidal Serra. Bajo licencia GNU GPL.
	//Este software viene SIN NINGUN TIPO DE GARANTIA; para saber mas detalles
	//puede consultar la licencia en http://www.gnu.org/licenses/gpl.txt
	//Esto es software libre, y puede ser usado y redistribuirdo de acuerdo
	//con la condicion de que el autor jamas sera responsable de su uso.
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
	   if (preg_match('^[KLM]{1}', $cif))
	      if ($num[8] == chr(64 + $n) || $num[8] == substr('TRWAGMYFPDXBNJZSQVHLCKE', substr($cif, 1, 8) % 23, 1))
	         return 1;
	      else
	         return -1;
	//comprobacion de CIFs
	   if (preg_match('^[ABCDEFGHJNPQRSUVW]{1}', $cif))
	      if ($num[8] == chr(64 + $n) || $num[8] == substr($n, strlen($n) - 1, 1))
	         return 2;
	      else
	         return -2;
	//comprobacion de NIEs
	   //T
	   if (preg_match('^[T]{1}', $cif))
	      if ($num[8] == preg_match('^[T]{1}[A-Z0-9]{8}$', $cif))
	         return 3;
	      else
	         return -3;
	   //XYZ
	   if (preg_match('^[XYZ]{1}', $cif))
	      if ($num[8] == substr('TRWAGMYFPDXBNJZSQVHLCKE', substr(str_replace(array('X','Y','Z'), array('0','1','2'), $cif), 0, 8) % 23, 1))
	         return 3;
	      else
	         return -3;
	//si todavia no se ha verificado devuelve error
	   return 0;
	}
  
  
    
}
