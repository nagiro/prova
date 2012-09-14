<?php

/**
 * Matricules form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Albert Johé i Martí
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class MatriculesForm extends sfFormPropel
{
  public function setup()
  {  	
  	    
    $IDU = $this->getObject()->getUsuarisUsuariid();
                
  	$this->setWidgets(array(
      'idMatricules'     => new sfWidgetFormInputHidden(),
  	  'Usuaris_UsuariID' => new sfWidgetFormInputHidden(),  	  
  	  'Cursos_idCursos'  => new sfWidgetFormChoice(array('choices'=>CursosPeer::getSelectCursosMatriculaInterna($this->getOption('IDS')))),
      'Estat'            => new sfWidgetFormChoice(array('choices'=>MatriculesPeer::getEstatsSelect())),
      'DataInscripcio'   => new sfWidgetFormDateTime(array('date'=>array('format'=>'%day%/%month%/%year%'))),
      'data_baixa'       => new sfWidgetFormDate(array('format'=>'%day%/%month%/%year%')),
      'Pagat'        	 => new sfWidgetFormInputText(),
      'tReduccio'        => new sfWidgetFormChoice( array('choices'=>DescomptesPeer::getDescomptesArray($this->getOption('IDS'),false))),
      'tPagament'        => new sfWidgetFormChoice( array('choices'=>TipusPeer::getTipusPagamentArray())),
      'idDadesBancaries' => new sfWidgetFormChoice( array( 'choices'=> DadesBancariesPeer::getSelectBySelect( DadesBancariesPeer::getDadesUsuari($IDU) , false , true ) ) ),
  	  'Comentari'        => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(      
      'idMatricules'     => new sfValidatorPropelChoice(array('model' => 'Matricules', 'column' => 'idMatricules', 'required' => false)),
      'Usuaris_UsuariID' => new sfValidatorPropelChoice(array('model' => 'Usuaris', 'column' => 'UsuariID')),
      'Cursos_idCursos'  => new sfValidatorPropelChoice(array('model' => 'Cursos', 'column' => 'idCursos')),
      'Estat'            => new sfValidatorInteger(array('required' => false)),
      'Comentari'        => new sfValidatorString(array('required' => false)),
      'DataInscripcio'   => new sfValidatorDateTime(array('required' => false)),
      'data_baixa'       => new sfValidatorDateTime(array('required' => false)),
      'Pagat'            => new sfValidatorNumber(array('required' => false)),
      'tReduccio'        => new sfValidatorInteger(),
      'tPagament'        => new sfValidatorInteger(),
      'idDadesBancaries' => new sfValidatorInteger(),    
    ));
    
    $this->widgetSchema->setLabels(array(                        
      'Cursos_idCursos'  => 'Curs: ',
      'Estat'            => 'Estat: ',
      'Comentari'        => 'Comentari: ',
      'DataInscripcio'   => 'Data d\'inscripció: ',
      'data_baixa'       => 'Data de baixa: ',
      'Descompte'        => 'Te descompte? ',
      'tReduccio'        => 'Te reducció? ',
      'tPagament'        => 'Com ha pagat? ',
      'idDadesBancaries' => 'CCC',
    ));    
    
    $this->widgetSchema->setNameFormat('matricules[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

  }

  public function save($conn = null)
  {
    
    $this->updateObject();
    $OM = $this->getObject();
    $db = $OM->getDatabaixa('Y-m-d');
        
    if(is_null($db) && $OM->getEstat() == MatriculesPeer::BAIXA) $OM->setDatabaixa(date('Y-m-d',time()));
    
    return $OM->save();
    
  }

  public function getModelName()
  {
    return 'Matricules';
  }

}
