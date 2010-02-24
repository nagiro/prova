<?php

class AppBlogsFormsEntries extends BaseAppBlogsFormsEntries
{
	public function getArrayElements()
	{
		$SOL = array();
		$ARR = explode("@@@",$this->getDades());
		foreach($ARR as $V):
			$ARR2 = explode('###',$V);
			if(!empty($ARR2[0])) $SOL[$ARR2[0]] = $ARR2[1];
		endforeach;
		
		return $SOL;
		
	}
}
