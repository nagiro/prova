<?php


/**
 * This class defines the structure of the 'cicles' table.
 *
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 11/18/10 11:15:12
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class CiclesTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.CiclesTableMap';

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
		$this->setName('cicles');
		$this->setPhpName('Cicles');
		$this->setClassname('Cicles');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('CICLEID', 'Cicleid', 'INTEGER', true, 11, null);
		$this->addColumn('NOM', 'Nom', 'LONGVARCHAR', false, null, null);
		$this->addColumn('IMATGE', 'Imatge', 'VARCHAR', true, 255, null);
		$this->addColumn('PDF', 'Pdf', 'VARCHAR', true, 255, null);
		$this->addColumn('TCURT', 'Tcurt', 'LONGVARCHAR', true, null, null);
		$this->addColumn('DCURT', 'Dcurt', 'LONGVARCHAR', true, null, null);
		$this->addColumn('TMIG', 'Tmig', 'LONGVARCHAR', true, null, null);
		$this->addColumn('DMIG', 'Dmig', 'LONGVARCHAR', true, null, null);
		$this->addColumn('TCOMPLET', 'Tcomplet', 'LONGVARCHAR', true, null, null);
		$this->addColumn('DCOMPLET', 'Dcomplet', 'LONGVARCHAR', true, null, null);
		$this->addColumn('EXTINGIT', 'Extingit', 'TINYINT', true, 1, null);
		$this->addColumn('SITE_ID', 'SiteId', 'TINYINT', false, 4, null);
		$this->addColumn('ACTIU', 'Actiu', 'TINYINT', true, 1, 1);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('Activitats', 'Activitats', RelationMap::ONE_TO_MANY, array('CicleID' => 'Cicles_CicleID', ), 'SET NULL', 'SET NULL');
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

} // CiclesTableMap
