<?php


/**
 * This class adds structure of 'incidencies' table to 'propel' DatabaseMap object.
 *
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * Thu Mar 11 13:07:17 2010
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class IncidenciesMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.IncidenciesMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(IncidenciesPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(IncidenciesPeer::TABLE_NAME);
		$tMap->setPhpName('Incidencies');
		$tMap->setClassname('Incidencies');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('IDINCIDENCIA', 'Idincidencia', 'INTEGER', true, 11);

		$tMap->addForeignKey('QUIINFORMA', 'Quiinforma', 'INTEGER', 'usuaris', 'USUARIID', true, 11);

		$tMap->addForeignKey('QUIRESOL', 'Quiresol', 'INTEGER', 'usuaris', 'USUARIID', true, 11);

		$tMap->addColumn('TITOL', 'Titol', 'LONGVARCHAR', false, null);

		$tMap->addColumn('DESCRIPCIO', 'Descripcio', 'LONGVARCHAR', false, null);

		$tMap->addColumn('ESTAT', 'Estat', 'INTEGER', true, 11);

		$tMap->addColumn('DATAALTA', 'Dataalta', 'DATE', true, null);

		$tMap->addColumn('DATARESOLUCIO', 'Dataresolucio', 'DATE', false, null);

	} // doBuild()

} // IncidenciesMapBuilder
