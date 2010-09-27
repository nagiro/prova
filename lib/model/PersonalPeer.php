<?php

require 'lib/model/om/BasePersonalPeer.php';


/**
 * Skeleton subclass for performing query and update operations on the 'personal' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 07/06/10 12:03:57
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class PersonalPeer extends BasePersonalPeer {

	const AP_FESTA = '1';
    const CANVI_HORARI = '2';
    const HORARI_USUARI = '3';
    const FEINA = '4';    
    
	static public function initialize($idUsuari, $data,$idu,$idPersonal = null)
	{
		$C = new Criteria();
		$C->add(PersonalPeer::IDUSUARI,$idu);		
		$C->add(PersonalPeer::IDDATA, date('Y-m-d',$data));
		$C->add(PersonalPeer::IDPERSONAL, $idPersonal);			
		$OP = self::doSelectOne($C);
		
		if($OP instanceof Personal):			
			$OP->setUsuariUpdateId($idUsuari);
			return new PersonalForm($OP);
		else: 
			$OP = new Personal();
			$OP->setDataAlta(date('Y-m-d',time()));
			$OP->setIddata(date('Y-m-d',$data));
			$OP->setIdusuari($idu);	
			$OP->setUsuariUpdateId($idUsuari);												
			return new PersonalForm($OP);
		endif; 
		
		
	}

    static public function getTipusArray()
    {
        return array(
                    self::FEINA => 'Feina',
                    self::CANVI_HORARI => 'Canvi horari puntual',
                    self::AP_FESTA => 'AP o Festa',
                    self::HORARI_USUARI => 'Canvi horari habitual'                    
        );
    }

	static public function getDadesUpdates($data,$idU)
	{
		$RET = array();
		
		$C = new Criteria();
		$C->add(PersonalPeer::IDUSUARI,$idU);		
		$C->add(PersonalPeer::IDDATA, date('Y-m-d',$data));
        $C->add(PersonalPeer::DATA_BAIXA, null, Criteria::ISNULL);			
		$C->addAscendingOrderByColumn(PersonalPeer::DATA_ALTA);
		
		foreach(self::doSelect($C) as $D):						
			$RET[$D->getIdpersonal()] = $D; 
		endforeach;
		
		return $RET; 
	}
	
	static public function getHoraris($datai)	
	{
		$RET = array();
		
		$dataf = mktime(0,0,0,date('m',$datai),date('d',$datai)+21,date('Y',$datai));
		
        //Seleccionem tots els treballadors 
		$TREBALLADORS = UsuarisPeer::selectTreballadors();
		
		foreach($TREBALLADORS as $idU => $T):
			$C = new Criteria();
			$C->add(PersonalPeer::IDUSUARI,$idU);
			$C->add(PersonalPeer::IDDATA, date('Y-m-d',$datai), CRITERIA::GREATER_EQUAL);
			$C->add(PersonalPeer::IDDATA, date('Y-m-d',$dataf), CRITERIA::LESS_EQUAL);
            $C->add(PersonalPeer::DATA_BAIXA, NULL, Criteria::ISNULL);			
			$C->addAscendingOrderByColumn(PersonalPeer::DATA_ALTA);
			
			$OU = UsuarisPeer::retrieveByPK($idU);			
			$RET[$idU]['TREBALLADOR'] = $OU->getNomComplet();
			            
			//Busquem l'últim horari estàndard del treballador abans de les dates que mirem.
			$C2 = new Criteria();
			$C2->add(PersonalPeer::IDUSUARI,$idU);
            $C2->add(PersonalPeer::TIPUS, PersonalPeer::HORARI_USUARI);            
			$C2->addDescendingOrderByColumn(PersonalPeer::IDDATA);	            					
			$C2->add(PersonalPeer::IDDATA, date('Y-m-d',$datai), Criteria::LESS_THAN);
            $C2->add(PersonalPeer::DATA_BAIXA, NULL, Criteria::ISNULL);						
			$ULTIM_HORARI = self::doSelectOne($C2);			
			if($ULTIM_HORARI instanceof Personal) $RET[$idU]['ULTIM_HORARI'] = $ULTIM_HORARI->getText();
			else $RET[$idU]['ULTIM_HORARI'] = 'n/d';
				
            //Carreguem totes les línies que consten d'aquests dies		
			foreach(self::doSelect($C) as $D):
				
				list($YE,$MO,$DA) = explode('-',$D->getIddata());
				$data = mktime(0,0,0,$MO,$DA,$YE);                			
				$RET[$D->getIdusuari()]['DIES'][$data][] = $D;
                                																
			endforeach;
			
		endforeach;
		
		return $RET;
	}
	
} // PersonalPeer
