<?php


/**
 * This class adds structure of 'tasques' table to 'propel' DatabaseMap object.
 *
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * Thu Nov 26 11:47:45 2009
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class TasquesMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.TasquesMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(TasquesPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(TasquesPeer::TABLE_NAME);
		$tMap->setPhpName('Tasques');
		$tMap->setClassname('Tasques');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('TASQUESID', 'Tasquesid', 'INTEGER', true, 11);

		$tMap->addForeignKey('ACTIVITATS_ACTIVITATID', 'ActivitatsActivitatid', 'INTEGER', 'activitats', 'ACTIVITATID', false, 11);

		$tMap->addForeignKey('QUIMANA', 'Quimana', 'INTEGER', 'usuaris', 'USUARIID', false, 11);

		$tMap->addForeignKey('QUIFA', 'Quifa', 'INTEGER', 'usuaris', 'USUARIID', true, 11);

		$tMap->addColumn('TITOL', 'Titol', 'LONGVARCHAR', false, null);

		$tMap->addColumn('ACCIO', 'Accio', 'LONGVARCHAR', false, null);

		$tMap->addColumn('REACCIO', 'Reaccio', 'LONGVARCHAR', false, null);

		$tMap->addColumn('ESTAT', 'Estat', 'CHAR', false, 1);

		$tMap->addColumn('APARICIO', 'Aparicio', 'DATE', false, null);

		$tMap->addColumn('DESAPARICIO', 'Desaparicio', 'DATE', false, null);

		$tMap->addColumn('DATARESOLUCIO', 'Dataresolucio', 'TIMESTAMP', false, null);

		$tMap->addColumn('ISFETA', 'Isfeta', 'TINYINT', false, 1);

		$tMap->addColumn('ALTAREGISTRE', 'Altaregistre', 'DATE', false, null);

	} // doBuild()

} // TasquesMapBuilder
