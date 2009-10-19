<?php

/**
 * Noticies form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseNoticiesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idNoticia'       => new sfWidgetFormInputHidden(),
      'TitolNoticia'    => new sfWidgetFormInput(),
      'TextNoticia'     => new sfWidgetFormTextarea(),
      'DataPublicacio'  => new sfWidgetFormDate(),
      'Activa'          => new sfWidgetFormInput(),
      'Imatge'          => new sfWidgetFormInput(),
      'Adjunt'          => new sfWidgetFormInput(),
      'idActivitat'     => new sfWidgetFormInput(),
      'DataDesaparicio' => new sfWidgetFormDate(),
    ));

    $this->setValidators(array(
      'idNoticia'       => new sfValidatorPropelChoice(array('model' => 'Noticies', 'column' => 'idNoticia', 'required' => false)),
      'TitolNoticia'    => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'TextNoticia'     => new sfValidatorString(array('required' => false)),
      'DataPublicacio'  => new sfValidatorDate(array('required' => false)),
      'Activa'          => new sfValidatorInteger(array('required' => false)),
      'Imatge'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'Adjunt'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'idActivitat'     => new sfValidatorInteger(array('required' => false)),
      'DataDesaparicio' => new sfValidatorDate(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('noticies[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Noticies';
  }


}
