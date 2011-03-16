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
    $this->accio = $request->getParameter('accio','index');        
    
    //Carrego la cerca
    $this->CERCA = $this->getUser()->getSessionPar('cerca');    

    switch($this->accio){        
        case 'cerca_activitat':
        
                //Agafo el paràmetre
                $C = $request->getParameter('cerca',array());
                                
                //Normalitzo tots els camps                    
                $C2 = $this->getCercaComplet($C);        
                                                        
                //Guardem a sessió la cerca "actual"        
                $this->CERCA = $C2;
                $this->getUser()->setSessionPar('cerca',$this->CERCA);                                                                                                                                                    
                                                
                $this->LLISTAT_ACTIVITATS = ActivitatsPeer::getActivitatsHospici($this->CERCA['TEXT'],$this->CERCA['SITE'],$this->CERCA['POBLE'][0],$this->CERCA['CATEGORIA'][0],$this->CERCA['DATA'][0],$this->CERCA['DATAR'],$this->CERCA['P']);
                $this->MODE = 'CERCA';
            break;
    
        case 'detall_activitat':
                $this->ACTIVITAT = ActivitatsPeer::retrieveByPK($request->getParameter('idA'));
                $this->MODE = 'DETALL';
            break;
        
        //Arribem per primer cop al web o no entrem per cap url interessant
        default:
                                
            //Inicialitzem la cerca i la guardem a memòria
            $this->CERCA = $this->getCercaComplet(null);
            $this->getUser()->setSessionPar('cerca',$this->CERCA);
            $this->MODE = 'INICIAL';
    }                                        
    
  }
   
  private function getCercaComplet($C)
  {    
    if(!isset($C['TEXT']))              $C['TEXT'] = "";
    if(!isset($C['SITE']))              $C['SITE'] = array(0=>0);
    if(!isset($C['POBLE']))             $C['POBLE'] = array(0=>0);
    if(!isset($C['CATEGORIA']))         $C['CATEGORIA'] = array(0=>0);
    if(!isset($C['DATA']))              $C['DATA'] = array(0=>0);
    if(!isset($C['DATAR']))             $C['DATAR'] = array('DI'=>time(), 'DF'=>time());
    if(!isset($C['P']))                 $C['P'] = 1;
    return $C;
  }
   
   
  public function executeEntitats(sfWebRequest $request)
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
    $text = $request->getParameter('TEXT');
    $idP = $request->getParameter('ON');    
    $sel = $request->getParameter('SEL');
    $R = ActivitatsPeer::selectCategoriesActivitats($idP[0],$text);
    $RET = "";
    foreach($R as $K=>$E){
        $SELECTED = ($sel == $K)?"SELECTED":"";        
        $RET .= '<option '.$SELECTED.' value="'.$K.'">'.$E.'</option>';        
    }        
    return $this->renderText($RET);
  }

  public function executeAjaxCAT(sfWebRequest $request)
  {
 	$C = new Criteria();
    $idP = $request->getParameter('ON');
    $idC = $request->getParameter('CAT');    
    $sel = $request->getParameter('SEL');
    $text = $request->getParameter('TEXT');
    $R = ActivitatsPeer::selectDatesActivitats($idP[0],$idC[0],$text,null);
    $RET = "";
    foreach($R as $K=>$E){
        $SELECTED = ($sel == $K)?"SELECTED":"";        
        $RET .= '<option '.$SELECTED.' value="'.$K.'">'.$E.'</option>';        
    }        
    return $this->renderText($RET);
  }

  public function executeAjaxDATENT(sfWebRequest $request)
  {
 	$C = new Criteria();
    $idE = $request->getParameter('ENT');        
    $sel = $request->getParameter('SEL');
    $text = $request->getParameter('TEXT');
    $R = ActivitatsPeer::selectDatesActivitats(null,null,$text,$idE[0]);
    $RET = "";
    foreach($R as $K=>$E){
        $SELECTED = ($sel == $K)?"SELECTED":"";        
        $RET .= '<option '.$SELECTED.' value="'.$K.'">'.$E.'</option>';        
    }        
    return $this->renderText($RET);
  }  
  

  /**
   * hospiciActions::executeCursos()
   * 
   * Part de mostra de cursos a l'hospici
   * 
   * @param mixed $request
   * @return void
   */
  public function executeCursos(sfWebRequest $request)
  {    
    $this->setLayout('hospici');
    $this->setTemplate('indexCursos');
    $this->accio = $request->getParameter('accio','index');        
    
    //Carrego la cerca
    $this->CERCA = $this->getUser()->getSessionPar('cerca');    

    switch($this->accio){        
        case 'cerca_cursos':
               
                //Agafo el paràmetre
                $C = $request->getParameter('cerca',array());
                                
                //Normalitzo tots els camps                    
                $C2 = $this->getCercaComplet($C);        
                                                        
                //Guardem a sessió la cerca "actual"        
                $this->CERCA = $C2;
                $this->getUser()->setSessionPar('cerca',$this->CERCA);                                                                                                                                                    
                                                
                $this->LLISTAT_ACTIVITATS = ActivitatsPeer::getActivitatsHospici($this->CERCA['TEXT'],$this->CERCA['SITE'],$this->CERCA['POBLE'][0],$this->CERCA['CATEGORIA'][0],$this->CERCA['DATA'][0],$this->CERCA['DATAR'],$this->CERCA['P']);
                $this->MODE = 'CERCA';
                
            break;
    
        case 'detall_activitat':
        
                $this->ACTIVITAT = ActivitatsPeer::retrieveByPK($request->getParameter('idA'));
                $this->MODE = 'DETALL';
                
            break;
        
        //Arribem per primer cop al web o no entrem per cap url interessant
        case 'inici':            
            //Inicialitzem la cerca i la guardem a memòria
            $this->CERCA = $this->getCercaComplet(null);
            $this->getUser()->setSessionPar('cerca',$this->CERCA);
            $this->MODE = 'INICIAL';
    }                                        
    
  }
  
  

}
