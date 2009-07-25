<?php

/**
 * WordStatical form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseWordStaticalForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'Paraula'     => new sfWidgetFormInputHidden(),
      'idObject'    => new sfWidgetFormInputHidden(),
      'Aparicions'  => new sfWidgetFormInput(),
      'Modul'       => new sfWidgetFormInputHidden(),
      'idSecondary' => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'Paraula'     => new sfValidatorPropelChoice(array('model' => 'WordStatical', 'column' => 'Paraula', 'required' => false)),
      'idObject'    => new sfValidatorPropelChoice(array('model' => 'WordStatical', 'column' => 'idObject', 'required' => false)),
      'Aparicions'  => new sfValidatorInteger(array('required' => false)),
      'Modul'       => new sfValidatorPropelChoice(array('model' => 'WordStatical', 'column' => 'Modul', 'required' => false)),
      'idSecondary' => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('word_statical[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'WordStatical';
  }


}
