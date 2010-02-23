<?php


/**
 * This class adds structure of 'usuaris_apps' table to 'propel' DatabaseMap object.
 *
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * Tue Feb 23 14:11:59 2010
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class UsuarisAppsMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.UsuarisAppsMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(UsuarisAppsPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(UsuarisAppsPeer::TABLE_NAME);
		$tMap->setPhpName('UsuarisApps');
		$tMap->setClassname('UsuarisApps');

		$tMap->setUseIdGenerator(false);

		$tMap->addForeignPrimaryKey('USUARI_ID', 'UsuariId', 'INTEGER' , 'usuaris', 'USUARIID', true, 11);

		$tMap->addForeignPrimaryKey('APP_ID', 'AppId', 'INTEGER' , 'apps', 'APP_ID', true, 11);

		$tMap->addForeignKey('NIVELL_ID', 'NivellId', 'INTEGER', 'nivells', 'IDNIVELLS', false, 11);

	} // doBuild()

} // UsuarisAppsMapBuilder
