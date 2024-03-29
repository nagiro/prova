<?php

/**
 * Base static class for performing query and update operations on the 'entrades_reserva' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 02/27/13 14:45:40
 *
 * @package    lib.model.om
 */
abstract class BaseEntradesReservaPeer {

	/** the default database name for this class */
	const DATABASE_NAME = 'propel';

	/** the table name for this class */
	const TABLE_NAME = 'entrades_reserva';

	/** the related Propel class for this table */
	const OM_CLASS = 'EntradesReserva';

	/** A class that can be returned by this peer. */
	const CLASS_DEFAULT = 'lib.model.EntradesReserva';

	/** the related TableMap class for this table */
	const TM_CLASS = 'EntradesReservaTableMap';
	
	/** The total number of columns. */
	const NUM_COLUMNS = 18;

	/** The number of lazy-loaded columns. */
	const NUM_LAZY_LOAD_COLUMNS = 0;

	/** the column name for the IDENTRADA field */
	const IDENTRADA = 'entrades_reserva.IDENTRADA';

	/** the column name for the ENTRADES_PREUS_HORARI_ID field */
	const ENTRADES_PREUS_HORARI_ID = 'entrades_reserva.ENTRADES_PREUS_HORARI_ID';

	/** the column name for the ENTRADES_PREUS_ACTIVITAT_ID field */
	const ENTRADES_PREUS_ACTIVITAT_ID = 'entrades_reserva.ENTRADES_PREUS_ACTIVITAT_ID';

	/** the column name for the USUARI_ID field */
	const USUARI_ID = 'entrades_reserva.USUARI_ID';

	/** the column name for the NOM_RESERVA field */
	const NOM_RESERVA = 'entrades_reserva.NOM_RESERVA';

	/** the column name for the EMAIL_RESERVA field */
	const EMAIL_RESERVA = 'entrades_reserva.EMAIL_RESERVA';

	/** the column name for the TELEFON_RESERVA field */
	const TELEFON_RESERVA = 'entrades_reserva.TELEFON_RESERVA';

	/** the column name for the QUANTITAT field */
	const QUANTITAT = 'entrades_reserva.QUANTITAT';

	/** the column name for the PAGAT field */
	const PAGAT = 'entrades_reserva.PAGAT';

	/** the column name for the DATA field */
	const DATA = 'entrades_reserva.DATA';

	/** the column name for the ESTAT field */
	const ESTAT = 'entrades_reserva.ESTAT';

	/** the column name for the TIPUS_PAGAMENT field */
	const TIPUS_PAGAMENT = 'entrades_reserva.TIPUS_PAGAMENT';

	/** the column name for the ACTIU field */
	const ACTIU = 'entrades_reserva.ACTIU';

	/** the column name for the SITE_ID field */
	const SITE_ID = 'entrades_reserva.SITE_ID';

	/** the column name for the DESCOMPTE field */
	const DESCOMPTE = 'entrades_reserva.DESCOMPTE';

	/** the column name for the TPV_OPERACIO field */
	const TPV_OPERACIO = 'entrades_reserva.TPV_OPERACIO';

	/** the column name for the TPV_ORDER field */
	const TPV_ORDER = 'entrades_reserva.TPV_ORDER';

	/** the column name for the COMENTARI field */
	const COMENTARI = 'entrades_reserva.COMENTARI';

	/**
	 * An identiy map to hold any loaded instances of EntradesReserva objects.
	 * This must be public so that other peer classes can access this when hydrating from JOIN
	 * queries.
	 * @var        array EntradesReserva[]
	 */
	public static $instances = array();


	// symfony behavior
	
	/**
	 * Indicates whether the current model includes I18N.
	 */
	const IS_I18N = false;

	/**
	 * holds an array of fieldnames
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
	 */
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Identrada', 'EntradesPreusHorariId', 'EntradesPreusActivitatId', 'UsuariId', 'NomReserva', 'EmailReserva', 'TelefonReserva', 'Quantitat', 'Pagat', 'Data', 'Estat', 'TipusPagament', 'Actiu', 'SiteId', 'Descompte', 'TpvOperacio', 'TpvOrder', 'Comentari', ),
		BasePeer::TYPE_STUDLYPHPNAME => array ('identrada', 'entradesPreusHorariId', 'entradesPreusActivitatId', 'usuariId', 'nomReserva', 'emailReserva', 'telefonReserva', 'quantitat', 'pagat', 'data', 'estat', 'tipusPagament', 'actiu', 'siteId', 'descompte', 'tpvOperacio', 'tpvOrder', 'comentari', ),
		BasePeer::TYPE_COLNAME => array (self::IDENTRADA, self::ENTRADES_PREUS_HORARI_ID, self::ENTRADES_PREUS_ACTIVITAT_ID, self::USUARI_ID, self::NOM_RESERVA, self::EMAIL_RESERVA, self::TELEFON_RESERVA, self::QUANTITAT, self::PAGAT, self::DATA, self::ESTAT, self::TIPUS_PAGAMENT, self::ACTIU, self::SITE_ID, self::DESCOMPTE, self::TPV_OPERACIO, self::TPV_ORDER, self::COMENTARI, ),
		BasePeer::TYPE_FIELDNAME => array ('idEntrada', 'entrades_preus_horari_id', 'entrades_preus_activitat_id', 'usuari_id', 'nom_reserva', 'email_reserva', 'telefon_reserva', 'quantitat', 'pagat', 'data', 'estat', 'tipus_pagament', 'actiu', 'site_id', 'descompte', 'tpv_operacio', 'tpv_order', 'comentari', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, )
	);

	/**
	 * holds an array of keys for quick access to the fieldnames array
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
	 */
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Identrada' => 0, 'EntradesPreusHorariId' => 1, 'EntradesPreusActivitatId' => 2, 'UsuariId' => 3, 'NomReserva' => 4, 'EmailReserva' => 5, 'TelefonReserva' => 6, 'Quantitat' => 7, 'Pagat' => 8, 'Data' => 9, 'Estat' => 10, 'TipusPagament' => 11, 'Actiu' => 12, 'SiteId' => 13, 'Descompte' => 14, 'TpvOperacio' => 15, 'TpvOrder' => 16, 'Comentari' => 17, ),
		BasePeer::TYPE_STUDLYPHPNAME => array ('identrada' => 0, 'entradesPreusHorariId' => 1, 'entradesPreusActivitatId' => 2, 'usuariId' => 3, 'nomReserva' => 4, 'emailReserva' => 5, 'telefonReserva' => 6, 'quantitat' => 7, 'pagat' => 8, 'data' => 9, 'estat' => 10, 'tipusPagament' => 11, 'actiu' => 12, 'siteId' => 13, 'descompte' => 14, 'tpvOperacio' => 15, 'tpvOrder' => 16, 'comentari' => 17, ),
		BasePeer::TYPE_COLNAME => array (self::IDENTRADA => 0, self::ENTRADES_PREUS_HORARI_ID => 1, self::ENTRADES_PREUS_ACTIVITAT_ID => 2, self::USUARI_ID => 3, self::NOM_RESERVA => 4, self::EMAIL_RESERVA => 5, self::TELEFON_RESERVA => 6, self::QUANTITAT => 7, self::PAGAT => 8, self::DATA => 9, self::ESTAT => 10, self::TIPUS_PAGAMENT => 11, self::ACTIU => 12, self::SITE_ID => 13, self::DESCOMPTE => 14, self::TPV_OPERACIO => 15, self::TPV_ORDER => 16, self::COMENTARI => 17, ),
		BasePeer::TYPE_FIELDNAME => array ('idEntrada' => 0, 'entrades_preus_horari_id' => 1, 'entrades_preus_activitat_id' => 2, 'usuari_id' => 3, 'nom_reserva' => 4, 'email_reserva' => 5, 'telefon_reserva' => 6, 'quantitat' => 7, 'pagat' => 8, 'data' => 9, 'estat' => 10, 'tipus_pagament' => 11, 'actiu' => 12, 'site_id' => 13, 'descompte' => 14, 'tpv_operacio' => 15, 'tpv_order' => 16, 'comentari' => 17, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, )
	);

	/**
	 * Translates a fieldname to another type
	 *
	 * @param      string $name field name
	 * @param      string $fromType One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                         BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
	 * @param      string $toType   One of the class type constants
	 * @return     string translated name of the field.
	 * @throws     PropelException - if the specified name could not be found in the fieldname mappings.
	 */
	static public function translateFieldName($name, $fromType, $toType)
	{
		$toNames = self::getFieldNames($toType);
		$key = isset(self::$fieldKeys[$fromType][$name]) ? self::$fieldKeys[$fromType][$name] : null;
		if ($key === null) {
			throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(self::$fieldKeys[$fromType], true));
		}
		return $toNames[$key];
	}

	/**
	 * Returns an array of field names.
	 *
	 * @param      string $type The type of fieldnames to return:
	 *                      One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                      BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
	 * @return     array A list of field names
	 */

	static public function getFieldNames($type = BasePeer::TYPE_PHPNAME)
	{
		if (!array_key_exists($type, self::$fieldNames)) {
			throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME, BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. ' . $type . ' was given.');
		}
		return self::$fieldNames[$type];
	}

	/**
	 * Convenience method which changes table.column to alias.column.
	 *
	 * Using this method you can maintain SQL abstraction while using column aliases.
	 * <code>
	 *		$c->addAlias("alias1", TablePeer::TABLE_NAME);
	 *		$c->addJoin(TablePeer::alias("alias1", TablePeer::PRIMARY_KEY_COLUMN), TablePeer::PRIMARY_KEY_COLUMN);
	 * </code>
	 * @param      string $alias The alias for the current table.
	 * @param      string $column The column name for current table. (i.e. EntradesReservaPeer::COLUMN_NAME).
	 * @return     string
	 */
	public static function alias($alias, $column)
	{
		return str_replace(EntradesReservaPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	/**
	 * Add all the columns needed to create a new object.
	 *
	 * Note: any columns that were marked with lazyLoad="true" in the
	 * XML schema will not be added to the select list and only loaded
	 * on demand.
	 *
	 * @param      criteria object containing the columns to add.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function addSelectColumns(Criteria $criteria)
	{
		$criteria->addSelectColumn(EntradesReservaPeer::IDENTRADA);
		$criteria->addSelectColumn(EntradesReservaPeer::ENTRADES_PREUS_HORARI_ID);
		$criteria->addSelectColumn(EntradesReservaPeer::ENTRADES_PREUS_ACTIVITAT_ID);
		$criteria->addSelectColumn(EntradesReservaPeer::USUARI_ID);
		$criteria->addSelectColumn(EntradesReservaPeer::NOM_RESERVA);
		$criteria->addSelectColumn(EntradesReservaPeer::EMAIL_RESERVA);
		$criteria->addSelectColumn(EntradesReservaPeer::TELEFON_RESERVA);
		$criteria->addSelectColumn(EntradesReservaPeer::QUANTITAT);
		$criteria->addSelectColumn(EntradesReservaPeer::PAGAT);
		$criteria->addSelectColumn(EntradesReservaPeer::DATA);
		$criteria->addSelectColumn(EntradesReservaPeer::ESTAT);
		$criteria->addSelectColumn(EntradesReservaPeer::TIPUS_PAGAMENT);
		$criteria->addSelectColumn(EntradesReservaPeer::ACTIU);
		$criteria->addSelectColumn(EntradesReservaPeer::SITE_ID);
		$criteria->addSelectColumn(EntradesReservaPeer::DESCOMPTE);
		$criteria->addSelectColumn(EntradesReservaPeer::TPV_OPERACIO);
		$criteria->addSelectColumn(EntradesReservaPeer::TPV_ORDER);
		$criteria->addSelectColumn(EntradesReservaPeer::COMENTARI);
	}

	/**
	 * Returns the number of rows matching criteria.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
	 * @param      PropelPDO $con
	 * @return     int Number of matching rows.
	 */
	public static function doCount(Criteria $criteria, $distinct = false, PropelPDO $con = null)
	{
		// we may modify criteria, so copy it first
		$criteria = clone $criteria;

		// We need to set the primary table name, since in the case that there are no WHERE columns
		// it will be impossible for the BasePeer::createSelectSql() method to determine which
		// tables go into the FROM clause.
		$criteria->setPrimaryTableName(EntradesReservaPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			EntradesReservaPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
		$criteria->setDbName(self::DATABASE_NAME); // Set the correct dbName

		if ($con === null) {
			$con = Propel::getConnection(EntradesReservaPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}
		// symfony_behaviors behavior
		foreach (sfMixer::getCallables(self::getMixerPreSelectHook(__FUNCTION__)) as $sf_hook)
		{
		  call_user_func($sf_hook, 'BaseEntradesReservaPeer', $criteria, $con);
		}

		// BasePeer returns a PDOStatement
		$stmt = BasePeer::doCount($criteria, $con);

		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$count = (int) $row[0];
		} else {
			$count = 0; // no rows returned; we infer that means 0 matches.
		}
		$stmt->closeCursor();
		return $count;
	}
	/**
	 * Method to select one object from the DB.
	 *
	 * @param      Criteria $criteria object used to create the SELECT statement.
	 * @param      PropelPDO $con
	 * @return     EntradesReserva
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectOne(Criteria $criteria, PropelPDO $con = null)
	{
		$critcopy = clone $criteria;
		$critcopy->setLimit(1);
		$objects = EntradesReservaPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	/**
	 * Method to do selects.
	 *
	 * @param      Criteria $criteria The Criteria object used to build the SELECT statement.
	 * @param      PropelPDO $con
	 * @return     array Array of selected Objects
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelect(Criteria $criteria, PropelPDO $con = null)
	{
		return EntradesReservaPeer::populateObjects(EntradesReservaPeer::doSelectStmt($criteria, $con));
	}
	/**
	 * Prepares the Criteria object and uses the parent doSelect() method to execute a PDOStatement.
	 *
	 * Use this method directly if you want to work with an executed statement durirectly (for example
	 * to perform your own object hydration).
	 *
	 * @param      Criteria $criteria The Criteria object used to build the SELECT statement.
	 * @param      PropelPDO $con The connection to use
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 * @return     PDOStatement The executed PDOStatement object.
	 * @see        BasePeer::doSelect()
	 */
	public static function doSelectStmt(Criteria $criteria, PropelPDO $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(EntradesReservaPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		if (!$criteria->hasSelectClause()) {
			$criteria = clone $criteria;
			EntradesReservaPeer::addSelectColumns($criteria);
		}

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);
		// symfony_behaviors behavior
		foreach (sfMixer::getCallables(self::getMixerPreSelectHook(__FUNCTION__)) as $sf_hook)
		{
		  call_user_func($sf_hook, 'BaseEntradesReservaPeer', $criteria, $con);
		}


		// BasePeer returns a PDOStatement
		return BasePeer::doSelect($criteria, $con);
	}
	/**
	 * Adds an object to the instance pool.
	 *
	 * Propel keeps cached copies of objects in an instance pool when they are retrieved
	 * from the database.  In some cases -- especially when you override doSelect*()
	 * methods in your stub classes -- you may need to explicitly add objects
	 * to the cache in order to ensure that the same objects are always returned by doSelect*()
	 * and retrieveByPK*() calls.
	 *
	 * @param      EntradesReserva $value A EntradesReserva object.
	 * @param      string $key (optional) key to use for instance map (for performance boost if key was already calculated externally).
	 */
	public static function addInstanceToPool(EntradesReserva $obj, $key = null)
	{
		if (Propel::isInstancePoolingEnabled()) {
			if ($key === null) {
				$key = (string) $obj->getIdentrada();
			} // if key === null
			self::$instances[$key] = $obj;
		}
	}

	/**
	 * Removes an object from the instance pool.
	 *
	 * Propel keeps cached copies of objects in an instance pool when they are retrieved
	 * from the database.  In some cases -- especially when you override doDelete
	 * methods in your stub classes -- you may need to explicitly remove objects
	 * from the cache in order to prevent returning objects that no longer exist.
	 *
	 * @param      mixed $value A EntradesReserva object or a primary key value.
	 */
	public static function removeInstanceFromPool($value)
	{
		if (Propel::isInstancePoolingEnabled() && $value !== null) {
			if (is_object($value) && $value instanceof EntradesReserva) {
				$key = (string) $value->getIdentrada();
			} elseif (is_scalar($value)) {
				// assume we've been passed a primary key
				$key = (string) $value;
			} else {
				$e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or EntradesReserva object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
				throw $e;
			}

			unset(self::$instances[$key]);
		}
	} // removeInstanceFromPool()

	/**
	 * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
	 *
	 * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
	 * a multi-column primary key, a serialize()d version of the primary key will be returned.
	 *
	 * @param      string $key The key (@see getPrimaryKeyHash()) for this instance.
	 * @return     EntradesReserva Found object or NULL if 1) no instance exists for specified key or 2) instance pooling has been disabled.
	 * @see        getPrimaryKeyHash()
	 */
	public static function getInstanceFromPool($key)
	{
		if (Propel::isInstancePoolingEnabled()) {
			if (isset(self::$instances[$key])) {
				return self::$instances[$key];
			}
		}
		return null; // just to be explicit
	}
	
	/**
	 * Clear the instance pool.
	 *
	 * @return     void
	 */
	public static function clearInstancePool()
	{
		self::$instances = array();
	}
	
	/**
	 * Method to invalidate the instance pool of all tables related to entrades_reserva
	 * by a foreign key with ON DELETE CASCADE
	 */
	public static function clearRelatedInstancePool()
	{
	}

	/**
	 * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
	 *
	 * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
	 * a multi-column primary key, a serialize()d version of the primary key will be returned.
	 *
	 * @param      array $row PropelPDO resultset row.
	 * @param      int $startcol The 0-based offset for reading from the resultset row.
	 * @return     string A string version of PK or NULL if the components of primary key in result array are all null.
	 */
	public static function getPrimaryKeyHashFromRow($row, $startcol = 0)
	{
		// If the PK cannot be derived from the row, return NULL.
		if ($row[$startcol] === null) {
			return null;
		}
		return (string) $row[$startcol];
	}

	/**
	 * The returned array will contain objects of the default type or
	 * objects that inherit from the default.
	 *
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function populateObjects(PDOStatement $stmt)
	{
		$results = array();
	
		// set the class once to avoid overhead in the loop
		$cls = EntradesReservaPeer::getOMClass(false);
		// populate the object(s)
		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key = EntradesReservaPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj = EntradesReservaPeer::getInstanceFromPool($key))) {
				// We no longer rehydrate the object, since this can cause data loss.
				// See http://propel.phpdb.org/trac/ticket/509
				// $obj->hydrate($row, 0, true); // rehydrate
				$results[] = $obj;
			} else {
				$obj = new $cls();
				$obj->hydrate($row);
				$results[] = $obj;
				EntradesReservaPeer::addInstanceToPool($obj, $key);
			} // if key exists
		}
		$stmt->closeCursor();
		return $results;
	}
	/**
	 * Returns the TableMap related to this peer.
	 * This method is not needed for general use but a specific application could have a need.
	 * @return     TableMap
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function getTableMap()
	{
		return Propel::getDatabaseMap(self::DATABASE_NAME)->getTable(self::TABLE_NAME);
	}

	/**
	 * Add a TableMap instance to the database for this peer class.
	 */
	public static function buildTableMap()
	{
	  $dbMap = Propel::getDatabaseMap(BaseEntradesReservaPeer::DATABASE_NAME);
	  if (!$dbMap->hasTable(BaseEntradesReservaPeer::TABLE_NAME))
	  {
	    $dbMap->addTableObject(new EntradesReservaTableMap());
	  }
	}

	/**
	 * The class that the Peer will make instances of.
	 *
	 * If $withPrefix is true, the returned path
	 * uses a dot-path notation which is tranalted into a path
	 * relative to a location on the PHP include_path.
	 * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
	 *
	 * @param      boolean  Whether or not to return the path wit hthe class name 
	 * @return     string path.to.ClassName
	 */
	public static function getOMClass($withPrefix = true)
	{
		return $withPrefix ? EntradesReservaPeer::CLASS_DEFAULT : EntradesReservaPeer::OM_CLASS;
	}

	/**
	 * Method perform an INSERT on the database, given a EntradesReserva or Criteria object.
	 *
	 * @param      mixed $values Criteria or EntradesReserva object containing data that is used to create the INSERT statement.
	 * @param      PropelPDO $con the PropelPDO connection to use
	 * @return     mixed The new primary key.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doInsert($values, PropelPDO $con = null)
	{
    // symfony_behaviors behavior
    foreach (sfMixer::getCallables('BaseEntradesReservaPeer:doInsert:pre') as $sf_hook)
    {
      if (false !== $sf_hook_retval = call_user_func($sf_hook, 'BaseEntradesReservaPeer', $values, $con))
      {
        return $sf_hook_retval;
      }
    }

		if ($con === null) {
			$con = Propel::getConnection(EntradesReservaPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity
		} else {
			$criteria = $values->buildCriteria(); // build Criteria from EntradesReserva object
		}

		if ($criteria->containsKey(EntradesReservaPeer::IDENTRADA) && $criteria->keyContainsValue(EntradesReservaPeer::IDENTRADA) ) {
			throw new PropelException('Cannot insert a value for auto-increment primary key ('.EntradesReservaPeer::IDENTRADA.')');
		}


		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		try {
			// use transaction because $criteria could contain info
			// for more than one table (I guess, conceivably)
			$con->beginTransaction();
			$pk = BasePeer::doInsert($criteria, $con);
			$con->commit();
		} catch(PropelException $e) {
			$con->rollBack();
			throw $e;
		}

    // symfony_behaviors behavior
    foreach (sfMixer::getCallables('BaseEntradesReservaPeer:doInsert:post') as $sf_hook)
    {
      call_user_func($sf_hook, 'BaseEntradesReservaPeer', $values, $con, $pk);
    }

		return $pk;
	}

	/**
	 * Method perform an UPDATE on the database, given a EntradesReserva or Criteria object.
	 *
	 * @param      mixed $values Criteria or EntradesReserva object containing data that is used to create the UPDATE statement.
	 * @param      PropelPDO $con The connection to use (specify PropelPDO connection object to exert more control over transactions).
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doUpdate($values, PropelPDO $con = null)
	{
    // symfony_behaviors behavior
    foreach (sfMixer::getCallables('BaseEntradesReservaPeer:doUpdate:pre') as $sf_hook)
    {
      if (false !== $sf_hook_retval = call_user_func($sf_hook, 'BaseEntradesReservaPeer', $values, $con))
      {
        return $sf_hook_retval;
      }
    }

		if ($con === null) {
			$con = Propel::getConnection(EntradesReservaPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		$selectCriteria = new Criteria(self::DATABASE_NAME);

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity

			$comparison = $criteria->getComparison(EntradesReservaPeer::IDENTRADA);
			$selectCriteria->add(EntradesReservaPeer::IDENTRADA, $criteria->remove(EntradesReservaPeer::IDENTRADA), $comparison);

		} else { // $values is EntradesReserva object
			$criteria = $values->buildCriteria(); // gets full criteria
			$selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
		}

		// set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);

    // symfony_behaviors behavior
    foreach (sfMixer::getCallables('BaseEntradesReservaPeer:doUpdate:post') as $sf_hook)
    {
      call_user_func($sf_hook, 'BaseEntradesReservaPeer', $values, $con, $ret);
    }

    return $ret;
	}

	/**
	 * Method to DELETE all rows from the entrades_reserva table.
	 *
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 */
	public static function doDeleteAll($con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(EntradesReservaPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		$affectedRows = 0; // initialize var to track total num of affected rows
		try {
			// use transaction because $criteria could contain info
			// for more than one table or we could emulating ON DELETE CASCADE, etc.
			$con->beginTransaction();
			$affectedRows += BasePeer::doDeleteAll(EntradesReservaPeer::TABLE_NAME, $con);
			// Because this db requires some delete cascade/set null emulation, we have to
			// clear the cached instance *after* the emulation has happened (since
			// instances get re-added by the select statement contained therein).
			EntradesReservaPeer::clearInstancePool();
			EntradesReservaPeer::clearRelatedInstancePool();
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	/**
	 * Method perform a DELETE on the database, given a EntradesReserva or Criteria object OR a primary key value.
	 *
	 * @param      mixed $values Criteria or EntradesReserva object or primary key or array of primary keys
	 *              which is used to create the DELETE statement
	 * @param      PropelPDO $con the connection to use
	 * @return     int 	The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
	 *				if supported by native driver or if emulated using Propel.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	 public static function doDelete($values, PropelPDO $con = null)
	 {
		if ($con === null) {
			$con = Propel::getConnection(EntradesReservaPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		if ($values instanceof Criteria) {
			// invalidate the cache for all objects of this type, since we have no
			// way of knowing (without running a query) what objects should be invalidated
			// from the cache based on this Criteria.
			EntradesReservaPeer::clearInstancePool();
			// rename for clarity
			$criteria = clone $values;
		} elseif ($values instanceof EntradesReserva) { // it's a model object
			// invalidate the cache for this single object
			EntradesReservaPeer::removeInstanceFromPool($values);
			// create criteria based on pk values
			$criteria = $values->buildPkeyCriteria();
		} else { // it's a primary key, or an array of pks
			$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(EntradesReservaPeer::IDENTRADA, (array) $values, Criteria::IN);
			// invalidate the cache for this object(s)
			foreach ((array) $values as $singleval) {
				EntradesReservaPeer::removeInstanceFromPool($singleval);
			}
		}

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$affectedRows = 0; // initialize var to track total num of affected rows

		try {
			// use transaction because $criteria could contain info
			// for more than one table or we could emulating ON DELETE CASCADE, etc.
			$con->beginTransaction();
			
			$affectedRows += BasePeer::doDelete($criteria, $con);
			EntradesReservaPeer::clearRelatedInstancePool();
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	/**
	 * Validates all modified columns of given EntradesReserva object.
	 * If parameter $columns is either a single column name or an array of column names
	 * than only those columns are validated.
	 *
	 * NOTICE: This does not apply to primary or foreign keys for now.
	 *
	 * @param      EntradesReserva $obj The object to validate.
	 * @param      mixed $cols Column name or array of column names.
	 *
	 * @return     mixed TRUE if all columns are valid or the error message of the first invalid column.
	 */
	public static function doValidate(EntradesReserva $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(EntradesReservaPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(EntradesReservaPeer::TABLE_NAME);

			if (! is_array($cols)) {
				$cols = array($cols);
			}

			foreach ($cols as $colName) {
				if ($tableMap->containsColumn($colName)) {
					$get = 'get' . $tableMap->getColumn($colName)->getPhpName();
					$columns[$colName] = $obj->$get();
				}
			}
		} else {

		}

		return BasePeer::doValidate(EntradesReservaPeer::DATABASE_NAME, EntradesReservaPeer::TABLE_NAME, $columns);
	}

	/**
	 * Retrieve a single object by pkey.
	 *
	 * @param      int $pk the primary key.
	 * @param      PropelPDO $con the connection to use
	 * @return     EntradesReserva
	 */
	public static function retrieveByPK($pk, PropelPDO $con = null)
	{

		if (null !== ($obj = EntradesReservaPeer::getInstanceFromPool((string) $pk))) {
			return $obj;
		}

		if ($con === null) {
			$con = Propel::getConnection(EntradesReservaPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$criteria = new Criteria(EntradesReservaPeer::DATABASE_NAME);
		$criteria->add(EntradesReservaPeer::IDENTRADA, $pk);

		$v = EntradesReservaPeer::doSelect($criteria, $con);

		return !empty($v) > 0 ? $v[0] : null;
	}

	/**
	 * Retrieve multiple objects by pkey.
	 *
	 * @param      array $pks List of primary keys
	 * @param      PropelPDO $con the connection to use
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function retrieveByPKs($pks, PropelPDO $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(EntradesReservaPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$objs = null;
		if (empty($pks)) {
			$objs = array();
		} else {
			$criteria = new Criteria(EntradesReservaPeer::DATABASE_NAME);
			$criteria->add(EntradesReservaPeer::IDENTRADA, $pks, Criteria::IN);
			$objs = EntradesReservaPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

	// symfony behavior
	
	/**
	 * Returns an array of arrays that contain columns in each unique index.
	 *
	 * @return array
	 */
	static public function getUniqueColumnNames()
	{
	  return array();
	}

	// symfony_behaviors behavior
	
	/**
	 * Returns the name of the hook to call from inside the supplied method.
	 *
	 * @param string $method The calling method
	 *
	 * @return string A hook name for {@link sfMixer}
	 *
	 * @throws LogicException If the method name is not recognized
	 */
	static private function getMixerPreSelectHook($method)
	{
	  if (preg_match('/^do(Select|Count)(Join(All(Except)?)?|Stmt)?/', $method, $match))
	  {
	    return sprintf('BaseEntradesReservaPeer:%s:%1$s', 'Count' == $match[1] ? 'doCount' : $match[0]);
	  }
	
	  throw new LogicException(sprintf('Unrecognized function "%s"', $method));
	}

} // BaseEntradesReservaPeer

// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BaseEntradesReservaPeer::buildTableMap();

