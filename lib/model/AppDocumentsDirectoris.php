<?php

class AppDocumentsDirectoris extends BaseAppDocumentsDirectoris
{

	public function __toString()
	{
		return $this->getNom();
	}
	
}
