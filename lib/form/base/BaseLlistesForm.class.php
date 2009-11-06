<?php

/**
 * Llistes form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseLlistesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idLlistes'             => new sfWidgetFormInputHidden(),
      'Nom'                   => new sfWidgetFormTextarea(),
      'isActiva'              => new sfWidgetFormInput(),
      'missatgesllistes_list' => new sfWidgetFormPropelChoiceMany(array('model' => 'Missatgesmailing')),
    ));

    $this->setValidators(array(
      'idLlistes'             => new sfValidatorPropelChoice(array('model' => 'Llistes', 'column' => 'idLlistes', 'required' => false)),
      'Nom'                   => new sfValidatorString(),
      'isActiva'              => new sfValidatorInteger(),
      'missatgesllistes_list' => new sfValidatorPropelChoiceMany(array('model' => 'Missatgesmailing', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('llistes[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Llistes';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['missatgesllistes_list']))
    {
      $values = array();
      foreach ($this->object->getMissatgesllistess() as $obj)
      {
        $values[] = $obj->getIdmissatgesllistes();
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
    $c->add(MissatgesllistesPeer::LLISTES_IDLLISTES, $this->object->getPrimaryKey());
    MissatgesllistesPeer::doDelete($c, $con);

    $values = $this->getValue('missatgesllistes_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new Missatgesllistes();
        $obj->setLlistesIdllistes($this->object->getPrimaryKey());
        $obj->setIdmissatgesllistes($value);
        $obj->save();
      }
    }
  }

}
