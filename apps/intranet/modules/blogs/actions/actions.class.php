<?php

/**
 * blogs actions.
 *
 * @package    intranet
 * @subpackage blogs
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class blogsActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeNoticiesculturals(sfWebRequest $request)
  {
  	
  	$this->PAGE_ID_QUE_ESTA_PASSANT = 1;
  	$this->PAGE_ID_QUE_PASSARA = 2;
  	$this->PAGE_ID_QUE_HA_PASSAT = 3;
  	$this->FORM_ID = 2;   	
  	
  	$this->setLayout('blank');
  	$this->PAGE_ID = $this->ParReqSesForm($request,'PAGE_ID',$this->PAGE_ID_QUE_ESTA_PASSANT);
  	$this->NOTICIA_ID = $this->ParReqSesForm($request,'NOTICIA_ID',-1);
  	$this->PAGINA = $this->ParReqSesForm($request,'PAGINA',1);
  	
  	if($request->hasParameter('NOTICIA_ID')):
  		$this->NOTICIA = AppBlogsEntriesPeer::retrieveByPK($request->getParameter('NOTICIA_ID')); 
	else:  	
  		$this->NOTICIES = AppBlogsEntriesPeer::getEntries($this->PAGE_ID,$this->PAGINA); 
  	endif; 
  	
  	
  	if($request->hasParameter('dades')):

  		AppBlogsFormsPeer::save($this->FORM_ID,$request->getParameter('dades'),$request->getFiles());
  	
  	endif; 

  	
  }
  
  public function executeBiennal(sfWebRequest $request)
  {
  	
  	$this->setLayout('blank');
  	$this->DADES = array('nom'=>'','cognoms'=>'','domicili'=>'','numero'=>'','codi_postal'=>'','localitat'=>'','telefon'=>'','qreu'=>'');
  	$this->ENVIAT = false;
  	$this->FORM_ID = 1;  //Aquest formulari és el número 1 quan es va entrar :D
  	
  	if(!$request->hasParameter('ESTAT')) $this->ESTAT = 'INICI';  	
  	else $this->ESTAT = $request->getParameter('ESTAT');
  	  	  	   
  	 
  	if($request->hasParameter('dades')):
    	
  		$this->DADES = $request->getParameter('dades');  		  		  		
  		if($this->DADES['resultat'] == ($this->getUser()->getAttribute('VAL1')+$this->getUser()->getAttribute('VAL2'))):
  			$correcte = AppBlogsFormsPeer::save($this->FORM_ID,$request->getParameter('dades'),$request->getFiles());
	  		if($correcte): 
	  			$this->MISSATGE = array('TEXT' => "Formulari enviat correctament",'OK'=>true);
	  			$this->ENVIAT = true;
	  		else: 
	  			$this->MISSATGE = array('TEXT'=>"Hi ha hagut algun problema guardant...",'OK'=>false);
	  		endif;
  		else: 
	  		$this->MISSATGE = array('TEXT'=>"La suma no és correcta",'OK'=>false);
	  	endif;   		
  	endif;
  	
  	$this->getUser()->setAttribute('VAL1',rand(0,9));
  	$this->getUser()->setAttribute('VAL2',rand(0,9));
  	$this->VAL1 = $this->getUser()->getAttribute('VAL1');
  	$this->VAL2 = $this->getUser()->getAttribute('VAL2');
  	
  }
  
  public function executeRSS(sfWebRequest $request)
  {
  	
	$PAGE_ID = AppBlogsPagesPeer::retrieveByPK($request->getParameter('PAGE_ID'));
	$URL = sfConfig::get('sf_webrooturl').'blogs/'.$request->getParameter('URL');
	if($PAGE_ID instanceof AppBlogsPages && !empty($URL)):

		$feed = new sfAtom1Feed();
		$feed->setTitle($PAGE_ID->getName());
		$feed->setLink($URL);
		$feed->setAuthorEmail('informatica@casadecultura.org');
		$feed->setAuthorName('Casa de Cultura de Girona');
		
//		$feedImage = new sfFeedImage();
//		$feedImage->setFavicon('http://www.myblog.com/favicon.ico');
//		$feed->setImage($feedImage);
		
		$c = new Criteria;
		$c->addDescendingOrderByColumn(AppBlogsEntriesPeer::DATE);
		$c->add(AppBlogsEntriesPeer::PAGE_ID, $PAGE_ID->getId());
		$c->setLimit(5);
		$posts = AppBlogsEntriesPeer::doSelect($c);
		
		foreach ($posts as $post)
		{
		
		  $data = mktime(	$post->getDate('H'),
		  					$post->getDate('i'),
		  					$post->getDate('s'),
		  					$post->getDate('m'),
		  					$post->getDate('d'),
		  					$post->getDate('Y'));
		  					
		  $R = $post->getImages();
		  if($R) $text = '<img src="'.sfConfig::get('sf_webrooturl').'images/blogs/'.$R[0]->getUrl().'" align="LEFT">';
		  else $text = "";
			
		  $item = new sfFeedItem();
		  $item->setTitle($post->getTitle());		  
		  $item->setLink($URL.'?NOTICIA_ID='.$post->getId());
		  $item->setAuthorName('Casa de Cultura de Girona');
		  $item->setAuthorEmail('giroscopi@casadecultura.org');
		  $item->setPubdate($data);
		  $item->setUniqueId($post->getId());
		  $text .= '('.$post->getSubtitle1().') - ';
		  $text .= '('.$post->getSubtitle2().') || ';
		  $text .= $post->getBody();
		  		  
		  $item->setDescription($text);
		  		  
		  $feed->addItem($item);
		  
		 }
		
		$this->feed = $feed;  	
		
	endif; 
  }
  
  
  
  
  
  //Guardem els valors de l'array amb Default[$K]=>$V --> $NOM.$K
  //Exemple: $this->ParReqSesForm($request,'cerca',array('text'=>""));
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
  
  
  
}
