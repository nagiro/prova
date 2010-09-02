<?php


/**
 * This class defines the structure of the 'agendatelefonica' table.
 *
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 09/02/10 11:35:46
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class AgendatelefonicaTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.AgendatelefonicaTableMap';

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
		$this->setName('agendatelefonica');
		$this->setPhpName('Agendatelefonica');
		$this->setClassname('Agendatelefonica');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('AGENDATELEFONICAID', 'Agendatelefonicaid', 'INTEGER', true, 11, null);
		$this->addColumn('NOM', 'Nom', 'VARCHAR', false, 30, null);
		$this->addColumn('NIF', 'Nif', 'VARCHAR', false, 15, null);
		$this->addColumn('DATAALTA', 'Dataalta', 'DATE', false, null, null);
		$this->addColumn('NOTES', 'Notes', 'LONGVARCHAR', false, null, null);
		$this->addColumn('TAGS', 'Tags', 'VARCHAR', false, 100, null);
		$this->addColumn('ENTITAT', 'Entitat', 'VARCHAR', false, 50, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('Agendatelefonicadades', 'Agendatelefonicadades', RelationMap::ONE_TO_MANY, array('AgendaTelefonicaID' => 'AgendaTelefonica_AgendaTelefonicaID', ), 'CASCADE', 'CASCADE');
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

} // AgendatelefonicaTableMap
