<?php


/**
 * This class defines the structure of the 'app_documents_directoris' table.
 *
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 06/07/11 13:54:18
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class AppDocumentsDirectorisTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.AppDocumentsDirectorisTableMap';

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
		$this->setName('app_documents_directoris');
		$this->setPhpName('AppDocumentsDirectoris');
		$this->setClassname('AppDocumentsDirectoris');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('IDDIRECTORI', 'Iddirectori', 'INTEGER', true, 11, null);
		$this->addColumn('NOM', 'Nom', 'LONGVARCHAR', true, null, null);
		$this->addColumn('PARE', 'Pare', 'INTEGER', false, 11, null);
		$this->addColumn('SITE_ID', 'SiteId', 'TINYINT', false, 4, null);
		$this->addColumn('ACTIU', 'Actiu', 'TINYINT', true, 1, 1);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('AppDocumentsArxius', 'AppDocumentsArxius', RelationMap::ONE_TO_MANY, array('idDirectori' => 'idDirectori', ), 'SET NULL', 'SET NULL');
    $this->addRelation('AppDocumentsPermisosDir', 'AppDocumentsPermisosDir', RelationMap::ONE_TO_MANY, array('idDirectori' => 'idDirectori', ), 'CASCADE', 'CASCADE');
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

} // AppDocumentsDirectorisTableMap
