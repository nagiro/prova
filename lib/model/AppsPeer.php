<?php

class AppsPeer extends BaseAppsPeer
{
	static public function select()
	{
		$C = new Criteria();
		$RET = array();
		
		foreach(self::doSelect($C) as $APP):
			$RET[$APP->getAppId()] = $APP->getNom();  									
		endforeach;
		
		return $RET;
	}
	
	static public function getNom($IDAPP)
	{
		$OAPP = self::retrieveByPK($IDAPP);		
		if( $OAPP instanceof Apps ):
			return $OAPP->getNom();
		else:
			return 'n/d';
		endif; 
	}
}
