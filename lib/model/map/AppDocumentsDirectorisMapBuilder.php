<?php


/**
 * This class adds structure of 'app_documents_directoris' table to 'propel' DatabaseMap object.
 *
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * Fri Nov 27 14:09:31 2009
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class AppDocumentsDirectorisMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.AppDocumentsDirectorisMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(AppDocumentsDirectorisPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(AppDocumentsDirectorisPeer::TABLE_NAME);
		$tMap->setPhpName('AppDocumentsDirectoris');
		$tMap->setClassname('AppDocumentsDirectoris');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('IDDIRECTORI', 'Iddirectori', 'INTEGER', true, 11);

		$tMap->addColumn('NOM', 'Nom', 'LONGVARCHAR', true, null);

		$tMap->addForeignKey('PARE', 'Pare', 'INTEGER', 'app_documents_directoris', 'IDDIRECTORI', false, 11);

	} // doBuild()

} // AppDocumentsDirectorisMapBuilder
