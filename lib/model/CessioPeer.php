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
   
   static public function printDocument()
   {
	  // create the document
	  $doc = new sfTinyDoc();
	  $doc->createFrom(array('extension' => 'docx'));
	  $doc->loadXml('word/document.xml');
	  $doc->mergeXmlField('field1', 'variable');
	  $doc->mergeXmlField('field2', array('id' => 55, 'name' => 'bob'));
	  $doc->mergeXmlField('field3', $doc);
	  $doc->mergeXmlBlock('block1',
	    array(
	      array('firstname' => 'John'   , 'lastname' => 'Doe'),
	      array('firstname' => 'Douglas', 'lastname' => 'Adams'),
	      array('firstname' => 'Roger'  , 'lastname' => 'Waters'),
	    )
	  );
	  $doc->saveXml();
	  $doc->close();
	 
	  // send and remove the document
	  $doc->sendResponse();
	  $doc->remove();
	 
	  throw new sfStopException;
	   		   	
   }
   
}
