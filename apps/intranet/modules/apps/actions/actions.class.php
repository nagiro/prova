<?php

/**
 * apps actions.
 *
 * @package    intranet
 * @subpackage apps
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class appsActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('default', 'module');
  }
  
  
  public function executeGDocuments(sfWebRequest $request)
  {
    
    $IDU = $this->getUser()->getAttribute('IDU');
    $IDD = $request->getParameter('IDD');
    
  	$this->DIRECTORIS = AppDocumentsDirectorisPeer::getDirectoris($IDU);
  	$this->ARXIUS     = AppDocumentsArxiusPeer::getArxius($IDU,$IDD);
  	$this->setLayout('gestio');
  	
  }
  
}
