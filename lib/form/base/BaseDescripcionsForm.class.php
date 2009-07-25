<?php

/**
 * Descripcions form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseDescripcionsForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idDescripcions'         => new sfWidgetFormInputHidden(),
      'Activitats_ActivitatID' => new sfWidgetFormPropelChoice(array('model' => 'Activitats', 'add_empty' => false)),
      'Descripcio'             => new sfWidgetFormTextarea(),
      'Tipus'                  => new sfWidgetFormInput(),
      'Activa'                 => new sfWidgetFormInput(),
      'Imatge'                 => new sfWidgetFormTextarea(),
      'PDF'                    => new sfWidgetFormTextarea(),
      'PublicaWEB'             => new sfWidgetFormInput(),
      'tWEB'                   => new sfWidgetFormTextarea(),
      'dWEB'                   => new sfWidgetFormTextarea(),
      'tNoticia'               => new sfWidgetFormTextarea(),
      'dNoticia'               => new sfWidgetFormTextarea(),
      'tGENERAL'               => new sfWidgetFormTextarea(),
      'dGENERAL'               => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'idDescripcions'         => new sfValidatorPropelChoice(array('model' => 'Descripcions', 'column' => 'idDescripcions', 'required' => false)),
      'Activitats_ActivitatID' => new sfValidatorPropelChoice(array('model' => 'Activitats', 'column' => 'ActivitatID')),
      'Descripcio'             => new sfValidatorString(array('required' => false)),
      'Tipus'                  => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'Activa'                 => new sfValidatorInteger(array('required' => false)),
      'Imatge'                 => new sfValidatorString(array('required' => false)),
      'PDF'                    => new sfValidatorString(array('required' => false)),
      'PublicaWEB'             => new sfValidatorInteger(),
      'tWEB'                   => new sfValidatorString(),
      'dWEB'                   => new sfValidatorString(),
      'tNoticia'               => new sfValidatorString(),
      'dNoticia'               => new sfValidatorString(),
      'tGENERAL'               => new sfValidatorString(),
      'dGENERAL'               => new sfValidatorString(),
    ));

    $this->widgetSchema->setNameFormat('descripcions[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Descripcions';
  }


}
