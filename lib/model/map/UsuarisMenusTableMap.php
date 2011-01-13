<?php


/**
 * This class defines the structure of the 'usuaris_menus' table.
 *
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 01/13/11 10:52:32
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class UsuarisMenusTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.UsuarisMenusTableMap';

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
		$this->setName('usuaris_menus');
		$this->setPhpName('UsuarisMenus');
		$this->setClassname('UsuarisMenus');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(false);
		// columns
		$this->addForeignPrimaryKey('USUARI_ID', 'UsuariId', 'INTEGER' , 'usuaris', 'USUARIID', true, 11, null);
		$this->addForeignPrimaryKey('MENU_ID', 'MenuId', 'INTEGER' , 'gestio_menus', 'MENU_ID', true, 11, null);
		$this->addPrimaryKey('SITE_ID', 'SiteId', 'TINYINT', true, 4, null);
		$this->addForeignKey('NIVELL_ID', 'NivellId', 'INTEGER', 'nivells', 'IDNIVELLS', true, 11, null);
		$this->addColumn('ACTIU', 'Actiu', 'TINYINT', true, 1, 1);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('Usuaris', 'Usuaris', RelationMap::MANY_TO_ONE, array('usuari_id' => 'UsuariID', ), 'CASCADE', 'CASCADE');
    $this->addRelation('GestioMenus', 'GestioMenus', RelationMap::MANY_TO_ONE, array('menu_id' => 'menu_id', ), 'CASCADE', 'CASCADE');
    $this->addRelation('Nivells', 'Nivells', RelationMap::MANY_TO_ONE, array('nivell_id' => 'idNivells', ), 'CASCADE', 'CASCADE');
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

} // UsuarisMenusTableMap
