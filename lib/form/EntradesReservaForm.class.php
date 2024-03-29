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
      'usuari_id'                   => new sfWidgetFormJQueryAutocompleter( array( 'url' => $this->getOption( 'ajax' ) ) , array( 'style' => 'width:400px' ) ) ,                                        
      'nom_reserva'                 => new sfWidgetFormInputText(array(),array('style'=>'width:400px')),
      'email_reserva'               => new sfWidgetFormInputText(array(),array('style'=>'width:200px')),
      'telefon_reserva'             => new sfWidgetFormInputText(array(),array('style'=>'width:200px')),
      'quantitat'                   => new sfWidgetFormChoice(array('choices'=>array('1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5')),array('style'=>'width:50px')),
      'data'                        => new sfWidgetFormShowText(),
      'estat'                       => new sfWidgetFormInputHidden(),
      'tipus_pagament'              => new sfWidgetFormChoice(array('choices'=>EntradesReservaPeer::getTipusPagaments( $this->getOption('IDA') , $this->getOption('IDH') , true ))),
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
    
  /**
   * Retorna un array ( status, OER );
   * */
  public function saveMy(){
    
    //Aquest guardar, no guarda l'objecte en sí, sinó que crida un mètode per igualar-lo amb l'hospici.    
    $this->updateObject();
    $OER = $this->getObject();
                                            
    //Mirem que hagi entrat o bé el nom d'usuari o bé el codi.
    if( $OER->getNomReserva() == "" && is_null($OER->getUsuariId())) throw new Exception("Selecciona un usuari de l'Hospici o bé entra el seu nom.");

    //Si hem entrat el codi d'usuari, guardem la info amb les dades de l'usuari.
    if(!is_null($OER->getUsuariId())):    
        $OU = UsuarisPeer::retrieveByPK($OER->getUsuariId());        
        if($OU instanceof Usuaris):        
            $OER->setNomReserva( $OU->getNomComplet() );
            $OER->setEmailReserva( $OU->getEmail() );
            $OER->setTelefonReserva( $OU->getTelefonString() );            
        else:        
            throw new Exception('L\'usuari seleccionat, no s\'ha trobat a la base de dades.');            
        endif;
    elseif($OER->getNomReserva() != ""):
        //No cal fer res, perquè se suposa que les dades ja s'han entrat correctament i quan guardem quedarà guardada.        
    else:
        throw new Exception('Hi ha algun problema amb el nom o codi d\'usuari.');
    endif;    
    
    //D'entrada és correcte, així que si l'entrada és nova, fem la compra.
    if( $this->isNew() ):
        $RET = EntradesReservaPeer::setCompraEntrada($OER->getEntradesPreusHorariId() , $OER->getUsuariId() , $OER->getQuantitat() , $OER->getDescompte() , $OER->getTipusPagament() );
        
        //Tornem a posar OER amb els nous valors després de la compra
        $OER = $RET['OER'];                
        
        switch($RET['status']){
            case -1: throw new Exception('Hi ha hagut algun problema buscant l\'horari. Informeu-ne a informatica@casadecultura.org'); break;
            case -2: throw new Exception('Hi ha hagut algun problema buscant l\'activitat. Informeu-ne a informatica@casadecultura.org'); break;
            case -3: throw new Exception('Hi ha hagut algun problema buscant el preu. Informeu-ne a informatica@casadecultura.org'); break;
            case -4: throw new Exception('Aquest usuari ja ha comprat una entrada per aquest espectacle.'); break;
            case -5: throw new Exception('Aquesta activitat ja no té entrades disponibles.'); break;
            case -6: throw new Exception('Error de TPV.'); break;
            case -7: throw new Exception('El número d\'entrades comprades ha de ser superior a 0.'); break;                        
        } 
    else: 
        $RET['OER'] = $OER; //L'objecte que hem creat al principi el guardem a l'array per passar-lo.
        $RET['status'] = 0;       //Marquem l'status a 0 perquè no és nou... només és una modificació
    endif;
                
    //Si no hi ha cap error, guardem. 
    if( $RET['status'] >= 0 ) $RET['OER']->save();
    
    return $RET;                                                    
       
  }
}