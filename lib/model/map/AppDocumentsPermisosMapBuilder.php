<?php


/**
 * This class adds structure of 'app_documents_permisos' table to 'propel' DatabaseMap object.
 *
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * 04/07/10 12:22:44
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class AppDocumentsPermisosMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.AppDocumentsPermisosMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(AppDocumentsPermisosPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(AppDocumentsPermisosPeer::TABLE_NAME);
		$tMap->setPhpName('AppDocumentsPermisos');
		$tMap->setClassname('AppDocumentsPermisos');

		$tMap->setUseIdGenerator(false);

		$tMap->addForeignPrimaryKey('IDUSUARI', 'Idusuari', 'INTEGER' , 'usuaris', 'USUARIID', true, 11);

		$tMap->addForeignPrimaryKey('IDARXIU', 'Idarxiu', 'INTEGER' , 'app_documents_arxius', 'IDDOCUMENT', true, 11);

		$tMap->addForeignKey('IDNIVELL', 'Idnivell', 'INTEGER', 'nivells', 'IDNIVELLS', false, 11);

		$tMap->addColumn('DATAMODIFICACIO', 'Datamodificacio', 'DATE', true, null);

	} // doBuild()

} // AppDocumentsPermisosMapBuilder
