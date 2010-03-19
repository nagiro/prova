<?php


/**
 * This class adds structure of 'usuaris' table to 'propel' DatabaseMap object.
 *
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * 03/16/10 13:50:27
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class UsuarisMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.UsuarisMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(UsuarisPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(UsuarisPeer::TABLE_NAME);
		$tMap->setPhpName('Usuaris');
		$tMap->setClassname('Usuaris');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('USUARIID', 'Usuariid', 'INTEGER', true, 11);

		$tMap->addForeignKey('NIVELLS_IDNIVELLS', 'NivellsIdnivells', 'INTEGER', 'nivells', 'IDNIVELLS', false, 11);

		$tMap->addColumn('DNI', 'Dni', 'VARCHAR', false, 12);

		$tMap->addColumn('PASSWD', 'Passwd', 'VARCHAR', false, 20);

		$tMap->addColumn('NOM', 'Nom', 'VARCHAR', false, 30);

		$tMap->addColumn('COG1', 'Cog1', 'VARCHAR', false, 30);

		$tMap->addColumn('COG2', 'Cog2', 'VARCHAR', false, 30);

		$tMap->addColumn('EMAIL', 'Email', 'VARCHAR', false, 30);

		$tMap->addColumn('ADRECA', 'Adreca', 'LONGVARCHAR', false, null);

		$tMap->addColumn('CODIPOSTAL', 'Codipostal', 'INTEGER', false, 11);

		$tMap->addForeignKey('POBLACIO', 'Poblacio', 'INTEGER', 'poblacions', 'IDPOBLACIO', false, 11);

		$tMap->addColumn('POBLACIOTEXT', 'Poblaciotext', 'LONGVARCHAR', false, null);

		$tMap->addColumn('TELEFON', 'Telefon', 'LONGVARCHAR', false, null);

		$tMap->addColumn('MOBIL', 'Mobil', 'LONGVARCHAR', false, null);

		$tMap->addColumn('ENTITAT', 'Entitat', 'LONGVARCHAR', false, null);

		$tMap->addColumn('HABILITAT', 'Habilitat', 'TINYINT', false, 4);

	} // doBuild()

} // UsuarisMapBuilder
