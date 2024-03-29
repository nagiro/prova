<?php
/**
 * PHPExcel
 *
 * Copyright (c) 2006 - 2009 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 * 
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel_Style
 * @copyright  Copyright (c) 2006 - 2009 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    ##VERSION##, ##DATE##
 */


/** PHPExcel_Style_Color */
require_once 'PHPExcel/Style/Color.php';

/** PHPExcel_IComparable */
require_once 'PHPExcel/IComparable.php';


/**
 * PHPExcel_Style_Font
 *
 * @category   PHPExcel
 * @package    PHPExcel_Style
 * @copyright  Copyright (c) 2006 - 2009 PHPExcel (http://www.codeplex.com/PHPExcel)
 */
class PHPExcel_Style_Font implements PHPExcel_IComparable
{
	/* Underline types */
	const UNDERLINE_NONE					= 'none';
	const UNDERLINE_DOUBLE					= 'double';
	const UNDERLINE_DOUBLEACCOUNTING		= 'doubleAccounting';
	const UNDERLINE_SINGLE					= 'single';
	const UNDERLINE_SINGLEACCOUNTING		= 'singleAccounting';
	
	/**
	 * Name
	 *
	 * @var string
	 */
	private $_name;
	
	/**
	 * Bold
	 *
	 * @var boolean
	 */
	private $_bold;
	
	/**
	 * Italic
	 *
	 * @var boolean
	 */
	private $_italic;
	
	/**
	 * Superscript
	 *
	 * @var boolean
	 */
	private $_superScript;
	
	/**
	 * Subscript
	 *
	 * @var boolean
	 */
	private $_subScript;
	
	/**
	 * Underline
	 *
	 * @var string
	 */
	private $_underline;
	
	/**
	 * Strikethrough
	 *
	 * @var boolean
	 */
	private $_strikethrough;
	
	/**
	 * Foreground color
	 * 
	 * @var PHPExcel_Style_Color
	 */
	private $_color;	
	
	/**
	 * Parent Style
	 *
	 * @var PHPExcel_Style
	 */
	 
	private $_parent;
	
	/**
	 * Parent Borders
	 *
	 * @var _parentPropertyName string
	 */
	private $_parentPropertyName;
		
	/**
     * Create a new PHPExcel_Style_Font
     */
    public function __construct()
    {
    	// Initialise values
    	$this->_name				= 'Calibri';
    	$this->_size				= 10;
		$this->_bold				= false;
		$this->_italic				= false;
		$this->_superScript			= false;
		$this->_subScript			= false;
		$this->_underline			= PHPExcel_Style_Font::UNDERLINE_NONE;
		$this->_strikethrough		= false;
		$this->_color				= new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_BLACK);
    }

	/**
	 * Property Prepare bind
	 *
	 * Configures this object for late binding as a property of a parent object
	 *	 
	 * @param $parent
	 * @param $parentPropertyName
	 */
	public function propertyPrepareBind($parent, $parentPropertyName)
	{
		// Initialize parent PHPExcel_Style for late binding. This relationship purposely ends immediately when this object
		// is bound to the PHPExcel_Style object pointed to so as to prevent circular references.
		$this->_parent 				= $parent;
		$this->_parentPropertyName	= $parentPropertyName;
	}

    /**
     * Property Get Bound
     *
     * Returns the PHPExcel_Style_Font that is actual bound to PHPExcel_Style
	 *
	 * @return PHPExcel_Style_Font
     */
	private function propertyGetBound() {
		if(!isset($this->_parent))
			return $this;																// I am bound

		if($this->_parent->propertyIsBound($this->_parentPropertyName))
			return $this->_parent->getFont();											// Another one is bound

		return $this;																	// No one is bound yet
	}
	
    /**
     * Property Begin Bind
     *
     * If no PHPExcel_Style_Font has been bound to PHPExcel_Style then bind this one. Return the actual bound one.
	 *
	 * @return PHPExcel_Style_Font
     */
	private function propertyBeginBind() {
		if(!isset($this->_parent))
			return $this;																// I am already bound

		if($this->_parent->propertyIsBound($this->_parentPropertyName))
			return $this->_parent->getFont();											// Another one is already bound
			
		$this->_parent->propertyCompleteBind($this, $this->_parentPropertyName);		// Bind myself
		$this->_parent = null;
		
		return $this;
	}
    
    /**
     * Apply styles from array
     * 
     * <code>
     * $objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->applyFromArray(
     * 		array(
     * 			'name'      => 'Arial',
     * 			'bold'      => true,
     * 			'italic'    => false,
     * 			'underline' => PHPExcel_Style_Font::UNDERLINE_DOUBLE,
     * 			'strike'    => false,
     * 			'color'     => array(
     * 				'rgb' => '808080'
     * 			)
     * 		)
     * );
     * </code>
     * 
     * @param	array	$pStyles	Array containing style information
     * @throws	Exception
     */
    public function applyFromArray($pStyles = null) {
        if (is_array($pStyles)) {
        	if (array_key_exists('name', $pStyles)) {
    			$this->setName($pStyles['name']);
    		}
        	if (array_key_exists('bold', $pStyles)) {
    			$this->setBold($pStyles['bold']);
    		}
    		if (array_key_exists('italic', $pStyles)) {
    			$this->setItalic($pStyles['italic']);
    		}
			if (array_key_exists('superScript', $pStyles)) {
    			$this->setSuperScript($pStyles['superScript']);
    		}
			if (array_key_exists('subScript', $pStyles)) {
    			$this->setSubScript($pStyles['subScript']);
    		}
            if (array_key_exists('underline', $pStyles)) {
    			$this->setUnderline($pStyles['underline']);
    		}
            if (array_key_exists('strike', $pStyles)) {
    			$this->setStrikethrough($pStyles['strike']);
    		}
            if (array_key_exists('color', $pStyles)) {
    			$this->getColor()->applyFromArray($pStyles['color']);
    		}
        	if (array_key_exists('size', $pStyles)) {
    			$this->setSize($pStyles['size']);
    		}
    	} else {
    		throw new Exception("Invalid style array passed.");
    	}
    }
    
    /**
     * Get Name
     *
     * @return string
     */
    public function getName() {
    	return $this->propertyGetBound()->_name;
    }
    
    /**
     * Set Name
     *
     * @param string $pValue
     */
    public function setName($pValue = 'Calibri') {
   		if ($pValue == '') {
    		$pValue = 'Calibri';
    	}
    	$this->propertyBeginBind()->_name = $pValue;
    }
    
    /**
     * Get Size
     *
     * @return double
     */
    public function getSize() {
    	return $this->propertyGetBound()->_size;
    }
    
    /**
     * Set Size
     *
     * @param double $pValue
     */
    public function setSize($pValue = 10) {
    	if ($pValue == '') {
    		$pValue = 10;
    	}
    	$this->propertyBeginBind()->_size = $pValue;
    }
    
    /**
     * Get Bold
     *
     * @return boolean
     */
    public function getBold() {
    	return $this->propertyGetBound()->_bold;
    }
    
    /**
     * Set Bold
     *
     * @param boolean $pValue
     */
    public function setBold($pValue = false) {
    	if ($pValue == '') {
    		$pValue = false;
    	}
    	$this->propertyBeginBind()->_bold = $pValue;
    }
    
    /**
     * Get Italic
     *
     * @return boolean
     */
    public function getItalic() {
    	return $this->propertyGetBound()->_italic;
    }
    
    /**
     * Set Italic
     *
     * @param boolean $pValue
     */
    public function setItalic($pValue = false) {
    	if ($pValue == '') {
    		$pValue = false;
    	}
    	$this->propertyBeginBind()->_italic = $pValue;
    }
	
    /**
     * Get SuperScript
     *
     * @return boolean
     */
    public function getSuperScript() {
    	return $this->propertyGetBound()->_superScript;
    }
    
    /**
     * Set SuperScript
     *
     * @param boolean $pValue
     */
    public function setSuperScript($pValue = false) {
    	if ($pValue == '') {
    		$pValue = false;
    	}
    	$this->propertyBeginBind()->_superScript = $pValue;
		$this->propertyBeginBind()->_subScript = !$pValue;
    }
	
	    /**
     * Get SubScript
     *
     * @return boolean
     */
    public function getSubScript() {
    	return $this->propertyGetBound()->_subScript;
    }
    
    /**
     * Set SubScript
     *
     * @param boolean $pValue
     */
    public function setSubScript($pValue = false) {
    	if ($pValue == '') {
    		$pValue = false;
    	}
    	$this->propertyBeginBind()->_subScript = $pValue;
		$this->propertyBeginBind()->_superScript = !$pValue;
    }
    
    /**
     * Get Underline
     *
     * @return string
     */
    public function getUnderline() {
    	return $this->propertyGetBound()->_underline;
    }
    
    /**
     * Set Underline
     *
     * @param string $pValue	PHPExcel_Style_Font underline type
     */
    public function setUnderline($pValue = PHPExcel_Style_Font::UNDERLINE_NONE) {
    	if ($pValue == '') {
    		$pValue = PHPExcel_Style_Font::UNDERLINE_NONE;
    	}
    	$this->propertyBeginBind()->_underline = $pValue;
    }
    
    /**
     * Get Striketrough
     *
     * @deprecated Use getStrikethrough() instead.
     * @return boolean
     */
    public function getStriketrough() {
    	return $this->getStrikethrough();
    }
    
    /**
     * Set Striketrough
     *
     * @deprecated Use setStrikethrough() instead.
     * @param boolean $pValue
     */
    public function setStriketrough($pValue = false) {
    	$this->setStrikethrough($pValue);
    }
    
    /**
     * Get Strikethrough
     *
     * @return boolean
     */
    public function getStrikethrough() {
    	return $this->propertyGetBound()->_strikethrough;
    }
    
    /**
     * Set Strikethrough
     *
     * @param boolean $pValue
     */
    public function setStrikethrough($pValue = false) {
    	if ($pValue == '') {
    		$pValue = false;
    	}
    	$this->propertyBeginBind()->_strikethrough = $pValue;
    }

    /**
     * Get Color
     *
     * @return PHPExcel_Style_Color
     */
    public function getColor() {
    	// It's a get but it may lead to a modified color which we won't detect but in which case we must bind.
    	// So bind as an assurance.
    	return $this->propertyBeginBind()->_color;
    }
    
    /**
     * Set Color
     *
     * @param 	PHPExcel_Style_Color $pValue
     * @throws 	Exception
     */
    public function setColor(PHPExcel_Style_Color $pValue = null) {
   		$this->propertyBeginBind()->_color = $pValue;
    }

	/**
	 * Get hash code
	 *
	 * @return string	Hash code
	 */	
	public function getHashCode() {
		$property = $this->propertyGetBound();
    	return md5(
    		  $property->_name
    		. $property->_size
    		. ($property->_bold ? 't' : 'f')
    		. ($property->_italic ? 't' : 'f')
			. ($property->_superScript ? 't' : 'f')
			. ($property->_subScript ? 't' : 'f')
    		. $property->_underline
    		. ($property->_strikethrough ? 't' : 'f')
    		. $property->_color->getHashCode()
    		. __CLASS__
    	);
    }
    
    /**
     * Hash index
     *
     * @var string
     */
    private $_hashIndex;
    
	/**
	 * Get hash index
	 * 
	 * Note that this index may vary during script execution! Only reliable moment is
	 * while doing a write of a workbook and when changes are not allowed.
	 *
	 * @return string	Hash index
	 */
	public function getHashIndex() {
		return $this->_hashIndex;
	}
	
	/**
	 * Set hash index
	 * 
	 * Note that this index may vary during script execution! Only reliable moment is
	 * while doing a write of a workbook and when changes are not allowed.
	 *
	 * @param string	$value	Hash index
	 */
	public function setHashIndex($value) {
		$this->_hashIndex = $value;
	}
        
	/**
	 * Implement PHP __clone to create a deep clone, not just a shallow copy.
	 */
	public function __clone() {
		$vars = get_object_vars($this);
		foreach ($vars as $key => $value) {
			if (is_object($value)) {
				$this->$key = clone $value;
			} else {
				$this->$key = $value;
			}
		}
	}
}
