<?php


/**
 * This class adds structure of 'missatgesmailing' table to 'propel' DatabaseMap object.
 *
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * Thu Nov 26 11:47:44 2009
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class MissatgesmailingMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.MissatgesmailingMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(MissatgesmailingPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(MissatgesmailingPeer::TABLE_NAME);
		$tMap->setPhpName('Missatgesmailing');
		$tMap->setClassname('Missatgesmailing');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('IDMISSATGE', 'Idmissatge', 'INTEGER', true, 11);

		$tMap->addColumn('TITOL', 'Titol', 'LONGVARCHAR', true, null);

		$tMap->addColumn('TEXT', 'Text', 'LONGVARCHAR', true, null);

		$tMap->addColumn('DATA_ALTA', 'DataAlta', 'DATE', true, null);

	} // doBuild()

} // MissatgesmailingMapBuilder
