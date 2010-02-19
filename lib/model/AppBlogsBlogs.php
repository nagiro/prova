<?php

class AppBlogsBlogs extends BaseAppBlogsBlogs
{
	public function __toString()
	{
		return $this->getName();
	}
}
