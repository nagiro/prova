<?php


/**
 * This class adds structure of 'matricules' table to 'propel' DatabaseMap object.
 *
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * Wed Feb  3 13:23:35 2010
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class MatriculesMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.MatriculesMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(MatriculesPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(MatriculesPeer::TABLE_NAME);
		$tMap->setPhpName('Matricules');
		$tMap->setClassname('Matricules');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('IDMATRICULES', 'Idmatricules', 'INTEGER', true, 11);

		$tMap->addForeignKey('USUARIS_USUARIID', 'UsuarisUsuariid', 'INTEGER', 'usuaris', 'USUARIID', false, 11);

		$tMap->addForeignKey('CURSOS_IDCURSOS', 'CursosIdcursos', 'INTEGER', 'cursos', 'IDCURSOS', false, 11);

		$tMap->addColumn('ESTAT', 'Estat', 'SMALLINT', false, 2);

		$tMap->addColumn('COMENTARI', 'Comentari', 'LONGVARCHAR', false, null);

		$tMap->addColumn('DATAINSCRIPCIO', 'Datainscripcio', 'TIMESTAMP', false, null);

		$tMap->addColumn('PAGAT', 'Pagat', 'DOUBLE', false, null);

		$tMap->addColumn('TREDUCCIO', 'Treduccio', 'SMALLINT', true, 2);

		$tMap->addColumn('TPAGAMENT', 'Tpagament', 'SMALLINT', true, 2);

	} // doBuild()

} // MatriculesMapBuilder
