<?php


/**
 * This class defines the structure of the 'app_blog_multimedia_entries' table.
 *
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 06/28/12 10:57:34
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class AppBlogMultimediaEntriesTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.AppBlogMultimediaEntriesTableMap';

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
		$this->setName('app_blog_multimedia_entries');
		$this->setPhpName('AppBlogMultimediaEntries');
		$this->setClassname('AppBlogMultimediaEntries');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(false);
		// columns
		$this->addForeignPrimaryKey('ENTRIES_ID', 'EntriesId', 'INTEGER' , 'app_blogs_entries', 'ID', true, 11, null);
		$this->addForeignPrimaryKey('MULTIMEDIA_ID', 'MultimediaId', 'INTEGER' , 'app_blogs_multimedia', 'ID', true, 11, null);
		$this->addColumn('SITE_ID', 'SiteId', 'TINYINT', false, 4, 1);
		$this->addColumn('ACTIU', 'Actiu', 'TINYINT', false, 1, 1);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('AppBlogsEntries', 'AppBlogsEntries', RelationMap::MANY_TO_ONE, array('entries_id' => 'id', ), 'RESTRICT', 'CASCADE');
    $this->addRelation('AppBlogsMultimedia', 'AppBlogsMultimedia', RelationMap::MANY_TO_ONE, array('multimedia_id' => 'id', ), 'RESTRICT', 'CASCADE');
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

} // AppBlogMultimediaEntriesTableMap
