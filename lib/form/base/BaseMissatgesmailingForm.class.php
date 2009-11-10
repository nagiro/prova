<?php

/**
 * Missatgesmailing form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseMissatgesmailingForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idMissatge'            => new sfWidgetFormInputHidden(),
      'titol'                 => new sfWidgetFormTextarea(),
      'text'                  => new sfWidgetFormTextarea(),
      'data_alta'             => new sfWidgetFormDate(),
      'missatgesllistes_list' => new sfWidgetFormPropelChoiceMany(array('model' => 'Llistes')),
    ));

    $this->setValidators(array(
      'idMissatge'            => new sfValidatorPropelChoice(array('model' => 'Missatgesmailing', 'column' => 'idMissatge', 'required' => false)),
      'titol'                 => new sfValidatorString(),
      'text'                  => new sfValidatorString(),
      'data_alta'             => new sfValidatorDate(),
      'missatgesllistes_list' => new sfValidatorPropelChoiceMany(array('model' => 'Llistes', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('missatgesmailing[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Missatgesmailing';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['missatgesllistes_list']))
    {
      $values = array();
      foreach ($this->object->getMissatgesllistess() as $obj)
      {
        $values[] = $obj->getLlistesIdllistes();
      }

      $this->setDefault('missatgesllistes_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->saveMissatgesllistesList($con);
  }

  public function saveMissatgesllistesList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['missatgesllistes_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (is_null($con))
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(MissatgesllistesPeer::IDMISSATGESLLISTES, $this->object->getPrimaryKey());
    MissatgesllistesPeer::doDelete($c, $con);

    $values = $this->getValue('missatgesllistes_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new Missatgesllistes();
        $obj->setIdmissatgesllistes($this->object->getPrimaryKey());
        $obj->setLlistesIdllistes($value);
        $obj->save();
      }
    }
  }

}
