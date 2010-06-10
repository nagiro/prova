<?php

/**
 * Materialgeneric filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseMaterialgenericFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'Nom'               => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'Nom'               => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('materialgeneric_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Materialgeneric';
  }

  public function getFields()
  {
    return array(
      'idMaterialGeneric' => 'Number',
      'Nom'               => 'Text',
    );
  }
}
