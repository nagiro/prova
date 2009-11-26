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
  	
    $IDU = $this->getUser()->getAttribute( 'IDU' );
  	$IDD = $this->ParReqSesForm( $request , 'IDD' , 1 );  	
  	$this->ACTUAL = AppDocumentsDirectorisPeer::retrieveByPK($IDD);
  	if(!($this->ACTUAL instanceof AppDocumentsDirectoris)):
  		$this->ACTUAL = AppDocumentsDirectorisPeer::retrieveByPK(1);
  		$this->getUser()->setAttribute('IDD',1);
  	endif;   	  		

  	if($this->getUser()->hasCredential('admin')):
  		$this->ADMIN = true;
  		print_r(AppDocumentsDirectorisPeer::getSelectDirectoris());
  	endif;  
  	
  	$this->DIRECTORIS = AppDocumentsDirectorisPeer::getDirectoris($this->IDU);  	  
  	$this->setLayout('gestio');
  	
  }
  
  
  //Guardem els valors de l'array amb Default[$K]=>$V --> $NOM.$K
  //Exemple: $this->ParReqSesForm($request,'cerca',"",array('text'=>""));
  public function ParReqSesForm(sfWebRequest $request, $nomCamp, $default = "") 
  {
  	  	
  	$RET = ""; 	    	
  	
  	if(is_array($default)):
  	
	  	//Si existeix el paràmetre carreguem el nom actual
	  	if($request->hasParameter($nomCamp)):
	  	
	  		$CAMP = $request->getParameter($nomCamp);
	  		
	  		//Mirem els elements del formulari i els guardem a la sessió  		  		
	  		foreach( $CAMP as $NOM => $VALOR ):
	  			$this->getUser()->setAttribute($nomCamp.$NOM,$VALOR);  				
	  		endforeach;  				  		  		 
	  		
	  		$RET = $CAMP;  		
	  
	  	//Si no existeix el paràmetre mirem si ja el tenim a la sessió
	  	elseif($this->existeixAtributArray($nomCamp,$default)):
	  		$RET = array();
	  		foreach($default as $NOM => $VALOR):
	  			$RET[$NOM] = $this->getUser()->getAttribute($nomCamp.$NOM);
	  		endforeach;
	  		
	  	//Si no el tenim a la sessió i tampoc l'hem passat per paràmetre carreguem el valor per defecte. 
	  	else: 
	  	
	  		foreach($default as $NOM => $VALOR):
	  			$this->getUser()->setAttribute($NOM.$nomCamp, $default);
	  		endforeach;
	  		
	  		$RET = $default;
	  		
	  	endif;
	  	
	else:
		
		//Si existeix el paràmetre carreguem el nom actual
	  	if($request->hasParameter($nomCamp)):
	  	
	  		$CAMP = $request->getParameter($nomCamp);	  		
	  		$this->getUser()->setAttribute($nomCamp,$CAMP);  					  		  				  		  		 	  		
	  		$RET = $CAMP;  		
	  
	  	//Si no existeix el paràmetre mirem si ja el tenim a la sessió
	  	elseif($this->getUser()->hasAttribute($nomCamp)):
	  		
	  		$RET = $this->getUser()->getAttribute($nomCamp);
	  			  		
	  	//Si no el tenim a la sessió i tampoc l'hem passat per paràmetre carreguem el valor per defecte. 
	  	else:
	  	 	  		  		
	  		$this->getUser()->setAttribute($nomCamp, $default);	  			  	
	  		$RET = $default;
	  		
	  	endif;
	
	endif;
  	
  	return $RET;
  }
  
  public function ParSesForm($valor, $nomCamp, $default = "") 
  {

  	$RET = ""; 	    	
  	   	
  	if($this->getUser()->hasAttribute($nomCamp)):
  		$RET = $this->getUser()->getAttribute($nomCamp); 
  	else:   	
  		$this->getUser()->setAttribute($nomCamp, $default);
  		$RET = $default;
  	endif;
  	
  	return $RET;
  }
  
  
  
}
