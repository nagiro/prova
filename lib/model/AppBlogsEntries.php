<?php

class AppBlogsEntries extends BaseAppBlogsEntries
{
	public function getImages()
	{
		$C = new Criteria();
		$C->addJoin(AppBlogsEntriesPeer::ID, AppBlogMultimediaEntriesPeer::ENTRIES_ID);
		$C->addJoin(AppBlogsMultimediaPeer::ID, AppBlogMultimediaEntriesPeer::MULTIMEDIA_ID);
		$C->add(AppBlogsEntriesPeer::ID, $this->getId());
		$RS = AppBlogsMultimediaPeer::doSelect($C);
		if(empty($RS)) return false; 
		else return $RS;		
	}
}
