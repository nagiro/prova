<?php


/**
 * This class defines the structure of the 'hospici_articles_comentaris' table.
 *
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 11/04/10 14:56:59
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class HospiciArticlesComentarisTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.HospiciArticlesComentarisTableMap';

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
		$this->setName('hospici_articles_comentaris');
		$this->setPhpName('HospiciArticlesComentaris');
		$this->setClassname('HospiciArticlesComentaris');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('COMENTARI_ID', 'ComentariId', 'INTEGER', true, 11, null);
		$this->addColumn('ARTICLE_ID', 'ArticleId', 'INTEGER', true, 11, null);
		$this->addColumn('QUI', 'Qui', 'LONGVARCHAR', true, null, null);
		$this->addColumn('COMENTARI', 'Comentari', 'LONGVARCHAR', true, null, null);
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

} // HospiciArticlesComentarisTableMap
