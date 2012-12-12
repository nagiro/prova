<?php

/**
 * Base class that represents a row from the 'entrades' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 12/05/12 17:42:52
 *
 * @package    lib.model.om
 */
abstract class BaseEntrades extends BaseObject  implements Persistent {


	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        EntradesPeer
	 */
	protected static $peer;

	/**
	 * The value for the identrada field.
	 * @var        int
	 */
	protected $identrada;

	/**
	 * The value for the titol field.
	 * @var        string
	 */
	protected $titol;

	/**
	 * The value for the subtitol field.
	 * @var        string
	 */
	protected $subtitol;

	/**
	 * The value for the data field.
	 * @var        string
	 */
	protected $data;

	/**
	 * The value for the lloc field.
	 * @var        string
	 */
	protected $lloc;

	/**
	 * The value for the preu field.
	 * @var        string
	 */
	protected $preu;

	/**
	 * The value for the venudes field.
	 * @var        int
	 */
	protected $venudes;

	/**
	 * The value for the recaptat field.
	 * @var        int
	 */
	protected $recaptat;

	/**
	 * The value for the localitats field.
	 * @var        int
	 */
	protected $localitats;

	/**
	 * The value for the site_id field.
	 * Note: this column has a database default value of: 1
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
	
	const PEER = 'EntradesPeer';

	/**
	 * Applies default values to this object.
	 * This method should be called from the object's constructor (or
	 * equivalent initialization method).
	 * @see        __construct()
	 */
	public function applyDefaultValues()
	{
		$this->site_id = 1;
		$this->actiu = 1;
	}

	/**
	 * Initializes internal state of BaseEntrades object.
	 * @see        applyDefaults()
	 */
	public function __construct()
	{
		parent::__construct();
		$this->applyDefaultValues();
	}

	/**
	 * Get the [identrada] column value.
	 * 
	 * @return     int
	 */
	public function getIdentrada()
	{
		return $this->identrada;
	}

	/**
	 * Get the [titol] column value.
	 * 
	 * @return     string
	 */
	public function getTitol()
	{
		return $this->titol;
	}

	/**
	 * Get the [subtitol] column value.
	 * 
	 * @return     string
	 */
	public function getSubtitol()
	{
		return $this->subtitol;
	}

	/**
	 * Get the [data] column value.
	 * 
	 * @return     string
	 */
	public function getData()
	{
		return $this->data;
	}

	/**
	 * Get the [lloc] column value.
	 * 
	 * @return     string
	 */
	public function getLloc()
	{
		return $this->lloc;
	}

	/**
	 * Get the [preu] column value.
	 * 
	 * @return     string
	 */
	public function getPreu()
	{
		return $this->preu;
	}

	/**
	 * Get the [venudes] column value.
	 * 
	 * @return     int
	 */
	public function getVenudes()
	{
		return $this->venudes;
	}

	/**
	 * Get the [recaptat] column value.
	 * 
	 * @return     int
	 */
	public function getRecaptat()
	{
		return $this->recaptat;
	}

	/**
	 * Get the [localitats] column value.
	 * 
	 * @return     int
	 */
	public function getLocalitats()
	{
		return $this->localitats;
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
	 * Set the value of [identrada] column.
	 * 
	 * @param      int $v new value
	 * @return     Entrades The current object (for fluent API support)
	 */
	public function setIdentrada($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->identrada !== $v) {
			$this->identrada = $v;
			$this->modifiedColumns[] = EntradesPeer::IDENTRADA;
		}

		return $this;
	} // setIdentrada()

	/**
	 * Set the value of [titol] column.
	 * 
	 * @param      string $v new value
	 * @return     Entrades The current object (for fluent API support)
	 */
	public function setTitol($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->titol !== $v) {
			$this->titol = $v;
			$this->modifiedColumns[] = EntradesPeer::TITOL;
		}

		return $this;
	} // setTitol()

	/**
	 * Set the value of [subtitol] column.
	 * 
	 * @param      string $v new value
	 * @return     Entrades The current object (for fluent API support)
	 */
	public function setSubtitol($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->subtitol !== $v) {
			$this->subtitol = $v;
			$this->modifiedColumns[] = EntradesPeer::SUBTITOL;
		}

		return $this;
	} // setSubtitol()

	/**
	 * Set the value of [data] column.
	 * 
	 * @param      string $v new value
	 * @return     Entrades The current object (for fluent API support)
	 */
	public function setData($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->data !== $v) {
			$this->data = $v;
			$this->modifiedColumns[] = EntradesPeer::DATA;
		}

		return $this;
	} // setData()

	/**
	 * Set the value of [lloc] column.
	 * 
	 * @param      string $v new value
	 * @return     Entrades The current object (for fluent API support)
	 */
	public function setLloc($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->lloc !== $v) {
			$this->lloc = $v;
			$this->modifiedColumns[] = EntradesPeer::LLOC;
		}

		return $this;
	} // setLloc()

	/**
	 * Set the value of [preu] column.
	 * 
	 * @param      string $v new value
	 * @return     Entrades The current object (for fluent API support)
	 */
	public function setPreu($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->preu !== $v) {
			$this->preu = $v;
			$this->modifiedColumns[] = EntradesPeer::PREU;
		}

		return $this;
	} // setPreu()

	/**
	 * Set the value of [venudes] column.
	 * 
	 * @param      int $v new value
	 * @return     Entrades The current object (for fluent API support)
	 */
	public function setVenudes($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->venudes !== $v) {
			$this->venudes = $v;
			$this->modifiedColumns[] = EntradesPeer::VENUDES;
		}

		return $this;
	} // setVenudes()

	/**
	 * Set the value of [recaptat] column.
	 * 
	 * @param      int $v new value
	 * @return     Entrades The current object (for fluent API support)
	 */
	public function setRecaptat($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->recaptat !== $v) {
			$this->recaptat = $v;
			$this->modifiedColumns[] = EntradesPeer::RECAPTAT;
		}

		return $this;
	} // setRecaptat()

	/**
	 * Set the value of [localitats] column.
	 * 
	 * @param      int $v new value
	 * @return     Entrades The current object (for fluent API support)
	 */
	public function setLocalitats($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->localitats !== $v) {
			$this->localitats = $v;
			$this->modifiedColumns[] = EntradesPeer::LOCALITATS;
		}

		return $this;
	} // setLocalitats()

	/**
	 * Set the value of [site_id] column.
	 * 
	 * @param      int $v new value
	 * @return     Entrades The current object (for fluent API support)
	 */
	public function setSiteId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->site_id !== $v || $this->isNew()) {
			$this->site_id = $v;
			$this->modifiedColumns[] = EntradesPeer::SITE_ID;
		}

		return $this;
	} // setSiteId()

	/**
	 * Set the value of [actiu] column.
	 * 
	 * @param      int $v new value
	 * @return     Entrades The current object (for fluent API support)
	 */
	public function setActiu($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->actiu !== $v || $this->isNew()) {
			$this->actiu = $v;
			$this->modifiedColumns[] = EntradesPeer::ACTIU;
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
			if ($this->site_id !== 1) {
				return false;
			}

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

			$this->identrada = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
			$this->titol = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
			$this->subtitol = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
			$this->data = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
			$this->lloc = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
			$this->preu = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
			$this->venudes = ($row[$startcol + 6] !== null) ? (int) $row[$startcol + 6] : null;
			$this->recaptat = ($row[$startcol + 7] !== null) ? (int) $row[$startcol + 7] : null;
			$this->localitats = ($row[$startcol + 8] !== null) ? (int) $row[$startcol + 8] : null;
			$this->site_id = ($row[$startcol + 9] !== null) ? (int) $row[$startcol + 9] : null;
			$this->actiu = ($row[$startcol + 10] !== null) ? (int) $row[$startcol + 10] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 11; // 11 = EntradesPeer::NUM_COLUMNS - EntradesPeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating Entrades object", $e);
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
			$con = Propel::getConnection(EntradesPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		$stmt = EntradesPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); // rehydrate

		if ($deep) {  // also de-associate any related objects?

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
			$con = Propel::getConnection(EntradesPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$ret = $this->preDelete($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BaseEntrades:delete:pre') as $callable)
			{
			  if (call_user_func($callable, $this, $con))
			  {
			    $con->commit();
			
			    return;
			  }
			}

			if ($ret) {
				EntradesPeer::doDelete($this, $con);
				$this->postDelete($con);
				// symfony_behaviors behavior
				foreach (sfMixer::getCallables('BaseEntrades:delete:post') as $callable)
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
			$con = Propel::getConnection(EntradesPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		$isInsert = $this->isNew();
		try {
			$ret = $this->preSave($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BaseEntrades:save:pre') as $callable)
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
				foreach (sfMixer::getCallables('BaseEntrades:save:post') as $callable)
				{
				  call_user_func($callable, $this, $con, $affectedRows);
				}

				EntradesPeer::addInstanceToPool($this);
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

			if ($this->isNew() ) {
				$this->modifiedColumns[] = EntradesPeer::IDENTRADA;
			}

			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = EntradesPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setIdentrada($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += EntradesPeer::doUpdate($this, $con);
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


			if (($retval = EntradesPeer::doValidate($this, $columns)) !== true) {
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
		$pos = EntradesPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getIdentrada();
				break;
			case 1:
				return $this->getTitol();
				break;
			case 2:
				return $this->getSubtitol();
				break;
			case 3:
				return $this->getData();
				break;
			case 4:
				return $this->getLloc();
				break;
			case 5:
				return $this->getPreu();
				break;
			case 6:
				return $this->getVenudes();
				break;
			case 7:
				return $this->getRecaptat();
				break;
			case 8:
				return $this->getLocalitats();
				break;
			case 9:
				return $this->getSiteId();
				break;
			case 10:
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
		$keys = EntradesPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getIdentrada(),
			$keys[1] => $this->getTitol(),
			$keys[2] => $this->getSubtitol(),
			$keys[3] => $this->getData(),
			$keys[4] => $this->getLloc(),
			$keys[5] => $this->getPreu(),
			$keys[6] => $this->getVenudes(),
			$keys[7] => $this->getRecaptat(),
			$keys[8] => $this->getLocalitats(),
			$keys[9] => $this->getSiteId(),
			$keys[10] => $this->getActiu(),
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
		$pos = EntradesPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setIdentrada($value);
				break;
			case 1:
				$this->setTitol($value);
				break;
			case 2:
				$this->setSubtitol($value);
				break;
			case 3:
				$this->setData($value);
				break;
			case 4:
				$this->setLloc($value);
				break;
			case 5:
				$this->setPreu($value);
				break;
			case 6:
				$this->setVenudes($value);
				break;
			case 7:
				$this->setRecaptat($value);
				break;
			case 8:
				$this->setLocalitats($value);
				break;
			case 9:
				$this->setSiteId($value);
				break;
			case 10:
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
		$keys = EntradesPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setIdentrada($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setTitol($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setSubtitol($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setData($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setLloc($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setPreu($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setVenudes($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setRecaptat($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setLocalitats($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setSiteId($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setActiu($arr[$keys[10]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(EntradesPeer::DATABASE_NAME);

		if ($this->isColumnModified(EntradesPeer::IDENTRADA)) $criteria->add(EntradesPeer::IDENTRADA, $this->identrada);
		if ($this->isColumnModified(EntradesPeer::TITOL)) $criteria->add(EntradesPeer::TITOL, $this->titol);
		if ($this->isColumnModified(EntradesPeer::SUBTITOL)) $criteria->add(EntradesPeer::SUBTITOL, $this->subtitol);
		if ($this->isColumnModified(EntradesPeer::DATA)) $criteria->add(EntradesPeer::DATA, $this->data);
		if ($this->isColumnModified(EntradesPeer::LLOC)) $criteria->add(EntradesPeer::LLOC, $this->lloc);
		if ($this->isColumnModified(EntradesPeer::PREU)) $criteria->add(EntradesPeer::PREU, $this->preu);
		if ($this->isColumnModified(EntradesPeer::VENUDES)) $criteria->add(EntradesPeer::VENUDES, $this->venudes);
		if ($this->isColumnModified(EntradesPeer::RECAPTAT)) $criteria->add(EntradesPeer::RECAPTAT, $this->recaptat);
		if ($this->isColumnModified(EntradesPeer::LOCALITATS)) $criteria->add(EntradesPeer::LOCALITATS, $this->localitats);
		if ($this->isColumnModified(EntradesPeer::SITE_ID)) $criteria->add(EntradesPeer::SITE_ID, $this->site_id);
		if ($this->isColumnModified(EntradesPeer::ACTIU)) $criteria->add(EntradesPeer::ACTIU, $this->actiu);

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
		$criteria = new Criteria(EntradesPeer::DATABASE_NAME);

		$criteria->add(EntradesPeer::IDENTRADA, $this->identrada);

		return $criteria;
	}

	/**
	 * Returns the primary key for this object (row).
	 * @return     int
	 */
	public function getPrimaryKey()
	{
		return $this->getIdentrada();
	}

	/**
	 * Generic method to set the primary key (identrada column).
	 *
	 * @param      int $key Primary key.
	 * @return     void
	 */
	public function setPrimaryKey($key)
	{
		$this->setIdentrada($key);
	}

	/**
	 * Sets contents of passed object to values from current object.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      object $copyObj An object of Entrades (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setTitol($this->titol);

		$copyObj->setSubtitol($this->subtitol);

		$copyObj->setData($this->data);

		$copyObj->setLloc($this->lloc);

		$copyObj->setPreu($this->preu);

		$copyObj->setVenudes($this->venudes);

		$copyObj->setRecaptat($this->recaptat);

		$copyObj->setLocalitats($this->localitats);

		$copyObj->setSiteId($this->site_id);

		$copyObj->setActiu($this->actiu);


		$copyObj->setNew(true);

		$copyObj->setIdentrada(NULL); // this is a auto-increment column, so set to default value

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
	 * @return     Entrades Clone of current object.
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
	 * @return     EntradesPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new EntradesPeer();
		}
		return self::$peer;
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

	}

	// symfony_behaviors behavior
	
	/**
	 * Calls methods defined via {@link sfMixer}.
	 */
	public function __call($method, $arguments)
	{
	  if (!$callable = sfMixer::getCallable('BaseEntrades:'.$method))
	  {
	    throw new sfException(sprintf('Call to undefined method BaseEntrades::%s', $method));
	  }
	
	  array_unshift($arguments, $this);
	
	  return call_user_func_array($callable, $arguments);
	}

} // BaseEntrades
