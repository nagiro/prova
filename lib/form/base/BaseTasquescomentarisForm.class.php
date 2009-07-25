<?php

/**
 * Tasquescomentaris form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseTasquescomentarisForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idTasquesComentaris' => new sfWidgetFormInputHidden(),
      'Tasques_TasquesID'   => new sfWidgetFormPropelChoice(array('model' => 'Tasques', 'add_empty' => false)),
      'Comentari'           => new sfWidgetFormTextarea(),
      'Data_2'              => new sfWidgetFormDate(),
    ));

    $this->setValidators(array(
      'idTasquesComentaris' => new sfValidatorPropelChoice(array('model' => 'Tasquescomentaris', 'column' => 'idTasquesComentaris', 'required' => false)),
      'Tasques_TasquesID'   => new sfValidatorPropelChoice(array('model' => 'Tasques', 'column' => 'TasquesID')),
      'Comentari'           => new sfValidatorString(),
      'Data_2'              => new sfValidatorDate(),
    ));

    $this->widgetSchema->setNameFormat('tasquescomentaris[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Tasquescomentaris';
  }


}
