<?php


/**
 * This class defines the structure of the 'reservaespais' table.
 *
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 11/04/11 12:44:02
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class ReservaespaisTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.ReservaespaisTableMap';

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
		$this->setName('reservaespais');
		$this->setPhpName('Reservaespais');
		$this->setClassname('Reservaespais');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('RESERVAESPAIID', 'Reservaespaiid', 'INTEGER', true, 11, null);
		$this->addColumn('REPRESENTACIO', 'Representacio', 'LONGVARCHAR', false, null, null);
		$this->addColumn('RESPONSABLE', 'Responsable', 'LONGVARCHAR', false, null, null);
		$this->addColumn('PERSONALAUTORITZAT', 'Personalautoritzat', 'LONGVARCHAR', false, null, null);
		$this->addColumn('PREVISIOASSISTENTS', 'Previsioassistents', 'INTEGER', false, 11, 0);
		$this->addColumn('ESCICLE', 'Escicle', 'TINYINT', false, 1, 0);
		$this->addColumn('COMENTARIS', 'Comentaris', 'LONGVARCHAR', false, null, null);
		$this->addColumn('ESTAT', 'Estat', 'CHAR', false, 1, '0');
		$this->addForeignKey('USUARIS_USUARIID', 'UsuarisUsuariid', 'INTEGER', 'usuaris', 'USUARIID', false, 11, null);
		$this->addColumn('ORGANITZADORS', 'Organitzadors', 'LONGVARCHAR', true, null, null);
		$this->addColumn('DATAACTIVITAT', 'Dataactivitat', 'LONGVARCHAR', true, null, null);
		$this->addColumn('HORARIACTIVITAT', 'Horariactivitat', 'LONGVARCHAR', true, null, null);
		$this->addColumn('TIPUSACTE', 'Tipusacte', 'LONGVARCHAR', true, null, null);
		$this->addColumn('NOM', 'Nom', 'LONGVARCHAR', true, null, null);
		$this->addColumn('ISENREGISTRABLE', 'Isenregistrable', 'TINYINT', true, 1, null);
		$this->addColumn('ESPAISSOLICITATS', 'Espaissolicitats', 'LONGVARCHAR', true, null, null);
		$this->addColumn('MATERIALSOLICITAT', 'Materialsolicitat', 'LONGVARCHAR', true, null, null);
		$this->addColumn('DATAALTA', 'Dataalta', 'TIMESTAMP', false, null, null);
		$this->addColumn('COMPROMIS', 'Compromis', 'LONGVARCHAR', true, null, null);
		$this->addColumn('CODI', 'Codi', 'VARCHAR', true, 10, null);
		$this->addColumn('CONDICIONSCCG', 'Condicionsccg', 'LONGVARCHAR', false, null, null);
		$this->addColumn('DATAACCEPTACIOCONDICIONS', 'Dataacceptaciocondicions', 'TIMESTAMP', false, null, null);
		$this->addColumn('OBSERVACIONSCONDICIONS', 'Observacionscondicions', 'LONGVARCHAR', false, null, null);
		$this->addColumn('SITE_ID', 'SiteId', 'TINYINT', false, 4, 1);
		$this->addColumn('ACTIU', 'Actiu', 'TINYINT', false, 1, 1);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('Usuaris', 'Usuaris', RelationMap::MANY_TO_ONE, array('Usuaris_usuariID' => 'UsuariID', ), 'RESTRICT', 'CASCADE');
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

} // ReservaespaisTableMap
