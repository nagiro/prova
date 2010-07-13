<?php


/**
 * This class defines the structure of the 'app_blogs_pages' table.
 *
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 07/12/10 13:49:57
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class AppBlogsPagesTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.AppBlogsPagesTableMap';

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
		$this->setName('app_blogs_pages');
		$this->setPhpName('AppBlogsPages');
		$this->setClassname('AppBlogsPages');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, 11, null);
		$this->addColumn('NAME', 'Name', 'VARCHAR', true, 40, null);
		$this->addColumn('VISIBLE', 'Visible', 'TINYINT', true, 1, null);
		$this->addColumn('DATE', 'Date', 'DATE', true, null, null);
		$this->addColumn('TYPE', 'Type', 'CHAR', true, 1, null);
		$this->addForeignKey('BLOG_ID', 'BlogId', 'INTEGER', 'app_blogs_blogs', 'ID', true, 11, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('AppBlogsBlogs', 'AppBlogsBlogs', RelationMap::MANY_TO_ONE, array('blog_id' => 'id', ), 'CASCADE', 'CASCADE');
    $this->addRelation('AppBlogsEntries', 'AppBlogsEntries', RelationMap::ONE_TO_MANY, array('id' => 'page_id', ), 'CASCADE', 'CASCADE');
    $this->addRelation('AppBlogsMenu', 'AppBlogsMenu', RelationMap::ONE_TO_MANY, array('id' => 'page_id', ), 'CASCADE', 'CASCADE');
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

} // AppBlogsPagesTableMap
