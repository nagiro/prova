<?php


/**
 * This class defines the structure of the 'hospici_articles' table.
 *
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 07/12/10 13:50:02
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class HospiciArticlesTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.HospiciArticlesTableMap';

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
		$this->setName('hospici_articles');
		$this->setPhpName('HospiciArticles');
		$this->setClassname('HospiciArticles');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ARTICLE_ID', 'ArticleId', 'INTEGER', true, 11, null);
		$this->addColumn('TITOL', 'Titol', 'LONGVARCHAR', true, null, null);
		$this->addColumn('TEXT', 'Text', 'LONGVARCHAR', true, null, null);
		$this->addColumn('DATA_ALTA', 'DataAlta', 'DATE', true, null, null);
		$this->addColumn('HORA_ALTA', 'HoraAlta', 'TIME', true, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
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

} // HospiciArticlesTableMap
