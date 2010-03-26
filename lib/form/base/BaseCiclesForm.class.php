<?php

/**
 * Cicles form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseCiclesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'CicleID'  => new sfWidgetFormInputHidden(),
      'Nom'      => new sfWidgetFormTextarea(),
      'Imatge'   => new sfWidgetFormInput(),
      'PDF'      => new sfWidgetFormInput(),
      'tCurt'    => new sfWidgetFormTextarea(),
      'dCurt'    => new sfWidgetFormTextarea(),
      'tMig'     => new sfWidgetFormTextarea(),
      'dMig'     => new sfWidgetFormTextarea(),
      'tComplet' => new sfWidgetFormTextarea(),
      'dComplet' => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'CicleID'  => new sfValidatorPropelChoice(array('model' => 'Cicles', 'column' => 'CicleID', 'required' => false)),
      'Nom'      => new sfValidatorString(array('required' => false)),
      'Imatge'   => new sfValidatorString(array('max_length' => 255)),
      'PDF'      => new sfValidatorString(array('max_length' => 255)),
      'tCurt'    => new sfValidatorString(),
      'dCurt'    => new sfValidatorString(),
      'tMig'     => new sfValidatorString(),
      'dMig'     => new sfValidatorString(),
      'tComplet' => new sfValidatorString(),
      'dComplet' => new sfValidatorString(),
    ));

    $this->widgetSchema->setNameFormat('cicles[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Cicles';
  }


}
