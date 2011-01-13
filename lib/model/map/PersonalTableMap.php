<?php


/**
 * This class defines the structure of the 'personal' table.
 *
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 01/13/11 10:52:29
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class PersonalTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.PersonalTableMap';

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
		$this->setName('personal');
		$this->setPhpName('Personal');
		$this->setClassname('Personal');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('IDPERSONAL', 'Idpersonal', 'INTEGER', true, 11, null);
		$this->addForeignKey('IDUSUARI', 'Idusuari', 'INTEGER', 'usuaris', 'USUARIID', true, 11, null);
		$this->addColumn('IDDATA', 'Iddata', 'DATE', true, null, null);
		$this->addColumn('TIPUS', 'Tipus', 'TINYINT', false, 1, null);
		$this->addColumn('TEXT', 'Text', 'LONGVARCHAR', false, null, null);
		$this->addColumn('DATA_REVISIO', 'DataRevisio', 'TIMESTAMP', false, null, null);
		$this->addColumn('DATA_ALTA', 'DataAlta', 'TIMESTAMP', false, null, null);
		$this->addColumn('DATA_BAIXA', 'DataBaixa', 'DATE', false, null, null);
		$this->addForeignKey('USUARIUPDATEID', 'Usuariupdateid', 'INTEGER', 'usuaris', 'USUARIID', false, 11, null);
		$this->addColumn('SITE_ID', 'SiteId', 'TINYINT', false, 4, null);
		$this->addColumn('ACTIU', 'Actiu', 'TINYINT', true, 1, 1);
		$this->addColumn('DATA_FINALITZADA', 'DataFinalitzada', 'TIMESTAMP', false, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('UsuarisRelatedByIdusuari', 'Usuaris', RelationMap::MANY_TO_ONE, array('idUsuari' => 'UsuariID', ), 'CASCADE', 'CASCADE');
    $this->addRelation('UsuarisRelatedByUsuariupdateid', 'Usuaris', RelationMap::MANY_TO_ONE, array('usuariUpdateId' => 'UsuariID', ), 'SET NULL', 'SET NULL');
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

} // PersonalTableMap
