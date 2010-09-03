<?php


/**
 * This class defines the structure of the 'app_documents_permisos' table.
 *
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 09/03/10 12:35:43
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class AppDocumentsPermisosTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.AppDocumentsPermisosTableMap';

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
		$this->setName('app_documents_permisos');
		$this->setPhpName('AppDocumentsPermisos');
		$this->setClassname('AppDocumentsPermisos');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(false);
		// columns
		$this->addForeignPrimaryKey('IDUSUARI', 'Idusuari', 'INTEGER' , 'usuaris', 'USUARIID', true, 11, null);
		$this->addForeignPrimaryKey('IDARXIU', 'Idarxiu', 'INTEGER' , 'app_documents_arxius', 'IDDOCUMENT', true, 11, null);
		$this->addForeignKey('IDNIVELL', 'Idnivell', 'INTEGER', 'nivells', 'IDNIVELLS', false, 11, null);
		$this->addColumn('DATAMODIFICACIO', 'Datamodificacio', 'DATE', true, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('Usuaris', 'Usuaris', RelationMap::MANY_TO_ONE, array('idUsuari' => 'UsuariID', ), 'CASCADE', 'CASCADE');
    $this->addRelation('AppDocumentsArxius', 'AppDocumentsArxius', RelationMap::MANY_TO_ONE, array('idArxiu' => 'idDocument', ), 'CASCADE', 'CASCADE');
    $this->addRelation('Nivells', 'Nivells', RelationMap::MANY_TO_ONE, array('idNivell' => 'idNivells', ), 'SET NULL', 'SET NULL');
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

} // AppDocumentsPermisosTableMap
