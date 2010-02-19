<?php

class AppBlogsPages extends BaseAppBlogsPages
{
	public function __toString()
	{
		return $this->getId().'. '.$this->getName();
	}
}
