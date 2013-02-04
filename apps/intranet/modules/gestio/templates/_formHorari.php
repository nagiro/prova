<?php use_helper('Form') ?>

<?php 

    /**
     * És el formulari de cada Horari.
     * @param $OH instanceof Horaris 
     * */

    $FHorari = new HorarisForm($OH);                        
    $EXTRES['ESPAISOUT'] = $OH->getArrayHorarisEspaisActiusAgrupats();                    
    $EXTRES['MATERIALOUT'] = $OH->getArrayHorarisEspaisMaterial();                                        
    $EXTRES['ESPAIEXTERN'] = $OH->getEspaiExternForm();    

?> 


<script>

	 $(document).ready(function() {	
		 $("#id").val(1);														//Inicialitzem el valor identificador de nou camp a 1								
		 $("#mesmaterial").click( function() { creaFormMaterial(); });			//Marquem que a cada click es farà un nou formulari
		 $("#mesespais").click( function () { creaFormEspais(); });
        
                 
        //Si l'espai que tenim és un espai extern ho mostrem directament.
        <?php if(isset($EXTRES['ESPAIEXTERN']) && $EXTRES['ESPAIEXTERN']->getObject()->getPoble() <= 0){ ?>                                
        $("#formulari_lloc_extern").hide(0);
        $('#a_lloc_extern').click(function(){ 
            $('#div_lloc_extern').hide(); 
            $('#formulari_lloc_extern').fadeIn(1000); 
        });
        <?php } else { ?>
            $('#div_lloc_extern').hide(); 
            $('#formulari_lloc_extern').fadeIn(1000);              
        <?php } ?>
        
        $('#multi999Datepicker').datepick( {
            numberOfMonths: 3, 
            multiSelect: 999, 
            showOn: 'both', 
            buttonImageOnly: true, 
            buttonImage: '<?php echo image_path('template/calendar_1.png')?>'
        });               			    
        
    });                                               

                        
// ---------------------- FUNCIONS DE CARREGA DE MATERIAL ------------------------------------


    //Treu linies de material i espais
    function esborraLinia(id) { $("#row\\["+id+"\\]").remove(); }
	function esborraLiniaE(id) { $("#rowE\\["+id+"\\]").remove(); }
    

    //Funció que captura de quin genèric parlem i busca els disponibles. 
	function ajax(d, iCtrl)
	{
												
        $.get(
                '<?php echo url_for('gestio/AjaxSelectMaterial') ?>',  
                { dies: $('#multi999Datepicker').val() , 
                  horapre: $('#horaris_HoraPre_hour').val()+':'+$('#horaris_HoraPre_minute').val() ,
                  horapost: $('#horaris_HoraPost_hour').val()+':'+$('#horaris_HoraPost_minute').val(),
                  generic: d.value 
                } , 
                function(data) { $("select#material\\["+iCtrl+"\\]").html(data); }
            );                                                
                                                
    }
    
    //Generem el desplegable de material genèric
	function creaFormMaterial()
	{
		
		var id = $("#idV").val();        		
		id = (parseInt(id) + parseInt(1));
		$("#idV").val(id);				                        
        				
        var options = '<?php echo MaterialgenericPeer::selectAjax($OH->getSiteId()) ?>';        
		$("#divTxt").append(
                        '<span id="row['+id+']">'+
                        '<select onChange="ajax(this,'+id+')" name="generic[' + id + ']"> id="generic[' + id + ']">' + options + '</select>'+
                        '<select name="material[' + id + ']" id="material[' + id + ']"></select>' +
                        '<input type="button" style="width:30px;" onClick="esborraLinia('+id+');" id="mesmaterial" value="-"></input><br /></span>');
		ajax($("generic\\["+id+"\\]"),id);  //Carreguem el primer																	
	}

    //Generem el desplegable dels espais
	function creaFormEspais()
	{
				
		var id = $("#idE").val();
		id = (parseInt(id) + parseInt(1));
		$("#idE").val(id);
		
		var options = '<?php echo EspaisPeer::selectJavascript($OH->getSiteId()); ?>';
		$("#divTxtE").append(
            '<span id="rowE['+id+']">' +
            '<select name="espais['+id+']" id="espais['+id+']">'+ options +'</select>'+
            ' <input type="button" style="width:30px;" onClick="esborraLiniaE('+id+');" id="mesespais" value="-"></input>' + 
            '<br /></span>');

	}		
	
    // ---------------------------------- FI FUNCIONS DE CÀRREGA DE MATERIAL ---------------------------------------------        
                                                                          	 
</script>

    <div id="MISSATGE"></div>

    <form id="FORM_HORARI" action="<?php echo url_for('gestio/gActivitats') ?>" method="POST">          	            
     	     	 		
     		<div class="TITOL">
             
             <?php if(!$FHorari->isNew()):?>
             Edició horaris ( <?php echo link_to('convertir en activitat independent','gestio/gActivitats?accio=DESDOBLAR&IDH='.$OH->getHorarisid()); ?> )
             <?php endif; ?>
               
            </div>            
            <br />                                                
            <div class="FORMULARI">                   
    
               	<?php echo $FHorari?>
                                                        
                <div class="clear row fb">
                    <span class="title row_title fb"><b>Espais: </b></span>
                    <span class="row_field fb">
                     	<?php                         
            				$id = 1;  $VAL = "";                             	            	
                     		foreach($EXTRES['ESPAISOUT'] AS $idE=>$nom):
                                if(!empty($idE)){
                             		$VAL .= '<span id="rowE['.$id.']">
                             					<select name="espais['.$id.']" id="espais['.$id.']">'.EspaisPeer::selectJavascript( $OH->getSiteId() , $idE ).'</select>
                             					<input type="button" style="width:30px;" onClick="esborraLiniaE('.$id.');" id="mesespais" value="-"></input>
                             					<br />
                             			  	 </span>
                             			  ';
                             		      $id++;      	
                                }
                     		endforeach;
            
                     		echo '<input type="button" id="mesespais" style="width:30px;" value="+"></input><br />';             		             		             		             		    				   
            				echo '<input type="hidden" id="idE" value="'.$id.'"></input>';   					
            			    echo '<div id="divTxtE">'.$VAL.'</div>';
                     	?>
                    </span>
                </div>
                <div class="clear row fb">
                    <span class="title row_title fb"><b>Material: </b></span>
                    <span class="row_field fb">
                     	<?php 
            				$id = 1;  $VAL = "";                                                				                                                        	
                     		foreach($EXTRES['MATERIALOUT'] AS $M=>$idM):                
                     		$VAL .= '
             	  	        		<span id="row['.$id.']">
             	  	        			<select onChange="ajax(this,'.$id.')" name="generic['.$id.']"> id="generic['.$id.']">'.options_for_select(MaterialgenericPeer::select($IDS),$idM['generic']).'</select>
             	  	        			<select name="material['.$id.']" id="material['.$id.']">'.options_for_select(MaterialPeer::selectGeneric( $idM['generic'] , $OH->getSiteId() , $idM['material']) , $idM['material'] ).'</select>	
             	  	        			<input type="button" style="width:30px;" onClick="esborraLinia('.$id.');" id="mesmaterial" value="-"></input>
             	  	        			<br />
             	  	        		</span>  	 	  	        			
                     			  ';
                     		      $id++;      	             		      
                     		                   		      	
                     		endforeach;					
                     		echo '<input type="button" id="mesmaterial" style="width:30px;" value="+"></input><br />';
                     		echo '<input type="hidden" id="idV" value="'.$id.'"></input>';   					
            			    echo '<div id="divTxt">'.$VAL.'</div>';
                     						    
                     	?>             	             	                         		
                    </span>
                </div>
                <div class="clear"></div>
                <div id="div_lloc_extern" class="clear row fb">
                    <span class="title row_title fb"><b>Opcions: </b></span>
                    <span class="row_field fb">
                        <a href="#" id="a_lloc_extern">L'activitat es realitza a un lloc extern</a>                     	          	             	            
                    </span>
                </div>                    
                
                <div id="formulari_lloc_extern">
                    <div><b>Població externa</b><br /><br /></div>                    
                    <?php echo $EXTRES['ESPAIEXTERN']; ?>                            
                    <div class="clear"></div>                                        
                </div>
                                       				
      	 </div>
         <div class="clear"></div>
    
        
    <script type="text/javascript">
    	$(function() {			     
                   $('#multi999Datepicker').datepick({numberOfMonths: 3, multiSelect: 999, showOn: 'both', buttonImageOnly: true, buttonImage: '<?php echo image_path('template/calendar_1.png')?>'});               			
        });   
    </script>
            
     </form>     
