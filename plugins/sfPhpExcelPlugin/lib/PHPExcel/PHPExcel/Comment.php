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
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2009 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    ##VERSION##, ##DATE##
 */


/** PHPExcel_RichText */
require_once 'PHPExcel/RichText.php';

/** PHPExcel_Style_Color */
require_once 'PHPExcel/Style/Color.php';

/** PHPExcel_IComparable */
require_once 'PHPExcel/IComparable.php';


/**
 * PHPExcel_Comment
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2009 PHPExcel (http://www.codeplex.com/PHPExcel)
 */
class PHPExcel_Comment implements PHPExcel_IComparable
{
	/**
	 * Author
	 *
	 * @var string
	 */
	private $_author;
	
	/**
	 * Rich text comment
	 *
	 * @var PHPExcel_RichText
	 */
	private $_text;
	
	/**
	 * Comment width (CSS style, i.e. XXpx or YYpt)
	 *
	 * @var string
	 */
	private $_width = '96pt';
	
	/**
	 * Left margin (CSS style, i.e. XXpx or YYpt)
	 *
	 * @var string
	 */
	private $_marginLeft = '59.25pt';
	
	/**
	 * Top margin (CSS style, i.e. XXpx or YYpt)
	 *
	 * @var string
	 */
	private $_marginTop = '1.5pt';
	
	/**
	 * Visible
	 *
	 * @var boolean
	 */
	private $_visible = false;
	
	/**
	 * Comment height (CSS style, i.e. XXpx or YYpt)
	 *
	 * @var string
	 */
	private $_height = '55.5pt';
	
	/**
	 * Comment fill color
	 *
	 * @var PHPExcel_Style_Color
	 */
	private $_fillColor;
		
    /**
     * Create a new PHPExcel_Comment
     * 
     * @throws	Exception
     */
    public function __construct()
    {
    	// Initialise variables
    	$this->_author		  = 'Author';
    	$this->_text		  = new PHPExcel_RichText();
    	$this->_fillColor     = new PHPExcel_Style_Color('FFFFFFE1');
    }
    
    /**
     * Get Author
     *
     * @return string
     */
    public function getAuthor() {
    	return $this->_author;
    }
    
    /**
     * Set Author
     *
     * @param string $pValue
     */
	public function setAuthor($pValue = '') {
		$this->_author = $pValue;
	}
    
    /**
     * Get Rich text comment
     *
     * @return PHPExcel_RichText
     */
    public function getText() {
    	return $this->_text;
    }
    
    /**
     * Set Rich text comment
     *
     * @param PHPExcel_RichText $pValue
     */
    public function setText(PHPExcel_RichText $pValue) {
    	$this->_text = $pValue;
    }
    
    /**
     * Get comment width (CSS style, i.e. XXpx or YYpt)
     *
     * @return string
     */
    public function getWidth() {
        return $this->_width;
    }
    
    /**
     * Set comment width (CSS style, i.e. XXpx or YYpt)
     *
     * @param string $value
     */
    public function setWidth($value = '96pt') {
        $this->_width = $value;
    }
    
    /**
     * Get comment height (CSS style, i.e. XXpx or YYpt)
     *
     * @return string
     */
    public function getHeight() {
        return $this->_height;
    }
    
    /**
     * Set comment height (CSS style, i.e. XXpx or YYpt)
     *
     * @param string $value
     */
    public function setHeight($value = '55.5pt') {
        $this->_height = $value;
    }
    
    /**
     * Get left margin (CSS style, i.e. XXpx or YYpt)
     *
     * @return string
     */
    public function getMarginLeft() {
        return $this->_marginLeft;
    }
    
    /**
     * Set left margin (CSS style, i.e. XXpx or YYpt)
     *
     * @param string $value
     */
    public function setMarginLeft($value = '59.25pt') {
        $this->_marginLeft = $value;
    }
    
    /**
     * Get top margin (CSS style, i.e. XXpx or YYpt)
     *
     * @return string
     */
    public function getMarginTop() {
        return $this->_marginTop;
    }
    
    /**
     * Set top margin (CSS style, i.e. XXpx or YYpt)
     *
     * @param string $value
     */
    public function setMarginTop($value = '1.5pt') {
        $this->_marginTop = $value;
    }
    
    /**
     * Is the comment visible by default?
     *
     * @return boolean
     */
    public function getVisible() {
        return $this->_visible;
    }
    
    /**
     * Set comment default visibility
     *
     * @param boolean $value
     */
    public function setVisible($value = false) {
        $this->_visible = $value;   
    }
    
    /**
     * Get fill color
     *
     * @return PHPExcel_Style_Color
     */
    public function getFillColor() {
        return $this->_fillColor;
    }
    
	/**
	 * Get hash code
	 *
	 * @return string	Hash code
	 */	
	public function getHashCode() {
    	return md5(
    		  $this->_author
    		. $this->_text->getHashCode()
    		. $this->_width
    		. $this->_height
    		. $this->_marginLeft
    		. $this->_marginTop
    		. ($this->_visible ? 1 : 0)
    		. $this->_fillColor->getHashCode()
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
