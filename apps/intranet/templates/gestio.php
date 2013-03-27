<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html xmlns="http://www.w3.org/1999/xhtml"
      xmlns:fb="http://www.facebook.com/2008/fbml">
  <head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />   

  <?php $BASE = OptionsPeer::getString('SF_WEBROOT',1); ?>
      
  <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $BASE.'css/gestio.css'; ?>" />
  <link rel="stylesheet" type="text/css" media="screen" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.21/themes/smoothness/jquery-ui.css" />
  
  <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $BASE.'css/jquery-datepick/jquery.datepick.css'; ?>" />
  <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $BASE.'css/jquery.autocompleter.css'; ?>" />
  <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $BASE.'css/thickbox.css'; ?>" />
  <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $BASE.'js/uploader/client/fileuploader.css'; ?>" />    

  <!--[if lte IE 7]>
    <link type="text/css" rel="stylesheet" media="all" href="css/screen_ie.css" />
  <![endif]-->
      
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.21/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?php echo $BASE.'js/jquery-ui/js/jquery-datepicker-ca.js'; ?>"></script>
  
  
  <script type="text/javascript" src="<?php echo $BASE.'js/tiny_mce/tiny_mce.js'; ?>"></script>              
  <script type="text/javascript" src="<?php echo $BASE.'js/jquery.datepick.package-3.7.1/jquery.datepick.js'; ?>"></script>
  <script type="text/javascript" src="<?php echo $BASE.'js/jquery.datepick.package-3.7.1/jquery.datepick-ca.js'; ?>"></script>    
  <script type="text/javascript" src="<?php echo $BASE.'js/jquery.cookie.js'; ?>"></script>
  <script type="text/javascript" src="<?php echo $BASE.'js/jquery-validate/jquery.validate.min.js'; ?>"></script>
  <script type="text/javascript" src="<?php echo $BASE.'js/jquery-validate/localization/messages_es.js'; ?>"></script>  
    
  <script type="text/javascript" src="<?php echo $BASE.'js/buttonfix.js'; ?>"></script>    
  <script type="text/javascript" src="<?php echo $BASE.'js/gestio.js'; ?>"></script>
  
  <script type="text/javascript" src="<?php echo $BASE.'js/uploader/client/fileuploader.js'; ?>" ></script>
    
<!--[if lt IE 7]>
    <script type="text/javascript" src="<?php echo $BASE.'js/buttonfix.js'; ?>"></script>
    <script>alert('El seu navegador és antic. Si us plau instal·lis qualsevol navegador que no sigui Internet Explorer');</script>
<![endif]-->
  
  <title>L'Hospici :: Gestor d'entitats culturals</title>
  
  </head>
  
  <body class="CCG">  
  <center>          
    <TABLE class="TAULA">
<!--  <TR><TD colspan="4" class="DEGRADAT_SUPERIOR"><?php echo image_tag('intranet/DifuminatSuperior.png', array()); ?></TD></TR>  -->
    <TR><TD colspan="4" class="CAPCALERA"><?php echo link_to(image_tag('intranet/logoCCG.png', array('id'=>'logo')),'gestio/ULogin'); ?></TD></TR>
<!--  <TR><TD class="FOTOS"><?php echo image_tag('intranet/logoCCG.png', array('class'=>'IMG_FOTO')); ?></TD><TD class="FOTOS"><?php echo image_tag('intranet/logoCCG.png', array('class'=>'IMG_FOTO')); ?></TD><TD class="FOTOS"><?php echo image_tag('intranet/logoCCG.png', array('class'=>'IMG_FOTO')); ?></TD><TD class="FOTOS"><?php echo image_tag('intranet/logoCCG.png', array('class'=>'IMG_FOTO')); ?></TD></TR> -->
    <TR>    
      <TD class="MENU">
      
      <?php
        if($sf_user->getSessionPar('idU') > 0): 
            //Carreguem els menús que podrà veure l'usuari                        
            $LOM = GestioMenusPeer::getMenusUsuari($sf_user->getSessionPar('idU'),$sf_user->getSessionPar('idS'),$sf_user->getSessionPar('idN'));
            $ANT = "";
            echo '<CENTER><TABLE class="MENU_TABLE">';
            foreach($LOM as $OM):
                if($ANT <> $OM->getCategoria()):
                    echo '<TR><TD class="SUBMENU_1">'.imgSub1().' '.$OM->getCategoria().'</TD></TR>';
                    $ANT = $OM->getCategoria();
                endif; 
                echo '<TR><TD class="SUBMENU_2">'.link_to(imgSub2().' '.$OM->getTitol(),$OM->getUrl()).'</TD></TR>';
            endforeach;
            echo '</TABLE></CENTER>';        
        endif; 
      ?>      			                  
      </TD>      
    
    <?php echo $sf_content ?>

    
    </TR>
    <TR><TD colspan="4" class="PEU">CASA DE CULTURA | Pl. hospital,6. 17002. Girona | T. 972 20 20 13 | <a class="white" href="mailto:informatica@casadecultura.org">E-mail</a> | Informació legal</TD></TR>
    <TR><TD colspan="4" class="DEGRADAT_INFERIOR"></TD></TR>     
    </TABLE>
  </center>
  
<!-- begin olark code -->
<script data-cfasync="false" type='text/javascript'>/*<![CDATA[*/window.olark||(function(c){var f=window,d=document,l=f.location.protocol=="https:"?"https:":"http:",z=c.name,r="load";var nt=function(){
f[z]=function(){
(a.s=a.s||[]).push(arguments)};var a=f[z]._={
},q=c.methods.length;while(q--){(function(n){f[z][n]=function(){
f[z]("call",n,arguments)}})(c.methods[q])}a.l=c.loader;a.i=nt;a.p={
0:+new Date};a.P=function(u){
a.p[u]=new Date-a.p[0]};function s(){
a.P(r);f[z](r)}f.addEventListener?f.addEventListener(r,s,false):f.attachEvent("on"+r,s);var ld=function(){function p(hd){
hd="head";return["<",hd,"></",hd,"><",i,' onl' + 'oad="var d=',g,";d.getElementsByTagName('head')[0].",j,"(d.",h,"('script')).",k,"='",l,"//",a.l,"'",'"',"></",i,">"].join("")}var i="body",m=d[i];if(!m){
return setTimeout(ld,100)}a.P(1);var j="appendChild",h="createElement",k="src",n=d[h]("div"),v=n[j](d[h](z)),b=d[h]("iframe"),g="document",e="domain",o;n.style.display="none";m.insertBefore(n,m.firstChild).id=z;b.frameBorder="0";b.id=z+"-loader";if(/MSIE[ ]+6/.test(navigator.userAgent)){
b.src="javascript:false"}b.allowTransparency="true";v[j](b);try{
b.contentWindow[g].open()}catch(w){
c[e]=d[e];o="javascript:var d="+g+".open();d.domain='"+d.domain+"';";b[k]=o+"void(0);"}try{
var t=b.contentWindow[g];t.write(p());t.close()}catch(x){
b[k]=o+'d.write("'+p().replace(/"/g,String.fromCharCode(92)+'"')+'");d.close();'}a.P(2)};ld()};nt()})({
loader: "static.olark.com/jsclient/loader0.js",name:"olark",methods:["configure","extend","declare","identify"]});
/* custom configuration goes here (www.olark.com/documentation) */
olark.identify('5043-577-10-8758');/*]]>*/</script><noscript><a href="https://www.olark.com/site/5043-577-10-8758/contact" title="Contact us" target="_blank">Questions? Feedback?</a> powered by <a href="http://www.olark.com?welcome" title="Olark live chat software">Olark live chat software</a></noscript>
<!-- end olark code -->  
  
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
