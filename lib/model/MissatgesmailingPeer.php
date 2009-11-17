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
		
		$OM = MissatgesmailingPeer::retrieveByPK($idMissatge);
		MissatgesmailingPeer::sendMail($OM->getTitol(),$OM->getText(),$email,'informatica@casadecultura.org');
						
	}
	
	static public function sendMessageId($idMissatge)
	{
		
		$OM = MissatgesmailingPeer::retrieveByPK($idMissatge);
		
		if($OM instanceof Missatgesmailing):
		
			//Recuperem les llistes			
			foreach($OM->getLlistesEnviament() as $L)
			{																						
				foreach($L->getMailsUsuaris() as $mail)
				{
					MissatgesmailingPeer::sendMail($OM->getTitol(),$OM->getText(),$mail,'llista@casadecultura.org');
				}
			}
			
		endif;
				
	}
	
	
	static public function sendMail($subject,$mailBody,$mailTo,$mailFrom)
	{
		
		try
		{
			
		  $mailer = new Swift(new Swift_Connection_NativeMail());
		  $message = new Swift_Message($subject, $mailBody, 'text/html');
		  		 
		  $mailer->send($message, $mailTo, $mailFrom);
		  $mailer->disconnect();		  
		  
		}
		catch (Exception $e) {
			 
		  $mailer->disconnect();		  		  		  
		  		  		 		  
		}
		
	}
	
}
