<?php

/**
 * Agendatelefonica form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseAgendatelefonicaForm extends BaseFormPropel
{
	public function setup()
	{
		$this->setWidgets(array(
      'AgendaTelefonicaID' => new sfWidgetFormInputHidden(),
      'Nom'                => new sfWidgetFormTextarea(),
      'NIF'                => new sfWidgetFormTextarea(),
      'DataAlta'           => new sfWidgetFormDate(),
      'Notes'              => new sfWidgetFormTextarea(),
      'Tags'               => new sfWidgetFormTextarea(),
      'Entitat'            => new sfWidgetFormTextarea(),
		));

		$this->setValidators(array(
      'AgendaTelefonicaID' => new sfValidatorPropelChoice(array('model' => 'Agendatelefonica', 'column' => 'AgendaTelefonicaID', 'required' => false)),
      'Nom'                => new sfValidatorString(array('required' => false)),
      'NIF'                => new sfValidatorString(array('required' => false)),
      'DataAlta'           => new sfValidatorDate(array('required' => false)),
      'Notes'              => new sfValidatorString(array('required' => false)),
      'Tags'               => new sfValidatorString(array('required' => false)),
      'Entitat'            => new sfValidatorString(array('required' => false)),
		));

		$this->widgetSchema->setNameFormat('agendatelefonica[%s]');

		$this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

		parent::setup();
	}

	public function getModelName()
	{
		return 'Agendatelefonica';
	}


}
