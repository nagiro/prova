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
  	
    $IDU        = $this->getUser()->getSessionPar('idU');
  	$IDD        = $this->getUser()->ParReqSesForm($request , 'IDD' , 1 );
  	$IDA		= $this->getUser()->ParReqSesForm( $request , 'IDA' , null );  	  	  	
  	$accio      = $this->getUser()->ParReqSesForm( $request , 'accio' , 'CD' );
  	$this->MODE = "CONSULTA";
  	
  	if($request->hasParameter('B_SAVE_UPLOAD')) $accio = 'SAVE_UPLOAD';
  	
  	$this->getUser()->setSessionPar('accio',$accio);
  	
  	switch($accio){
  	
  		//Mostrem el diàleg d'upload
  		case 'UPLOAD':
  				$OA = AppDocumentsArxiusPeer::retrieveByPK($IDA);
  				if(!($OA instanceof AppDocumentsArxius)):
  					$OA = new AppDocumentsArxius();
  					$OA->setDatacreacio(date('Y-m-d',time()));
  					$OA->setIddirectori($IDD);  				  					
  				endif;  				  				  				
  				$this->FUPLOAD = new AppDocumentsArxiusForm($OA);  				
  				$this->MODE = 'UPLOAD';
  			break;
  		
  		//Guardem un arxiu que hem carregat. 
  		case 'SAVE_UPLOAD':
  				$OA = AppDocumentsArxiusPeer::retrieveByPK($IDA);
  				if(!($OA instanceof AppDocumentsArxius)):
  					$OA = new AppDocumentsArxius();  					
  				endif;   				  				  				
  				$this->FUPLOAD = new AppDocumentsArxiusForm($OA);
  				$this->FUPLOAD->bind($request->getParameter('app_documents_arxius'),$request->getFiles('app_documents_arxius'));
  				
  				if($this->FUPLOAD->isValid()): 
  					$this->FUPLOAD->save();  					  				  				
  					$this->redirect('apps/gDocuments?accio=CD');
  				endif; 
				  			
  				$this->MODE = 'UPLOAD';
  			break;
  			
  		//Esborrem un arxiu guardat prèviament 
  		case 'DELETE':
  				$OA = AppDocumentsArxiusPeer::retrieveByPK($IDA);
  				if($OA instanceof AppDocumentsArxius):
  					$OA->delete();  									
  				endif;   			
  				$this->redirect('apps/gDocuments?accio=CD'); 	  				  				  								  		  				
  			break;
  			
  		//Fem un canvi de directori o tornem a una pantalla anterior i inicialitzem
  		case 'CD':  				
  				$this->getUser()->setAttribute('IDA',null);
  			break;
  	}
  	
  	$this->ACTUAL = AppDocumentsDirectorisPeer::retrieveByPK($IDD);			  	
  	if(!($this->ACTUAL instanceof AppDocumentsDirectoris)):
  		$this->ACTUAL = AppDocumentsDirectorisPeer::retrieveByPK(1);
  		$this->getUser()->setAttribute('IDD',1);			  		
  	endif;
  	$this->DIRECTORIS = AppDocumentsDirectorisPeer::getDirectoris($IDU);
  	$this->PERMISOS_AL_DIR = AppDocumentsPermisosDirPeer::getPermis($IDU,$IDD);
  	  	  
  	$this->setLayout('gestio_apps');
  	
  }
  
}
