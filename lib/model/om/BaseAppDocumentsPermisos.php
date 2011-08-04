<?php

/**
 * Base class that represents a row from the 'app_documents_permisos' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 08/02/11 12:51:28
 *
 * @package    lib.model.om
 */
abstract class BaseAppDocumentsPermisos extends BaseObject  implements Persistent {


	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        AppDocumentsPermisosPeer
	 */
	protected static $peer;

	/**
	 * The value for the idusuari field.
	 * @var        int
	 */
	protected $idusuari;

	/**
	 * The value for the idarxiu field.
	 * @var        int
	 */
	protected $idarxiu;

	/**
	 * The value for the idnivell field.
	 * @var        int
	 */
	protected $idnivell;

	/**
	 * The value for the datamodificacio field.
	 * @var        string
	 */
	protected $datamodificacio;

	/**
	 * The value for the site_id field.
	 * @var        int
	 */
	protected $site_id;

	/**
	 * The value for the actiu field.
	 * Note: this column has a database default value of: 1
	 * @var        int
	 */
	protected $actiu;

	/**
	 * @var        Usuaris
	 */
	protected $aUsuaris;

	/**
	 * @var        AppDocumentsArxius
	 */
	protected $aAppDocumentsArxius;

	/**
	 * @var        Nivells
	 */
	protected $aNivells;

	/**
	 * Flag to prevent endless save loop, if this object is referenced
	 * by another object which falls in this transaction.
	 * @var        boolean
	 */
	protected $alreadyInSave = false;

	/**
	 * Flag to prevent endless validation loop, if this object is referenced
	 * by another object which falls in this transaction.
	 * @var        boolean
	 */
	protected $alreadyInValidation = false;

	// symfony behavior
	
	const PEER = 'AppDocumentsPermisosPeer';

	/**
	 * Applies default values to this object.
	 * This method should be called from the object's constructor (or
	 * equivalent initialization method).
	 * @see        __construct()
	 */
	public function applyDefaultValues()
	{
		$this->actiu = 1;
	}

	/**
	 * Initializes internal state of BaseAppDocumentsPermisos object.
	 * @see        applyDefaults()
	 */
	public function __construct()
	{
		parent::__construct();
		$this->applyDefaultValues();
	}

	/**
	 * Get the [idusuari] column value.
	 * 
	 * @return     int
	 */
	public function getIdusuari()
	{
		return $this->idusuari;
	}

	/**
	 * Get the [idarxiu] column value.
	 * 
	 * @return     int
	 */
	public function getIdarxiu()
	{
		return $this->idarxiu;
	}

	/**
	 * Get the [idnivell] column value.
	 * 
	 * @return     int
	 */
	public function getIdnivell()
	{
		return $this->idnivell;
	}

	/**
	 * Get the [optionally formatted] temporal [datamodificacio] column value.
	 * 
	 *
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the raw DateTime object will be returned.
	 * @return     mixed Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00
	 * @throws     PropelException - if unable to parse/validate the date/time value.
	 */
	public function getDatamodificacio($format = 'Y-m-d')
	{
		if ($this->datamodificacio === null) {
			return null;
		}


		if ($this->datamodificacio === '0000-00-00') {
			// while technically this is not a default value of NULL,
			// this seems to be closest in meaning.
			return null;
		} else {
			try {
				$dt = new DateTime($this->datamodificacio);
			} catch (Exception $x) {
				throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->datamodificacio, true), $x);
			}
		}

		if ($format === null) {
			// Because propel.useDateTimeClass is TRUE, we return a DateTime object.
			return $dt;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $dt->format('U'));
		} else {
			return $dt->format($format);
		}
	}

	/**
	 * Get the [site_id] column value.
	 * 
	 * @return     int
	 */
	public function getSiteId()
	{
		return $this->site_id;
	}

	/**
	 * Get the [actiu] column value.
	 * 
	 * @return     int
	 */
	public function getActiu()
	{
		return $this->actiu;
	}

	/**
	 * Set the value of [idusuari] column.
	 * 
	 * @param      int $v new value
	 * @return     AppDocumentsPermisos The current object (for fluent API support)
	 */
	public function setIdusuari($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->idusuari !== $v) {
			$this->idusuari = $v;
			$this->modifiedColumns[] = AppDocumentsPermisosPeer::IDUSUARI;
		}

		if ($this->aUsuaris !== null && $this->aUsuaris->getUsuariid() !== $v) {
			$this->aUsuaris = null;
		}

		return $this;
	} // setIdusuari()

	/**
	 * Set the value of [idarxiu] column.
	 * 
	 * @param      int $v new value
	 * @return     AppDocumentsPermisos The current object (for fluent API support)
	 */
	public function setIdarxiu($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->idarxiu !== $v) {
			$this->idarxiu = $v;
			$this->modifiedColumns[] = AppDocumentsPermisosPeer::IDARXIU;
		}

		if ($this->aAppDocumentsArxius !== null && $this->aAppDocumentsArxius->getIddocument() !== $v) {
			$this->aAppDocumentsArxius = null;
		}

		return $this;
	} // setIdarxiu()

	/**
	 * Set the value of [idnivell] column.
	 * 
	 * @param      int $v new value
	 * @return     AppDocumentsPermisos The current object (for fluent API support)
	 */
	public function setIdnivell($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->idnivell !== $v) {
			$this->idnivell = $v;
			$this->modifiedColumns[] = AppDocumentsPermisosPeer::IDNIVELL;
		}

		if ($this->aNivells !== null && $this->aNivells->getIdnivells() !== $v) {
			$this->aNivells = null;
		}

		return $this;
	} // setIdnivell()

	/**
	 * Sets the value of [datamodificacio] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.  Empty string will
	 *						be treated as NULL for temporal objects.
	 * @return     AppDocumentsPermisos The current object (for fluent API support)
	 */
	public function setDatamodificacio($v)
	{
		// we treat '' as NULL for temporal objects because DateTime('') == DateTime('now')
		// -- which is unexpected, to say the least.
		if ($v === null || $v === '') {
			$dt = null;
		} elseif ($v instanceof DateTime) {
			$dt = $v;
		} else {
			// some string/numeric value passed; we normalize that so that we can
			// validate it.
			try {
				if (is_numeric($v)) { // if it's a unix timestamp
					$dt = new DateTime('@'.$v, new DateTimeZone('UTC'));
					// We have to explicitly specify and then change the time zone because of a
					// DateTime bug: http://bugs.php.net/bug.php?id=43003
					$dt->setTimeZone(new DateTimeZone(date_default_timezone_get()));
				} else {
					$dt = new DateTime($v);
				}
			} catch (Exception $x) {
				throw new PropelException('Error parsing date/time value: ' . var_export($v, true), $x);
			}
		}

		if ( $this->datamodificacio !== null || $dt !== null ) {
			// (nested ifs are a little easier to read in this case)

			$currNorm = ($this->datamodificacio !== null && $tmpDt = new DateTime($this->datamodificacio)) ? $tmpDt->format('Y-m-d') : null;
			$newNorm = ($dt !== null) ? $dt->format('Y-m-d') : null;

			if ( ($currNorm !== $newNorm) // normalized values don't match 
					)
			{
				$this->datamodificacio = ($dt ? $dt->format('Y-m-d') : null);
				$this->modifiedColumns[] = AppDocumentsPermisosPeer::DATAMODIFICACIO;
			}
		} // if either are not null

		return $this;
	} // setDatamodificacio()

	/**
	 * Set the value of [site_id] column.
	 * 
	 * @param      int $v new value
	 * @return     AppDocumentsPermisos The current object (for fluent API support)
	 */
	public function setSiteId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->site_id !== $v) {
			$this->site_id = $v;
			$this->modifiedColumns[] = AppDocumentsPermisosPeer::SITE_ID;
		}

		return $this;
	} // setSiteId()

	/**
	 * Set the value of [actiu] column.
	 * 
	 * @param      int $v new value
	 * @return     AppDocumentsPermisos The current object (for fluent API support)
	 */
	public function setActiu($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->actiu !== $v || $this->isNew()) {
			$this->actiu = $v;
			$this->modifiedColumns[] = AppDocumentsPermisosPeer::ACTIU;
		}

		return $this;
	} // setActiu()

	/**
	 * Indicates whether the columns in this object are only set to default values.
	 *
	 * This method can be used in conjunction with isModified() to indicate whether an object is both
	 * modified _and_ has some values set which are non-default.
	 *
	 * @return     boolean Whether the columns in this object are only been set with default values.
	 */
	public function hasOnlyDefaultValues()
	{
			if ($this->actiu !== 1) {
				return false;
			}

		// otherwise, everything was equal, so return TRUE
		return true;
	} // hasOnlyDefaultValues()

	/**
	 * Hydrates (populates) the object variables with values from the database resultset.
	 *
	 * An offset (0-based "start column") is specified so that objects can be hydrated
	 * with a subset of the columns in the resultset rows.  This is needed, for example,
	 * for results of JOIN queries where the resultset row includes columns from two or
	 * more tables.
	 *
	 * @param      array $row The row returned by PDOStatement->fetch(PDO::FETCH_NUM)
	 * @param      int $startcol 0-based offset column which indicates which restultset column to start with.
	 * @param      boolean $rehydrate Whether this object is being re-hydrated from the database.
	 * @return     int next starting column
	 * @throws     PropelException  - Any caught Exception will be rewrapped as a PropelException.
	 */
	public function hydrate($row, $startcol = 0, $rehydrate = false)
	{
		try {

			$this->idusuari = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
			$this->idarxiu = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
			$this->idnivell = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
			$this->datamodificacio = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
			$this->site_id = ($row[$startcol + 4] !== null) ? (int) $row[$startcol + 4] : null;
			$this->actiu = ($row[$startcol + 5] !== null) ? (int) $row[$startcol + 5] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 6; // 6 = AppDocumentsPermisosPeer::NUM_COLUMNS - AppDocumentsPermisosPeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating AppDocumentsPermisos object", $e);
		}
	}

	/**
	 * Checks and repairs the internal consistency of the object.
	 *
	 * This method is executed after an already-instantiated object is re-hydrated
	 * from the database.  It exists to check any foreign keys to make sure that
	 * the objects related to the current object are correct based on foreign key.
	 *
	 * You can override this method in the stub class, but you should always invoke
	 * the base method from the overridden method (i.e. parent::ensureConsistency()),
	 * in case your model changes.
	 *
	 * @throws     PropelException
	 */
	public function ensureConsistency()
	{

		if ($this->aUsuaris !== null && $this->idusuari !== $this->aUsuaris->getUsuariid()) {
			$this->aUsuaris = null;
		}
		if ($this->aAppDocumentsArxius !== null && $this->idarxiu !== $this->aAppDocumentsArxius->getIddocument()) {
			$this->aAppDocumentsArxius = null;
		}
		if ($this->aNivells !== null && $this->idnivell !== $this->aNivells->getIdnivells()) {
			$this->aNivells = null;
		}
	} // ensureConsistency

	/**
	 * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
	 *
	 * This will only work if the object has been saved and has a valid primary key set.
	 *
	 * @param      boolean $deep (optional) Whether to also de-associated any related objects.
	 * @param      PropelPDO $con (optional) The PropelPDO connection to use.
	 * @return     void
	 * @throws     PropelException - if this object is deleted, unsaved or doesn't have pk match in db
	 */
	public function reload($deep = false, PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("Cannot reload a deleted object.");
		}

		if ($this->isNew()) {
			throw new PropelException("Cannot reload an unsaved object.");
		}

		if ($con === null) {
			$con = Propel::getConnection(AppDocumentsPermisosPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		$stmt = AppDocumentsPermisosPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); // rehydrate

		if ($deep) {  // also de-associate any related objects?

			$this->aUsuaris = null;
			$this->aAppDocumentsArxius = null;
			$this->aNivells = null;
		} // if (deep)
	}

	/**
	 * Removes this object from datastore and sets delete attribute.
	 *
	 * @param      PropelPDO $con
	 * @return     void
	 * @throws     PropelException
	 * @see        BaseObject::setDeleted()
	 * @see        BaseObject::isDeleted()
	 */
	public function delete(PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(AppDocumentsPermisosPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$ret = $this->preDelete($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BaseAppDocumentsPermisos:delete:pre') as $callable)
			{
			  if (call_user_func($callable, $this, $con))
			  {
			    $con->commit();
			
			    return;
			  }
			}

			if ($ret) {
				AppDocumentsPermisosPeer::doDelete($this, $con);
				$this->postDelete($con);
				// symfony_behaviors behavior
				foreach (sfMixer::getCallables('BaseAppDocumentsPermisos:delete:post') as $callable)
				{
				  call_user_func($callable, $this, $con);
				}

				$this->setDeleted(true);
				$con->commit();
			} else {
				$con->commit();
			}
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	/**
	 * Persists this object to the database.
	 *
	 * If the object is new, it inserts it; otherwise an update is performed.
	 * All modified related objects will also be persisted in the doSave()
	 * method.  This method wraps all precipitate database operations in a
	 * single transaction.
	 *
	 * @param      PropelPDO $con
	 * @return     int The number of rows affected by this insert/update and any referring fk objects' save() operations.
	 * @throws     PropelException
	 * @see        doSave()
	 */
	public function save(PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(AppDocumentsPermisosPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		$isInsert = $this->isNew();
		try {
			$ret = $this->preSave($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BaseAppDocumentsPermisos:save:pre') as $callable)
			{
			  if (is_integer($affectedRows = call_user_func($callable, $this, $con)))
			  {
			    $con->commit();
			
			    return $affectedRows;
			  }
			}

			if ($isInsert) {
				$ret = $ret && $this->preInsert($con);
			} else {
				$ret = $ret && $this->preUpdate($con);
			}
			if ($ret) {
				$affectedRows = $this->doSave($con);
				if ($isInsert) {
					$this->postInsert($con);
				} else {
					$this->postUpdate($con);
				}
				$this->postSave($con);
				// symfony_behaviors behavior
				foreach (sfMixer::getCallables('BaseAppDocumentsPermisos:save:post') as $callable)
				{
				  call_user_func($callable, $this, $con, $affectedRows);
				}

				AppDocumentsPermisosPeer::addInstanceToPool($this);
			} else {
				$affectedRows = 0;
			}
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	/**
	 * Performs the work of inserting or updating the row in the database.
	 *
	 * If the object is new, it inserts it; otherwise an update is performed.
	 * All related objects are also updated in this method.
	 *
	 * @param      PropelPDO $con
	 * @return     int The number of rows affected by this insert/update and any referring fk objects' save() operations.
	 * @throws     PropelException
	 * @see        save()
	 */
	protected function doSave(PropelPDO $con)
	{
		$affectedRows = 0; // initialize var to track total num of affected rows
		if (!$this->alreadyInSave) {
			$this->alreadyInSave = true;

			// We call the save method on the following object(s) if they
			// were passed to this object by their coresponding set
			// method.  This object relates to these object(s) by a
			// foreign key reference.

			if ($this->aUsuaris !== null) {
				if ($this->aUsuaris->isModified() || $this->aUsuaris->isNew()) {
					$affectedRows += $this->aUsuaris->save($con);
				}
				$this->setUsuaris($this->aUsuaris);
			}

			if ($this->aAppDocumentsArxius !== null) {
				if ($this->aAppDocumentsArxius->isModified() || $this->aAppDocumentsArxius->isNew()) {
					$affectedRows += $this->aAppDocumentsArxius->save($con);
				}
				$this->setAppDocumentsArxius($this->aAppDocumentsArxius);
			}

			if ($this->aNivells !== null) {
				if ($this->aNivells->isModified() || $this->aNivells->isNew()) {
					$affectedRows += $this->aNivells->save($con);
				}
				$this->setNivells($this->aNivells);
			}


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = AppDocumentsPermisosPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setNew(false);
				} else {
					$affectedRows += AppDocumentsPermisosPeer::doUpdate($this, $con);
				}

				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			$this->alreadyInSave = false;

		}
		return $affectedRows;
	} // doSave()

	/**
	 * Array of ValidationFailed objects.
	 * @var        array ValidationFailed[]
	 */
	protected $validationFailures = array();

	/**
	 * Gets any ValidationFailed objects that resulted from last call to validate().
	 *
	 *
	 * @return     array ValidationFailed[]
	 * @see        validate()
	 */
	public function getValidationFailures()
	{
		return $this->validationFailures;
	}

	/**
	 * Validates the objects modified field values and all objects related to this table.
	 *
	 * If $columns is either a column name or an array of column names
	 * only those columns are validated.
	 *
	 * @param      mixed $columns Column name or an array of column names.
	 * @return     boolean Whether all columns pass validation.
	 * @see        doValidate()
	 * @see        getValidationFailures()
	 */
	public function validate($columns = null)
	{
		$res = $this->doValidate($columns);
		if ($res === true) {
			$this->validationFailures = array();
			return true;
		} else {
			$this->validationFailures = $res;
			return false;
		}
	}

	/**
	 * This function performs the validation work for complex object models.
	 *
	 * In addition to checking the current object, all related objects will
	 * also be validated.  If all pass then <code>true</code> is returned; otherwise
	 * an aggreagated array of ValidationFailed objects will be returned.
	 *
	 * @param      array $columns Array of column names to validate.
	 * @return     mixed <code>true</code> if all validations pass; array of <code>ValidationFailed</code> objets otherwise.
	 */
	protected function doValidate($columns = null)
	{
		if (!$this->alreadyInValidation) {
			$this->alreadyInValidation = true;
			$retval = null;

			$failureMap = array();


			// We call the validate method on the following object(s) if they
			// were passed to this object by their coresponding set
			// method.  This object relates to these object(s) by a
			// foreign key reference.

			if ($this->aUsuaris !== null) {
				if (!$this->aUsuaris->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aUsuaris->getValidationFailures());
				}
			}

			if ($this->aAppDocumentsArxius !== null) {
				if (!$this->aAppDocumentsArxius->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aAppDocumentsArxius->getValidationFailures());
				}
			}

			if ($this->aNivells !== null) {
				if (!$this->aNivells->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aNivells->getValidationFailures());
				}
			}


			if (($retval = AppDocumentsPermisosPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	/**
	 * Retrieves a field from the object by name passed in as a string.
	 *
	 * @param      string $name name
	 * @param      string $type The type of fieldname the $name is of:
	 *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
	 * @return     mixed Value of field.
	 */
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = AppDocumentsPermisosPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		$field = $this->getByPosition($pos);
		return $field;
	}

	/**
	 * Retrieves a field from the object by Position as specified in the xml schema.
	 * Zero-based.
	 *
	 * @param      int $pos position in xml schema
	 * @return     mixed Value of field at $pos
	 */
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getIdusuari();
				break;
			case 1:
				return $this->getIdarxiu();
				break;
			case 2:
				return $this->getIdnivell();
				break;
			case 3:
				return $this->getDatamodificacio();
				break;
			case 4:
				return $this->getSiteId();
				break;
			case 5:
				return $this->getActiu();
				break;
			default:
				return null;
				break;
		} // switch()
	}

	/**
	 * Exports the object as an array.
	 *
	 * You can specify the key type of the array by passing one of the class
	 * type constants.
	 *
	 * @param      string $keyType (optional) One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                        BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. Defaults to BasePeer::TYPE_PHPNAME.
	 * @param      boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns.  Defaults to TRUE.
	 * @return     an associative array containing the field names (as keys) and field values
	 */
	public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true)
	{
		$keys = AppDocumentsPermisosPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getIdusuari(),
			$keys[1] => $this->getIdarxiu(),
			$keys[2] => $this->getIdnivell(),
			$keys[3] => $this->getDatamodificacio(),
			$keys[4] => $this->getSiteId(),
			$keys[5] => $this->getActiu(),
		);
		return $result;
	}

	/**
	 * Sets a field from the object by name passed in as a string.
	 *
	 * @param      string $name peer name
	 * @param      mixed $value field value
	 * @param      string $type The type of fieldname the $name is of:
	 *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
	 * @return     void
	 */
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = AppDocumentsPermisosPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	/**
	 * Sets a field from the object by Position as specified in the xml schema.
	 * Zero-based.
	 *
	 * @param      int $pos position in xml schema
	 * @param      mixed $value field value
	 * @return     void
	 */
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setIdusuari($value);
				break;
			case 1:
				$this->setIdarxiu($value);
				break;
			case 2:
				$this->setIdnivell($value);
				break;
			case 3:
				$this->setDatamodificacio($value);
				break;
			case 4:
				$this->setSiteId($value);
				break;
			case 5:
				$this->setActiu($value);
				break;
		} // switch()
	}

	/**
	 * Populates the object using an array.
	 *
	 * This is particularly useful when populating an object from one of the
	 * request arrays (e.g. $_POST).  This method goes through the column
	 * names, checking to see whether a matching key exists in populated
	 * array. If so the setByName() method is called for that column.
	 *
	 * You can specify the key type of the array by additionally passing one
	 * of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
	 * BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
	 * The default key type is the column's phpname (e.g. 'AuthorId')
	 *
	 * @param      array  $arr     An array to populate the object from.
	 * @param      string $keyType The type of keys the array uses.
	 * @return     void
	 */
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = AppDocumentsPermisosPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setIdusuari($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setIdarxiu($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setIdnivell($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setDatamodificacio($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setSiteId($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setActiu($arr[$keys[5]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(AppDocumentsPermisosPeer::DATABASE_NAME);

		if ($this->isColumnModified(AppDocumentsPermisosPeer::IDUSUARI)) $criteria->add(AppDocumentsPermisosPeer::IDUSUARI, $this->idusuari);
		if ($this->isColumnModified(AppDocumentsPermisosPeer::IDARXIU)) $criteria->add(AppDocumentsPermisosPeer::IDARXIU, $this->idarxiu);
		if ($this->isColumnModified(AppDocumentsPermisosPeer::IDNIVELL)) $criteria->add(AppDocumentsPermisosPeer::IDNIVELL, $this->idnivell);
		if ($this->isColumnModified(AppDocumentsPermisosPeer::DATAMODIFICACIO)) $criteria->add(AppDocumentsPermisosPeer::DATAMODIFICACIO, $this->datamodificacio);
		if ($this->isColumnModified(AppDocumentsPermisosPeer::SITE_ID)) $criteria->add(AppDocumentsPermisosPeer::SITE_ID, $this->site_id);
		if ($this->isColumnModified(AppDocumentsPermisosPeer::ACTIU)) $criteria->add(AppDocumentsPermisosPeer::ACTIU, $this->actiu);

		return $criteria;
	}

	/**
	 * Builds a Criteria object containing the primary key for this object.
	 *
	 * Unlike buildCriteria() this method includes the primary key values regardless
	 * of whether or not they have been modified.
	 *
	 * @return     Criteria The Criteria object containing value(s) for primary key(s).
	 */
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(AppDocumentsPermisosPeer::DATABASE_NAME);

		$criteria->add(AppDocumentsPermisosPeer::IDUSUARI, $this->idusuari);
		$criteria->add(AppDocumentsPermisosPeer::IDARXIU, $this->idarxiu);

		return $criteria;
	}

	/**
	 * Returns the composite primary key for this object.
	 * The array elements will be in same order as specified in XML.
	 * @return     array
	 */
	public function getPrimaryKey()
	{
		$pks = array();

		$pks[0] = $this->getIdusuari();

		$pks[1] = $this->getIdarxiu();

		return $pks;
	}

	/**
	 * Set the [composite] primary key.
	 *
	 * @param      array $keys The elements of the composite key (order must match the order in XML file).
	 * @return     void
	 */
	public function setPrimaryKey($keys)
	{

		$this->setIdusuari($keys[0]);

		$this->setIdarxiu($keys[1]);

	}

	/**
	 * Sets contents of passed object to values from current object.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      object $copyObj An object of AppDocumentsPermisos (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setIdusuari($this->idusuari);

		$copyObj->setIdarxiu($this->idarxiu);

		$copyObj->setIdnivell($this->idnivell);

		$copyObj->setDatamodificacio($this->datamodificacio);

		$copyObj->setSiteId($this->site_id);

		$copyObj->setActiu($this->actiu);


		$copyObj->setNew(true);

	}

	/**
	 * Makes a copy of this object that will be inserted as a new row in table when saved.
	 * It creates a new object filling in the simple attributes, but skipping any primary
	 * keys that are defined for the table.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @return     AppDocumentsPermisos Clone of current object.
	 * @throws     PropelException
	 */
	public function copy($deepCopy = false)
	{
		// we use get_class(), because this might be a subclass
		$clazz = get_class($this);
		$copyObj = new $clazz();
		$this->copyInto($copyObj, $deepCopy);
		return $copyObj;
	}

	/**
	 * Returns a peer instance associated with this om.
	 *
	 * Since Peer classes are not to have any instance attributes, this method returns the
	 * same instance for all member of this class. The method could therefore
	 * be static, but this would prevent one from overriding the behavior.
	 *
	 * @return     AppDocumentsPermisosPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new AppDocumentsPermisosPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a Usuaris object.
	 *
	 * @param      Usuaris $v
	 * @return     AppDocumentsPermisos The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setUsuaris(Usuaris $v = null)
	{
		if ($v === null) {
			$this->setIdusuari(NULL);
		} else {
			$this->setIdusuari($v->getUsuariid());
		}

		$this->aUsuaris = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the Usuaris object, it will not be re-added.
		if ($v !== null) {
			$v->addAppDocumentsPermisos($this);
		}

		return $this;
	}


	/**
	 * Get the associated Usuaris object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     Usuaris The associated Usuaris object.
	 * @throws     PropelException
	 */
	public function getUsuaris(PropelPDO $con = null)
	{
		if ($this->aUsuaris === null && ($this->idusuari !== null)) {
			$this->aUsuaris = UsuarisPeer::retrieveByPk($this->idusuari);
			/* The following can be used additionally to
			   guarantee the related object contains a reference
			   to this object.  This level of coupling may, however, be
			   undesirable since it could result in an only partially populated collection
			   in the referenced object.
			   $this->aUsuaris->addAppDocumentsPermisoss($this);
			 */
		}
		return $this->aUsuaris;
	}

	/**
	 * Declares an association between this object and a AppDocumentsArxius object.
	 *
	 * @param      AppDocumentsArxius $v
	 * @return     AppDocumentsPermisos The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setAppDocumentsArxius(AppDocumentsArxius $v = null)
	{
		if ($v === null) {
			$this->setIdarxiu(NULL);
		} else {
			$this->setIdarxiu($v->getIddocument());
		}

		$this->aAppDocumentsArxius = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the AppDocumentsArxius object, it will not be re-added.
		if ($v !== null) {
			$v->addAppDocumentsPermisos($this);
		}

		return $this;
	}


	/**
	 * Get the associated AppDocumentsArxius object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     AppDocumentsArxius The associated AppDocumentsArxius object.
	 * @throws     PropelException
	 */
	public function getAppDocumentsArxius(PropelPDO $con = null)
	{
		if ($this->aAppDocumentsArxius === null && ($this->idarxiu !== null)) {
			$this->aAppDocumentsArxius = AppDocumentsArxiusPeer::retrieveByPk($this->idarxiu);
			/* The following can be used additionally to
			   guarantee the related object contains a reference
			   to this object.  This level of coupling may, however, be
			   undesirable since it could result in an only partially populated collection
			   in the referenced object.
			   $this->aAppDocumentsArxius->addAppDocumentsPermisoss($this);
			 */
		}
		return $this->aAppDocumentsArxius;
	}

	/**
	 * Declares an association between this object and a Nivells object.
	 *
	 * @param      Nivells $v
	 * @return     AppDocumentsPermisos The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setNivells(Nivells $v = null)
	{
		if ($v === null) {
			$this->setIdnivell(NULL);
		} else {
			$this->setIdnivell($v->getIdnivells());
		}

		$this->aNivells = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the Nivells object, it will not be re-added.
		if ($v !== null) {
			$v->addAppDocumentsPermisos($this);
		}

		return $this;
	}


	/**
	 * Get the associated Nivells object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     Nivells The associated Nivells object.
	 * @throws     PropelException
	 */
	public function getNivells(PropelPDO $con = null)
	{
		if ($this->aNivells === null && ($this->idnivell !== null)) {
			$this->aNivells = NivellsPeer::retrieveByPk($this->idnivell);
			/* The following can be used additionally to
			   guarantee the related object contains a reference
			   to this object.  This level of coupling may, however, be
			   undesirable since it could result in an only partially populated collection
			   in the referenced object.
			   $this->aNivells->addAppDocumentsPermisoss($this);
			 */
		}
		return $this->aNivells;
	}

	/**
	 * Resets all collections of referencing foreign keys.
	 *
	 * This method is a user-space workaround for PHP's inability to garbage collect objects
	 * with circular references.  This is currently necessary when using Propel in certain
	 * daemon or large-volumne/high-memory operations.
	 *
	 * @param      boolean $deep Whether to also clear the references on all associated objects.
	 */
	public function clearAllReferences($deep = false)
	{
		if ($deep) {
		} // if ($deep)

			$this->aUsuaris = null;
			$this->aAppDocumentsArxius = null;
			$this->aNivells = null;
	}

	// symfony_behaviors behavior
	
	/**
	 * Calls methods defined via {@link sfMixer}.
	 */
	public function __call($method, $arguments)
	{
	  if (!$callable = sfMixer::getCallable('BaseAppDocumentsPermisos:'.$method))
	  {
	    throw new sfException(sprintf('Call to undefined method BaseAppDocumentsPermisos::%s', $method));
	  }
	
	  array_unshift($arguments, $this);
	
	  return call_user_func_array($callable, $arguments);
	}

} // BaseAppDocumentsPermisos
