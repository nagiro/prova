<?php

/**
 * Cessio form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseCessioForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'cessio_id'      => new sfWidgetFormInputHidden(),
      'usuari_id'      => new sfWidgetFormPropelChoice(array('model' => 'Usuaris', 'add_empty' => false)),
      'representant'   => new sfWidgetFormInput(),
      'data_cessio'    => new sfWidgetFormDate(),
      'data_retorn'    => new sfWidgetFormDate(),
      'estat'          => new sfWidgetFormTextarea(),
      'retornat'       => new sfWidgetFormInput(),
      'estat_retornat' => new sfWidgetFormTextarea(),
      'data_retornat'  => new sfWidgetFormDate(),
    ));

    $this->setValidators(array(
      'cessio_id'      => new sfValidatorPropelChoice(array('model' => 'Cessio', 'column' => 'cessio_id', 'required' => false)),
      'usuari_id'      => new sfValidatorPropelChoice(array('model' => 'Usuaris', 'column' => 'UsuariID')),
      'representant'   => new sfValidatorString(array('max_length' => 100)),
      'data_cessio'    => new sfValidatorDate(),
      'data_retorn'    => new sfValidatorDate(),
      'estat'          => new sfValidatorString(),
      'retornat'       => new sfValidatorInteger(),
      'estat_retornat' => new sfValidatorString(),
      'data_retornat'  => new sfValidatorDate(),
    ));

    $this->widgetSchema->setNameFormat('cessio[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Cessio';
  }


}
