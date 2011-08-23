<?php


/**
 * This class defines the structure of the 'incidencies' table.
 *
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 08/17/11 13:31:52
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class IncidenciesTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.IncidenciesTableMap';

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
		$this->setName('incidencies');
		$this->setPhpName('Incidencies');
		$this->setClassname('Incidencies');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('IDINCIDENCIA', 'Idincidencia', 'INTEGER', true, 11, null);
		$this->addForeignKey('QUIINFORMA', 'Quiinforma', 'INTEGER', 'usuaris', 'USUARIID', true, 11, null);
		$this->addForeignKey('QUIRESOL', 'Quiresol', 'INTEGER', 'usuaris', 'USUARIID', true, 11, null);
		$this->addColumn('TITOL', 'Titol', 'LONGVARCHAR', false, null, null);
		$this->addColumn('DESCRIPCIO', 'Descripcio', 'LONGVARCHAR', false, null, null);
		$this->addColumn('ESTAT', 'Estat', 'INTEGER', true, 11, null);
		$this->addColumn('DATAALTA', 'Dataalta', 'DATE', true, null, null);
		$this->addColumn('DATARESOLUCIO', 'Dataresolucio', 'DATE', false, null, null);
		$this->addColumn('SITE_ID', 'SiteId', 'TINYINT', false, 4, null);
		$this->addColumn('ACTIU', 'Actiu', 'TINYINT', true, 1, 1);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('UsuarisRelatedByQuiinforma', 'Usuaris', RelationMap::MANY_TO_ONE, array('quiinforma' => 'UsuariID', ), 'RESTRICT', 'RESTRICT');
    $this->addRelation('UsuarisRelatedByQuiresol', 'Usuaris', RelationMap::MANY_TO_ONE, array('quiresol' => 'UsuariID', ), 'RESTRICT', 'RESTRICT');
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

} // IncidenciesTableMap
