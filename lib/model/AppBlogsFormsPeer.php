<?php

class AppBlogsFormsPeer extends BaseAppBlogsFormsPeer
{
	
	static public function getOptionsForms( $blog_id , $form_id )
	{

		$C = new Criteria();
		$C->add(self::BLOG_ID, $blog_id);
						
		$Q = self::doSelect($C);				
		$RET = '<option value="-1">('.sizeof($Q).') Escull un formulari...</option>';
		foreach($Q as $OO):
			$SEL = ($OO->getId() == $form_id)?'SELECTED':'';
			$RET .= '<option '.$SEL.' value="'.$OO->getId().'">'.$OO->getName().'</option>';			
		endforeach;
		
		return $RET;		
		
	}
	
	static public function save($form_id,$dades,$arxius)
	{
		
		try{
			
			$OO = AppBlogsFormsPeer::retrieveByPK($form_id);
			$OO2 = new AppBlogsFormsEntries();	  		
	  		$OO2->setDate(date('Y-m-d H:i:s',time()));
	  		$OO2->setFormId($OO->getId());
	  		$OO2->save();
	  	  		
	  		$RET = array();
	  		foreach($dades as $K=>$V):
	  			$RET[$K] = $V;
	  		endforeach;
	  		
	  		if(isset($arxius['arxius'])):
	  		foreach($arxius['arxius'] as $K=>$V):  		
	  			if($V['error'] == 0):
	  				$file_ext = substr($V['name'], strripos($V['name'], '.'));
	  				$file_name = $OO2->getId().'-'.$K.$file_ext;
	  				$url = sfConfig::get('sf_websysroot').'uploads/formularis/'.$file_name;
	  				move_uploaded_file($V['tmp_name'], $url);	  				 
	  				$RET['file'][] = $file_name;
	  			endif; 
	  		
	  		endforeach;
	  		endif;
	  		
	  		$SOL = "@@@";
	  		foreach($RET as $K=>$V):
				
	  			if($K == 'file'):
	  				foreach($V as $V2):
	  					$SOL .= 'file###'.$V2.'@@@';
	  				endforeach;
	  			else:	
	  				$SOL .= $K."###".$V.'@@@';
	  			endif;
	  				
	  		endforeach;	  						  			  						
	  		$OO2->setDades($SOL);
	  		$OO2->save();
	  		
		} catch(Exception $e){ echo $e->getMessage(); return false; }
				
		return true;		
	}
	
	static public function getForms( $blog_id , $num )
	{
		$C = new Criteria();
		$C->add(self::BLOG_ID,$blog_id);
		$OO = self::doSelect($C);
		if($OO instanceof AppBlogsForms):
			if(isset($OO[$num])) return $num;
			else return new AppBlogsForms();
		else: 
			return new AppBlogsForms();  
		endif;
		 
		return self::doSelect($C);
	}
	
	
}
