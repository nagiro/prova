<?php

/**
 * Usuaris form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class ClientReservesForm extends sfFormPropel
{
	
  var $idU;
	
  public function setUser($idU)
  {
  	$this->idU = $idU;
  }
  
  public function setup()
  {
  	
  	$SN = array(true=>'Sí',false=>'No');
  	  	  	
    $this->setWidgets(array(
      'ReservaEspaiID'     => new sfWidgetFormInputHidden(),
      'Nom'                => new sfWidgetFormInputText(array(),array('style'=>'width:450px')),
      'DataActivitat'      => new sfWidgetFormInputText(array(),array('style'=>'width:450px')),
      'HorariActivitat'    => new sfWidgetFormInputText(array(),array('style'=>'width:450px')),
      'EspaisSolicitats'   => new sfWidgetFormChoice(array('renderer_class'=>'sfWidgetFormSelectManyMy', 'choices'=>EspaisPeer::selectFormReserva() , 'multiple'=>true , 'expanded'=>true),array('class'=>'ul_espais')),
      'MaterialSolicitat'  => new sfWidgetFormChoice(array('renderer_class'=>'sfWidgetFormSelectManyMy', 'choices'=>MaterialgenericPeer::selectFormulariUsuaris(), 'multiple'=>true ,'expanded'=>true),array('class'=>'ul_material')),
      'TipusActe'          => new sfWidgetFormInputText(array(),array('style'=>'width:450px')),    
      'Representacio'      => new sfWidgetFormInputText(array(),array('style'=>'width:450px')),    
      'Responsable'        => new sfWidgetFormInputText(array(),array('style'=>'width:450px')),
      'Organitzadors'      => new sfWidgetFormInputText(array(),array('style'=>'width:450px')),
      'PersonalAutoritzat' => new sfWidgetFormInputText(array(),array('style'=>'width:450px')),    
      'PrevisioAssistents' => new sfWidgetFormChoice(array('choices'=>$this->AssistentsArray()),array()),
      'isEnregistrable'    => new sfWidgetFormChoice(array('choices'=>$SN),array()),
      'EsCicle'            => new sfWidgetFormChoice(array('choices'=>$SN),array()),          
      'Comentaris'         => new sfWidgetFormTextarea(array(),array('style'=>'width:450px')),
      'Estat'              => new sfWidgetFormInputHidden(),
      'Usuaris_usuariID'   => new sfWidgetFormInputHidden(),            
      'DataAlta'           => new sfWidgetFormInputHidden(),
      'Condicions'		   => new sfWidgetFormChoice(array('choices'=>array(0=>'No',1=>'Sí'))),      
      'Codi'			   => new sfWidgetFormInputHidden(),
      'CondicionsCCG'      => new sfWidgetFormInputHidden(),
      'DataAcceptacioCondicions' => new sfWidgetFormInputHidden(),
      'ObservacionsCondicions' => new sfWidgetFormTextarea(array(),array('style'=>'width:450px')),
    ));

    $this->setValidators(array(
      'ReservaEspaiID'     => new sfValidatorPropelChoice(array('model' => 'Reservaespais', 'column' => 'ReservaEspaiID', 'required' => false)),
      'Representacio'      => new sfValidatorString(array('required' => false)),
      'Responsable'        => new sfValidatorString(array('required' => false)),
      'PersonalAutoritzat' => new sfValidatorString(array('required' => false)),
      'PrevisioAssistents' => new sfValidatorInteger(array('required' => false)),
      'EsCicle'            => new sfValidatorBoolean(array('required' => false)),
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
      'Condicions'		   => new sfValidatorBoolean(array('required' => false)),      
      'Codi'			   => new sfValidatorString(array('required'=>false)),
      'CondicionsCCG'      => new sfValidatorPass(),
      'DataAcceptacioCondicions' => new sfValidatorPass(),
      'ObservacionsCondicions' => new sfValidatorString(array('required'=>false)),    
    ));

    $this->widgetSchema->setLabels(array(      
      'Nom'                => "Nom de l'activitat ",
      'DataActivitat'      => "Proposta de data ",
      'HorariActivitat'    => "Proposta d'hores ",
      'Espais'             => 'Espais (<a class="blue" href="'.sfConfig::get('sf_webroot').'intranet_dev.php/web/espais" target="_NEW">veure\'ls</a>)',
      'Material'		   => "Material ",
      'TipusActe'          => "Tipus d'acte ",    
      'isEnregistrable'    => "És enregistrable?",
      'Representacio'      => "En representació de ",    
      'Responsable'        => "Responsable ",
      'Organitzadors'      => "Organitzadors ",
      'PersonalAutoritzat' => "Personal autoritzat ",    
      'PrevisioAssistents' => "Previsió d'assistents ",
      'EsCicle'            => "És un cicle? ",
      'Comentaris'         => "Comentaris ",
      'EspaisSolicitats'   => "Espais ",
      'MaterialSolicitat'  => "Material ",      
      'ObservacionsCondicions' => "Observacions ",
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
    if($OR->getDataalta() == "") $OR->setDataalta(date('Y-m-d H:i',time()));
    //Si ja s'han enviat les condicions i no tenim data d'acceptació, vol dir que estem guardant la confirmació.
    if($OR->getCondicionsCCG() != "" && $OR->getDataAcceptacioCondicions() == ""):        
        $OR->setDataAcceptacioCondicions(date('Y-m-d',time()));
        $OR->setEstat(ReservaespaisPeer::ACCEPTADA);        
    endif;   	  	
  	$OR->save();
  	
  }
  
  private function AssistentsArray()
  {
    $A = array();
    for($i=10;$i <= 150; $i=$i+10):
        $A[$i] = ($i-9).' a '.$i; 
    endfor;
    $A['200'] = '+ 150';
    return $A;
  }
  
}
