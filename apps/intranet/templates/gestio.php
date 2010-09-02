<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
  <meta http-equiv="content-type" content="text/html; charset=windows-1250">
  <meta name="generator" content="PSPad editor, www.pspad.com">
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
        
    <link rel="shortcut icon" href="/favicon.ico" />
    <link rel="stylesheet" type="text/css" media="screen" href="/web_beta/css/gestio.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="/web_beta/css/smoothness/jquery-ui-1.7.2.custom.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="/web_beta/css/jquery-datepick/jquery.datepick.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="/web_beta/css/thickbox.css" />
    <script type="text/javascript" src="/web_beta/js/jquery-1.4.1.min.js"></script>
    <script type="text/javascript" src="/web_beta/js/tiny_mce/tiny_mce.js"></script>    
    <script type="text/javascript" src="/web_beta/js/thickbox-compressed.js"></script>
    <script type="text/javascript" src="/web_beta/js/jquery-ui/js/jquery-ui-1.7.2.custom.min.js"></script>        
      
  <link rel="shortcut icon" href="/favicon.ico" />
  
  <title></title>
    <!--    <base href="http://localhost/intranet_dev.php" /> -->  
    <!--   	<base href="http://servidor.casadecultura.cat/intranet/intranet_dev.php" /> -->
  </head>
  
  <body class="CCG">
  <center>
    <TABLE class="TAULA">
<!--  <TR><TD colspan="4" class="DEGRADAT_SUPERIOR"><?php echo image_tag('intranet/DifuminatSuperior.png', array()); ?></TD></TR>  -->
    <TR><TD colspan="4" class="CAPCALERA"><?php echo link_to(image_tag('intranet/logoCCG.png', array('id'=>'logo')),'web/index?accio=no'); ?></TD></TR>
<!--  <TR><TD class="FOTOS"><?php echo image_tag('intranet/logoCCG.png', array('class'=>'IMG_FOTO')); ?></TD><TD class="FOTOS"><?php echo image_tag('intranet/logoCCG.png', array('class'=>'IMG_FOTO')); ?></TD><TD class="FOTOS"><?php echo image_tag('intranet/logoCCG.png', array('class'=>'IMG_FOTO')); ?></TD><TD class="FOTOS"><?php echo image_tag('intranet/logoCCG.png', array('class'=>'IMG_FOTO')); ?></TD></TR> -->
    <TR>    
      <TD class="MENU">
        <CENTER>
          <TABLE class="MENU_TABLE">
            <TR><TD class="SUBMENU_1"><?php echo imgSub1().' PERSONAL'; ?></TD></TR>
              <TR><TD class="SUBMENU_2"><?php echo link_to(imgSub2().' Avui','gestio/main'); ?></TD></TR>
              <TR><TD class="SUBMENU_2"><?php echo link_to(imgSub2().' Contactes','gestio/gAgenda?accio=C'); ?></TD></TR>
              <TR><TD class="SUBMENU_2"><?php echo link_to(imgSub2().' Taulell','gestio/gMissatges?accio=I'); ?></TD></TR>
              <TR><TD class="SUBMENU_2"><?php echo link_to(imgSub2().' Material','gestio/gMaterial?accio=C'); ?></TD></TR>
              <TR><TD class="SUBMENU_2"><?php echo link_to(imgSub2().' Cessio/Reparació','gestio/gCessio?accio=C'); ?></TD></TR>                            
              <TR><TD class="SUBMENU_2"><?php echo link_to(imgSub2().' Reserves d\'espais','gestio/gReserves?accio=C'); ?></TD></TR>                                                                      
              <TR><TD class="SUBMENU_2"><?php echo link_to(imgSub2().' Incidències','gestio/gIncidencies?accio=C'); ?></TD></TR>
              <TR><TD class="SUBMENU_2"><?php echo link_to(imgSub2().' Informes','gestio/gInformes'); ?></TD></TR>
              <TR><TD class="SUBMENU_2"><?php echo link_to(imgSub2().' Horaris i feines','gestio/gPersonal'); ?></TD></TR>              
            <TR><TD class="SUBMENU_1"><?php echo imgSub1().' PROGRAMACIÓ'; ?></TD></TR>
              <TR><TD class="SUBMENU_2"><?php echo link_to(imgSub2().' Cursos','gestio/gCursos?accio=C'); ?></TD></TR>
			  <TR><TD class="SUBMENU_2"><?php echo link_to(imgSub2().' Matricules','gestio/gMatricules?accio=C'); ?></TD></TR>
              <TR><TD class="SUBMENU_2"><?php echo link_to(imgSub2().' Agenda','gestio/gActivitats?accio=C'); ?></TD></TR>             
              <TR><TD class="SUBMENU_2"><?php echo link_to(imgSub2().' Cicles','gestio/gCicles?accio=C'); ?></TD></TR>
              <TR><TD class="SUBMENU_2"><?php echo link_to(imgSub2().' Estadístiques','gestio/gEspais?accio=CC'); ?></TD></TR>
            <TR><TD class="SUBMENU_1"><?php echo imgSub1().' WEB'; ?></TD></TR>          
              <TR><TD class="SUBMENU_2"><?php echo link_to(imgSub2().' Gestió estructura','gestio/gEstructura?accio=CC'); ?></TD></TR>
              <TR><TD class="SUBMENU_2"><?php echo link_to(imgSub2().' Promocions','gestio/gPromocions?accio=CC'); ?></TD></TR>                                                                          
              <TR><TD class="SUBMENU_2"><?php echo link_to(imgSub2().' Notícies','gestio/gNoticies?accio=CC'); ?></TD></TR>
            <TR><TD class="SUBMENU_1"><?php echo imgSub1().' USUARIS'; ?></TD></TR>
              <TR><TD class="SUBMENU_2"><?php echo link_to(imgSub2().' Gestió d\'usuaris','gestio/gUsuaris?accio=CC'); ?></TD></TR>              
              <TR><TD class="SUBMENU_2"><?php echo link_to(imgSub2().' Llistes','gestio/gLlistes'); ?></TD></TR>                                        
			<TR><TD class="SUBMENU_1"><?php echo imgSub1().' APLICACIONS'; ?></TD></TR>
              <TR><TD class="SUBMENU_2"><?php echo link_to(imgSub2().' Documents','gestio/gDocuments?accio=GP'); ?></TD></TR>                                          
              <TR><TD class="SUBMENU_2"><?php echo link_to(imgSub2().' Blogs','gestio/gBlogs?accio=VB'); ?></TD></TR>
              <TR><TD class="SUBMENU_2"><?php echo link_to(imgSub2().' Entrades','gestio/gEntrades?accio=C'); ?></TD></TR>
			<TR><TD class="SUBMENU_1"><?php echo imgSub1().' ARXIU'; ?></TD></TR>
              <TR><TD class="SUBMENU_2"><?php echo link_to(imgSub2().' DVDs / CDs','gestio/gArxiuDvd?accio=CC'); ?></TD></TR>                                          
              <TR><TD class="SUBMENU_2"><?php echo link_to(imgSub2().' Històric','gestio/gArxiuDocuments?accio=CC'); ?></TD></TR>                            
			<TR><TD class="SUBMENU_1"><?php echo imgSub1().' LOGIN'; ?></TD></TR>
			  <TR><TD class="SUBMENU_2"><?php echo link_to(imgSub2().' Sortir','web/logout'); ?></TD></TR>
			  <TR><TD class="SUBMENU_2"><?php echo link_to(imgSub2().' Web','web/index',array('target'=>'_NEW')); ?></TD></TR>			
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
    return image_tag('intranet/Submenu1T.png', array('align'=>'ABSMIDDLE'));
  }
  
  function imgSub2()
  {
    return image_tag('intranet/Submenu2.png', array('align'=>'ABSMIDDLE'));
  }

?>
