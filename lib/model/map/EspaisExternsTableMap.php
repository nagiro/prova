<?php


/**
 * This class defines the structure of the 'espais_externs' table.
 *
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 02/27/13 14:45:41
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class EspaisExternsTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.EspaisExternsTableMap';

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
		$this->setName('espais_externs');
		$this->setPhpName('EspaisExterns');
		$this->setClassname('EspaisExterns');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('IDESPAIEXTERN', 'Idespaiextern', 'INTEGER', true, 11, null);
		$this->addColumn('POBLE', 'Poble', 'INTEGER', true, 11, null);
		$this->addColumn('NOM', 'Nom', 'LONGVARCHAR', true, null, null);
		$this->addColumn('ADRECA', 'Adreca', 'LONGVARCHAR', true, null, null);
		$this->addColumn('CONTACTE', 'Contacte', 'LONGVARCHAR', true, null, null);
		$this->addColumn('ACTIU', 'Actiu', 'TINYINT', true, 1, 1);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
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

} // EspaisExternsTableMap
