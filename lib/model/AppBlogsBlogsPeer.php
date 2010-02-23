<?php

class AppBlogsBlogsPeer extends BaseAppBlogsBlogsPeer
{
	
	static public function initialize($blog_id)
	{
		
		$OO = self::retrieveByPK($blog_id);
		
		if($OO instanceof AppBlogsBlogs):
			return new AppBlogsBlogsForm($OO);
		else:
			$OO = new AppBlogsBlogs();
			$OO->setName('Nom per defecte');
			$OO->setDate(date('Y-m-d',time()));		
			return new AppBlogsBlogsForm($OO);			
		endif; 
		
	}
	
	static public function getOptionsBlogs($APP_BLOG_ID)
	{		
			
		$RET = '<option value="-1">Escull un blog...</option>';
		foreach(self::doSelect(new Criteria()) as $OO):
			$SEL = ($OO->getId() == $APP_BLOG_ID)?'SELECTED':'';
			$RET .= '<option '.$SEL.' value="'.$OO->getId().'">'.$OO->getId().'. '.$OO->getName().'</option>';			
		endforeach;
		
		return $RET;		
		
	}
			
}
