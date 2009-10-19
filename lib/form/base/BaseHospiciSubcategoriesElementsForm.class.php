<?php

/**
 * HospiciSubcategoriesElements form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseHospiciSubcategoriesElementsForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'element_id'      => new sfWidgetFormInputHidden(),
      'subcategoria_id' => new sfWidgetFormInputHidden(),
      'tipus'           => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'element_id'      => new sfValidatorPropelChoice(array('model' => 'HospiciSubcategoriesElements', 'column' => 'element_id', 'required' => false)),
      'subcategoria_id' => new sfValidatorPropelChoice(array('model' => 'HospiciSubcategoriesElements', 'column' => 'subcategoria_id', 'required' => false)),
      'tipus'           => new sfValidatorPropelChoice(array('model' => 'HospiciSubcategoriesElements', 'column' => 'tipus', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('hospici_subcategories_elements[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'HospiciSubcategoriesElements';
  }


}
