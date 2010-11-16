<?php


/**
 * This class defines the structure of the 'app_blogs_forms_entries' table.
 *
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 11/16/10 11:46:19
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class AppBlogsFormsEntriesTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.AppBlogsFormsEntriesTableMap';

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
		$this->setName('app_blogs_forms_entries');
		$this->setPhpName('AppBlogsFormsEntries');
		$this->setClassname('AppBlogsFormsEntries');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, 11, null);
		$this->addColumn('DADES', 'Dades', 'LONGVARCHAR', true, null, null);
		$this->addColumn('DATE', 'Date', 'TIMESTAMP', true, null, null);
		$this->addForeignKey('FORM_ID', 'FormId', 'INTEGER', 'app_blogs_forms', 'ID', true, 11, null);
		$this->addColumn('ESTAT', 'Estat', 'TINYINT', true, 2, 0);
		$this->addColumn('OBJECCIONS', 'Objeccions', 'LONGVARCHAR', true, null, null);
		$this->addColumn('SITE_ID', 'SiteId', 'TINYINT', false, 4, null);
		$this->addColumn('ACTIU', 'Actiu', 'TINYINT', true, 1, 1);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('AppBlogsForms', 'AppBlogsForms', RelationMap::MANY_TO_ONE, array('form_id' => 'id', ), 'CASCADE', 'CASCADE');
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

} // AppBlogsFormsEntriesTableMap
