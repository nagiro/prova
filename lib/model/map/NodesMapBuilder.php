<?php


/**
 * This class adds structure of 'nodes' table to 'propel' DatabaseMap object.
 *
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * 03/24/10 13:49:04
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class NodesMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.NodesMapBuilder';

	/**
	 * The database map.
	 */
	private $dbMap;

	/**
	 * Tells us if this DatabaseMapBuilder is built so that we
	 * don't have to re-build it every time.
	 *
	 * @return     boolean true if this DatabaseMapBuilder is built, false otherwise.
	 */
	public function isBuilt()
	{
		return ($this->dbMap !== null);
	}

	/**
	 * Gets the databasemap this map builder built.
	 *
	 * @return     the databasemap
	 */
	public function getDatabaseMap()
	{
		return $this->dbMap;
	}

	/**
	 * The doBuild() method builds the DatabaseMap
	 *
	 * @return     void
	 * @throws     PropelException
	 */
	public function doBuild()
	{
		$this->dbMap = Propel::getDatabaseMap(NodesPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(NodesPeer::TABLE_NAME);
		$tMap->setPhpName('Nodes');
		$tMap->setClassname('Nodes');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('IDNODES', 'Idnodes', 'INTEGER', true, 11);

		$tMap->addColumn('TITOLMENU', 'Titolmenu', 'LONGVARCHAR', false, null);

		$tMap->addColumn('HTML', 'Html', 'LONGVARCHAR', false, null);

		$tMap->addColumn('ISCATEGORIA', 'Iscategoria', 'TINYINT', false, 4);

		$tMap->addColumn('ISPHP', 'Isphp', 'TINYINT', true, 1);

		$tMap->addColumn('ISACTIVA', 'Isactiva', 'TINYINT', false, 4);

		$tMap->addColumn('ORDRE', 'Ordre', 'INTEGER', false, 11);

		$tMap->addColumn('NIVELL', 'Nivell', 'INTEGER', true, 11);

		$tMap->addColumn('URL', 'Url', 'LONGVARCHAR', true, null);

	} // doBuild()

} // NodesMapBuilder
