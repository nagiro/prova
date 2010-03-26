<?php


/**
 * This class adds structure of 'activitats' table to 'propel' DatabaseMap object.
 *
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * 03/24/10 13:49:02
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class ActivitatsMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.ActivitatsMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(ActivitatsPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(ActivitatsPeer::TABLE_NAME);
		$tMap->setPhpName('Activitats');
		$tMap->setClassname('Activitats');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ACTIVITATID', 'Activitatid', 'INTEGER', true, 11);

		$tMap->addForeignKey('CICLES_CICLEID', 'CiclesCicleid', 'INTEGER', 'cicles', 'CICLEID', false, 11);

		$tMap->addForeignKey('TIPUSACTIVITAT_IDTIPUSACTIVITAT', 'TipusactivitatIdtipusactivitat', 'INTEGER', 'tipusactivitat', 'IDTIPUSACTIVITAT', false, 11);

		$tMap->addColumn('NOM', 'Nom', 'LONGVARCHAR', false, null);

		$tMap->addColumn('PREU', 'Preu', 'DOUBLE', false, null);

		$tMap->addColumn('PREUREDUIT', 'Preureduit', 'DOUBLE', false, null);

		$tMap->addColumn('PUBLICABLE', 'Publicable', 'TINYINT', false, 4);

		$tMap->addColumn('ESTAT', 'Estat', 'CHAR', false, 1);

		$tMap->addColumn('DESCRIPCIO', 'Descripcio', 'LONGVARCHAR', true, null);

		$tMap->addColumn('IMATGE', 'Imatge', 'LONGVARCHAR', true, null);

		$tMap->addColumn('PDF', 'Pdf', 'LONGVARCHAR', true, null);

		$tMap->addColumn('PUBLICAWEB', 'Publicaweb', 'TINYINT', true, 1);

		$tMap->addColumn('TCURT', 'Tcurt', 'LONGVARCHAR', true, null);

		$tMap->addColumn('DCURT', 'Dcurt', 'LONGVARCHAR', true, null);

		$tMap->addColumn('TMIG', 'Tmig', 'LONGVARCHAR', true, null);

		$tMap->addColumn('DMIG', 'Dmig', 'LONGVARCHAR', true, null);

		$tMap->addColumn('TCOMPLET', 'Tcomplet', 'LONGVARCHAR', true, null);

		$tMap->addColumn('DCOMPLET', 'Dcomplet', 'LONGVARCHAR', true, null);

		$tMap->addColumn('TIPUSENVIAMENT', 'Tipusenviament', 'TINYINT', true, 4);

	} // doBuild()

} // ActivitatsMapBuilder
