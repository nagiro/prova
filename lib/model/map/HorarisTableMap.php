<?php


/**
 * This class defines the structure of the 'horaris' table.
 *
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 01/12/11 10:07:33
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class HorarisTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.HorarisTableMap';

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
		$this->setName('horaris');
		$this->setPhpName('Horaris');
		$this->setClassname('Horaris');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('HORARISID', 'Horarisid', 'INTEGER', true, 11, null);
		$this->addForeignKey('ACTIVITATS_ACTIVITATID', 'ActivitatsActivitatid', 'INTEGER', 'activitats', 'ACTIVITATID', true, 11, null);
		$this->addColumn('DIA', 'Dia', 'DATE', false, null, null);
		$this->addColumn('HORAINICI', 'Horainici', 'TIME', false, null, null);
		$this->addColumn('HORAFI', 'Horafi', 'TIME', false, null, null);
		$this->addColumn('HORAPRE', 'Horapre', 'TIME', false, null, null);
		$this->addColumn('HORAPOST', 'Horapost', 'TIME', false, null, null);
		$this->addColumn('AVIS', 'Avis', 'LONGVARCHAR', true, null, null);
		$this->addColumn('ESPECTADORS', 'Espectadors', 'INTEGER', true, 11, null);
		$this->addColumn('PLACES', 'Places', 'INTEGER', true, 11, null);
		$this->addColumn('TITOL', 'Titol', 'VARCHAR', true, 255, null);
		$this->addColumn('PREU', 'Preu', 'DOUBLE', true, null, null);
		$this->addColumn('PREUR', 'Preur', 'FLOAT', true, null, null);
		$this->addColumn('ESTAT', 'Estat', 'TINYINT', true, 1, null);
		$this->addColumn('RESPONSABLE', 'Responsable', 'LONGVARCHAR', true, null, null);
		$this->addColumn('SITE_ID', 'SiteId', 'TINYINT', true, 4, null);
		$this->addColumn('ACTIU', 'Actiu', 'TINYINT', true, 1, 1);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('Activitats', 'Activitats', RelationMap::MANY_TO_ONE, array('Activitats_ActivitatID' => 'ActivitatID', ), 'CASCADE', 'CASCADE');
    $this->addRelation('Horarisespais', 'Horarisespais', RelationMap::ONE_TO_MANY, array('HorarisID' => 'Horaris_HorarisID', ), 'CASCADE', 'CASCADE');
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

} // HorarisTableMap
