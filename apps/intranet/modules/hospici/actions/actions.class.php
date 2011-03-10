<?php

/**
 * hospici actions.
 *
 * @package    intranet
 * @subpackage hospici
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class hospiciActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->setLayout('hospici');
    $this->CERCA = array( 'POBLE' => array( 0=> -1 ) , 'CATEGORIA' => -1 , 'DATA' => -1 , 'DATA_R' => array('DI'=>time(),'DF'=>time()), 'P' => 1  );                
    $RS = $this->getUser()->ParReqSesForm($request,'cerca',$this->CERCA);    
    $this->CERCA = $RS;
    $this->LLISTAT_ACTIVITATS = ActivitatsPeer::getActivitatsHospici($this->CERCA['POBLE'][0],$this->CERCA['CATEGORIA'][0],$this->CERCA['DATA'],$this->CERCA['DATA_R'],$this->CERCA['P']);
    $this->MODE = 'INICIAL';
    
    if($request->getMethod() == 'POST' && !empty($RS)) { $this->MODE = 'CERCA'; }    
    
    if($request->getMethod() == 'GET' && $request->hasParameter('idA')):
        
        $this->ACTIVITAT = ActivitatsPeer::retrieveByPK($request->getParameter('idA'));
        $this->MODE = 'DETALL';
    endif;
    
  }
    
  public function executeEntitats(sfWebRequest $request)
  {
    
  }
    
  public function executeCursos(sfWebRequest $request)
  {
    
  }
  
  public function executeCalendari(sfWebRequest $request)
  {
    
  }
  
  public function executeHospici(sfWebRequest $request)
  {
    
  }
  
  
    
  public function executeAjaxON(sfWebRequest $request)
  {
 	$C = new Criteria();
    $idP = $request->getParameter('ON');    
    $sel = $request->getParameter('SEL');
    $R = ActivitatsPeer::selectCategoriesActivitats($idP[0]);
    $RET = "";
    foreach($R as $K=>$E){
        $SELECTED = ($sel == $K)?"SELECTED":"";        
        $RET .= '<option '.$SELECTED.' value="'.$K.'">'.$E.'</option>';        
    }        
    return $this->renderText($RET);
  }
  
}
