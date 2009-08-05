
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
  <meta http-equiv="content-type" content="text/html; charset=windows-1250">
  <meta name="generator" content="PSPad editor, www.pspad.com">

  <?php include_http_metas() ?>
  <?php include_metas() ?>
  
  <?php include_title() ?>
  
  <link rel="shortcut icon" href="/favicon.ico" />
  
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
