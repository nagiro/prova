<?php


/**
 * This class defines the structure of the 'tasquescomentaris' table.
 *
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 06/17/10 13:16:30
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class TasquescomentarisTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.TasquescomentarisTableMap';

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
		$this->setName('tasquescomentaris');
		$this->setPhpName('Tasquescomentaris');
		$this->setClassname('Tasquescomentaris');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('IDTASQUESCOMENTARIS', 'Idtasquescomentaris', 'INTEGER', true, 11, null);
		$this->addForeignKey('TASQUES_TASQUESID', 'TasquesTasquesid', 'INTEGER', 'tasques', 'TASQUESID', true, 11, null);
		$this->addColumn('COMENTARI', 'Comentari', 'LONGVARCHAR', true, null, null);
		$this->addColumn('DATA_2', 'Data2', 'DATE', true, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('Tasques', 'Tasques', RelationMap::MANY_TO_ONE, array('Tasques_TasquesID' => 'TasquesID', ), 'CASCADE', 'CASCADE');
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

} // TasquescomentarisTableMap
