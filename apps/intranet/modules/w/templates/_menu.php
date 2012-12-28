<style>
    .menu_hidden { display: none; }
</style>
<script>

    $(document).ready(function(){
        
        $('#properament_0').removeClass('menu_hidden');
        $('#cicles_0').removeClass('menu_hidden');
                
    });
    
    function visible( id , a ){           
        $('[id*="' + id + '"]').each(function(){ $(this).addClass('menu_hidden'); });
        $('#' + id + a).removeClass('menu_hidden');        
    }
    
</script>                
                <div id="menu_esquerra">
                
                    <div style="margin-bottom: 20px; overflow:hidden; ">
                        <div id="logo">&nbsp;</div>
                    </div>

                    <?php if( $MODE != 'home' ): ?>

                    <div style="margin-bottom: 50px;">                                                
                        <?php foreach($A_MENU as $ON): ?>
                            <?php if( $SELECCIONAT instanceof Nodes ) $color = ( $SELECCIONAT->getIdnodes() == $ON->getIdnodes() )?"background-color:inherit":""; ?>
                            <?php if($ON->getIdnodes() == 60): ?>                                               
                                <div class="menu_titol menu_esquerra" style="<?php echo $color ?>" onclick="segueix_url('<?php echo url_for('@web_menu_click_noticies?idNoticia=0&titol=Noticies') ?>')" id="menu_<?php echo $ON->getIdnodes() ?>"><div><?php echo $ON->getTitolMenu() ?></div></div>                                                                                                                        
                            <?php elseif($ON->getNivell() == 1): ?>                                                                                                         
                                <div class="menu_titol menu_esquerra" style="<?php echo $color ?>" onclick="segueix_url('<?php echo url_for('@web_menu_click?node='.$ON->getIdnodes().'&titol='.$ON->getNomForUrl()) ?>')" id="menu_<?php echo $ON->getIdnodes() ?>"><div><?php echo $ON->getTitolMenu() ?></div></div>                                
                            <?php endif; ?>                            
                        <?php endforeach ?>                        
                    </div>
                    
                    <?php endif; ?>
                
                    <!-- AVUI -->
                    <div style="">
                        <div class="menu_titol"><div>Avui a la Casa de Cultura</div></div>
                        
                        <?php foreach( $A_ACTIVITATS_AVUI as $OA ): ?>
                        <?php   $OH = $OA->getHorariDia(date('Y-m-d',time())); ?>
                        <?php   $OC = $OA->getCicles(); ?>
                        <?php   if($OH instanceof Horaris) $Espai = $OH->getArrayEspais(); else $Espai = array(); ?>                                                
                        <?php   if($OC instanceof Cicles): $Nom_Cicle = $OC->getTMig(); else: $Nom_Cicle = "n/d"; endif; ?>
                        <?php   if($OA instanceof Activitats): $Nom_Activitat = $OA->getTMig(); else: $Nom_Activitat = "n/d"; endif; ?>                        
                        
                        <div class="menu_activitat">
                            <div class="menu_activitat_text" onclick="segueix_url('<?php echo url_for('@web_menu_click_activitat?idCicle='.$OC->getCicleid().'&idActivitat='.$OA->getActivitatid().'&titol='.$OA->getNomForUrl()) ?>')">
                                <?php echo $Nom_Activitat . ' | ' . $OH->getHorainici( 'H.i' ) . 'h' .' | '.$Nom_Cicle; ?>           
                            </div>
                        </div>
                        
                        <?php endforeach; ?>
                                                                        
                    </div>
                    <!-- AVUI -->
                    
                    <!-- PROPERAMENT -->                    
                    <div>
                        <div class="menu_titol" style="margin-top: 20px;"><div>Properament</div></div>
                                               
                        <?php 
                            
                            $i = 0; $quants = 3; $j = 0; $activitats_ja_aparegudes = array();                            
                            foreach( $A_ACTIVITATS_FUTURES as $OH ){
                                                                                                                                                               
                                //Inicialitzem les variables
                                $Data_Activitat = "n/d"; $Nom_Activitat = "n/d"; $Nom_Cicle = "n/d"; $Espai = array();
                                
                                //Carreguem l'activitat associada a l'horari
                                $OA = $OH->getActivitats();
                                
                                //Mirem el primer i últim horari de l'activitat per saber si és un cicle
                                $OH1 = $OA->getPrimerHorari(); $OH2 = $OA->getUltimHorari();                                
                                 
                                //Si tots dos són horaris correctes
                                if( $OH1 instanceof Horaris && $OH2 instanceof Horaris && !key_exists( $OA->getActivitatid() , $activitats_ja_aparegudes ) ){
                                    
                                    //Guardem aquesta activitat com a apareguda perquè no torni a sortir
                                    $activitats_ja_aparegudes[$OA->getActivitatid()] = $OA->getActivitatid();
                                    
                                    //Si el primer i últim dia és el mateix, llavors tenim una activitat amb només un horari
                                    if( $OH1->getDia() == $OH2->getDia() ){
                                        
                                        $Data_Activitat =   myUser::getDiaText( $OH1->getDia('Y-m-d') )
                                                            ."<br />"
                                                            .$OH1->getDia('d').'/'.$OH1->getDia('m');
                                    
                                    // Si el primer i últim dia són diferents, tenim una activitat amb diversos horaris
                                    } else {
                                        
                                        $Data_Activitat =   myUser::getDiaText( $OH->getDia('Y-m-d') )
                                                            ."<br />"
                                                            .$OH->getDia('d').'/'.$OH->getDia('m')
                                                            .'<br />'
                                                            .'<span style="font-size:8px;"> + dies </span>';
                                    }
                                    
                                    $OC = $OA->getCicles();
                                    if($OH instanceof Horaris)      { $Espai = $OH->getArrayEspais(); }     else { $Espai = array(); }                                                
                                    if($OC instanceof Cicles)       { $Nom_Cicle = $OC->getTMig(); }        else { $OC = ""; }
                                    if($OA instanceof Activitats)   { $Nom_Activitat = $OA->getTMig(); }    else { $OA = "n/d"; }
                                                                                                                                                    
                                    $requadre = '
                                    <div class="menu_activitat_prop" onclick="segueix_url(\''.url_for('@web_menu_click_activitat?idCicle='.$OC->getCicleid().'&idActivitat='.$OA->getActivitatid().'&titol='.$OA->getNomForUrl()).'\')">
                                        <div class="menu_activitat_prop_dia">'.$Data_Activitat.'</div>
                                        <div class="menu_activitat_prop_text">
                                            <div>'.$Nom_Activitat.' | '.$OH->getHorainici('H.i').'h</div>
                                        </div>
                                    </div>';
                                     
                                    if($i % $quants == 0) { echo '<div class="menu_hidden" id="properament_'.$j++.'">'; }
                                    
                                    echo $requadre;
                                                                                                                                                                                                                                                                                
                                    if( $i++ % $quants == ( $quants - 1 ) ){
                                        echo BotoMes( 'properament_' , $j );
                                        echo '</div>';
                                    }
                                }                                                                                                                                                    
                            }   
                            if( ( ( $i - 1 ) % $quants ) < ( $quants - 1) ){
                                echo BotoMes( 'properament_' , 0 );
                                echo '</div>';
                            }
                            
                        ?>                                                                                                                                                
                    </div>
                    <!-- FI PROPERAMENT -->                                                              
                    
                </div>                


<?php 

    function BotoMes($qui , $i)
    {
        $RET = '
                <div style="background-color: #817D74;" class="menu_activitat_prop" onclick="visible(\''.$qui.'\',\''.$i.'\')">                                                    
                    <div class="menu_activitat_prop_text">
                        <div style="font-weight:bold; color:white; margin-left:80px; margin-top:8px;">Veure més activitats</div>
                    </div>
                </div>';                 
        return $RET;
    }

?>