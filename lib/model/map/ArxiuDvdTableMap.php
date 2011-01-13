<?php


/**
 * This class defines the structure of the 'arxiu_dvd' table.
 *
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 01/13/11 10:52:19
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class ArxiuDvdTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.ArxiuDvdTableMap';

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
		$this->setName('arxiu_dvd');
		$this->setPhpName('ArxiuDvd');
		$this->setClassname('ArxiuDvd');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, 11, null);
		$this->addColumn('TIPUS', 'Tipus', 'VARCHAR', true, 30, null);
		$this->addColumn('VOLUM', 'Volum', 'VARCHAR', false, 30, null);
		$this->addColumn('URL', 'Url', 'LONGVARCHAR', false, null, null);
		$this->addColumn('NOM', 'Nom', 'LONGVARCHAR', false, null, null);
		$this->addColumn('DATA_CREACIO', 'DataCreacio', 'TIMESTAMP', false, null, null);
		$this->addColumn('COMENTARI', 'Comentari', 'LONGVARCHAR', false, null, null);
		$this->addColumn('SITE_ID', 'SiteId', 'TINYINT', false, 4, null);
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

} // ArxiuDvdTableMap
