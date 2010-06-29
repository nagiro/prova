   <TD colspan="3" class="CONTINGUT">
    
    <?php include_partial('breadcumb',array('text'=>'INFORMES')); ?>
      
        <DIV class="REQUADRE">
        <DIV class="TITOL">Informes disponibles</DIV>
      	<TABLE class="DADES">
      		<tr><th>Nom</th><th>Descripció</th><th>Enllaç</th><th>Parametres</th></tr>
      		<?php if($POTVEURE[1]): ?>
      			<tr><td>Comptabilitat</td><td>Resum de conceptes i factures</td><td><a target="_NEW" href="http://192.168.0.3/comptabilitat/informe_conceptes.php">Anar-hi</a></td><td>Cap</td></tr>
      			<tr>
      				<td>Comptabilitat</td>
      				<td>Resum de matrícules per dia i mitjà pagament</td>
      				<td>---</td>
      				<td>
      					<a href="<?php echo url_for('gestio/gInformes?accio=MAT_DIA_PAG&mode_pagament='.MatriculesPeer::PAGAMENT_METALIC) ?>"> M </a>
      					<a href="<?php echo url_for('gestio/gInformes?accio=MAT_DIA_PAG&mode_pagament='.MatriculesPeer::PAGAMENT_TARGETA) ?>"> Ta </a>
      					<a href="<?php echo url_for('gestio/gInformes?accio=MAT_DIA_PAG&mode_pagament='.MatriculesPeer::PAGAMENT_TELEFON) ?>"> Tf </a>
      					<a href="<?php echo url_for('gestio/gInformes?accio=MAT_DIA_PAG&mode_pagament='.MatriculesPeer::PAGAMENT_TRANSFERENCIA) ?>"> Tr </a>
      				</td></tr>      			
      		<?php endif; ?>
      			
      	</TABLE>      
      </DIV>

<!-- Comença el bloc de matrícules per dia -->      
<?php if($accio == 'MAT_DIA_PAG'): ?>

      <DIV class="REQUADRE">
        <DIV class="TITOL">Matrícules pagades per dia</DIV>
      	<TABLE class="DADES">
      		<tr>
      			<th>Data</th>
      			<th>Import</th>
      			<th>DNI</th>
      			<th>Nom</th>
      			<th>Curs</th>
      		</tr>
      		<?php $DATA = ""; $DATA_ANT = -2; $TOTAL = 0; ?>
      		<?php foreach($DADES as $D): ?>
      		
      		<?php $DATA = $D['DATA']; ?>
			<?php $DATA_ANT = ($DATA_ANT == -2)?$D['DATA']:$DATA_ANT; ?>      		      		
      		<?php if($DATA <> $DATA_ANT): ?>
			<tr>
      			<td style="font-weight:bold; background:#F2EAEA;"><?php echo $DATA_ANT; ?></td>
      			<td colspan="4" style="font-weight:bold; background:#F2EAEA;"><?php echo $TOTAL ?></td>      			      			
      		</tr>				      		
      		<?php endif; ?>      		      			      			
      		<tr>
      			<td><?php echo $D['DATA'] ?></td>
      			<td><?php echo $D['IMPORT'] ?></td>
      			<td><?php echo $D['DNI'] ?></td>
      			<td><?php echo $D['NOM'] ?></td>
      			<td><?php echo $D['CURS'] ?></td>
      		</tr>
      		      		      		      		
      		<?php $DATA_ANT = $DATA; $TOTAL += $D['IMPORT']; ?>
      		
      		<?php endforeach; ?>        	      					
      	</TABLE>      
      </DIV>
      
<?php endif; ?>      
      
      
      <DIV STYLE="height:40px;"></DIV>
                
    </TD>    
 