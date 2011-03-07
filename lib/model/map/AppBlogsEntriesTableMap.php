<?php


/**
 * This class defines the structure of the 'app_blogs_entries' table.
 *
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 03/01/11 13:40:45
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class AppBlogsEntriesTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.AppBlogsEntriesTableMap';

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
		$this->setName('app_blogs_entries');
		$this->setPhpName('AppBlogsEntries');
		$this->setClassname('AppBlogsEntries');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, 11, null);
		$this->addForeignKey('PAGE_ID', 'PageId', 'INTEGER', 'app_blogs_pages', 'ID', true, 11, null);
		$this->addColumn('LANG', 'Lang', 'VARCHAR', true, 4, null);
		$this->addColumn('TITLE', 'Title', 'VARCHAR', true, 255, null);
		$this->addColumn('SUBTITLE1', 'Subtitle1', 'VARCHAR', true, 100, null);
		$this->addColumn('SUBTITLE2', 'Subtitle2', 'VARCHAR', true, 100, null);
		$this->addColumn('BODY', 'Body', 'LONGVARCHAR', true, null, null);
		$this->addColumn('DATE', 'Date', 'TIMESTAMP', true, null, null);
		$this->addColumn('TAGS', 'Tags', 'VARCHAR', true, 150, null);
		$this->addColumn('URL', 'Url', 'LONGVARCHAR', true, null, null);
		$this->addColumn('SITE_ID', 'SiteId', 'TINYINT', false, 4, null);
		$this->addColumn('ACTIU', 'Actiu', 'TINYINT', true, 1, 1);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('AppBlogsPages', 'AppBlogsPages', RelationMap::MANY_TO_ONE, array('page_id' => 'id', ), 'CASCADE', 'CASCADE');
    $this->addRelation('AppBlogMultimediaEntries', 'AppBlogMultimediaEntries', RelationMap::ONE_TO_MANY, array('id' => 'entries_id', ), 'CASCADE', 'CASCADE');
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

} // AppBlogsEntriesTableMap
