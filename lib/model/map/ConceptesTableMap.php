<?php


/**
 * This class defines the structure of the 'conceptes' table.
 *
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 07/08/11 10:10:17
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class ConceptesTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.ConceptesTableMap';

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
		$this->setName('conceptes');
		$this->setPhpName('Conceptes');
		$this->setClassname('Conceptes');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('CONCEPTEID', 'Concepteid', 'INTEGER', true, 11, null);
		$this->addColumn('ANY', 'Any', 'INTEGER', false, 11, null);
		$this->addColumn('CAPITOL', 'Capitol', 'LONGVARCHAR', false, null, null);
		$this->addColumn('APARTAT', 'Apartat', 'LONGVARCHAR', false, null, null);
		$this->addColumn('CONCEPTE', 'Concepte', 'LONGVARCHAR', false, null, null);
		$this->addColumn('QUANTITAT', 'Quantitat', 'DOUBLE', false, null, null);
		$this->addColumn('SITE_ID', 'SiteId', 'TINYINT', false, 4, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('Factures', 'Factures', RelationMap::ONE_TO_MANY, array('ConcepteID' => 'Conceptes_ConcepteID', ), 'CASCADE', 'CASCADE');
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

} // ConceptesTableMap
