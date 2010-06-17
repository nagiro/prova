<?php


/**
 * This class defines the structure of the 'tasques' table.
 *
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 06/17/10 13:16:29
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class TasquesTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.TasquesTableMap';

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
		$this->setName('tasques');
		$this->setPhpName('Tasques');
		$this->setClassname('Tasques');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('TASQUESID', 'Tasquesid', 'INTEGER', true, 11, null);
		$this->addForeignKey('ACTIVITATS_ACTIVITATID', 'ActivitatsActivitatid', 'INTEGER', 'activitats', 'ACTIVITATID', false, 11, null);
		$this->addForeignKey('QUIMANA', 'Quimana', 'INTEGER', 'usuaris', 'USUARIID', false, 11, null);
		$this->addForeignKey('QUIFA', 'Quifa', 'INTEGER', 'usuaris', 'USUARIID', true, 11, null);
		$this->addColumn('TITOL', 'Titol', 'LONGVARCHAR', false, null, null);
		$this->addColumn('ACCIO', 'Accio', 'LONGVARCHAR', false, null, null);
		$this->addColumn('REACCIO', 'Reaccio', 'LONGVARCHAR', false, null, null);
		$this->addColumn('ESTAT', 'Estat', 'CHAR', false, 1, null);
		$this->addColumn('APARICIO', 'Aparicio', 'DATE', false, null, null);
		$this->addColumn('DESAPARICIO', 'Desaparicio', 'DATE', false, null, null);
		$this->addColumn('DATARESOLUCIO', 'Dataresolucio', 'TIMESTAMP', false, null, null);
		$this->addColumn('ISFETA', 'Isfeta', 'TINYINT', false, 1, 0);
		$this->addColumn('ALTAREGISTRE', 'Altaregistre', 'DATE', false, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('Activitats', 'Activitats', RelationMap::MANY_TO_ONE, array('Activitats_ActivitatID' => 'ActivitatID', ), 'CASCADE', 'CASCADE');
    $this->addRelation('UsuarisRelatedByQuimana', 'Usuaris', RelationMap::MANY_TO_ONE, array('QuiMana' => 'UsuariID', ), 'CASCADE', 'CASCADE');
    $this->addRelation('UsuarisRelatedByQuifa', 'Usuaris', RelationMap::MANY_TO_ONE, array('QuiFa' => 'UsuariID', ), 'CASCADE', 'CASCADE');
    $this->addRelation('Tasquescomentaris', 'Tasquescomentaris', RelationMap::ONE_TO_MANY, array('TasquesID' => 'Tasques_TasquesID', ), 'CASCADE', 'CASCADE');
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

} // TasquesTableMap
