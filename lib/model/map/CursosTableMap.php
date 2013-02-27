<?php


/**
 * This class defines the structure of the 'cursos' table.
 *
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 02/27/13 14:45:39
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class CursosTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.CursosTableMap';

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
		$this->setName('cursos');
		$this->setPhpName('Cursos');
		$this->setClassname('Cursos');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('IDCURSOS', 'Idcursos', 'INTEGER', true, 11, null);
		$this->addColumn('TITOLCURS', 'Titolcurs', 'LONGVARCHAR', false, null, null);
		$this->addColumn('ISACTIU', 'Isactiu', 'TINYINT', false, 1, 1);
		$this->addColumn('PLACES', 'Places', 'INTEGER', false, 11, null);
		$this->addColumn('CODI', 'Codi', 'LONGVARCHAR', false, null, null);
		$this->addColumn('DESCRIPCIO', 'Descripcio', 'LONGVARCHAR', false, null, null);
		$this->addColumn('PREU', 'Preu', 'INTEGER', false, 11, null);
		$this->addColumn('HORARIS', 'Horaris', 'LONGVARCHAR', false, null, null);
		$this->addColumn('CATEGORIA', 'Categoria', 'LONGVARCHAR', false, null, null);
		$this->addColumn('ORDRESORTIDA', 'Ordresortida', 'INTEGER', false, 11, null);
		$this->addColumn('DATAAPARICIO', 'Dataaparicio', 'DATE', false, null, null);
		$this->addColumn('DATADESAPARICIO', 'Datadesaparicio', 'DATE', false, null, null);
		$this->addColumn('DATAINMATRICULA', 'Datainmatricula', 'DATE', false, null, null);
		$this->addColumn('DATAFIMATRICULA', 'Datafimatricula', 'DATE', false, null, null);
		$this->addColumn('DATAINICI', 'Datainici', 'DATE', false, null, null);
		$this->addColumn('VISIBLEWEB', 'Visibleweb', 'TINYINT', true, 4, 1);
		$this->addColumn('SITE_ID', 'SiteId', 'TINYINT', false, 4, 1);
		$this->addColumn('ACTIU', 'Actiu', 'TINYINT', false, 1, 1);
		$this->addColumn('ACTIVITAT_ID', 'ActivitatId', 'INTEGER', false, 11, null);
		$this->addColumn('PDF', 'Pdf', 'LONGVARCHAR', false, null, null);
		$this->addColumn('ADESCOMPTES', 'Adescomptes', 'LONGVARCHAR', false, null, null);
		$this->addColumn('PAGAMENTEXTERN', 'Pagamentextern', 'VARCHAR', false, 50, null);
		$this->addColumn('PAGAMENTINTERN', 'Pagamentintern', 'VARCHAR', false, 50, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('Matricules', 'Matricules', RelationMap::ONE_TO_MANY, array('idCursos' => 'Cursos_idCursos', ), 'RESTRICT', 'CASCADE');
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

} // CursosTableMap
