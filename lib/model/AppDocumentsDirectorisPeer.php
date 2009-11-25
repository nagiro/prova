<?php

class AppDocumentsDirectorisPeer extends BaseAppDocumentsDirectorisPeer
{
	static public function getDirectoris($IDU)
	{
		$RET = array();
		$C = new Criteria();
//		$C->add(AppDocumentsPermisosDirPeer::IDUSUARI, $IDU);
//		$C->addJoin(AppDocumentsPermisosDirPeer::IDDIRECTORI,self::IDDIRECTORI);
		
		foreach(self::doSelect($C) as $DIR):
			$RET[$DIR->getPare()][]['ID'] = $DIR->getIddirectori();
			$RET[$DIR->getPare()][]['NOM'] = $DIR->getIddirectori();			
		endforeach;
						
		return $RET;
	}
}
