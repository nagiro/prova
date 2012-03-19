<?php


/**
 * This class defines the structure of the 'entrades_reserva' table.
 *
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 03/19/12 09:27:57
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class EntradesReservaTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.EntradesReservaTableMap';

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
		$this->setName('entrades_reserva');
		$this->setPhpName('EntradesReserva');
		$this->setClassname('EntradesReserva');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('IDENTRADA', 'Identrada', 'INTEGER', true, 11, null);
		$this->addColumn('ENTRADES_PREUS_HORARI_ID', 'EntradesPreusHorariId', 'INTEGER', true, 11, 0);
		$this->addColumn('ENTRADES_PREUS_ACTIVITAT_ID', 'EntradesPreusActivitatId', 'TINYINT', true, 1, 0);
		$this->addColumn('USUARI_ID', 'UsuariId', 'INTEGER', false, 11, null);
		$this->addColumn('NOM_RESERVA', 'NomReserva', 'LONGVARCHAR', false, null, null);
		$this->addColumn('QUANTITAT', 'Quantitat', 'TINYINT', true, 2, null);
		$this->addColumn('DATA', 'Data', 'TIMESTAMP', false, null, null);
		$this->addColumn('ESTAT', 'Estat', 'SMALLINT', false, 6, null);
		$this->addColumn('ACTIU', 'Actiu', 'TINYINT', true, 1, 1);
		$this->addColumn('SITE_ID', 'SiteId', 'INTEGER', false, 11, null);
		$this->addColumn('TIPUS', 'Tipus', 'SMALLINT', false, 1, null);
		$this->addColumn('DESCOMPTE', 'Descompte', 'SMALLINT', false, 3, null);
		$this->addColumn('TPV_OPERACIO', 'TpvOperacio', 'VARCHAR', false, 20, null);
		$this->addColumn('TPV_ORDER', 'TpvOrder', 'INTEGER', false, 11, null);
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

} // EntradesReservaTableMap
