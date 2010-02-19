<?php

class AppBlogsMultimediaPeer extends BaseAppBlogsMultimediaPeer
{
	static public function deleteMultimeda($idM)
	{
		$C = new Criteria();
		$C->add(self::ID,$idM);
		self::doSelectOne($C)->delete();
	}
}
