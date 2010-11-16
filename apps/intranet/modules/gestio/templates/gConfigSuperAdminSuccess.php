<?php use_helper('Form') ?>

<style>
	
	.row { width:500px; } 
	.row_field { width:70%; } 
	.row_title { width:30%; }
	.row_field input { width:100%; }
	input.ul_cat { background-color:white; border:0px; width:20px; }
	li.ul_cat { width:220px; }
	#TD1 td { border: 0px solid #DB9296; padding:0px 2px; font-size:10px; }
	#TD1 { border-collapse:collapse; }
	.LIST2 { padding:10px;  } 
		
</style>

<script type="text/javascript">

	$(document).ready(function() {
		$( "#tabs" ).tabs({ cookie: { expires: 1 } });                
        $('#sites_site_id').change(function(){ $('#FSITES').submit(); });                        
	});

    //Funci� que captura de quin gen�ric parlem i busca els disponibles. 
	function ajaxOptions()
	{
		$("#options_valor").val('Carregant...');										
        $.post(
                '<?php echo url_for('gestio/gConfig?accio=AJAX_OPCIO') ?>',  
                { IDO: $('#options_option_id').val() } , 
                function(data) { $("#options_valor").val(data); }
            );                                                
                                                
    }
    	
	</script>


  
<TD colspan="3" class="CONTINGUT_ADMIN">	

	<?php include_partial('breadcumb',array('text'=>'CONFIGURACI�')); ?>		
		                   	                   	

    <div class="demo" style=" padding:20px; width:700px; ">    
        <div id="tabs">
        	<ul>        		        		        		
                <li><a href="#tabs-1">Entitats</a></li>
                <li><a href="#tabs-2">Permisos</a></li>                                                
                <li><a href="#tabs-3">Men�s Gesti�</a></li>
        	</ul>                        
        	<div id="tabs-1"> <?php echo EntitatsTab($FSITES); ?> </div>
        	<div id="tabs-2"> <?php echo PermisosTab($FUSERSITES); ?> </div>              	
            <div id="tabs-3"> <?php /*MenusgestioTab($FMENUS);*/ ?> </div>
        </div>
    
    </div>
    

<DIV STYLE="height:40px;"></DIV>

<?php 

    /**
     * Entitats Tab
     * */
    function EntitatsTab($FSITES)
    {
                
        $RET = '
            <form id="FSITES" action="'.url_for('gestio/gConfigSuperAdmin').'" method="POST" enctype="multipart/form-data">         	 	                                    
                <table class="FORMULARI">                    
                '.$FSITES.'                    
                </table>
                <div style="text-align:right">
                    <button style="margin-top:10px;" name="EDIT" class="BOTO_ACTIVITAT">
                        '.image_tag('template/find.png').' Consulta
                    </BUTTON>   
                    <button type="submit" name="BSAVESITE" class="BOTO_ACTIVITAT" onClick="return confirm(\'Segur que vols guardar els canvis?\')">
                        '.image_tag('template/disk.png').' Guardar i sortir
                    </button>
    	            <button type="submit" name="BDELETESITE" class="BOTO_PERILL" onClick="return confirm(\'Segur que vols esborrar-lo?\')">
                        '.image_tag('tango/16x16/status/user-trash-full.png').' Eliminar
                    </button>                    
                </div>                                                                                                            
            </form>';
                     
        return $RET;
        
    }


    /**
     * Permisos Tab
     * */
    function PermisosTab($FUSERSITES = "")
    {
        
        $RET = '
            <form id="FESPAIS" action="'.url_for('gestio/gConfigSuperAdmin').'" method="POST" enctype="multipart/form-data">         	 	                                    
                <table class="FORMULARI">                    
                '.$FUSERSITES.'                    
                </table>
                <div style="text-align:right">
                    <button style="margin-top:10px;" name="EDIT" class="BOTO_ACTIVITAT">
                        '.image_tag('template/find.png').' Consulta
                    </BUTTON>   
                    <button style="margin-top:10px;" name="BADDUSERSITE" class="BOTO_ACTIVITAT">
                        '.image_tag('template/new.png').' Nou
                    </BUTTON>
                    <button type="submit" name="BSAVEUSERSITE" class="BOTO_ACTIVITAT" onClick="return confirm(\'Segur que vols guardar els canvis?\')">
                        '.image_tag('template/disk.png').' Guardar i sortir
                    </button>
    	            <button type="submit" name="BDELETEUSERSITE" class="BOTO_PERILL" onClick="return confirm(\'Segur que vols esborrar-lo?\')">
                        '.image_tag('tango/16x16/status/user-trash-full.png').' Eliminar
                    </button>
                </div>                                                                                            
            </form>';
                     
        return $RET;
             
    }

    /**
     * Menus Gesti� Tab
     * */
    function MenusgestioTab($FESPAIS = "")
    {
        
        $RET = '
            <form id="FESPAIS" action="'.url_for('gestio/gConfig').'" method="POST" enctype="multipart/form-data">         	 	                                    
                <table class="FORMULARI">                    
                '.$FESPAIS.'                    
                </table>
                <div style="text-align:right">
                    <button style="margin-top:10px;" name="EDIT" class="BOTO_ACTIVITAT">
                        '.image_tag('template/find.png').' Consulta
                    </BUTTON>   
                    <button type="submit" name="BSAVEESPAI" class="BOTO_ACTIVITAT" onClick="return confirm(\'Segur que vols guardar els canvis?\')">
                        '.image_tag('template/disk.png').' Guardar i sortir
                    </button>
    	            <button type="submit" name="BDELETEESPAI" class="BOTO_PERILL" onClick="return confirm(\'Segur que vols esborrar-lo?\')">
                        '.image_tag('tango/16x16/status/user-trash-full.png').' Eliminar
                    </button>
                </div>                                                                                            
            </form>';
                     
        return $RET;
             
    }

?>