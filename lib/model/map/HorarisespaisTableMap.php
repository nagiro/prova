<?php


/**
 * This class defines the structure of the 'horarisespais' table.
 *
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 11/16/10 11:46:25
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class HorarisespaisTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.HorarisespaisTableMap';

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
		$this->setName('horarisespais');
		$this->setPhpName('Horarisespais');
		$this->setClassname('Horarisespais');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('IDHORARISESPAIS', 'Idhorarisespais', 'INTEGER', true, 11, null);
		$this->addForeignKey('MATERIAL_IDMATERIAL', 'MaterialIdmaterial', 'INTEGER', 'material', 'IDMATERIAL', false, 11, null);
		$this->addForeignKey('ESPAIS_ESPAIID', 'EspaisEspaiid', 'INTEGER', 'espais', 'ESPAIID', false, 11, null);
		$this->addForeignKey('HORARIS_HORARISID', 'HorarisHorarisid', 'INTEGER', 'horaris', 'HORARISID', false, 11, null);
		$this->addColumn('SITE_ID', 'SiteId', 'TINYINT', false, 4, null);
		$this->addColumn('ACTIU', 'Actiu', 'TINYINT', true, 1, 1);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('Material', 'Material', RelationMap::MANY_TO_ONE, array('Material_idMaterial' => 'idMaterial', ), 'CASCADE', 'CASCADE');
    $this->addRelation('Espais', 'Espais', RelationMap::MANY_TO_ONE, array('Espais_EspaiID' => 'EspaiID', ), 'CASCADE', 'CASCADE');
    $this->addRelation('Horaris', 'Horaris', RelationMap::MANY_TO_ONE, array('Horaris_HorarisID' => 'HorarisID', ), 'CASCADE', 'CASCADE');
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

} // HorarisespaisTableMap
