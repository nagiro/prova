<?php 

/**
 * Variables utilitzades a aquest partial
 * $DIRECTORI_WEB = '/images/activitats/';
 * $NOM_ARXIU = 'A-'.$IDA; 
 * */

//Mirem tots els arxius d'imatge que hi ha amb aquesta activitat
$dir = getcwd().$DIRECTORI_WEB; 
$mini = false; $normal = false; $big = false; $pdf = false; 
foreach ( glob( $dir.$NOM_ARXIU."*" ) as $K => $arxiu ) {    
    $a = str_replace( $dir , "", $arxiu );    
    //Si té un -M és la foto mini.
    if( substr_count( $arxiu , "-M" ) > 0   && !substr_count($arxiu , "--" ) )      $mini    = $a;
    if( substr_count( $arxiu , "-L" ) > 0   && !substr_count($arxiu , "--" ) )      $normal  = $a;
    if( substr_count( $arxiu , "-XL" ) > 0  && !substr_count($arxiu , "--" ) )     $big     = $a;
    if( substr_count( $arxiu , "-PDF" ) > 0 && !substr_count($arxiu , "--" ) )    $pdf     = $a;
}

?>
<script>
        
    /** Aquesta funció genera un botó d'upload **/
    function genUpload( ELEMENT , URL , TEXT ){
        
        $(ELEMENT).html("");
                    
        var uploader = new qq.FileUploader({            
            element: document.getElementById( ELEMENT ),
            uploadButtonText: TEXT,
            action: '<?php echo url_for('gestio/Upload') ?>',
            debug: false,
            onSubmit: function(){ uploader.setParams({ NOM_ARXIU: URL , OPCIO: 'UPLOAD' }); },                        
        });
    }
                          
    function genDelete( ELEMENT , ELEMENT2 , URL , URL2 , TEXT ){
        $(ELEMENT).click(function(){                                    
            $.post("<?php echo url_for('gestio/Upload') ?>", { OPCIO: 'DELETE', NOM_ARXIU: URL },
            function(data) {                                        
                if(data == 'ok') { genUpload( ELEMENT2 , URL2 , TEXT ); }                                     
            });
            return false;
        });

    }

</script>


<div style="clear: both; padding-top:20px;">

    <div style="float:left;" id="B1">
    
        <?php if( !$mini ): ?>
            <script>genUpload( "B1" , "<?php echo $DIRECTORI_WEB . $NOM_ARXIU . '-M' ?>" , "FOTO MINI" );</script>
        <?php else: ?>                                                
            <img width="100px" src="<?php echo $DIRECTORI_WEB . $mini ?>" />
            <br /><a id="DEL_B1" href="#" >Esborra-la</a>
            <script>genDelete( '#DEL_B1' , '#B1' , '<?php echo $DIRECTORI_WEB.$mini ?>' , '<?php echo $DIRECTORI_WEB . $NOM_ARXIU . '-M' ?>' , 'FOTO MINI' );</script>
        <?php endif; ?>
                          
    </div>                                      

    <div style="float:left; margin-left:20px;" id="B2">
    
        <?php if( !$normal ): ?>
            <script> genUpload( "B2" , "<?php echo $DIRECTORI_WEB . $NOM_ARXIU . '-L' ?>" , "FOTO NORMAL" ); </script>
        <?php else: ?>                                                
            <img width="100px" src="<?php echo $DIRECTORI_WEB.$normal ?> " />
            <br /><a id="DEL_B2" href="#" >Esborra-la</a>
            <script>genDelete( '#DEL_B2' , '#B2' , '<?php echo $DIRECTORI_WEB.$normal ?>' , '<?php echo $DIRECTORI_WEB . $NOM_ARXIU . '-L' ?>' , 'FOTO NORMAL' );</script>        
        <?php endif; ?>
                                
    </div>


    <div style="float:left; margin-left:20px;" id="B3">
    
        <?php if( !$big ): ?>
        
            <script>genUpload( "B3" , "<?php echo $DIRECTORI_WEB . $NOM_ARXIU . '-XL' ?>" , "FOTO GRAN" );</script>
            
        <?php else: ?>
                                                        
            <img width="100px" src="<?php echo $DIRECTORI_WEB.$big ?>" />
            <br /><a id="DEL_B3" href="#" >Esborra-la</a>
            <script>genDelete( '#DEL_B3' , '#B3' , '<?php echo $DIRECTORI_WEB.$big ?>' , '<?php echo $DIRECTORI_WEB . $NOM_ARXIU . '-XL' ?>' , 'FOTO GRAN' );</script>
                                        
        <?php endif; ?>                        
    
    </div>
                                        

    <div style="float:left; margin-left:20px;" id="B4">
    
        <?php if( !$pdf ): ?>
            <script>genUpload( "B4" , "<?php echo $DIRECTORI_WEB . $NOM_ARXIU . '-PDF' ?>" , "PDF" );</script>
        <?php else: ?>                                                
            <a href="<?php echo $DIRECTORI_WEB.$pdf ?>" >Baixa't el pdf</a>
            <br /><a id="DEL_B4" href="#" >Esborra'l</a>
            <script>genDelete( '#DEL_B4' , '#B4' , '<?php echo $DIRECTORI_WEB.$pdf ?>' , '<?php echo $DIRECTORI_WEB . $NOM_ARXIU . '-PDF' ?>' , 'PDF' );</script>        
        <?php endif; ?>      
    
    </div>
               
</div>                         