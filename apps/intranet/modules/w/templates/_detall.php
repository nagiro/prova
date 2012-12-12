<style>
    #HORARI_AMAGAT { display:none; }
</style>
<script>
    function VisibleHoraris(){ $("#HORARI_AMAGAT").show(); }    
</script>

                <div id="contingut_text" style="margin-top: 20px; width:610px;">

                    <?php if( $IMG != "" ): ?>
                        <!-- Imatge gran -->
                        <?php $style = ($IMG == 'color')?"background-color: rgb(".rand(1,255).",".rand(1,255).",".rand(1,255).");":"background-image: url('".$IMG."');"; ?>
                        <div style="width: 610px; height:295px; background-color:black; margin-bottom:20px; <?php echo $style ?>">&nbsp;</div>
                        <!-- Fi imatge gran -->
                    <?php endif; ?>
                    
                    <?php if( $HORARIS != "" || $TITOL != "" ): ?>
                        <div style="background-color: #817D74; color:white; margin-bottom:10px; width: 610px">
                            <div style="border-bottom: 1px solid white; font-size:14px; font-weight:bolder; padding:5px;"><?php echo $TITOL ?></div>
                            <div style="font-size: 12px; padding:5px;">
                                <?php echo converteixHorari($HORARIS) ?>
                            </div>
                        </div>
                    <?php endif; ?>
                                                            
                    <div style="font-size:11px; text-align:justify; margin-bottom:20px;">
                        <div style="padding: 10px;">
                            <?php echo $CONTINGUT ?>                    
                        </div>
                    </div>
                    
                    <?php if( $INFO_PRACTICA != "" ): ?>
                        <div style="background-color: #817D74; color:white; margin-left:315px; margin-bottom:60px; width: 295px;">
                            <div style="border-bottom: 1px solid white; font-size:14px; font-weight:bolder; padding:5px;">Informació pràctica</div>
                            <div style="font-size: 12px; padding:5px; min-height:70px; color:white;">
                                <?php echo $INFO_PRACTICA ?>
                            </div>
                        </div>                    
                    <?php endif; ?>
                                        
                    <?php include_partial( 'llistat', array( 'A_LLISTA' => $A_LLISTA ) ) ?>                    
                                        
                </div>
                <div style="clear: both;"></div>
                
                
<?php 

    //Converteix els horaris que arriben a format text. Pot arribar un objecte Array d'horaris o bé un text
    function converteixHorari($A_OH)
    {
        if( is_string( $A_OH ) ):
            return $A_OH;
        else: 
            if( sizeof($A_OH) > 0 ):
                $primer = null; $ultim = null;
                foreach($A_OH as $OH):            
                    if( is_null( $primer) ) $primer = $OH;
                    $ultim = $OH;
                endforeach;
                if($primer->getDia() == $ultim->getDia()):
                    $A_OE = $OH->getArrayEspais();
                    return 'El '.$primer->getDia('d/m').' a les '.$primer->getHorainici('H:i').' a '.$A_OE[0]->getNom();
                else: 
                    //Aquí hi he d'afegir poder veure més horaris
                    $EXPAND = "<div id=\"HORARI_AMAGAT\">";
                    foreach($A_OH as $OH):
                        $A_OE = $OH->getArrayEspais();                        
                        $EXPAND .= 'El '.myUser::getDiaText($OH->getDia()).' '.$OH->getDia('d/m').' a les '.$OH->getHorainici('H:i').' a '.$A_OE[0]->getNom().'<br />';
                    endforeach;
                    $EXPAND .= "</div>";                                        
                    return $EXPAND.'Del '.$primer->getDia('d/m').' al '.$ultim->getDia('d/m').' <span style="color:smokegray; font-size:8px; cursor: pointer; " onClick="VisibleHoraris()"> ( + Veure detall de dates )</span>';
                endif;         
            endif;
        endif;
    }



?>