<?php

/**
 * DadesBancaries form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
class DadesBancariesForm extends BaseDadesBancariesForm
{
    public function setup()
    {
        $this->setWidgets(array(
          'idDada'   => new sfWidgetFormInputHidden(),
          'idUsuari' => new sfWidgetFormInputHidden(),
          'nif'      => new sfWidgetFormInput(array(),array('style'=>'width:100px;')),
          'titular'  => new sfWidgetFormInput(array(),array('style'=>'width:400px;')),          
          'entitat'  => new sfWidgetFormInput(array(),array('style'=>'width:400px;')),
          'poblacio' => new sfWidgetFormInput(array(),array('style'=>'width:400px;')),
          'ccc'      => new sfWidgetFormInput(array(),array('style'=>'width:400px;')),
          'actiu'    => new sfWidgetFormChoice(array('choices'=>array(1=>'Sí', 0=>'No'))),
          'site_id'  => new sfWidgetFormInputHidden(),
        ));
        
        $this->setValidators(array(
          'idDada'   => new sfValidatorChoice(array('choices' => array($this->getObject()->getIddada()), 'empty_value' => $this->getObject()->getIddada(), 'required' => false)),
          'idUsuari' => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
          'titular'  => new sfValidatorString(array('required' => false)),
          'nif'      => new sfValidatorString(array('required' => false)),
          'entitat'  => new sfValidatorString(array('required' => false)),
          'poblacio' => new sfValidatorString(array('required' => false)),
          'ccc'      => new sfValidatorString(),
          'actiu'    => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
          'site_id'  => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
        ));                
        
        $this->setValidator('ccc', 
            new sfValidatorCallback( array(
                'callback'=>array('DadesBancariesForm','ComprovaCCC'), 
                'arguments' => array('IDS'=>$this->getOption('IDS'), 'IDU'=>$this->getOption('IDU')) , 
                'required'=>true)));
        
        $this->widgetSchema->setLabels(array(
          'titular'  => 'Titular del compte: ',
          'nif'      => 'NIF: ',
          'entitat'  => 'Entitat: ',
          'poblacio' => 'Població: ',
          'ccc'      => 'Compte corrent: ',
          'actiu'    => 'És actiu?',        
        ));
        
        
        
        $this->widgetSchema->setNameFormat('dades_bancaries[%s]');
        
        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
    }
    
    static public function ComprovaCCC($A,$valor,$arguments)
    {
      	        
        $CCC = $valor;
        
        if(DadesBancariesPeer::isCorrecteCCC($CCC) <= 0) throw new sfValidatorError($A, "Error: El compte corrent és incorrecte.<br /> Recorda escriure'l sense espais ni guions.");
        if(DadesBancariesPeer::isExisteix($CCC,$arguments['IDS'],$arguments['IDU'])) throw new sfValidatorError($A, "Error: El compte corrent ja existeix.");        
                        
        return $valor;
      	
    } 
       
}