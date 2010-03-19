<?php

class CessioPeer extends BaseCessioPeer
{
	
   static public function getCessions($PAGINA,$cedit,$text)
   {
    $C = new Criteria();
    $C->add(CessioPeer::RETORNAT,!$cedit);
    $C->addDescendingOrderByColumn(CessioPeer::RETORNAT);
    $C->addDescendingOrderByColumn(CessioPeer::DATA_RETORN);
          
    $pager = new sfPropelPager('Cessio', 10);
	$pager->setCriteria($C);
	$pager->setPage($PAGINA);
	$pager->init();  	
  	return $pager;
   }
   
   static public function printDocument($OCESSIO)
   {
  
   	  $OU = $OCESSIO->getUsuaris();
   	  $OCM = $OCESSIO->getCessiomaterials();   	  

   	  $MAT = "";
	  foreach($OCM as $OCMAT):
	  	$OMAT = $OCMAT->getMaterial();	  	
	  	$MAT .= ' un/a '.$OMAT->getNom().' amb identificador '.$OMAT->getIdentificador().',';	  		  		  
	  endforeach;
   	  
	  // create the document
	  $doc = new sfTinyDoc();
	  $doc->createFrom(array('extension' => 'docx'));
	  $doc->loadXml('word/document.xml');

	  $doc->mergeXmlField('NOM',$OU->getNomComplet());
	  $doc->mergeXmlField('DNI',$OU->getDni());
	  $doc->mergeXmlField('REPRESENTANT',$OCESSIO->getRepresentant());	  
	  $doc->mergeXmlField('MATERIAL',$MAT);	  
	  if($OCESSIO->getMaterialNoInventariat() != '') 
	  	$doc->mergeXmlField('MATERIAL_NO_INVENTARIAT',' i '.$OCESSIO->getMaterialNoInventariat());	  	  
	  $doc->mergeXmlField('MOTIU',$OCESSIO->getMotiu());	  	  
	  $doc->mergeXmlField('CONDICIONS1',$OCESSIO->getCondicions());
	  $doc->mergeXmlField('DATA_SORTIDA',$OCESSIO->getDataCessio());
	  $doc->mergeXmlField('DATA_RETORN',$OCESSIO->getDataRetorn());
	  	  	  
	  $doc->saveXml();
	  $doc->close();
	 
	  // send and remove the document
	  $doc->sendResponse();
	  $doc->remove();
	 
	  throw new sfStopException;
   	
   }
   
}
