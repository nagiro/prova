<?php


/**
 * This class defines the structure of the 'cessiomaterial' table.
 *
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 11/10/10 14:51:33
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class CessiomaterialTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.CessiomaterialTableMap';

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
		$this->setName('cessiomaterial');
		$this->setPhpName('Cessiomaterial');
		$this->setClassname('Cessiomaterial');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('IDCESSIOMATERIAL', 'Idcessiomaterial', 'INTEGER', true, 11, null);
		$this->addForeignKey('MATERIAL_IDMATERIAL', 'MaterialIdmaterial', 'INTEGER', 'material', 'IDMATERIAL', true, 11, null);
		$this->addForeignKey('CESSIO_ID', 'CessioId', 'INTEGER', 'cessio', 'CESSIO_ID', true, 11, null);
		$this->addColumn('SITE_ID', 'SiteId', 'TINYINT', false, 4, null);
		$this->addColumn('ACTIU', 'Actiu', 'TINYINT', true, 1, 1);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('Material', 'Material', RelationMap::MANY_TO_ONE, array('Material_idMaterial' => 'idMaterial', ), 'CASCADE', 'CASCADE');
    $this->addRelation('Cessio', 'Cessio', RelationMap::MANY_TO_ONE, array('cessio_id' => 'cessio_id', ), 'CASCADE', 'CASCADE');
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

} // CessiomaterialTableMap
