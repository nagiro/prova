<?php

/**
 * Subclass for performing query and update operations on the 'word_statical' table.
 *
 * 
 *
 * @package lib.model
 */ 
class WordStaticalPeer extends BaseWordStaticalPeer
{

	const ENTITAT = 'E';
	const FITXERMULTIMEDIA = 'M';
	const ALBUMMULTIMEDIA = 'L';
	const ARTICLE = 'A';
	const DOCUMENT = 'D';
	const ACTIVITAT = 'C';
	const PROJECTE = 'P';
	
	
	static public function updateIndex($TextOriginal , $idObject , $idSecondary , $Tipus = "D")
	{
		$ParaulesOrigen = array();

		//Creem un array amb totes les paraules de més de 2 lletres $a['paraula']=#aparicions
		$CadenaDepurada = WordStaticalPeer::Formata($TextOriginal);

		foreach( $CadenaDepurada as $ParaulaOrigen ):
			if( strlen($ParaulaOrigen) > 3 ):
				if( isset($ParaulesOrigen[$ParaulaOrigen]) ):
					$ParaulesOrigen[$ParaulaOrigen]++; 	 //Guardem la paraula i sumem 1 més si en trobem una d'extra
				else:
					$ParaulesOrigen[$ParaulaOrigen] = 1;
				endif;
			endif;
		endforeach;

		//Totes les paraules noves, les hem d'afegir a la BDD
		foreach($ParaulesOrigen as $Paraula => $Aparicions):

			$WS = new WordStatical();
			$WS->setNew(true);
			$WS->setParaula($Paraula);
			$WS->setAparicions($Aparicions);
			$WS->setIdobject($idObject);
			$WS->setidsecondary($idSecondary);
			$WS->setModul($Tipus);
			$WS->save();
	
		endforeach;

	}

	static public function Formata($TextOriginal)
	{
		/* Remove whitespace from beginning and end of string: */
		$buf = trim($TextOriginal);
    $buf = strtolower($buf);
    $buf = strip_tags($buf);
    $buf = html_entity_decode($buf, ENT_COMPAT, "UTF-8");

    $buf = str_replace ("'"," ",$buf); //Treiem la cometa
    $buf = str_replace ("\""," ",$buf); //Treiem la cometa
    $buf = str_replace ("!"," ",$buf); //Treiem la cometa
    $buf = str_replace ("?"," ",$buf); //Treiem la cometa
    $buf = str_replace ("."," ",$buf); //Treiem la cometa
    $buf = str_replace (","," ",$buf); //Treiem la cometa
    $buf = str_replace (";"," ",$buf); //Treiem la cometa
    $buf = eregi_replace("[\n|\r|\n\r]", ' ', $buf); //Treu els salts de línia
    $buf = trim($buf);  //Tornem a treure espais en blanc  
        				
    $words = explode(" ", $buf);
    
	  if($TextOriginal == "") return array();
   	return $words;
	}

}
