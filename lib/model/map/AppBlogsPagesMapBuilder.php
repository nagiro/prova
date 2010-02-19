<?php


/**
 * This class adds structure of 'app_blogs_pages' table to 'propel' DatabaseMap object.
 *
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * Thu Feb 18 13:50:48 2010
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class AppBlogsPagesMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.AppBlogsPagesMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(AppBlogsPagesPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(AppBlogsPagesPeer::TABLE_NAME);
		$tMap->setPhpName('AppBlogsPages');
		$tMap->setClassname('AppBlogsPages');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'INTEGER', true, 11);

		$tMap->addColumn('NAME', 'Name', 'VARCHAR', true, 40);

		$tMap->addColumn('VISIBLE', 'Visible', 'TINYINT', true, 1);

		$tMap->addColumn('DATE', 'Date', 'DATE', true, null);

		$tMap->addColumn('TYPE', 'Type', 'CHAR', true, 1);

		$tMap->addForeignKey('BLOG_ID', 'BlogId', 'INTEGER', 'app_blogs_blogs', 'ID', true, 11);

	} // doBuild()

} // AppBlogsPagesMapBuilder
