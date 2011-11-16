<?php


/**
 * This class defines the structure of the 'entrades_preus' table.
 *
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 11/04/11 12:43:48
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class EntradesPreusTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.EntradesPreusTableMap';

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
		$this->setName('entrades_preus');
		$this->setPhpName('EntradesPreus');
		$this->setClassname('EntradesPreus');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(false);
		// columns
		$this->addPrimaryKey('HORARI_ID', 'HorariId', 'INTEGER', true, 11, 0);
		$this->addColumn('PREU', 'Preu', 'SMALLINT', false, 6, null);
		$this->addColumn('PREUR', 'Preur', 'SMALLINT', false, 6, null);
		$this->addColumn('PLACES', 'Places', 'SMALLINT', false, 6, null);
		$this->addColumn('TIPUS', 'Tipus', 'SMALLINT', false, 1, 1);
		$this->addPrimaryKey('ACTIVITAT_ID', 'ActivitatId', 'INTEGER', true, 11, 0);
		$this->addColumn('SITE_ID', 'SiteId', 'SMALLINT', true, 6, null);
		$this->addColumn('ACTIU', 'Actiu', 'TINYINT', true, 1, null);
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

} // EntradesPreusTableMap
