<?php

/**
 * Material form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class MaterialForm extends sfFormPropel
{
	
  public function setup()
  {
  	$Fdata = array('format'=>'%day%/%month%/%year%');
  	
    $this->setWidgets(array(
      'idMaterial'                        => new sfWidgetFormInputHidden(),
      'MaterialGeneric_idMaterialGeneric' => new sfWidgetFormInputHidden(),
      'Identificador'                     => new sfWidgetFormInput(),
      'Nom'                               => new sfWidgetFormInput(),
	  'Ubicacio'                          => new sfWidgetFormInput(),
      'Responsable'                       => new sfWidgetFormChoice(array('choices'=>UsuarisPeer::selectTreballadors())),
      'Disponible'                        => new sfWidgetFormChoice(array('choices'=>array(1=>'Sí',0=>'No'))),
      'Descripcio'                        => new sfWidgetFormTextarea(array(),array('cols'=>'60','rows'=>'10')),
      'NumSerie'                          => new sfWidgetFormInput(),      
      'DataCompra'                        => new sfWidgetFormDate($Fdata),
      'DataGarantia'                      => new sfWidgetFormDate($Fdata),
      'DataRevisio'                       => new sfWidgetFormDate($Fdata),
      'Cedit'                             => new sfWidgetFormInputHidden(),
      'DataCessio'                        => new sfWidgetFormInputHidden(),
      'DataRetorn'                        => new sfWidgetFormInputHidden(),
      'NumFactura'                        => new sfWidgetFormInput(),
      'Preu'                              => new sfWidgetFormInput(),
      'DataBaixa'                         => new sfWidgetFormDate($Fdata),
      'DataReparacio'                     => new sfWidgetFormInputHidden(),
      'AltaRegistre'                      => new sfWidgetFormInputHidden(),
      'NotesManteniment'                  => new sfWidgetFormTextarea(array(),array('cols'=>'60','rows'=>'5')),
    ));

    
    $this->setValidators(array(
      'idMaterial'                        => new sfValidatorPropelChoice(array('model' => 'Material', 'column' => 'idMaterial', 'required' => false)),
      'MaterialGeneric_idMaterialGeneric' => new sfValidatorPropelChoice(array('model' => 'Materialgeneric', 'column' => 'idMaterialGeneric')),
      'Nom'                               => new sfValidatorString(array('required' => false)),
      'Descripcio'                        => new sfValidatorString(array('required' => false)),
      'Responsable'                       => new sfValidatorString(array('required' => false)),
      'Ubicacio'                          => new sfValidatorString(array('required' => false)),
      'DataCompra'                        => new sfValidatorDate(array('required' => false)),
      'Identificador'                     => new sfValidatorString(array('required' => false)),
      'NumSerie'                          => new sfValidatorString(array('required' => false)),
      'DataGarantia'                      => new sfValidatorDate(array('required' => false)),
      'DataRevisio'                       => new sfValidatorDate(array('required' => false)),
      'Cedit'                             => new sfValidatorString(array('required' => false)),
      'DataCessio'                        => new sfValidatorDate(array('required' => false)),
      'DataRetorn'                        => new sfValidatorDate(array('required' => false)),
      'NumFactura'                        => new sfValidatorString(array('required' => false)),
      'Preu'                              => new sfValidatorInteger(array('required' => false)),
      'NotesManteniment'                  => new sfValidatorString(array('required' => false)),
      'DataBaixa'                         => new sfValidatorDate(array('required' => false)),
      'DataReparacio'                     => new sfValidatorDate(array('required' => false)),
      'Disponible'                        => new sfValidatorInteger(array('required' => false)),
      'AltaRegistre'                      => new sfValidatorDate(array('required' => false)),
    ));

    $this->widgetSchema->setLabels(array(            
      'Identificador'                     => 'Identificador: ',
      'Nom'                               => 'Nom: ',
	  'Ubicacio'                          => 'Ubicació: ',
      'Responsable'                       => 'Responsable: ',
      'Disponible'                        => 'Disponible? ',
      'Descripcio'                        => 'Descripció: ',
      'NumSerie'                          => 'Núm. sèrie: ',      
      'DataCompra'                        => 'Compra: ',
      'DataGarantia'                      => 'Fi garantia: ',
      'DataRevisio'                       => 'Propera revisió: ',      
      'NumFactura'                        => 'Núm. factura: ',
      'Preu'                              => 'Preu: ',
      'DataBaixa'                         => 'Baixa: ',      
      'NotesManteniment'                  => 'Notes: ',
    ));
    
    $this->widgetSchema->setDefaults(array(            
	  'Ubicacio'                          => 'Magatzem',      
      'Disponible'                        => 1,
      'DataCompra'                        => date('d-m-Y',time()),                        
    ));
    
    
    $this->widgetSchema->setNameFormat('material[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Material';
  }

}
