<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"><html>  <head>  <meta http-equiv="content-type" content="text/html; charset=windows-1250">  <meta name="generator" content="PSPad editor, www.pspad.com">    
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
        </head>  <body class="CCG">  <center>  	        <TABLE class="TAULA">    <!-- <TR><TD colspan="4" class="DEGRADAT_SUPERIOR"><?php echo image_tag('intranet/DifuminatSuperior.png', array()); ?></TD></TR>  -->       <TR>
    	<TD class="CAPCALERA"><?php echo link_to(image_tag('intranet/logoCCG.png', array('id'=>'logo')),'web/index?accio=no'); ?></TD>
    	<TD class="CAPCALERA"></TD>
    	<TD class="CAPCALERA" style="width:512px;" colspan="2" style="">		<div style="vertical-align:bottom; position:relative;">
			<div class="PESTANYA_SUPERIOR">
				<a href="<?php echo url_for('web/contacta'); ?>">
					<img src="<?php echo url_for(sfConfig::get('sf_webrooturl').'images/menu_03.png'); ?>" /> 
				</a>
			</div>
			<div class="PESTANYA_SUPERIOR">
				<a href="http://www.casadecultura.org/giroscopi">
					<img src="<?php echo url_for(sfConfig::get('sf_webrooturl').'images/menu_04.png'); ?>" /> 
				</a>
			</div>
			<div class="PESTANYA_SUPERIOR">
				<a href="<?php echo url_for('web/espais'); ?>">
					<img src="<?php echo url_for(sfConfig::get('sf_webrooturl').'images/menu_05.png'); ?>" /> 
				</a>
			</div>
			<div class="PESTANYA_SUPERIOR">
				<a href="<?php echo url_for('web/cursos'); ?>">
					<img src="<?php echo url_for(sfConfig::get('sf_webrooturl').'images/menu_06.png'); ?>" /> 
				</a>
			</div>
			<div class="PESTANYA_SUPERIOR">
				<a href="http://localhost/hospici_dev.php/directori/inicial">
					<img src="<?php echo url_for(sfConfig::get('sf_webrooturl').'images/menu_07.png'); ?>" /> 
				</a>
			</div>
		</div>		    	    		    		    		    	
    	</TD>
	</TR>    <?php echo $sf_content ?>            <TR><TD colspan="4" class="PEU">CASA DE CULTURA DE GIRONA | Pl. hospital,6. 17001. Girona | T. 972 20 20 13 | <a class="white" href="mailto:informatica@casadecultura.org">E-mails</a> | <a class="white" href="" >Informació legal</a></TD></TR>    <TR><TD colspan="4" class="DEGRADAT_INFERIOR"></TD></TR>         </TABLE>  </center>  </body></html>
