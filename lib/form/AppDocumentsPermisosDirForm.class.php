<?php

/**
 * AppDocumentsPermisosDir form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class AppDocumentsPermisosDirForm extends sfFormPropel
{
	
  public function setup()
  {
    $this->setWidgets(array(
      'idUsuari'    => new sfWidgetFormJQueryAutocompleter(array('config'=>'{ max:20 , width:500 }' , 'url'=>$this->getOption('url'))),
//      'idDirectori' => new sfWidgetFormSelect(array('choices'=>AppDocumentsDirectorisPeer::getSelectDirectoris())),
      'idNivell'    => new sfWidgetFormSelect(array('choices'=>NivellsPeer::getSelectPermisos())),
    ));

    $this->setValidators(array(
      'idUsuari'    => new sfValidatorPropelChoice(array('model' => 'Usuaris', 'column' => 'UsuariID', 'required' => false)),
      'idDirectori' => new sfValidatorPropelChoice(array('model' => 'AppDocumentsDirectoris', 'column' => 'idDirectori', 'required' => false)),
      'idNivell'    => new sfValidatorPropelChoice(array('model' => 'Nivells', 'column' => 'idNivells', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('app_documents_permisos_dir[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
   
  }

  public function getModelName()
  {
    return 'AppDocumentsPermisosDir';
  }

	
}
