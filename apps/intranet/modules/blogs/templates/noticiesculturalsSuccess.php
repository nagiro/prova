<?php use_javascript('fonts/cufon-yui.js')?>
<?php use_javascript('fonts/myriad/Myriad_Pro_400.font.js')?>
<?php use_javascript('fonts/bauhaus/Bauhaus_93_400.font')?>

<script type="text/javascript">
	Cufon.replace('.col_content .title', { fontFamily: 'Bauhaus 93' });
	Cufon.replace('.col_content .subtitle', { fontFamily: 'Myriad Pro' });
	Cufon.replace('.col_content .subtitle2', { fontFamily: 'Myriad Pro' });
	Cufon.replace('.col_footer .footer', { fontFamily: 'Myriad Pro' });
	Cufon.replace('.col_footer .tags', { fontFamily: 'Bauhaus 93' });	
	Cufon.replace('.more', { fontFamily: 'Bauhaus 93' });
	
	// preload images first (can run before page is fully loaded)
    $(document).ready(function() {
		$(".rollover").hover(
				function() { this.src = this.src.replace("_A","_B"); },
				function() { this.src = this.src.replace("_B","_A"); }
			);
	 });
	
</script>



<style>
	table.principal { width:1024px; border:0px solid black; margin-top:20px; }
	a { color: #E95D0F; text-decoration:none; }
	.main_title { height:200px; }
	.left-col { width:162px; }
	.right-col { width:850px; }
	.content { background-color: #FFFFFF; text-align:left; vertical-align:top; }
	.col_white { width:70px; }
	.col_content { width: 190px; }
	.col_content .title { font-size:26px; color:#162983; }
	.col_content .image { width:70px; margin-right:8px; margin-bottom:5px;}
	.col_content .subtitle { font-size:14px; color:#162983;  }
	.col_content .subtitle2 { font-size:14px; color:#006AB2;  }
	.col_content .text { margin-top:15px; margin-bottom:15px; font-size:12px; color:black; text-align:left; }
	.col_content { height: 180px; }
	.col_footer { height: 50px; }	
	.col_footer .footer { color: #E95D0F; font-size:14px; text-align:right; }		
	.col_footer .tags { color: #E95D0F; font-size:16px; font-weight:bold; text-align:right; }	
	.row_sep { height: 25px; }	
	table.list { width:100%; }
	.more { color:#162983; font-size:21px; }
	.more a { color:#162983; font-size:21px; text-decoration:none; }
	.more a:hover { color: #5063BA; }
	.image_gran { width:200px; margin-right:20px; margin-bottom:15px; }
	.right { text-align:right; padding-right:100px; }	
	
</style>
<center>
<table class="principal">
<tr>
	<td class="left-col main_title"><?php echo image_tag('blogs/Dissenys/noticies_culturals/blog_02.png')?></td>
	<td class="right-col main_title"><?php echo image_tag('blogs/Dissenys/noticies_culturals/blog_03.png')?></td>
</tr>
<tr>
	<td class="left-col">
		<a href="<?php echo url_for('blogs/noticiesculturals?PAGE_ID='.$PAGE_ID_QUE_ESTA_PASSANT) ?>"><?php echo image_tag('blogs/Dissenys/noticies_culturals/B1_A.png',array('class'=>'rollover','alt'=>'Què està passant?'))?></a><br />
		<a href="<?php echo url_for('blogs/noticiesculturals?PAGE_ID='.$PAGE_ID_QUE_PASSARA) ?>"><?php echo image_tag('blogs/Dissenys/noticies_culturals/B2_A.png',array('class'=>'rollover','alt'=>'Què passarà?'))?></a><br />
		<a href="<?php echo url_for('blogs/noticiesculturals?PAGE_ID='.$PAGE_ID_QUE_HA_PASSAT) ?>"><?php echo image_tag('blogs/Dissenys/noticies_culturals/B3_A.png',array('class'=>'rollover','alt'=>'Què ha passat?'))?></a><br />			
	</td>
	<td class="right-col content">		
		<?php if(isset($NOTICIA)): printEntry($NOTICIA); else: printEntries($NOTICIES); endif; ?>
	</td>
</tr>
<tr>
	<td colspan="2" class="right-col"><?php echo image_tag('blogs/Dissenys/noticies_culturals/blog_12.png')?></td>
</tr>
</tr>
</table>	
</center>

<?php 

	function printEntry($NOTICIA)
	{
		
		$OOM = $NOTICIA->getAppBlogMultimediaEntriessJoinAppBlogsMultimedia(new Criteria());						
		if(isset($OOM[0])):
			$OOM = $OOM[0]->getAppBlogsMultimedia();
			$img = '<img class="image_gran" align="LEFT" src="'.sfConfig::get('sf_webroot').'images/blogs/'.$OOM->getUrl().'" alt="'.$OOM->getDesc().'" />';
			$text2 = $NOTICIA->getBody();				
			$text = $img.$text2;
		else:
			$text2 = $NOTICIA->getBody(); 
			$text = $text2;					
		endif; 
		
		echo '<table><tr><td>';	
		echo $text;
		echo '</td></tr>';
		echo '<tr><td class="more right"><a href="'.url_for('blogs/noticiesculturals').'">Tornar</a></td></tr>';
		echo '</table>';
		
	}
	
	
	function printEntries($PAGES)
	{

		$RET = array();
		
		foreach($PAGES->getResults() as $OO):
						
			$OOM = $OO->getAppBlogMultimediaEntriessJoinAppBlogsMultimedia(new Criteria());						
			if(isset($OOM[0])):
				$OOM = $OOM[0]->getAppBlogsMultimedia();
				$img = '<img class="image" align="LEFT" src="'.sfConfig::get('sf_webroot').'images/blogs/'.$OOM->getUrl().'" alt="'.$OOM->getDesc().'" />';
				$text2 = substr($OO->getBody(),0,150);				
				$text = $img.$text2.'...';
			else:
				$text2 = substr($OO->getBody(),0,200); 
				$text = $text2.'...';					
			endif; 
						
			$RET[] = fillCell($OO,$text);
															
		endforeach;
						
		for($l = sizeof($RET); $l < 6; $l++):
			$RET[] = fillCell(null,null,true);
		endfor;
		
		$WHITE[0] = '<td class="col_white" rowspan="2">&nbsp;</td>';		
		
		echo '<center>';
		echo '<table class="list">';
		echo '<tr><td style="row_sep" colspan="7">&nbsp;</td></tr>';				
		for($j = 0; $j < 2; $j++):
			for($k=0; $k < 2; $k++):				
				echo '<tr class="col_white" rowspan="3">';				
				for($i = 0; $i < 3 ; $i++):
					if($k==0) echo $WHITE[0]; //Només el 0 perquè tenim un rowspan				
					if(isset($RET[($j*3)+$i])) echo $RET[($j*3)+$i][$k];
				endfor;
				if($k==0) echo $WHITE[0]; //Només el 0 perquè tenim un rowspan				
				echo '</tr>';				
			endfor;						
			echo '</tr><tr><td style="row_sep" colspan="7">&nbsp;</td></tr>'; 			
		endfor;
		if($PAGES->haveToPaginate() && $PAGES->getPage() != $PAGES->getLastPage()):								
			echo '</tr><tr><td style="row_sep" colspan="5">&nbsp;</td>
						<td class="more"><a href="'.url_for('blogs/noticiesculturals?PAGINA='.$PAGES->getNextPage()).'">veure\'n més</a></td>
						<td>&nbsp;</td>
						</tr>';
		endif;
		echo '</tr><tr><td style="row_sep" colspan="7">&nbsp;</td></tr>';
		echo '</table>';
		echo '</center>';
						
	}
	
	
	function fillCell($OO,$text,$blank = false)
	{
						
		$RET = array();
		if(!$blank):						 	
			$RET[0]  = '<td class="col_content">';
			$RET[0] .= '<div class="title">'.$OO->getTitle().'</div>';
			$RET[0] .= '<div class="subtitle">'.$OO->getSubtitle1().'</div>';
			$RET[0] .= '<div class="subtitle2">'.$OO->getSubtitle2().'</div>';						
			$RET[0] .= '<div class="text">'.$text.'</div></td>';
			
			$RET[1]  = '<td class="col_footer"><div class="footer"><a href="'.url_for('blogs/noticiesculturals?NOTICIA_ID='.$OO->getId()).'">+ llegir tota la notícia</a></div>';
			$url = $OO->getUrl();
			if(!empty($url)) $RET[1] .= '<div class="footer"><a href="'.$url.'">entrar al web</a></div>';
			$RET[1] .= '<div class="footer tags">'.$OO->getTags().'</div>';
			$RET[1] .= '</td>';
		else: 
			$RET[0] = '<td class="col_content">&nbsp;</td>';
			$RET[1] = '<td class="col_footer">&nbsp;</td>';			
		endif; 
		
		return $RET;
	}

?>