<?php

/**
 * Subclass for performing query and update operations on the 'llistes' table.
 *
 * 
 *
 * @package lib.model
 */ 
class LlistesPeer extends BaseLlistesPeer
{
   
  const TOTS = 0;
  const ENVIATS = 1;
  const NO_ENVIATS = 2;
   
  //Torna un Select amb les llistes que hi ha disponibles
  static public function select(){
     
     $C = new Criteria();
     $C->add(LlistesPeer::ISACTIVA , true); 
     
     $SELECT = array();     
     foreach(LlistesPeer::doSelect($C) as $L):        
        $SELECT[$L->getIdllistes()] = $L->getNom();
     endforeach;
     return $SELECT;
  }
   
  /**
   * Donada una llista i un usuari, els desvincula
   *
   */
  static public function desvincula($IDU, $IDL)
  {
      
       $C = new Criteria();
       $C->add(UsuarisllistesPeer::LLISTES_IDLLISTES , $IDL);
       $C->add(UsuarisllistesPeer::USUARIS_USUARISID , $IDU);
       
       foreach(UsuarisllistesPeer::doSelect($C) as $ULP):
          $ULP->delete();
       endforeach;
  }
  
 /**
   * Donada una llista i un usuari, els desvincula
   *
   */
  static public function vincula($IDU, $IDL)
  {
     
      $UL = new Usuarisllistes();
      $UL->setNew(true);
      $UL->setUsuarisUsuarisid($IDU);
      $UL->setLlistesIdllistes($IDL);
      $UL->save();
      
  }
  
  
  static public function getLlistesDisponibles($IDU)
  {
     $SELECT = array();
               
     foreach(self::select() as $K=>$L):
        $C = new Criteria();     
        $C->add(UsuarisllistesPeer::USUARIS_USUARISID , $IDU);
        $C->add(UsuarisllistesPeer::LLISTES_IDLLISTES, $K);
        if(UsuarisllistesPeer::doCount($C) == 0) $SELECT[$K] = $L;                 
     endforeach;          
     return $SELECT;
  }

  /**
   * Retorna els missatges d'una llista
   *
   * @param INT $MODALITAT
   */
  static public function getMissatges($IDL , $MODALITAT , $PAGINA = 1)  
  {
     $C = new Criteria();
     
     $C->add( MissatgesllistesPeer::LLISTES_IDLLISTES , $IDL );
     $C->addJoin(MissatgesllistesPeer::IDMISSATGESLLISTES,MissatgesmailingPeer::IDMISSATGE);     
     if($MODALITAT == self::ENVIATS)        $C->add( MissatgesllistesPeer::ENVIAT , null , CRITERIA::ISNOTNULL );   
     elseif($MODALITAT == self::NO_ENVIATS) $C->add( MissatgesllistesPeer::ENVIAT , null , Criteria::ISNULL );
                    
     $pager = new sfPropelPager('Missatgesmailing', 10);
	 $pager->setCriteria($C);
	 $pager->setPage($PAGINA);
	 $pager->init();  	
  	
  	 return $pager;
     
  }
  
  
  static public function EnviaMissatge($IDM)
  {

    $M = MissatgesllistesPeer::retrieveByPK($IDM);  	  
  	      	     	
    require_once('lib/vendor/swift/swift_init.php'); # needed due to symfony autoloader
  	$mailer = Swift_Mailer::newInstance(Swift_MailTransport::newInstance());
 
	$MAILS = UsuarisllistesPeer::getUsuarisLlistaEmail($M->getLlistesIdllistes()); 
	foreach($MAILS as $Email) {
     	
    	$message = Swift_Message::newInstance($M->getTitol())
        	 	->setFrom(array('informatica@casadeculutra.org' => 'CCG :: Informació'))
         		->setTo($Email)
         		->setBody($M->getText() , 'text/html');
         		  
	  	$mailer->send($message);
     	
     }
         
     $M->setEnviat(date('Y-m-d',time()));
     $M->save();
     
     return sizeof($MAILS);
  }
  
  
}
