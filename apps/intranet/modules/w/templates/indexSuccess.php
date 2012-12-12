<?php $base = 'http://www.casadecultura.tmp/'; ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Casa de Cultura de Girona</title>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800,300' rel='stylesheet' type='text/css'>
<script src="http://cdn.jquerytools.org/1.2.6/full/jquery.tools.min.js"></script>

<style>

@charset "UTF-8";
/* CSS Document */

* {
	margin: 0;
	border: 0;
	font-family: Open Sans;
	}

body {
	background-image: url(<?php echo $base ?>images/front/indianaccg.jpg);    
	}

#marc { margin:60px auto; width:1024px; background-color:white; overflow:hidden; }
#contingut { margin: 32px; background-color:red; background-color: #E1D9CB; }
#logo { width:310px; height:90px; float:left; background-image: url('<?php echo $base ?>images/front/logo_ccg.jpg'); cursor:pointer; }
#franja_superior { width:650px; height:90px; background-color:#E1D9CB; float:left; }
#menu_esquerra { width: 310px; float:left; }
#contingut_text { margin-left:20px; width:620px; min-height:300px; float:left; }

.requadre_individual { width: 135px; height:140px; float:left; }
.requadre_individual_titol { background-color: transparent; width: 110px; color:black; font-weight:bold; font-size:13px; margin:10px; }
.requadre_doble { width: 295px; height:140px; float:left; background-color:white; }
.requadre_doble_titol { width: 270px; color:black; font-weight:bold; font-size:13px; margin:10px; }
.requadre_doble:hover { opacity:0.7; cursor:pointer; filter: alpha(opacity = 70); }
.requadre_individual:hover { opacity:0.7; cursor:pointer; filter: alpha(opacity = 70); }
.requadre_no_imatge { border-top:1px solid gray; font-size:12px; padding:10px; }
.requadre_no_imatge:hover { opacity:0.7; cursor:pointer; filter: alpha(opacity = 70); }
.requadre_no_imatge a { text-decoration:none; color:inherit; }

.menu_titol_llarg { width:610px; height:24px; color:white; background-color: #817D74; margin-bottom:10px; }
.menu_titol_llarg > div { padding-top:3px; margin-left:5px; font-size:15px; font-weight: bolder;  }
.fila { margin-bottom:20px; overflow: hidden; }
.fila_imatge { width:295px; height:295px; background-color:white; float:left; position:relative;  }
.fila_imatge_text { position: absolute; bottom:0px; opacity: 0.5; filter: alpha(opacity = 50); background-color: black; color:white; font-size:12px; padding:10px; min-width: 275px; }
.fila_imatge_mig { width:295px; height:124px; background-color:white; float:left; position: relative; }

.fila_imatge:hover { opacity:0.7; cursor:pointer; filter: alpha(opacity = 70); }
.fila_imatge_mig:hover { opacity:0.7; cursor:pointer; filter: alpha(opacity = 70); }

.menu_titol { width:300px; height:24px; color:white; background-color: #817D74; margin-top:10px; margin-left:10px;  }
.menu_titol > div { padding-top:3px; margin-left:5px; font-size:15px; font-weight: bolder;  }
.menu_esquerra { cursor:pointer; }
.menu_esquerra:hover { background-color: #706C63; }
.menu_activitat { width:300px; min-height: 60px; color:white; background-color: #F0ECE6; margin-bottom:10px; margin-left:10px; overflow: hidden; }
.menu_activitat_text { font-size:11px; margin: 5px; color:black; }
.menu_activitat_prop { width:300px; min-height: 43px; background-color: #F0ECE6; margin-bottom:10px; margin-left:10px; overflow: hidden; }
.menu_activitat_prop_dia { background-color:white; width: 60px; height:55px; color: black; font-size:12px; text-align:center; padding-top:3px; float:left; }	
.menu_activitat_prop_text { font-size:12px; color:black; float:left; width: 240px; }
.menu_activitat_prop_text > div { padding:3px; margin-left:7px; }
.menu_activitat:hover { opacity:0.7; cursor:pointer; filter: alpha(opacity = 70); }
.menu_activitat_prop:hover { opacity:0.7; cursor:pointer; filter: alpha(opacity = 70); }

</style>

<script>

    function segueix_url(url){
        window.location.href = url;
    }

    $(document).ready(function(){
        $('#logo').click(function(){ segueix_url('<?php echo url_for('@web_home') ?>') })        
    });


</script>

</head>

<body>

    <div id="marc">        

        <div id="contingut">
                        
            <!-- CONTINGUTS -->            
            <div style="margin-bottom:40px; ">
            
                <!-- MENÚ ESQUERRA -->
                    <?php include_partial('menu', array( 'MODE' => $mode , 'A_MENU' => $A_MENU , 'A_ACTIVITATS_AVUI' => $A_ACTIVITATS_AVUI , 'A_ACTIVITATS_FUTURES' => $A_ACTIVITATS_FUTURES , 'PAGE' => $PAGE , 'SUBMENU' => $A_NODE )); ?>
                <!-- MENÚ ESQUERRA -->                
                
                <!-- CONTINGUT -->                    
                    <?php 
                    switch($mode){                        
                        case 'llista': include_partial( 'llista' , array( 'A_LLISTA' => $A_LLISTA ) ); break;
                        case 'detall': include_partial( 'detall' , array( 'CONTINGUT' => $CONTINGUT , 'HORARIS' => $HORARIS , 'TITOL' => $TITOL , 'INFO_PRACTICA' => $INFO_PRACTICA , 'IMG' => $IMG , 'A_LLISTA' => $A_LLISTA ) ); break;
                        default: include_partial( 'home' , array( 'CAPTCHA' => $CAPTCHA ) ); break;                        
                    } 
                    ?>
                <!-- FI CONTINGUT -->
                              
            </div>            
            <!-- FI CONTINGUTS -->
            
            <!-- FOOTER -->            
                <?php include_partial('footer'); ?>            
            <!-- FI FOOTER -->
                        
        </div>                        
    </div> 

</body>
</html>