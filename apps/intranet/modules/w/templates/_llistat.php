<?php $COLUMNES = 2 ?>
<?php $FILES = ( !isset($MAX_FILES) )?0:$MAX_FILES; ?>
<!-- 

    $this->A_LLISTA[1]['mode'] = 2;
    $this->A_LLISTA[1]['titol'] = "Categories dins aquest menú";
    foreach($AON as $ON):                            
        $this->A_LLISTA[1]['elements'][] = array('titol' => $ON->getTitolmenu() , 'img' => $ON->getIdnodes());                            
    endforeach;    

-->
<?php function mostraElement($LLE){ ?>

    <div onclick="segueix_url('<?php echo url_for($LLE['url'],true) ?>')" class="requadre_no_imatge"> 
        <?php echo $LLE['titol'] ?> 
    </div>
    
<?php } ?>

<?php function mostraImatge($class , $titol , $img , $url , $id, $COLUMNES ) { ?>
    
    <?php $A_COLORS = array(1=>'#A0C3CB',2=>'#9599AF',3=>'#B78485',4=>'#E8D131'); ?>    
    <?php $style = ($img == 'color')?"background-color: #F0ECE6;":"background-image: url('".$img."');"; ?>
    <?php if($id % $COLUMNES != 0): ?>
    <div class="fila">        
        <div onclick="segueix_url('<?php echo url_for($url,true) ?>')" class="<?php echo $class ?>" style="<?php echo $style ?>">
            <div onclick="segueix_url('<?php echo url_for($url,true) ?>')" class="fila_imatge_text"><b><?php echo $titol ?></b></div>
        </div>
    <?php elseif($id % $COLUMNES == 0): ?>
        <div onclick="segueix_url('<?php echo url_for($url,true) ?>')" class="<?php echo $class ?>" style="<?php echo $style ?> margin-left:20px;">
            <div class="fila_imatge_text"><b><?php echo $titol ?></b></div>
        </div>
    </div>
    <?php endif; ?>    
<?php } ?>
                                
                    <?php $j = 0 ?>
                    <?php foreach( $A_LLISTA as $LLISTA ): ?>
                    <?php $j++ ?>                            
                                                                    
                        <?php if( !empty( $LLISTA['elements'] ) ): ?>
                        
                            <div class="menu_titol_llarg"><div><?php echo $LLISTA['titol']?></div></div>
                                                                            
                            <?php $i = -1; foreach($LLISTA['elements'] as $ID => $LLE): ?>
                    
                                <?php if($LLISTA['mode'] == 1): ?>
                                
                                    <?php echo mostraImatge( 'fila_imatge' , $LLE['titol'] , $LLE['img'] , $LLE['url'] , $i++ , $COLUMNES ) ?>
                                    
                                <?php elseif($LLISTA['mode'] == 2): ?>
                                
                                    <?php echo mostraImatge( 'fila_imatge_mig' , $LLE['titol'] , $LLE['img'] , $LLE['url'] , $i++ , $COLUMNES ) ?>
                                                                                                
                                <?php elseif($LLISTA['mode'] == 3): ?>
                                                                     
                                    <?php                                                                                                                                                                                         
                                        if($FILES == 0)
                                            echo mostraElement( $LLE );
                                        else
                                        {
                                            if( ++$i < $FILES ){
                                                
                                                echo mostraElement( $LLE );
                                                                                        
                                            } else {
                                            
                                                if( $i % $FILES == 0 && sizeof( $LLISTA['elements'] ) > 5 ){
                                                    if( $i > $FILES ){ echo '</div>'; }
                                                    echo '<div id="amaga_'.$j.$i.'" onclick="mostra('.$j.$i.')" class="requadre_no_imatge_more"> Veure més activitats </div>';
                                                    echo '<div id="mostra_'.$j.$i.'"  style="display:none;">';    
                                                }
                                                echo mostraElement( $LLE );                                                                                                                               
                                            }                                                                                                                
                                        }
                                     ?>                                                                                                                    
                                                                                                                                                                                                                                                                                                                                                                                                                                       
                                <?php endif; ?>
                                
                            <?php endforeach; ?>
                            
                            <?php // En el cas que el total d'elements, no sigui parell, posem l'últim div per tancar. ?>
                                                    
                            <?php if( ( sizeof( $LLISTA['elements'] ) % $COLUMNES ) != 0 && ( $LLISTA['mode'] == 1 || $LLISTA['mode'] == 2 ) ): echo "</div>"; endif; ?>
                            <?php if( ( sizeof( $LLISTA['elements'] ) % $FILES ) != 0 && ( sizeof( $LLISTA['elements'] ) ) > 5 &&  $LLISTA['mode'] == 3 && $FILES > 0 ) echo '</div>'; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                