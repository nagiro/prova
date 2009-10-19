<?php

/**
 * HospiciDocuments form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseHospiciDocumentsForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'document_id' => new sfWidgetFormInputHidden(),
      'url'         => new sfWidgetFormTextarea(),
      'nom'         => new sfWidgetFormTextarea(),
      'descripcio'  => new sfWidgetFormTextarea(),
      'tags'        => new sfWidgetFormTextarea(),
      'data_alta'   => new sfWidgetFormDate(),
    ));

    $this->setValidators(array(
      'document_id' => new sfValidatorPropelChoice(array('model' => 'HospiciDocuments', 'column' => 'document_id', 'required' => false)),
      'url'         => new sfValidatorString(),
      'nom'         => new sfValidatorString(),
      'descripcio'  => new sfValidatorString(),
      'tags'        => new sfValidatorString(),
      'data_alta'   => new sfValidatorDate(),
    ));

    $this->widgetSchema->setNameFormat('hospici_documents[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'HospiciDocuments';
  }


}
