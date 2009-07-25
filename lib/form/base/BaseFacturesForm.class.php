<?php

/**
 * Factures form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseFacturesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'FacturaID'              => new sfWidgetFormInputHidden(),
      'Proveidors_ProveidorID' => new sfWidgetFormPropelChoice(array('model' => 'Proveidors', 'add_empty' => false)),
      'Conceptes_ConcepteID'   => new sfWidgetFormPropelChoice(array('model' => 'Conceptes', 'add_empty' => false)),
      'DataFactura'            => new sfWidgetFormDate(),
      'Quantitat'              => new sfWidgetFormInput(),
      'NumFactura'             => new sfWidgetFormTextarea(),
      'DataPagament'           => new sfWidgetFormDate(),
      'ModalitatPagament'      => new sfWidgetFormTextarea(),
      'SubConcepte'            => new sfWidgetFormTextarea(),
      'TipusComptable'         => new sfWidgetFormTextarea(),
      'Text'                   => new sfWidgetFormTextarea(),
      'ValidaUsuari'           => new sfWidgetFormPropelChoice(array('model' => 'Usuaris', 'add_empty' => true)),
      'ValidatData'            => new sfWidgetFormDate(),
    ));

    $this->setValidators(array(
      'FacturaID'              => new sfValidatorPropelChoice(array('model' => 'Factures', 'column' => 'FacturaID', 'required' => false)),
      'Proveidors_ProveidorID' => new sfValidatorPropelChoice(array('model' => 'Proveidors', 'column' => 'ProveidorID')),
      'Conceptes_ConcepteID'   => new sfValidatorPropelChoice(array('model' => 'Conceptes', 'column' => 'ConcepteID')),
      'DataFactura'            => new sfValidatorDate(array('required' => false)),
      'Quantitat'              => new sfValidatorNumber(array('required' => false)),
      'NumFactura'             => new sfValidatorString(array('required' => false)),
      'DataPagament'           => new sfValidatorDate(array('required' => false)),
      'ModalitatPagament'      => new sfValidatorString(array('required' => false)),
      'SubConcepte'            => new sfValidatorString(array('required' => false)),
      'TipusComptable'         => new sfValidatorString(array('required' => false)),
      'Text'                   => new sfValidatorString(array('required' => false)),
      'ValidaUsuari'           => new sfValidatorPropelChoice(array('model' => 'Usuaris', 'column' => 'UsuariID', 'required' => false)),
      'ValidatData'            => new sfValidatorDate(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('factures[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Factures';
  }


}
