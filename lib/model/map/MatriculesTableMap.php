<?php


/**
 * This class defines the structure of the 'matricules' table.
 *
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 11/04/11 12:43:58
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class MatriculesTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.MatriculesTableMap';

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
		$this->setName('matricules');
		$this->setPhpName('Matricules');
		$this->setClassname('Matricules');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('IDMATRICULES', 'Idmatricules', 'INTEGER', true, 11, null);
		$this->addForeignKey('USUARIS_USUARIID', 'UsuarisUsuariid', 'INTEGER', 'usuaris', 'USUARIID', false, 11, null);
		$this->addForeignKey('CURSOS_IDCURSOS', 'CursosIdcursos', 'INTEGER', 'cursos', 'IDCURSOS', false, 11, null);
		$this->addColumn('ESTAT', 'Estat', 'SMALLINT', false, 2, null);
		$this->addColumn('COMENTARI', 'Comentari', 'LONGVARCHAR', false, null, null);
		$this->addColumn('DATAINSCRIPCIO', 'Datainscripcio', 'TIMESTAMP', false, null, null);
		$this->addColumn('PAGAT', 'Pagat', 'DOUBLE', false, null, null);
		$this->addColumn('TREDUCCIO', 'Treduccio', 'SMALLINT', true, 2, null);
		$this->addColumn('TPAGAMENT', 'Tpagament', 'SMALLINT', true, 2, null);
		$this->addColumn('SITE_ID', 'SiteId', 'TINYINT', false, 4, 1);
		$this->addColumn('ACTIU', 'Actiu', 'TINYINT', false, 1, 1);
		$this->addColumn('TPV_OPERACIO', 'TpvOperacio', 'VARCHAR', true, 20, null);
		$this->addColumn('TPV_ORDER', 'TpvOrder', 'INTEGER', true, 11, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('Usuaris', 'Usuaris', RelationMap::MANY_TO_ONE, array('Usuaris_UsuariID' => 'UsuariID', ), 'RESTRICT', 'CASCADE');
    $this->addRelation('Cursos', 'Cursos', RelationMap::MANY_TO_ONE, array('Cursos_idCursos' => 'idCursos', ), 'RESTRICT', 'CASCADE');
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

} // MatriculesTableMap
