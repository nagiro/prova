<?php use_helper('Form')?>

<style>

#submit { width:100px; }

</style>

    <TD colspan="3" class="CONTINGUT">
    

     <form action="<?php echo url_for('gestio/gNoticies') ?>" method="post" enctype="multipart/form-data">
	    <DIV class="REQUADRE">
	    <DIV class="TITOL">Notícies actives a portada</DIV>
	    	<table class="DADES">
	    	<?php           
                if(sizeof($NOTICIES) == 0 ) { echo '<TR><TD class="LINIA">No hi ha cap notícia activa.</TD></TR>'; }
                 									                           
                foreach($NOTICIES as $N):                                      
					echo '<TR>
							<TD width="10%" class="LINIA">'.checkbox_tag('NOTICIA[]',$N->getActivitatid(),false).'</TD>
							<TD class="LINIA">'.$N->getTnoticia().'</TD>							
						  </TR>';                		                 															
				endforeach;				
                ?>         
                <TR><TD><?=submit_tag('Desactiva',array('name'=>'BDESACTIVA','id'=>'submit'))?></TD><TD></TD></TR>       
	        </table>
	     </DIV>
     </form>                  

	</TD>