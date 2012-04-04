<?php


/**
 * This class defines the structure of the 'llistes_llistes' table.
 *
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 04/03/12 09:56:40
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class LlistesLlistesTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.LlistesLlistesTableMap';

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
		$this->setName('llistes_llistes');
		$this->setPhpName('LlistesLlistes');
		$this->setClassname('LlistesLlistes');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('IDLLISTA', 'Idllista', 'INTEGER', true, 11, null);
		$this->addColumn('NOM', 'Nom', 'LONGVARCHAR', false, null, null);
		$this->addColumn('SITE_ID', 'SiteId', 'SMALLINT', false, 6, null);
		$this->addColumn('ACTIU', 'Actiu', 'TINYINT', true, 1, 1);
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

} // LlistesLlistesTableMap
