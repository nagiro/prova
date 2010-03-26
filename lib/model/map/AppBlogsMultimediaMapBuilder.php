<?php


/**
 * This class adds structure of 'app_blogs_multimedia' table to 'propel' DatabaseMap object.
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
class AppBlogsMultimediaMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.AppBlogsMultimediaMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(AppBlogsMultimediaPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(AppBlogsMultimediaPeer::TABLE_NAME);
		$tMap->setPhpName('AppBlogsMultimedia');
		$tMap->setClassname('AppBlogsMultimedia');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'INTEGER', true, 11);

		$tMap->addColumn('NAME', 'Name', 'VARCHAR', true, 50);

		$tMap->addColumn('DESC', 'Desc', 'LONGVARCHAR', true, null);

		$tMap->addColumn('URL', 'Url', 'VARCHAR', true, 255);

		$tMap->addColumn('DATE', 'Date', 'DATE', true, null);

	} // doBuild()

} // AppBlogsMultimediaMapBuilder
