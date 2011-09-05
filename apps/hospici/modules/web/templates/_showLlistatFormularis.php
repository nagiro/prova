<div class="h_requadre_resultats">
    <div class="h_subtitle_gray c1">
        L'HOSPICI...
    </div>

    <div>
        
    <?php     
     
        $cat_ant = "";
        if(!$LLISTAT_FORMS->getNbResults()):
            echo '<div>';                                
            echo '<div class="h_llistat_activitat_titol">No hem trobat cap resultat amb aquests paràmetres.</div>';
            echo '</div>';
            echo '<div style="margin-top:10px; clear:both;"></div>';                                                                                                                                                                    
        else:                        
            foreach($LLISTAT_FORMS->getResults() as $OF):                                
                echo '<div style="margin-top:10px; margin-bottom:10px;">';                                        
                    
                    echo '<div class="h_llistat_acivitat_titol">
                            <div style="float:left">
                                <a style="font-size:14px;" href="'.url_for('@hospici_formularis_detall?idF='.$OF->getIdformularis().'&titol='.$OF->getNomForUrl()).'">'.$OF->getNom().'</a>
                            </div>';
                            
                    //Si apareix aquí és perquè es pot demanar per internet.
                    $url = url_for('@hospici_formularis_detall?idF='.$OF->getIdformularis().'&titol='.$OF->getNomForUrl()); 
                    if(isset($AUTH) && $AUTH > 0){
                        echo '  <div style="float:right">
                                    <div class="requadre_mini" style="color:white; background-color:#FFCC00;">
                                        <a name="link_compra" style="text-decoration:none;" href="'.$url.'">Omple formulari</a>
                                    </div>
                                </div>';                    
                    } 
                    else
                    {
                        echo '  <div style="float:right">
                                    <div class="requadre_mini" style="color:white; background-color:#FFCC00;">
                                        <a class="auth" href="'.$url.'" name="link_compra" style="text-decoration:none;">Autentifica\'t i omple</a>
                                    </div>
                                </div>';                                            
                    }                  
                    
                    echo '</div>';
                                         
                    echo '<div style="clear:both" class="h_llistat_activitat_organitzador">'.$OF->getDescripcio().'</div>';                    
                    
                    echo '<div style="clear:both"></div>';
                echo '</div>';
                echo '<div style="height:1px; background-color:#CCCCCC; clear:both;"></div>';                
            endforeach; 
        endif;
		
        if($LLISTAT_FORMS->getLastPage() > $LLISTAT_FORMS->getPage()):
            echo '<div class="pagerE">'.setPagerN($LLISTAT_FORMS,'@hospici_cercador_formularis',false).'</div>';
        else:      
            echo '<div class="pagerE">'.setPagerN($LLISTAT_FORMS,'@hospici_cercador_formularis',true).'</div>';
        endif;                
    ?>
                        
    </div>
</div>
