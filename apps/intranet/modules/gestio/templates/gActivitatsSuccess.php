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
    
      <?php echo nice_form_tag('gestio/gActivitats',array('method'=>'post' , 'multipart'=>true )); ?>
    

  <?php IF ($CONSULTA): ?>

      <TABLE class="BOX">
        <TR><TD class="NOTICIA">                                                              
                <DIV class="TITOL">Cerca a les activitats </DIV>                
                <DIV class="CERCA"><?php echo input_tag('CERCA',$CERCA, array('size'=>'50%')).submit_tag('Cerca',array('name'=>'BCERCA')).' '.submit_tag('Nova activitat',array('name'=>'BNOU')); ?></DIV>                                                                 
              </TD>
        </TR>
      </TABLE>
      
    
      <TABLE class="BOX">
        <TR><TD class="NOTICIA">                
                <DIV class="TITOL">Calendari d'activitats<SPAN id="MESOS"> <?php echo getSelData( $CERCA , $PAGINA , $IDA , 'CC' , NULL , NULL , NULL , $DATAI );  ?></SPAN></DIV>
                <TABLE class="CALENDARI">
                <?php                 
                  
                  $DATA = explode("-",$DATAI);
                  $MES = intval($DATA[1]); 
                  $ANY = intval($DATA[0]);
                  echo llistaCalendariH($MES, $ANY , $CERCA , $CALENDARI , $DATAI , $PAGINA , $IDA , $ACCIO);                                              

                ?>
                </TABLE>                                                                  
            </TD>
        </TR>
      </TABLE>

  <?php ENDIF; IF( $NOU || $EDICIO && !$CICLES ): ?>
      
      <TABLE class="BOX">
        <TR><TD class="NOTICIA_MENU">                
                <TABLE CLASS="SUBMEN"><TR>
                  <TR><TD class="NOTICIA_MENU">
                  	<TABLE CLASS="SUBMEN">
                  		<TR><?php menu(1,$ACTIVITAT,$EDICIO); ?></TR>
                  	</TABLE>
                 </TD></TR>
                 </TABLE>
         </TD></TR>
        <TR><TD class="NOTICIA">                                                
                <?php echo input_hidden_tag('accio','S'); ?>
                <?php echo input_hidden_tag('IDA',$ACTIVITAT->getActivitatid()); ?>
                <TABLE class="DADES">
                  <?php if(isset($ERRORS)) echo '<TR><TD class="ERRORS" colspan="2">'.implode("<br />",$ERRORS).'</TD>'; ?>
                  <TR><TD class="LINIA"> Nom </TD><TD> <?=input_tag('NOM',$ACTIVITAT->getNom()); ?> </TD>
                  <TR><TD class="LINIA"> Estat </TD><TD><?=select_tag('ESTAT',options_for_select(array('P'=>'PreReserva','A'=>'Activa')),$ACTIVITAT->getEstat()); ?></TD>
                  <TR><TD class="LINIA"> Projecte </TD><TD><?=select_tag('CICLE',options_for_select(CiclesPeer::getSelect()),$ACTIVITAT->getCiclesCicleid()); ?></TD>
                  <TR><TD class="LINIA"> Format </TD><TD><?=select_tag('TIPUS',options_for_select(TipusactivitatPeer::getSelect(),$ACTIVITAT->getTipusactivitatIdtipusactivitat())); ?></TD>                  
                  <TR><TD class="LINIA"> Preu </TD><TD> <?=input_tag('PREU',$ACTIVITAT->getPreu()); ?> </TD>
                  <TR><TD class="LINIA"> Preu reduït </TD><TD> <?=input_tag('PREUREDUIT',$ACTIVITAT->getPreureduit()); ?> </TD>
                  <TR><TD class="LINIA"> Publicable </TD><TD> <?=checkbox_tag('PUBLICABLE',true,$ACTIVITAT->getPublicable()); ?> </TD>                                   
                  <TR><TD class="LINIA"></TD><TD><?php echo submit_tag('GUARDA',array('name'=>'BGUARDAA')); ?> </TD>                                              
                </TABLE>                                          
              </TD>
        </TR>
      </TABLE>
    
    
  <?php ELSEIF( $HORARIS ): ?>    

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
      
            
      
  <?php ELSEIF( $TEXTOS ): ?>
      
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

  <?php ELSEIF( $CICLES ): ?>
      
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
    
  <?php ELSEIF( $LLISTA ): ?>

      <TABLE class="BOX">
        <TR><TD class="NOTICIA">                
                <DIV class="TITOL">Llistat d'activitats</DIV>
                <TABLE class="DADES">
                <?php                 

                  if(sizeof($ACTIVITATS) == 0):
                    echo '<TR><TD class="LINIA" colspan="5">No s\'ha trobat cap activitat.</TD></TR>'; 
                  endif;
                  
                  $i = 1;
                  foreach($ACTIVITATS as $A):      					                 
                  	if($i > 10*($PAGINA-1) && $i <= (10*($PAGINA-1)+10)  ):
                  		$AVIS = ""; $ESP = ""; $MAT = "";	
                  		if(!empty($A['ESPAIS'])) $ESP = implode("<br />",$A['ESPAIS']);
                  		if(!empty($A['MATERIAL'])) $MAT = implode("<br />",$A['MATERIAL']);                  		 
                  		if(strlen($A['AVIS'])>2) { $AVIS = link_to( image_tag('tango/32x32/emblems/emblem-important.png', array('size'=>'16x16')).'<span>'.$A['AVIS'].'</span>',"#",array('class'=>'tt2')); } else { $AVIS = ""; }                     
                  		echo '<TR>';                      	
	                  	echo '<TD class="LINIA">'.link_to($A['NOM_ACTIVITAT'],'gestio/gActivitats'.getPar($CERCA , $PAGINA , $A['ID'] , 'E' , null , null , null , $DATAI )).$AVIS.'</TD>';
	                    echo '<TD class="LINIA">'.$A['DIA'].'</TD>';
	                  	echo '<TD class="LINIA">'.$A['HORA_INICI'].'</TD>';
	                    echo '<TD class="LINIA">'.$ESP.'</TD>';
	                    echo '<TD class="LINIA">'.$MAT.'</TD>';						            
	                    echo '</TR>';
                    endif;
                    $i++;
                  endforeach;   
                  $sof = sizeof($ACTIVITATS);
                  $TALL = intval($sof/20)+1;
                  if($TALL > 1):
	                  echo '<TR><TD class="LINIA" colspan="5" align="CENTER">';	                                                     
	                  for($i = 1; $i < $TALL ; $i++ ):
	                  	echo link_to("pàg ".$i." - ",'gestio/gActivitats'.getPar($CERCA , $i , $IDA , 'C' , $ANY , $MES , NULL , $DATAI ));                  	
	                  endfor;
                  	echo '</TD></TR>';
                  endif;
                ?>
                </TABLE>                                                                  
            </TD>
        </TR>
      </TABLE>

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

function menu($seleccionat = 1,$ACTIVITAT,$edicio = true)
{     
      if($edicio): 
	    if($seleccionat == 1) echo '<TD class="SUBMEN1">'.link_to('Dades activitat','gestio/gActivitats?accio=E&IDA='.$ACTIVITAT->getActivitatid()).'</TD>';
	    else  echo '<TD class="SUBMEN">'.link_to('Dades activitat','gestio/gActivitats?accio=E&IDA='.$ACTIVITAT->getActivitatid()).'</TD>';             
        if($seleccionat == 2) echo '<TD class="SUBMEN1">'.link_to('Horaris','gestio/gActivitats?accio=H&IDA='.$ACTIVITAT->getActivitatid()).'</TD>';
        else echo '<TD class="SUBMEN">'.link_to('Horaris','gestio/gActivitats?accio=H&IDA='.$ACTIVITAT->getActivitatid()).'</TD>';
        if($seleccionat == 3) echo '<TD class="SUBMEN1">'.link_to('Descripció','gestio/gActivitats?accio=T&IDA='.$ACTIVITAT->getActivitatid()).'</TD>';
        else echo '<TD class="SUBMEN">'.link_to('Descripció','gestio/gActivitats?accio=T&IDA='.$ACTIVITAT->getActivitatid()).'</TD>';
        if($seleccionat == 4) echo '<TD class="SUBMEN1">'.link_to('Cicles','gestio/gActivitats?accio=AC&IDA='.$ACTIVITAT->getActivitatid()).'</TD>';
        else echo '<TD class="SUBMEN">'.link_to('Cicles','gestio/gActivitats?accio=AC&IDA='.$ACTIVITAT->getActivitatid()).'</TD>';        
      else:
        if($seleccionat == 1) echo '<TD class="SUBMEN1">'.link_to('Dades activitat','gestio/gActivitats?accio=N').'</TD>';
	    else  echo '<TD class="SUBMEN">'.link_to('Dades activitat','gestio/gActivitats?accio=N').'</TD>';
	    if($seleccionat == 4) echo '<TD class="SUBMEN1">'.link_to('Cicles','gestio/gActivitats?accio=AC').'</TD>';
        else echo '<TD class="SUBMEN">'.link_to('Cicles','gestio/gActivitats?accio=AC').'</TD>';                             
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


  function llistaCalendariH($mes = null, $year = null, $CERCA = NULL, $CALENDARI = NULL, $DATAI = NULL, $PAGINA , $IDA , $ACCIO )
  {
    
    //Agafo un mes... marco els dies blanc i començo a escriure
    if($mes==null) $mes = date("m",time());
    if($year == NULL) $year = date('Y',time());        
    $mesI = $mes; $any = $year;
    $mesF = date('m',mktime(0,0,0,$mes+3,1,$year));
    if($mesF > 12) $mesF = $mesF-12;      
         
    $RET = "<TR><TD></TD>";
    for($i = 6; $i>0; $i--):
      $RET .= "<TD>Dll</TD><TD>Dm</TD><TD>Dc</TD><TD>Dj</TD><TD>Dv</TD><TD>Ds</TD><TD>Dg</TD>";
    endfor;
    $RET .= "</TR>";
    
    for($mes = $mesI; $mes < $mesF; $mes++):
      
      $dies = cal_days_in_month(CAL_GREGORIAN, $mes, $any );                            //Mirem quants dies té el mes      
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
          
          $CalDia = date('Y-m-d',mktime(0,0,0,$mes,$diaA,$any));
          $SPAN = ""; $color = "";
          
          if(isset($CALENDARI[$CalDia])) { $SELECCIONAT = "SELECCIONAT";
            $SPAN  = '<span>';				 
          	foreach($CALENDARI[$CalDia] as $CAL) $SPAN .= $CAL['HORA'].' - '.$CAL['TITOL'].'<br />';          		                    	          	
            $SPAN .= '</span>';
          } else { $SELECCIONAT = ""; }
                                        
          $RET .= '<TD class="DIES" style="background-color:'.$background.';">'.link_to($diaA.$SPAN,"gestio/gActivitats".getPar($CERCA , $PAGINA , $IDA , 'C' , $any , $mes , $diaA , $DATAI ) , array('class'=>"tt2 $SELECCIONAT")).'</TD>';
          
        endif;    
      endfor;
      $RET .= "</TR>";
      
      if($mes == 12) $any = $any+1;
    endfor;
          
    return $RET;
      
  }

  function getSelData($CERCA = NULL, $PAGINA = NULL, $IDA = NULL, $ACCIO = NULL , $ANY = NULL , $MES = NULL , $DIA = NULL , $DATAI = NULL)
  {
  	 $DATA = explode("-",$DATAI);
     $MES = intval($DATA[1]); 
     $ANY = intval($DATA[0]);     
     
     $RET = "";
     $RET = link_to($ANY-1,'gestio/gActivitats'.getPar($CERCA , $PAGINA , $IDA , $ACCIO , $ANY , $MES , $DIA , date('Y-m-d',mktime(0,0,0,1,1,$ANY-1))),array('class'=>'black'))." ";
     for($any = $ANY ; $any < $ANY+2 ; $any++ ):
     	$RET .= link_to($any,'gestio/gActivitats'.getPar($CERCA , $PAGINA , $IDA , $ACCIO , $ANY , $MES , $DIA , date('Y-m-d',mktime(0,0,0,1,1,$any))),array('class'=>'black'))." ";
     	for($mes = 1; $mes < 13; $mes++):
     		$RET .= link_to(mesosSimplificats($mes),"gestio/gActivitats".getPar($CERCA , $PAGINA , $IDA , $ACCIO , $ANY , $MES , $DIA , date('Y-m-d',mktime(0,0,0,$mes,1,$any)) ),array('class'=>'black'))." ";
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