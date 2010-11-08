<?php


/**
 * This class defines the structure of the 'app_documents_arxius' table.
 *
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 11/08/10 11:42:54
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class AppDocumentsArxiusTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.AppDocumentsArxiusTableMap';

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
		$this->setName('app_documents_arxius');
		$this->setPhpName('AppDocumentsArxius');
		$this->setClassname('AppDocumentsArxius');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('IDDOCUMENT', 'Iddocument', 'INTEGER', true, 11, null);
		$this->addForeignKey('IDDIRECTORI', 'Iddirectori', 'INTEGER', 'app_documents_directoris', 'IDDIRECTORI', false, 11, null);
		$this->addColumn('NOM', 'Nom', 'LONGVARCHAR', true, null, null);
		$this->addColumn('URL', 'Url', 'LONGVARCHAR', true, null, null);
		$this->addColumn('DATACREACIO', 'Datacreacio', 'DATE', true, null, null);
		$this->addColumn('SITE_ID', 'SiteId', 'TINYINT', false, 4, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('AppDocumentsDirectoris', 'AppDocumentsDirectoris', RelationMap::MANY_TO_ONE, array('idDirectori' => 'idDirectori', ), 'SET NULL', 'SET NULL');
    $this->addRelation('AppDocumentsPermisos', 'AppDocumentsPermisos', RelationMap::ONE_TO_MANY, array('idDocument' => 'idArxiu', ), 'CASCADE', 'CASCADE');
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

} // AppDocumentsArxiusTableMap
