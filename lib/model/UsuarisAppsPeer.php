<?php

class UsuarisAppsPeer extends BaseUsuarisAppsPeer
{
	
	
	
	//Retorna una llista amb les aplicacions on hi té permís. 
	static public function getPermisos($IDU)
	{
		
		$RET = array();
		$C = new Criteria();
		$C->add(self::USUARI_ID, $IDU);

		foreach(self::doSelect($C) as $APP):			
			$RET[$APP->getAppId()] = $APP->getNivellId();					
		endforeach;		
		
		return $RET; 
				
	}
	
	static public function getPermisosOO($IDU)
	{				
		$C = new Criteria();
		$C->add(self::USUARI_ID, $IDU);
		$C->addJoin(self::APP_ID, AppsPeer::APP_ID);
		
		return AppsPeer::doSelect($C);						 				
	}
	
	
	static public function save($PERMISOS,$IDU)
	{
		
		foreach($PERMISOS as $IDAPP => $PERM):
			$OAPP = self::retrieveByPK($IDU,$IDAPP);
			if( $OAPP instanceof UsuarisApps ):
				$OAPP->setNivellId($PERM);
			else: 
				$OAPP = new UsuarisApps();
				$OAPP->setAppId($IDAPP);
				$OAPP->setUsuariId($IDU);
				$OAPP->setNivellId($PERM);				
			endif; 
			
			$OAPP->save();
			
		endforeach;
	}
	
	//Retorna la select amb les usuaris que poden entrar a l'aplicació
	static public function getSelectUsuarisPermis($APPID)
	{
		
		$RET = array();
		
		$C = new Criteria();		
		$C->addJoin(UsuarisPeer::USUARIID,self::USUARI_ID);
						
		foreach(UsuarisPeer::doSelect($C) as $U):
			$RET[$U->getUsuariid()] = $U->getDni().' - '.$U->getNomComplet();  			  		
  		endforeach;
		
  		return $RET;
		
	}
	
}
