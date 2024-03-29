<?php


/**
 * This class defines the structure of the 'usuarisllistes' table.
 *
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 02/27/13 14:45:59
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class UsuarisllistesTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.UsuarisllistesTableMap';

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
		$this->setName('usuarisllistes');
		$this->setPhpName('Usuarisllistes');
		$this->setClassname('Usuarisllistes');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('IDUSUARISLLISTES', 'Idusuarisllistes', 'INTEGER', true, 11, null);
		$this->addForeignKey('LLISTES_IDLLISTES', 'LlistesIdllistes', 'INTEGER', 'llistes', 'IDLLISTES', false, 11, null);
		$this->addForeignKey('USUARIS_USUARISID', 'UsuarisUsuarisid', 'INTEGER', 'usuaris', 'USUARIID', false, 11, null);
		$this->addColumn('SITE_ID', 'SiteId', 'TINYINT', false, 4, 1);
		$this->addColumn('ACTIU', 'Actiu', 'TINYINT', false, 1, 1);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('Llistes', 'Llistes', RelationMap::MANY_TO_ONE, array('Llistes_idLlistes' => 'idLlistes', ), 'RESTRICT', 'CASCADE');
    $this->addRelation('Usuaris', 'Usuaris', RelationMap::MANY_TO_ONE, array('Usuaris_UsuarisID' => 'UsuariID', ), 'RESTRICT', 'CASCADE');
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

} // UsuarisllistesTableMap
