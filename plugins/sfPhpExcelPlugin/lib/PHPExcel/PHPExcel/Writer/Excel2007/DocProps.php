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
 * @package    PHPExcel_Writer_Excel2007
 * @copyright  Copyright (c) 2006 - 2009 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    ##VERSION##, ##DATE##
 */


/** PHPExcel */
require_once 'PHPExcel.php';

/** PHPExcel_Writer_Excel2007 */
require_once 'PHPExcel/Writer/Excel2007.php';

/** PHPExcel_Writer_Excel2007_WriterPart */
require_once 'PHPExcel/Writer/Excel2007/WriterPart.php';

/** PHPExcel_Shared_XMLWriter */
require_once 'PHPExcel/Shared/XMLWriter.php';


/**
 * PHPExcel_Writer_Excel2007_DocProps
 *
 * @category   PHPExcel
 * @package    PHPExcel_Writer_Excel2007
 * @copyright  Copyright (c) 2006 - 2009 PHPExcel (http://www.codeplex.com/PHPExcel)
 */
class PHPExcel_Writer_Excel2007_DocProps extends PHPExcel_Writer_Excel2007_WriterPart
{
/**
	 * Write docProps/app.xml to XML format
	 *
	 * @param 	PHPExcel	$pPHPExcel
	 * @return 	string 		XML Output
	 * @throws 	Exception
	 */
	public function writeDocPropsApp(PHPExcel $pPHPExcel = null)
	{
		// Create XML writer
		$objWriter = null;
		if ($this->getParentWriter()->getUseDiskCaching()) {
			$objWriter = new PHPExcel_Shared_XMLWriter(PHPExcel_Shared_XMLWriter::STORAGE_DISK, $this->getParentWriter()->getDiskCachingDirectory());
		} else {
			$objWriter = new PHPExcel_Shared_XMLWriter(PHPExcel_Shared_XMLWriter::STORAGE_MEMORY);
		}

		// XML header
		$objWriter->startDocument('1.0','UTF-8','yes');

		// Properties
		$objWriter->startElement('Properties');
		$objWriter->writeAttribute('xmlns', 'http://schemas.openxmlformats.org/officeDocument/2006/extended-properties');
		$objWriter->writeAttribute('xmlns:vt', 'http://schemas.openxmlformats.org/officeDocument/2006/docPropsVTypes');

			// Application
			$objWriter->writeElement('Application', 	'Microsoft Excel');

			// DocSecurity
			$objWriter->writeElement('DocSecurity', 	'0');

			// ScaleCrop
			$objWriter->writeElement('ScaleCrop', 		'false');

			// HeadingPairs
			$objWriter->startElement('HeadingPairs');

				// Vector
				$objWriter->startElement('vt:vector');
				$objWriter->writeAttribute('size', 		'2');
				$objWriter->writeAttribute('baseType', 	'variant');


					// Variant
					$objWriter->startElement('vt:variant');
						$objWriter->writeElement('vt:lpstr', 	'Worksheets');
					$objWriter->endElement();

					// Variant
					$objWriter->startElement('vt:variant');
						$objWriter->writeElement('vt:i4', 		$pPHPExcel->getSheetCount());
					$objWriter->endElement();

				$objWriter->endElement();

			$objWriter->endElement();

			// TitlesOfParts
			$objWriter->startElement('TitlesOfParts');

				// Vector
				$objWriter->startElement('vt:vector');
				$objWriter->writeAttribute('size', 		$pPHPExcel->getSheetCount());
				$objWriter->writeAttribute('baseType',	'lpstr');

				$sheetCount = $pPHPExcel->getSheetCount();
				for ($i = 0; $i < $sheetCount; ++$i) {
					$objWriter->writeElement('vt:lpstr', $pPHPExcel->getSheet($i)->getTitle());
				}

				$objWriter->endElement();

			$objWriter->endElement();

			// Company
			$objWriter->writeElement('Company', 			'Microsoft Corporation');

			// LinksUpToDate
			$objWriter->writeElement('LinksUpToDate', 		'false');

			// SharedDoc
			$objWriter->writeElement('SharedDoc', 			'false');

			// HyperlinksChanged
			$objWriter->writeElement('HyperlinksChanged', 	'false');

			// AppVersion
			$objWriter->writeElement('AppVersion', 			'12.0000');

		$objWriter->endElement();

		// Return
		return $objWriter->getData();
	}

	/**
	 * Write docProps/core.xml to XML format
	 *
	 * @param 	PHPExcel	$pPHPExcel
	 * @return 	string 		XML Output
	 * @throws 	Exception
	 */
	public function writeDocPropsCore(PHPExcel $pPHPExcel = null)
	{
		// Create XML writer
		$objWriter = null;
		if ($this->getParentWriter()->getUseDiskCaching()) {
			$objWriter = new PHPExcel_Shared_XMLWriter(PHPExcel_Shared_XMLWriter::STORAGE_DISK, $this->getParentWriter()->getDiskCachingDirectory());
		} else {
			$objWriter = new PHPExcel_Shared_XMLWriter(PHPExcel_Shared_XMLWriter::STORAGE_MEMORY);
		}

		// XML header
		$objWriter->startDocument('1.0','UTF-8','yes');

		// cp:coreProperties
		$objWriter->startElement('cp:coreProperties');
		$objWriter->writeAttribute('xmlns:cp', 'http://schemas.openxmlformats.org/package/2006/metadata/core-properties');
		$objWriter->writeAttribute('xmlns:dc', 'http://purl.org/dc/elements/1.1/');
		$objWriter->writeAttribute('xmlns:dcterms', 'http://purl.org/dc/terms/');
		$objWriter->writeAttribute('xmlns:dcmitype', 'http://purl.org/dc/dcmitype/');
		$objWriter->writeAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');

			// dc:creator
			$objWriter->writeElement('dc:creator',			$pPHPExcel->getProperties()->getCreator());

			// cp:lastModifiedBy
			$objWriter->writeElement('cp:lastModifiedBy', 	$pPHPExcel->getProperties()->getLastModifiedBy());

			// dcterms:created
			$objWriter->startElement('dcterms:created');
			$objWriter->writeAttribute('xsi:type', 'dcterms:W3CDTF');
			$objWriter->writeRaw(date(DATE_W3C, 			$pPHPExcel->getProperties()->getCreated()));
			$objWriter->endElement();

			// dcterms:modified
			$objWriter->startElement('dcterms:modified');
			$objWriter->writeAttribute('xsi:type', 'dcterms:W3CDTF');
			$objWriter->writeRaw(date(DATE_W3C, 			$pPHPExcel->getProperties()->getModified()));
			$objWriter->endElement();

			// dc:title
			$objWriter->writeElement('dc:title', 			$pPHPExcel->getProperties()->getTitle());

			// dc:description
			$objWriter->writeElement('dc:description', 		$pPHPExcel->getProperties()->getDescription());

			// dc:subject
			$objWriter->writeElement('dc:subject', 			$pPHPExcel->getProperties()->getSubject());

			// cp:keywords
			$objWriter->writeElement('cp:keywords', 		$pPHPExcel->getProperties()->getKeywords());

			// cp:category
			$objWriter->writeElement('cp:category', 		$pPHPExcel->getProperties()->getCategory());

		$objWriter->endElement();

		// Return
		return $objWriter->getData();
	}
}
