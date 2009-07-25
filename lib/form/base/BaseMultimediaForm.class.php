<?php

/**
 * Multimedia form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseMultimediaForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idMultimedia'     => new sfWidgetFormInputHidden(),
      'Cluber_idClubber' => new sfWidgetFormPropelChoice(array('model' => 'Cluber', 'add_empty' => false)),
      'NomAlbum'         => new sfWidgetFormTextarea(),
      'DescripcioAlbum'  => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'idMultimedia'     => new sfValidatorPropelChoice(array('model' => 'Multimedia', 'column' => 'idMultimedia', 'required' => false)),
      'Cluber_idClubber' => new sfValidatorPropelChoice(array('model' => 'Cluber', 'column' => 'idClubber')),
      'NomAlbum'         => new sfValidatorString(array('required' => false)),
      'DescripcioAlbum'  => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('multimedia[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Multimedia';
  }


}
