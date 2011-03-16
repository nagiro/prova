<style>    
    .pager { font-size:16px;  }
    .pager a { font-size:16px; color:inherit; text-decoration:inherit;  }
    .pagerE { margin-top:10px; margin-bottom:30px; text-align:center;  }
</style>
<div class="h_requadre_resultats">
    <div class="h_subtitle_gray c1">
        L'HOSPICI...
    </div>

    <div>
        
    <?php 
        $C = new Criteria();
        $C->addAscendingOrderByColumn(HorarisPeer::DIA);
        $cat_ant = "";
        if(!$LLISTAT_ACTIVITATS->getNbResults()):
            echo '<div>';                                
            echo '<div class="h_llistat_activitat_titol">No hem trobat cap resultat amb aquests paràmetres.</div>';                                
            echo '</div>';
            echo '<div style="margin-top:10px; clear:both;"></div>';                                                                                                                                                                    
        else:                        
            foreach($LLISTAT_ACTIVITATS->getResults() as $OA):
                echo '<div style="margin-top:10px; margin-bottom:10px;">';                                                
                    if($cat_ant <> $OA->getTipusactivitatIdtipusactivitat()):
                        echo '<div class="h_llistat_activitat_tipus_titol">'.$OA->getNomTipusActivitat().'</div>';                                                                        
                    endif;
                    echo '<div class="h_llistat_activitat_titol"><a href="'.url_for('@hospici_detall_activitat?idA='.$OA->getActivitatid().'&titol='.$OA->getNomForUrl()).'">'.$OA->getTMig().'</a></div>';
                    echo '<div class="h_llistat_activitat_horari">'.generaHorarisCompactat($OA->getHorariss($C)).'</div>';
                    echo '<div class="h_llistat_activitat_organitzador">|&nbsp;&nbsp;Organitza: '.$OA->getNomSite().'</div>';
                    echo '<div style="clear:both"></div>';
                echo '</div>';
                echo '<div style="height:1px; background-color:#CCCCCC; clear:both;"></div>';
                $cat_ant = $OA->getTipusactivitatIdtipusactivitat();                                                                                               
            endforeach; 
        endif;
		
        echo '<div class="pagerE">'.setPager($LLISTAT_ACTIVITATS,'@hospici_cercador_activitats').'</div>';        
        
    ?>
                        
    </div>
</div>
