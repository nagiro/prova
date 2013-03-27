<?php $base = '/'; ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Casa de Cultura de Girona</title>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800,300' rel='stylesheet' type='text/css'>
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>

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

#marc { margin:00px auto; width:1024px; background-color:white; overflow:hidden; }
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
.requadre_no_imatge_more { border-top:1px solid gray; font-size:12px; padding:10px; cursor:pointer; background-color: #D0C8BA; }

.menu_titol_llarg { width:610px; height:24px; color:white; background-color: #817D74; margin-bottom:10px; }
.menu_titol_llarg > div { padding-top:3px; margin-left:5px; font-size:15px; font-weight: bolder;  }
.fila { margin-bottom:20px; overflow: hidden; }
.fila_imatge { width:295px; height:295px; background-color:white; float:left; position:relative;  }
.fila_imatge_text { position: absolute; bottom:0px; opacity: 0.5; filter: alpha(opacity = 50); background-color: black; color:white; font-size:12px; padding:10px; min-width: 275px; }
.fila_imatge_mig { width:295px; height:124px; background-color:white; float:left; position: relative; }

.fila_imatge:hover { opacity:0.7; cursor:pointer; filter: alpha(opacity = 70); }
.fila_imatge_mig:hover { opacity:0.7; cursor:pointer; filter: alpha(opacity = 70); }

.menu_titol { width:300px; height:24px; color:white; background-color: #817D74; margin-top:10px; margin-left:10px; margin-bottom:10px;  }
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

    function mostra(id){
        $('#mostra_' + id).show();
        $('#amaga_'  + id).hide();                
    }

    $(document).ready(function(){
        $('#logo').click(function(){ segueix_url('<?php echo url_for('@web_home') ?>') })        
    });


</script>

</head>

<body>
    
    <div style="position:relative; height: 50px; background-color:#000000;">
        <div><img style="position:absolute; right:60px;" src="/images/front/LogoDiputacioSuperior.png" /></div></div>
    
    <?php echo $sf_content ?>
     
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-11029946-1");
pageTracker._trackPageview();
} catch(err) {}</script>  

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