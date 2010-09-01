<?php


/**
 * This class defines the structure of the 'equipament' table.
 *
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 09/01/10 12:19:44
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class EquipamentTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.EquipamentTableMap';

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
		$this->setName('equipament');
		$this->setPhpName('Equipament');
		$this->setClassname('Equipament');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('EQUIPAMENTID', 'Equipamentid', 'INTEGER', true, 11, null);
		$this->addForeignKey('FACTURES_FACTURAID', 'FacturesFacturaid', 'INTEGER', 'factures', 'FACTURAID', true, 11, null);
		$this->addColumn('TIPUS', 'Tipus', 'VARCHAR', false, 100, null);
		$this->addColumn('DATACOMPRA', 'Datacompra', 'DATE', false, null, null);
		$this->addColumn('DADES', 'Dades', 'LONGVARCHAR', false, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('Factures', 'Factures', RelationMap::MANY_TO_ONE, array('Factures_FacturaID' => 'FacturaID', ), 'CASCADE', 'CASCADE');
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

} // EquipamentTableMap
