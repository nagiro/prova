<?php 

if($MODE == 'LLISTAT_ALUMNES'):

    $RET = "";
    foreach($MATRICULES as $M):
        $C = $M->getCursos();
        $U = $M->getUsuaris();
        $ODB = DadesBancariesPeer::retrieveByPK($M->getIddadesbancaries());
        $TEXT_REDUCCIO ="";         
        if(!$M->hasDescompte()) { $PREU = $M->getPagat(); } else { $PREU = $M->getPagat(); $TEXT_REDUCCIO = ' |R'; }
        if($M->getEstat() == $estat):
          	$RET .= '<TR>';
			$RET .= '<TD class="LINIA" width="15%">'.link_to($U->getDni(),'gestio/gMatricules?accio=E&IDM='.$M->getIdmatricules()).'</TD>';
			$RET .= '<TD class="LINIA" width="40%"><b>'.$U->getNomComplet().'</b><BR />'.$U->getAdreca().'<BR />'.$U->getCodiPostal().' - '.$U->getPoblacioString().'<BR />'.$U->getTelefonString().' | '.$M->getDatainscripcio().' <br />'.$U->getEmail().'</TD>';
			$RET .= '<TD class="LINIA" width="45%">'.$C->getCodi().' '.$C->getTitolcurs().' ('.$PREU.'€'.$TEXT_REDUCCIO .') <br />';
            if($C->getIsentrada() == CursosPeer::TIPUS_PAGAMENT_DOMICILIACIO):
                if(is_null($ODB))   $RET .= 'No disposa de compte corrent.<br />';
                else                $RET .= link_to($ODB->getCccPublic(),'gestio/gUsuaris?id_usuari='.$M->getUsuarisUsuariid().'&accio=CCC',array('target'=>'_BLANK')).'<br />';                
            endif;
			$RET .= MatriculesPeer::getEstatText($M->getEstat()).'<br />'.$M->getComentari().'</TD>';							
			$RET .= '</TR>';
        endif; 
   endforeach;
   
   echo $RET;
    
endif;

?>