<?php


/**
 * This class defines the structure of the 'material' table.
 *
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 09/01/10 12:19:49
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class MaterialTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.MaterialTableMap';

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
		$this->setName('material');
		$this->setPhpName('Material');
		$this->setClassname('Material');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('IDMATERIAL', 'Idmaterial', 'INTEGER', true, 11, null);
		$this->addForeignKey('MATERIALGENERIC_IDMATERIALGENERIC', 'MaterialgenericIdmaterialgeneric', 'INTEGER', 'materialgeneric', 'IDMATERIALGENERIC', true, 11, null);
		$this->addColumn('NOM', 'Nom', 'LONGVARCHAR', false, null, null);
		$this->addColumn('DESCRIPCIO', 'Descripcio', 'LONGVARCHAR', false, null, null);
		$this->addColumn('RESPONSABLE', 'Responsable', 'LONGVARCHAR', false, null, null);
		$this->addColumn('UBICACIO', 'Ubicacio', 'LONGVARCHAR', false, null, null);
		$this->addColumn('DATACOMPRA', 'Datacompra', 'DATE', false, null, null);
		$this->addColumn('IDENTIFICADOR', 'Identificador', 'LONGVARCHAR', false, null, null);
		$this->addColumn('NUMSERIE', 'Numserie', 'LONGVARCHAR', false, null, null);
		$this->addColumn('DATAGARANTIA', 'Datagarantia', 'DATE', false, null, null);
		$this->addColumn('DATAREVISIO', 'Datarevisio', 'DATE', false, null, null);
		$this->addColumn('CEDIT', 'Cedit', 'LONGVARCHAR', false, null, null);
		$this->addColumn('DATACESSIO', 'Datacessio', 'DATE', false, null, null);
		$this->addColumn('DATARETORN', 'Dataretorn', 'DATE', false, null, null);
		$this->addColumn('NUMFACTURA', 'Numfactura', 'LONGVARCHAR', false, null, null);
		$this->addColumn('PREU', 'Preu', 'INTEGER', false, 11, null);
		$this->addColumn('NOTESMANTENIMENT', 'Notesmanteniment', 'LONGVARCHAR', false, null, null);
		$this->addColumn('DATABAIXA', 'Databaixa', 'DATE', false, null, null);
		$this->addColumn('DATAREPARACIO', 'Datareparacio', 'DATE', false, null, null);
		$this->addColumn('DISPONIBLE', 'Disponible', 'TINYINT', false, 1, 1);
		$this->addColumn('ALTAREGISTRE', 'Altaregistre', 'DATE', false, null, null);
		$this->addColumn('ISTRANSFERIBLE', 'Istransferible', 'TINYINT', true, 1, null);
		$this->addColumn('ISADMINISTRATIU', 'Isadministratiu', 'TINYINT', true, 1, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('Materialgeneric', 'Materialgeneric', RelationMap::MANY_TO_ONE, array('MaterialGeneric_idMaterialGeneric' => 'idMaterialGeneric', ), 'CASCADE', 'CASCADE');
    $this->addRelation('Cessiomaterial', 'Cessiomaterial', RelationMap::ONE_TO_MANY, array('idMaterial' => 'Material_idMaterial', ), 'CASCADE', 'CASCADE');
    $this->addRelation('Horarisespais', 'Horarisespais', RelationMap::ONE_TO_MANY, array('idMaterial' => 'Material_idMaterial', ), 'CASCADE', 'CASCADE');
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

} // MaterialTableMap
