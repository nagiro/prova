<?php

/**
 * w actions.
 *
 * @package    intranet
 * @subpackage w
 * @author     Albert Johé
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class wActions extends sfActions
{
    
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {

     $this->setLayout('web');
     $accio = $request->getParameter('accio','home');
     $this->IDS = 1;
     $this->PAGE = $request->getParameter('page',1);

     // Definim el captcha
     $val1 = rand(0,9); $val2 = rand(0,9);
     $this->getUser()->setAttribute('CAPTCHA1', $val1 );
     $this->getUser()->setAttribute('CAPTCHA2', $val2 );     
     $this->CAPTCHA = "i la suma de ".$val1." + ".$val2;
     $this->SELECCIONAT = "CAP";               
     
     switch($accio){
        //Cliquem del menú esquerra, i mostrem els submenús a la dreta. Si no hi ha submenús, mostrem el home
        case 'menu_click':
                $this->A_LLISTA = array();
                $ON = NodesPeer::retrieveByPK($request->getParameter('node'));
                if($ON instanceof Nodes):                
                    $AON = NodesPeer::getFillsNextLevel($ON);
                    $this->SELECCIONAT = array_pop($ON->getArbre());                    
                                                             
                    switch($ON->getCategories()){
                        
                        //Si la categoria del node és manual
                        case NodesPeer::CATEGORIA_MANUAL:
                            
                                //Mirem si conté subdirectoris... o bé és de contingut.
                                if( !empty( $AON ) ):
                                                                                     
                                    $this->A_LLISTA[1]['mode'] = 1;
                                    $this->A_LLISTA[1]['titol'] = "Categories dins aquest menú";
                                    foreach($AON as $ON):
                                    
                                        //Mirem si la imatge existeix                                        
                                        $img = ($this->Image_exists('front',$ON->getIdnodes().'-L'))?'/images/front/'.$ON->getIdnodes().'-L.jpg':'color';                                        
                                        $this->A_LLISTA[1]['elements'][] = array(
                                            'url' => '@web_menu_click?node='.$ON->getIdnodes().'&titol='.$ON->getNomForUrl() ,
                                            'titol' => $ON->getTitolmenu() , 
                                            'img' => $img );                            
                                    endforeach;                        
                                    $this->mode = 'llista';
                                
                                //No té cap més subdirectori, carreguem els continguts
                                else: 
                                                                
                                    //Si el contingut és html, l'interpretem, altrament el mostrem tal com està.
                                    if( $ON->getIsphp() ):
                                        $this->CONTINGUT = $ON->getHtml();
                                        $this->IMG = ($this->Image_exists('front',$ON->getIdnodes().'-XL'))?'/images/front/'.$ON->getIdnodes().'-XL.jpg':'';                                        
                                        $this->mode = 'detall';
                                    else: 
                                        $this->CONTINGUT = $ON->getHtml();                                                                                                                        
                                        $this->IMG = ($this->Image_exists('front',$ON->getIdnodes().'-XL'))?'/images/front/'.$ON->getIdnodes().'-XL.jpg':'';
                                        $this->mode = 'detall';  
                                    endif; 
                                    
                                endif;  
                                                                                        
                            break;
                            
                        //Si el node és d'exposicions, mostrem un llistat amb les exposicions
                        case NodesPeer::CATEGORIA_EXPOSICIONS:
                        
                                //Carreguem les exposicions actuals ( Sala Fita i Sala d'exposicions ) i les futures, si hi són.                                                                
                                $this->A_LLISTA = $this->CarregaInfoExposicions( );
                                $this->mode = 'llista';
                                                                                        
                            break;

                        case NodesPeer::CATEGORIA_ACTIVITATS_NORMALS:
                        
                                $this->A_LLISTA = $this->CarregaInfoActivitats();                                
                                $this->mode = 'llista';
                                                
                            break;                            

                        case NodesPeer::CATEGORIA_CURSOS:
                        
                                $this->A_LLISTA = $this->CarregaInfoCursos( $this->IDS , 0 );                                                                                                                                                                         
                                $this->mode = 'llista';
                        
                            break;                       
                            
                        case NodesPeer::CATEGORIA_GIROSCOPI:
                            break;                                 
                        
                    }                                                                                                                             
                    
                else: 
                    $this->mode = 'home';
                endif;
            break;
            
        //Quan cliquem l'enllaç d'un curs, mostrem el seu contingut.
        case 'menu_click_cursos':
        
                $this->SELECCIONAT = NodesPeer::retrieveByPK(62);
                
                $idC = $request->getParameter('idCurs');
                //Si no hem seleccionat el curs, mostrem els cursos dins una categoria
                if($idC == 0):
                
                    $this->A_LLISTA = $this->CarregaInfoCursos( $this->IDS , $request->getParameter('idCategoria') );
                    $this->mode = 'llista';
                    
                //Hem entrat clicant un curs, mostrem el detall del curs
                else:
                 
                    $OC = CursosPeer::retrieveByPK( $idC );
                    if( $OC instanceof Cursos ):                
                        $this->CONTINGUT = $OC->getDescripcio();
                        $this->HORARIS = $OC->getHoraris();
                        $this->TITOL = $OC->getTitolcurs();                        
                        $this->IMG = ($this->Image_exists('cursos','C-'.$OC->getIdcursos().'-L'))?'/images/cursos/C-'.$OC->getIdcursos().'-L.jpg':'';
                        $this->mode = "detall";
                    else: 
                        $this->mode = "home";
                    endif;
                    
                endif; 
                                 
            break;

        //Quan cliquem l'enllaç d'una activitat mostrem el contingut
        case 'menu_click_activitats':
                                        
                $idA = $request->getParameter('idActivitat');                                
                                                 
                $OA = ActivitatsPeer::retrieveByPK( $idA );
                if( $OA instanceof Activitats ):
             
                    $this->SELECCIONAT = NodesPeer::retrieveByPK( ( substr_count( $OA->getCategories() , '46' ) > 0 )?58:61 );

                    $OC = CiclesPeer::retrieveByPK($OA->getCiclesCicleid());                    
                                    
                    $this->CONTINGUT = $OA->getDMig();
                    $this->HORARIS = $OA->getHorariss();
                    $this->TITOL = $OA->getTMig();
                    $this->IMG = ($this->Image_exists('activitats','A-'.$OA->getActivitatid().'-L'))?'/images/activitats/A-'.$OA->getActivitatid().'-L.jpg':'';
                    $this->INFO_PRACTICA = $OA->getInfopractica();
                    $this->A_LLISTA = $this->CarregaInfoCategories( 
                                                            null, 
                                                            ($OC instanceof Cicles)?'Altres activitats de: '.$OC->getTMig():'Altres activitats del cicle', 
                                                            $OA->getCiclesCicleid() ,
                                                            3 );                     
                    $this->mode = "detall";
                else: 
                    $this->mode = "home";
                endif;
                                                                              
            break;
            
        //Quan cliquem l'enllaç d'un curs, mostrem el seu contingut.
        case 'menu_click_noticies':
        
                $this->SELECCIONAT = NodesPeer::retrieveByPK(60);
        
                $idN = $request->getParameter('idNoticia',0);
                //Si no hem escollit una notícia, mostrem les notícies
                if($idN == 0):
                
                    $this->A_LLISTA = $this->CarregaInfoNoticies(  );
                    $this->mode = 'llista';
                    
                //Hem entrat clicant un curs, mostrem el detall del curs
                else:
                 
                    $ON = NoticiesPeer::retrieveByPK( $idN );
                    if( $ON instanceof Noticies ):              
                        $this->CONTINGUT = $ON->getTextnoticia();
                        $this->HORARIS = "";
                        $this->TITOL = $ON->getTitolnoticia();                        
                        $this->IMG = ($this->Image_exists('noticies','N-'.$ON->getIdnoticia().'-XL'))?'/images/noticies/N-'.$ON->getIdnoticia().'-XL.jpg':'';
                        $this->mode = "detall";
                    else: 
                        $this->mode = "home";
                    endif;
                    
                endif; 
                                 
            break;

            
        default: 
                $this->mode = 'home';
            break;
     }
          
     $this->A_MENU = NodesPeer::retornaMenu(99,false);    
     $avui = date('Y-m-d',time());
     $this->A_ACTIVITATS_AVUI = ActivitatsPeer::getActivitatsDia( $this->IDS , $avui , $this->PAGE , 'activitats' );     
     $this->A_ACTIVITATS_FUTURES = ActivitatsPeer::getActivitatsProperes( $this->IDS , $avui , $this->PAGE ,  'horari' , 100 ); 
     
  }  
  

  /**
   * Quan carrego una pàgina de categoria, carrego també la llista corresponent.        
   * */
  private function CarregaInfoExposicions( )
  {
    
    $RET = array();        
    $A_OA_PAGER = ActivitatsPeer::getCategoriaActivitat( 46 , $this->IDS );
            
    $RET[1]['mode'] = 1; $RET[2]['mode'] = 2;
    $RET[1]['titol'] = "Exposicions actuals"; $RET[2]['titol'] = "Exposicions futures";
    //Agafem les exposicions que tenen la data igual al dia d'avui. Les altres, les posem com exposicions properes 
    foreach($A_OA_PAGER->getResults() as $OA):        
                
        $primer = $OA->getPrimerHorari(); $ultim = $OA->getUltimHorari(); $avui = date('U',time());
        $titol = $OA->getTMig().' | Del '.$primer->getDia('d/m').' al '.$ultim->getDia('d/m');
        
        //Si la expo és acutal, ho posem al primer , sinó al segon.
        if( $avui < $ultim->getDia('U') && $primer->getDia('U') < $avui ): 
            $i = 1;            
            $img = ($this->Image_exists('activitats','C-'.$OA->getActivitatid().'-L'))?'/images/activitats/C-'.$OA->getActivitatid().'-L.jpg':'color'; 
        else: 
            $i = 2;             
            $img = ($this->Image_exists('activitats','C-'.$OA->getActivitatid().'-M'))?'/images/activitats/C-'.$OA->getActivitatid().'-M.jpg':'color';
        endif;            
                
        $RET[$i]['elements'][] = array(                                        
                                        'url' => '@web_menu_click_activitat?idCicle='.$OA->getCiclesCicleid().'&idActivitat='.$OA->getActivitatid().'&titol='.$OA->getNomForUrl() ,
                                        'titol' => $titol , 
                                        'img' => $img );                                            
    endforeach;
    
    return $RET;                        
                                        
  }


  /**
   * Quan carrego una pàgina de categoria, carrego també la llista corresponent.        
   * */
  private function CarregaInfoNoticies(  )
  {
    
    $RET = array();            
    $A_ON_PAGER = NoticiesPeer::getNoticies( "" , 1 , true , false , $this->IDS );
            
    $RET[1]['mode'] = 2;
    $RET[1]['titol'] = "Actualitat a la Casa de Cultura";    
    foreach($A_ON_PAGER->getResults() as $ON):                                
        //Mirem si la imatge existeix
        $img = ($this->Image_exists('noticies','N-'.$ON->getIdnoticia().'-M'))?'/images/noticies/N-'.$ON->getIdNoticia().'-M.jpg':'color';
        $RET[1]['elements'][] = array(                                        
                                        'url' => '@web_menu_click_noticies?idNoticia='.$ON->getIdnoticia().'&titol='.$ON->getNomForUrl() ,
                                        'titol' => $ON->getTitolnoticia() , 
                                        'img' => $img );                            
    endforeach;
    
    return $RET;                        
                                        
  }


  /**
   * Quan carrego una pàgina de categoria, carrego també la llista corresponent.        
   * */
  private function CarregaInfoCategories( $CATEGORIA , $TITOL , $idCicle = null , $TIPUS = 2)
  {
    
    $RET = array();
    $A_OA_PAGER = null;    
    //Si el cicle és null o bé és igual a 1 ( no pertany a cap cicle )
    if(is_null($idCicle)) $A_OA_PAGER = ActivitatsPeer::getCategoriaActivitat( $CATEGORIA , $this->IDS );
    elseif( $idCicle == 1 ) $A_OA_PAGER = ActivitatsPeer::getCategoriaActivitat( ' ' , $this->IDS );
    else $A_OA_PAGER = ActivitatsPeer::getActivitatsCicles( $idCicle , 1 , true );
    
    $RET[1]['mode'] = $TIPUS;
    $RET[1]['titol'] = $TITOL;
    foreach($A_OA_PAGER->getResults() as $OA):
        //Busco el primer i l'últim dia de l'expo, i llavors ho mostro                                                                        
        $A_OH = $OA->getHorariss();
        $primer = null; $ultim = null;
        foreach($A_OH as $OH):
            if( is_null( $primer) ) $primer = $OH;
            $ultim = $OH;
        endforeach;
        if($primer->getDia() == $ultim->getDia()):
            $titol = $OA->getTMig().' | El '.$primer->getDia('d/m').' a les '.$primer->getHorainici('H:i');
        else: 
            $titol = $OA->getTMig().' | Del '.$primer->getDia('d/m').' al '.$ultim->getDia('d/m');
        endif; 
        
        //Mirem si la imatge existeix
        $img = ($this->Image_exists('activitats','C-'.$OA->getActivitatid().'-M'))?'/images/activitats/C-'.$OA->getActivitatid().'-M.jpg':'color';                                
        $RET[1]['elements'][] = array(                                        
                                        'url' => '@web_menu_click_activitat?idCicle='.$OA->getCiclesCicleid().'&idActivitat='.$OA->getActivitatid().'&titol='.$OA->getNomForUrl() ,
                                        'titol' => $titol , 
                                        'img' => $img );                            
    endforeach;
    
    return $RET;                        
                                        
  }

  /**
   * Carrego les activitats amb l'ordre que a mi m'interessa.         
   * */
  private function CarregaInfoActivitats(  )
  {
    
    $RET = array();    
    
    //Quinzena 
    $avui_text = date('d/m',time());
    $ultim_dia_text = date( 'd/m' , mktime( 0 , 0 , 0 , date( 'm' , time() ) , date( 'd' , time() ) + 15 , date( 'Y' , time() ) ) );
    $ultim_dia = date( 'Y-m-d' , mktime( 0 , 0 , 0 , date( 'm' , time() ) , date( 'd' , time() ) + 15 , date( 'Y' , time() ) ) );
    
    $RET[1]['mode'] = 1; $RET[1]['titol'] = "Activitats destacades fins al ".$ultim_dia_text; $RET[1]['elements'] = array();
    $RET[2]['mode'] = 2; $RET[2]['titol'] = ""; $RET[2]['elements'] = array();    
    $RET[3]['mode'] = 3; $RET[3]['titol'] = ""; $RET[3]['elements'] = array();
    
    $A_OA_PAGER = ActivitatsPeer::getActivitatsProperes( $this->IDS , date('Y-m-d',time()) , 1 , "activitat" , 50 , true );    
    
    //Mostro només la quinzena d'activitats...    
    foreach($A_OA_PAGER->getResults() as $OA):
                        
        //Carrego el títol i els horaris
        $primer = $OA->getPrimerHorari(); 
        
        //Si l'activitat correspòn a la quinzena, la mostrem
        if($primer->getDia() < $ultim_dia ):
        
            $ultim = $OA->getUltimHorari();        
            if( $primer->getDia() == $ultim->getDia() ): 
                $titol = $OA->getTMig().' | El '.$primer->getDia('d/m').' a les '.$primer->getHorainici('H:i');
            else: 
                $titol = $OA->getTMig().' | Del '.$primer->getDia('d/m').' al '.$ultim->getDia('d/m');
            endif;        
            
            $cat = $OA->getCategories();

            
            //Activitats destacades
            if( substr_count( $cat , 49 ) > 0 || substr_count( $cat , 52 ) >  0 ):
                    
                $img = ($this->Image_exists('activitats','A-'.$OA->getActivitatid().'-L'))?'/images/activitats/A-'.$OA->getActivitatid().'-L.jpg':'color';                                
                $RET[1]['elements'][] = array(
                                                'url' => '@web_menu_click_activitat?idCicle='.$OA->getCiclesCicleid().'&idActivitat='.$OA->getActivitatid().'&titol='.$OA->getNomForUrl() ,
                                                'titol' => $titol , 
                                                'img' => $img );
            
            //Activitats normals
            elseif( substr_count( $cat , 47 ) > 0 || substr_count( $cat , 53 ) >  0 ):
    
                $img = ($this->Image_exists('activitats','A-'.$OA->getActivitatid().'-M'))?'/images/activitats/A-'.$OA->getActivitatid().'-M.jpg':'color';                                
                $RET[2]['elements'][] = array(
                                                'url' => '@web_menu_click_activitat?idCicle='.$OA->getCiclesCicleid().'&idActivitat='.$OA->getActivitatid().'&titol='.$OA->getNomForUrl() ,
                                                'titol' => $titol , 
                                                'img' => $img );
                    
            //Activitats acollides
            elseif( substr_count( $cat , 50 ) > 0  || substr_count( $cat , 54 ) >  0 ):
    
                //$img = ($this->Image_exists('activitats','C-'.$OA->getActivitatid().'-M'))?'/images/activitats/C-'.$OA->getActivitatid().'-M.jpg':'color';
                $img = "";                                
                $RET[3]['elements'][] = array(
                                                'url' => '@web_menu_click_activitat?idCicle='.$OA->getCiclesCicleid().'&idActivitat='.$OA->getActivitatid().'&titol='.$OA->getNomForUrl() ,
                                                'titol' => $titol , 
                                                'img' => $img );
    
            endif;
             
        endif;
                                                                                      
    endforeach;
    
    return $RET;                        
                                        
  }

  private function CarregaInfoCursos( $idS , $cat = 0 )
  {
                    
    $RET = array();        
    $A_OC_PAGER = CursosPeer::getCursos( CursosPeer::CURSACTIU , 0 , '' , $idS , true );                                                                       
            
    foreach($A_OC_PAGER->getResults() as $OC):
    
        if(!isset($RET[$OC->getCategoria()])):                
            $OT = TipusPeer::retrieveByPK($OC->getCategoria()); 
            if($OT instanceof Tipus) $RET[$OC->getCategoria()] = array( 'mode' => 3 , 'titol' => $OT->getTipusdesc() , 'elements'=>array() );
            else $RET[$OC->getCategoria()] = array( 'mode' => 3 , 'titol' => 'n/d' , 'elements'=>array() );
                                
        endif;
                     
        $RET[$OC->getCategoria()]['elements'][$OC->getIdcursos()] = array(
                                        'url' => '@web_menu_click_curs?idCategoria='.$OC->getCategoria().'&idCurs='.$OC->getIdcursos().'&titol='.$OC->getNomForUrl() ,  
                                        'titol' => '&nbsp;<div style="float:left; width: 400px;">'.$OC->getTitolcurs().'</div><div style="float:left;">'.$OC->getHoraris().'</div>' , 
                                        'img' => 'color' );                                                            
    endforeach;
    
    return $RET;                        
                                        
  }


  //Primer mostrem1 un llistat amb les categories dels cursos que hi ha actualment. 
/*  private function CarregaInfoCursos( $idS , $cat = 0 )
  {
    
    //Hem de mostrar el llistat de categories
    if($cat == 0):
    
        $RET = array(); $nom_categoria = "";        

        $A_OC_PAGER = CursosPeer::getCursos( CursosPeer::CURSACTIU , 0 , '' , $idS , true );                                                                       
        $RET[1]['mode'] = 3;
        $RET[1]['titol'] = "Cursos amb matrícula oberta";
        foreach($A_OC_PAGER->getResults() as $OC):
            $OT = TipusPeer::retrieveByPK( $OC->getCategoria() );
            if($OT instanceof Tipus) $nom_categoria = $OT->getTipusDesc();            
            $RET[1]['elements'][$OC->getCategoria()] = array(
                                            'url' => '@web_menu_click_curs?idCategoria='.$OC->getCategoria().'&idCurs=0&titol='.$nom_categoria ,
                                            'titol' => $OC->getCategoriaText(),
                                            'img' => 'color');                                                    
        endforeach;
        
    //Hem de mostrar els cursos dins d'una categoria
    else: 
    
        $RET = array(); $nom_categoria = "";
        $OT = TipusPeer::retrieveByPK($cat);
        if($OT instanceof Tipus) $nom_categoria = $OT->getTipusDesc();
        
        $A_OC_PAGER = CursosPeer::getCursos( CursosPeer::CURSACTIU , 0 , '' , $idS , true );                                                                       
        $RET[1]['mode'] = 2;
        $RET[1]['titol'] = "Cursos disponibles de ".$nom_categoria;
        foreach($A_OC_PAGER->getResults() as $OC):         
            if($OC->getCategoria() == $cat):
                $RET[1]['elements'][$OC->getIdcursos()] = array(
                                                'url' => '@web_menu_click_curs?idCategoria='.$OC->getCategoria().'&idCurs='.$OC->getIdcursos().'&titol='.$OC->getNomForUrl() ,  
                                                'titol' => $OC->getTitolcurs().'<br />'.$OC->getHoraris() , 
                                                'img' => 'color' );
            endif;                                                    
        endforeach;

    
    endif;         
    
    return $RET;                        
                                        
  }
*/  
  public function executeAjaxGetEmailMailing(sfWebRequest $request)
  {
    $CAPTCHA = $request->getParameter('CAPTCHA');
    $EMAIL = $request->getParameter('EMAIL');    
    $val1 = $this->getUser()->getAttribute('CAPTCHA1');
    $val2 = $this->getUser()->getAttribute('CAPTCHA2');    
    if( ( intval($val1) + intval($val2) ) == intval($CAPTCHA) ):
        if( filter_var( $EMAIL , FILTER_VALIDATE_EMAIL ) ):
            //Si el correu és correcte i el captcha també, entrem l'adreça a la base de dades.
            mail('informatica@casadecultura.org','CCG :: NOU MAILING',"S'ha afegit l'usuari amb correu electrònic: ".$EMAIL);
            //$RET = LlistesLlistesEmailsPeer::addEmails($EMAIL, 1, 1);            
            //if( sizeof( $RET['ERRORS'] ) == 0 ) return $this->renderText('ok');
            //else return $this->renderText('fail');
            return $this->renderText('ok');            
        else:
            return $this->renderText('fail');
        endif;
    else: 
        return $this->renderText('fail');
    endif;    
    
  }

  private function Image_exists($directori, $id){
    //Mirem si la imatge existeix
    $dir = getcwd().'/images/'.$directori.'/'.$id.'.jpg';                                    
    return file_exists($dir);
  }
  
}
