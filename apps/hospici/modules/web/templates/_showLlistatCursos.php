<style>    
    .pager { font-size:16px;  }
    .pager a { font-size:16px; color:inherit; text-decoration:inherit;  }
    .pagerE { margin-top:10px; margin-bottom:30px; text-align:center;  }
</style>
<script>


    $(document).ready(function(){
        	$( ".matricula_presencial" ).dialog({
			autoOpen: false,
			height: 310,
			width: 350,
			modal: true,
            buttons: {},
			close: function() {}
		});
    });

    function MostraDialegMatriculaPresencial(id){
        $( " [idD=" + id + "]" ).dialog( "open" );
        return false;    
    }
    

</script>
<div class="h_requadre_resultats">
    <div class="h_subtitle_gray c1">
        L'HOSPICI...
    </div>

    <div>
        
    <?php 
        $C = new Criteria();
        $C->addAscendingOrderByColumn(HorarisPeer::DIA);
        $cat_ant = "";
        if(!$LLISTAT_CURSOS->getNbResults()):
            echo '<div>';                                
            echo '<div class="h_llistat_activitat_titol">No hem trobat cap resultat amb aquests paràmetres.</div>';                                
            echo '</div>';
            echo '<div style="margin-top:10px; clear:both;"></div>';                                                                                                                                                                    
        else:                        
            foreach($LLISTAT_CURSOS->getResults() as $OC):
                $DATA_INICI =  $OC->getDatainici('d').' '.generaMes($OC->getDatainici('m')).' de '.$OC->getDatainici('Y');                
                echo '<div style="margin-top:10px; margin-bottom:10px;">';
                    
                    //Si la categoria és diferent a l'anterior la mostrem
                    if($cat_ant <> $OC->getCategoria()):
                        echo '<div class="h_llistat_activitat_tipus_titol">'.$OC->getCategoriaText().'</div>';
                    endif;
                    
                    echo '<div class="h_llistat_acivitat_titol">
                            <div style="float:left;">
                                <a style="font-size:14px;" href="'.url_for('@hospici_detall_curs?idC='.$OC->getIdcursos().'&titol='.$OC->getNomForUrl()).'">'.$OC->getTitolcurs().'</a>
                            </div>';
                            
                    //Si es pot reservar entrada per internet, es mostra. 
                    if($OC->getIsEntrada())
                    {
                        $url = url_for('@hospici_detall_curs?idC='.$OC->getIdCursos().'&titol='.$OC->getNomForUrl());
                        //Es pot reservar i estic autentificat 
                        if(isset($AUTH) && $AUTH > 0) {

                            //Es pot reservar, estic autentificat i no m'hi he matriculat prèviament.
                            if(!isset($CURSOS_MATRICULATS[$OC->getIdcursos()])) {
                                echo '  <div style="float:right">'.ph_getRoundCorner('<a name="link_compra" style="text-decoration:none;" href="'.$url.'">Matricula\'m-hi</a>','#FFCC00').'</div>';                                                                                                     
                            }
                            
                            //Es pot reservar, estic autentificat i ja m'hi he matriculat.  
                            else { 
                                echo '  <div class="tip" title="Vostè ja ha realitzat una reserva o matrícula a aquest curs." style="float:right">'.ph_getRoundCorner('Ja hi esteu matriculat','#29A729').'</div>';
                                //echo '  <div style="float:right">'.ph_getRoundCorner('Ja hi esteu matriculat','#29A729').'</div>';                                        
                            }
    
                        }
                        
                        //Es pot reservar i no estic autentificat 
                        else {                            
                            echo '  <div style="float:right">'.ph_getRoundCorner('<a class="auth" url="" name="link_compra" style="text-decoration:none;" url="'.$url.'" href="#">Matricula\'m-hi</a>','#FFCC00').'</div>';                                                                                         
                        }
                                                                                                     
                    }
                    //No es pot matriculat per internet.
                    else {
                        $OS = SitesPeer::retrieveByPK($OC->getSiteId());
                        $tel = $OS->getTelefonString();
                        $email = $OS->getEmailString();
                        $nom = $OS->getNom();                        
                        echo "  <div class=\"tip\" title=\"Aquest curs no disposa de matrícula en línia. Per poder-s'hi matricular, ha de posar-se en contacte amb <b>{$nom}</b> enviant un correu electrònic a <b>{$email}</b> o bé trucant al telèfon <b>{$tel}</b>.<br /><br />Disculpi les molèsties.\" style=\"float:right\">".ph_getRoundCorner('<a class="requadre_mini" style="text-decoration:none;" href="#">Matrícula presencial</a>','#FF4B4B').'</div>';                        
                                                                                                             
                    }
                    echo '</div>';
                    echo '<div style="clear:both" class="h_llistat_activitat_horari">Inici: '.$DATA_INICI.'</div>';
                    echo '<div class="h_llistat_activitat_organitzador">|&nbsp;&nbsp;Organitza: '.$OC->getNomSite().'</div>';
                    echo '<div style="clear:both"></div>';
                echo '</div>';
                echo '<div style="height:1px; background-color:#CCCCCC; clear:both;"></div>';
                $cat_ant = $OC->getCategoria();                                                                                               
            endforeach; 
        endif;
		
        echo '<div class="pagerE">'.setPager($LLISTAT_CURSOS,'@hospici_cercador_cursos').'</div>';        
        
    ?>
                        
    </div>
</div>
