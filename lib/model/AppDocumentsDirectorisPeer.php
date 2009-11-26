<?php

class AppDocumentsDirectorisPeer extends BaseAppDocumentsDirectorisPeer
{
	static public function getDirectoris($IDU = null)
	{
		$RET = array();
		$C = new Criteria();
		if(!is_null($IDU)):
			$C->add(AppDocumentsPermisosDirPeer::IDUSUARI, $IDU);
			$C->addJoin(AppDocumentsPermisosDirPeer::IDDIRECTORI,self::IDDIRECTORI);
		endif; 
		
		foreach(self::doSelect($C) as $DIR):
			$RET[$DIR->getPare()][$DIR->getIddirectori()] = $DIR->getNom() ;			
		endforeach;
						
		return $RET;
	}
	
	
	static public function getSelectDirectoris()
	{
	
		$RET = array();

		$DIRS = self::getDirectoris(null);
		
		return self::getRecursiveDirs($DIRS, 1, 'BASE');
				
	}
	
	
	static public function getRecursiveDirs($DIRECTORIS, $DIR_ACT, $NOM_ACT)
	{		
		
		$RET = array(); $ARRAY = array();		
		if(isset($DIRECTORIS[$DIR_ACT])):
			foreach($DIRECTORIS[$DIR_ACT] as $ID => $TEXT):
				$NOM = $NOM_ACT.'/'.$TEXT;			
				$ARRAY = self::getRecursiveDirs($DIRECTORIS, $ID, $NOM);
				$RET = array_merge($ARRAY);						 
			endforeach;
			return array_merge(array($DIR_ACT=>$NOM_ACT),$ARRAY);
		else:			
			return array($DIR_ACT=>$NOM_ACT);					
		endif; 
		
	} 

	
	
}
