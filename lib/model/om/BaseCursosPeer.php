<?php

/**
 * Base static class for performing query and update operations on the 'cursos' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * Thu Feb 18 13:50:48 2010
 *
 * @package    lib.model.om
 */
abstract class BaseCursosPeer {

	/** the default database name for this class */
	const DATABASE_NAME = 'propel';

	/** the table name for this class */
	const TABLE_NAME = 'cursos';

	/** A class that can be returned by this peer. */
	const CLASS_DEFAULT = 'lib.model.Cursos';

	/** The total number of columns. */
	const NUM_COLUMNS = 15;

	/** The number of lazy-loaded columns. */
	const NUM_LAZY_LOAD_COLUMNS = 0;

	/** the column name for the IDCURSOS field */
	const IDCURSOS = 'cursos.IDCURSOS';

	/** the column name for the TITOLCURS field */
	const TITOLCURS = 'cursos.TITOLCURS';

	/** the column name for the ISACTIU field */
	const ISACTIU = 'cursos.ISACTIU';

	/** the column name for the PLACES field */
	const PLACES = 'cursos.PLACES';

	/** the column name for the CODI field */
	const CODI = 'cursos.CODI';

	/** the column name for the DESCRIPCIO field */
	const DESCRIPCIO = 'cursos.DESCRIPCIO';

	/** the column name for the PREU field */
	const PREU = 'cursos.PREU';

	/** the column name for the PREUR field */
	const PREUR = 'cursos.PREUR';

	/** the column name for the HORARIS field */
	const HORARIS = 'cursos.HORARIS';

	/** the column name for the CATEGORIA field */
	const CATEGORIA = 'cursos.CATEGORIA';

	/** the column name for the ORDRESORTIDA field */
	const ORDRESORTIDA = 'cursos.ORDRESORTIDA';

	/** the column name for the DATAAPARICIO field */
	const DATAAPARICIO = 'cursos.DATAAPARICIO';

	/** the column name for the DATADESAPARICIO field */
	const DATADESAPARICIO = 'cursos.DATADESAPARICIO';

	/** the column name for the DATAFIMATRICULA field */
	const DATAFIMATRICULA = 'cursos.DATAFIMATRICULA';

	/** the column name for the DATAINICI field */
	const DATAINICI = 'cursos.DATAINICI';

	/**
	 * An identiy map to hold any loaded instances of Cursos objects.
	 * This must be public so that other peer classes can access this when hydrating from JOIN
	 * queries.
	 * @var        array Cursos[]
	 */
	public static $instances = array();

	/**
	 * The MapBuilder instance for this peer.
	 * @var        MapBuilder
	 */
	private static $mapBuilder = null;

	/**
	 * holds an array of fieldnames
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
	 */
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Idcursos', 'Titolcurs', 'Isactiu', 'Places', 'Codi', 'Descripcio', 'Preu', 'Preur', 'Horaris', 'Categoria', 'Ordresortida', 'Dataaparicio', 'Datadesaparicio', 'Datafimatricula', 'Datainici', ),
		BasePeer::TYPE_STUDLYPHPNAME => array ('idcursos', 'titolcurs', 'isactiu', 'places', 'codi', 'descripcio', 'preu', 'preur', 'horaris', 'categoria', 'ordresortida', 'dataaparicio', 'datadesaparicio', 'datafimatricula', 'datainici', ),
		BasePeer::TYPE_COLNAME => array (self::IDCURSOS, self::TITOLCURS, self::ISACTIU, self::PLACES, self::CODI, self::DESCRIPCIO, self::PREU, self::PREUR, self::HORARIS, self::CATEGORIA, self::ORDRESORTIDA, self::DATAAPARICIO, self::DATADESAPARICIO, self::DATAFIMATRICULA, self::DATAINICI, ),
		BasePeer::TYPE_FIELDNAME => array ('idCursos', 'TitolCurs', 'isActiu', 'Places', 'Codi', 'Descripcio', 'Preu', 'Preur', 'Horaris', 'Categoria', 'OrdreSortida', 'DataAparicio', 'DataDesaparicio', 'DataFiMatricula', 'DataInici', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, )
	);

	/**
	 * holds an array of keys for quick access to the fieldnames array
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
	 */
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Idcursos' => 0, 'Titolcurs' => 1, 'Isactiu' => 2, 'Places' => 3, 'Codi' => 4, 'Descripcio' => 5, 'Preu' => 6, 'Preur' => 7, 'Horaris' => 8, 'Categoria' => 9, 'Ordresortida' => 10, 'Dataaparicio' => 11, 'Datadesaparicio' => 12, 'Datafimatricula' => 13, 'Datainici' => 14, ),
		BasePeer::TYPE_STUDLYPHPNAME => array ('idcursos' => 0, 'titolcurs' => 1, 'isactiu' => 2, 'places' => 3, 'codi' => 4, 'descripcio' => 5, 'preu' => 6, 'preur' => 7, 'horaris' => 8, 'categoria' => 9, 'ordresortida' => 10, 'dataaparicio' => 11, 'datadesaparicio' => 12, 'datafimatricula' => 13, 'datainici' => 14, ),
		BasePeer::TYPE_COLNAME => array (self::IDCURSOS => 0, self::TITOLCURS => 1, self::ISACTIU => 2, self::PLACES => 3, self::CODI => 4, self::DESCRIPCIO => 5, self::PREU => 6, self::PREUR => 7, self::HORARIS => 8, self::CATEGORIA => 9, self::ORDRESORTIDA => 10, self::DATAAPARICIO => 11, self::DATADESAPARICIO => 12, self::DATAFIMATRICULA => 13, self::DATAINICI => 14, ),
		BasePeer::TYPE_FIELDNAME => array ('idCursos' => 0, 'TitolCurs' => 1, 'isActiu' => 2, 'Places' => 3, 'Codi' => 4, 'Descripcio' => 5, 'Preu' => 6, 'Preur' => 7, 'Horaris' => 8, 'Categoria' => 9, 'OrdreSortida' => 10, 'DataAparicio' => 11, 'DataDesaparicio' => 12, 'DataFiMatricula' => 13, 'DataInici' => 14, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, )
	);

	/**
	 * Get a (singleton) instance of the MapBuilder for this peer class.
	 * @return     MapBuilder The map builder for this peer
	 */
	public static function getMapBuilder()
	{
		if (self::$mapBuilder === null) {
			self::$mapBuilder = new CursosMapBuilder();
		}
		return self::$mapBuilder;
	}
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
	 * @param      string $column The column name for current table. (i.e. CursosPeer::COLUMN_NAME).
	 * @return     string
	 */
	public static function alias($alias, $column)
	{
		return str_replace(CursosPeer::TABLE_NAME.'.', $alias.'.', $column);
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

		$criteria->addSelectColumn(CursosPeer::IDCURSOS);

		$criteria->addSelectColumn(CursosPeer::TITOLCURS);

		$criteria->addSelectColumn(CursosPeer::ISACTIU);

		$criteria->addSelectColumn(CursosPeer::PLACES);

		$criteria->addSelectColumn(CursosPeer::CODI);

		$criteria->addSelectColumn(CursosPeer::DESCRIPCIO);

		$criteria->addSelectColumn(CursosPeer::PREU);

		$criteria->addSelectColumn(CursosPeer::PREUR);

		$criteria->addSelectColumn(CursosPeer::HORARIS);

		$criteria->addSelectColumn(CursosPeer::CATEGORIA);

		$criteria->addSelectColumn(CursosPeer::ORDRESORTIDA);

		$criteria->addSelectColumn(CursosPeer::DATAAPARICIO);

		$criteria->addSelectColumn(CursosPeer::DATADESAPARICIO);

		$criteria->addSelectColumn(CursosPeer::DATAFIMATRICULA);

		$criteria->addSelectColumn(CursosPeer::DATAINICI);

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
		$criteria->setPrimaryTableName(CursosPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			CursosPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
		$criteria->setDbName(self::DATABASE_NAME); // Set the correct dbName

		if ($con === null) {
			$con = Propel::getConnection(CursosPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}


    foreach (sfMixer::getCallables('BaseCursosPeer:doCount:doCount') as $callable)
    {
      call_user_func($callable, 'BaseCursosPeer', $criteria, $con);
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
	 * @return     Cursos
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectOne(Criteria $criteria, PropelPDO $con = null)
	{
		$critcopy = clone $criteria;
		$critcopy->setLimit(1);
		$objects = CursosPeer::doSelect($critcopy, $con);
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
		return CursosPeer::populateObjects(CursosPeer::doSelectStmt($criteria, $con));
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

    foreach (sfMixer::getCallables('BaseCursosPeer:doSelectStmt:doSelectStmt') as $callable)
    {
      call_user_func($callable, 'BaseCursosPeer', $criteria, $con);
    }


		if ($con === null) {
			$con = Propel::getConnection(CursosPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		if (!$criteria->hasSelectClause()) {
			$criteria = clone $criteria;
			CursosPeer::addSelectColumns($criteria);
		}

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

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
	 * @param      Cursos $value A Cursos object.
	 * @param      string $key (optional) key to use for instance map (for performance boost if key was already calculated externally).
	 */
	public static function addInstanceToPool(Cursos $obj, $key = null)
	{
		if (Propel::isInstancePoolingEnabled()) {
			if ($key === null) {
				$key = (string) $obj->getIdcursos();
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
	 * @param      mixed $value A Cursos object or a primary key value.
	 */
	public static function removeInstanceFromPool($value)
	{
		if (Propel::isInstancePoolingEnabled() && $value !== null) {
			if (is_object($value) && $value instanceof Cursos) {
				$key = (string) $value->getIdcursos();
			} elseif (is_scalar($value)) {
				// assume we've been passed a primary key
				$key = (string) $value;
			} else {
				$e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or Cursos object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
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
	 * @return     Cursos Found object or NULL if 1) no instance exists for specified key or 2) instance pooling has been disabled.
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
		if ($row[$startcol + 0] === null) {
			return null;
		}
		return (string) $row[$startcol + 0];
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
		$cls = CursosPeer::getOMClass();
		$cls = substr('.'.$cls, strrpos('.'.$cls, '.') + 1);
		// populate the object(s)
		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key = CursosPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj = CursosPeer::getInstanceFromPool($key))) {
				// We no longer rehydrate the object, since this can cause data loss.
				// See http://propel.phpdb.org/trac/ticket/509
				// $obj->hydrate($row, 0, true); // rehydrate
				$results[] = $obj;
			} else {
		
				$obj = new $cls();
				$obj->hydrate($row);
				$results[] = $obj;
				CursosPeer::addInstanceToPool($obj, $key);
			} // if key exists
		}
		$stmt->closeCursor();
		return $results;
	}

  static public function getUniqueColumnNames()
  {
    return array();
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
	 * The class that the Peer will make instances of.
	 *
	 * This uses a dot-path notation which is tranalted into a path
	 * relative to a location on the PHP include_path.
	 * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
	 *
	 * @return     string path.to.ClassName
	 */
	public static function getOMClass()
	{
		return CursosPeer::CLASS_DEFAULT;
	}

	/**
	 * Method perform an INSERT on the database, given a Cursos or Criteria object.
	 *
	 * @param      mixed $values Criteria or Cursos object containing data that is used to create the INSERT statement.
	 * @param      PropelPDO $con the PropelPDO connection to use
	 * @return     mixed The new primary key.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doInsert($values, PropelPDO $con = null)
	{

    foreach (sfMixer::getCallables('BaseCursosPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseCursosPeer', $values, $con);
      if (false !== $ret)
      {
        return $ret;
      }
    }


		if ($con === null) {
			$con = Propel::getConnection(CursosPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity
		} else {
			$criteria = $values->buildCriteria(); // build Criteria from Cursos object
		}

		if ($criteria->containsKey(CursosPeer::IDCURSOS) && $criteria->keyContainsValue(CursosPeer::IDCURSOS) ) {
			throw new PropelException('Cannot insert a value for auto-increment primary key ('.CursosPeer::IDCURSOS.')');
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

		
    foreach (sfMixer::getCallables('BaseCursosPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BaseCursosPeer', $values, $con, $pk);
    }

    return $pk;
	}

	/**
	 * Method perform an UPDATE on the database, given a Cursos or Criteria object.
	 *
	 * @param      mixed $values Criteria or Cursos object containing data that is used to create the UPDATE statement.
	 * @param      PropelPDO $con The connection to use (specify PropelPDO connection object to exert more control over transactions).
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doUpdate($values, PropelPDO $con = null)
	{

    foreach (sfMixer::getCallables('BaseCursosPeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseCursosPeer', $values, $con);
      if (false !== $ret)
      {
        return $ret;
      }
    }


		if ($con === null) {
			$con = Propel::getConnection(CursosPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		$selectCriteria = new Criteria(self::DATABASE_NAME);

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity

			$comparison = $criteria->getComparison(CursosPeer::IDCURSOS);
			$selectCriteria->add(CursosPeer::IDCURSOS, $criteria->remove(CursosPeer::IDCURSOS), $comparison);

		} else { // $values is Cursos object
			$criteria = $values->buildCriteria(); // gets full criteria
			$selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
		}

		// set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BaseCursosPeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BaseCursosPeer', $values, $con, $ret);
    }

    return $ret;
  }

	/**
	 * Method to DELETE all rows from the cursos table.
	 *
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 */
	public static function doDeleteAll($con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(CursosPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		$affectedRows = 0; // initialize var to track total num of affected rows
		try {
			// use transaction because $criteria could contain info
			// for more than one table or we could emulating ON DELETE CASCADE, etc.
			$con->beginTransaction();
			$affectedRows += CursosPeer::doOnDeleteCascade(new Criteria(CursosPeer::DATABASE_NAME), $con);
			$affectedRows += BasePeer::doDeleteAll(CursosPeer::TABLE_NAME, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	/**
	 * Method perform a DELETE on the database, given a Cursos or Criteria object OR a primary key value.
	 *
	 * @param      mixed $values Criteria or Cursos object or primary key or array of primary keys
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
			$con = Propel::getConnection(CursosPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		if ($values instanceof Criteria) {
			// invalidate the cache for all objects of this type, since we have no
			// way of knowing (without running a query) what objects should be invalidated
			// from the cache based on this Criteria.
			CursosPeer::clearInstancePool();

			// rename for clarity
			$criteria = clone $values;
		} elseif ($values instanceof Cursos) {
			// invalidate the cache for this single object
			CursosPeer::removeInstanceFromPool($values);
			// create criteria based on pk values
			$criteria = $values->buildPkeyCriteria();
		} else {
			// it must be the primary key



			$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(CursosPeer::IDCURSOS, (array) $values, Criteria::IN);

			foreach ((array) $values as $singleval) {
				// we can invalidate the cache for this single object
				CursosPeer::removeInstanceFromPool($singleval);
			}
		}

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$affectedRows = 0; // initialize var to track total num of affected rows

		try {
			// use transaction because $criteria could contain info
			// for more than one table or we could emulating ON DELETE CASCADE, etc.
			$con->beginTransaction();
			$affectedRows += CursosPeer::doOnDeleteCascade($criteria, $con);
			
				// Because this db requires some delete cascade/set null emulation, we have to
				// clear the cached instance *after* the emulation has happened (since
				// instances get re-added by the select statement contained therein).
				if ($values instanceof Criteria) {
					CursosPeer::clearInstancePool();
				} else { // it's a PK or object
					CursosPeer::removeInstanceFromPool($values);
				}
			
			$affectedRows += BasePeer::doDelete($criteria, $con);

			// invalidate objects in MatriculesPeer instance pool, since one or more of them may be deleted by ON DELETE CASCADE rule.
			MatriculesPeer::clearInstancePool();

			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	/**
	 * This is a method for emulating ON DELETE CASCADE for DBs that don't support this
	 * feature (like MySQL or SQLite).
	 *
	 * This method is not very speedy because it must perform a query first to get
	 * the implicated records and then perform the deletes by calling those Peer classes.
	 *
	 * This method should be used within a transaction if possible.
	 *
	 * @param      Criteria $criteria
	 * @param      PropelPDO $con
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 */
	protected static function doOnDeleteCascade(Criteria $criteria, PropelPDO $con)
	{
		// initialize var to track total num of affected rows
		$affectedRows = 0;

		// first find the objects that are implicated by the $criteria
		$objects = CursosPeer::doSelect($criteria, $con);
		foreach ($objects as $obj) {


			// delete related Matricules objects
			$c = new Criteria(MatriculesPeer::DATABASE_NAME);
			
			$c->add(MatriculesPeer::CURSOS_IDCURSOS, $obj->getIdcursos());
			$affectedRows += MatriculesPeer::doDelete($c, $con);
		}
		return $affectedRows;
	}

	/**
	 * Validates all modified columns of given Cursos object.
	 * If parameter $columns is either a single column name or an array of column names
	 * than only those columns are validated.
	 *
	 * NOTICE: This does not apply to primary or foreign keys for now.
	 *
	 * @param      Cursos $obj The object to validate.
	 * @param      mixed $cols Column name or array of column names.
	 *
	 * @return     mixed TRUE if all columns are valid or the error message of the first invalid column.
	 */
	public static function doValidate(Cursos $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(CursosPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(CursosPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(CursosPeer::DATABASE_NAME, CursosPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = CursosPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
        }
    }

    return $res;
	}

	/**
	 * Retrieve a single object by pkey.
	 *
	 * @param      int $pk the primary key.
	 * @param      PropelPDO $con the connection to use
	 * @return     Cursos
	 */
	public static function retrieveByPK($pk, PropelPDO $con = null)
	{

		if (null !== ($obj = CursosPeer::getInstanceFromPool((string) $pk))) {
			return $obj;
		}

		if ($con === null) {
			$con = Propel::getConnection(CursosPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$criteria = new Criteria(CursosPeer::DATABASE_NAME);
		$criteria->add(CursosPeer::IDCURSOS, $pk);

		$v = CursosPeer::doSelect($criteria, $con);

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
			$con = Propel::getConnection(CursosPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$objs = null;
		if (empty($pks)) {
			$objs = array();
		} else {
			$criteria = new Criteria(CursosPeer::DATABASE_NAME);
			$criteria->add(CursosPeer::IDCURSOS, $pks, Criteria::IN);
			$objs = CursosPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} // BaseCursosPeer

// This is the static code needed to register the MapBuilder for this table with the main Propel class.
//
// NOTE: This static code cannot call methods on the CursosPeer class, because it is not defined yet.
// If you need to use overridden methods, you can add this code to the bottom of the CursosPeer class:
//
// Propel::getDatabaseMap(CursosPeer::DATABASE_NAME)->addTableBuilder(CursosPeer::TABLE_NAME, CursosPeer::getMapBuilder());
//
// Doing so will effectively overwrite the registration below.

Propel::getDatabaseMap(BaseCursosPeer::DATABASE_NAME)->addTableBuilder(BaseCursosPeer::TABLE_NAME, BaseCursosPeer::getMapBuilder());

