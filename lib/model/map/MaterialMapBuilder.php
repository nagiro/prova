<?php


/**
 * This class adds structure of 'material' table to 'propel' DatabaseMap object.
 *
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * Mon Sep  7 13:25:47 2009
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class MaterialMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.MaterialMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(MaterialPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(MaterialPeer::TABLE_NAME);
		$tMap->setPhpName('Material');
		$tMap->setClassname('Material');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('IDMATERIAL', 'Idmaterial', 'INTEGER', true, 11);

		$tMap->addForeignKey('MATERIALGENERIC_IDMATERIALGENERIC', 'MaterialgenericIdmaterialgeneric', 'INTEGER', 'materialgeneric', 'IDMATERIALGENERIC', true, 11);

		$tMap->addColumn('NOM', 'Nom', 'LONGVARCHAR', false, null);

		$tMap->addColumn('DESCRIPCIO', 'Descripcio', 'LONGVARCHAR', false, null);

		$tMap->addColumn('RESPONSABLE', 'Responsable', 'LONGVARCHAR', false, null);

		$tMap->addColumn('UBICACIO', 'Ubicacio', 'LONGVARCHAR', false, null);

		$tMap->addColumn('DATACOMPRA', 'Datacompra', 'DATE', false, null);

		$tMap->addColumn('IDENTIFICADOR', 'Identificador', 'LONGVARCHAR', false, null);

		$tMap->addColumn('NUMSERIE', 'Numserie', 'LONGVARCHAR', false, null);

		$tMap->addColumn('DATAGARANTIA', 'Datagarantia', 'DATE', false, null);

		$tMap->addColumn('DATAREVISIO', 'Datarevisio', 'DATE', false, null);

		$tMap->addColumn('CEDIT', 'Cedit', 'LONGVARCHAR', false, null);

		$tMap->addColumn('DATACESSIO', 'Datacessio', 'DATE', false, null);

		$tMap->addColumn('DATARETORN', 'Dataretorn', 'DATE', false, null);

		$tMap->addColumn('NUMFACTURA', 'Numfactura', 'LONGVARCHAR', false, null);

		$tMap->addColumn('PREU', 'Preu', 'INTEGER', false, 11);

		$tMap->addColumn('NOTESMANTENIMENT', 'Notesmanteniment', 'LONGVARCHAR', false, null);

		$tMap->addColumn('DATABAIXA', 'Databaixa', 'DATE', false, null);

		$tMap->addColumn('DATAREPARACIO', 'Datareparacio', 'DATE', false, null);

		$tMap->addColumn('DISPONIBLE', 'Disponible', 'TINYINT', false, 1);

		$tMap->addColumn('ALTAREGISTRE', 'Altaregistre', 'DATE', false, null);

	} // doBuild()

} // MaterialMapBuilder
