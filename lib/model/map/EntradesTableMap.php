<?php


/**
 * This class defines the structure of the 'entrades' table.
 *
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 07/19/10 14:29:45
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class EntradesTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.EntradesTableMap';

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
		$this->setName('entrades');
		$this->setPhpName('Entrades');
		$this->setClassname('Entrades');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('IDENTRADA', 'Identrada', 'INTEGER', true, 11, null);
		$this->addColumn('TITOL', 'Titol', 'VARCHAR', true, 50, null);
		$this->addColumn('SUBTITOL', 'Subtitol', 'VARCHAR', true, 50, null);
		$this->addColumn('DATA', 'Data', 'VARCHAR', true, 50, null);
		$this->addColumn('LLOC', 'Lloc', 'VARCHAR', true, 50, null);
		$this->addColumn('PREU', 'Preu', 'VARCHAR', true, 50, null);
		$this->addColumn('VENUDES', 'Venudes', 'INTEGER', true, 11, null);
		$this->addColumn('RECAPTAT', 'Recaptat', 'INTEGER', true, 11, null);
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

} // EntradesTableMap
