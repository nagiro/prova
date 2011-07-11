<script type="text/javascript">

    $(document).ready(function() {
            $("#tabs").tabs({ cookie: { expires: 30 } });                                         
        });
        
</script>

<div class="h_subtitle_gray">
    CERCADOR DE CURSOS
</div>

<div id="tabs">
	<ul>
		<li><a href="#tabs-1">Cercador...</a></li>					
	</ul>
    
	<div class="taula_dades" id="tabs-1">

    <form action="<?php echo url_for('@hospici_cercador_cursos')?>" method="POST">

        <div style="float: left; width: 600px;">
            <div style="margin: 5px;">
                <b>Text a cercar</b><br /><input type="text" id="R_TEXT" name="cerca[TEXT]" value="<?php echo $CERCA['TEXT'] ?>" style="width: 500px;" />
            </div>
        </div>                
        <div style="clear:both; float: left;">
            <div style="margin: 5px;">
                <b>Població</b><br /><?php echo select_tag( 'cerca[POBLE]', options_for_select( $DESPLEGABLES['SELECT_POBLACIONS'] , $CERCA['POBLE'] ), array( 'style'=>'background-color:#EEEEEE; border:1px solid #CCCCCC; padding:2px; width:250px;','id'=>'R_ON' )); ?>
            </div>
        </div>
        <div style="float: left;">
            <div style="margin: 5px;">            
                <b>Entitat</b><br /><?php echo select_tag( 'cerca[SITE]', options_for_select( $DESPLEGABLES['SELECT_ENTITATS'] , $CERCA['SITE'] ), array( 'style'=>'background-color:#EEEEEE; border:1px solid #CCCCCC; padding:2px; width:250px;','id'=>'R_ON' )); ?>
            </div>
        </div>
        <div style="float: left;">
            <div style="margin: 5px;">            
                <b>Categoria</b><br /><?php echo select_tag( 'cerca[CATEGORIA]', options_for_select( $DESPLEGABLES['SELECT_CATEGORIES'] , $CERCA['CATEGORIA'] ), array( 'style'=>'background-color:#EEEEEE; border:1px solid #CCCCCC; padding:2px; width:250px;','id'=>'R_ON' )); ?>
            </div>
        </div>
        <div style="float: left;">
            <div style="margin: 5px;">            
                <b>Quan</b><br /><?php echo select_tag( 'cerca[DATA]', options_for_select( $DESPLEGABLES['SELECT_DATES'] , $CERCA['DATA'] ), array( 'style'=>'background-color:#EEEEEE; border:1px solid #CCCCCC; padding:2px; width:250px;','id'=>'R_ON' )); ?>
            </div>
        </div>

        <div style="clear:both; float: left; width:400px;">            
            <div style="float: left; margin-right:5px; margin-top:4px;">
                <input type="hidden" name="cerca[P]" value="1" style="height:30px; width:100px;" />                                                
            </div>
        </div>
        
        <div style="float: right; margin-right:5px; margin-top:4px;">
            <input type="submit" value="Cerca!" style="height:30px; width:100px;" />                                
        </div>
        
        <div style="clear: both;"></div>                     
    </form>  
	</div>
    
        
</div>