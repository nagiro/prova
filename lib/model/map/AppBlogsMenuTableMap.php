<?php


/**
 * This class defines the structure of the 'app_blogs_menu' table.
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
class AppBlogsMenuTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.AppBlogsMenuTableMap';

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
		$this->setName('app_blogs_menu');
		$this->setPhpName('AppBlogsMenu');
		$this->setClassname('AppBlogsMenu');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, 11, null);
		$this->addColumn('NAME', 'Name', 'VARCHAR', true, 50, null);
		$this->addForeignKey('PAGE_ID', 'PageId', 'INTEGER', 'app_blogs_pages', 'ID', false, 11, null);
		$this->addColumn('ORDER', 'Order', 'INTEGER', true, 11, null);
		$this->addForeignKey('BLOG_ID', 'BlogId', 'INTEGER', 'app_blogs_blogs', 'ID', true, 11, null);
		$this->addColumn('FATHER_ID', 'FatherId', 'INTEGER', true, 11, null);
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
    $this->addRelation('AppBlogsBlogs', 'AppBlogsBlogs', RelationMap::MANY_TO_ONE, array('blog_id' => 'id', ), 'CASCADE', 'CASCADE');
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

} // AppBlogsMenuTableMap
