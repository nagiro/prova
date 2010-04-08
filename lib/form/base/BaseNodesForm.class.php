<?php

/**
 * Nodes form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseNodesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idNodes'     => new sfWidgetFormInputHidden(),
      'TitolMenu'   => new sfWidgetFormTextarea(),
      'HTML'        => new sfWidgetFormTextarea(),
      'isCategoria' => new sfWidgetFormInput(),
      'isPhp'       => new sfWidgetFormInput(),
      'isActiva'    => new sfWidgetFormInput(),
      'Ordre'       => new sfWidgetFormInput(),
      'Nivell'      => new sfWidgetFormInput(),
      'Url'         => new sfWidgetFormTextarea(),
      'Categories'  => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'idNodes'     => new sfValidatorPropelChoice(array('model' => 'Nodes', 'column' => 'idNodes', 'required' => false)),
      'TitolMenu'   => new sfValidatorString(array('required' => false)),
      'HTML'        => new sfValidatorString(array('required' => false)),
      'isCategoria' => new sfValidatorInteger(array('required' => false)),
      'isPhp'       => new sfValidatorInteger(),
      'isActiva'    => new sfValidatorInteger(array('required' => false)),
      'Ordre'       => new sfValidatorInteger(array('required' => false)),
      'Nivell'      => new sfValidatorInteger(),
      'Url'         => new sfValidatorString(),
      'Categories'  => new sfValidatorString(array('max_length' => 100)),
    ));

    $this->widgetSchema->setNameFormat('nodes[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Nodes';
  }


}
