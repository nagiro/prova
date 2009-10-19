<?php

/**
 * HospiciSubcategories form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseHospiciSubcategoriesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'subcategoria_id' => new sfWidgetFormInputHidden(),
      'categoria_id'    => new sfWidgetFormInput(),
      'nom'             => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'subcategoria_id' => new sfValidatorPropelChoice(array('model' => 'HospiciSubcategories', 'column' => 'subcategoria_id', 'required' => false)),
      'categoria_id'    => new sfValidatorInteger(),
      'nom'             => new sfValidatorString(),
    ));

    $this->widgetSchema->setNameFormat('hospici_subcategories[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'HospiciSubcategories';
  }


}
