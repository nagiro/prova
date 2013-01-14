<?php


/**
 * This class defines the structure of the 'log' table.
 *
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 01/14/13 10:14:24
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class LogTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.LogTableMap';

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
		$this->setName('log');
		$this->setPhpName('Log');
		$this->setClassname('Log');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, 11, null);
		$this->addForeignKey('USUARIID', 'Usuariid', 'INTEGER', 'usuaris', 'USUARIID', false, 11, null);
		$this->addColumn('ACCIO', 'Accio', 'VARCHAR', true, 50, null);
		$this->addColumn('MODEL', 'Model', 'VARCHAR', true, 50, null);
		$this->addColumn('DADESBEFORE', 'Dadesbefore', 'LONGVARCHAR', false, null, null);
		$this->addColumn('DADESAFTER', 'Dadesafter', 'LONGVARCHAR', false, null, null);
		$this->addColumn('DATA', 'Data', 'TIMESTAMP', false, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('Usuaris', 'Usuaris', RelationMap::MANY_TO_ONE, array('UsuariID' => 'UsuariID', ), 'SET NULL', 'CASCADE');
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

} // LogTableMap
