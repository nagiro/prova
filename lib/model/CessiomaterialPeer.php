<?php

/**
 * Subclass for performing query and update operations on the 'cessiomaterial' table.
 *
 * 
 *
 * @package lib.model
 */ 
class CessiomaterialPeer extends BaseCessiomaterialPeer
{
   static public function getCessions($PAGINA)
   {
    $C = new Criteria();
    $C->addDescendingOrderByColumn(CessiomaterialPeer::RETORNAT);
    $C->addDescendingOrderByColumn(CessiomaterialPeer::DATARETORN);
          
    $pager = new sfPropelPager('Cessiomaterial', 10);
	$pager->setCriteria($C);
	$pager->setPage($PAGINA);
	$pager->init();  	
  	return $pager;
   } 
}
