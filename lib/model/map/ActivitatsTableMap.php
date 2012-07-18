<?php


/**
 * This class defines the structure of the 'activitats' table.
 *
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 07/17/12 11:06:30
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class ActivitatsTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.ActivitatsTableMap';

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
		$this->setName('activitats');
		$this->setPhpName('Activitats');
		$this->setClassname('Activitats');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ACTIVITATID', 'Activitatid', 'INTEGER', true, 11, null);
		$this->addForeignKey('CICLES_CICLEID', 'CiclesCicleid', 'INTEGER', 'cicles', 'CICLEID', false, 11, null);
		$this->addForeignKey('TIPUSACTIVITAT_IDTIPUSACTIVITAT', 'TipusactivitatIdtipusactivitat', 'INTEGER', 'tipusactivitat', 'IDTIPUSACTIVITAT', false, 11, null);
		$this->addColumn('NOM', 'Nom', 'LONGVARCHAR', false, null, null);
		$this->addColumn('PREU', 'Preu', 'DOUBLE', false, null, null);
		$this->addColumn('PREUREDUIT', 'Preureduit', 'DOUBLE', false, null, null);
		$this->addColumn('PUBLICABLE', 'Publicable', 'TINYINT', false, 4, null);
		$this->addColumn('ESTAT', 'Estat', 'CHAR', false, 1, null);
		$this->addColumn('DESCRIPCIO', 'Descripcio', 'LONGVARCHAR', true, null, null);
		$this->addColumn('IMATGE', 'Imatge', 'LONGVARCHAR', true, null, null);
		$this->addColumn('PDF', 'Pdf', 'LONGVARCHAR', true, null, null);
		$this->addColumn('PUBLICAWEB', 'Publicaweb', 'TINYINT', true, 1, null);
		$this->addColumn('TCURT', 'Tcurt', 'LONGVARCHAR', true, null, null);
		$this->addColumn('DCURT', 'Dcurt', 'LONGVARCHAR', true, null, null);
		$this->addColumn('TMIG', 'Tmig', 'LONGVARCHAR', true, null, null);
		$this->addColumn('DMIG', 'Dmig', 'LONGVARCHAR', true, null, null);
		$this->addColumn('TCOMPLET', 'Tcomplet', 'LONGVARCHAR', true, null, null);
		$this->addColumn('DCOMPLET', 'Dcomplet', 'LONGVARCHAR', true, null, null);
		$this->addColumn('TIPUSENVIAMENT', 'Tipusenviament', 'TINYINT', true, 4, null);
		$this->addColumn('ORGANITZADOR', 'Organitzador', 'VARCHAR', true, 250, null);
		$this->addColumn('CATEGORIES', 'Categories', 'VARCHAR', true, 100, null);
		$this->addColumn('RESPONSABLE', 'Responsable', 'LONGVARCHAR', true, null, null);
		$this->addColumn('INFOPRACTICA', 'Infopractica', 'LONGVARCHAR', true, null, null);
		$this->addColumn('SITE_ID', 'SiteId', 'TINYINT', false, 4, 1);
		$this->addColumn('ACTIU', 'Actiu', 'TINYINT', false, 1, 1);
		$this->addColumn('ISENTRADA', 'Isentrada', 'TINYINT', true, 1, 0);
		$this->addColumn('PLACES', 'Places', 'SMALLINT', false, 6, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('Cicles', 'Cicles', RelationMap::MANY_TO_ONE, array('Cicles_CicleID' => 'CicleID', ), 'RESTRICT', 'CASCADE');
    $this->addRelation('Tipusactivitat', 'Tipusactivitat', RelationMap::MANY_TO_ONE, array('TipusActivitat_idTipusActivitat' => 'idTipusActivitat', ), 'RESTRICT', 'CASCADE');
    $this->addRelation('Horaris', 'Horaris', RelationMap::ONE_TO_MANY, array('ActivitatID' => 'Activitats_ActivitatID', ), 'RESTRICT', 'CASCADE');
    $this->addRelation('Tasques', 'Tasques', RelationMap::ONE_TO_MANY, array('ActivitatID' => 'Activitats_ActivitatID', ), 'RESTRICT', 'CASCADE');
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

} // ActivitatsTableMap
