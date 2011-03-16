<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <?php $metas = $sf_response->getMetas();        
        if(!empty($metas)):
            echo html_entity_decode(implode(' ',$metas));                    
        endif;        
   ?>  
  
  <?php $BASE = OptionsPeer::getString('SF_WEBROOT',1); ?>
  <?php $BASE_I = sfConfig::get('sf_webrooturl').'images/hospici'; ?>
  
  <!-- Facebook & Twitter -->
    <script src="http://connect.facebook.net/ca_ES/all.js#xfbml=1"></script>
    <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
  <!-- Facebook & Twitter -->
  <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $BASE.'css/smoothness/jquery-ui-1.7.2.custom.css'; ?>" />   
  <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $BASE.'css/jquery-datepick/jquery.datepick.css'; ?>" />  
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>     
  <script type="text/javascript" src="<?php echo $BASE.'js/thickbox-compressed.js'; ?>"></script>
  <script type="text/javascript" src="<?php echo $BASE.'js/jquery-ui/js/jquery-ui-1.7.2.custom.min.js'; ?>"></script>
  <script type="text/javascript" src="<?php echo $BASE.'js/jquery.cookie.js'; ?>"></script>      
  
     
<!--[if lt IE 7]>
    <script type="text/javascript" src="/intranet/js/buttonfix.js"></script>
<![endif]-->

  <title>L'Hospici. La Cultura al teu abast!</title>

<style type="text/css">

* { font-family: Myriad Pro, Trebuchet MS, Arial, Sans-Serif; margin:0px; padding:0px; font-size:12px; }

#taula { width:1024px; margin:0 auto; text-align:left; border:1px solid black;  }
        
.h_left_col { width:200px;float:left; vertical-align: top;  }
.h_middle_col { width:624px; float:left; vertical-align: top; min-height:450px; }
.h_right_col { width:200px; float:left; vertical-align: top;  }
    
.h_col_head , .h_head , .h_head_down { background-color:#3F3F3F; }
.h_head { width:1024px; height:100px }
.h_head_down { width:1024px; height:11px; }    
                        
.h_menu { height:30px; background-image: url('<?php echo $BASE_I.'/menu_gradient.jpg'; ?>'); background-repeat: repeat-x; }
.h_menu_sup_item { font-size:16px; float:left; color:orange; padding:4px 10px; border-right:3px solid orange; list-style-type: none; }
.h_menu_sup_link { color:orange; text-decoration:none; }    
.h_menu_sup_item:hover { background-color:#96BD0D; color: #96BD0D; }
.h_menu_sup_link:hover { color:black; text-decoration:none; }    
            
.h_menu_left { list-style-image: url('<?php echo $BASE_I.'/menu_right_arrow.jpg'; ?>'); list-style-position: inside; }
.h_menu_left a { text-decoration:none; font-weight:bold; color:black;  }
.h_menu_left a:hover { color:#96BD0D; text-decoration:underline;  }
.h_menu_left li { font-size:12px; }

.h_requadre_menu_left { background-color:white; border-radius:10px; text-align:left; }

.h_content { margin-top:20px;  }        

.h_subtitle_gray { font-size:15px; color:#B2B2B2; margin-bottom:10px; border-bottom:1px solid #CCCCCC;   }

.h_requadre_cercador { /* background-color:#96BD0D; */ height:180px; width:600px; }         
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
      
  </head>
  
  <body>
  
    <div style="text-align:center;">  
    <div id="taula">
        <!-- HEADER -->

        <div class="h_head"></div>

        <div class="h_menu">
            <ul>
                <li class="h_menu_sup_item"><a href="<?php echo url_for('@hospici_cercador_activitats') ?>" class="h_menu_sup_link">ACTIVITATS</a></li>

                <li class="h_menu_sup_item"><a href="<?php echo url_for('@hospici_cercador_cursos_inici') ?>" class="h_menu_sup_link">CURSOS</a></li>

                <li class="h_menu_sup_item"><a href="#" class="h_menu_sup_link">CALENDARI</a></li>

                <li class="h_menu_sup_item"><a href="#" class="h_menu_sup_link">EL MEU HOSPICI</a></li>
            </ul>
        </div>

        <div class="h_head_down"></div>                

        <div class="h_content">
            <div class="h_left_col">
                <div class="h_requadre_menu_left">             
                    <ul class="h_menu_left">
                        <li><a href="<?php echo url_for('@hospici_cercador_activitats') ?>">Cercador d'activitats</a></li>

                        <li><a href="<?php echo url_for('@hospici_cercador_cursos_inici') ?>">Cercador de cursos</a></li>    
    
                        <li><a href="">Llistat d'entitats</a></li>
    
                        <li><a href="">Reserva d'espais per activitats culturals</a></li>    
    
                        <li><a href="">Calendari</a></li>
    
                        <li><a href="">Acc&eacute;s al teu espai de l&rsquo;Hospici</a> (modificar les teves dades, consultar on t&rsquo;has matriculat...)</li>
                    </ul>
                </div>
            </div>

            <div class="h_middle_col">

                <?php echo $sf_content ?>                            

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
                        <img src="<?php echo $BASE_I.'/logo_hospici.png'; ?>">
                    </div>
                </div>                
            </div>                        
        </div>
        <div style="clear: both;"></div>        
    </div>    
    
</div>
    

    
            
  </body>
</html>
