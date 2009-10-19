<?php

/**
 * HospiciCategoria form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseHospiciCategoriaForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'categoria_id' => new sfWidgetFormInputHidden(),
      'tipus'        => new sfWidgetFormInput(),
      'nom'          => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'categoria_id' => new sfValidatorPropelChoice(array('model' => 'HospiciCategoria', 'column' => 'categoria_id', 'required' => false)),
      'tipus'        => new sfValidatorString(array('max_length' => 1)),
      'nom'          => new sfValidatorString(),
    ));

    $this->widgetSchema->setNameFormat('hospici_categoria[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'HospiciCategoria';
  }


}
