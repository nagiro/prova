<?php use_helper('Form') ?>
<?php use_helper('Javascript')?>
<STYLE>
.CALENDARI { font-size: 8px; }
.CALENDARI A { text-decoration:none; color:black; }
.CALENDARI A:hover { text-decoration:none; color:black; font-weight: bolder; }
.CALENDARI A:visited {text-decoration:none; color:black; }
.CALENDARI TD { font-size:10px; text-align: left; padding:1px; }
.LINIA_ERROR { background-color: rgb(255,196,196); }
.HORA { width:80px;}
.CENT { width:50%; }
#CENT { width:100%; } 
#DEU { width:10%; }
#FDATA { width:80px; }
#MESOS { font-weight:normal; border: 3px solid #F3F3F3; background-color:#FAFAFA; margin-left:5px; }
.DIES { font-size: 10px;  }
.SELECCIONAT { font-weight:bold; }

</STYLE>
   
    <TD colspan="3" class="CONTINGUT">
       
  <?php IF ($MODE['CONSULTA']): ?>

	<form action="<?php echo url_for('gestio/gActivitats') ?>" method="POST">
	    <DIV class="REQUADRE">
	    	<table class="FORMULARI">          
	            <?php echo $FCerca ?>
	            <tr>
	            	<td colspan="2">
	            		<input type="submit" name="BCERCA" value="Prem per buscar" />
	            		<input type="submit" name="BNOU" value="Nova activitat" />
	            	</td>
	            </tr>
	        </table>
	     </DIV>
     </form>  
      
    
      <TABLE class="BOX">
        <TR><TD class="NOTICIA">                
                <DIV class="TITOL">Calendari d'activitats<SPAN id="MESOS"> <?php echo getSelData($DATAI);  ?></SPAN></DIV>
                <TABLE class="CALENDARI">
                <?php                 
                  
                  echo llistaCalendariH($DATAI,$CALENDARI);                                              

                ?>
                </TABLE>                                                                  
            </TD>
        </TR>
      </TABLE>

  <?php ENDIF; IF( $MODE['NOU'] || $MODE['EDICIO'] && !$MODE['CICLES'] ): ?>
      
     <form action="<?php echo url_for('gestio/gActivitats') ?>" method="POST">            
	 	<div class="REQUADRE">
	 		<div class="MENU"><?php menu(1,$MODE['EDICIO']); ?></div>	 		
	    	<table class="FORMULARI" width="600px">                  			    	
	    	<tr><td width="100px"></td><td width="500px"></td></tr>
                <?=$FActivitat?>                								
                <tr>
                	<td></td>
	            	<td colspan="2" class="dreta">
	            		<br>	            		
	            		<?=submit_image_tag('icons/Colored/PNG/action_check.png',array('value'=>'Guarda','name'=>'BSAVEACTIVITAT'))?>
	            		<?=link_to(image_tag('icons/Colored/PNG/action_delete.png'),'gestio/gCursos',array('name'=>'BDELETE','confirm'=>'Segur que vols esborrar-lo?'))?>
	            	</td>
	            </tr>                	 
      		</table>      		
      	</div>
     </form>         
    
  <?php ELSEIF( $MODE['HORARIS'] ): ?>
  
	<DIV class="REQUADRE">
		<DIV class="TITOL">Horaris actuals</DIV>
      	<TABLE class="DADES">
 			<? if( sizeof($HORARIS) == 0 ): echo '<TR><TD class="LINIA">Aquesta activitat no té cap horari definit.</TD></TR>'; endif; ?>  
			<? foreach($HORARIS as $H): $M = $H->getHorarisespaissJoinMaterial(); $HE = $H->getHorarisespaissJoinEspais(); ?>			
				<TR>
					<TD class="<?php $PAR ?>" width=""><?=link_to($H->getHorarisid(),'gestio/gActivitats?IDH='.$H->getHorarisid())?></TD>
					<TD class="<?php $PAR ?>" width=""><?=$H->getDia('d/m/Y')?></TD>
					<TD class="<?php $PAR ?>" width=""><?=$H->getHorapre('H:m') ?></TD>
					<TD class="<?php $PAR ?>" width=""><?=$H->getHorainici('H:m') ?></TD>
					<TD class="<?php $PAR ?>" width=""><?=$H->getHorafi('H:m') ?></TD>
					<TD class="<?php $PAR ?>" width=""><?=$H->getHorapost('H:m') ?></TD>
					<TD class="<?php $PAR ?>" width=""><? foreach($HE as $HESPAI) { if(is_object($HESPAI->getEspais())) echo $HESPAI->getEspais()->getNom().'<br />'; } ?></TD>
					<TD class="<?php $PAR ?>" width=""><? foreach($M as $MATERIAL) { if(is_object($MATERIAL->getMaterial())) echo $MATERIAL->getMaterial()->getNom().'<br />'; } ?></TD>
				</TR>
			<? endforeach; ?>                        	
    	</TABLE>      
	</DIV>

     <form action="<?php echo url_for('gestio/gActivitats') ?>" method="POST">            
	 	<div class="REQUADRE">	 		
	 		<DIV class="TITOL">Edició horaris</DIV>
	    	<table class="FORMULARI" width="550x">                  			    	
	    	<tr><td width="100px"></td><td width="450x"></td></tr>
               	<?=$FHorari?>
                <tr>
                	<td></td>
	            	<td colspan="2" class="dreta">
	            		<br>	            		
	            		<?=submit_image_tag('icons/Colored/PNG/action_check.png',array('value'=>'Guarda','name'=>'BSAVEACTIVITAT'))?>
	            		<?=link_to(image_tag('icons/Colored/PNG/action_delete.png'),'gestio/gCursos',array('name'=>'BDELETE','confirm'=>'Segur que vols esborrar-lo?'))?>
	            	</td>
	            </tr>                	 
      		</table>      		
      	</div>
     </form>         
  
  
      
  <?php ELSEIF( $MODE['HORARIS2'] ): ?>    

	<TABLE class="BOX">
        <TR><TD class="NOTICIA">                
                <DIV class="TITOL">Gestor d'horaris</DIV>
                <TABLE class="NOTICIA" width="100%">
                <?php
                     if(!empty($ERRORS)):
	                     echo '<TR>';
	                     echo "<TD class=\"ERRORS LINIA_ERROR\" colspan=\"8\">"; foreach($ERRORS as $E){ echo $E.'<BR />'; } echo '</TD>';
	                     echo '</TR>';   
	                 endif;          
                 ?>
                  <TR>
                  	<TD colspan="4" class="TITOL">Avís<BR /><?php echo input_tag('D[AVIS]',$D['AVIS'],array('style'=>"width:400px;")); ?></TD>
                  	<TD colspan="1" class="TITOL">Espectadors<BR><?php echo input_tag('D[ESPECTADORS]',$D['ESPECTADORS'],array('style'=>"width:40px;")); ?></TD></TR>
                  <TR>
                  	<TD class="TITOL">Dia</TD>
                  	<TD class="TITOL">Muntatge</TD>
                  	<TD class="TITOL">Inici</TD>
                  	<TD class="TITOL">Finalització</TD>
                  	<TD class="TITOL">Desmuntatge</TD>
                  </TR>
                  <TR>
                    <TD class="LINIA">
                    	<input type="text" name="D[DIA]" id="calendari" value="<?php echo $D['DIA']; ?>" size="12" style="width:80px;" /><button type="button" disabled=disabled onclick="return false" id="trigger">...</button>
                    	<!-- <?php input_date_tag('hola','',array('rich'=>true)); ?> Això només hi és per a què carregui el jscalendar :D -->                    
					</TD>
					<TD class="LINIA"><?php echo input_tag('D[HORAPRE]',$D['HORAPRE'],array('style'=>"width:40px;")); ?> </TD>
					<TD class="LINIA"><?php echo input_tag('D[HORAIN]',$D['HORAIN'],array('style'=>"width:40px;")); ?> </TD>
					<TD class="LINIA"><?php echo input_tag('D[HORAFI]',$D['HORAFI'],array('style'=>"width:40px;")); ?> </TD>
					<TD class="LINIA"><?php echo input_tag('D[HORAPOST]',$D['HORAPOST'],array('style'=>"width:40px;")); ?></TD>
				  </TR>
				  <TR>
					<TD class="TITOL" colspan="2">Espais</TD><TD class="TITOL" colspan="3">Material</TD>
				  </TR>
				  <TR>                    					
                    	<?php

                    	   echo '<TD colspan="2" class="LINIA" id="field">';
                    	   
                    	   //Guardem l'idH si n'hi ha per saber que hem fet una edició
                    	   if(!empty($D['idH'])) echo input_hidden_tag('D[idH]',$D['idH']);
                    	   
                    	   $OFS = EspaisPeer::select();
                    	               	
                    	   for( $i=0 ; $i < sizeof($D['ESPAIS']) ; $i++ ):                    			 
						      echo select_tag("D[ESPAIS][$i]" , options_for_select($OFS , $D['ESPAIS'][$i] , array('include_blank' => true)) , array('multiple'=>false , 'class'=>'CENT')).'<BR>'; 
						   endfor;							
						   if(!empty($D['ESPAIS'])) echo select_tag("D[ESPAIS][$i]" , options_for_select($OFS , NULL , array('include_blank' => true)) , array('multiple'=>false , 'class'=>'CENT')).'<BR>';
						   else echo select_tag("D[ESPAIS][$i]" , options_for_select($OFS , NULL , array('include_blank' => true)) , array('multiple'=>false , 'class'=>'CENT')).'<BR>';
							
						   echo '</TD>';					                    
							
		                   echo '<TD colspan="3" class="LINIA">';
		                   $OFS = MaterialgenericPeer::selectMaterial();
		                   for( $i=0 ; $i < sizeof($D['MATERIAL']) ; $i++ ):                    			 
						      echo select_tag("D[MATERIAL][$i]" , options_for_select($OFS , $D['MATERIAL'][$i] , array('include_blank' => true)) , array('multiple'=>false , 'class'=>'CENT')).'<BR>'; 
						   endfor;
						   if(!empty($D['MATERIAL'])) echo select_tag("D[MATERIAL][$i]" , options_for_select($OFS , NULL , array('include_blank' => true)) , array('multiple'=>false , 'class'=>'CENT')).'<BR>';
						   else echo select_tag("D[MATERIAL][$i]" , options_for_select($OFS , NULL , array('include_blank' => true)) , array('multiple'=>false , 'class'=>'CENT')).'<BR>'; 							
						   echo '</TD>';
						                       							
						?>
                  </TR>                  
                  <TR><TD colspan="5"><?php 
                  				echo submit_tag('+',array('name'=>'BAFEGIRESPAI'));
                                echo submit_tag('Verifica',array('name'=>'BVERIFICA'));
                                if(isset($D['idH'])) echo submit_tag('Elimina',array('name'=>'BELIMINA'));
                      ?></TD></TR>
                </TABLE>                                                                  
            </TD>
        </TR>
      </TABLE>

      
      <TABLE class="BOX">
                <TR><TD class="NOTICIA_MENU"><TABLE CLASS="SUBMEN"><TR><?php menu(2,$ACTIVITAT); ?></TR></table></TD></TR>                
        <TR><TD class="NOTICIA">
        	    <?php echo input_hidden_tag('accio','VH'); ?>
                <?php echo input_hidden_tag('IDA',$IDA); ?>
                <TABLE class="DADES">
                  <?php 
                          
                      $i = 0;
                      foreach($LINIES as $K=>$L):
                                                                        
                          if(isset($L['idH'])) echo input_hidden_tag("L[$i][idH]",$L['idH']);
                          echo input_hidden_tag("L[$i][DIA]",$L['DIA']);
                          echo input_hidden_tag("L[$i][HORAPRE]",$L['HORAPRE']);
                          echo input_hidden_tag("L[$i][HORAIN]",$L['HORAIN']);
                          echo input_hidden_tag("L[$i][HORAFI]",$L['HORAFI']);
                          echo input_hidden_tag("L[$i][HORAPOST]",$L['HORAPOST']);
                          echo input_hidden_tag("L[$i][AVIS]",$L['AVIS']);
                          echo input_hidden_tag("L[$i][ESPECTADORS]",$L['ESPECTADORS']);
                          foreach($L['ESPAIS'] AS $E) { echo input_hidden_tag("L[$i][ESPAIS][]",$E); }                          
                          foreach($L['MATERIAL'] as $M) { echo input_hidden_tag("L[$i][MATERIAL][]",$M); }                                                                                                                             
                                                                                                                                    
                          $class = "LINIA";
                          echo '<TR>';                          
                          
                          echo "<TD class=\"$class\">".$L['DIA'].'</TD>';
                          echo "<TD class=\"$class\">".$L['HORAPRE'].'</TD>';
                          echo "<TD class=\"$class\">".$L['HORAIN'].'</TD>';
                          echo "<TD class=\"$class\">".$L['HORAFI'].'</TD>';
                          echo "<TD class=\"$class\">".$L['HORAPOST'].'</TD>';
                          echo "<TD class=\"$class\">"; foreach($L['ESPAIS'] AS $E) { if($E>0) echo EspaisPeer::retrieveByPK($E)->getNom(); echo "<BR />"; } echo '</TD>';                          
                          echo "<TD class=\"$class\">"; foreach($L['MATERIAL'] as $M) { if($M>0) echo MaterialPeer::retrieveByPK($M)->getNom(); echo "<br />"; } echo '</TD>';
                          echo "<TD class=\"$class\">"; echo radiobutton_tag("REDICIO",$i,($REDICIO==$i)?true:false); echo '</TD>';                                                                                  
                          echo '</TR>';                        
                          
                          $i++;                                                                                              
                                                                                              
                      endforeach;                      
                  ?>        
                       
                       
                       <TR><TD class="LINIA" colspan="7"><?php echo submit_tag('FINALITZA',array('name'=>'BGUARDAH','width'=>'100%')); ?></TD>
                       	   <TD class="LINIA" colspan="1"><?php echo submit_tag('Edita',array('name'=>'BEDITAH','style'=>'width:50px')); ?></TD>
                       </TR>                                                                                                             
                </TABLE>                                          
              </TD>
        </TR>
      </TABLE>
      
            
      
  <?php ELSEIF( $MODE['TEXTOS'] ): ?>
      
      <?php echo input_hidden_tag('IDA',$IDA); ?>
      <TABLE class="BOX">
        <TR><TD class="NOTICIA_MENU"><TABLE CLASS="SUBMEN"><TR><?php menu(3,$ACTIVITAT); ?></TR></table></TD></TR>
            <TR><TD class="NOTICIA">                
                <TABLE>
                <?php
                	$URL =  $ACTIVITAT->getImatge(); $URL2 = $ACTIVITAT->getPdf();
                	$IMATGE = link_to_if( $URL != NULL , "arxiu" , image_path('noticies/'.$URL , true ) , array('target'=>'_NEW') );
                	$PDF    = link_to_if( $URL2 != NULL , "arxiu" ,  image_path('noticies/'.$URL2 , true )  , array('target'=>'_NEW') );                	                	
                ?>
                	
                <TR>
                	<TD class="TITOL"><CENTER>Activa Notícia<br /><?php echo checkbox_tag('PUBLICA',true,$ACTIVITAT->getPublicaweb()) ?></CENTER></TD>                	
                	<TD class="TITOL">Imatge<?php echo ' ('.$IMATGE.')<br>'.input_file_tag('IMATGE'); ?></TD>                	
                	<TD class="TITOL">PDF<?php echo ' ('.$PDF.')<br>'.input_file_tag('PDF'); ?></TD>
                </TR>
                <TR><TD class="TITOL" colspan="3">Text notícies</TD></TR>
                <TR><TD colspan="3"><?php echo input_tag('TITOL_NOTICIA',$ACTIVITAT->getTnoticia(),array('class'=>'cent')); ?></TD></TR>
                <TR><TD colspan="3"><?php echo textarea_tag('TEXT_NOTICIA',$ACTIVITAT->getDnoticia(),array('rich'=>true, 'size'=>'100%x10' , 'tinymce_options'=>' theme:"simple"')); ?></TD></TR>

				<TR><TD class="TITOL" colspan="3">Text web</TD></TR>
				<TR><TD colspan="3"><?php echo input_tag('TITOL_WEB',$ACTIVITAT->getTweb(),array('class'=>'cent')); ?></TD></TR>
                <TR><TD colspan="3"><?php echo textarea_tag('TEXT_WEB',$ACTIVITAT->getDweb(),array('rich'=>true, 'size'=>'100%x10' , 'tinymce_options'=>' theme:"simple"')); ?></TD></TR>
                
                <TR><TD class="TITOL" colspan="3">Text general</TD></TR>
                <TR><TD colspan="3"><?php echo input_tag('TITOL_GENERAL',$ACTIVITAT->getTgeneral(),array('class'=>'cent')); ?></TD></TR>
                <TR><TD colspan="3"><?php echo textarea_tag('TEXT_GENERAL',$ACTIVITAT->getDgeneral(),array('rich'=>true, 'size'=>'100%x10' , 'tinymce_options'=>' theme:"simple"')); ?></TD></TR>

                <TR><TD colspan="3"><?php echo submit_tag('Guarda',array('name'=>'BGUARDAT')); ?></TD></TR>
                </TABLE>                                                                                                  
            </TD>
        </TR>
      </TABLE>

  <?php ELSEIF( $MODE['CICLES'] ): ?>
      
      <?php echo input_hidden_tag('IDA',$IDA); ?>
      <TABLE class="BOX">
        <TR><TD class="NOTICIA_MENU"><TABLE CLASS="SUBMEN"><TR><?php menu(4,$ACTIVITAT,$EDICIO); ?></TR></table></TD></TR>
            <TR><TD class="NOTICIA">                
                <TABLE class="DADES">
                <?php
                   echo '<TR><TD class="TITOL">NOM</TD><TD class="TITOL">DESCRIPCIO</TD></TR>';
                   foreach($LLISTA_CICLES as $C):
                      
                      echo '<TR><TD class="LINIA">'.$C->getNom().'</TD><TD class="LINIA">'.$C->getDescripcio().'</TD></TR>';
                   
                   endforeach;
                   echo '<TR><TD class="LINIA">'.input_tag('NOM',$CICLE->getNom()).'</TD><TD class="LINIA">'.input_tag('DESCRIPCIO',$CICLE->getDescripcio()).'</TD></TR>';
                   echo '</TABLE>';
                   echo submit_tag('Afegir cicle',array('name'=>'BCICLESAVE'));                   
                  ?>                                                                
            </TD>
        </TR>
      </TABLE>      
    
  <?php ELSEIF( $MODE['LLISTA'] ): ?>


     <DIV class="REQUADRE">
        <DIV class="TITOL">Llistat d'activitats </DIV>
      	<TABLE class="DADES">
 			<? if( sizeof($ACTIVITATS) == 0 ): echo '<TR><TD class="LINIA">No s\'ha trobat cap activitat.</TD></TR>'; endif; ?>
 			<?php $i = 0; $j=0; $Tall = 10; ?> 			   			
			<? foreach($ACTIVITATS as $A):			
                  if($i >= $Tall*($PAGINA-1) && $i < ($Tall*($PAGINA-1)+$Tall)  ):
                    
                  	$AVIS = ""; $ESP = ""; $MAT = "";	
                  	if(!empty($A['ESPAIS'])) $ESP = implode("<br />",$A['ESPAIS']);
                  	if(!empty($A['MATERIAL'])) $MAT = implode("<br />",$A['MATERIAL']);                  		 
                  	if(strlen($A['AVIS'])>2) { $AVIS = '<a href="#" class="tt2">'.image_tag('tango/32x32/emblems/emblem-important.png', array('size'=>'16x16')).'<span>'.$A['AVIS'].'</span></a>'; } else { $AVIS = ""; }
                  	$PAR = ParImpar($j++);                  	
                  	?>                     
                  	<TR>                      	
	               		<TD class="<?=$PAR?>"><?=link_to($A['NOM_ACTIVITAT'],'gestio/gActivitats?accio=CA&IDA='.$A['ID']).$AVIS ?> </TD>
	                	<TD class="<?=$PAR?>"> <?=$A['DIA']?> </TD>
	               		<TD class="<?=$PAR?>"> <?=$A['HORA_INICI']?> </TD>
	                	<TD class="<?=$PAR?>"> <?=$ESP?> </TD>
	                	<TD class="<?=$PAR?>"> <?=$MAT?> </TD>						            
	                </TR>
                   <? endif;
                   $i++;
			 endforeach; 
			 
			 $sof = sizeof($ACTIVITATS);			 
                  $TALL = intval($sof/$Tall)+1;                  
                  if($TALL > 1):
	                  ?><TR><TD class="LINIA" colspan="5" align="CENTER"><?	                                                     
	                  for($i = 1; $i <= $TALL ; $i++ ):
	                  	echo link_to("pàg ".$i." - ",'gestio/gActivitats?PAGINA='.$i);                  	
	                  endfor;
                  	 ?></TD></TR><?
                  endif;
                ?>            	
      	</TABLE>      
      </DIV>

  <?php ENDIF; ?>
  
      <DIV STYLE="height:40px;"></DIV>
                
<!--  </TD> -->        
    
<!-- FI CONTINGUT -->
<!-- CALENDARI -->
 <!-- >
    <TD class="CALENDARI">          
      
    </TD>
-->
<!-- FI CALENDARI -->

<?php 

function menu($seleccionat = 1,$edicio = true)
{     
      if($edicio): 
	    if($seleccionat == 1) echo '<SPAN class="SUBMEN1">'.link_to('Dades activitat','gestio/gActivitats?accio=CA').'</SPAN>';
	    else  echo '<SPAN class="SUBMEN">'.link_to('Dades activitat','gestio/gActivitats?accio=CA').'</SPAN>';             
        if($seleccionat == 2) echo '<TD class="SUBMEN1">'.link_to('Horaris','gestio/gActivitats?accio=CH').'</SPAN>';
        else echo '<SPAN class="SUBMEN">'.link_to('Horaris','gestio/gActivitats?accio=CH').'</SPAN>';
        if($seleccionat == 3) echo '<TD class="SUBMEN1">'.link_to('Descripció','gestio/gActivitats?accio=T').'</SPAN>';
        else echo '<SPAN class="SUBMEN">'.link_to('Descripció','gestio/gActivitats?accio=T').'</SPAN>';
        if($seleccionat == 4) echo '<TD class="SUBMEN1">'.link_to('Cicles','gestio/gActivitats?accio=AC').'</SPAN>';
        else echo '<SPAN class="SUBMEN">'.link_to('Cicles','gestio/gActivitats?accio=AC').'</SPAN>';        
      else:
        if($seleccionat == 1) echo '<TD class="SUBMEN1">'.link_to('Dades activitat','gestio/gActivitats?accio=N').'</SPAN>';
	    else  echo '<SPAN class="SUBMEN">'.link_to('Dades activitat','gestio/gActivitats?accio=N').'</SPAN>';
	    if($seleccionat == 4) echo '<TD class="SUBMEN1">'.link_to('Cicles','gestio/gActivitats?accio=AC').'</SPAN>';
        else echo '<SPAN class="SUBMEN">'.link_to('Cicles','gestio/gActivitats?accio=AC').'</SPAN>';                             
      endif;
}


function getPar($CERCA = NULL, $PAGINA = NULL, $IDA = NULL, $ACCIO = NULL , $ANY = NULL , $MES = NULL , $DIA = NULL , $DATAI = NULL )
{
    $A = "";
    if(!is_null($CERCA) && !empty($CERCA))    $A[] = 'CERCA='.$CERCA;
    if(!is_null($PAGINA))   $A[] = 'PAGINA='.$PAGINA;
    if(!is_null($IDA))      $A[] = 'IDA='.$IDA;
    if(!is_null($ACCIO))    $A[] = 'accio='.$ACCIO;
    if(!is_null($ANY))      $A[] = 'ANY='.$ANY;
    if(!is_null($MES))      $A[] = 'MES='.$MES;
    if(!is_null($DIA))      $A[] = 'DIA='.$DIA;    
    if(!is_null($DATAI))    $A[] = 'DATAI='.$DATAI;
    if(!empty($A)) return '?'.implode('&',$A); 
    else return '';
    
}


  function llistaCalendariH($DATAI, $CALENDARI)
  {
    
    //Inicialitzem variables i marquem els dies en blanc
    $mes  = date('m',$DATAI);
    $year = date('Y',$DATAI);
              
    $mesI = $mes; $any = $year;
    $mesF = date('m',mktime(0,0,0,$mes+3,1,$year));
    if($mesF > 12) $mesF = $mesF-12;      
         
    $RET = "<TR><TD></TD>";
    for($i = 6; $i>0; $i--):
      $RET .= "<TD>Dll</TD><TD>Dm</TD><TD>Dc</TD><TD>Dj</TD><TD>Dv</TD><TD>Ds</TD><TD>Dg</TD>";
    endfor;
    $RET .= "</TR>";
    
    for($mes = $mesI; $mes < $mesF; $mes++):
      
      $dies = cal_days_in_month(CAL_GREGORIAN, $mes, $any );                           //Mirem quants dies té el mes      
      $diaSetmana = jddayofweek(cal_to_jd(CAL_GREGORIAN, $mes , 1 , $any) , 0 );       //Marquem quants blancs volem tenir      
      if($diaSetmana == 0) $blancs = 6-1; else  $blancs = $diaSetmana-2;
      
      if($mes % 2) $background = "beige"; else $background = "white";                   //Mirem el color del fons
      $RET .= "<TR><TD>".mesos($mes)."</TD>";
      
      //Bucle de pintar dies
      
      for($dia = 0; $dia < 40; $dia++):                                             //Generem el calendari
        $diaA = $dia-$blancs;
        if($dia <= $blancs || $diaA > $dies):                                        //Si és blanc el marquem com a tal i si el dia ha passat el màxim de dies del mes no el marquem
          $RET .= "<TD></TD>";
        else:                                  
          $diaSetmana = jddayofweek(cal_to_jd(CAL_GREGORIAN, $mes , $diaA , $any) , 0 );
          if( $diaSetmana == 6 || $diaSetmana == 0) $background="beige"; else $background = "white"; 
          
          $CalDia = mktime(0,0,0,$mes,$diaA,$any);
          $SPAN = ""; $color = "";
          
          if(isset($CALENDARI[$CalDia])) { $SELECCIONAT = "SELECCIONAT";
            $SPAN  = '<span>';				 
          	foreach($CALENDARI[$CalDia] as $CAL) $SPAN .= $CAL['HORA'].' - '.$CAL['TITOL'].'<br />';          		                    	          	
            $SPAN .= '</span>';
          } else { $SELECCIONAT = ""; }
                                        
          $RET .= '<TD class="DIES" style="background-color:'.$background.';">'.link_to($diaA.$SPAN,"gestio/gActivitats?accio=CD&DIA=".$CalDia , array('class'=>"tt2 $SELECCIONAT")).'</TD>';
          
        endif;    
      endfor;
      $RET .= "</TR>";
      
      if($mes == 12) $any = $any+1;
    endfor;
          
    return $RET;
      
  }

  function ParImpar($i)
{
	if($i % 2 == 0) return "PAR";
	else return "IPAR";
}
  
  
  /**
   * A partir d'una DataI generem els enllaços del menú
   * @param time() $DATAI
   * @return string
   */
  
  function getSelData($DATAI = NULL)
  {

     $MES = date('m',$DATAI); 
     $ANY = date('Y',$DATAI);            
     
     $RET = "";
     $RET = link_to($ANY-1,'gestio/gActivitats?DATAI='.mktime(0,0,0,1,1,$ANY-1),array('class'=>'black'))." ";
     for($any = $ANY ; $any < $ANY+2 ; $any++ ):
     	$RET .= link_to($any,'gestio/gActivitats?DATAI='.mktime(0,0,0,1,1,$any),array('class'=>'black'))." ";
     	for($mes = 1; $mes < 13; $mes++):
     		$RET .= link_to(mesosSimplificats($mes),"gestio/gActivitats?DATAI=".mktime(0,0,0,$mes,1,$any),array('class'=>'black'))." ";
     	endfor;     
     endfor;
      
     return $RET;
     
  }
  
  function mesos($mes)  
  {
    switch($mes){
      case 1: $text = "Gener"; break;
      case 2: $text = "Febrer"; break;
      case 3: $text = "Març"; break;
      case 4: $text = "Abril"; break;
      case 5: $text = "Maig"; break;
      case 6: $text = "Juny"; break;
      case 7: $text = "Juliol"; break;
      case 8: $text = "Agost"; break;
      case 9: $text = "Setembre"; break;
      case 10: $text = "Octubre"; break;
      case 11: $text = "Novembre"; break;
      case 12: $text = "Desembre"; break;
    }
    
    return $text; //utf8_encode($text);
  
  }
  
  function mesosSimplificats($mes)  
  {
    switch($mes){
      case 1: $text = "G"; break;
      case 2: $text = "F"; break;
      case 3: $text = "M"; break;
      case 4: $text = "A"; break;
      case 5: $text = "M"; break;
      case 6: $text = "J"; break;
      case 7: $text = "J"; break;
      case 8: $text = "A"; break;
      case 9: $text = "S"; break;
      case 10: $text = "O"; break;
      case 11: $text = "N"; break;
      case 12: $text = "D"; break;
    }
    
    return utf8_encode($text);
  
  }
  

  function fletxeta()
  {    
    return image_tag('intranet/fletxeta.png',array('align'=>'ABSMIDDLE'));    
  }


?>

<script type="text/javascript">
  //
    // the default multiple dates selected, first time the calendar is instantiated
    var MA = [];

    function closed(cal) {

      // here we'll write the output; this is only for example.  You
      // will normally fill an input field or something with the dates.
      var el = document.getElementById("calendari");

      // reset initial content.
      el.innerHTML = "";
      el.value = "";
      // Reset the "MA", in case one triggers the calendar again.
      // CAREFUL!  You don't want to do "MA = [];".  We need to modify
      // the value of the current array, instead of creating a new one.
      // Calendar.setup is called only once! :-)  So be careful.
      MA.length = 0;

      // walk the calendar's multiple dates selection hash
      for (var i in cal.multiple) {
        var d = cal.multiple[i];
        // sometimes the date is not actually selected, that's why we need to check.
        if (d) {
          // OK, selected.  Fill an input field.  Or something.  Just for example,
          // we will display all selected dates in the element having the id "output".
          el.value += d.print("%Y-%m-%d") + " ";

          // and push it in the "MA", in case one triggers the calendar again.
          MA[MA.length] = d;
        }
      }
      cal.hide();
      return true;
    };

    document.getElementById("trigger").disabled = false;
    Calendar.setup({
      align      : " ",
      showOthers : true,
      multiple   : MA, // pass the initial or computed array of multiple dates to be initially selected
      onClose    : closed,
      button     : "trigger"
    });
  </script>