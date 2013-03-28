<?php use_helper('Presentation'); ?>

<style>
.cent { width:100%; }
.vuitanta { width:80%; }
.cinquanta { width:50%; }
.HTEXT { height:100px; }

	.row { width:500px; } 
	.row_field { width:80%; } 
	.row_title { width:20%; }
	.row_field input { width:100%; } 

</style>


   <td colspan="3" class="CONTINGUT_ADMIN">
    
    <?php include_partial('breadcumb',array('text'=>'INFORMES')); ?>
      
        <div class="REQUADRE">
        <div class="TITOL">Informes disponibles</div>
      	<table class="DADES">
      		<tr><th>Nom</th><th>Descripció</th><th>Enllaç</th><th>Parametres</th></tr>
      		<?php if($POTVEURE[1]): ?>
      			<tr><td>Comptabilitat</td><td>Resum de conceptes i factures</td><td><a target="_NEW" href="http://192.168.0.3/comptabilitat/informe_conceptes.php">Anar-hi</a></td><td>Cap</td></tr>
      		<?php endif; ?>
       			<tr>
      				<td>Comptabilitat</td>
      				<td>Resum de matrícules per dia i mitjà pagament</td>
      				<td>---</td>
      				<td>
      					<a href="<?php echo url_for('gestio/gInformes?accio=MAT_DIA_PAG&mode_pagament='.MatriculesPeer::PAGAMENT_CODI_DE_BARRES) ?>"> C </a>
                        <a href="<?php echo url_for('gestio/gInformes?accio=MAT_DIA_PAG&mode_pagament='.MatriculesPeer::PAGAMENT_METALIC) ?>"> M </a>
      					<a href="<?php echo url_for('gestio/gInformes?accio=MAT_DIA_PAG&mode_pagament='.MatriculesPeer::PAGAMENT_TARGETA) ?>"> Ta </a>
      					<a href="<?php echo url_for('gestio/gInformes?accio=MAT_DIA_PAG&mode_pagament='.MatriculesPeer::PAGAMENT_TELEFON) ?>"> Tf </a>
      					<a href="<?php echo url_for('gestio/gInformes?accio=MAT_DIA_PAG&mode_pagament='.MatriculesPeer::PAGAMENT_TRANSFERENCIA) ?>"> Tr </a>
      					<a href="<?php echo url_for('gestio/gInformes?accio=MAT_DIA_PAG&mode_pagament=0') ?>"> All </a>
   				</td></tr>
                <tr><td>Programació</td><td>Document Word amb les activitats</td><td><a href="<?php echo url_for('gestio/gInformes?accio=RESUM_ACTIVITATS') ?>">Anar-hi</a></td><td>Cap</td></tr>
                <tr><td>Programació</td><td>Planificació d'ocupació d'espais i material</td><td><a href="<?php echo url_for('gestio/gEstadistiques?accio=CC') ?>">Anar-hi</a></td><td>Cap</td></tr>
                <tr><td>Programació</td><td>Repàs contingut mensual web/news</td><td><a href="<?php echo url_for('gestio/gInformes?accio=CONTINGUT_WEB') ?>">Anar-hi</a></td><td>Cap</td></tr>
      	</table>      
      </div>
      
      
      <?php if(isset($FACTIVITATS)) echo FLlistatWord($FACTIVITATS); ?>
      
      <?php if(isset($DADES)) echo LlistatMatriculats($DADES,$MODE,$accio); ?>
            
      <?php if(isset($LOA,$IDS)) echo LlistatWord($LOA,$IDS); ?>
      
      <?php if( isset( $LLISTAT_ACTIVITATS_WEB , $IDS ) ) echo LlistatWeb( $LLISTAT_ACTIVITATS_WEB , $IDS ); ?>
      
      <div style="height:40px;"></div>
                
    </td>          
      

<!-- Comença el bloc de matrícules per dia -->
<?php 

    function FLlistatWord($FACTIVITATS)
    {        
    	echo ' <form action="'.url_for('gestio/gInformes').'" method="POST">     	    
                    <div class="REQUADRE">';            
        echo '          <div class="FORMULARI">                    
                            '.$FACTIVITATS.'
                            <div class="cl" style="text-align:right; padding-top:40px;">	 	
                                <button type="submit" name="BGENERADOC" class="BOTO_ACTIVITAT">
    				                '.image_tag('template/disk.png').' Genera el llistat
                                </button>  <br />
                                <button type="submit" name="BGENERAXML" class="BOTO_ACTIVITAT">
    				                '.image_tag('template/disk.png').' Genera fitxer XML
                                </button>
                                <div style="clear:both"></div>
                            </div>                                       	
                        </div>                                                  		 		        			 	 	
                    </div>     		                    
                </form>';
                               
    }


    function LlistatMatriculats($DADES,$MODE,$accio)
    {        
        $RET = "";
        $TARGETA = ($MODE == MatriculesPeer::PAGAMENT_TARGETA || $MODE == MatriculesPeer::PAGAMENT_TELEFON);
        $PAGAMENT_APLACAT = ($MODE == MatriculesPeer::PAGAMENT_CODI_DE_BARRES);
              
        if($accio == 'MAT_DIA_PAG'):
    
        $RET .= '<DIV class="REQUADRE">
                    <DIV class="TITOL">Matrícules pagades per dia</DIV>
          	         <TABLE class="DADES">
          		        <tr>
              			<th>Data</th>
                        <th>Hora</th>
              			<th>Import</th>
              			<th>DNI</th>
              			<th>Nom</th>
              			<th>Curs</th>';
        if($TARGETA) $RET .= '<th># Caixa</th>';            
        if($PAGAMENT_APLACAT) $RET .= '<th>Pagat?</th>';
        if($MODE == 0) $RET .= '<th>Pagament?</th>';
        $RET .= '</tr>';
  		$DATA = ""; $DATA_ANT = -2; $TOTAL = 0;
  		foreach($DADES as $D):
          		
  		    $DATA = $D['DATA'];
 			$DATA_ANT = ($DATA_ANT == -2)?$D['DATA']:$DATA_ANT;      		      		
  		    if($DATA <> $DATA_ANT):
    			$RET .= '<tr>';
    			$RET .= '<td style="font-weight:bold; background:#F2EAEA;">'.$DATA_ANT.'</td><td style="font-weight:bold; background:#F2EAEA;">&nbsp;</td>';
    			$RET .= '<td colspan="6" style="font-weight:bold; background:#F2EAEA;">'.$TOTAL.'€ || Total alumnes: '.$ALUMNES.'</td>';      			      			
          		$RET .= '</tr>';
                $TOTAL = 0;
                $ALUMNES = 0;                  				      		
          	endif;      		

            //Sumem l'import que hem de mostrar
            if($D['ESTAT'] == MatriculesPeer::DEVOLUCIO) { $IMPORT = -1*$D['IMPORT']; $TOTAL -= $D['IMPORT']; }
            else { $IMPORT = $D['IMPORT']; $TOTAL += $D['IMPORT']; }
            
            //Sumem un alumne més
            $ALUMNES++;

            $RET .= '<tr>
              			<td>'.$D['DATA'].'</td>
                        <td>'.$D['HORA'].'</td>
                        <td>'.$IMPORT.'</td>
                        <td>'.$D['DNI'].'</td>
              			<td>'.$D['NOM'].'</td>
              			<td>'.$D['CURS'].'</td>';
                        
            //Si és un pagament amb targeta, mirem el número de comanda.
            if($TARGETA) $RET .= '<td>'.$D['ORDER'].'</td>';
            
            //Si és pagament aplaçat, marquem si està pagat o no.
            $PAGAT = ($D['ESTAT'] == MatriculesPeer::ACCEPTAT_PAGAT)?'Sí':'No';
            if($PAGAMENT_APLACAT) $RET .= '<td>'.$PAGAT.'</td>';
            
            //Si  marquem de mode tots, mostrem l'estat de la matrícula
            if($MODE == 0) $RET .= '<td>'.$D['ESTATS'].'</td>';
            
            $RET .= '</tr>';          		      		      		      		
      		$DATA_ANT = $DATA; 
        
  		endforeach;    				

        $RET .= '<tr>';
    	$RET .= '<td style="font-weight:bold; background:#F2EAEA;">'.$DATA_ANT.'</td><td style="font-weight:bold; background:#F2EAEA;">&nbsp;</td>';
    	$RET .= '<td colspan="6" style="font-weight:bold; background:#F2EAEA;">'.$TOTAL.'€ || Total alumnes: '.$ALUMNES.'</td>';      			      			
        $RET .= '</tr>';
          	
        $RET .= '  </TABLE>';      
        $RET .= '</DIV>';
      
        endif;      
        
        return $RET;
    }
    

    /**
     * Treu el llistat de les activitats setmanals...
     * */
    function LlistatWord($LOA,$IDS)
    {
        $RET = "";
        $URLWEB = OptionsPeer::getString('SF_WEBROOTURL',$IDS);
        
        foreach($LOA as $OA):
            
            //Mostrem el títol, cicle, Organitzador, Espais, dies i hores.
            $titol          = $OA->getTmig();
            $desc           = $OA->getDmig();
            $OC             = $OA->getCicles(); if($OC instanceof Cicles) $cicle = $OC->getTmig();
            $organitzador   = $OA->getOrganitzador();
            $horaris        = generaHoraris($OA->getHorarisOrdenats(HorarisPeer::DIA));
            $imatge         = $OA->getImatge('M');                                                                        
            $link           = url_for('gestio/gActivitats?IDA='.$OA->getActivitatid());
                                    
            $RET .= '                    
                        <div style="clear:both; float:left"><img align="top" src="'.$imatge.'" /></div>
                        <div style="float:left">
                            <b>'.$titol.'</b> (<a href="'.$link.'">edita</a>)
                            <br /><i>Cicle: '.$cicle.'</i>
                            <br /><i>Organitzador: '.$organitzador.'</i>
                            <br /><i>'.$horaris.'</i>                        
                            <br /><br />'.$desc.'
                        </div>                  
                        <div style="clear:both"></div>
                        <br /><br /><br /><br />
                        ';
                                                
        endforeach;
        
        $RETF = '<DIV class="REQUADRE">
                    <DIV class="TITOL">Llistat d\'activitats</DIV>
                        <div>'.$RET.'</div>
                 </div>';                              
        return $RETF;
    }    
 

    function LlistatWeb( $LLISTAT_ACTIVITATS_WEB , $IDS )
    {

        $RET = "";
        $URLWEB = OptionsPeer::getString('SF_WEBROOTURL',$IDS);

        $RET = '<div class="REQUADRE"><div class="TITOL">Llistat properes activitats visibles a web (4 mesos)</div>'; 
        $RET .= '<table width="100%"><tr><td class="titol">Quan</td><td class="titol">Què</td><td class="titol">Nivell</td><td class="titol">Falta</td></tr>';
        
        foreach( $LLISTAT_ACTIVITATS_WEB as $id => $A_OA ):
                                    
            if($A_OA['OA']->getPublicaweb()){
                //Dia, activitat, (què li falta...)
                $PH = $A_OA['OA']->getPrimerHorari()->getDia('d/m');
                $UH = $A_OA['OA']->getUltimHorari()->getDia('d/m');
                $horari = $PH;
                if($PH <> $UH) $horari = $PH.' a '.$UH;
                $falta  = (!$A_OA['text'])?' TXT ':'';                 
                $falta .= (!$A_OA['desc'])?' DES ':'';
                $falta .= (!$A_OA['img_m'])?'S':'';
                $falta .= (!$A_OA['img_l'])?'M':'';
                $falta .= (!$A_OA['img_xl'])?'L':'';                
                
                $url = link_to('edita',url_for('gestio/gActivitats?accio=ACTIVITAT&IDA='.$id,array('target'=>'_blank')));

                $RET .= '
                    <tr>                                                
                        <td>'.$horari.'</td>
                        <td>'.$A_OA['OA']->getTmig().' ('.$url.') <br /><span style="font-size:8px;"><i>'.$A_OA['OA']->getCicles()->getNom().'</i></span></td>
                        <td>'.$A_OA['nivell'].'                        
                        <td>'.$falta.'</td>                                                
                    </div>                                            
                        ';
                
            }                        
                        
        endforeach;                        
        
        $RET .= '</table></div>';
                                                  
        return $RET;
    }    

 