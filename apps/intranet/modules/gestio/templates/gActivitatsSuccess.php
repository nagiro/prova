<?php use_helper('Form') ?>
<?php $BASE = OptionsPeer::getString('SF_WEBROOT',1); ?>

<style>
	
    .col_horaris { float:left; padding:5px; font-size:11px; }
    .row_horaris { clear:both; width:600px; border-bottom: 1px solid gray; }
    .a_horaris { font-size:11px; }
	.row { width:600px; } 
	.row_field { width:500px; } 
	.row_title { width:100px; }
	.row_field input { width:100%; }
	input.ul_cat { background-color:white; border:0px; width:20px; }
	li.ul_cat { width:220px; }
	#TD1 td { border: 0px solid #DB9296; padding:0px 2px; font-size:10px; }
	#TD1 { border-collapse:collapse; }
	.LIST2 { padding:10px;  } 
    #formulari_lloc_extern { background-color:#FCD1A7; display:none; }
    .ui-datepicker { z-index: 9999 !important; }
    a { cursor: pointer; }
    #accordion > h3 { padding:5px; padding-left:25px; }
		
</style>


	<script type="text/javascript">

    var hora;    
    
    //----------------------------- FUNCIONS DE CARREGA D'HORARIS ------------------------------
    $(document).ready(function() {
        
        //Al llistat d'activitats podem canviar d'un mode a l'altre.
        $("#ORDENA_HORARIS").click(function(){ $("#LLISTAT_ORDENAT_HORARIS").show(); $("#LLISTAT_ORDENAT_ESPAIS").hide(); });
        $("#ORDENA_ESPAIS").click(function(){ $("#LLISTAT_ORDENAT_HORARIS").hide(); $("#LLISTAT_ORDENAT_ESPAIS").show(); });
        
        //Afegim els layouts als botons                
        $( "#B-GUARDA-ACTIVITAT" ).button({ icons: { primary: 'ui-icon-disk' } , label: "Guarda l'activitat"});
        $( "#B-ESBORRA-ACTIVITAT" ).button({ icons: { primary: 'ui-icon-trash' } , label: "Esborra l'activitat"});
        $("#BDIFUSIO").button({ icons: { primary: 'ui-icon-plus' } , label: "Fes difusió ara!"});
        $("#FORMULARI_DIFUSIO").submit(function(){ EnviaFormulariDifusio(); return false; });
        $("#BPREUSSAVE").button({ icons: { primary: 'ui-icon-disk' } , label: "Actualitza el preu"});                                          
        
        $( "#H-0" ).button({ icons: { primary: 'ui-icon-circle-plus' } , label: "Afegir un nou horari a l'activitat"});         
        
        $( "#B-GUARDA-DESCRIPCIO" ).button({ icons: { primary: 'ui-icon-disk' } , label: "Guarda la descripció"});
        $( "#FORMULARI_DESCRIPCIO" ).submit(function(){ EnviaFormulariDescripcio(); return false; });                        

        //A l'edició d'una activitat mostrem els tabs
        <?php if( isset($OA) && ! $OA->isNew()): ?>
            $( "#tabs_cicles" ).tabs({ cache: true , select: function(event, ui) { window.location.replace(ui.tab.hash); } });
            LoadIfActivitatExisteix(<?php echo $OA->getActivitatid(); ?>);
            LoadDialogPreus( <?php echo $OA->getActivitatid(); ?> );            
        <?php else: ?>        
            $( "#tabs_cicles" ).tabs({ cache: true, disabled: [1, 2, 3, 4, 5, 6] });
        <?php endif; ?>
        
        $("#accordion").accordion( );
                         
    });
    
    function LoadIfActivitatExisteix(idActivitat)
    {

        //Quan fem click a un horari, entrem a aquesta funció. 
        $("[id^='H-']").click(function(){ 
            
            //Capturem el codi d'horari
            var a = $(this).attr('id').split('-');
            
            //Carreguem el formulari que toca al div i després ho mostrem amb el dialog. 
            LoadHorari(a[1] , idActivitat );
            
            //Mostrem el diàleg
            $( "#FORMULARI_HORARI" ).dialog( "open" );
             
        });                        
        
        
        /********* FORMULARI QUE S'OBRE PELS HORARIS **********/        
                
         $( "#FORMULARI_HORARI" ).dialog({
            autoOpen: false,
            height: 600,
            width: 700,
            modal: true,
            buttons: {
            "Guarda": function() {
                //Hem d'enviar el post per formulari i esperar resposta. Si ok, passem sinó mostrem l'error.  
                $.post( 
                    '<?php echo url_for('gestio/gActivitats?accio=HORARI_SAVE'); ?>', 
                    { FORMULARI: $("#FORM_HORARI").serialize() } , 
                    function(data){ 
                        if(data != "") {
                            alert(data); 
                            return false; 
                        //Tot ha anat bé, i tanquem el formulari
                        } else {                                                   
                            $("#FORM_HORARI").html("");                            
                            window.location.reload();
                            return true; 
                        }
                    }
                );                                
            },                                                
            "Esborra": function() {
                //Enviem el formulari i ho esborrem.   
                $.post( 
                    '<?php echo url_for('gestio/gActivitats?accio=HORARI_DELETE'); ?>', 
                    { FORMULARI: $("#FORM_HORARI").serialize() } , 
                    function(data){ 
                        if(data != "") {
                            alert(data); 
                            return false; 
                        //Tot ha anat bé, i tanquem el formulari
                        } else {
                            $("#FORM_HORARI").html("");                            
                            window.location.reload();
                            return true; 
                        }
                    }
                );                
            },
            
            },            
            close: function() {
                $("#FORM_HORARI").html("");
                $( "#FORMULARI_HORARI" ).dialog( "close" );
            }         
        });                        
    }        
    
    function LoadHorari( idHorari , idActivitat ){        
        $.post(
            '<?php echo url_for('gestio/gActivitats?accio=HORARI') ?>',  
            { idH: idHorari , idA: idActivitat } , 
            function(data) { $( "#FORMULARI_HORARI" ).html(data); }
        );
    }
    
    /********* FI FORMULARI QUE S'OBRE PELS HORARIS **********/
    
    function EnviaFormulariDifusio(){
        
        $.post( 
            '<?php echo url_for('gestio/AjaxDifusio'); ?>' , 
            { FORMULARI: $("#FORMULARI_DIFUSIO").serialize() } , 
            function(data){ 
                if(data != "") { alert(data); return false; }                
                else { alert('Descripció guardada correctament.'); return false; }                                                            
            });
    }
    
    function EnviaFormulariDescripcio(){

        tinyMCE.triggerSave();        
        $.post( 
            '<?php echo url_for('gestio/gActivitats?accio=DESCRIPCIO_SAVE'); ?>', 
            { FORMULARI: $("#FORMULARI_DESCRIPCIO").serialize() } , 
            function(data){ 
                if(data != "") {
                    alert(data); 
                    return false; 
                //Tot ha anat bé, i tanquem el formulari
                } else {                                                                                                   
                    //window.location.reload();
                    alert('Descripció guardada correctament.');
                    return false; 
                }
            }
        );                
    }
    
    
    function LoadDialogPreus( idActivitat )
    {

        //Quan fem click a un horari, entrem a aquesta funció. 
        $("[id^='P-']").click(function(){ 
            
            //Capturem el codi d'horari
            var a = $(this).attr('id').split('-');
            
            //Carreguem el formulari que toca al div i després ho mostrem amb el dialog. 
            LoadPreu( a[1] , idActivitat );
            
            //Mostrem el diàleg
            $( "#FORMULARI_PREU" ).dialog( "open" );            
             
        });                        
        
        
        /********* FORMULARI QUE S'OBRE PELS PREUS **********/        
                
         $( "#FORMULARI_PREU" ).dialog({
            autoOpen: false, height: 400, width: 400, modal: true,
            buttons: {
            "Guarda": function() {
                //Hem d'enviar el post per formulari i esperar resposta. Si ok, passem sinó mostrem l'error.  
                $.post( 
                    '<?php echo url_for('gestio/gActivitats?accio=PREUS'); ?>', 
                    { FORMULARI: $("#FORM_PREU").serialize() } , 
                    function(data){ 
                        if(data != "") {
                            alert(data); 
                            return false; 
                        //Tot ha anat bé, i tanquem el formulari
                        } else {                                                   
                            $("#FORM_PREU").html("");                            
                            window.location.reload();
                            return true; 
                        }
                    }
                );                                
            },                                                                        
            },            
            close: function() {
                $( "#FORM_PREU" ).html("");
                $( "#FORMULARI_PREU" ).dialog( "close" );
            }         
        });                        
    }        
    
    function LoadPreu( idHorari , idActivitat ){        
        $.post(
            '<?php echo url_for('gestio/gActivitats?accio=PREUS') ?>',  
            { idH: idHorari , idA: idActivitat } , 
            function(data) { $( "#FORMULARI_PREU" ).html(data); }
        );
    }
    
    /********* FI FORMULARI QUE S'OBRE PELS PREUS **********/

    
    //----------------------------- FUNCIONS DE CARREGA D'HORARIS ------------------------------

	function jq(myid)
	  { return '#'+myid.replace(/:/g,"\\:").replace(/\./g,"\\.");}
	
       
	</script>
  
<td colspan="3" class="CONTINGUT_ADMIN">	


	<?php         
        
        include_partial('breadcumb',array('text'=>'ACTIVITATS'));
        if(isset($MISSATGE)){ echo "<h1>".$MISSATGE."</h1>"; }        
        if(!isset($MISSATGE)) $MISSATGE = null;
        
        if(isset($MODE['ERROR_GREU'])){ formErrorGreu($MISSATGE); }
    
        if ( isset($MODE['CONSULTA']) || isset($MODE['LLISTAT']) ) formConsulta($FCerca,$DATAI,$CALENDARI);
        
        if( (isset($MODE['ACTIVITAT_CICLE']) ) ){            
            if( isset($FActivitat) && isset($MODE['ACTIVITAT_EDIT']) ){ formEditaActivitat($IDA,$FActivitat); }
            if( isset($FHorari)) { formEditaHoraris($IDA,$FHorari,$MISSATGE,$EXTRES,$IDS);  }
            if( isset($MODE['HORARI']) ){ formLlistaHoraris($IDA,$NOMACTIVITAT,$HORARIS,$FHorari);  }            
            if( isset($MODE['DESCRIPCIO']) ) { formEditaDescripcio($IDA,$FActivitat); }
            if( isset($MODE['PREUS']) ){ formLlistaPreus( $OA , $FPREUS );  }
            formLlistaActivitatsEdicio( $OA, $OC, $L_OA_REL, $FA , $IDS , $FPREUS );                    
        }
        
        if( isset($MODE['LLISTAT']) && isset($ACTIVITATS) ) { formLlistaActivitats($ACTIVITATS,$PAGINA,$IDS);  }
                
    ?>

<div style="height:40px;"></div>

</td>    
   

<!-- Comencen les funcions -->
   
    		
<?php function formConsulta($FCerca,$DATAI,$CALENDARI){ ?>

    <form action="<?php echo url_for('gestio/gActivitats') ?>" method="POST">
        <div class="REQUADRE">
        	<table class="FORMULARI">          
                <?php echo $FCerca ?>
                <tr>
                	<td colspan="2">
                		<input type="submit" name="BCERCA" value="Prem per buscar" />
                		<input type="submit" name="BNOU" value="Nova activitat" />
                	</td>
                </tr>
            </table>
         </div>
     </form>

    <div class="REQUADRE">
    <div class="TITOL">Calendari d'activitats<span id="MESOS"> <?php echo getSelData($DATAI); ?></span></div>
    	<table id="CALENDARI_ACTIVITATS">          
            <?php                 
              
              echo llistaCalendariV($DATAI,$CALENDARI);                                              

            ?>
        </table>
     </div>
                  
<?php } ?>
	  
      
<?php function formLlistaActivitatsEdicio( $OA , $OC , $L_OA_REL , $FA , $IDS ){ ?>
	    
    <div class="REQUADRE fb">
	<?php echo include_partial('botonera',array('tipus'=>'Tancar','url'=>'gestio/gActivitats?accio=C')); ?>		
	<div class="titol">Editant les activitats ( <?php echo ($OC instanceof Cicles)?$OC->getNom():"No pertany a cap cicle"; ?> )</div>
		
        
        <div id="tabs_cicles">
            <ul>
            <li><a href="#tabs-1">Dades generals</a></li>
            <li><a href="#tabs-2">Horaris</a></li>
            <li><a href="#tabs-3">Descripció</a></li>            
            <li><a href="#tabs-4">Activitats del cicle</a></li>
            <li><a href="#tabs-5">Difusió</a></li>
            </ul>
            
            
            <!-- COMENÇA ACTIVITAT -->
            
            <div id="tabs-1">
                    			
         		<div style="padding-top:10px;" class="FORMULARI fb">
         		
                    <form action="<?php echo url_for('gestio/gActivitats?accio=ACTIVITAT_SAVE') ?>" method="POST">
             			<?php echo $FA; ?>
             			<div style="text-align:right; padding-top:40px;">
                			<button id="B-GUARDA-ACTIVITAT" name="B-GUARDA-ACTIVITAT" type="submit"></button>
                			<button id="B-ESBORRA-ACTIVITAT" name="B-ESBORRA-ACTIVITAT" type="submit"></button>
             			</div>
                    </form>	
         		</div>
                <div style="clear: both;">&nbsp;</div>
                
            </div>
            
            <!-- FI ACTIVITAT -->
            <!-- COMENÇA HORARIS -->
            
            <div id="tabs-2">

              	<div>       
                    <?php $A_OH_PREU = $OA->getHorarisAmbPreu(); ?>                                                                                     
                    <?php $L_OH = $OA->getHorariss(); $RET = ""; ?>
         			<?php if( sizeof($L_OH) == 0 ): echo '<div class="row_horaris"><div class="col_horaris">Aquesta activitat no té cap horari definit.</div></div>'; endif; ?>  
        			<?php 	foreach($L_OH as $OH): $M = $OH->getArrayHorarisEspaisMaterial(); $HE = $OH->getArrayHorarisEspaisActiusAgrupats();                                                                                                
        						echo '<div class="row_horaris">                                        								
        								<div class="col_horaris" style="width:100px;"><a class="a_horaris" >'.myUser::getDiaText($OH->getDia('Y-m-d'), true).', '.$OH->getDia('d/m/Y').'</a></div>        								
        								<div class="col_horaris" style="width:50px;">'.$OH->getHorainici('H:i').'</div>        								                                        
                                        <div class="col_horaris" style="width:50px;">'.$OH->getHorafi('H:i').'</div>
        								<div class="col_horaris" style="width:200px;">'; foreach($HE as $HESPAI): echo $HESPAI.'<br />'; endforeach; echo '</div>';         						
                                echo   '<div class="col_horaris" style="width:50px; float:right;">';
                                
                                    echo '<a id="H-'.$OH->getHorarisid().'" class="tt2">'.image_tag('template/door.png').'<span>Edita l\'horari.</span></a>';                                                                        
                                    if(array_key_exists( $OH->getHorarisid() , $A_OH_PREU ) ) echo '&nbsp;&nbsp;<a id="P-'.$OH->getHorarisid().'" class="tt2">'.image_tag('template/money.png').'<span>Edita els preus.</span></a>';
                                    else echo '&nbsp;&nbsp;<a id="P-'.$OH->getHorarisid().'" class="tt2">'.image_tag('template/money_euro.png').'<span>Edita els preus.</span></a>';
                                
                                echo   '</div>';  
        						echo '</div>';                                                                                                
                                
        					endforeach;
        				
        			?>			                   	
            	</div>    	
                <br />
                <?php echo '<button id="H-0"></button>'; ?>

                <div id="FORMULARI_HORARI"></div>                                                    
                <div id="FORMULARI_PREU"></div>                
            
            </div>
            
            <!-- FI HORARIS -->
            <!-- COMENÇA DESCRIPCIÓ -->
            
            <div id="tabs-3">

         		<div style="padding-top:10px;" class="FORMULARI fb">
         		
                    <form id="FORMULARI_DESCRIPCIO" method="POST">
             			<?php echo new ActivitatsTextosForm($OA); ?>
                        <?php include_partial('uploads',array('DIRECTORI_WEB' => '/images/activitats/' , 'NOM_ARXIU' => 'A-'.$OA->getActivitatid() )); ?>
             			<div style="text-align:right; padding-top:40px;">
                			<input id="B-GUARDA-DESCRIPCIO" name="B-GUARDA-DESCRIPCIO" type="submit" value="Guarda" />                						 				 				 			
             			</div>	
                    </form>
                                    
         		</div>                
            <div style="clear: both;">&nbsp;</div>
            </div>
            
            <!-- FI DESCRIPCIÓ -->
            
            <!-- COMENÇA CICLES -->
            
            <div id="tabs-4">                 
              	<table class="DADES">   
                    <tr><th>Activitat</th><th>Data</th></tr>
                    <tr><th>&nbsp;</th><th>&nbsp;</th></tr>                 
         			<?php if( sizeof($L_OA_REL) == 0 ): echo '<tr><td class="LINIA">El cicle no té cap activitat.</td></tr>'; endif; ?>          			
                    <?php foreach($L_OA_REL as $OA):
                                    						
        						$PrimerDia = $OA->getPrimeraData();                                
                                echo '<tr>
        								<td class="" width="">'.link_to($OA->getNom(),'gestio/gActivitats?accio=ACTIVITAT&IDA='.$OA->getActivitatid()).'</td>
                                        <td class="" width="">'.$PrimerDia.'</td>                                                  								 
        							  </tr>';
                        endforeach;				
        			?>		                   	                   	
            	</table>    
                <br />                                    
            
            </div>
            
            <!-- FI CICLES -->
            
            <!-- COMENÇA DIFUSIÓ -->
            
            <div id="tabs-5">              
                <div class="TITOL">Llocs on fer difusió de l'activitat</div>   
                <div style="padding:10px;">
                    <a href="<?php echo url_for('gestio/ConnectaGoogleCalendars?login=true&idA='.$OA->getActivitatid()); ?>">Connecta a Google</a>
                    <br /><br />
                    <form id="FORMULARI_DIFUSIO" action="POST">                                            
                        <div style="width: 150px; float:left; "><input type="checkbox" value="calendars" name="calendars" /> Google calendars</div>
                        <div style="width: 150px; float:left; "><input disabled="disabled" type="checkbox" value="facebook" name="facebook" /> Facebook</div>
                        <div style="width: 150px; float:left; "><input disabled="disabled" type="checkbox" value="twitter" name="twitter" /> Twitter</div>
                        <div style="width: 150px; float:left; "><input disabled="disabled" type="checkbox" value="DdG" name="ddg" /> Diari de Girona</div>
                        <div style="width: 150px; float:left; "><input disabled="disabled" type="checkbox" value="elpunt" name="elpunt" /> El punt - Avui</div>
                        <div style="width: 150px; float:left; "><input disabled="disabled" type="checkbox" value="ara" name="ara" /> Ara</div>                                                        
                        <div style="width: 150px; float:left; "><input disabled="disabled" type="checkbox" value="giroque" name="giroque" /> Giroquè</div>
                        <div style="width: 150px; float:left; "><input disabled="disabled" type="checkbox" value="femxarxa" name="femxarxa" /> Fem Xarxa</div>
                        <div style="width: 150px; float:left; "><input disabled="disabled" type="checkbox" value="forfree" name="forfree" /> For Free</div>
                        <div style="width: 150px; float:left; "><input disabled="disabled" type="checkbox" value="ddgi" name="ddgi" /> Diputació de Girona</div>
                        <div style="clear: both;" >&nbsp;</div>
                        <div style="font-size: 9px; color: gray;">Si cliqueu el botó, s'afegirà automàticament la informació que hi ha al text mig i titol mig de l'apartat descripció de l'activitat així com s'adjuntarà l'enllaç a la "foto normal" (habitualment quadrada). S'utilitzaran els horaris que heu entrat i les categories seleccionades per classificar l'activitat. Si torneu a prèmer el botó es tornarà a publicar la informació. En cap cas es substituirà. Així doncs abans de fer difusió assegureu-vos que la informació està entrada correctament.</div>
                        <div><input type="submit" id="BDIFUSIO" name="BDIFUSIO" style="margin-top: 10px;" /></div>
                        <input type="hidden" name="idA" value="<?php echo $OA->getActivitatid() ?>" />
                    </form>               
                </div> 
            </div>
            
            <!-- FI DIFUSIÓ -->            
                                                
        </div>                                                		    	     
    	
	</div>

<?php } ?>

  
<?php function formLlistaActivitats($ACTIVITATS,$PAGINA,$IDS){ ?>

     <div class="REQUADRE">
        <div class="TITOL">Llistat d'activitats <span style="color:gray; font-weight:normal; ">(Ordenat per <a id="ORDENA_HORARIS" href="#">horaris</a> / <a id="ORDENA_ESPAIS" href="#">espais</a> )</span></div>
      	<table id="LLISTAT_ORDENAT_HORARIS" class="DADES">
 			<?php 	             
                             
                    if( sizeof($ACTIVITATS) == 0 ): echo '<TR><TD class="LINIA">No s\'ha trobat cap activitat.</TD></TR>'; endif;  					  			   			
					foreach($ACTIVITATS as $idH => $A):			
	                                                                    
	                  	$AVIS = ""; $ESP = ""; $MAT = ""; $PUBLICAT = "";                                                     
	                  	if( !empty( $A['ESPAIS'] ) ):       $ESP = implode("<br />",$A['ESPAIS']); endif;
	                  	if( !empty( $A['MATERIAL'] ) ):     $MAT = implode("<br />",$A['MATERIAL']); endif;            		 
	                  	if( strlen( $A['AVIS'] ) > 2 ):     $AVIS = '<a href="#" class="tt2">'.image_tag('tango/32x32/emblems/emblem-important.png', array('size'=>'16x16')).'<span>'.$A['AVIS'].'</span></a>'; else: $AVIS = ""; endif;                        
                        if( $A['PUBLICAT'] == 'OK' ):       $PUBLICAT = image_tag('template/exclamation.png', array('size'=>'16x16'));
                        elseif( $A['PUBLICAT'] == 'FALTA_INFO' ): $PUBLICAT = image_tag('template/stop.png', array('size'=>'16x16')); endif;                                 
	                  	$j = 1;
	                  	$PAR = ParImpar($j++);
                        $url_act = link_to($A['NOM_ACTIVITAT'],'gestio/gActivitats?accio=ACTIVITAT&IDA='.$A['ID'],array('style'=>'font-size:12px'));
                        $url_hor = ""; //link_to('Edita informació pràctica','gestio/gActivitats?accio=HORARI&IDA='.$A['ID'].'&IDH='.$idH,array('style'=>'font-size:10px'));                            
                        $org = (empty($A['ORGANITZADOR']))?"":"<span style=\"font-size:8px; color:gray; \"> (".$A['ORGANITZADOR'].") </span>";                                                                           	                            
                  		echo '	<tr><td style="background-color:#EEEEEE; border:1px solid #EEEEEE; height:15px;" colspan="6"></td></tr>';		                  	
	                  	echo '	<tr><td class="LIST2 '.$PAR.'" colspan="6">'.$url_act.$AVIS.' '.$PUBLICAT.$org.' <div style="float:right">'.$url_hor.'</div></td></tr>';		                  	
	                  	echo '	<TR>                      						               							                	
	                  				<TD class="LIST2 '.$PAR.'"><span style="font-weight:bold; font-size:10px; color:#880000;">'.$A['HORA_PRE'].'</span></TD>	
				               		<TD class="LIST2 '.$PAR.'"><span style="font-weight:bold; font-size:12px; color:green;">'.$A['HORA_INICI'].'</span></TD>
				               		<TD class="LIST2 '.$PAR.'"><b>'.$A['HORA_FI'].'</b></TD>';                              					    
                        echo '	    <TD class="LIST2 '.$PAR.'"><span style="font-weight:bold; font-size:12px; color:#800000;">'.$ESP.'</span></TD>';                            
				        echo '     	<TD class="LIST2 '.$PAR.'">'.$MAT.'</TD>
				                	<TD class="LIST2 '.$PAR.'">'.$A['DIA'].'</TD>						            
				                </TR>';		                  			                  	
                                                
				 	endforeach; 
				 
	                ?>            	
      	</table>

      	<table id="LLISTAT_ORDENAT_ESPAIS" class="DADES" style="display: none;">
 			<?php 	                
                if( sizeof($ACTIVITATS) == 0 ): echo '<TR><TD class="LINIA">No s\'ha trobat cap activitat.</TD></TR>'; endif;
                $ESPAIS = array();                
                foreach($ACTIVITATS as $idH => $A):
                    foreach($A['ESPAIS'] as $idE => $E):
                        $ESPAIS[$idE][] = $idH;
                    endforeach; 
                endforeach;             
                $ANT = "";         
                
                //Reordeno espais perquè apareguin com estan ordenats a la intranet. 
                $ESPAIS_REAL = EspaisPeer::getEspaisSite($IDS);
                $ESPAIS_ORDENAT = array();
                foreach($ESPAIS_REAL as $OE):
                    $idE = $OE->getNom();                    
                    if(isset($ESPAIS[$idE])) $ESPAIS_ORDENAT[$idE] = $ESPAIS[$idE];                    
                endforeach;
                                                      
				foreach($ESPAIS_ORDENAT as $idE => $HORA):
                    foreach($HORA as $idH):			
                        $A = $ACTIVITATS[$idH];
                        //Per cada horari, agafem l'espai i fem un vector on guardarem els resultats.'                    
                      	$AVIS = ""; $ESP = ""; $MAT = ""; $PUBLICAT = "";                              	                                                        
                      	if( !empty( $A['ESPAIS'] ) ):     $ESP = $A['ESPAIS'][$idE]; endif;
                      	if( !empty( $A['MATERIAL'] ) ):   $MAT = implode("<br />",$A['MATERIAL']); endif;            		 
                      	if( strlen( $A['AVIS'] ) > 2 ):   $AVIS = '<a href="#" class="tt2">'.image_tag('tango/32x32/emblems/emblem-important.png', array('size'=>'16x16')).'<span>'.$A['AVIS'].'</span></a>'; else: $AVIS = ""; endif;
                        if( $A['PUBLICAT'] == 'OK' ):       $PUBLICAT = image_tag('template/exclamation.png', array('size'=>'16x16'));
                        elseif( $A['PUBLICAT'] == 'FALTA_INFO' ): $PUBLICAT = image_tag('template/stop.png', array('size'=>'16x16')); endif;
                      	$j = 1; $PAR = ParImpar($j++);
                        $url_act = link_to($A['NOM_ACTIVITAT'],'gestio/gActivitats?accio=ACTIVITAT&IDA='.$A['ID'],array('style'=>'font-size:12px'));
                        $url_hor = //link_to('Edita informació pràctica','gestio/gActivitats?accio=HORARI&IDA='.$A['ID'].'&IDH='.$idH,array('style'=>'font-size:10px'));                            
                        $org = (empty($A['ORGANITZADOR']))?"":"<span style=\"font-size:8px; color:gray; \"> (".$A['ORGANITZADOR'].") </span>";
                        
                        if($ANT <> $ESP):                                                                                               	                            
                  		    echo '	<tr><td style="background-color:#AAAAAA; font-size:14px; color:EEEEEE; font-style:italic; border:1px solid #EEEEEE; height:15px;" colspan="6">'.$ESP.'</td></tr>';
                        else: 
                            echo '	<tr><td style="background-color:#EEEEEE; border:1px solid #EEEEEE; height:15px;" colspan="6">&nbsp;</td></tr>';
                        endif;		                  	
                        $ANT = $ESP;
                        
                      	echo '	<tr><td class="LIST2 '.$PAR.'" colspan="6">'.$url_act.$AVIS.' '.$PUBLICAT.$org.' <div style="float:right">'.$url_hor.'</div></td></tr>';		                  	
                      	echo '	<TR>                      						               							                	
                      				<TD class="LIST2 '.$PAR.'"><span style="font-weight:bold; font-size:10px; color:#880000;">'.$A['HORA_PRE'].'</span></TD>	
    			               		<TD class="LIST2 '.$PAR.'"><span style="font-weight:bold; font-size:12px; color:green;">'.$A['HORA_INICI'].'</span></TD>
    			               		<TD class="LIST2 '.$PAR.'"><b>'.$A['HORA_FI'].'</b></TD>';                              					    
                        echo '	    <TD class="LIST2 '.$PAR.'"><span style="font-weight:bold; font-size:12px; color:#800000;">'.$ESP.'</span></TD>';                            
    			        echo '     	<TD class="LIST2 '.$PAR.'">'.$MAT.'</TD>
    			                	<TD class="LIST2 '.$PAR.'">'.$A['DIA'].'</TD>						            
    			                </TR>';		                  			                  	                                                
                    endforeach;                                                
			 	endforeach; 
			 
                ?>            	 				                         	
      	</table>      

                
      </div>

<?php } ?>  


<?php function formLlistaPreus( $OA , $FPREUS ){ ?>    
    
    <style>
    
        .row { width: auto; float:left; margin-left:10px; } 
        .row_field { width:auto; } 
	    .row_title { width:auto; }
	    .row_field input { width:auto; }

    </style>
    	    	                                                             
	<div class="REQUADRE">
    
    	<div class="OPCIO_FINESTRA"><?php echo link_to(image_tag('icons/Grey/PNG/action_delete.png'),'gestio/gActivitats?accio=PREUS&IDA='.$IDA); ?></div>        	
    	<div class="titol">        
            <?php echo 'Editant els preus de l\'activitat: '.$OA->getNom(); //Mostrem de quina activitat estem editant els preus ?>
    	</div>
            
    	<div class="TITOL">Preu horaris</div>                                    
          	<div class="DADES">
     			<?php   
                        
                    if( sizeof($FPREUS) == 0 ): echo '<TR><TD class="LINIA">Aquesta activitat no té cap horari definit.</TD></TR>'; endif;
                    foreach($FPREUS as $F):
                        echo '<form action="'.url_for('gestio/gActivitats').'" method="post">';
                            echo input_hidden_tag('IDA',$OA->getActivitatid());
                            $OH = HorarisPeer::retrieveByPK($F->getObject()->getHorariId());
                            echo '<div style="clear:both; font-weight:bold;" class="titol" >'.$OH->getDia('d/m/Y').' | '.$OH->getHorainici('H:i').'</div>';                             
                                echo $F;
                            echo '<div style="margin-left:20px; padding-top:20px; float:left; "> <button name="BPREUSSAVE" class="BOTO_ACTIVITAT">Actualitza</button></div>';
                        echo '</form>';	                   	
                    endforeach;
                                            
                ?>                                        
                <div style="clear:both">&nbsp;</div>                                                                                  	    			
        	</div>    	                          
	</div>
<?php } ?>



<?php 


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
              
    $any = $year;
    $mesI = $mes;
    $mesF = $mes+3;      
         
    $RET = "<TR><TD></TD>";
    for($i = 6; $i>0; $i--):
      $RET .= "<TD>Dll</TD><TD>Dm</TD><TD>Dc</TD><TD>Dj</TD><TD>Dv</TD><TD>Ds</TD><TD>Dg</TD>";
    endfor;
    $RET .= "</TR>";

    
    for($mes = $mesI; $mes < $mesF; $mes++):
    
      
      $mesReal = ($mes > 12)?($mes-12):$mes;
      $anyReal = ($mes == 13)?$any+1:$any;
            
      
      $dies = cal_days_in_month(CAL_GREGORIAN, $mesReal, $anyReal );                   		//Mirem quants dies té el mes      
      $diaSetmana = jddayofweek(cal_to_jd(CAL_GREGORIAN, $mesReal , 1 , $anyReal) , 0 );    //Marquem quants blancs volem tenir      
      if($diaSetmana == 0) $blancs = 6-1; else  $blancs = $diaSetmana-2;
      
      if($mesReal % 2) $background = "beige"; else $background = "white";                   //Mirem el color del fons
      $RET .= "<TR><TD>".mesos($mesReal)."</TD>";
      
      //Bucle de pintar dies
      
      for($dia = 0; $dia < 40; $dia++):                                             //Generem el calendari
        $diaA = $dia-$blancs;
        if($dia <= $blancs || $diaA > $dies):                                        //Si és blanc el marquem com a tal i si el dia ha passat el màxim de dies del mes no el marquem
          $RET .= "<TD></TD>";
        else:                                  
          $diaSetmana = jddayofweek(cal_to_jd(CAL_GREGORIAN, $mesReal , $diaA , $anyReal) , 0 );
          if( $diaSetmana == 6 || $diaSetmana == 0) $background="beige"; else $background = "white"; 
          
          $CalDia = mktime(0,0,0,$mesReal,$diaA,$anyReal);
          $SPAN = ""; $color = "";
          
          if(isset($CALENDARI[$CalDia])) { $SELECCIONAT = "SELECCIONAT";
            $SPAN  = '<span>';				 
          	foreach($CALENDARI[$CalDia] as $CAL) $SPAN .= $CAL['HORA'].' - '.$CAL['TITOL'].'<br />';          		                    	          	
            $SPAN .= '</span>';
          } else { $SELECCIONAT = ""; }
                                        
          $RET .= '<TD class="DIES" style="background-color:'.$background.';">'.link_to($diaA.$SPAN,"gestio/gActivitats?accio=CD&DATAI=".$this->DATAI."&DIA=".$CalDia , array('class'=>"tt2 $SELECCIONAT")).'</TD>';
          
        endif;    
      endfor;
      $RET .= "</TR>";
            
    endfor;
          
    return $RET;
      
  }

  
  function llistaCalendariV($DATAI, $CALENDARI)
  {
    
    //Inicialitzem variables i marquem els dies en blanc
    $Q = 3; 
    $mes  = date('m',$DATAI);
    $year = date('Y',$DATAI);
    $RET = "";
              
    $any = $year;
    $mesI = $mes;
    $mesF = $mes+$Q;      

    //Omplim els mesos
    $RET .= '<tr>'; $dies = array(); $IndexMes = 0;
    for($mes = $mesI; $mes < $mesF; $mes++):  
    
    	$mesReal = ($mes > 12)?($mes-12):$mes;
      	$anyReal = ($mes == 13)?$any+1:$any;
    
    	$week = 1; $IndexMes++; 
    	$diesMes = cal_days_in_month(CAL_GREGORIAN, $mesReal, $anyReal );
    	
    	for($dia = 1; $dia <= $diesMes; $dia++ ):
    	    	
    		$diaSetmana = jddayofweek(cal_to_jd(CAL_GREGORIAN, $mesReal , $dia , $anyReal) , 0 );
    		$diaSetmana = ($diaSetmana==0)?7:$diaSetmana;
    		    		 
    		$dies[$week][$diaSetmana][$IndexMes]['day'] = $dia;
    		$dies[$week][$diaSetmana][$IndexMes]['month'] = $mesReal;
    		$dies[$week][$diaSetmana][$IndexMes]['year'] = $anyReal;
    		
    		if($diaSetmana == 7) $week++;
    		
    	endfor;
    	    	
    	$RET .= "<TD class=\"titol_mes\" colspan=\"7\">".mesos($mesReal)."</TD><td width=\"20px\"></td>";
    	    
    endfor;
   
	$RET .= '</tr>';	

	$RET .= "<TR>";    
    for($i = 0; $i < $Q; $i++):
    	$RET .= "<TD>Dll</TD><TD>Dm</TD><TD>Dc</TD><TD>Dj</TD><TD>Dv</TD><TD>Ds</TD><TD>Dg</TD><TD></TD>";
    endfor;    
    $RET .= "</TR>";
        
    
    for($row = 1; $row <= 6; $row++):
    	$RET .= "<tr>";
	    for($col = 1; $col<=(7*$Q); $col++):    		
		
			$IndexMes = ceil($col / 7);
			$colR = $col - (7 * ($IndexMes-1));

			//Color de fons per diferenciar els mesos
			if($IndexMes % 2) $background = "beige"; else $background = "beige";
			
			//Color de fons per diferenciar els caps de setmana
			if( $colR == 6 || $colR == 7) $background="#CCCCCC";			 
						
			if(isset($dies[$row][$colR][$IndexMes])):

				$dades = $dies[$row][$colR][$IndexMes];
			
				$SPAN = ""; $color = "";
		        $CalDia = mktime(0,0,0,$dades['month'],$dades['day'],$dades['year']);
		        
		        if(isset($CALENDARI[$CalDia])):
		        	$SELECCIONAT = "SELECCIONAT";		        	
		        	$SPAN  = '<span><table id="TD1"><tr><th>Inici</th><th>Fi</th><th>Espai</th><th>Títol</th><th>Organitzador</th></tr>';				 
		          		foreach($CALENDARI[$CalDia] as $CAL) $SPAN .= '<tr><td>'.$CAL['HORAI'].'</td><td>'.$CAL['HORAF'].'</td><td>'.$CAL['ESPAIS'].'</td><td>'.$CAL['TITOL'].'</td><td>'.$CAL['ORGANITZADOR'].'</td></tr>';
		            $SPAN .= '</table></span>';
		        else: 
		        	$SELECCIONAT = "";
		        endif; 
		                                        
				$RET .= '<TD class="DIES" style="background-color:'.$background.';">'.link_to($dades['day'].$SPAN,"gestio/gActivitats?accio=CD&DIA=".$CalDia , array('class'=>"tt2 $SELECCIONAT")).'</TD>';
      																						
			else: 
				
				$RET .= '<TD class="DIES" style="background-color:'.$background.';"></TD>';
			
			endif; 			

			if($colR == 7): $RET .= '<td></td>'; endif; 
			
		endfor;        
		$RET .= "</tr>";
    endfor;
    
    $RET .= "</TR>";
	        
    return $RET;
      
  }
  
  

  function ParImpar($i){ if($i % 2 == 0) return "PAR"; else return "IPAR"; }
  
  
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
     $RET = link_to($ANY-1,'gestio/gActivitats?accio=CC&DATAI='.mktime(0,0,0,1,1,$ANY-1),array('class'=>'negreta'))." ";
     for($any = $ANY ; $any < $ANY+2 ; $any++ ):
     	$RET .= link_to($any,'gestio/gActivitats?accio=CC&DATAI='.mktime(0,0,0,1,1,$any),array('class'=>'negreta'))." ";
     	for($mes = 1; $mes < 13; $mes++):
     		$RET .= link_to(mesosSimplificats($mes),"gestio/gActivitats?accio=CC&DATAI=".mktime(0,0,0,$mes,1,$any),array('class'=>'mesos_unit'))." ";
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