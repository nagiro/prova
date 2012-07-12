<?php


/**
 * This class defines the structure of the 'hospici_documents' table.
 *
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 06/28/12 10:57:46
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class HospiciDocumentsTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.HospiciDocumentsTableMap';

	/**
	 * Initialize the table attributes, columns and validators
	 * Relations are not initialized by this method since they are lazy loaded
	 *
	 * @return     void
	 * @throws     PropelException
	 */
	public function initialize()
	{
	  // attributes
		$this->setName('hospici_documents');
		$this->setPhpName('HospiciDocuments');
		$this->setClassname('HospiciDocuments');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('DOCUMENT_ID', 'DocumentId', 'INTEGER', true, 11, null);
		$this->addColumn('URL', 'Url', 'LONGVARCHAR', true, null, null);
		$this->addColumn('NOM', 'Nom', 'LONGVARCHAR', true, null, null);
		$this->addColumn('DESCRIPCIO', 'Descripcio', 'LONGVARCHAR', true, null, null);
		$this->addColumn('TAGS', 'Tags', 'LONGVARCHAR', true, null, null);
		$this->addColumn('DATA_ALTA', 'DataAlta', 'DATE', true, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
	} // buildRelations()

	/**
	 * 
	 * Gets the list of behaviors registered for this table
	 * 
	 * @return array Associative array (name => parameters) of behaviors
	 */
	public function getBehaviors()
	{
		return array(
			'symfony' => array('form' => 'true', 'filter' => 'true', ),
			'symfony_behaviors' => array(),
		);
	} // getBehaviors()

} // HospiciDocumentsTableMap
