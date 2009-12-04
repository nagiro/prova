<?php

class AppDocumentsPermisosDirPeer extends BaseAppDocumentsPermisosDirPeer
{
	static public function getLlistatPermisos($IDD)
	{
		$RET = array();
		
		$C = new Criteria();
		$C->add(self::IDDIRECTORI,$IDD);
		
		foreach(self::doSelect($C) as $PERM_DIR):
			$RET[] = array(
							'idUsuari'  => $PERM_DIR->getIdusuari(),
							'idNivell'  => $PERM_DIR->getIdnivell(),
							'DNI' 		=> $PERM_DIR->getUsuaris()->getDni(),
							'nomUsuari' => $PERM_DIR->getUsuaris()->getNomComplet(),
							'nomNivell' => $PERM_DIR->getNivells()->getNom(), 
			
			); 						
		
		endforeach;

		return $RET;
	}
	
	static public function getPermis($IDU,$IDD)
	{
		
		$C = new Criteria();
		$C->add(self::IDUSUARI,$IDU);
		$C->add(self::IDDIRECTORI,$IDD);
		
		$PERMIS = self::doSelectOne($C);
		if($PERMIS instanceof AppDocumentsPermisosDir):
			return $PERMIS->getIdnivell();
		else: 
			return NivellsPeer::CAP; 
		endif;  
						
	}
	
	static public function save($idU,$idN,$idD)
	{
		$OD = AppDocumentsPermisosDirPeer::retrieveByPK($idU,$idD);
		if($OD instanceof AppDocumentsPermisosDir):
			$OD->setIdnivell($idN);
			$OD->save();
		else: 
			$OD = new AppDocumentsPermisosDir();
			$OD->setIddirectori($idD);
			$OD->setIdnivell($idN);
			$OD->setIdusuari($idU);
			$OD->save();
		endif;		
		
	}
		
}
