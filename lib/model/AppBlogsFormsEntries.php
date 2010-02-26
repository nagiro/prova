<?php

class AppBlogsFormsEntries extends BaseAppBlogsFormsEntries
{
	public function getArrayElements()
	{
		$SOL = array();
		$ARR = explode("@@@",$this->getDades());
		$i = 1;
		foreach($ARR as $V):
			$ARR2 = explode('###',$V);
			if(!empty($ARR2[0])):
				if($ARR2[0] == 'file'):
					$SOL[$ARR2[0].$i++] = $ARR2[1];
				else: 
					$SOL[$ARR2[0]] = $ARR2[1];
				endif; 				
			endif; 
		endforeach;
		
		return $SOL;
		
	}
}
