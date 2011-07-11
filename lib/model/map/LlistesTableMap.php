<?php


/**
 * This class defines the structure of the 'llistes' table.
 *
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 07/08/11 10:10:22
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class LlistesTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.LlistesTableMap';

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
		$this->setName('llistes');
		$this->setPhpName('Llistes');
		$this->setClassname('Llistes');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('IDLLISTES', 'Idllistes', 'INTEGER', true, 11, null);
		$this->addColumn('NOM', 'Nom', 'LONGVARCHAR', true, null, null);
		$this->addColumn('ISACTIVA', 'Isactiva', 'TINYINT', true, 1, 1);
		$this->addColumn('SITE_ID', 'SiteId', 'TINYINT', false, 4, null);
		$this->addColumn('ACTIU', 'Actiu', 'TINYINT', true, 1, 1);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('MissatgesEmails', 'MissatgesEmails', RelationMap::ONE_TO_MANY, array('idLlistes' => 'idLlista', ), 'CASCADE', 'CASCADE');
    $this->addRelation('MissatgesUsuaris', 'MissatgesUsuaris', RelationMap::ONE_TO_MANY, array('idLlistes' => 'idLlista', ), 'CASCADE', 'CASCADE');
    $this->addRelation('Missatgesllistes', 'Missatgesllistes', RelationMap::ONE_TO_MANY, array('idLlistes' => 'Llistes_idLlistes', ), 'CASCADE', 'CASCADE');
    $this->addRelation('Usuarisllistes', 'Usuarisllistes', RelationMap::ONE_TO_MANY, array('idLlistes' => 'Llistes_idLlistes', ), 'CASCADE', 'CASCADE');
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

} // LlistesTableMap
