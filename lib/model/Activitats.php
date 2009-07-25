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
   
}
