<?php


/**
 * This class defines the structure of the 'nodes' table.
 *
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 11/04/10 14:57:05
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class NodesTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.NodesTableMap';

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
		$this->setName('nodes');
		$this->setPhpName('Nodes');
		$this->setClassname('Nodes');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('IDNODES', 'Idnodes', 'INTEGER', true, 11, null);
		$this->addColumn('TITOLMENU', 'Titolmenu', 'LONGVARCHAR', false, null, null);
		$this->addColumn('HTML', 'Html', 'LONGVARCHAR', false, null, null);
		$this->addColumn('ISCATEGORIA', 'Iscategoria', 'TINYINT', false, 4, 0);
		$this->addColumn('ISPHP', 'Isphp', 'TINYINT', true, 1, 0);
		$this->addColumn('ISACTIVA', 'Isactiva', 'TINYINT', false, 4, 1);
		$this->addColumn('ORDRE', 'Ordre', 'INTEGER', false, 11, null);
		$this->addColumn('NIVELL', 'Nivell', 'INTEGER', true, 11, null);
		$this->addColumn('URL', 'Url', 'LONGVARCHAR', true, null, null);
		$this->addColumn('CATEGORIES', 'Categories', 'VARCHAR', true, 100, null);
		$this->addColumn('SITE_ID', 'SiteId', 'TINYINT', false, 4, null);
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

} // NodesTableMap
