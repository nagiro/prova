<?php

class AppBlogsFormsEntriesPeer extends BaseAppBlogsFormsEntriesPeer
{
	const ESTAT_CAP = 0;	
	const ESTAT_TRACTAT_MIGRAT = 1;
	const ESTAT_TRACTAT_MIGRAT_WAIT = 10;
	const ESTAT_TRACTAT_EMMAGATZEMAT = 2;
	const ESTAT_TRACTAT_EMMAGATZEMAT_WAIT = 20;
	
	static public function selectEstats()
	{
		return array(	self::ESTAT_CAP=>'Res',
						self::ESTAT_TRACTAT_MIGRAT_WAIT => 'Per publicar',						
						self::ESTAT_TRACTAT_EMMAGATZEMAT_WAIT => 'Per arxivar',
						self::ESTAT_TRACTAT_MIGRAT => 'Publicat',						
						self::ESTAT_TRACTAT_EMMAGATZEMAT => 'Arxivat'
					);
	}
	
}
