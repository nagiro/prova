<?php


/**
 * This class adds structure of 'agendatelefonica' table to 'propel' DatabaseMap object.
 *
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * Wed Nov 25 14:28:57 2009
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class AgendatelefonicaMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.AgendatelefonicaMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(AgendatelefonicaPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(AgendatelefonicaPeer::TABLE_NAME);
		$tMap->setPhpName('Agendatelefonica');
		$tMap->setClassname('Agendatelefonica');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('AGENDATELEFONICAID', 'Agendatelefonicaid', 'INTEGER', true, 11);

		$tMap->addColumn('NOM', 'Nom', 'VARCHAR', false, 30);

		$tMap->addColumn('NIF', 'Nif', 'VARCHAR', false, 15);

		$tMap->addColumn('DATAALTA', 'Dataalta', 'DATE', false, null);

		$tMap->addColumn('NOTES', 'Notes', 'LONGVARCHAR', false, null);

		$tMap->addColumn('TAGS', 'Tags', 'VARCHAR', false, 100);

		$tMap->addColumn('ENTITAT', 'Entitat', 'VARCHAR', false, 50);

	} // doBuild()

} // AgendatelefonicaMapBuilder
