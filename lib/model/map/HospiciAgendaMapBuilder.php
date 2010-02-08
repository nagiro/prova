<?php


/**
 * This class adds structure of 'hospici_agenda' table to 'propel' DatabaseMap object.
 *
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * Wed Feb  3 13:23:34 2010
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class HospiciAgendaMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.HospiciAgendaMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(HospiciAgendaPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(HospiciAgendaPeer::TABLE_NAME);
		$tMap->setPhpName('HospiciAgenda');
		$tMap->setClassname('HospiciAgenda');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('AGENDA_ID', 'AgendaId', 'INTEGER', true, 11);

		$tMap->addColumn('TITOL', 'Titol', 'LONGVARCHAR', true, null);

		$tMap->addColumn('TEXT', 'Text', 'LONGVARCHAR', true, null);

		$tMap->addColumn('DATA_INICIAL', 'DataInicial', 'DATE', true, null);

		$tMap->addColumn('DATA_FINAL', 'DataFinal', 'DATE', true, null);

		$tMap->addColumn('LLOC', 'Lloc', 'LONGVARCHAR', true, null);

		$tMap->addColumn('HORA_INICIAL', 'HoraInicial', 'TIME', true, null);

		$tMap->addColumn('HORA_FINAL', 'HoraFinal', 'TIME', true, null);

		$tMap->addColumn('LINK', 'Link', 'LONGVARCHAR', true, null);

		$tMap->addColumn('CIUTAT', 'Ciutat', 'LONGVARCHAR', true, null);

		$tMap->addColumn('RESERVA', 'Reserva', 'TINYINT', true, 1);

	} // doBuild()

} // HospiciAgendaMapBuilder
