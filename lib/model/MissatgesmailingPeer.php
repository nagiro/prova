<?php

class MissatgesmailingPeer extends BaseMissatgesmailingPeer
{
    
    static public function getTemplate()
    {    
        $TEXT = '
        <table width="640px" style="font-family: sans-serif; font-size:14px; margin:0 auto; border:0px solid #B33330;">
            <tr><td align="center" style=" padding:20px;"><img width="200px" src="http://servidor.casadecultura.org/downloads/logos/CCG_BLANC.jpg" /></td></tr>
            <tr><td style="border-top:2px solid #B33330;padding: 20px; text-align: left;">    
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed convallis egestas nunc, nec pharetra justo sodales ac. Vivamus arcu libero, semper eu aliquet ac, fringilla nec metus. Aliquam tristique lobortis ligula nec tempus. Suspendisse potenti. Duis suscipit diam eget elit semper blandit. Fusce purus urna, semper et vehicula eget, luctus non sapien. Duis libero ante, tristique at posuere non, ornare non quam. Sed et ante eu ante vehicula vestibulum in sit amet eros. Sed rhoncus tortor ac orci molestie et ullamcorper neque semper. Praesent placerat commodo massa vitae fringilla.</p>
                <br /><br />             
                <p><span style="font-size:10px; font-style: italic; color: gray;">En cas de resposta afirmativa, les vostres dades seran incorporades a un fitxer titularitat de la Fundaci&oacute; Casa de Cultura creat sota la seva responsabilitat per a gestionar les activitats que s&rsquo;hi porten a terme i per a informar-ne a persones que hi estiguin interessades. La Casa de Cultura es compromet a complir els seus deures de mantenir reserva i d&rsquo;adoptar les mesures legalment previstes i les t&egrave;cnicament necess&agrave;ries per evitar-ne un acc&eacute;s o qualsevol classe de tractament no autoritzat. Podran ser cedides a altres persones amb les quals la Casa de Cultura col&bull;labora en la programaci&oacute; i organitzaci&oacute; d&rsquo;activitats, exclusivament a l&rsquo;efecte de fer-vos arribar la informaci&oacute; que vost&egrave; manifesta estar interessat en rebre. Per qualsevol altre cessi&oacute; requerir&iacute;em pr&egrave;viament el seu consentiment. En qualsevol cas podeu exercir els vostres drets d&rsquo;acc&eacute;s, rectificaci&oacute; i cancel&bull;laci&oacute; tot adre&ccedil;ant-se a: Sr/a. Director/a de la Casa de Cultura, Pla&ccedil;a de l&rsquo;Hospital 6, 17002 GIRONA, tel&egrave;fon 972 202 013 i correu electr&ograve;nic  secretaria@casadecultura.org.</span></p>
            </td></tr>
        </table>';
        
        return $TEXT;
    }
    
	static public function getMissatges( $idL = 0 , $pagina = 1 )
	{
		
		$C = new Criteria();
        if( $idL > 0 ):
            $C->addJoin(self::IDMISSATGE,MissatgesLlistesPeer::IDMISSATGESLLISTES);
            $C->add(MissatgesllistesPeer::LLISTES_IDLLISTES, $idL);
        endif; 
		$C->addDescendingOrderByColumn(self::IDMISSATGE);
		
		$pager = new sfPropelPager('Missatgesmailing', 20);
	    $pager->setCriteria($C);
	    $pager->setPage($pagina);
	    $pager->init();
	    return $pager;
		
	}
				

    static public function initialize($idM)
    {        
        $OMissatge = self::retrieveByPK($idM);
                
        if(!($OMissatge instanceof Missatgesmailing)):
            $OMissatge = new Missatgesmailing();                	                	
        	$OMissatge->setText(self::getTemplate());
            $OMissatge->setDataAlta(date('Y-m-d',time()));                                                
    	endif;
        
        return new MissatgesmailingForm($OMissatge);
    }                
                
}
