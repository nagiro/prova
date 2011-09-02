<script type="text/javascript">

    $(document).ready(function(){
            $("#tabs").tabs({ cookie: { expires: 30 } });
            
            $("#R_POBLE").change(function(){ $("#formulari").submit(); });
            $("#R_SITE").change(function(){ $("#formulari").submit(); });
            $("#R_CATEGORIA").change(function(){ $("#formulari").submit(); });            
            
            
        });
        
</script>

<div class="h_subtitle_gray">
    CERCADOR D'ESPAIS
</div>

<div style="border:1px solid #CCCCCC; border-radius: 5px;">
    <div style="padding: 10px;">

	<div class="taula_dades">

    <form id="formulari" action="<?php echo url_for('@hospici_cercador_espais')?>" method="post">

        <div style="float: left; width: 600px;">
            <div style="margin: 5px;">
                <b>Text a cercar</b><br /><input type="text" id="R_TEXT" name="cerca[TEXT]" value="<?php echo $CERCA['TEXT'] ?>" class="input_common" style="width: 500px;" />
            </div>
        </div>
        <div style="clear:both; float: left;">
            <div style="margin: 5px;">
                <b>Població</b><br /><?php echo select_tag( 'cerca[POBLE]', options_for_select( $DESPLEGABLES['SELECT_POBLACIONS'] , $CERCA['POBLE'] ), array('class'=>'input_common','style'=>'width:250px;','id'=>'R_POBLE' )); ?>
            </div>
        </div>
        <div style="float: left;">
            <div style="margin: 5px;">            
                <b>Entitat</b><br /><?php echo select_tag( 'cerca[SITE]', options_for_select( $DESPLEGABLES['SELECT_ENTITATS'] , $CERCA['SITE'] ), array('class'=>'input_common','style'=>'width:250px;','id'=>'R_SITE' )); ?>
            </div>
        </div>

        <div style="float: left;">
            <div style="margin: 5px;">            
                <b>Categoria</b><br /><?php echo select_tag( 'cerca[CATEGORIA]', options_for_select( $DESPLEGABLES['SELECT_CATEGORIES'] , $CERCA['SITE'] ), array('class'=>'input_common','style'=>'width:250px;','id'=>'R_CATEGORIA' )); ?>
            </div>
        </div>
        
        <div style="float: right; margin-right:5px; margin-top:4px;">
            <input type="submit" value="Cerca!" style="height:30px; width:100px;" />                                
        </div>
        
        <div style="clear: both;"></div>                     
    </form>  
	</div>


    </div>
</div>