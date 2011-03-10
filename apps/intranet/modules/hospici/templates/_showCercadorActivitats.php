<script type="text/javascript">

    $(document).ready(function() {                                                
            $( "#R_ON" ).click(CarregaCategories);
            CarregaCategories();
            $( "#RANG" ).hide();
            $( "#DATA" ).click(RangDeDates);
            RangDeDates();                
            $("#DI").datepicker($.datepicker.regional['ca']);
            $("#DF").datepicker($.datepicker.regional['ca']);                                         
        });

    function RangDeDates(){
        if($( "#DATA" ).val() == 5) { 
            $( "#RANG" ).show(500); 
        } else {
            $( "#RANG" ).hide();
        } 
    }
        
    function CarregaCategories(){            
        $("#R_CAT").html('<option>Carregant...</option>');            
        $.post( '<?php echo url_for('hospici/ajaxON') ?>', 
                { ON: $("#R_ON").val(), SEL: '<?php echo $CERCA['CATEGORIA'][0]; ?>' }, 
                function(data){
                    /// Ponemos la respuesta de nuestro script en el DIV recargado                                
                    $("#R_CAT").html(data);
                });
    }
                    
        
</script>

<div class="h_subtitle_gray c1">
    CERCADOR D'ACTIVITATS
</div>

<form action="<?php url_for('hospici/index')?>" method="POST">

<div id="h_cercador">                

    <div id="h_cercador" class="h_requadre_cercador">
        <div style="padding:10px;">
            <div style="float: left; ">                                
                <?php echo select_tag('cerca[POBLE]',options_for_select(ActivitatsPeer::selectPoblesActivitats(),$CERCA['POBLE'][0]),array('multiple'=>'multiple','style'=>'height:130px; width:185px;','id'=>'R_ON')); ?>
            </div>
            <div id="DIV_SEL_CAT" style="float: left;margin-left:10px;">                                                                
                <?php echo select_tag('cerca[CATEGORIA]',options_for_select(ActivitatsPeer::selectCategoriesActivitats($CERCA['POBLE'][0]),$CERCA['CATEGORIA'][0]),array('multiple'=>'multiple','style'=>'height:130px; width:185px;','id'=>'R_CAT')); ?>           
            </div>
            <div style="float: left;margin-left:10px;">
                <select id="DATA" name="cerca[DATA]" multiple="multiple" style="height:130px; width:185px;">
                    <?php                                     
                        echo options_for_select(array(
                                                    0=>'Avui',
                                                    1=>'Aquest cap de setmana',
                                                    2=>'En 7 dies',
                                                    3=>'En 15 dies',
                                                    4=>'En 30 dies',
                                                    5=>'Rang de dates'),$CERCA['DATA']);                                        
                        
                    ?>
                </select>           
            </div>                            
            <div id="RANG" style="clear:both; float: left; margin-right:5px; margin-top:4px;">
                Des de: <input type="text" id="DI" name="cerca[DATA_R][DI]" style="height:30px; width:100px;" />
                Fins a: <input type="text" id="DF" name="cerca[DATA_R][DF]" style="height:30px; width:100px;" />
            </div>
            <div style="float: left; margin-right:5px; margin-top:4px;">
                <input type="hidden" name="cerca[P]" value="1" style="height:30px; width:100px;" />                                
            </div>
            
            <div style="float: right; margin-right:5px; margin-top:4px;">
                <input type="submit" value="Cerca!" style="height:30px; width:100px;" />
            </div>
        </div>                                                             
    </div>
    
</div>
</form>