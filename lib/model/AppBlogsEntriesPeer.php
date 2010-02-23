<?php

class AppBlogsEntriesPeer extends BaseAppBlogsEntriesPeer
{
	
	static public function initialize($entry_id,$lang = 'CA',$page_id)
	{
		
		$OO = self::retrieveByPK($entry_id);
		
		if($OO instanceof AppBlogsEntries):
			$OO->setDate(date('Y-m-d H:i:s',time()));			
			return new AppBlogsEntriesForm($OO);			
		else:
			$OO = new AppBlogsEntries();
			$OO->setTitle('Títol per defecte');
			$OO->setBody("Cos per defecte");
			$OO->setLang($lang);
			$OO->setPageId($page_id);
			$OO->setDate(date('Y-m-d H:i:s',time()));			
			return new AppBlogsEntriesForm($OO);			
		endif; 
		
	}
	
	static public function cerca($page_id)
	{
		$C = new Criteria();
		$C->add(self::PAGE_ID, $page_id);
		$C->add(self::LANG, 'CA');
		
		return $C;
	}
	
	static public function getOptionsEntries($page_id)
	{
		
		$C = self::cerca($page_id);
		$Q = self::doSelect($C);		
		$RET = '<option value="-1">('.sizeof($Q).') Escull una entrada...</option>';
		
		foreach(self::doSelect($C) as $OO):
			$RET .= '<option value="'.$OO->getId().'">'.$OO->getDate('d/m/Y').' - '.$OO->getTitle().'</option>';			
		endforeach;
		
		return $RET;		
		
	}
	
	static public function getFiles($entry_id)
	{
		$C = new Criteria();
		$C->addJoin(self::ID,AppBlogMultimediaEntriesPeer::ENTRIES_ID);
		$C->addJoin(AppBlogMultimediaEntriesPeer::MULTIMEDIA_ID,AppBlogsMultimediaPeer::ID);
		$C->add(self::ID, $entry_id);
		
		return AppBlogsMultimediaPeer::doSelect($C);
	}
	
	static public function getEntries($page_id = null,$PAGINA = 1)
	{
		$C = new Criteria();		
		if(!is_null($page_id)) $C->add(self::PAGE_ID,$page_id);
		
		$pager = new sfPropelPager('AppBlogsEntries', 3);
	 	$pager->setCriteria($C);
	 	$pager->setPage($PAGINA);
	 	$pager->init();
	 	return $pager;
		
	}
	
}