<?php


/**
 * This class defines the structure of the 'hospici_agenda' table.
 *
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 02/27/13 14:45:44
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class HospiciAgendaTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.HospiciAgendaTableMap';

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
		$this->setName('hospici_agenda');
		$this->setPhpName('HospiciAgenda');
		$this->setClassname('HospiciAgenda');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('AGENDA_ID', 'AgendaId', 'INTEGER', true, 11, null);
		$this->addColumn('TITOL', 'Titol', 'LONGVARCHAR', true, null, null);
		$this->addColumn('TEXT', 'Text', 'LONGVARCHAR', true, null, null);
		$this->addColumn('DATA_INICIAL', 'DataInicial', 'DATE', true, null, null);
		$this->addColumn('DATA_FINAL', 'DataFinal', 'DATE', true, null, null);
		$this->addColumn('LLOC', 'Lloc', 'LONGVARCHAR', true, null, null);
		$this->addColumn('HORA_INICIAL', 'HoraInicial', 'TIME', true, null, null);
		$this->addColumn('HORA_FINAL', 'HoraFinal', 'TIME', true, null, null);
		$this->addColumn('LINK', 'Link', 'LONGVARCHAR', true, null, null);
		$this->addColumn('CIUTAT', 'Ciutat', 'LONGVARCHAR', true, null, null);
		$this->addColumn('RESERVA', 'Reserva', 'TINYINT', true, 1, null);
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

} // HospiciAgendaTableMap
