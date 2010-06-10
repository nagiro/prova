<?php

/**
 * Tipusactivitat filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseTipusactivitatFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'Nom'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'Nom'              => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('tipusactivitat_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Tipusactivitat';
  }

  public function getFields()
  {
    return array(
      'idTipusActivitat' => 'Number',
      'Nom'              => 'Text',
    );
  }
}
