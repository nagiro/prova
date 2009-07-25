<style>

#submit { width:100px; }

</style>

    <TD colspan="3" class="CONTINGUT">
    
      <?php echo nice_form_tag('gestio/gNoticies',array('method'=>'post')); ?>

      <TABLE class="BOX">
        <TR><TD class="NOTICIA">                
                <DIV class="TITOL">Llistat de notícies al web principal actives</DIV>
                <TABLE class="DADES">
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
                </TABLE>                                                                  
            </TD>
        </TR>
      </TABLE>