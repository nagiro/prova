<style>
.LEGEND_CONTACTE { font-size:12px; font-weight:bold; padding:10px 10px 10px 10px; }
FIELDSET { border:2px solid #CCCCCC; padding:10px; margin-right:40px; }
.TITOL_CATEGORIA { background-color: #FFF4F4; color:black; font-weight:bold; padding:5px; }
.TOP   { vertical-align:top;}
input.CONTACTE { border:1px solid #CCCCCC; }
TEXTAREA.CONTACTE { border: 1px solid #CCCCCC; }
.ENVIAT { font-size: 12px; padding-left:10px; padding-bottom: 10px; }
</style>

<TD colspan="3" class="CONTINGUT">

<? if(!$ENVIAT): ?>
   <?=form_tag('web/enviaContacte',array('method'=>'POST')) ?>

   <FIELDSET><LEGEND class="LEGEND LEGEND_CONTACTE">Contacta'ns</LEGEND>   
    <TABLE class="DADES">
    <TR> <TD class="TITOL TOP">Nom</TD>     				<TD><?=input_tag('NOM' , null , array('class'=>'CONTACTE'));?></TD> </TR>
    <TR>	<TD class="TITOL TOP">Cognoms</TD> 				<TD><?=input_tag('COGNOMS' , null , array('class'=>'CONTACTE'));?></TD> </TR>
    <TR>	<TD class="TITOL TOP">Telèfon</TD> 				<TD><?=input_tag('TELEFON' , null , array('class'=>'CONTACTE'));?></TD> </TR>
    <TR>	<TD class="TITOL TOP">Correu electrònic</TD> 	<TD><?=input_tag('EMAIL' , null , array('class'=>'CONTACTE'));?></TD> </TR>
    <TR>	<TD class="TITOL TOP">Què ens vols dir?</TD> 	<TD><?=textarea_tag('COMENTARI' , null , array('size'=>'40x5','class'=>'CONTACTE'));?></TD> </TR>  	   
	<TR>	<TD class="TITOL TOP"></TD> 					<TD><BR /><?=submit_tag('Envia missatge');?></TD> </TR>
	</TABLE>
   </FIELDSET>

   <? else: ?>
   
   <FIELDSET><LEGEND class="LEGEND LEGEND_CONTACTE">Contacta'ns</LEGEND>   
    <div class="ENVIAT"> Missatge enviat correctament. Segueix <?=link_to('navegant.','web/index') ?></div>    
   </FIELDSET>
   
   <? endif; ?>
   
   <DIV STYLE="height:40px;"></DIV>
   
</TD>