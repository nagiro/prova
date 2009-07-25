
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
  <meta http-equiv="content-type" content="text/html; charset=windows-1250">
  <meta name="generator" content="PSPad editor, www.pspad.com">

  <?php include_http_metas() ?>
  <?php include_metas() ?>
  
  <?php include_title() ?>
  
  <link rel="shortcut icon" href="/favicon.ico" />
  
  <STYLE>	
 	
	
/*    
            
    .BOX { border-collapse:collapse; border:5px solid #f3f3f3; margin-bottom:10px; width:90%; }
    .BOX .FOTO { width:130px; vertical-align:top; }
    .BOX .FOTO .IMG_FOTO { width:120px; border:10px solid white; }
    .BOX .NOTICIA { padding:10px; }    
    .BOX .DATA { color:#a3c101; font-size:11px; margin-bottom:20px; }
    .BOX .TITOL { color:black; font-size:11px; font-weight:bold; margin-bottom:10px; vertical-align: top; padding:4px; }
    .BOX .TEXT { color:black; font-size:11px; margin-bottom:10px; }
    .BOX .PEU { background-color:white; border:0px; }
    .BOX TD { padding-top:4px; padding-bottom:4px; }         
    .BOX .BOTONS { text-align: right; }
    
    .BOX .NOTICIA_MENU { margin:0px; padding-top:0px; padding-bottom: 10px; padding-left:0px; padding-right:10px; }
    .BOX .SUBMEN { border-collapse:collapse; border: 4px #F3F3F3 solid; border-left-width:0px; border-top-width: 0px; padding:5px;  }
    .BOX TD.SUBMEN { padding:5px; padding-left:10px; padding-right:10px; background-color: #F3F3F3; text-align: left; font-size:11px; font-weight: bold; }
    .BOX TD.SUBMEN1 { padding:5px; padding-left:10px; padding-right:10px; background-color: white; text-align: left; font-size:11px; font-weight: bold; }
   
    
    .CAL { width:175px; margin-top:20px; }
    .CAL .CERCA { width:152px; margin-bottom:10px; }
    .CAL .CALENDARI { margin-bottom:10px; }
    .CAL .BANNER { margin-bottom:5px; width:175px; height:70px; }
            
    #logo { padding-left:10px; }
    
    A.white { text-decoration:none; color:white; }
    A.white:hover { font-weight:bold; text-decoration: underline; color:white; }
    A.white:visited { color:white; text-decoration:none; }
    A.black  { text-decoration:none; color:black; }
    A.black:hover { text-decoration: underline; font-weight:bold; color:black; }
    A.black:visited { color:black; text-decoration:none; }
    A.verd  { text-decoration:none; color:#a3c101; }
    A.verd:hover { text-decoration: underline; font-weight:bold; color:#a3c101; }
    A.verd:visited { color:#a3c101; text-decoration:none; }
    
    .DADES { border-collapse:collapse; width:100%; }
    .DADES .LINIA { color:black; font-size:11px; border-bottom: 2px #F3F3F3 dotted; vertical-align: top; }
    .DADES .LINIA A { text-decoration:none; color:black; }
    .DADES .LINIA A:hover { text-decoration:none; font-weight:bold; }
    .DADES .LINIA A:visited { text-decoration:none; color:black; }           
    .DADES .ERRORS { color:red; font-size:11px; border-bottom: 2px #F3F3F3 dotted; }
    .DADES TR:hover { background-color: #F3F3F3; }     
*/   
  </STYLE>

  
  <title></title>
    <base href="http://localhost/intranet_dev.php" />  
    <!--   	<base href="http://servidor.casadecultura.cat/intranet/intranet_dev.php" /> -->
  </head>
  <body>
  <center>
    <TABLE class="TAULA">
    <TR><TD colspan="4" class="DEGRADAT_SUPERIOR"><?php echo image_tag('intranet/DifuminatSuperior.png', array()); ?></TD></TR>
    <TR><TD class="CAPCALERA"><?php echo image_tag('intranet/logoCCG.png', array('class'=>'logo')); ?></TD><TD class="CAPCALERA"></TD><TD class="MENU_CAPCALERA" style="text-align:right;"><?php echo image_tag('intranet/cursos.png', array()); ?></TD><TD class="MENU_CAPCALERA" style="text-align:left;"><?php echo image_tag('intranet/hospici.png', array('style'=>'margin-right:4px')); ?><?php echo image_tag('intranet/contacte.png', array()); ?></TD></TR>
<!--  <TR><TD class="FOTOS"><?php echo image_tag('intranet/logoCCG.png', array('class'=>'IMG_FOTO')); ?></TD><TD class="FOTOS"><?php echo image_tag('intranet/logoCCG.png', array('class'=>'IMG_FOTO')); ?></TD><TD class="FOTOS"><?php echo image_tag('intranet/logoCCG.png', array('class'=>'IMG_FOTO')); ?></TD><TD class="FOTOS"><?php echo image_tag('intranet/logoCCG.png', array('class'=>'IMG_FOTO')); ?></TD></TR> -->
    <TR>    
      <TD class="MENU">
        <CENTER>
          <TABLE class="MENU_TABLE">
            <TR><TD class="SUBMENU1"><?php echo imgSub1().' PERSONAL'; ?></TD></TR>
              <TR><TD class="SUBMENU2"><?php echo link_to(imgSub2().' Avui','gestio/main'); ?></TD></TR>
              <TR><TD class="SUBMENU2"><?php echo link_to(imgSub2().' Agenda','gestio/gAgenda'); ?></TD></TR>
              <TR><TD class="SUBMENU2"><?php echo link_to(imgSub2().' Taulell','gestio/gMissatges'); ?></TD></TR>
              <TR><TD class="SUBMENU2"><?php echo link_to(imgSub2().' Tasques','gestio/gTasques'); ?></TD></TR>
              <TR><TD class="SUBMENU2"><?php echo link_to(imgSub2().' Material','gestio/gMaterial'); ?></TD></TR>
              <TR><TD class="SUBMENU2"><?php echo link_to(imgSub2().' Cessio/Reparació','gestio/gCessio'); ?></TD></TR>                            
              <TR><TD class="SUBMENU2"><?php echo link_to(imgSub2().' Reserves','gestio/gReserves'); ?></TD></TR>                                                                      
              <TR><TD class="SUBMENU2"><?php echo link_to(imgSub2().' Incidències','gestio/gIncidencies'); ?></TD></TR>
            <TR><TD class="SUBMENU1"><?php echo imgSub1().' ACTIVITATS'; ?></TD></TR>
              <TR><TD class="SUBMENU2"><?php echo link_to(imgSub2().' Cursos','gestio/gCursos'); ?></TD></TR>
			  <TR><TD class="SUBMENU2"><?php echo link_to(imgSub2().' Matricules','gestio/gMatricules'); ?></TD></TR>
              <TR><TD class="SUBMENU2"><?php echo link_to(imgSub2().' Activitats','gestio/gActivitats'); ?></TD></TR>             
              <TR><TD class="SUBMENU2"><?php echo link_to(imgSub2().' Espais','gestio/gEspais'); ?></TD></TR>
            <TR><TD class="SUBMENU1"><?php echo imgSub1().' WEB'; ?></TD></TR>          
              <TR><TD class="SUBMENU2"><?php echo link_to(imgSub2().' Gestió estructura','gestio/gEstructura'); ?></TD></TR>
              <TR><TD class="SUBMENU2"><?php echo link_to(imgSub2().' Promocions','gestio/gPromocions'); ?></TD></TR>                                                                          
              <TR><TD class="SUBMENU2"><?php echo link_to(imgSub2().' Notícies','gestio/gNoticies'); ?></TD></TR>
            <TR><TD class="SUBMENU1"><?php echo imgSub1().' USUARIS'; ?></TD></TR>
              <TR><TD class="SUBMENU2"><?php echo link_to(imgSub2().' Gestió d\'usuaris','gestio/gUsuaris'); ?></TD></TR>
              <TR><TD class="SUBMENU2"><?php echo link_to(imgSub2().' Llistes','gestio/gLlistes'); ?></TD></TR>                                        
			<TR><TD class="SUBMENU1"><?php echo imgSub1().' LOGIN'; ?></TD></TR>
			  <TR><TD class="SUBMENU2"><?php echo link_to(imgSub2().' Logout','web/logout'); ?></TD></TR>
			  <TR><TD class="SUBMENU2"><?php echo link_to(imgSub2().' Web','web/index'); ?></TD></TR>			
          </TABLE>
        </CENTER>
        </TD>      
    
    <?php echo $sf_content ?>

    
    </TR>
    <TR><TD colspan="4" class="PEU">CASA DE CULTURA | Pl. hospital,6. 17001. Girona | T. 972 20 20 13 | <a class="white" href="mailto:informatica@casadecultura.org">E-mail</a> | Informació legal</TD></TR>
    <TR><TD colspan="4" class="DEGRADAT_INFERIOR"></TD></TR>     
    </TABLE>
  </center>
  </body>
</html>

<?php 

  function imgSub1()
  {
    return image_tag('intranet/Submenu1.png', array('align'=>'ABSMIDDLE'));
  }
  
  function imgSub2()
  {
    return image_tag('intranet/Submenu2.png', array('align'=>'ABSMIDDLE'));
  }

?>
