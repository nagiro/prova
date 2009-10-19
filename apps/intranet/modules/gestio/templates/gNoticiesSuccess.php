<?php use_helper('Form')?>

<style>

#submit { width:100px; }

</style>

    <TD colspan="3" class="CONTINGUT">
    

<?php if($MODE == 'FORMULARI'): ?>
		
		<form action="<?php echo url_for('gestio/gNoticies') ?>" method="POST" enctype="multipart/form-data">
		    <DIV class="REQUADRE">	    
		    	<table class="FORMULARI">
		    		<tr><td width="100px"></td><td></td></tr>	    			    		        
		            <?php echo $FORMULARI ?>	            
		            <tr>
		            	<td colspan="2" class="dreta">
		            		<br>	            	
		            			<?php echo submit_image_tag('icons/Colored/PNG/action_check.png',array('value'=>'SAVE','name'=>'BSUBMIT'))?>
		            			<?php echo link_to(image_tag('icons/Colored/PNG/action_delete.png'),'gestio/gNoticies',array('name'=>'BDELETE','confirm'=>'Segur que vols esborrar-lo?'))?>	            		
		            	</td>
		            </tr>
		        </table>
		     </DIV>
	     </form>		

<?php else: ?>

     <form action="<?php echo url_for('gestio/gNoticies') ?>" method="post" enctype="multipart/form-data">
	    <DIV class="REQUADRE">
	    <DIV class="TITOL">Notícies actives a portada</DIV>
	    	<table class="DADES">
	    	<?php           
                if(sizeof($NOTICIES) == 0 ) { echo '<TR><TD class="LINIA">No hi ha cap notícia activa.</TD></TR>'; }
                 									                           
                foreach($NOTICIES->getResults() as $N):                                      
					echo '<TR>
							<TD width="10%" class="LINIA">'.radiobutton_tag('NOTICIA[]',$N->getIdnoticia(),false).'</TD>
							<TD class="LINIA">'.$N->getTitolnoticia().'</TD>							
						  </TR>';                		                 															
				endforeach;				
                ?>         
                <TR><TD><?php echo submit_tag('Nova',array('name'=>'BADD'))?>
                		<?php echo submit_tag('Edita',array('name'=>'BEDIT'))?>                		
                	</TD>
                	<TD colspan="2"></TD>
                </TR>
                <TR><TD colspan="3" class="TITOL"><?php echo gestorPagines($NOTICIES);?></TD></TR>       
	        </table>
	     </DIV>
     </form>                  

	</TD>
	
<?php endif; ?>
	
	
<?php 
	
	function ParImpar($i)
	{
		if($i % 2 == 0) return "PAR";
		else return "IPAR";
	}
	
	
	function gestorPagines($O)
	{
	  if($O->haveToPaginate())
	  {       
	     echo link_to(image_tag('tango/16x16/actions/go-previous.png'), 'gestio/gNoticies?PAGINA='.$O->getPreviousPage());
	     echo " ";
	     echo link_to(image_tag('tango/16x16/actions/go-next.png'), 'gestio/gNoticies?PAGINA='.$O->getNextPage());
	  }
	}
	
?>