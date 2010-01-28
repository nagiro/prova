<?php

/**
 * Subclass for performing query and update operations on the 'activitats' table.
 *
 * 
 *
 * @package lib.model
 */ 
class ActivitatsPeer extends BaseActivitatsPeer
{
   //Retorna quantes activitats hi ha avui
   static function QuantesAvui()
   {     
     $H = new Horaris();
     $C = new Criteria();
     $C->add(HorarisPeer::DIA,date('Y-m-d',time()));          
     return HorarisPeer::doCount($C);
   }
   
   static function getNoticies()
   {
      $C = new Criteria();
      $C->add(self::PUBLICAWEB , true);
      $C->addDescendingOrderByColumn(self::ACTIVITATID);      
      return self::doSelect($C);
   }

   static function getActivitatsDia($dia)
   {
      $RET = array();

      $SQL = "
            SELECT A.* , E.*, H.*
              FROM espais E, horarisespais HE, horaris H, activitats A 
             WHERE H.Activitats_ActivitatID = A.ActivitatID 
                  AND H.HorarisID = HE.Horaris_HorarisID 
                  AND HE.Espais_EspaiID = E.EspaiID                  
                  AND H.Dia = '$dia'
                  AND A.tWEB <> '' ";
      
     $con = Propel::getConnection(); $stmt = $con->prepare($SQL); $stmt->execute();     
	 
     while($rs = $stmt->fetch(PDO::FETCH_OBJ)): 
     
         $RET[$rs->ActivitatID]['DADES']['ID'] = $rs->ActivitatID; 
         $RET[$rs->ActivitatID]['DADES']['TITOL'] = $rs->tMig;
         $RET[$rs->ActivitatID]['DADES']['TEXT'] = $rs->dMig;
         $RET[$rs->ActivitatID]['DADES']['TEXT'] = $rs->Imatge;
         $RET[$rs->ActivitatID]['DADES']['TEXT'] = $rs->PDF;
         
         $RET[$rs->ActivitatID]['HORARIS'][$rs->HorarisID]['ESPAIS'][] = $rs->Nom;
         $RET[$rs->ActivitatID]['HORARIS'][$rs->HorarisID]['HORAI'] = $rs->HoraInici;
         $RET[$rs->ActivitatID]['HORARIS'][$rs->HorarisID]['HORAF'] = $rs->HoraFi;
         
      endwhile;
          
      return $RET; 
   }
   
   static function getSelectEstats()
   {
   		return array(1=>'Acceptada',2=>'PreReserva');
   }
   
	static public function getTipusEnviaments()
	{
		return array(1=>'El primer dia',2=>'Una setmana abans',3=>'Cada dia d\'activitat');
	}
	
	static public function getTipusEnviamentsSelect()
	{
		return self::getTipusEnviaments();
	}
	
	static public function getTipusEnviamentsSelectValidator()
	{
		$RET = array();
		foreach(self::getTipusEnviaments() as $K=>$V):
		
			$RET[$K] = $K;
		
		endforeach;
		
		return $RET;
	}
   
}
