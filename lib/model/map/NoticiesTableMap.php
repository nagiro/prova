<?php


/**
 * This class defines the structure of the 'noticies' table.
 *
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 09/20/10 12:08:31
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class NoticiesTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.NoticiesTableMap';

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
		$this->setName('noticies');
		$this->setPhpName('Noticies');
		$this->setClassname('Noticies');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('IDNOTICIA', 'Idnoticia', 'INTEGER', true, 11, null);
		$this->addColumn('TITOLNOTICIA', 'Titolnoticia', 'VARCHAR', false, 100, null);
		$this->addColumn('TEXTNOTICIA', 'Textnoticia', 'LONGVARCHAR', false, null, null);
		$this->addColumn('DATAPUBLICACIO', 'Datapublicacio', 'DATE', false, null, null);
		$this->addColumn('ACTIVA', 'Activa', 'TINYINT', false, 1, null);
		$this->addColumn('IMATGE', 'Imatge', 'VARCHAR', false, 255, null);
		$this->addColumn('ADJUNT', 'Adjunt', 'VARCHAR', false, 255, null);
		$this->addColumn('IDACTIVITAT', 'Idactivitat', 'INTEGER', false, 11, null);
		$this->addColumn('DATADESAPARICIO', 'Datadesaparicio', 'DATE', false, null, null);
		$this->addColumn('ORDRE', 'Ordre', 'INTEGER', true, 11, 0);
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

} // NoticiesTableMap
