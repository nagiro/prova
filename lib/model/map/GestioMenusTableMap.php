<?php


/**
 * This class defines the structure of the 'gestio_menus' table.
 *
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 01/14/13 10:14:18
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class GestioMenusTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.GestioMenusTableMap';

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
		$this->setName('gestio_menus');
		$this->setPhpName('GestioMenus');
		$this->setClassname('GestioMenus');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('MENU_ID', 'MenuId', 'INTEGER', true, 11, null);
		$this->addColumn('TITOL', 'Titol', 'LONGVARCHAR', true, null, null);
		$this->addColumn('URL', 'Url', 'LONGVARCHAR', true, null, null);
		$this->addColumn('CATEGORIA', 'Categoria', 'LONGVARCHAR', true, null, null);
		$this->addColumn('ORDRE', 'Ordre', 'TINYINT', true, 4, null);
		$this->addColumn('ACTIU', 'Actiu', 'TINYINT', true, 1, null);
		$this->addColumn('TIPUS', 'Tipus', 'TINYINT', true, 1, 1);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('UsuarisMenus', 'UsuarisMenus', RelationMap::ONE_TO_MANY, array('menu_id' => 'menu_id', ), 'RESTRICT', 'CASCADE');
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

} // GestioMenusTableMap
