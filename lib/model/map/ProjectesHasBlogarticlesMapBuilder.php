<?php


/**
 * This class adds structure of 'projectes_has_blogarticles' table to 'propel' DatabaseMap object.
 *
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * Thu Sep  3 13:08:21 2009
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class ProjectesHasBlogarticlesMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.ProjectesHasBlogarticlesMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(ProjectesHasBlogarticlesPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(ProjectesHasBlogarticlesPeer::TABLE_NAME);
		$tMap->setPhpName('ProjectesHasBlogarticles');
		$tMap->setClassname('ProjectesHasBlogarticles');

		$tMap->setUseIdGenerator(false);

		$tMap->addForeignPrimaryKey('PROJECTES_IDPROJECTES', 'ProjectesIdprojectes', 'INTEGER' , 'projectes', 'IDPROJECTES', true, 11);

		$tMap->addForeignPrimaryKey('BLOGARTICLES_ARTICLESID', 'BlogarticlesArticlesid', 'INTEGER' , 'blogarticles', 'ARTICLESID', true, 11);

	} // doBuild()

} // ProjectesHasBlogarticlesMapBuilder
