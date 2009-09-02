<?php // use_helper('Asset'); ?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"><html>  <head>  <meta http-equiv="content-type" content="text/html; charset=windows-1250">  <meta name="generator" content="PSPad editor, www.pspad.com">    <STYLE>
  
  	//Reset
	html, body, div, span, applet, object, iframe, h1, h2, h3, h4, h5, h6, p, blockquote, pre, a, abbr, acronym, address, big, cite, code, del, dfn, em, font, img, ins, kbd, q, s, samp, small, strike, strong, sub, sup, tt, var, dl, dt, dd, ol, ul, li, fieldset, form, label, legend, table, caption, tbody, tfoot, thead, tr, th, td, center, u, b, i {  margin: 0; padding: 0; border: 0; outline: 0; font-weight: normal; font-style: normal; font-size: 100%; font-family: inherit; vertical-align: baseline; }
	body { line-height: 1 }
	:focus { outline: 0 }
	ol, ul {list-style: none }
	table { border-collapse: collapse; border-spacing: 0 }
	blockquote:before, blockquote:after, q:before, q:after { content: "" }
	blockquote, q { quotes: "" "" }
	input, textarea { margin: 0; padding: 0 }
	hr { margin: 0; padding: 0; border: 0; color: #000;  background-color: #000; height: 1px }
  
  	.Titol_N1 { font-size:14px; margin-right:40px; font-weight: bold; margin-bottom:20px; padding-top:20px; }
  	.Titol_N2 { font-size:12px; margin-right:40px; font-weight: bold; margin-bottom:10px; padding-top:10px; } 
  	.Text { font-size:11px; margin-right:40px; text-align: justify; }
   	.error { color:red; font-style: italic; }  
  	//CSS	a.tt2:hover span { margin-top:10px; padding:5px; position: absolute; display: block; background: #fdd; border: 1px solid brown; font-size:10px; font-weight:normal; }  
	a.tt2 span { display:none; }
	
	.HIDDEN {  visibility: hidden; }
	.VISIBLE { visibility: visible; }
	
    body { background-color: #680000; font-family: Verdana; font-size: 10px; }
    .TAULA { width:1024px; border-collapse: collapse;}
    .CAPCALERA { background-color: #ae1912; border: 0px;}
    #MENU_CURSOS { vertical-align:bottom;  }
    #MENU_HOSPICI { padding-left:4px;vertical-align:bottom;  }
    #MENU_CONTACTANS { vertical-align:bottom;  }
    
    .MENU_CAPCALERA { background-color: #ae1912; height:65px; border: 0px; vertical-align:bottom; }
    #logo { position:relative; left:20px; top:0px; }

	.MENU_PESTANYA  { border:0px;  }
	A.MENU_PESTANYA { border:0px; margin:0px; }

    .FOTOS { background-color:white; }
    .MENU { background-color:white; vertical-align:top; } 
    .CONTINGUT { background-color:white; vertical-align: top; padding-top:20px; }    
    .CALENDARI { background-color:white; vertical-align: top; }        
    .PEU { height:25px; background-color:#1f1a17; border-left:4px solid #1f1a17; border-right:4px solid #1f1a17; border-top:4px solid #1f1a17; color: white; text-align:center; font-size: 10px; }    
    .DEGRADAT_INFERIOR { background-image: url(DifuminatInferior.png); background-repeat: repeat-x; }    
        
    .FOTOS .IMG_FOTO { width:256px; height:80px; border-top:2px solid white; border-left:1px solid white; border-left:1px solid white; }
            
    #ESPAI { margin-top:20px; }
   
	.MENU_TABLE {  }
    .SUBMENU1   { font-size:9px; background-color:#b58282; border:1px solid black; width:165px; height:30px; vertical-align:middle; padding-left:10px; border:1px solid white; }
    .SUBMENU1T  { font-size:9px; background-color:#b58282; border:1px solid black; width:165px; height:30px; vertical-align:middle; padding-left:10px; border:1px solid white; }
    .SUBMENU2   { font-size:9px; border:1px solid black; width:165px; height:30px; vertical-align:middle; padding-left:10px; background-color: white; border:1px solid white; }
    #REGISTRAT  { font-size:9px; background-color: #680000; border:2px solid white; height:30px; width:175px; text-align:center; display: table-cell; vertical-align: middle; }
    #REGISTRAT a { color:white; font-size:9px; text-decoration: none; }
    #REGISTRAT a:visited { color:white; font-size:9px; text-decoration: none; }
    .MENU_TABLE A { color:black; font-size:9px; text-decoration: none; }
    .MENU_TABLE A:hover { color:black; font-size:9px; text-decoration: none; }
    .MENU_TABLE A:visited { color:black; font-size:9px; text-decoration: none; }    
     A IMG { border:0px; }
                
    .BOX { border-collapse:collapse; border:5px solid #f3f3f3; margin-bottom:10px; width:100%; }
    .BOX .FOTO { width:130px; vertical-align:top; }
    .BOX .FOTO .IMG_FOTO { width:120px; border:10px solid white; }
    .BOX .NOTICIA { padding:10px; vertical-align:top; }    
    .BOX .DATA { color:#a3c101; font-size:11px; margin-bottom:20px; }
    .BOX .TITOL { color:black; font-size:11px; font-weight:bold; margin-bottom:10px; }
    .BOX .TEXT { color:black; font-size:11px; margin-bottom:10px; }
    .BOX .PEU { background-color:white; border:0px; }
    .BOX .ERRORS  { color:red; font-size:11px; }
    
    .BOX .NOTICIA_MENU { margin:0px; padding-top:0px; padding-bottom: 10px; padding-left:0px; padding-right:10px; }
    .BOX .SUBMEN { border-collapse:collapse; border: 4px #F3F3F3 solid; border-left-width:0px; border-top-width: 0px; padding:5px;  }
    .BOX TD.SUBMEN { padding:5px; padding-left:10px; padding-right:10px; background-color: #F3F3F3; text-align: left; font-size:11px; font-weight: bold; }
    .BOX TD.SUBMEN1 { padding:5px; padding-left:10px; padding-right:10px; background-color: white; text-align: left; font-size:11px; font-weight: bold; }
       
    .CAL { width:175px; margin-top:20px; }
    .CAL .CERCA { width:152px; margin-bottom:10px; }
    .CAL .CALENDARI { margin-bottom:10px; }
    .CAL .BANNER { margin-bottom:10px; width:175px; height:70px; }
    
    A.white { text-decoration:none; color:white; }
    A.white:hover { font-weight:bold; text-decoration: underline; color:white; }
    A.white:visited { color:white; text-decoration:none; }
    A.black  { text-decoration:none; color:black; }
    A.black:hover { text-decoration: underline; font-weight:bold; color:black; }
    A.black:visited { color:black; text-decoration:none; }
    A.verd  { text-decoration:none; color:#a3c101; }
    A.verd:hover { text-decoration: underline; font-weight:bold; color:#a3c101; }
    A.verd:visited { color:#a3c101; text-decoration:none; }
    A.taronja  { text-decoration:none; color:orange; }
    A.taronja:hover { text-decoration: underline; font-weight:bold; color:orange; }
    A.taronja:visited { color:orange; text-decoration:none; }
    
    .DADES { border-collapse:collapse; width:100%; }
    .DADES .LINIA { color:black; font-size:11px; border-bottom: 2px #F3F3F3 dotted; vertical-align: top; }
    .DADES .OPCIONS { color:black; font-size:11px; border-bottom: 2px #F3F3F3 dotted; width:70px; }
    .DADES .LINIA A { text-decoration:none; color:black; }
    .DADES .LINIA A:hover { text-decoration:none; font-weight:bold; }
    .DADES .LINIA A:visited { text-decoration:none; color:black; }   
    .DADES .ERRORS { color:red; font-size:11px; border-bottom: 2px #F3F3F3 dotted; }
    .DADES TR:hover { background-color: #F3F3F3; }
    .DADES .TITOL { font-weight: bold; font-size:10px;  }
    
//Dades per un requadre inputs    
	.REQUADRE { border:5px solid #f3f3f3; padding:10px; margin-right:40px; }
	.LLEGENDA { font-size:12px; font-weight:bold; padding:10px 10px 10px 10px; }
	.FORMULARI { width:100%; }
	.FORMULARI TD { color:black; font-size:11px; border-bottom: 2px #F3F3F3 dotted; vertical-align: top; text-align:left;  }
	.FORMULARI TD A { text-decoration:none; color:black; }
	.FORMULARI TD A:hover { text-decoration:none; color:black; }
	.FORMULARI TD A:visited { text-decoration:none; color:black; }
	.FORMULARI TD A:hover { text-decoration:none; color:black; }
            
	.div_taula .t_calendari { border-collapse:collapse; border:0px #CCCCCC solid; }
    .div_taula .titol { border-collapse: collapse; background-color: #CCCCCC; text-align:center; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:bold; color: #606060; font-size:10px; padding:2px; }    
    .div_taula .dies { text-align: center; font-weight: bold; font-family: verdana; font-size: 10px; padding: 2px; }    
    .div_taula .numeros { font-family: verdana; font-size: 10px; text-align: right; padding: 2px; }    
    .div_taula { width:175px; border:3px solid #CCCCCC; }    
    .div_taula .selsetmana { background-color: #F9E8E4; color: #6E1F0C; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:10px; padding:2px; text-align:right; }
    .div_taula .selsetmana a { text-decoration: none; color: #6E1F0C; }
    .div_taula a { text-decoration:none; color: #606060; }
    .div_taula .HIHAACTIVITAT { background-color: lime; font-weight: bold; }    

	.CERCA_TITOL { font-size:10px; font-weight: bold; }
	.CERCA_TEXT  { font-size:10px; color:gray; margin-left:20px; }
	.CERCA_DIES  { font-size:10px; color:gray; margin-left:20px; }
	li.CERCA { border:2px solid #CCCCCC; padding:10px; }
    
    .bold { font-weight:bold; }    
      </STYLE>    <title></title>
   <base href="http://localhost/intranet_dev.php" />
   <!-- <base href="http://servidor.casadecultura.cat/intranet/intranet_dev.php" /> -->      </head>  <body>  <center>  	    <TABLE class="TAULA">    <TR><TD colspan="4" class="DEGRADAT_SUPERIOR"><?php echo image_tag('intranet/DifuminatSuperior.png', array()); ?></TD></TR>    <TR>
    	<TD class="CAPCALERA"><?php echo link_to(image_tag('intranet/logoCCG.png', array('id'=>'logo')),'web/index'); ?></TD>
    	<TD class="CAPCALERA"></TD>
    	<TD class="MENU_CAPCALERA" style="text-align:right;">
    	   <?php echo link_to(image_tag('intranet/espais.png', array('id'=>'MENU_CURSOS')),'web/espais',array()); ?>    	  
    	   <?php echo link_to(image_tag('intranet/cursos.png', array('id'=>'MENU_CURSOS')),'web/cursos',array()); ?></TD>
    	<TD class="MENU_CAPCALERA" style="text-align:left;">    	
           <?php echo link_to(image_tag('intranet/hospici.png', array('id'=>'MENU_HOSPICI')),'http://localhost/hospici_dev.php/directori/inicial',array()); ?>    	   
    	   <?php echo link_to(image_tag('intranet/contacte.png', array('id'=>'MENU_CONTACTANS')),'web/contacte',array()); ?>
    	   </TD>
	</TR>    <?php echo $sf_content ?>            <TR><TD colspan="4" class="PEU">CASA DE CULTURA | Pl. hospital,6. 17001. Girona | T. 972 20 20 13 | <a class="white" href="mailto:informatica@casadecultura.org">E-mail</a> | Informaci� legal</TD></TR>    <TR><TD colspan="4" class="DEGRADAT_INFERIOR"></TD></TR>         </TABLE>  </center>  </body></html>