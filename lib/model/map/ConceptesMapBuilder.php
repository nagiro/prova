<?php


/**
 * This class adds structure of 'conceptes' table to 'propel' DatabaseMap object.
 *
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * 03/24/10 13:49:03
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class ConceptesMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.ConceptesMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(ConceptesPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(ConceptesPeer::TABLE_NAME);
		$tMap->setPhpName('Conceptes');
		$tMap->setClassname('Conceptes');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('CONCEPTEID', 'Concepteid', 'INTEGER', true, 11);

		$tMap->addColumn('ANY', 'Any', 'INTEGER', false, 11);

		$tMap->addColumn('CAPITOL', 'Capitol', 'LONGVARCHAR', false, null);

		$tMap->addColumn('APARTAT', 'Apartat', 'LONGVARCHAR', false, null);

		$tMap->addColumn('CONCEPTE', 'Concepte', 'LONGVARCHAR', false, null);

		$tMap->addColumn('QUANTITAT', 'Quantitat', 'DOUBLE', false, null);

	} // doBuild()

} // ConceptesMapBuilder
