<?php


/**
 * This class adds structure of 'usuarisllistes' table to 'propel' DatabaseMap object.
 *
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * Wed Feb 24 12:57:31 2010
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class UsuarisllistesMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.UsuarisllistesMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(UsuarisllistesPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(UsuarisllistesPeer::TABLE_NAME);
		$tMap->setPhpName('Usuarisllistes');
		$tMap->setClassname('Usuarisllistes');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('IDUSUARISLLISTES', 'Idusuarisllistes', 'INTEGER', true, 11);

		$tMap->addForeignKey('LLISTES_IDLLISTES', 'LlistesIdllistes', 'INTEGER', 'llistes', 'IDLLISTES', false, 11);

		$tMap->addForeignKey('USUARIS_USUARISID', 'UsuarisUsuarisid', 'INTEGER', 'usuaris', 'USUARIID', false, 11);

	} // doBuild()

} // UsuarisllistesMapBuilder
