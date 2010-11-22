<?php


/**
 * This class defines the structure of the 'missatgesllistes' table.
 *
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 11/22/10 11:46:31
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class MissatgesllistesTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.MissatgesllistesTableMap';

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
		$this->setName('missatgesllistes');
		$this->setPhpName('Missatgesllistes');
		$this->setClassname('Missatgesllistes');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(false);
		// columns
		$this->addForeignPrimaryKey('IDMISSATGESLLISTES', 'Idmissatgesllistes', 'INTEGER' , 'missatgesmailing', 'IDMISSATGE', true, 11, null);
		$this->addForeignPrimaryKey('LLISTES_IDLLISTES', 'LlistesIdllistes', 'INTEGER' , 'llistes', 'IDLLISTES', true, 11, null);
		$this->addColumn('ENVIAT', 'Enviat', 'DATE', false, null, null);
		$this->addColumn('SITE_ID', 'SiteId', 'TINYINT', true, 4, null);
		$this->addColumn('ACTIU', 'Actiu', 'TINYINT', true, 1, 1);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('Missatgesmailing', 'Missatgesmailing', RelationMap::MANY_TO_ONE, array('idMissatgesLlistes' => 'idMissatge', ), 'CASCADE', 'CASCADE');
    $this->addRelation('Llistes', 'Llistes', RelationMap::MANY_TO_ONE, array('Llistes_idLlistes' => 'idLlistes', ), 'CASCADE', 'CASCADE');
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

} // MissatgesllistesTableMap
