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
		
	
	static public function getRecursiveDirs($DIRECTORIS, $DIR_PARE, $NOM_PARE)
	{		
		$RET = array($DIR_PARE=>$NOM_PARE);

		if(isset($DIRECTORIS[$DIR_PARE])):
			foreach($DIRECTORIS[$DIR_PARE] as $DIR_FILL => $NOM_FILL):
				$NOM = $NOM_PARE.'/'.$NOM_FILL;							
				$RET = $RET + self::getRecursiveDirs($DIRECTORIS, $DIR_FILL, $NOM); 							
			endforeach;
		endif; 
											
		return $RET;		
	} 
	
	
	static public function save($nomDir, $pare, $IDDF = 0)
	{

		//Comprovem que el pare ja no tingui un directori que es digui igual
				
		if($IDDF <> 0):
			$ODir = AppDocumentsDirectorisPeer::retrieveByPK($IDDF);			
		else:
			$ODir = new AppDocumentsDirectoris();
			if(self::existDir($nomDir,$pare)) return null;			
		endif; 
		
		$ODir->setNom($nomDir);
		$ODir->setPare($pare);
		$ODir->save();
		
	}
	
	static public function existDir($nomDir,$pare)
	{
		$C = new Criteria();
		$C->add(self::NOM,$nomDir);
		$C->add(self::PARE,$pare);
		return (self::doCount($C) > 0);		
	}
	
}
