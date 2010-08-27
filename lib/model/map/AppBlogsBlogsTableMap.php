<?php


/**
 * This class defines the structure of the 'app_blogs_blogs' table.
 *
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 08/27/10 12:14:13
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class AppBlogsBlogsTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.AppBlogsBlogsTableMap';

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
		$this->setName('app_blogs_blogs');
		$this->setPhpName('AppBlogsBlogs');
		$this->setClassname('AppBlogsBlogs');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, 11, null);
		$this->addColumn('NAME', 'Name', 'VARCHAR', true, 50, null);
		$this->addColumn('DATE', 'Date', 'DATE', true, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('AppBlogsForms', 'AppBlogsForms', RelationMap::ONE_TO_MANY, array('id' => 'blog_id', ), 'CASCADE', 'CASCADE');
    $this->addRelation('AppBlogsMenu', 'AppBlogsMenu', RelationMap::ONE_TO_MANY, array('id' => 'blog_id', ), 'CASCADE', 'CASCADE');
    $this->addRelation('AppBlogsPages', 'AppBlogsPages', RelationMap::ONE_TO_MANY, array('id' => 'blog_id', ), 'CASCADE', 'CASCADE');
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

} // AppBlogsBlogsTableMap
