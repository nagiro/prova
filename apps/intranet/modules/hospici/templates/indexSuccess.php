<?php use_helper('Form') ?>
<?php use_helper('Presentation') ?>
<?php $BASE = sfConfig::get('sf_webrooturl').'images/hospici'; ?>
 
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">

<html>
<head>

    <script type="text/javascript">
        $(document).ready(function() {                
                $( "#accordion" ).tabs();                
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
    <style type="text/css">
    
    * { font-family: Myriad Pro, Trebuchet MS, Arial, Sans-Serif; margin:0px; padding:0px; font-size:12px; }

    #taula { width:1024px; margin:0 auto; text-align:left; border:1px solid black;  }
            
    .h_left_col { width:200px;float:left; vertical-align: top;  }
    .h_middle_col { width:624px; float:left; vertical-align: top; min-height:450px; }
    .h_right_col { width:200px; float:left; vertical-align: top;  }
        
    .h_col_head , .h_head , .h_head_down { background-color:#3F3F3F; }
    .h_head { width:1024px; height:100px }
    .h_head_down { width:1024px; height:11px; }    
                            
    .h_menu { height:30px; background-image: url('<?php echo $BASE.'/menu_gradient.jpg'; ?>'); background-repeat: repeat-x; }
    .h_menu_sup_item { font-size:16px; float:left; color:orange; padding:4px 10px; border-right:3px solid orange; list-style-type: none; }
    .h_menu_sup_link { color:orange; text-decoration:none; }    
    .h_menu_sup_item:hover { background-color:#96BD0D; color: #96BD0D; }
    .h_menu_sup_link:hover { color:black; text-decoration:none; }    
                
    .h_menu_left { list-style-image: url('<?php echo $BASE.'/menu_right_arrow.jpg'; ?>'); list-style-position: inside; }
    .h_menu_left a { text-decoration:none; font-weight:bold; color:black;  }
    .h_menu_left a:hover { color:#96BD0D; text-decoration:underline;  }
    .h_menu_left li { font-size:12px; }

    .h_requadre_menu_left { background-color:white; border-radius:10px; text-align:left; }
    
    .h_content { margin-top:20px;  }        

    .h_subtitle_gray { font-size:15px; color:#B2B2B2;  }

    .h_requadre_cercador { background-color:#96BD0D; height:180px; margin-bottom:10px; border-radius:10px; width:600px; }         
    .h_input_requadre_cercador input { margin-top:5px; width:300px;  }
    .h_input_requadre_cercador_data input { margin-top:5px; width:143px;  }
    .h_input_requadre_cercador select { margin-top:5px; width:300px;  }

    .h_requadre_cercador_plegat_titol { float:left; width:70px; font-size:30px; float:left; color:white;  }
    .h_requadre_cercador_plegat_text { margin-top:10px; font-size:14px; color:#CCCCCC; float:right;  }

    .h_requadre_banners { background-color:white; border:3px solid #96BD0D; height:113px; width:600px; }
    .h_requadre_banners_banner { color:#666666; padding:5px; border-right:1px solid #96BD0D; float:left; height:105px; width:117px; }
    .h_requadre_banners_banner_text { height:90px;  }
    .h_requadre_banners_banner_amplia { height:10px; text-align: right; }
    .h_requadre_banners_banner_amplia a { text-decoration:none; color:#AD1C1C; }

    .h_requadre_resultats { margin-top:20px; }
    .h_requadre_resultats #tabs { height:480px; }

    .h_calendari { width:175px; margin:0 auto; }
    .h_calendari_menu {  text-align:center; background-color:orange;  }
    .h_calendari_dia { color:#FF7F00; float:left; background-color: white; width:25px; text-align:center;  }
    .h_calendari_data { color:#888888; float:left; background-color: white; width:25px; text-align:center;  } 
    .h_calendari_break { clear:both;  } 


    .h_requadre_login { text-align:center; background-color:#3F3F3F; width:175px; margin:0 auto; margin-top:20px; border-radius: 10px; }
    .h_requadre_login_inputs { width:150px; margin-left:auto; margin-right:auto; }
    .h_requadre_login_inputs input { width:150px; background-color:#8C8C8C; border:0px; margin-bottom:5px; border-radius: 5px; color:white; }
    .h_requadre_login_button { width:150px; text-align:right; margin:0 auto; }
    .h_requadre_login_button a { color:#FF7F00; text-decoration:none; font-size:14px;  }
    .h_requadre_login_button a:hover { color:#96BD0D; text-decoration:none; font-size:14px;  }
    .h_requadre_login_text { margin: 0 auto; color:white; width:150px; text-align:left;}
    .h_requadre_login_imatge {  }

    .h_llistat_activitat_tipus_titol { background-color:#CCCCCC; padding:5px; font-weight:bold; margin-bottom:10px;  }    
    .h_llistat_activitat_titol a { text-decoration:none; font-weight:bold; font-size:14px; color:black; }
    .h_llistat_activitat_titol a:hover { text-decoration:underline; }
    
    .h_llistat_activitat_horari { margin-left:20px; color:green; font-weight:bold; float:left;  }
    .h_llistat_activitat_organitzador { margin-left:10px; font-weight:bold; float:left;  }

         
    </style>

    <title></title>
    <style type="text/css">
    div.c3 {}
    div.c2 { margin-bottom:10px;}
    div.c1 {border-bottom:3px solid #B2B2B2; margin-bottom:10px;}
    </style>
</head>

<body>
<div style="text-align:center;">

    <div id="taula">
        <!-- HEADER -->

        <div class="h_head"></div>

        <div class="h_menu">
            <ul>
                <li class="h_menu_sup_item"><a href="#" class="h_menu_sup_link">ACTIVITATS</a></li>

                <li class="h_menu_sup_item"><a href="#" class="h_menu_sup_link">CURSOS</a></li>

                <li class="h_menu_sup_item"><a href="#" class="h_menu_sup_link">CALENDARI</a></li>

                <li class="h_menu_sup_item"><a href="#" class="h_menu_sup_link">EL MEU HOSPICI</a></li>
            </ul>
        </div>

        <div class="h_head_down"></div>                

        <div class="h_content">
            <div class="h_left_col">
                <div class="h_requadre_menu_left">             
                    <ul class="h_menu_left">
                        <li><a href="">Cercador d'activitats</a></li>
    
                        <li><a href="">Llistat d'entitats</a></li>
    
                        <li><a href="">Reserva d'espais per activitats culturals</a></li>
    
                        <li><a href="">Directori de cursos</a></li>
    
                        <li><a href="">Calendari</a></li>
    
                        <li><a href="">Acc&eacute;s al teu espai de l&rsquo;Hospici</a> (modificar les teves dades, consultar on t&rsquo;has matriculat...)</li>
                    </ul>
                </div>
            </div>

            <div class="h_middle_col">
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
                
            <?php if(!$MODE == 'INICIAL'): ?>

                <div class="h_subtitle_gray c2">
                    DESTACATS
                </div>

                <div class="h_requadre_banners">
                    <div class="h_requadre_banners_banner">
                        <div class="h_requadre_banners_banner_text">
                            Nous cursos d'inform&agrave;tica, patchwork i artesania i arts aplicades: matr&iacute;cula oberta...
                        </div>

                        <div class="h_requadre_banners_banner_amplia">
                            <a href="">amplia not&iacute;cia</a>
                        </div>
                    </div>

                    <div class="h_requadre_banners_banner">
                        <div class="h_requadre_banners_banner_text">
                            Nous cursos d'inform&agrave;tica, patchwork i artesania i arts aplicades: matr&iacute;cula oberta...
                        </div>

                        <div class="h_requadre_banners_banner_amplia">
                            <a href="">amplia not&iacute;cia</a>
                        </div>
                    </div>

                    <div class="h_requadre_banners_banner">
                        <div class="h_requadre_banners_banner_text">
                            Nous cursos d'inform&agrave;tica, patchwork i artesania i arts aplicades: matr&iacute;cula oberta...
                        </div>

                        <div class="h_requadre_banners_banner_amplia">
                            <a href="">amplia not&iacute;cia</a>
                        </div>
                    </div>

                    <div class="h_requadre_banners_banner">
                        <div class="h_requadre_banners_banner_text">
                            Nous cursos d'inform&agrave;tica, patchwork i artesania i arts aplicades: matr&iacute;cula oberta...
                        </div>

                        <div class="h_requadre_banners_banner_amplia">
                            <a href="">amplia not&iacute;cia</a>
                        </div>
                    </div>
                </div>

            <?php endif; ?>
            <?php if($MODE == 'CERCA'): ?>

                <div class="h_requadre_resultats">
                    <div class="h_subtitle_gray c1">
                        L'HOSPICI...
                    </div>

                    <div>
                        
                    <?php 
                        $C = new Criteria();
                        $C->addAscendingOrderByColumn(HorarisPeer::DIA);
                        $cat_ant = "";
                        if(empty($LLISTAT_ACTIVITATS)):
                            echo '<div>';                                
                            echo '<div class="h_llistat_activitat_titol">No hem trobat cap resultat amb aquests paràmetres.</div>';                                
                            echo '</div>';
                            echo '<div style="margin-top:10px; clear:both;"></div>';                                                                                                                                                                    
                        else:
                            foreach($LLISTAT_ACTIVITATS as $OA):
                                echo '<div style="margin-top:10px;">';                                                
                                    if($cat_ant <> $OA->getTipusactivitatIdtipusactivitat()):
                                        echo '<div class="h_llistat_activitat_tipus_titol">'.$OA->getNomTipusActivitat().'</div>';                                                                        
                                    endif;
                                    echo '<div class="h_llistat_activitat_titol"><a href="'.url_for('hospici/index?idA='.$OA->getActivitatid().'&titol='.$OA->getTmig()).'">'.$OA->getTMig().'</a></div>';
                                    echo '<div class="h_llistat_activitat_horari">'.generaHorarisCompactat($OA->getHorariss($C)).'</div>';
                                    echo '<div class="h_llistat_activitat_organitzador">|&nbsp;&nbsp; '.$OA->getNomSite().'</div>';
                                echo '</div>';
                                echo '<div style="height:1px; background-color:#CCCCCC; clear:both;"></div>';
                                $cat_ant = $OA->getTipusactivitatIdtipusactivitat();                                                                                               
                            endforeach; 
                        endif;
                    ?>
                                        
                    </div>
                </div>

            <?php endif; ?>
            <?php if($MODE == 'DETALL'): ?>

                <div class="h_requadre_resultats">
                    <div class="h_subtitle_gray c1">
                        L'HOSPICI...
                    </div>

                    <div>
                        
                    <?php if($ACTIVITAT instanceof Activitats):
                            $imatge = $ACTIVITAT->getImatge();
		                    $pdf = $ACTIVITAT->getPdf();                          
                     ?>
                			<div style="border:2px solid #96BF0D; clear:both; padding:10px;">
                				<div style="font-size:11px"><b><?php echo $ACTIVITAT->getTMig() ?></b></div>
                				<div style="font-size:10px"><?php echo generaHoraris($ACTIVITAT->getHorarisOrdenats(HorarisPeer::DIA)); ?></div>
                				<div style="height:30px;">&nbsp;</div>				
                										
                				<div class="df" style="width:150px;">
                					<div><?php if($imatge > 0): ?> <img src="<?php echo sfConfig::get('sf_webrooturl').'images/activitats/'.$imatge ?>" style="vertical-align:middle"><?php endif; ?></div>
                						<div style="margin-top:20px; font-size:10px"><?php echo getRetorn(); ?></div>
                						<div class="pdf_cicle"><?php if($pdf > 0): ?> <br /><a href="<?php echo sfConfig::get('sf_webrooturl').'images/activitats/'.$pdf ?>">Baixa't el pdf</a><?php endif; ?></div>						
                				</div>
                				<div class="df" style="width:330px;">
                					<div style="padding-left:10px; font-size:10px;">
                						<?php echo $ACTIVITAT->getDmig() ?>
                					</div>					
                				</div>
                				
                				<div style="margin-left:150px; padding-top:20px; width:330px; clear:both; color:#96BF0D; font-size:12px; padding-left:10px;">INFORMACIÓ PRÀCTICA</div> 
                				<div style=" margin-left:150px; width:330px; clear:both; background-color:#DFECB6">					
                					<div style="padding:10px; font-size:10px;">
                						<?php echo $ACTIVITAT->getInfoPractica(); ?>
                					</div>
                				</div>
                				<div style="clear:both">&nbsp;</div>													
                			</div>
                    <?php endif; ?>					                                                                    
                    </div>
                </div>

            <?php endif; ?>                        
            </div>
           
            

            <div class="h_right_col">                

                <div class="h_requadre_login">
                    <br />

                    <div class="h_requadre_login_inputs">
                        <input type="text" name="login" /> <input type="password" name="pass" />
                    </div>

                    <div class="h_requadre_login_button">
                        <a href="">Entra &gt;&gt;&gt;</a>
                    </div>
                    <br />

                    <div class="h_requadre_login_text">
                        Ser soci de l&rsquo;hospici et d&oacute;na dret a veure totes les activitats de les entitats s&ograve;cies de la xarxa.
                        <br />
                        &Eacute;s totalment gratu&iuml;t.
                        <br />
                        Consulta aqu&iacute; les condicions de registre de les teves dades.
                    </div>
                    <br />

                    <div class="h_requadre_login_imatge">
                        <img src="<?php echo $BASE.'/logo_hospici.png'; ?>">
                    </div>
                </div>                
            </div>                        
        </div>
        <div style="clear: both;"></div>        
    </div>    
    
</div>

</body>
</html>

<?php 

    function getCalendari()
    {
        echo '
        <div class="h_calendari">
                    <div class="h_calendari_menu">
                        &lt;&lt;&lt; T&iacute;tol calendari &gt;&gt;&gt;
                    </div>

                    <div class="h_calendari_dia">
                        Dl
                    </div>

                    <div class="h_calendari_dia">
                        Dm
                    </div>

                    <div class="h_calendari_dia">
                        Dc
                    </div>

                    <div class="h_calendari_dia">
                        Dj
                    </div>

                    <div class="h_calendari_dia">
                        Dv
                    </div>

                    <div class="h_calendari_dia">
                        Ds
                    </div>

                    <div class="h_calendari_dia">
                        Dg
                    </div>

                    <div class="h_calendari_break"></div>

                    <div class="h_calendari_data">
                        01
                    </div>

                    <div class="h_calendari_data">
                        02
                    </div>

                    <div class="h_calendari_data">
                        03
                    </div>

                    <div class="h_calendari_data">
                        04
                    </div>

                    <div class="h_calendari_data">
                        05
                    </div>

                    <div class="h_calendari_data">
                        06
                    </div>

                    <div class="h_calendari_data">
                        07
                    </div>

                    <div class="h_calendari_break"></div>

                    <div class="h_calendari_data">
                        08
                    </div>

                    <div class="h_calendari_data">
                        09
                    </div>

                    <div class="h_calendari_data">
                        10
                    </div>

                    <div class="h_calendari_data">
                        11
                    </div>

                    <div class="h_calendari_data">
                        12
                    </div>

                    <div class="h_calendari_data">
                        13
                    </div>

                    <div class="h_calendari_data">
                        14
                    </div>

                    <div class="h_calendari_break"></div>

                    <div class="h_calendari_data">
                        15
                    </div>

                    <div class="h_calendari_data">
                        16
                    </div>

                    <div class="h_calendari_data">
                        17
                    </div>

                    <div class="h_calendari_data">
                        18
                    </div>

                    <div class="h_calendari_data">
                        19
                    </div>

                    <div class="h_calendari_data">
                        20
                    </div>

                    <div class="h_calendari_data">
                        21
                    </div>

                    <div class="h_calendari_break"></div>

                    <div class="h_calendari_data">
                        22
                    </div>

                    <div class="h_calendari_data">
                        23
                    </div>

                    <div class="h_calendari_data">
                        24
                    </div>

                    <div class="h_calendari_data">
                        25
                    </div>

                    <div class="h_calendari_data">
                        26
                    </div>

                    <div class="h_calendari_data">
                        27
                    </div>

                    <div class="h_calendari_data">
                        28
                    </div>

                    <div class="h_calendari_break"></div>

                    <div class="h_calendari_data">
                        29
                    </div>

                    <div class="h_calendari_data">
                        30
                    </div>

                    <div class="h_calendari_data">
                        31
                    </div>

                    <div class="h_calendari_data">
                        .
                    </div>

                    <div class="h_calendari_data">
                        .
                    </div>

                    <div class="h_calendari_data">
                        .
                    </div>

                    <div class="h_calendari_data">
                        .
                    </div>
                </div>';
    }


?>