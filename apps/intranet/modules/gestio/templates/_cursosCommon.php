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
            
            //Si la matrícula és domiciliada, hem de mostrar el codi que hi té relacionat. 
            if( $M->getTpagament() == TipusPeer::PAGAMENT_DOMICILIACIO ):
                if(is_null($ODB))   $RET .= 'No disposa de compte corrent.<br />';
                else                $RET .= link_to($ODB->getCccPublic(),'gestio/gUsuaris?id_usuari='.$M->getUsuarisUsuariid().'&accio=CCC',array('target'=>'_BLANK')).'<br />';                
            endif;
			
            $RET .= MatriculesPeer::getEstatText($M->getEstat()).'<br />'.$M->getComentari().'<br />';
            $RET .= 'Matrícula '.link_to(image_tag('/images/template/page_white_word.png'),'gestio/gMatricules?accio=P&IDP='.$M->getIdmatricules());
            if($M->getEstat() == MatriculesPeer::BAIXA):            						
                $RET .= '&nbsp;Baixa '.link_to(image_tag('/images/template/page_white_word.png'),'gestio/gMatricules?accio=PB&IDP='.$M->getIdmatricules());
            endif;
			$RET .= '</TD></TR>';
        endif; 
   endforeach;
   
   echo $RET;
    
endif;

?>