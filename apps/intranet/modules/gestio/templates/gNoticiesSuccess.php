<?php use_helper('Form')?>

<style>

#submit { width:100px; }

</style>

    <TD colspan="3" class="CONTINGUT">
    
	<?php include_partial('breadcumb',array('text'=>'NOTÍCIES')); ?>

<?php if($MODE == 'FORMULARI'): ?>
		
		<form action="<?php echo url_for('gestio/gNoticies') ?>" method="POST" enctype="multipart/form-data">
		    <DIV class="REQUADRE">	    
		    <?php include_partial('botonera',array('tipus'=>'Tancar','url'=>'gestio/gNoticies?accio=C'))?>
		    	<table class="FORMULARI">
		    		<tr><td width="100px"></td><td></td></tr>	    			    		        
		            <?php echo $FORMULARI ?>	            
		            <tr>		            	
		            	<td colspan="2" class="dreta">
							<?php include_partial('botonera',array('element'=>'la notícia')); ?>		            	
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
                else { echo '<tr><td class="TITOL"></td><td class="TITOL">Títular</td><td class="TITOL">Data publicació</td><td class="TITOL">Data desaparició</td><tr>'; }
                 								                           
                foreach($NOTICIES->getResults() as $N):                                      
					echo '<TR>
							<TD width="10%" class="LINIA">'.radiobutton_tag('NOTICIA',$N->getIdnoticia(),false).'</TD>
							<TD class="LINIA">'.$N->getTitolnoticia().'</TD>
							<TD class="LINIA">'.$N->getDatapublicacio().'</TD>							
							<TD class="LINIA">'.$N->getDatadesaparicio().'</TD>
						  </TR>';                		                 															
				endforeach;				
                ?>         
                <TR>
                	<TD colspan="1"></TD>
                	<TD colspan="3">
                		<button name="BADD">Nova notícia</button>
                		<button name="BEDIT">Edita notícia</button>                		                		
                	</TD>
                	
                </TR>
                <TR><TD colspan="4"><?php echo gestorPagines($NOTICIES);?></TD></TR>       
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