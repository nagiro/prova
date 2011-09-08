<?php

require 'lib/model/om/BaseFormularisRespostesPeer.php';


/**
 * Skeleton subclass for performing query and update operations on the 'formularis_respostes' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 09/05/11 10:56:55
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class FormularisRespostesPeer extends BaseFormularisRespostesPeer {

    static public function initialize($idF, $idU, $dades){
        $OFR = new FormularisRespostes();
        $OF = FormularisPeer::retrieveByPK($idF);
        $OFR->setIdusuaris($idU);
        $OFR->setIdformularis($idF);
        $OFR->setDades($dades);
        $OFR->setRegistrat(time());
        $OFR->setSiteid($OF->getSiteid());
        $OFR->setActiu(true);        
        return $OFR;        
    }

    static public function getFormularisUsuari($idU)
    {
        $C = new Criteria();
        $C->add(self::ACTIU, true); $C->add(FormularisPeer::ACTIU, true);
        $C->addJoin(self::IDFORMULARIS, FormularisPeer::IDFORMULARIS);
        $C->add(self::IDUSUARIS, $idU);        
        return self::doSelect($C);
    }

    static public function getFormulariDetall($idU,$idF){
        
        //Carreguem el formulari formulari
        $OF = FormularisPeer::retrieveByPK($idF);
        if($OF instanceof Formularis) $FORM = $OF->getFormulari();
        else $FORM = "No s'ha trobat el formulari. ";                        
        
        //Mirem si l'usuari ja en t� algun de creat.
        $C = new Criteria();
        $C->add(FormularisRespostesPeer::IDUSUARIS, $idU);
        $C->add(FormularisRespostesPeer::IDFORMULARIS, $idF);
        $C->addDescendingOrderByColumn(FormularisRespostesPeer::IDFORMULARISRESPOSTES);
        
        $OFR = FormularisRespostesPeer::doSelectOne($C);
        
        //Analitzo el formulari i canvio els codis per inputs pertinents. 
        $ARR = array(); preg_match_all("/#@@(.*)@@#/", $FORM , $ARR );
        
        //Ser� l'array amb els valors a carregar
        $A_D = array();        
                        
        //Si ja hi ha una resposta, reomplim el formulari
        if($OFR instanceof FormularisRespostes):
            $A_D = unserialize($OFR->getDades());                                                    
                    
        //Si no hi ha cap registre previ, posem les dades de registre per estalviar feina. 
        else:
        
            $OU = UsuarisPeer::retrieveByPK($idU);
            if($OU instanceof Usuaris):
                $A_D = array(   'NOM'=>$OU->getNom(), 
                                'COGNOMS'=>$OU->getCog1().' '.$OU->getCog2(), 
                                'DNI'=>$OU->getDni(), 
                                'POBLACIO' => $OU->getPoblacioString(), 
                                'TELEFON'=> $OU->getTelefonString(),
                                'EMAIL' => $OU->getEmail(),
                                'ENTITAT' => $OU->getEntitat()
                            );                                                                                 
            endif;
            
        endif;
                
        //Construim el formulari amb els valors que hem extret del formulari
        foreach($ARR[1] as $K=>$V){
            $A = explode("@@",$V);
                                  
            if($A[0] == 'text'){                
                if(isset($A_D[$A[1]]))  $FORM = str_replace( $ARR[0][$K], '<input type="text" value="'.$A_D[$A[1]].'" name="formulari['.$A[1].']" '.$A[2].' />', $FORM );
                else                    $FORM = str_replace( $ARR[0][$K], '<input type="text" value="" name="formulari['.$A[1].']" '.$A[2].' />', $FORM );
            }         
            elseif($A[0] == 'checkbox'){                
                if(isset($A_D[$A[1]]))  $FORM = str_replace( $ARR[0][$K], '<input type="checkbox" checked="checked" name="formulari['.$A[1].']" '.$A[2].' />', $FORM );
                else                    $FORM = str_replace( $ARR[0][$K], '<input type="checkbox" name="formulari['.$A[1].']" '.$A[2].' />', $FORM );  
            }             
        }
                        
        return $FORM; 
    }    


} // FormularisRespostesPeer
