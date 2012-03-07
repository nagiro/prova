<?php


/**
 * This class defines the structure of the 'agendatelefonicadades' table.
 *
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 01/30/12 12:18:30
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class AgendatelefonicadadesTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.AgendatelefonicadadesTableMap';

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
		$this->setName('agendatelefonicadades');
		$this->setPhpName('Agendatelefonicadades');
		$this->setClassname('Agendatelefonicadades');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('AGENDATELEFONICADADESID', 'Agendatelefonicadadesid', 'INTEGER', true, 11, null);
		$this->addForeignKey('AGENDATELEFONICA_AGENDATELEFONICAID', 'AgendatelefonicaAgendatelefonicaid', 'INTEGER', 'agendatelefonica', 'AGENDATELEFONICAID', true, 11, null);
		$this->addColumn('TIPUS', 'Tipus', 'LONGVARCHAR', false, null, null);
		$this->addColumn('DADA', 'Dada', 'LONGVARCHAR', false, null, null);
		$this->addColumn('NOTES', 'Notes', 'LONGVARCHAR', false, null, null);
		$this->addColumn('SITE_ID', 'SiteId', 'TINYINT', false, 4, 1);
		$this->addColumn('ACTIU', 'Actiu', 'TINYINT', false, 1, 1);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('Agendatelefonica', 'Agendatelefonica', RelationMap::MANY_TO_ONE, array('AgendaTelefonica_AgendaTelefonicaID' => 'AgendaTelefonicaID', ), 'RESTRICT', 'CASCADE');
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

} // AgendatelefonicadadesTableMap
