<?php

class MissatgesmailingPeer extends BaseMissatgesmailingPeer
{
	static public function getMissatges($pagina = 1)
	{
		
		$C = new Criteria();
		$C->addDescendingOrderByColumn(self::IDMISSATGE);
		
		$pager = new sfPropelPager('Missatgesmailing', 20);
	    $pager->setCriteria($C);
	    $pager->setPage($pagina);
	    $pager->init();
	    return $pager;
		
	}
	
	static public function sendProvaMessageId($idMissatge,$email)
	{
		
	}
	
	static public function sendMessageId($idMissatge)
	{
		
		//Recuperem les llistes
		foreach(MissatgesllistesPeer::getLlistesMissatge($idMissatge) as $L)
		{
			//Recuperem els usuaris de la llista a qui s'ha d'enviar el missatge
			foreach($L->getUsuaris() as $U)
			{
				//Fem el tractament de l'usuari per agafar-li el correu i enviar-li. 
			}
		}
		
		
	}
	
}
