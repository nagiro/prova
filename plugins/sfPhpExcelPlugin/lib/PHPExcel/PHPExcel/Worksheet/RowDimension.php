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
 * @package    PHPExcel_Worksheet
 * @copyright  Copyright (c) 2006 - 2009 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    ##VERSION##, ##DATE##
 */


/**
 * PHPExcel_Worksheet_RowDimension
 *
 * @category   PHPExcel
 * @package    PHPExcel_Worksheet
 * @copyright  Copyright (c) 2006 - 2009 PHPExcel (http://www.codeplex.com/PHPExcel)
 */
class PHPExcel_Worksheet_RowDimension
{			
	/**
	 * Row index
	 *
	 * @var int
	 */
	private $_rowIndex;
	
	/**
	 * Row height (in pt)
	 *
	 * When this is set to a negative value, the row height should be ignored by IWriter
	 *
	 * @var double
	 */
	private $_rowHeight;
	
	/**
	 * Visible?
	 *
	 * @var bool
	 */
	private $_visible;
	
	/**
	 * Outline level
	 *
	 * @var int
	 */
	private $_outlineLevel = 0;
	
	/**
	 * Collapsed
	 *
	 * @var bool
	 */
	private $_collapsed;
	
    /**
     * Create a new PHPExcel_Worksheet_RowDimension
     *
     * @param int $pIndex Numeric row index
     */
    public function __construct($pIndex = 0)
    {
    	// Initialise values
    	$this->_rowIndex		= $pIndex;
    	$this->_rowHeight		= -1;
    	$this->_visible			= true;
    	$this->_outlineLevel	= 0;
    	$this->_collapsed		= false;
    }
    
    /**
     * Get Row Index
     *
     * @return int
     */
    public function getRowIndex() {
    	return $this->_rowIndex;
    }
    
    /**
     * Set Row Index
     *
     * @param int $pValue
     */
    public function setRowIndex($pValue) {
    	$this->_rowIndex = $pValue;
    }
    
    /**
     * Get Row Height
     *
     * @return double
     */
    public function getRowHeight() {
    	return $this->_rowHeight;
    }
    
    /**
     * Set Row Height
     *
     * @param double $pValue
     */
    public function setRowHeight($pValue = -1) {
    	$this->_rowHeight = $pValue;
    }
    
    /**
     * Get Visible
     *
     * @return bool
     */
    public function getVisible() {
    	return $this->_visible;
    }
    
    /**
     * Set Visible
     *
     * @param bool $pValue
     */
    public function setVisible($pValue = true) {
    	$this->_visible = $pValue;
    }
    
    /**
     * Get Outline Level
     *
     * @return int
     */
    public function getOutlineLevel() {
    	return $this->_outlineLevel;
    }
    
    /**
     * Set Outline Level
     *
     * Value must be between 0 and 7
     *
     * @param int $pValue
     * @throws Exception
     */
    public function setOutlineLevel($pValue) {
    	if ($pValue < 0 || $pValue > 7) {
    		throw new Exception("Outline level must range between 0 and 7.");
    	}
    	
    	$this->_outlineLevel = $pValue;
    }
    
    /**
     * Get Collapsed
     *
     * @return bool
     */
    public function getCollapsed() {
    	return $this->_collapsed;
    }
    
    /**
     * Set Collapsed
     *
     * @param bool $pValue
     */
    public function setCollapsed($pValue = true) {
    	$this->_collapsed = $pValue;
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
