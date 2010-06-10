<?php

/**
 * Tipus filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseTipusFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'tipusNom'  => new sfWidgetFormFilterInput(),
      'tipusDesc' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'tipusNom'  => new sfValidatorPass(array('required' => false)),
      'tipusDesc' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('tipus_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Tipus';
  }

  public function getFields()
  {
    return array(
      'idTipus'   => 'Number',
      'tipusNom'  => 'Text',
      'tipusDesc' => 'Text',
    );
  }
}
