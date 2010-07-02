<?php

class AppBlogsFormsEntriesPeer extends BaseAppBlogsFormsEntriesPeer
{
	const ESTAT_CAP = 0;	
	const ESTAT_TRACTAT_MIGRAT = 1;
	const ESTAT_TRACTAT_MIGRAT_WAIT = 10;
	const ESTAT_TRACTAT_EMMAGATZEMAT = 2;
	const ESTAT_TRACTAT_EMMAGATZEMAT_WAIT = 20;
	const ESTAT_ELIMINAT = 30;
	
	static public function selectEstats()
	{
		return array(	self::ESTAT_CAP=>'Res',
						self::ESTAT_TRACTAT_MIGRAT_WAIT => 'Per publicar',						
						self::ESTAT_TRACTAT_EMMAGATZEMAT_WAIT => 'Per arxivar',
						self::ESTAT_TRACTAT_MIGRAT => 'Publicat',						
						self::ESTAT_TRACTAT_EMMAGATZEMAT => 'Arxivat',
						self::ESTAT_ELIMINAT => 'Eliminat'
					);
	}

	static public function getFields($idF)
	{
		$RET = array();
		$C = new Criteria();
		$FORM = AppBlogsFormsPeer::retrieveByPK($idF);
		foreach(explode('@@@',$FORM->getViewfields()) as $E) $RET[$E] = $E;
			
		return $RET;
		
	}
	
	static public function getEntries($idF,$datai = null)
	{
				
		$RET = array();
		$C = new Criteria();
		$C->add(self::FORM_ID,$idF);
		$C->add(self::ESTAT,self::ESTAT_ELIMINAT, CRITERIA::NOT_EQUAL);
		if(!is_null($datai)): $C->add(self::DATE, $datai , CRITERIA::GREATER_THAN); endif; 
		$C->addDescendingOrderByColumn(self::DATE);
					
		return self::doSelect($C);
		
	}
	
}
