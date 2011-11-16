<?php


/**
 * This class defines the structure of the 'proveidors' table.
 *
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 11/04/11 12:44:01
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class ProveidorsTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.ProveidorsTableMap';

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
		$this->setName('proveidors');
		$this->setPhpName('Proveidors');
		$this->setClassname('Proveidors');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('PROVEIDORID', 'Proveidorid', 'INTEGER', true, 11, null);
		$this->addColumn('NIF', 'Nif', 'VARCHAR', false, 20, null);
		$this->addColumn('NOM', 'Nom', 'LONGVARCHAR', false, null, null);
		$this->addColumn('TELEFON', 'Telefon', 'VARCHAR', false, 50, null);
		$this->addColumn('CE', 'Ce', 'VARCHAR', false, 100, null);
		$this->addColumn('CC', 'Cc', 'VARCHAR', false, 100, null);
		$this->addColumn('CP', 'Cp', 'VARCHAR', false, 100, null);
		$this->addColumn('ADRECA', 'Adreca', 'LONGVARCHAR', false, null, null);
		$this->addColumn('ALTA', 'Alta', 'DATE', false, null, null);
		$this->addColumn('CIUTAT', 'Ciutat', 'LONGVARCHAR', false, null, null);
		$this->addColumn('SITE_ID', 'SiteId', 'TINYINT', false, 4, 1);
		$this->addColumn('ACTIU', 'Actiu', 'TINYINT', false, 1, 1);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('Factures', 'Factures', RelationMap::ONE_TO_MANY, array('ProveidorID' => 'Proveidors_ProveidorID', ), 'RESTRICT', 'CASCADE');
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

} // ProveidorsTableMap
