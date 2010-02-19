<?php

class AppBlogsMenu extends BaseAppBlogsMenu
{
	public function __toString()
	{
		return $this->getName();
	}
}
