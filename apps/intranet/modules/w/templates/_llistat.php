<!-- 

    $this->A_LLISTA[1]['mode'] = 2;
    $this->A_LLISTA[1]['titol'] = "Categories dins aquest menú";
    foreach($AON as $ON):                            
        $this->A_LLISTA[1]['elements'][] = array('titol' => $ON->getTitolmenu() , 'img' => $ON->getIdnodes());                            
    endforeach;    

-->

<?php function mostraImatge($class , $titol , $img , $url , $id) { ?>
    
    <?php $A_COLORS = array(1=>'#A0C3CB',2=>'#9599AF',3=>'#B78485',4=>'#E8D131'); ?>    
    <?php $style = ($img == 'color')?"background-color: #F0ECE6;":"background-image: url('".$img."');"; ?>
    <?php if($id % 2 != 0): ?>
    <div class="fila">        
        <div onclick="segueix_url('<?php echo url_for($url,true) ?>')" class="<?php echo $class ?>" style="<?php echo $style ?>">
            <div onclick="segueix_url('<?php echo url_for($url,true) ?>')" class="fila_imatge_text"><b><?php echo $titol ?></b></div>
        </div>
    <?php elseif($id % 2 == 0): ?>
        <div onclick="segueix_url('<?php echo url_for($url,true) ?>')" class="<?php echo $class ?>" style="<?php echo $style ?> margin-left:20px;">
            <div class="fila_imatge_text"><b><?php echo $titol ?></b></div>
        </div>
    </div>
    <?php endif; ?>    
<?php } ?>
                                
                    <?php foreach( $A_LLISTA as $LLISTA ): ?>                            
                    
                        <div class="menu_titol_llarg"><div><?php echo $LLISTA['titol']?></div></div>                        
                        <?php if( !empty( $LLISTA['elements'] ) ): ?>                                                
                            <?php $i = 1; foreach($LLISTA['elements'] as $ID => $LLE): ?>
                    
                                <?php if($LLISTA['mode'] == 1): ?>
                                
                                    <?php echo mostraImatge( 'fila_imatge' , $LLE['titol'] , $LLE['img'] , $LLE['url'] , $i++ ) ?>
                                    
                                <?php elseif($LLISTA['mode'] == 2): ?>
                                
                                    <?php echo mostraImatge( 'fila_imatge_mig' , $LLE['titol'] , $LLE['img'] , $LLE['url'] , $i++ ) ?>
                                                                                                
                                <?php elseif($LLISTA['mode'] == 3): ?>
                                 
                                    <div onclick="segueix_url('<?php echo url_for($LLE['url'],true) ?>')" class="requadre_no_imatge">
                                        <?php echo $LLE['titol'] ?>
                                    </div>
                                                                                                                                              
                                <?php endif; ?>
                                
                            <?php endforeach; ?>
                            
                            <?php // En el cas que el total d'elements, no sigui parell, posem l'últim div per tancar. ?>
                                                    
                            <?php if( ( sizeof( $LLISTA['elements'] ) % 2 ) != 0 && ( $LLISTA['mode'] == 1 || $LLISTA['mode'] == 2 ) ): echo "</div>"; endif; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                