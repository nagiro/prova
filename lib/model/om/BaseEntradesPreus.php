<?php

/**
 * Base class that represents a row from the 'entrades_preus' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 02/27/13 14:45:40
 *
 * @package    lib.model.om
 */
abstract class BaseEntradesPreus extends BaseObject  implements Persistent {


	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        EntradesPreusPeer
	 */
	protected static $peer;

	/**
	 * The value for the horari_id field.
	 * Note: this column has a database default value of: 0
	 * @var        int
	 */
	protected $horari_id;

	/**
	 * The value for the preu field.
	 * @var        int
	 */
	protected $preu;

	/**
	 * The value for the places field.
	 * @var        int
	 */
	protected $places;

	/**
	 * The value for the tipus field.
	 * Note: this column has a database default value of: 1
	 * @var        int
	 */
	protected $tipus;

	/**
	 * The value for the activitat_id field.
	 * Note: this column has a database default value of: 0
	 * @var        int
	 */
	protected $activitat_id;

	/**
	 * The value for the descomptes field.
	 * @var        string
	 */
	protected $descomptes;

	/**
	 * The value for the pagamentintern field.
	 * @var        string
	 */
	protected $pagamentintern;

	/**
	 * The value for the pagamentextern field.
	 * @var        string
	 */
	protected $pagamentextern;

	/**
	 * The value for the site_id field.
	 * @var        int
	 */
	protected $site_id;

	/**
	 * The value for the actiu field.
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
	
	const PEER = 'EntradesPreusPeer';

	/**
	 * Applies default values to this object.
	 * This method should be called from the object's constructor (or
	 * equivalent initialization method).
	 * @see        __construct()
	 */
	public function applyDefaultValues()
	{
		$this->horari_id = 0;
		$this->tipus = 1;
		$this->activitat_id = 0;
	}

	/**
	 * Initializes internal state of BaseEntradesPreus object.
	 * @see        applyDefaults()
	 */
	public function __construct()
	{
		parent::__construct();
		$this->applyDefaultValues();
	}

	/**
	 * Get the [horari_id] column value.
	 * 
	 * @return     int
	 */
	public function getHorariId()
	{
		return $this->horari_id;
	}

	/**
	 * Get the [preu] column value.
	 * 
	 * @return     int
	 */
	public function getPreu()
	{
		return $this->preu;
	}

	/**
	 * Get the [places] column value.
	 * 
	 * @return     int
	 */
	public function getPlaces()
	{
		return $this->places;
	}

	/**
	 * Get the [tipus] column value.
	 * 
	 * @return     int
	 */
	public function getTipus()
	{
		return $this->tipus;
	}

	/**
	 * Get the [activitat_id] column value.
	 * 
	 * @return     int
	 */
	public function getActivitatId()
	{
		return $this->activitat_id;
	}

	/**
	 * Get the [descomptes] column value.
	 * 
	 * @return     string
	 */
	public function getDescomptes()
	{
		return $this->descomptes;
	}

	/**
	 * Get the [pagamentintern] column value.
	 * 
	 * @return     string
	 */
	public function getPagamentintern()
	{
		return $this->pagamentintern;
	}

	/**
	 * Get the [pagamentextern] column value.
	 * 
	 * @return     string
	 */
	public function getPagamentextern()
	{
		return $this->pagamentextern;
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
	 * Set the value of [horari_id] column.
	 * 
	 * @param      int $v new value
	 * @return     EntradesPreus The current object (for fluent API support)
	 */
	public function setHorariId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->horari_id !== $v || $this->isNew()) {
			$this->horari_id = $v;
			$this->modifiedColumns[] = EntradesPreusPeer::HORARI_ID;
		}

		return $this;
	} // setHorariId()

	/**
	 * Set the value of [preu] column.
	 * 
	 * @param      int $v new value
	 * @return     EntradesPreus The current object (for fluent API support)
	 */
	public function setPreu($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->preu !== $v) {
			$this->preu = $v;
			$this->modifiedColumns[] = EntradesPreusPeer::PREU;
		}

		return $this;
	} // setPreu()

	/**
	 * Set the value of [places] column.
	 * 
	 * @param      int $v new value
	 * @return     EntradesPreus The current object (for fluent API support)
	 */
	public function setPlaces($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->places !== $v) {
			$this->places = $v;
			$this->modifiedColumns[] = EntradesPreusPeer::PLACES;
		}

		return $this;
	} // setPlaces()

	/**
	 * Set the value of [tipus] column.
	 * 
	 * @param      int $v new value
	 * @return     EntradesPreus The current object (for fluent API support)
	 */
	public function setTipus($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->tipus !== $v || $this->isNew()) {
			$this->tipus = $v;
			$this->modifiedColumns[] = EntradesPreusPeer::TIPUS;
		}

		return $this;
	} // setTipus()

	/**
	 * Set the value of [activitat_id] column.
	 * 
	 * @param      int $v new value
	 * @return     EntradesPreus The current object (for fluent API support)
	 */
	public function setActivitatId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->activitat_id !== $v || $this->isNew()) {
			$this->activitat_id = $v;
			$this->modifiedColumns[] = EntradesPreusPeer::ACTIVITAT_ID;
		}

		return $this;
	} // setActivitatId()

	/**
	 * Set the value of [descomptes] column.
	 * 
	 * @param      string $v new value
	 * @return     EntradesPreus The current object (for fluent API support)
	 */
	public function setDescomptes($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->descomptes !== $v) {
			$this->descomptes = $v;
			$this->modifiedColumns[] = EntradesPreusPeer::DESCOMPTES;
		}

		return $this;
	} // setDescomptes()

	/**
	 * Set the value of [pagamentintern] column.
	 * 
	 * @param      string $v new value
	 * @return     EntradesPreus The current object (for fluent API support)
	 */
	public function setPagamentintern($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->pagamentintern !== $v) {
			$this->pagamentintern = $v;
			$this->modifiedColumns[] = EntradesPreusPeer::PAGAMENTINTERN;
		}

		return $this;
	} // setPagamentintern()

	/**
	 * Set the value of [pagamentextern] column.
	 * 
	 * @param      string $v new value
	 * @return     EntradesPreus The current object (for fluent API support)
	 */
	public function setPagamentextern($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->pagamentextern !== $v) {
			$this->pagamentextern = $v;
			$this->modifiedColumns[] = EntradesPreusPeer::PAGAMENTEXTERN;
		}

		return $this;
	} // setPagamentextern()

	/**
	 * Set the value of [site_id] column.
	 * 
	 * @param      int $v new value
	 * @return     EntradesPreus The current object (for fluent API support)
	 */
	public function setSiteId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->site_id !== $v) {
			$this->site_id = $v;
			$this->modifiedColumns[] = EntradesPreusPeer::SITE_ID;
		}

		return $this;
	} // setSiteId()

	/**
	 * Set the value of [actiu] column.
	 * 
	 * @param      int $v new value
	 * @return     EntradesPreus The current object (for fluent API support)
	 */
	public function setActiu($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->actiu !== $v) {
			$this->actiu = $v;
			$this->modifiedColumns[] = EntradesPreusPeer::ACTIU;
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
			if ($this->horari_id !== 0) {
				return false;
			}

			if ($this->tipus !== 1) {
				return false;
			}

			if ($this->activitat_id !== 0) {
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

			$this->horari_id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
			$this->preu = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
			$this->places = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
			$this->tipus = ($row[$startcol + 3] !== null) ? (int) $row[$startcol + 3] : null;
			$this->activitat_id = ($row[$startcol + 4] !== null) ? (int) $row[$startcol + 4] : null;
			$this->descomptes = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
			$this->pagamentintern = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
			$this->pagamentextern = ($row[$startcol + 7] !== null) ? (string) $row[$startcol + 7] : null;
			$this->site_id = ($row[$startcol + 8] !== null) ? (int) $row[$startcol + 8] : null;
			$this->actiu = ($row[$startcol + 9] !== null) ? (int) $row[$startcol + 9] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 10; // 10 = EntradesPreusPeer::NUM_COLUMNS - EntradesPreusPeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating EntradesPreus object", $e);
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
			$con = Propel::getConnection(EntradesPreusPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		$stmt = EntradesPreusPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
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
			$con = Propel::getConnection(EntradesPreusPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$ret = $this->preDelete($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BaseEntradesPreus:delete:pre') as $callable)
			{
			  if (call_user_func($callable, $this, $con))
			  {
			    $con->commit();
			
			    return;
			  }
			}

			if ($ret) {
				EntradesPreusPeer::doDelete($this, $con);
				$this->postDelete($con);
				// symfony_behaviors behavior
				foreach (sfMixer::getCallables('BaseEntradesPreus:delete:post') as $callable)
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
			$con = Propel::getConnection(EntradesPreusPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		$isInsert = $this->isNew();
		try {
			$ret = $this->preSave($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BaseEntradesPreus:save:pre') as $callable)
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
				foreach (sfMixer::getCallables('BaseEntradesPreus:save:post') as $callable)
				{
				  call_user_func($callable, $this, $con, $affectedRows);
				}

				EntradesPreusPeer::addInstanceToPool($this);
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


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = EntradesPreusPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setNew(false);
				} else {
					$affectedRows += EntradesPreusPeer::doUpdate($this, $con);
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


			if (($retval = EntradesPreusPeer::doValidate($this, $columns)) !== true) {
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
		$pos = EntradesPreusPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getHorariId();
				break;
			case 1:
				return $this->getPreu();
				break;
			case 2:
				return $this->getPlaces();
				break;
			case 3:
				return $this->getTipus();
				break;
			case 4:
				return $this->getActivitatId();
				break;
			case 5:
				return $this->getDescomptes();
				break;
			case 6:
				return $this->getPagamentintern();
				break;
			case 7:
				return $this->getPagamentextern();
				break;
			case 8:
				return $this->getSiteId();
				break;
			case 9:
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
		$keys = EntradesPreusPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getHorariId(),
			$keys[1] => $this->getPreu(),
			$keys[2] => $this->getPlaces(),
			$keys[3] => $this->getTipus(),
			$keys[4] => $this->getActivitatId(),
			$keys[5] => $this->getDescomptes(),
			$keys[6] => $this->getPagamentintern(),
			$keys[7] => $this->getPagamentextern(),
			$keys[8] => $this->getSiteId(),
			$keys[9] => $this->getActiu(),
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
		$pos = EntradesPreusPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setHorariId($value);
				break;
			case 1:
				$this->setPreu($value);
				break;
			case 2:
				$this->setPlaces($value);
				break;
			case 3:
				$this->setTipus($value);
				break;
			case 4:
				$this->setActivitatId($value);
				break;
			case 5:
				$this->setDescomptes($value);
				break;
			case 6:
				$this->setPagamentintern($value);
				break;
			case 7:
				$this->setPagamentextern($value);
				break;
			case 8:
				$this->setSiteId($value);
				break;
			case 9:
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
		$keys = EntradesPreusPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setHorariId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setPreu($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setPlaces($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setTipus($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setActivitatId($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setDescomptes($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setPagamentintern($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setPagamentextern($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setSiteId($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setActiu($arr[$keys[9]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(EntradesPreusPeer::DATABASE_NAME);

		if ($this->isColumnModified(EntradesPreusPeer::HORARI_ID)) $criteria->add(EntradesPreusPeer::HORARI_ID, $this->horari_id);
		if ($this->isColumnModified(EntradesPreusPeer::PREU)) $criteria->add(EntradesPreusPeer::PREU, $this->preu);
		if ($this->isColumnModified(EntradesPreusPeer::PLACES)) $criteria->add(EntradesPreusPeer::PLACES, $this->places);
		if ($this->isColumnModified(EntradesPreusPeer::TIPUS)) $criteria->add(EntradesPreusPeer::TIPUS, $this->tipus);
		if ($this->isColumnModified(EntradesPreusPeer::ACTIVITAT_ID)) $criteria->add(EntradesPreusPeer::ACTIVITAT_ID, $this->activitat_id);
		if ($this->isColumnModified(EntradesPreusPeer::DESCOMPTES)) $criteria->add(EntradesPreusPeer::DESCOMPTES, $this->descomptes);
		if ($this->isColumnModified(EntradesPreusPeer::PAGAMENTINTERN)) $criteria->add(EntradesPreusPeer::PAGAMENTINTERN, $this->pagamentintern);
		if ($this->isColumnModified(EntradesPreusPeer::PAGAMENTEXTERN)) $criteria->add(EntradesPreusPeer::PAGAMENTEXTERN, $this->pagamentextern);
		if ($this->isColumnModified(EntradesPreusPeer::SITE_ID)) $criteria->add(EntradesPreusPeer::SITE_ID, $this->site_id);
		if ($this->isColumnModified(EntradesPreusPeer::ACTIU)) $criteria->add(EntradesPreusPeer::ACTIU, $this->actiu);

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
		$criteria = new Criteria(EntradesPreusPeer::DATABASE_NAME);

		$criteria->add(EntradesPreusPeer::HORARI_ID, $this->horari_id);
		$criteria->add(EntradesPreusPeer::ACTIVITAT_ID, $this->activitat_id);

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

		$pks[0] = $this->getHorariId();

		$pks[1] = $this->getActivitatId();

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

		$this->setHorariId($keys[0]);

		$this->setActivitatId($keys[1]);

	}

	/**
	 * Sets contents of passed object to values from current object.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      object $copyObj An object of EntradesPreus (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setHorariId($this->horari_id);

		$copyObj->setPreu($this->preu);

		$copyObj->setPlaces($this->places);

		$copyObj->setTipus($this->tipus);

		$copyObj->setActivitatId($this->activitat_id);

		$copyObj->setDescomptes($this->descomptes);

		$copyObj->setPagamentintern($this->pagamentintern);

		$copyObj->setPagamentextern($this->pagamentextern);

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
	 * @return     EntradesPreus Clone of current object.
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
	 * @return     EntradesPreusPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new EntradesPreusPeer();
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
	  if (!$callable = sfMixer::getCallable('BaseEntradesPreus:'.$method))
	  {
	    throw new sfException(sprintf('Call to undefined method BaseEntradesPreus::%s', $method));
	  }
	
	  array_unshift($arguments, $this);
	
	  return call_user_func_array($callable, $arguments);
	}

} // BaseEntradesPreus
