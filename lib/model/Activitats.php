<?php

/**
 * Subclass for representing a row from the 'activitats' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Activitats extends BaseActivitats
{

    public function getSurtAWeb(){

        $titol = strlen($this->getTmig());
        $text  = strlen($this->getDmig());
        $publicable = $this->getPublicaweb();                
                                 
        if( ( $titol < 5 || $text < 30 ) && $publicable == 1 ):
            return "FALTA_INFO";            
        elseif( $titol > 0 && $text > 0 && $publicable == 1 ):
            return "OK";
        else:
            return "FAIL"; 
        endif;
    }

    public function getEntradesHoraris()
    {
        //Si de l'activitat actual se'n opden comprar entrades
        if($this->getIsentrada() == true):                    
            //Carreguem els horaris que tinguin isEntrada = 1
            $C = new Criteria();
            $C->add(HorarisPeer::ISENTRADA, true);
            $LHO = $this->getHorariss($C);                        
            return $LHO;        
        else: 
            return array();
        endif; 
    }

    public function getNomTipusActivitat()
    {
        $OTA = $this->getTipusactivitat();
        $NOM = "n/d";
        
        if($OTA instanceof Tipusactivitat) $NOM = $OTA->getNom();    
        
        return $NOM;
    }
    
    public function setInactiu()
    {
        $this->setActiu(false);
        $C = new Criteria();
        $C = HorarisPeer::getCriteriaActiu($C,$this->getSiteid());
        
        foreach($this->getHorariss($C) as $OH):
            $OH->setInactiu();
        endforeach;        
        
        $this->save();                
    }
    
   public function getEspais()
   {
      $RET = array();
      $con = Propel::getConnection();
      $stmt = $con->createStatement();
      $idA = $this->getActivitatid();
      $SQL = "
               SELECT E.*
                 FROM espais E, horarisespais HE, horaris H 
                WHERE H.Activitats_ActivitatID = $idA 
                  AND H.HorarisID = HE.Horaris_HorarisID 
                  AND HE.Espais_EspaiID = E.EspaiID
                  GROUP BY E.Nom
                  ";
      $rs = $stmt->executeQuery($SQL,ResultSet::FETCHMODE_NUM);      
      foreach(EspaisPeer::populateObjects($rs) as $E):
         $RET[] = $E->getNom();      
      endforeach;
      return $RET;
   }
   
   public function get7DiesAbansData()
   {
   	
   		$H = $this->getHorariss();
   		if($H[0] instanceof Horaris):
   		
   			list($any,$mes,$dia) = explode("-",$H[0]->getDia());
   			$time = mktime(0,0,0,$mes,$dia-7,$any);
   			return date('Y-m-d',$time);   			
   			
   		else:
   		
   			return date('Y-m-d',time());
   		
   		endif;
   	
   }
   
   public function getHorariss($criteria = null, PropelPDO $con = null)
   {
        $C = $criteria;
        if(is_null($criteria)) $C = new Criteria();
        
        $C = HorarisPeer::getCriteriaActiu($C,$this->getSiteId());
        return parent::getHorariss($C,null);
   }
   
      
   public function getPrimeraData()
   {   	                        
   		$H = $this->getHorariss();
   		if(isset($H[0]) && $H[0] instanceof Horaris):
   		
   			list($any,$mes,$dia) = explode("-",$H[0]->getDia());
   			$time = mktime(0,0,0,$mes,$dia,$any);
   			return date('Y-m-d',$time);   			
   			
   		else:
   		
   			return date('-----',time());
   		
   		endif;
   	
   }

   public function getPrimerHorari()
   {   	                        
        $C = new Criteria();
        $C->addAscendingOrderByColumn(HorarisPeer::DIA);
        
   		$H = $this->getHorariss($C);
        if($H[0] instanceof Horaris) return $H[0];        
        else return null;          	
   }

   /**
    * Retorna l'horari que correspòn al dia en qüestió
    **/    
   public function getHorariDia($dia){
        
        $C = new Criteria();
        $C->add( HorarisPeer::DIA , $dia );
        $C->add( HorarisPeer::ACTIVITATS_ACTIVITATID , $this->getActivitatid() );
        return HorarisPeer::doSelectOne($C);
   }

   /**
    * Entrem una variable Time i retorna el següent horari després del dia.
    * @param $dia (time())
    * */
   public function getSeguentHorariDespresDelDia( $dia ){
        $C = new Criteria();
        $C->addAscendingOrderByColumn(HorarisPeer::DIA);
        $C->add( HorarisPeer::DIA , date('Y-m-d',$dia) , CRITERIA::GREATER_EQUAL );
        
   		$H = $this->getHorariss($C);
        if($H[0] instanceof Horaris) return $H[0];        
        else return null;    
   }

    /**
     * Retorna l'últim horari d'una activitat.
     * */
   public function getUltimHorari()
   {
        $C = new Criteria();
        $C->addDescendingOrderByColumn(HorarisPeer::DIA);
        
   		$H = $this->getHorariss($C);
        if($H[0] instanceof Horaris) return $H[0];        
        else return null;        
   }

   
   public function getHorarisOrdenats($camp)
   {
        $C = new Criteria();
        $C = HorarisPeer::getCriteriaActiu($C,$this->getSiteId());
        $C->addAscendingOrderByColumn($camp);
        return $this->getHorariss($C);
   }
   
   public function countHorarisActius($idS)
   {
     $C = new Criteria();
     $C = HorarisPeer::getCriteriaActiu($C,$idS);     
     return $this->countHorariss($C);
   }
   
   public function getHorarisActius($idS)
   {    
     $C = new Criteria();
     $C = HorarisPeer::getCriteriaActiu($C,$idS);
     $C->addAscendingOrderByColumn(HorarisPeer::DIA);     
     return $this->getHorariss($C);    
   }

   public function getNomSite()
   {    
     return SitesPeer::getNom($this->getSiteId());
   }

   public function getNomForUrl()
   {
        $nom = $this->getTmig();
        return myUser::text2url($nom);        
   }

    /**
     * Retorna si una activitat ja no té més entrades a la venta. 
     * */
   public function getIsPle()
   {
        return (EntradesReservaPeer::countEntradesActivitatConf($this->getActivitatid()) >= $this->getPlaces());        
   }
   
   public function getTmig(){
    
    $tmig = $this->tmig;
    if(empty($tmig)) return $this->getNom();
    else return $tmig;
    
   }

   public function getImportancia()
   {
        $nivell = 3;
        $cat = $this->getCategories();
                                        
        if( substr_count($cat, '54') || substr_count($cat, '50') || substr_count($cat, '51') || substr_count($cat, '45') ) $nivell = 3;
        if( substr_count($cat, '53') || substr_count($cat, '47') ) $nivell = 2;
        if( substr_count($cat, '52') || substr_count($cat, '49') || substr_count($cat, '46') || substr_count($cat, '44') ) $nivell = 1;        
        return $nivell;
   }
   
   /**
    * Retorna els horaris que tenen pagament activat. 
    * */
   public function getHorarisAmbPreu()
   {
        $RET = array();
        $C = new Criteria();
        $C->add( EntradesPreusPeer::ACTIVITAT_ID , $this->getActivitatid() );
        $C->add( EntradesPreusPeer::ACTIU , true );        
        
        foreach( EntradesPreusPeer::doSelect($C) as $OP ):
            $RET[$OP->getHorariId()] = $OP->getHorariId();        
        endforeach;
         
        return $RET;                 
   }
   
   /**
    * Aquesta funció retorna la URL de la imatge segons la mida.
    * @param Mida: "S,M,L" 
    * */
   public function getImatge($mida)
   {
        $dir = '/images/activitats/';
        $base = OptionsPeer::getString('SF_WEBSYSROOT' , $this->getSiteId() );
        $mini = false; $normal = false; $big = false; $pdf = false;
        if ( file_exists( $base.'/images/activitats/A-'.$this->getActivitatid().'-'.$mida.'.jpg') ):
            return $dir.'A-'.$this->getActivitatid().'-'.$mida.'.jpg';        
        else: 
            return null; 
        endif;  
   }
   
}
