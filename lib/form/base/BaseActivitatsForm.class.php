<?php

/**
 * Activitats form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseActivitatsForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'ActivitatID'                     => new sfWidgetFormInputHidden(),
      'Cicles_CicleID'                  => new sfWidgetFormPropelChoice(array('model' => 'Cicles', 'add_empty' => true)),
      'TipusActivitat_idTipusActivitat' => new sfWidgetFormPropelChoice(array('model' => 'Tipusactivitat', 'add_empty' => true)),
      'Nom'                             => new sfWidgetFormTextarea(),
      'Preu'                            => new sfWidgetFormInput(),
      'PreuReduit'                      => new sfWidgetFormInput(),
      'Publicable'                      => new sfWidgetFormInput(),
      'Estat'                           => new sfWidgetFormInput(),
      'Descripcio'                      => new sfWidgetFormTextarea(),
      'Imatge'                          => new sfWidgetFormTextarea(),
      'PDF'                             => new sfWidgetFormTextarea(),
      'PublicaWEB'                      => new sfWidgetFormInput(),
      'tWEB'                            => new sfWidgetFormTextarea(),
      'dWEB'                            => new sfWidgetFormTextarea(),
      'tNoticia'                        => new sfWidgetFormTextarea(),
      'dNoticia'                        => new sfWidgetFormTextarea(),
      'tGENERAL'                        => new sfWidgetFormTextarea(),
      'dGENERAL'                        => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'ActivitatID'                     => new sfValidatorPropelChoice(array('model' => 'Activitats', 'column' => 'ActivitatID', 'required' => false)),
      'Cicles_CicleID'                  => new sfValidatorPropelChoice(array('model' => 'Cicles', 'column' => 'CicleID', 'required' => false)),
      'TipusActivitat_idTipusActivitat' => new sfValidatorPropelChoice(array('model' => 'Tipusactivitat', 'column' => 'idTipusActivitat', 'required' => false)),
      'Nom'                             => new sfValidatorString(array('required' => false)),
      'Preu'                            => new sfValidatorNumber(array('required' => false)),
      'PreuReduit'                      => new sfValidatorNumber(array('required' => false)),
      'Publicable'                      => new sfValidatorInteger(array('required' => false)),
      'Estat'                           => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'Descripcio'                      => new sfValidatorString(),
      'Imatge'                          => new sfValidatorString(),
      'PDF'                             => new sfValidatorString(),
      'PublicaWEB'                      => new sfValidatorInteger(),
      'tWEB'                            => new sfValidatorString(),
      'dWEB'                            => new sfValidatorString(),
      'tNoticia'                        => new sfValidatorString(),
      'dNoticia'                        => new sfValidatorString(),
      'tGENERAL'                        => new sfValidatorString(),
      'dGENERAL'                        => new sfValidatorString(),
    ));

    $this->widgetSchema->setNameFormat('activitats[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Activitats';
  }


}
