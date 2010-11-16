<?php use_helper('Form'); ?>

<script>

	$(document).ready(function() {
		$( "#tabs" ).tabs({ cookie: { expires: 1 } });        
	});
	
</script>

<style>
    LEGEND { font-weight:bold; padding-left:10px; padding-right:10px; font-size:12px;  }  

	.DH { display:block; float:left; padding-top:5px; }

	fieldset { border:3px solid #F3F3F3; margin-right:40px; padding:10px; }
	.MISSAT { color:black; font-weight:bold; font-size:10px; vertical-align:middle; text-align:center; background-color:White; padding-bottom:10px; }	
	.TITOL_CATEGORIA { background-color: #DD9D9A; color:black; font-weight:bold; padding:5px; font-size:10px; }	

</style>

   <TD colspan="3" class="CONTINGUT_ADMIN">

	<?php include_partial('breadcumb',array('text'=>'ZONA PRIVADA')); ?>		
   	<?php include_partial('espaiActual',array('IDS'=>$IDS)); ?>

    <?php if($DEFAULT): ?>
		                   	                   	
        <div style=" padding:20px; width:700px; ">    
            <div id="tabs">
            	<ul>
                    <li><a href="#tabs-0">Benvinguda</a></li>
                    <li><a href="#tabs-4">Entitats</a></li>
            		<li><a href="#tabs-1">Dades</a></li>
            		<li><a href="#tabs-2">Matrícules</a></li>
                    <li><a href="#tabs-3">Reserves</a></li>                            		
            	</ul>                        
                <div id="tabs-0"> <?php echo landing_page(); ?> </div>
                <div id="tabs-4"> <?php echo FormulariEntitats($LENTITATS); ?> </div>
                <div id="tabs-1"> <?php echo LlistaDades($FDADES); ?> </div>
            	<div id="tabs-2"> <?php echo LlistaMatricules($LMATRICULES); ?> </div>
            	<div id="tabs-3"> <?php echo LlistaReserves($LRESERVES); ?> </div>              	
                
            </div>
        
        </div>
        
      <?php else:
      
              if(isset($FUSUARI)) echo EditaUsuari($FUSUARI,$MISSATGE);                 
              if(isset($LCURSOS)) echo LlistaCursos($LCURSOS,$DATA_INICI);
              if(isset($TPV)) echo VerificaMatricula($TPV,$DADES_MATRICULA,$ISPLE);                              
              if(isset($FRESERVA)) echo EditaReserva($FRESERVA,$MISSATGE);
              if(isset($MISS_MAT)) echo MissatgeWeb($TITOL,$MISS);
              if(isset($FENTITATS)) echo EditaEntitats($FENTITATS);
                                                                    
            endif;                                       
         
      ?>
      
      
      
      
      <DIV STYLE="height:40px;"></DIV>
                
    </TD>
    

<?php 

	function missatge($MISSATGE)
	{
	   $RET = "";
		if(!empty($MISSATGE))
		{
			$RET .= '<TR>';
		   	$RET .= '<TD></TD><TD class="MISSAT_OK">';
		   	foreach($MISSATGE as $M): $RET .= $M."<BR>";  endforeach;    				
		   	$RET .= '</TD></TR>';			
		}		
        
        return $RET;
	}


    function FormulariEntitats($FENTITATS)
    {
    
        $RET = '
        <form name="gDades" action="'.url_for('gestio/uGestio').'" method="post">
           
                <table class="FORMULARI">                    
                '.$FENTITATS.'
                </table>
                <div style="text-align:right">
                    <button type="submit" name="BGUARDACANVIENTITAT" class="BOTO_ACTIVITAT" onClick="return confirm(\'Segur que vols guardar els canvis?\')">
                        '.image_tag('template/house.png').' Canvia de lloc
                    </button>
                </div>                                                              
        </form>';
                     
        return $RET;

    }

    function EditaEntitats($FENTITATS)
    {
    
        $RET = '
        <form name="gDades" action="'.url_for('gestio/uGestio').'" method="post">
           
    	   <FIELDSET class="REQUADRE"><LEGEND class="LLEGENDA">Dades personals</LEGEND>
    	                               	 	                                    
                <table class="FORMULARI">                    
                '.$FENTITATS.'
                </table>
                <div style="text-align:right">
                    <button type="submit" name="BGUARDACANVIENTITAT" class="BOTO_ACTIVITAT" onClick="return confirm(\'Segur que vols guardar els canvis?\')">
                        '.image_tag('template/house.png').' Canvia de lloc
                    </button>
                </div>
            </FIELDSET>                                                                                                            
        </form>';
                     
        return $RET;

    }

    function EditaUsuari($FUSUARI,$MISSATGE = "")
    {
    
        $RET = '
        <form name="gDades" action="'.url_for('gestio/uGestio').'" method="post">
           
    	   <FIELDSET class="REQUADRE"><LEGEND class="LLEGENDA">Dades personals</LEGEND>
    	   
    		   <TABLE class="FORMULARI">
    		   <tr><td width="100px"></td><td><td></tr>
               '.missatge($MISSATGE).'		      
    		   '.$FUSUARI.'      		                         
    		   </TABLE>
               
                <div style="text-align:right">
                    <button type="submit" name="BGUARDAUSUARI" class="BOTO_ACTIVITAT" onClick="return confirm(\'Segur que vols guardar els canvis?\')">
                        '.image_tag('template/disk.png').' Guarda els canvis
                    </button>
                </div>                                                                                                            
                  
    	   
    	   </FIELDSET>
    	   
    	</form>';
        
        return $RET;	 
            
    }


    function VerificaMatricula($TPV,$DADES_MATRICULA,$ISPLE)
    {
        
        $RET = "";
        
         //Si la matricula es paga amb Targeta de crèdit, passem al TPV, altrament mostrem el comprovant     
        if($DADES_MATRICULA['MODALITAT'] == MatriculesPeer::PAGAMENT_TARGETA || $DADES_MATRICULA['MODALITAT'] == MatriculesPeer::PAGAMENT_TELEFON ):         	 
            $RET .= '<FORM name="COMPRA" action="https://sis-t.sermepa.es:25443/sis/realizarPago" method="POST" target="TPV">';
            //$RET .= '<form name="COMPRA" action="https://sis.sermepa.es/sis/realizarPago" method="POST" target="TPV">';             
            foreach($TPV as $K => $T) $RET .= input_hidden_tag($K,$T);             
        else:         
            $RET .= '<form method="post" action="gestio/uGestio?accio=FI_MATRICULA">';          	                  
        endif;
    
         //Carreguem totes les dades de matrícula     
        foreach($DADES_MATRICULA as $K => $V) { $str = "DADES_MATRICULA[".$K."]"; $RET .= input_hidden_tag($str,$V); }
        $IDC = $DADES_MATRICULA['CURS'];     
        $ESPLE = ($ISPLE)?'(EN ESPERA)':'';
    
         $RET .= '<FIELDSET class="REQUADRE"><LEGEND class="LLEGENDA">Verificació de la matrícula</LEGEND>';	
        
    	 $RET .= ' <TABLE class="FORMULARI" style="magin-right:40px;">
    		        <TR><TD><b>DNI</b></TD>     <TD>'.$DADES_MATRICULA['DNI'].'</TD></TR>
                    <TR><TD><b>NOM</b></TD>     <TD>'.$DADES_MATRICULA['NOM'].'</TD></TR>
                    <TR><TD><b>PAGAMENT</b></TD><TD>'.MatriculesPeer::textPagament($DADES_MATRICULA['MODALITAT']).'</TD></TR>
                    <TR><TD><b>IMPORT</b></TD>  <TD>'.$DADES_MATRICULA['PREU'].'€'.'</TD></TR>
                    <TR><TD><b>DATA</b></TD>    <TD>'.$DADES_MATRICULA['DATA'].'</TD></TR>
                    <TR><TD><b>DESCOMPTE</b></TD>  <TD>'.MatriculesPeer::textDescomptes($DADES_MATRICULA['DESCOMPTE']).'</TD></TR>
                    <TR><TD><b>CURS</b></TD>  <TD>';
        $RET .=     '<TABLE width="100%" class="FORMULARI">';                  								
   	
        $CURS = CursosPeer::retrieveByPK($DADES_MATRICULA['CURS']);                  								
        $RET .= '       <TR>
                	        <TD>'.$CURS->getCodi().'</TD>
                            <TD>'.$CURS->getTitolcurs().' '.$ESPLE.'</TD>
                            <TD>'.$CURS->CalculaPreu($DADES_MATRICULA['DESCOMPTE']).'€'.'</TD>
                			</TR>                  								                  								                  	                           
      		         </TABLE>
    	           </TD></TR>  	 	          
      	          </TABLE>	
                    
                    <div style="text-align:right">
                        <button type="submit" name="BPAGAMATRICULA" class="BOTO_ACTIVITAT" >
                            '.image_tag('template/coins.png').' Finalitzar la matrícula
                        </button>
                    </div>                                         
                    		                                  
    	       </FIELDSET>    	
    	</FORM>';
        
        return $RET;
        
    }

    function EditaReserva($FRESERVA,$MISSATGE ="" )
    {


	$RET = '<form name="fReserves" id="fReserves" method="post" action="'.url_for('gestio/uGestio').'">';    
    $RET .= '<FIELDSET class="REQUADRE"><LEGEND class="LLEGENDA">Reserva d\'espais</LEGEND>';   	              	           	
    $RET .= missatge($MISSATGE);

    $RET .= $FRESERVA['ReservaEspaiID']->render();
        
    $RET .= 
        '<div style="clear:both" class="FORMULARI">
	    	<span class="DH" style="width:150px;"><b>Nom de l\'activitat</b></span>
	    	<span class="DH">'.$FRESERVA['Nom']->render().'</span>
	    </div>
	    	    
	    <div style="clear: both;" class="FORMULARI">
	    	<span class="DH" style="width:150px;"><b>Proposta de data</b></span>
	    	<span class="DH">'.$FRESERVA['DataActivitat']->render().'</span>
	    </div>
	    
	    <div style="clear: both;" class="FORMULARI">
	    	<span class="DH" style="width:150px;"><b>Proposta d\'hores</b></span>
	    	<span class="DH">'.$FRESERVA['HorariActivitat']->render().'</span>
	    </div>
	    
	    <div style="clear: both;" class="FORMULARI">
	    	<span class="DH" style="width:150px;"><b>Espais</b> (<a class="blue" href="'.url_for('web/espais').'" target="_NEW">veure\'ls</a>)</span>
	    	<span class="DH checkbox_list" style="width:450px">'.$FRESERVA['EspaisSolicitats']->render().'</span>
	    </div>

		<div style="clear: both;" class="FORMULARI">
	    	<span class="DH" style="width:150px;"><b>Material</b></span>
	    	<span class="DH checkbox_list">'.$FRESERVA['MaterialSolicitat']->render().'</span>
	    </div>
		
		<div style="clear: both;" class="FORMULARI">
	    	<span class="DH" style="width:150px;"><b>Tipus d\'acte</b></span>
	    	<span class="DH checkbox_list">'.$FRESERVA['TipusActe']->render().'</span>
	    </div>

		<div style="clear: both;" class="FORMULARI">
	    	<span class="DH" style="width:150px;"><b>Representant a</b></span>
	    	<span class="DH checkbox_list">'.$FRESERVA['Representacio']->render().'</span>
	    </div>

		<div style="clear: both;" class="FORMULARI">
	    	<span class="DH" style="width:150px;"><b>Responsable</b></span>
	    	<span class="DH checkbox_list">'.$FRESERVA['Responsable']->render().'</span>
	    </div>

		<div style="clear: both;" class="FORMULARI">
	    	<span class="DH" style="width:150px;"><b>Organitzadors</b></span>
	    	<span class="DH checkbox_list">'.$FRESERVA['Organitzadors']->render().'</span>
	    </div>

		<div style="clear: both;" class="FORMULARI">
	    	<span class="DH" style="width:150px;"><b>Personal autoritzat</b></span>
	    	<span class="DH checkbox_list">'.$FRESERVA['PersonalAutoritzat']->render().'</span>
	    </div>

		<div style="clear: both;" class="FORMULARI">
	    	<span class="DH" style="width:150px;"><b>Previsio d\'assistents</b></span>
	    	<span class="DH checkbox_list">'.$FRESERVA['PrevisioAssistents']->render().'</span>
	    </div>

		<div style="clear: both;" class="FORMULARI">
	    	<span class="DH" style="width:150px;"><b>Enregistrable?</b></span>
	    	<span class="DH checkbox_list">'.$FRESERVA['isEnregistrable']->render().'</span>
	    </div>

		<div style="clear: both;" class="FORMULARI">
	    	<span class="DH" style="width:150px;"><b>És un cicle?</b></span>
	    	<span class="DH checkbox_list">'.$FRESERVA['EsCicle']->render().'</span>
	    </div>

		<div style="clear: both;" class="FORMULARI">
	    	<span class="DH" style="width:150px;"><b>Comentaris</b></span>
	    	<span class="DH checkbox_list">'.$FRESERVA['Comentaris']->render().'</span>
	    </div>';
        
        
        
        if($FRESERVA->getObject()->getEstat() == ReservaespaisPeer::EN_ESPERA):
        
            $RET .= '<div style="clear: both;" class="FORMULARI">
	    	          <span class="DH" style="width:150px;"><b>Condicions</b></span>
	    	          <span class="DH checkbox_list"><a class="blue" href="'.url_for('web/espais#condicions').'" target="_BLANK">Llegeix les condicions</a><br /><span style="color: gray;"> Hauran de ser acceptades un cop validada la seva prereserva</span> </span>
	               </div>';
        else: 

            $RET .= '<div style="clear:both; padding-top:20px; " class="FORMULARI">
    			         <span class="DH" style="width:150px"></span>
    			         <span class="DH" style="width:450px">
                     </div>';
        
          $RET .= '<div style="clear: both;border-top:1px solid black;" class="FORMULARI">
	    	          <span class="DH" style="width:150px;"><b>Condicions</b></span>
	    	          <span class="DH checkbox_list">'.$FRESERVA['CondicionsCCG']->render().'</span>
	               </div>';                      
        endif; 

        $RET .= '<div style="clear:both; padding-top:20px; " class="FORMULARI">
			         <span class="DH" style="width:150px"></span>
			         <span class="DH" style="width:450px">
                 </div>';
            
        if($FRESERVA->getObject()->getEstat() == ReservaespaisPeer::EN_ESPERA):
	 	 $RET .= '
                <div style="text-align:right">
                    <button type="submit" id="BOTO_SUBMIT_RESERVA" name="BGUARDARESERVA" class="BOTO_ACTIVITAT" />
                        '.image_tag('template/disk.png').' Sol·liciteu la prereserva
                    </button>
                </div>';                                          
        elseif($FRESERVA->getObject()->getEstat() == ReservaespaisPeer::PENDENT_CONFIRMACIO):
        
	 	 $RET .= '
                <div style="text-align:right">
                    <button type="submit" id="BOTO_SUBMIT_RESERVA" name="BACCEPTACONDICIONSRESERVA" class="BOTO_ACTIVITAT" />
                        '.image_tag('template/accept.png').' Accepto les condicions i confirmo la reserva
                    </button>
                    <button type="submit" id="BOTO_SUBMIT_RESERVA" name="BANULACONDICIONSRESERVA" class="BOTO_ACTIVITAT" />
                        '.image_tag('template/cross.png').' No accepto les condicions i anul·lo la reserva
                    </button>
                </div>';                                          
                                                                                  			  					 					
		endif;		     
                    						 	  				 	  					        		                                   
		$RET .= '</span>
		  </div></fieldset></form>';        
        
        return $RET;	 
                
    }


function landing_page(){
?> 	    
        <br />   	   
	   	<p>
	   		Benvingut a la seva zona privada de la Casa de Cultura.<br /> 
	   		En aquest espai podrà accedir als serveis personalitzats que hem preparat per vostè.<br />
	   		Per accedir a qualsevol dels serveis podrà fer-ho a través del menú lateral esquerra <b>Zona privada</b> o a través d'aquesta mateixa pàgina.<br /> 
	   		<br />
	   	</p>	   		      
              
   <?php  
} 
    
    function LlistaDades($FDADES)
    {
    
        $OU = $FDADES->getObject();
        $Nom = $OU->getNomComplet();
        $Adreca = $OU->getAdreca();
        $Ciutat = $OU->getCodipostal(). ' - '.$OU->getPoblacioString();
        $Telefon = $OU->getTelefonString();
        $Email = $OU->getEmail();
    
        $RET = '
        <form name="gDades" action="'.url_for('gestio/uGestio').'" method="post">
               	       	   
    		   <TABLE class="FORMULARI">
    		   <tr><td width="100px"></td><td><td></tr>               
               <tr><td class="TITOL">Nom: </td><td>'.$Nom.'</td>		      
               <tr><td class="TITOL">Correu: </td><td>'.$Email.'</td>
               <tr><td class="TITOL">Telèfon: </td><td>'.$Telefon.'</td>
               <tr><td class="TITOL">Adreça: </td><td>'.$Adreca.'</td>
               <tr><td class="TITOL">Població: </td><td>'.$Ciutat.'</td>    		         		                         
    		   </TABLE>
               
                <div style="text-align:right">
                    <button type="submit" name="BGESTIONAUSUARI" class="BOTO_ACTIVITAT">
                        '.image_tag('template/disk.png').' Editeu les dades
                    </button>
                </div>

    	</form>';
        
        return $RET;	 
    
/*    
        $RET = '
            <form id="FOPTIONS" action="'.url_for('gestio/gConfig').'" method="POST" enctype="multipart/form-data">         	 	                                    
                <table class="FORMULARI">                    
                '.$FDADES.'                    
                </table>
                <div style="text-align:right">
                    <button type="submit" name="BGESTIONAUSUARI" class="BOTO_ACTIVITAT" onClick="return confirm(\'Segur que vols guardar els canvis?\')">
                        '.image_tag('template/disk.png').' Editeu les dades
                    </button>
                </div>                                                                                                            
            </form>';
                     
        return $RET;
*/            
    }

    function LlistaMatricules($MATRICULES)
    {
                
        $RET  = '<form action='.url_for('gestio/uGestio').'>';        
        if(sizeof($MATRICULES)==0):
            $RET .= 'No tenim constància informàtica que hagueu realitzat un curs a aquesta entitat. <br />Si no és així, si us plau notifiqueu-nos-ho.';
        else:
            $RET .= '<TABLE class="DADES">';
            $RET .= '<TR><TD class="titol">CODI</TD>
                         <TD class="titol">NOM</TD>
                         <TD class="titol">ESTAT</TD>
                         <TD class="titol">DATA MATRÍCULA</TD>
                         <TD class="titol">DESCOMPTE</TD></TR>';                                   


            foreach($MATRICULES as $M):
                $CURSOS = $M->getCursos();                           
    		   	$RET .= '<TR>
    		   			    <TD>
        						<a href="#TB_inline?height=480&width=640&inlineId=hidden'.$CURSOS->getIdcursos().'&modal=false" class="thickbox">'.$CURSOS->getCodi().'</a>
              					<div style="display:none" id="hidden'.$CURSOS->getIdcursos().'">'.$CURSOS->getDescripcio().'</div>
    				        </TD>		   				   			
                            <TD>'.$CURSOS->getTitolCurs().'</TD>
                            <TD>'.MatriculesPeer::getEstatText( $M->getEstat() ).'</TD>
                            <TD>'.$M->getDataInscripcio('d/m/Y H:i').'</TD>
                            <TD>'.MatriculesPeer::textDescomptes($M->getTReduccio()).'</TD>                                                                                             
    			     </TR>';                                   
            endforeach;                              		
            $RET .= '</TABLE>';
        endif;
        
        $RET .= '<br /><div style="text-align:right">
                    <button type="submit" name="BGESTIONAMATRICULES" class="BOTO_ACTIVITAT">
                        '.image_tag('template/new.png').' Nova matrícula
                    </button>
                 </div></form>';                                                                                                                            

        return $RET;           
           
    }
    
    function LlistaReserves($RESERVES)
    {
                     	     	
	    if(empty($RESERVES)):
        
            $RET = 'No s\'han trobat prereserves anteriors en aquesta entitat.';
            
        else:
        
            $RET  = '<TABLE class="DADES">';
            $RET .= '<TR><TD class="TITOL">Codi reserva</TD><TD class="TITOL">Nom activitat</TD><TD class="TITOL">Data sol·licitud</TD><TD class="TITOL">Estat</TD></TR>';
         
         	foreach($RESERVES as $R):     			
                $RET .= '   <TR>
                                <TD>'.link_to($R->getCodi(),'gestio/uGestio?accio=GESTIONA_RESERVES&idR='.$R->getReservaespaiid()).'</TD>                            
                                <TD>'.$R->getNom().'</TD>
                                <TD>'.$R->getDataalta('d/m/Y').'</TD>
                                <TD>'.$R->getEstatText().'</TD>                                                        
                            </TR>'; 
    		endforeach;
            $RET .= '</TABLE>';     

        endif;

        $RET .= '<br /><div style="text-align:right">
                    <button type="submit" name="BGESTIONARESERVES" class="BOTO_ACTIVITAT" onClick="return confirm(\'Segur que vols guardar els canvis?\')">
                        '.image_tag('template/new.png').' Nova reserva
                    </button>
                 </div>';                                                                                                                    

        
        return $RET;  
        
    }
    
    function LlistaCursos($LCURSOS,$DATA_INICI)
    {
        
        $RET  = '<form method="post" action="'.url_for('gestio/uGestio').'" id="FORM_CURSOS">';
        $RET .= '<FIELDSET class="REQUADRE"><LEGEND class="LLEGENDA">Cursos disponibles </LEGEND>';        
                                
        if(sizeof($LCURSOS) == 0):
        
            $RET .= 'Actualment no hi ha cap curs disponible.</fieldset></form>';
                            
        else: 
                            
            $RET .= '           
    				<TABLE class="DADES">
                    <tr>
    				    <td class="TITOL" colspan="2">CODI</td>						   	
    					<td class="TITOL">NOM</td>
    					<td class="TITOL">PREU</td>
    					<td class="TITOL" width="70px">INICI</td>
    					<td class="TITOL">PLACES</td>
    				</tr>';
            
    		$CAT_ANT = "";   
    		foreach($LCURSOS as $C):
                if($C->getVisibleweb() == 1):                      
                    if($CAT_ANT <> $C->getCategoria()) $RET .= '<TR><TD colspan="6" class="TITOL_CATEGORIA">'.$C->getCategoriaText().'</TD></TR>';                
                    $PLACES = $C->getPlacesArray(); 
                    $ple = ($PLACES['OCUPADES'] == $PLACES['TOTAL'])?"style=\"background-color:#FFCCCC;\"":"";
                    $jple = ($PLACES['OCUPADES'] == $PLACES['TOTAL']);                                                                                 					                       	
    		   		$RET .= '<TR>
    					       <TD '.$ple.'>'.radiobutton_tag('D[CURS]',$C->getIdcursos(),false,array('onClick'=>'ActivaBoto('.$jple.');','class'=>'class_cursos ')).'</TD>';					      		
    				$RET .= '  <TD '.$ple.'>';
                    $RET .= '       <a href="#TB_inline?height=480&width=640&inlineId=hidden'.$C->getIdcursos().'&modal=false" class="thickbox">
    					      				'.$C->getCodi().'
                                    </a>
    				                <div style="display: none;" id="hidden'.$C->getIdcursos().'">
                                            <div id="TEXT_WEB">
    			      						 '.$C->getDescripcio().'
                                            </div>
          							</div>
      		                    </TD>';
                    $RET .= '<TD '.$ple.'>'.$C->getTitolcurs().' ( '.$C->getHoraris().' ) </TD>';
                    $RET .= '<TD '.$ple.'>'.$C->getPreu().' €</TD>';      							
      		        $RET .= '<TD '.$ple.'>'.$C->getDatainici('d-m-Y').'</TD>';
      		        $RET .= '<TD '.$ple.'>'.$PLACES['OCUPADES'].'/'.$PLACES['TOTAL'].'</TD>';
       	            $RET .= '</TR>';                		                 										
                    $CAT_ANT = $C->getCategoria();
                endif;			   
    		endforeach;        					                         
    		$RET .= '</TABLE><br />';
                    
            $avui = time();                                                                                    
            if($DATA_INICI >= $avui):
                $BOT = "<div class=\"text\" style=\"font-weight:bold; \">El període de matrícules comença el dia ".date('d/m/Y',$DATA_INICI).'.<br /> Encara no es pot matricular.</div>';
            else: 
                $BOT = "";
                //$BOT = "<div>".submit_tag('Matriculeu-me',array('name'=>'BMATRICULA' , 'class'=>'BOTO_ACTIVITAT' , 'style'=>'width:100px')).'</div>';
            endif;                
                    
            $RET .= '   <TABLE class="FORMULARI" width="100%">					   		
                            <TR><TD width="100px;" style="font-size:10px;"><b>DESCOMPTE</b></TD><td>'.select_tag('D[DESCOMPTE]',options_for_select( MatriculesPeer::selectDescomptesWeb(),MatriculesPeer::REDUCCIO_CAP)).'</TD></TR>
    					   	<TR><TD width="100px"></TD>
                                <TD>'.$BOT.'<br />                                                                                                                                                                                                  
                                </TD>
                            </TR>
                        </TABLE>';        
            
            
            if(empty($BOT)):
                $RET .= '<div style="text-align:right">
                            <button type="submit" name="BMATRICULA" class="BOTO_ACTIVITAT">
                                '.image_tag('template/bookmark_document.png').' Matricular-me
                            </button>
                        </div>';
            endif; 
                    
            $RET .= '
                    </fieldset>                                                                
                 </form>                                            
                ';
        endif;      
                     
        return $RET;           
        
     }
     
    function MissatgeWeb($TITOL,$MISS)
    {                        
        $RET  = '<FIELDSET class="REQUADRE"><LEGEND class="LLEGENDA">'.$TITOL.'</LEGEND>';
        $RET .= '<DIV style="margin-right:20px;"><span class="TITOLAR">'.$MISS.'</span></DIV>';
        $RET .= '</FIELDSET>';
           
        return $RET;        
     }