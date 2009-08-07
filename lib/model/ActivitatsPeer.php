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
       
      $con = Propel::getConnection();
      $stmt = $con->createStatement();
      $SQL = "
            SELECT A.* , E.*, H.*
              FROM espais E, horarisespais HE, horaris H, activitats A 
             WHERE H.Activitats_ActivitatID = A.ActivitatID 
                  AND H.HorarisID = HE.Horaris_HorarisID 
                  AND HE.Espais_EspaiID = E.EspaiID                  
                  AND H.Dia = '$dia'
                  AND A.tWEB <> '' ";
      $rs = $stmt->executeQuery($SQL,ResultSet::FETCHMODE_ASSOC);
                        
      while($rs->next())
      {
         $RET[$rs->get('ActivitatID')]['DADES']['ID'] = $rs->get('ActivitatID'); 
         $RET[$rs->get('ActivitatID')]['DADES']['TITOL'] = $rs->get('tWEB');
         $RET[$rs->get('ActivitatID')]['DADES']['TEXT'] = $rs->get('dWEB');
         $RET[$rs->get('ActivitatID')]['DADES']['TEXT'] = $rs->get('Imatge');
         $RET[$rs->get('ActivitatID')]['DADES']['TEXT'] = $rs->get('PDF');
         
         $RET[$rs->get('ActivitatID')]['HORARIS'][$rs->get('HorarisID')]['ESPAIS'][] = $rs->get('Nom');
         $RET[$rs->get('ActivitatID')]['HORARIS'][$rs->get('HorarisID')]['HORAI'] = $rs->get('HoraInici');
         $RET[$rs->get('ActivitatID')]['HORARIS'][$rs->get('HorarisID')]['HORAF'] = $rs->get('HoraFi');
         
      }
          
      return $RET; 
   }
   
   static function getSelectEstats()
   {
   		return array('1'=>'Acceptada','2'=>'PreReserva');
   }
   
}
