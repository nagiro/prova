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


/** PHPExcel_IComparable */
require_once 'PHPExcel/IComparable.php';

/** PHPExcel_Worksheet */
require_once 'PHPExcel/Worksheet.php';

/** PHPExcel_Worksheet_BaseDrawing */
require_once 'PHPExcel/Worksheet/BaseDrawing.php';

/** PHPExcel_Worksheet_Drawing */
require_once 'PHPExcel/Worksheet/Drawing.php';


/**
 * PHPExcel_Worksheet_HeaderFooterDrawing
 *
 * @category   PHPExcel
 * @package    PHPExcel_Worksheet
 * @copyright  Copyright (c) 2006 - 2009 PHPExcel (http://www.codeplex.com/PHPExcel)
 */
class PHPExcel_Worksheet_HeaderFooterDrawing extends PHPExcel_Worksheet_Drawing implements PHPExcel_IComparable 
{	
	/**
	 * Path
	 *
	 * @var string
	 */
	private $_path;
    
	/**
	 * Name
	 *
	 * @var string
	 */
	protected $_name;
	
	/**
	 * Offset X
	 *
	 * @var int
	 */
	protected $_offsetX;
	
	/**
	 * Offset Y
	 *
	 * @var int
	 */
	protected $_offsetY;
	
	/**
	 * Width
	 *
	 * @var int
	 */
	protected $_width;
	
	/**
	 * Height
	 *
	 * @var int
	 */
	protected $_height;
	
	/**
	 * Proportional resize
	 *
	 * @var boolean
	 */
	protected $_resizeProportional;
	
    /**
     * Create a new PHPExcel_Worksheet_HeaderFooterDrawing
     */
    public function __construct()
    {
    	// Initialise values
    	$this->_path				= '';
    	$this->_name				= '';
    	$this->_offsetX				= 0;
    	$this->_offsetY				= 0;
    	$this->_width				= 0;
    	$this->_height				= 0;
    	$this->_resizeProportional	= true;
    }
       
    /**
     * Get Name
     *
     * @return string
     */
    public function getName() {
    	return $this->_name;
    }
    
    /**
     * Set Name
     *
     * @param string $pValue
     */
    public function setName($pValue = '') {
    	$this->_name = $pValue;
    }
    
    /**
     * Get OffsetX
     *
     * @return int
     */
    public function getOffsetX() {
    	return $this->_offsetX;
    }
    
    /**
     * Set OffsetX
     *
     * @param int $pValue
     */
    public function setOffsetX($pValue = 0) {
    	$this->_offsetX = $pValue;
    }
    
    /**
     * Get OffsetY
     *
     * @return int
     */
    public function getOffsetY() {
    	return $this->_offsetY;
    }
    
    /**
     * Set OffsetY
     *
     * @param int $pValue
     */
    public function setOffsetY($pValue = 0) {
    	$this->_offsetY = $pValue;
    }
    
    /**
     * Get Width
     *
     * @return int
     */
    public function getWidth() {
    	return $this->_width;
    }
    
    /**
     * Set Width
     *
     * @param int $pValue
     */
    public function setWidth($pValue = 0) {
    	// Resize proportional?
    	if ($this->_resizeProportional && $pValue != 0) {
    		$ratio = $this->_width / $this->_height;    		
    		$this->_height = round($ratio * $pValue);
    	}
    	
    	// Set width
    	$this->_width = $pValue;
    }
    
    /**
     * Get Height
     *
     * @return int
     */
    public function getHeight() {
    	return $this->_height;
    }
    
    /**
     * Set Height
     *
     * @param int $pValue
     */
    public function setHeight($pValue = 0) {
    	// Resize proportional?
    	if ($this->_resizeProportional && $pValue != 0) {
    		$ratio = $this->_width / $this->_height;   		
    		$this->_width = round($ratio * $pValue);
    	}
    	
    	// Set height
    	$this->_height = $pValue;
    }
    
    /**
     * Set width and height with proportional resize
     * @author Vincent@luo MSN:kele_100@hotmail.com
     * @param int $width
     * @param int $height
     * @example $objDrawing->setResizeProportional(true);
     * @example $objDrawing->setWidthAndHeight(160,120);
     */
	public function setWidthAndHeight($width = 0, $height = 0) {
		$xratio = $width / $this->_width;
		$yratio = $height / $this->_height;
		if ($this->_resizeProportional && !($width == 0 || $height == 0)) {
			if (($xratio * $this->_height) < $height) {
				$this->_height = ceil($xratio * $this->_height);
				$this->_width  = $width;
			} else {
				$this->_width	= ceil($yratio * $this->_width);
				$this->_height	= $height;
			}
		}
	}
    
    /**
     * Get ResizeProportional
     *
     * @return boolean
     */
    public function getResizeProportional() {
    	return $this->_resizeProportional;
    }
    
    /**
     * Set ResizeProportional
     *
     * @param boolean $pValue
     */
    public function setResizeProportional($pValue = true) {
    	$this->_resizeProportional = $pValue;
    }
    
    /**
     * Get Filename
     *
     * @return string
     */
    public function getFilename() {
    	return basename($this->_path);
    }
    
    /**
     * Get Extension
     *
     * @return string
     */
    public function getExtension() {
    	return end(explode(".", basename($this->_path)));
    }
    
    /**
     * Get Path
     *
     * @return string
     */
    public function getPath() {
    	return $this->_path;
    }
    
    /**
     * Set Path
     *
     * @param 	string 		$pValue			File path
     * @param 	boolean		$pVerifyFile	Verify file
     * @throws 	Exception
     */
    public function setPath($pValue = '', $pVerifyFile = true) {
    	if ($pVerifyFile) {
	    	if (file_exists($pValue)) {
	    		$this->_path = $pValue;
	    		
	    		if ($this->_width == 0 && $this->_height == 0) {
	    			// Get width/height
	    			list($this->_width, $this->_height) = getimagesize($pValue);
	    		}
	    	} else {
	    		throw new Exception("File $pValue not found!");
	    	}
    	} else {
    		$this->_path = $pValue;
    	}
    }

	/**
	 * Get hash code
	 *
	 * @return string	Hash code
	 */	
	public function getHashCode() {
    	return md5(
    		  $this->_path
    		. $this->_name
    		. $this->_offsetX
    		. $this->_offsetY
    		. $this->_width
    		. $this->_height
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
