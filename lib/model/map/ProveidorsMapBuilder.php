<?php


/**
 * This class adds structure of 'proveidors' table to 'propel' DatabaseMap object.
 *
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * Thu Jul 16 11:54:07 2009
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class ProveidorsMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.ProveidorsMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(ProveidorsPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(ProveidorsPeer::TABLE_NAME);
		$tMap->setPhpName('Proveidors');
		$tMap->setClassname('Proveidors');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('PROVEIDORID', 'Proveidorid', 'INTEGER', true, 11);

		$tMap->addColumn('NIF', 'Nif', 'VARCHAR', false, 20);

		$tMap->addColumn('NOM', 'Nom', 'LONGVARCHAR', false, null);

		$tMap->addColumn('TELEFON', 'Telefon', 'VARCHAR', false, 50);

		$tMap->addColumn('CE', 'Ce', 'VARCHAR', false, 100);

		$tMap->addColumn('CC', 'Cc', 'VARCHAR', false, 100);

		$tMap->addColumn('CP', 'Cp', 'VARCHAR', false, 100);

		$tMap->addColumn('ADRECA', 'Adreca', 'LONGVARCHAR', false, null);

		$tMap->addColumn('ALTA', 'Alta', 'DATE', false, null);

		$tMap->addColumn('CIUTAT', 'Ciutat', 'LONGVARCHAR', false, null);

	} // doBuild()

} // ProveidorsMapBuilder
