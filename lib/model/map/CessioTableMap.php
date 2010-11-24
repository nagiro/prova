<?php


/**
 * This class defines the structure of the 'cessio' table.
 *
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 11/24/10 11:41:12
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class CessioTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.CessioTableMap';

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
		$this->setName('cessio');
		$this->setPhpName('Cessio');
		$this->setClassname('Cessio');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('CESSIO_ID', 'CessioId', 'INTEGER', true, 11, null);
		$this->addColumn('ACTIU', 'Actiu', 'TINYINT', true, 1, 1);
		$this->addColumn('SITE_ID', 'SiteId', 'TINYINT', false, 4, null);
		$this->addColumn('USUARI_ID', 'UsuariId', 'INTEGER', false, 11, null);
		$this->addColumn('NOM', 'Nom', 'LONGVARCHAR', true, null, null);
		$this->addColumn('DNI', 'Dni', 'VARCHAR', true, 10, null);
		$this->addColumn('REPRESENTANT', 'Representant', 'VARCHAR', true, 100, null);
		$this->addColumn('MOTIU', 'Motiu', 'LONGVARCHAR', true, null, null);
		$this->addColumn('CONDICIONS', 'Condicions', 'LONGVARCHAR', true, null, null);
		$this->addColumn('MATERIAL_NO_INVENTARIAT', 'MaterialNoInventariat', 'LONGVARCHAR', true, null, null);
		$this->addColumn('DATA_CESSIO', 'DataCessio', 'DATE', true, null, null);
		$this->addColumn('DATA_RETORN', 'DataRetorn', 'DATE', true, null, null);
		$this->addColumn('ESTAT', 'Estat', 'LONGVARCHAR', true, null, null);
		$this->addColumn('RETORNAT', 'Retornat', 'TINYINT', true, 1, null);
		$this->addColumn('ESTAT_RETORNAT', 'EstatRetornat', 'LONGVARCHAR', true, null, null);
		$this->addColumn('DATA_RETORNAT', 'DataRetornat', 'DATE', true, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('Cessiomaterial', 'Cessiomaterial', RelationMap::ONE_TO_MANY, array('cessio_id' => 'cessio_id', ), 'CASCADE', 'CASCADE');
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

} // CessioTableMap
