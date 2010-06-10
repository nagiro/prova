<?php

/**
 * Nivells filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseNivellsFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'Nom'       => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'Nom'       => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('nivells_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Nivells';
  }

  public function getFields()
  {
    return array(
      'idNivells' => 'Number',
      'Nom'       => 'Text',
    );
  }
}
