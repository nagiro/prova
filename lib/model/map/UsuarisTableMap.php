<?php


/**
 * This class defines the structure of the 'usuaris' table.
 *
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 02/27/13 14:45:56
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class UsuarisTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.UsuarisTableMap';

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
		$this->setName('usuaris');
		$this->setPhpName('Usuaris');
		$this->setClassname('Usuaris');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('USUARIID', 'Usuariid', 'INTEGER', true, 11, null);
		$this->addForeignKey('NIVELLS_IDNIVELLS', 'NivellsIdnivells', 'INTEGER', 'nivells', 'IDNIVELLS', false, 11, null);
		$this->addColumn('DNI', 'Dni', 'VARCHAR', false, 12, null);
		$this->addColumn('PASSWD', 'Passwd', 'VARCHAR', false, 20, null);
		$this->addColumn('NOM', 'Nom', 'LONGVARCHAR', false, null, null);
		$this->addColumn('COG1', 'Cog1', 'LONGVARCHAR', false, null, null);
		$this->addColumn('COG2', 'Cog2', 'LONGVARCHAR', false, null, null);
		$this->addColumn('EMAIL', 'Email', 'LONGVARCHAR', false, null, null);
		$this->addColumn('ADRECA', 'Adreca', 'LONGVARCHAR', false, null, null);
		$this->addColumn('CODIPOSTAL', 'Codipostal', 'INTEGER', false, 11, null);
		$this->addForeignKey('POBLACIO', 'Poblacio', 'INTEGER', 'poblacions', 'IDPOBLACIO', false, 11, null);
		$this->addColumn('POBLACIOTEXT', 'Poblaciotext', 'LONGVARCHAR', false, null, null);
		$this->addColumn('TELEFON', 'Telefon', 'LONGVARCHAR', false, null, null);
		$this->addColumn('MOBIL', 'Mobil', 'LONGVARCHAR', false, null, null);
		$this->addColumn('ENTITAT', 'Entitat', 'LONGVARCHAR', false, null, null);
		$this->addColumn('HABILITAT', 'Habilitat', 'TINYINT', false, 4, null);
		$this->addColumn('ACTUALITZACIO', 'Actualitzacio', 'DATE', false, null, null);
		$this->addColumn('SITE_ID', 'SiteId', 'TINYINT', false, 4, 1);
		$this->addColumn('ACTIU', 'Actiu', 'TINYINT', false, 1, 1);
		$this->addColumn('FACEBOOK_ID', 'FacebookId', 'BIGINT', false, 20, null);
		$this->addColumn('DATA_NAIXEMENT', 'DataNaixement', 'DATE', false, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('Nivells', 'Nivells', RelationMap::MANY_TO_ONE, array('Nivells_idNivells' => 'idNivells', ), 'RESTRICT', 'SET NULL');
    $this->addRelation('Poblacions', 'Poblacions', RelationMap::MANY_TO_ONE, array('Poblacio' => 'idPoblacio', ), 'RESTRICT', 'SET NULL');
    $this->addRelation('AppDocumentsPermisos', 'AppDocumentsPermisos', RelationMap::ONE_TO_MANY, array('UsuariID' => 'idUsuari', ), 'RESTRICT', 'CASCADE');
    $this->addRelation('AppDocumentsPermisosDir', 'AppDocumentsPermisosDir', RelationMap::ONE_TO_MANY, array('UsuariID' => 'idUsuari', ), 'RESTRICT', 'CASCADE');
    $this->addRelation('Factures', 'Factures', RelationMap::ONE_TO_MANY, array('UsuariID' => 'ValidaUsuari', ), 'RESTRICT', 'CASCADE');
    $this->addRelation('IncidenciesRelatedByQuiinforma', 'Incidencies', RelationMap::ONE_TO_MANY, array('UsuariID' => 'quiinforma', ), 'RESTRICT', 'CASCADE');
    $this->addRelation('IncidenciesRelatedByQuiresol', 'Incidencies', RelationMap::ONE_TO_MANY, array('UsuariID' => 'quiresol', ), 'RESTRICT', 'CASCADE');
    $this->addRelation('Log', 'Log', RelationMap::ONE_TO_MANY, array('UsuariID' => 'UsuariID', ), 'SET NULL', 'CASCADE');
    $this->addRelation('Matricules', 'Matricules', RelationMap::ONE_TO_MANY, array('UsuariID' => 'Usuaris_UsuariID', ), 'RESTRICT', 'CASCADE');
    $this->addRelation('Missatges', 'Missatges', RelationMap::ONE_TO_MANY, array('UsuariID' => 'Usuaris_UsuariID', ), 'RESTRICT', 'CASCADE');
    $this->addRelation('PersonalRelatedByIdusuari', 'Personal', RelationMap::ONE_TO_MANY, array('UsuariID' => 'idUsuari', ), 'RESTRICT', 'CASCADE');
    $this->addRelation('PersonalRelatedByUsuariupdateid', 'Personal', RelationMap::ONE_TO_MANY, array('UsuariID' => 'usuariUpdateId', ), 'RESTRICT', 'CASCADE');
    $this->addRelation('Reservaespais', 'Reservaespais', RelationMap::ONE_TO_MANY, array('UsuariID' => 'Usuaris_usuariID', ), 'RESTRICT', 'CASCADE');
    $this->addRelation('TasquesRelatedByQuimana', 'Tasques', RelationMap::ONE_TO_MANY, array('UsuariID' => 'QuiMana', ), 'RESTRICT', 'CASCADE');
    $this->addRelation('TasquesRelatedByQuifa', 'Tasques', RelationMap::ONE_TO_MANY, array('UsuariID' => 'QuiFa', ), 'RESTRICT', 'CASCADE');
    $this->addRelation('UsuarisApps', 'UsuarisApps', RelationMap::ONE_TO_MANY, array('UsuariID' => 'usuari_id', ), 'RESTRICT', 'CASCADE');
    $this->addRelation('UsuarisMenus', 'UsuarisMenus', RelationMap::ONE_TO_MANY, array('UsuariID' => 'usuari_id', ), 'RESTRICT', 'CASCADE');
    $this->addRelation('UsuarisSites', 'UsuarisSites', RelationMap::ONE_TO_MANY, array('UsuariID' => 'usuari_id', ), 'RESTRICT', 'CASCADE');
    $this->addRelation('Usuarisllistes', 'Usuarisllistes', RelationMap::ONE_TO_MANY, array('UsuariID' => 'Usuaris_UsuarisID', ), 'RESTRICT', 'CASCADE');
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

} // UsuarisTableMap
