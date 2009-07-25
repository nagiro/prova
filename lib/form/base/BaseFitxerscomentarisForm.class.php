<?php

/**
 * Fitxerscomentaris form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseFitxerscomentarisForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idFitxersComentaris' => new sfWidgetFormInputHidden(),
      'Cluber_idClubber'    => new sfWidgetFormPropelChoice(array('model' => 'Cluber', 'add_empty' => false)),
      'Fitxers_FitxersID'   => new sfWidgetFormPropelChoice(array('model' => 'Fitxers', 'add_empty' => false)),
      'Comentari'           => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'idFitxersComentaris' => new sfValidatorPropelChoice(array('model' => 'Fitxerscomentaris', 'column' => 'idFitxersComentaris', 'required' => false)),
      'Cluber_idClubber'    => new sfValidatorPropelChoice(array('model' => 'Cluber', 'column' => 'idClubber')),
      'Fitxers_FitxersID'   => new sfValidatorPropelChoice(array('model' => 'Fitxers', 'column' => 'FitxersID')),
      'Comentari'           => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('fitxerscomentaris[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Fitxerscomentaris';
  }


}
