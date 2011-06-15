<?php


/**
 * This class defines the structure of the 'missatges_emails' table.
 *
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 06/15/11 11:46:46
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class MissatgesEmailsTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.MissatgesEmailsTableMap';

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
		$this->setName('missatges_emails');
		$this->setPhpName('MissatgesEmails');
		$this->setClassname('MissatgesEmails');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(false);
		// columns
		$this->addForeignPrimaryKey('IDLLISTA', 'Idllista', 'INTEGER' , 'llistes', 'IDLLISTES', true, 11, null);
		$this->addPrimaryKey('EMAIL', 'Email', 'VARCHAR', true, 50, null);
		$this->addColumn('SITE_ID', 'SiteId', 'TINYINT', false, 4, null);
		$this->addColumn('ACTIU', 'Actiu', 'TINYINT', true, 1, 1);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('Llistes', 'Llistes', RelationMap::MANY_TO_ONE, array('idLlista' => 'idLlistes', ), 'CASCADE', 'CASCADE');
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

} // MissatgesEmailsTableMap
