<?php

/**
 * Material form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseMaterialForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idMaterial'                        => new sfWidgetFormInputHidden(),
      'MaterialGeneric_idMaterialGeneric' => new sfWidgetFormPropelChoice(array('model' => 'Materialgeneric', 'add_empty' => false)),
      'Nom'                               => new sfWidgetFormTextarea(),
      'Descripcio'                        => new sfWidgetFormTextarea(),
      'Responsable'                       => new sfWidgetFormTextarea(),
      'Ubicacio'                          => new sfWidgetFormTextarea(),
      'DataCompra'                        => new sfWidgetFormDate(),
      'Identificador'                     => new sfWidgetFormTextarea(),
      'NumSerie'                          => new sfWidgetFormTextarea(),
      'DataGarantia'                      => new sfWidgetFormDate(),
      'DataRevisio'                       => new sfWidgetFormDate(),
      'Cedit'                             => new sfWidgetFormTextarea(),
      'DataCessio'                        => new sfWidgetFormDate(),
      'DataRetorn'                        => new sfWidgetFormDate(),
      'NumFactura'                        => new sfWidgetFormTextarea(),
      'Preu'                              => new sfWidgetFormInput(),
      'NotesManteniment'                  => new sfWidgetFormTextarea(),
      'DataBaixa'                         => new sfWidgetFormDate(),
      'DataReparacio'                     => new sfWidgetFormDate(),
      'Disponible'                        => new sfWidgetFormInput(),
      'AltaRegistre'                      => new sfWidgetFormDate(),
      'isTransferible'                    => new sfWidgetFormInput(),
      'isAdministratiu'                   => new sfWidgetFormInput(),
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
      'isTransferible'                    => new sfValidatorInteger(),
      'isAdministratiu'                   => new sfValidatorInteger(),
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
