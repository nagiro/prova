<?php

/**
 * EntradesReserva form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Albert Johé i Martí
 */
class EntradesReservaForm extends BaseEntradesReservaForm
{
        
  public function setup()
  {

    $this->setWidgets(array(
      'idEntrada'                   => new sfWidgetFormInputHidden(),
      'entrades_preus_horari_id'    => new sfWidgetFormInputHidden(),
      'entrades_preus_activitat_id' => new sfWidgetFormInputHidden(),
      'usuari_id'                   => new sfWidgetFormJQueryAutocompleter(array('url'=>$this->getOption('ajax'),'value_callback'=>array('UsuarisPeer','getNomComplet')),array('style'=>'width:400px;')),
      'nom_reserva'                 => new sfWidgetFormInputText(array(),array('style'=>'width:400px')),
      'email_reserva'               => new sfWidgetFormInputText(array(),array('style'=>'width:200px')),
      'telefon_reserva'             => new sfWidgetFormInputText(array(),array('style'=>'width:200px')),
      'quantitat'                   => new sfWidgetFormChoice(array('choices'=>array('1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5')),array('style'=>'width:50px')),
      'data'                        => new sfWidgetFormShowText(),
      'estat'                       => new sfWidgetFormInputHidden(),
      'tipus_pagament'              => new sfWidgetFormChoice(array('choices'=>EntradesReservaPeer::getTipusPagaments( $this->getOption('IDA') , $this->getOption('IDH') ))),
      'descompte'                   => new sfWidgetFormChoice(array('choices'=>EntradesPreusPeer::getDescomptesArray( $this->getOption('IDA'), $this->getOption('IDH'),true))),
      'actiu'                       => new sfWidgetFormInputHidden(),
      'site_id'                     => new sfWidgetFormInputHidden(),
      'comentari'                   => new sfWidgetFormTextarea(),
    ));
    
    if(!$this->isNew()):
        $this->setWidget('estat', new sfWidgetFormChoice(array('choices'=>EntradesReservaPeer::selectEstats())));
    endif;
    
    $this->setValidators(array(
      'idEntrada'                   => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdentrada()), 'empty_value' => $this->getObject()->getIdentrada(), 'required' => false)),
      'entrades_preus_horari_id'    => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'entrades_preus_activitat_id' => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'usuari_id'                   => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'nom_reserva'                 => new sfValidatorString(array('required' => false)),
      'email_reserva'               => new sfValidatorString(array('required' => false)),
      'telefon_reserva'             => new sfValidatorString(array('required' => false)),
      'quantitat'                   => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
      'data'                        => new sfValidatorDateTime(array('required' => false)),
      'estat'                       => new sfValidatorInteger(array('min' => -32768, 'max' => 32767, 'required' => false)),
      'tipus_pagament'              => new sfValidatorInteger(array('required' => false),array()),
      'descompte'                   => new sfValidatorInteger(array('required' => false),array()),
      'actiu'                       => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
      'site_id'                     => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'comentari'                   => new sfValidatorString(array('required'=>false)),
    ));

    $this->widgetSchema->setLabels(array(
      'usuari_id'                   => 'Usuari hospici: ',
      'nom_reserva'                 => 'Nom: ',
      'quantitat'                   => 'Entrades:',
      'data'                        => 'Data: ',      
      'tipus_pagament'              => 'Pagament?',
      'comentari'                   => 'Comentari: ',
    ));

    $this->widgetSchema->setNameFormat('entrades_reserva[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
    
    $this->widgetSchema->setFormFormatterName('Span');

  }
    
  public function save($conn = null){
    
    $this->updateObject();
    $OER = $this->getObject();
    
    if($this->isNew()){
        
        //S'ha d'haver omplert o bé l'Usuari ID o bé el nom
        if( $OER->getNomReserva() == "" && is_null($OER->getUsuariId())) throw new Exception("Selecciona un usuari de l'Hospici o bé entra el seu nom.");
        elseif(!is_null($OER->getUsuariId())) $OER->setNomReserva(UsuarisPeer::retrieveByPK($OER->getUsuariId())->getNomComplet());
        elseif($OER->getNomReserva() != "") {}  
        else throw new Exception('Hi ha algun problema amb el nom o codi d\'usuari.');        
        
        //Marquem l'estat actual segons el tipus de pagament. Si és amb targeta, el posem a "EN PROCÉS";
        if($OER->getTipusPagament() == EntradesReservaPeer::PAGAMENT_TARGETA) $OER->setEstat(EntradesReservaPeer::ESTAT_ENTRADA_EN_PROCES);
        elseif($OER->getTipusPagament() == EntradesReservaPeer::PAGAMENT_METALIC) $OER->setEstat(EntradesReservaPeer::ESTAT_ENTRADA_CONFIRMADA);
        elseif($OER->getTipusPagament() == EntradesReservaPeer::PAGAMENT_RESERVA) $OER->setEstat(EntradesReservaPeer::ESTAT_ENTRADA_RESERVADA);
        else $OER->setEstat(EntradesReservaPeer::ESTAT_ENTRADA_ERROR);
        
        //Mirem el preu relacionat... i calculem el descompte aplicable
        $OEP = EntradesPreusPeer::retrieveByPK( $OER->getEntradesPreusHorariId() , $OER->getEntradesPreusActivitatId() );
        if(!($OEP instanceof EntradesPreus)) throw new Exception("No s'ha trobat el preu relacionat."); 
        
        //Calculem quant ha pagat, apliquem descomptes i guardem. 
        $preu = DescomptesPeer::getPreuAmbDescompte($OEP->getPreu(),$OER->getDescompte());
        $preu = $preu * $OER->getQuantitat(); //Calculem el preu final pagat amb el nombre d'entrades venudes.
        $OER->setPagat($preu);                                         
    }
    
    $OER->save();
    
    return $OER;
     
  }
}
