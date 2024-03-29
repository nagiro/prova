<?php


/**
 * This class defines the structure of the 'factures' table.
 *
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 02/27/13 14:45:42
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class FacturesTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.FacturesTableMap';

	/**
	 * Initialize the table attributes, columns and validators
	 * Relations are not initialized by this method since they are lazy loaded
	 *
	 * @return     void
	 * @throws     PropelException
	 */
	public function initialize()
	{
	  // attributes
		$this->setName('factures');
		$this->setPhpName('Factures');
		$this->setClassname('Factures');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('FACTURAID', 'Facturaid', 'INTEGER', true, 11, null);
		$this->addForeignKey('PROVEIDORS_PROVEIDORID', 'ProveidorsProveidorid', 'INTEGER', 'proveidors', 'PROVEIDORID', true, 11, null);
		$this->addForeignKey('CONCEPTES_CONCEPTEID', 'ConceptesConcepteid', 'INTEGER', 'conceptes', 'CONCEPTEID', true, 11, null);
		$this->addColumn('DATAFACTURA', 'Datafactura', 'DATE', false, null, null);
		$this->addColumn('QUANTITAT', 'Quantitat', 'DOUBLE', false, null, null);
		$this->addColumn('NUMFACTURA', 'Numfactura', 'LONGVARCHAR', false, null, null);
		$this->addColumn('DATAPAGAMENT', 'Datapagament', 'DATE', false, null, null);
		$this->addColumn('MODALITATPAGAMENT', 'Modalitatpagament', 'LONGVARCHAR', false, null, null);
		$this->addColumn('SUBCONCEPTE', 'Subconcepte', 'LONGVARCHAR', false, null, null);
		$this->addColumn('TIPUSCOMPTABLE', 'Tipuscomptable', 'LONGVARCHAR', false, null, null);
		$this->addColumn('TEXT', 'Text', 'LONGVARCHAR', false, null, null);
		$this->addForeignKey('VALIDAUSUARI', 'Validausuari', 'INTEGER', 'usuaris', 'USUARIID', false, 11, null);
		$this->addColumn('VALIDATDATA', 'Validatdata', 'DATE', false, null, null);
		$this->addColumn('SITE_ID', 'SiteId', 'TINYINT', false, 4, 1);
		$this->addColumn('ACTIU', 'Actiu', 'TINYINT', false, 1, 1);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('Proveidors', 'Proveidors', RelationMap::MANY_TO_ONE, array('Proveidors_ProveidorID' => 'ProveidorID', ), 'RESTRICT', 'CASCADE');
    $this->addRelation('Conceptes', 'Conceptes', RelationMap::MANY_TO_ONE, array('Conceptes_ConcepteID' => 'ConcepteID', ), 'RESTRICT', 'CASCADE');
    $this->addRelation('Usuaris', 'Usuaris', RelationMap::MANY_TO_ONE, array('ValidaUsuari' => 'UsuariID', ), 'RESTRICT', 'CASCADE');
    $this->addRelation('Equipament', 'Equipament', RelationMap::ONE_TO_MANY, array('FacturaID' => 'Factures_FacturaID', ), 'RESTRICT', 'CASCADE');
	} // buildRelations()

	/**
	 * 
	 * Gets the list of behaviors registered for this table
	 * 
	 * @return array Associative array (name => parameters) of behaviors
	 */
	public function getBehaviors()
	{
		return array(
			'symfony' => array('form' => 'true', 'filter' => 'true', ),
			'symfony_behaviors' => array(),
		);
	} // getBehaviors()

} // FacturesTableMap
