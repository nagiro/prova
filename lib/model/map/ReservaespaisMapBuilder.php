<?php


/**
 * This class adds structure of 'reservaespais' table to 'propel' DatabaseMap object.
 *
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * Thu Mar 11 13:07:18 2010
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class ReservaespaisMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.ReservaespaisMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(ReservaespaisPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(ReservaespaisPeer::TABLE_NAME);
		$tMap->setPhpName('Reservaespais');
		$tMap->setClassname('Reservaespais');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('RESERVAESPAIID', 'Reservaespaiid', 'INTEGER', true, 11);

		$tMap->addColumn('REPRESENTACIO', 'Representacio', 'LONGVARCHAR', false, null);

		$tMap->addColumn('RESPONSABLE', 'Responsable', 'LONGVARCHAR', false, null);

		$tMap->addColumn('PERSONALAUTORITZAT', 'Personalautoritzat', 'LONGVARCHAR', false, null);

		$tMap->addColumn('PREVISIOASSISTENTS', 'Previsioassistents', 'INTEGER', false, 11);

		$tMap->addColumn('ESCICLE', 'Escicle', 'TINYINT', false, 1);

		$tMap->addColumn('EXEMPCIO', 'Exempcio', 'TINYINT', false, 1);

		$tMap->addColumn('PRESSUPOST', 'Pressupost', 'TINYINT', false, 1);

		$tMap->addColumn('COLABORACIOCCG', 'Colaboracioccg', 'TINYINT', false, 1);

		$tMap->addColumn('COMENTARIS', 'Comentaris', 'LONGVARCHAR', false, null);

		$tMap->addColumn('ESTAT', 'Estat', 'CHAR', false, 1);

		$tMap->addForeignKey('USUARIS_USUARIID', 'UsuarisUsuariid', 'INTEGER', 'usuaris', 'USUARIID', false, 11);

		$tMap->addColumn('ORGANITZADORS', 'Organitzadors', 'LONGVARCHAR', true, null);

		$tMap->addColumn('DATAACTIVITAT', 'Dataactivitat', 'LONGVARCHAR', true, null);

		$tMap->addColumn('HORARIACTIVITAT', 'Horariactivitat', 'LONGVARCHAR', true, null);

		$tMap->addColumn('TIPUSACTE', 'Tipusacte', 'LONGVARCHAR', true, null);

		$tMap->addColumn('NOM', 'Nom', 'LONGVARCHAR', true, null);

		$tMap->addColumn('ISENREGISTRABLE', 'Isenregistrable', 'TINYINT', true, 1);

		$tMap->addColumn('ESPAISSOLICITATS', 'Espaissolicitats', 'LONGVARCHAR', true, null);

		$tMap->addColumn('MATERIALSOLICITAT', 'Materialsolicitat', 'LONGVARCHAR', true, null);

		$tMap->addColumn('DATAALTA', 'Dataalta', 'TIMESTAMP', false, null);

	} // doBuild()

} // ReservaespaisMapBuilder
