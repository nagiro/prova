<?php


/**
 * This class defines the structure of the 'app_documents_permisos_dir' table.
 *
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 11/10/10 14:51:32
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class AppDocumentsPermisosDirTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.AppDocumentsPermisosDirTableMap';

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
		$this->setName('app_documents_permisos_dir');
		$this->setPhpName('AppDocumentsPermisosDir');
		$this->setClassname('AppDocumentsPermisosDir');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(false);
		// columns
		$this->addForeignPrimaryKey('IDUSUARI', 'Idusuari', 'INTEGER' , 'usuaris', 'USUARIID', true, 11, null);
		$this->addForeignPrimaryKey('IDDIRECTORI', 'Iddirectori', 'INTEGER' , 'app_documents_directoris', 'IDDIRECTORI', true, 11, null);
		$this->addForeignKey('IDNIVELL', 'Idnivell', 'INTEGER', 'nivells', 'IDNIVELLS', false, 11, null);
		$this->addColumn('SITE_ID', 'SiteId', 'TINYINT', false, 4, null);
		$this->addColumn('ACTIU', 'Actiu', 'TINYINT', true, 1, 1);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('Usuaris', 'Usuaris', RelationMap::MANY_TO_ONE, array('idUsuari' => 'UsuariID', ), 'CASCADE', 'CASCADE');
    $this->addRelation('AppDocumentsDirectoris', 'AppDocumentsDirectoris', RelationMap::MANY_TO_ONE, array('idDirectori' => 'idDirectori', ), 'CASCADE', 'CASCADE');
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

} // AppDocumentsPermisosDirTableMap
