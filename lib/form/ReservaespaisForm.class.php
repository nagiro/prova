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
  	
  	$SN = array(true=>'Sí',false=>'No');
  	
  	$this->setWidgets(array(
  	  'Estat'              => new sfWidgetFormChoice(array('choices'=>ReservaespaisPeer::selectEstat())),
      'ReservaEspaiID'     => new sfWidgetFormInputHidden(),
      'Nom'                => new sfWidgetFormInput(array(),array('style'=>'width:400px')),
      'DataActivitat'      => new sfWidgetFormInput(array(),array('style'=>'width:400px')),
      'HorariActivitat'    => new sfWidgetFormInput(array(),array('style'=>'width:400px')),
      'EspaisSolicitats'   => new sfWidgetFormChoiceMany(array('choices'=>EspaisPeer::select() , 'renderer_class'=>'sfWidgetFormSelectMany' ,  'expanded'=>false),array('style'=>'width:400px')),
      'MaterialSolicitat'  => new sfWidgetFormChoiceMany(array('choices'=>MaterialgenericPeer::select(), 'renderer_class'=>'sfWidgetFormSelectMany' ,'expanded'=>false),array('style'=>'width:400px')),
      'TipusActe'          => new sfWidgetFormInput(array(),array('style'=>'width:400px')),    
      'Representacio'      => new sfWidgetFormInput(array(),array('style'=>'width:400px')),    
      'Responsable'        => new sfWidgetFormInput(array(),array('style'=>'width:400px')),
      'Organitzadors'      => new sfWidgetFormInput(array(),array('style'=>'width:400px')),
      'PersonalAutoritzat' => new sfWidgetFormInput(array(),array('style'=>'width:400px')),    
      'PrevisioAssistents' => new sfWidgetFormInput(array(),array('style'=>'width:400px')),
      'isEnregistrable'    => new sfWidgetFormChoice(array('choices'=>$SN),array()),
      'EsCicle'            => new sfWidgetFormChoice(array('choices'=>$SN),array()),    
      'Exempcio'           => new sfWidgetFormChoice(array('choices'=>$SN),array()),
      'Pressupost'         => new sfWidgetFormChoice(array('choices'=>$SN),array()),
	  'ColaboracioCCG'     => new sfWidgetFormChoice(array('choices'=>$SN),array()),      
      'Comentaris'         => new sfWidgetFormTextarea(),      
      'Usuaris_usuariID'   => new sfWidgetFormInputHidden(),            
      'DataAlta'           => new sfWidgetFormInputHidden(),
    ));
  	  	
    $this->setValidators(array(
      'ReservaEspaiID'     => new sfValidatorPropelChoice(array('model' => 'Reservaespais', 'column' => 'ReservaEspaiID', 'required' => false)),
      'Representacio'      => new sfValidatorString(array('required' => false)),
      'Responsable'        => new sfValidatorString(array('required' => false)),
      'PersonalAutoritzat' => new sfValidatorString(array('required' => false)),
      'PrevisioAssistents' => new sfValidatorInteger(array('required' => false)),
      'EsCicle'            => new sfValidatorBoolean(array('required' => false)),
      'Exempcio'           => new sfValidatorBoolean(array('required' => false)),
      'Pressupost'         => new sfValidatorBoolean(array('required' => false)),
      'ColaboracioCCG'     => new sfValidatorBoolean(array('required' => false)),
      'Comentaris'         => new sfValidatorString(array('required' => false)),
      'Estat'              => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'Usuaris_usuariID'   => new sfValidatorPropelChoice(array('model' => 'Usuaris', 'column' => 'UsuariID', 'required' => false)),
      'Organitzadors'      => new sfValidatorString(array('required' => false)),
      'DataActivitat'      => new sfValidatorString(array('required' => false)),
      'HorariActivitat'    => new sfValidatorString(array('required' => false)),
      'TipusActe'          => new sfValidatorString(array('required' => false)),
      'Nom'                => new sfValidatorString(array('required' => false)),
      'isEnregistrable'    => new sfValidatorBoolean(array('required' => false)),
      'DataAlta'           => new sfValidatorDateTime(array('required' => false)),
      'EspaisSolicitats'   => new sfValidatorString(array('required' => false)),
      'MaterialSolicitat'  => new sfValidatorString(array('required' => false)),
    
    ));
    
    $this->widgetSchema->setLabels(array(
      'Estat'			   => "Estat actual: ",      
      'Nom'                => "Nom de l'activitat: ",
      'DataActivitat'      => "Data de l'activitat: ",
      'HorariActivitat'    => "Horari de l'activitat: ",
      'Espais'             => 'Espais: (<a class="blue" href="'.sfConfig::get('sf_webroot').'intranet_dev.php/web/espais" target="_NEW">veure\'ls</a>)',
      'Material'		   => "Material: ",
      'TipusActe'          => "Tipus d'acte: ",    
      'isEnregistrable'    => "És enregistrable?",
      'Representacio'      => "En representació de: ",    
      'Responsable'        => "Responsable: ",
      'Organitzadors'      => "Organitzadors: ",
      'PersonalAutoritzat' => "Personal autoritzat: ",    
      'PrevisioAssistents' => "Previsió d'assistents: ",
      'EsCicle'            => "És un cicle? ",
      'Exempcio'           => "Excempció de pagament? ",
      'Pressupost'         => "Necessiteu pressupost? ",
	  'ColaboracioCCG'     => "Col·laboració CCG? ",      
      'Comentaris'         => "Comentaris: ",
    ));
    
    $this->widgetSchema->setNameFormat('reservaespais[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);   
    
  }

  public function getModelName()
  {
    return 'Reservaespais';
  }

  public function save($conn = null)
  {

	$this->updateObject();
	$OR = $this->getObject();	  	  	
	if(!is_null($this['MaterialSolicitat']->getValue())) $OR->setMaterialsolicitat(implode('@',$this['MaterialSolicitat']->getValue()));
	if(!is_null($this['EspaisSolicitats']->getValue())) $OR->setEspaissolicitats(implode('@',$this['EspaisSolicitats']->getValue()));	
	$OR->save();
  	
  }
  
}


class sfWidgetFormSelectMany extends sfWidgetForm
{
  /**
   * Constructor.
   *
   * Available options:
   *
   *  * choices:  An array of possible choices (required)
   *  * multiple: true if the select tag must allow multiple selections
   *
   * @param array $options     An array of options
   * @param array $attributes  An array of default HTML attributes
   *
   * @see sfWidgetForm
   */
  protected function configure($options = array(), $attributes = array())
  {
    $this->addRequiredOption('choices');
    $this->addOption('multiple', false);
  }

  /**
   * @param  string $name        The element name
   * @param  string $value       The value selected in this widget
   * @param  array  $attributes  An array of HTML attributes to be merged with the default HTML attributes
   * @param  array  $errors      An array of errors for the field
   *
   * @return string An HTML tag string
   *
   * @see sfWidgetForm
   */
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    if ($this->getOption('multiple'))
    {
      $attributes['multiple'] = 'multiple';

      if ('[]' != substr($name, -2))
      {
        $name .= '[]';
      }
    }

    $choices = $this->getOption('choices');
    if ($choices instanceof sfCallable)
    {
      $choices = $choices->call();
    }
       
    return $this->renderContentTag('select', "\n".implode("\n", $this->getOptionsForSelect($value, $choices))."\n", array_merge(array('name' => $name), $attributes));
  }

  /**
   * Returns an array of option tags for the given choices
   *
   * @param  string $value    The selected value
   * @param  array  $choices  An array of choices
   *
   * @return array  An array of option tags
   */
  protected function getOptionsForSelect($value, $choices)
  {
    $mainAttributes = $this->attributes;
    $this->attributes = array();
    
    //Si el valor no és un array, vol dir que el carreguem de la BDD i l'hem de convertir
    if(!is_array($value)) $value = explode('@',(string)$value);    
    
    if (!is_array($value))
    {
      $value = array($value);
    }

    $value = array_map('strval', array_values($value));
    $value_set = array_flip($value);
    
    $options = array();
    foreach ($choices as $key => $option)
    {
      if (is_array($option))
      {
        $options[] = $this->renderContentTag('optgroup', implode("\n", $this->getOptionsForSelect($value, $option)), array('label' => self::escapeOnce($key)));
      }
      else
      {
        $attributes = array('value' => self::escapeOnce($key));
        if (isset($value_set[strval($key)]))
        {
          $attributes['selected'] = 'selected';
        }

        $options[] = $this->renderContentTag('option', self::escapeOnce($option), $attributes);
      }
    }

    $this->attributes = $mainAttributes;

    return $options;
  }

  public function __clone()
  {
    if ($this->getOption('choices') instanceof sfCallable)
    {
      $callable = $this->getOption('choices')->getCallable();
      $class = __CLASS__;
      if (is_array($callable) && $callable[0] instanceof $class)
      {
        $callable[0] = $this;
        $this->setOption('choices', new sfCallable($callable));
      }
    }
  }
}

