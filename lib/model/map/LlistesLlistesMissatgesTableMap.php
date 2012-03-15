<?php


/**
 * This class defines the structure of the 'llistes_llistes_missatges' table.
 *
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 03/12/12 12:13:38
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class LlistesLlistesMissatgesTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.LlistesLlistesMissatgesTableMap';

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
		$this->setName('llistes_llistes_missatges');
		$this->setPhpName('LlistesLlistesMissatges');
		$this->setClassname('LlistesLlistesMissatges');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(false);
		// columns
		$this->addPrimaryKey('IDLLISTA', 'Idllista', 'INTEGER', true, 11, null);
		$this->addPrimaryKey('IDMISSATGE', 'Idmissatge', 'INTEGER', true, 11, null);
		$this->addColumn('ACTIU', 'Actiu', 'TINYINT', true, 1, 1);
		$this->addColumn('SITE_ID', 'SiteId', 'TINYINT', true, 4, null);
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

} // LlistesLlistesMissatgesTableMap
