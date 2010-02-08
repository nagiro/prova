<?php


/**
 * This class adds structure of 'promocions' table to 'propel' DatabaseMap object.
 *
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * Wed Feb  3 13:23:35 2010
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class PromocionsMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.PromocionsMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(PromocionsPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(PromocionsPeer::TABLE_NAME);
		$tMap->setPhpName('Promocions');
		$tMap->setClassname('Promocions');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('PROMOCIOID', 'Promocioid', 'INTEGER', true, 11);

		$tMap->addColumn('NOM', 'Nom', 'LONGVARCHAR', false, null);

		$tMap->addColumn('ORDRE', 'Ordre', 'INTEGER', false, 11);

		$tMap->addColumn('EXTENSIO', 'Extensio', 'LONGVARCHAR', false, null);

		$tMap->addColumn('ISACTIVA', 'Isactiva', 'TINYINT', false, 4);

		$tMap->addColumn('ISFIXA', 'Isfixa', 'TINYINT', true, 1);

		$tMap->addColumn('URL', 'Url', 'LONGVARCHAR', true, null);

	} // doBuild()

} // PromocionsMapBuilder
