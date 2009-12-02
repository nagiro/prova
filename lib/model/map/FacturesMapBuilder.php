<?php


/**
 * This class adds structure of 'factures' table to 'propel' DatabaseMap object.
 *
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * Wed Dec  2 12:37:23 2009
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class FacturesMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.FacturesMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(FacturesPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(FacturesPeer::TABLE_NAME);
		$tMap->setPhpName('Factures');
		$tMap->setClassname('Factures');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('FACTURAID', 'Facturaid', 'INTEGER', true, 11);

		$tMap->addForeignKey('PROVEIDORS_PROVEIDORID', 'ProveidorsProveidorid', 'INTEGER', 'proveidors', 'PROVEIDORID', true, 11);

		$tMap->addForeignKey('CONCEPTES_CONCEPTEID', 'ConceptesConcepteid', 'INTEGER', 'conceptes', 'CONCEPTEID', true, 11);

		$tMap->addColumn('DATAFACTURA', 'Datafactura', 'DATE', false, null);

		$tMap->addColumn('QUANTITAT', 'Quantitat', 'DOUBLE', false, null);

		$tMap->addColumn('NUMFACTURA', 'Numfactura', 'LONGVARCHAR', false, null);

		$tMap->addColumn('DATAPAGAMENT', 'Datapagament', 'DATE', false, null);

		$tMap->addColumn('MODALITATPAGAMENT', 'Modalitatpagament', 'LONGVARCHAR', false, null);

		$tMap->addColumn('SUBCONCEPTE', 'Subconcepte', 'LONGVARCHAR', false, null);

		$tMap->addColumn('TIPUSCOMPTABLE', 'Tipuscomptable', 'LONGVARCHAR', false, null);

		$tMap->addColumn('TEXT', 'Text', 'LONGVARCHAR', false, null);

		$tMap->addForeignKey('VALIDAUSUARI', 'Validausuari', 'INTEGER', 'usuaris', 'USUARIID', false, 11);

		$tMap->addColumn('VALIDATDATA', 'Validatdata', 'DATE', false, null);

	} // doBuild()

} // FacturesMapBuilder
