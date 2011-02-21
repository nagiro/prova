<?php

/**
 * Base class that represents a row from the 'espais' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 02/21/11 12:23:24
 *
 * @package    lib.model.om
 */
abstract class BaseEspais extends BaseObject  implements Persistent {


	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        EspaisPeer
	 */
	protected static $peer;

	/**
	 * The value for the espaiid field.
	 * @var        int
	 */
	protected $espaiid;

	/**
	 * The value for the nom field.
	 * @var        string
	 */
	protected $nom;

	/**
	 * The value for the ordre field.
	 * @var        int
	 */
	protected $ordre;

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
	 * The value for the isllogable field.
	 * Note: this column has a database default value of: 0
	 * @var        int
	 */
	protected $isllogable;

	/**
	 * The value for the descripcio field.
	 * @var        string
	 */
	protected $descripcio;

	/**
	 * @var        array Horarisespais[] Collection to store aggregation of Horarisespais objects.
	 */
	protected $collHorarisespaiss;

	/**
	 * @var        Criteria The criteria used to select the current contents of collHorarisespaiss.
	 */
	private $lastHorarisespaisCriteria = null;

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
	
	const PEER = 'EspaisPeer';

	/**
	 * Applies default values to this object.
	 * This method should be called from the object's constructor (or
	 * equivalent initialization method).
	 * @see        __construct()
	 */
	public function applyDefaultValues()
	{
		$this->actiu = 1;
		$this->isllogable = 0;
	}

	/**
	 * Initializes internal state of BaseEspais object.
	 * @see        applyDefaults()
	 */
	public function __construct()
	{
		parent::__construct();
		$this->applyDefaultValues();
	}

	/**
	 * Get the [espaiid] column value.
	 * 
	 * @return     int
	 */
	public function getEspaiid()
	{
		return $this->espaiid;
	}

	/**
	 * Get the [nom] column value.
	 * 
	 * @return     string
	 */
	public function getNom()
	{
		return $this->nom;
	}

	/**
	 * Get the [ordre] column value.
	 * 
	 * @return     int
	 */
	public function getOrdre()
	{
		return $this->ordre;
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
	 * Get the [isllogable] column value.
	 * 
	 * @return     int
	 */
	public function getIsllogable()
	{
		return $this->isllogable;
	}

	/**
	 * Get the [descripcio] column value.
	 * 
	 * @return     string
	 */
	public function getDescripcio()
	{
		return $this->descripcio;
	}

	/**
	 * Set the value of [espaiid] column.
	 * 
	 * @param      int $v new value
	 * @return     Espais The current object (for fluent API support)
	 */
	public function setEspaiid($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->espaiid !== $v) {
			$this->espaiid = $v;
			$this->modifiedColumns[] = EspaisPeer::ESPAIID;
		}

		return $this;
	} // setEspaiid()

	/**
	 * Set the value of [nom] column.
	 * 
	 * @param      string $v new value
	 * @return     Espais The current object (for fluent API support)
	 */
	public function setNom($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->nom !== $v) {
			$this->nom = $v;
			$this->modifiedColumns[] = EspaisPeer::NOM;
		}

		return $this;
	} // setNom()

	/**
	 * Set the value of [ordre] column.
	 * 
	 * @param      int $v new value
	 * @return     Espais The current object (for fluent API support)
	 */
	public function setOrdre($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->ordre !== $v) {
			$this->ordre = $v;
			$this->modifiedColumns[] = EspaisPeer::ORDRE;
		}

		return $this;
	} // setOrdre()

	/**
	 * Set the value of [site_id] column.
	 * 
	 * @param      int $v new value
	 * @return     Espais The current object (for fluent API support)
	 */
	public function setSiteId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->site_id !== $v) {
			$this->site_id = $v;
			$this->modifiedColumns[] = EspaisPeer::SITE_ID;
		}

		return $this;
	} // setSiteId()

	/**
	 * Set the value of [actiu] column.
	 * 
	 * @param      int $v new value
	 * @return     Espais The current object (for fluent API support)
	 */
	public function setActiu($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->actiu !== $v || $this->isNew()) {
			$this->actiu = $v;
			$this->modifiedColumns[] = EspaisPeer::ACTIU;
		}

		return $this;
	} // setActiu()

	/**
	 * Set the value of [isllogable] column.
	 * 
	 * @param      int $v new value
	 * @return     Espais The current object (for fluent API support)
	 */
	public function setIsllogable($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->isllogable !== $v || $this->isNew()) {
			$this->isllogable = $v;
			$this->modifiedColumns[] = EspaisPeer::ISLLOGABLE;
		}

		return $this;
	} // setIsllogable()

	/**
	 * Set the value of [descripcio] column.
	 * 
	 * @param      string $v new value
	 * @return     Espais The current object (for fluent API support)
	 */
	public function setDescripcio($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->descripcio !== $v) {
			$this->descripcio = $v;
			$this->modifiedColumns[] = EspaisPeer::DESCRIPCIO;
		}

		return $this;
	} // setDescripcio()

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

			if ($this->isllogable !== 0) {
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

			$this->espaiid = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
			$this->nom = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
			$this->ordre = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
			$this->site_id = ($row[$startcol + 3] !== null) ? (int) $row[$startcol + 3] : null;
			$this->actiu = ($row[$startcol + 4] !== null) ? (int) $row[$startcol + 4] : null;
			$this->isllogable = ($row[$startcol + 5] !== null) ? (int) $row[$startcol + 5] : null;
			$this->descripcio = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 7; // 7 = EspaisPeer::NUM_COLUMNS - EspaisPeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating Espais object", $e);
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
			$con = Propel::getConnection(EspaisPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		$stmt = EspaisPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); // rehydrate

		if ($deep) {  // also de-associate any related objects?

			$this->collHorarisespaiss = null;
			$this->lastHorarisespaisCriteria = null;

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
			$con = Propel::getConnection(EspaisPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$ret = $this->preDelete($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BaseEspais:delete:pre') as $callable)
			{
			  if (call_user_func($callable, $this, $con))
			  {
			    $con->commit();
			
			    return;
			  }
			}

			if ($ret) {
				EspaisPeer::doDelete($this, $con);
				$this->postDelete($con);
				// symfony_behaviors behavior
				foreach (sfMixer::getCallables('BaseEspais:delete:post') as $callable)
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
			$con = Propel::getConnection(EspaisPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		$isInsert = $this->isNew();
		try {
			$ret = $this->preSave($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BaseEspais:save:pre') as $callable)
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
				foreach (sfMixer::getCallables('BaseEspais:save:post') as $callable)
				{
				  call_user_func($callable, $this, $con, $affectedRows);
				}

				EspaisPeer::addInstanceToPool($this);
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
				$this->modifiedColumns[] = EspaisPeer::ESPAIID;
			}

			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = EspaisPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setEspaiid($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += EspaisPeer::doUpdate($this, $con);
				}

				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collHorarisespaiss !== null) {
				foreach ($this->collHorarisespaiss as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
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


			if (($retval = EspaisPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collHorarisespaiss !== null) {
					foreach ($this->collHorarisespaiss as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
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
		$pos = EspaisPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getEspaiid();
				break;
			case 1:
				return $this->getNom();
				break;
			case 2:
				return $this->getOrdre();
				break;
			case 3:
				return $this->getSiteId();
				break;
			case 4:
				return $this->getActiu();
				break;
			case 5:
				return $this->getIsllogable();
				break;
			case 6:
				return $this->getDescripcio();
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
		$keys = EspaisPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getEspaiid(),
			$keys[1] => $this->getNom(),
			$keys[2] => $this->getOrdre(),
			$keys[3] => $this->getSiteId(),
			$keys[4] => $this->getActiu(),
			$keys[5] => $this->getIsllogable(),
			$keys[6] => $this->getDescripcio(),
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
		$pos = EspaisPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setEspaiid($value);
				break;
			case 1:
				$this->setNom($value);
				break;
			case 2:
				$this->setOrdre($value);
				break;
			case 3:
				$this->setSiteId($value);
				break;
			case 4:
				$this->setActiu($value);
				break;
			case 5:
				$this->setIsllogable($value);
				break;
			case 6:
				$this->setDescripcio($value);
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
		$keys = EspaisPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setEspaiid($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setNom($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setOrdre($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setSiteId($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setActiu($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setIsllogable($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setDescripcio($arr[$keys[6]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(EspaisPeer::DATABASE_NAME);

		if ($this->isColumnModified(EspaisPeer::ESPAIID)) $criteria->add(EspaisPeer::ESPAIID, $this->espaiid);
		if ($this->isColumnModified(EspaisPeer::NOM)) $criteria->add(EspaisPeer::NOM, $this->nom);
		if ($this->isColumnModified(EspaisPeer::ORDRE)) $criteria->add(EspaisPeer::ORDRE, $this->ordre);
		if ($this->isColumnModified(EspaisPeer::SITE_ID)) $criteria->add(EspaisPeer::SITE_ID, $this->site_id);
		if ($this->isColumnModified(EspaisPeer::ACTIU)) $criteria->add(EspaisPeer::ACTIU, $this->actiu);
		if ($this->isColumnModified(EspaisPeer::ISLLOGABLE)) $criteria->add(EspaisPeer::ISLLOGABLE, $this->isllogable);
		if ($this->isColumnModified(EspaisPeer::DESCRIPCIO)) $criteria->add(EspaisPeer::DESCRIPCIO, $this->descripcio);

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
		$criteria = new Criteria(EspaisPeer::DATABASE_NAME);

		$criteria->add(EspaisPeer::ESPAIID, $this->espaiid);

		return $criteria;
	}

	/**
	 * Returns the primary key for this object (row).
	 * @return     int
	 */
	public function getPrimaryKey()
	{
		return $this->getEspaiid();
	}

	/**
	 * Generic method to set the primary key (espaiid column).
	 *
	 * @param      int $key Primary key.
	 * @return     void
	 */
	public function setPrimaryKey($key)
	{
		$this->setEspaiid($key);
	}

	/**
	 * Sets contents of passed object to values from current object.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      object $copyObj An object of Espais (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setNom($this->nom);

		$copyObj->setOrdre($this->ordre);

		$copyObj->setSiteId($this->site_id);

		$copyObj->setActiu($this->actiu);

		$copyObj->setIsllogable($this->isllogable);

		$copyObj->setDescripcio($this->descripcio);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach ($this->getHorarisespaiss() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addHorarisespais($relObj->copy($deepCopy));
				}
			}

		} // if ($deepCopy)


		$copyObj->setNew(true);

		$copyObj->setEspaiid(NULL); // this is a auto-increment column, so set to default value

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
	 * @return     Espais Clone of current object.
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
	 * @return     EspaisPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new EspaisPeer();
		}
		return self::$peer;
	}

	/**
	 * Clears out the collHorarisespaiss collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addHorarisespaiss()
	 */
	public function clearHorarisespaiss()
	{
		$this->collHorarisespaiss = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collHorarisespaiss collection (array).
	 *
	 * By default this just sets the collHorarisespaiss collection to an empty array (like clearcollHorarisespaiss());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initHorarisespaiss()
	{
		$this->collHorarisespaiss = array();
	}

	/**
	 * Gets an array of Horarisespais objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this Espais has previously been saved, it will retrieve
	 * related Horarisespaiss from storage. If this Espais is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array Horarisespais[]
	 * @throws     PropelException
	 */
	public function getHorarisespaiss($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(EspaisPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collHorarisespaiss === null) {
			if ($this->isNew()) {
			   $this->collHorarisespaiss = array();
			} else {

				$criteria->add(HorarisespaisPeer::ESPAIS_ESPAIID, $this->espaiid);

				HorarisespaisPeer::addSelectColumns($criteria);
				$this->collHorarisespaiss = HorarisespaisPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(HorarisespaisPeer::ESPAIS_ESPAIID, $this->espaiid);

				HorarisespaisPeer::addSelectColumns($criteria);
				if (!isset($this->lastHorarisespaisCriteria) || !$this->lastHorarisespaisCriteria->equals($criteria)) {
					$this->collHorarisespaiss = HorarisespaisPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastHorarisespaisCriteria = $criteria;
		return $this->collHorarisespaiss;
	}

	/**
	 * Returns the number of related Horarisespais objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related Horarisespais objects.
	 * @throws     PropelException
	 */
	public function countHorarisespaiss(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(EspaisPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collHorarisespaiss === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(HorarisespaisPeer::ESPAIS_ESPAIID, $this->espaiid);

				$count = HorarisespaisPeer::doCount($criteria, false, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(HorarisespaisPeer::ESPAIS_ESPAIID, $this->espaiid);

				if (!isset($this->lastHorarisespaisCriteria) || !$this->lastHorarisespaisCriteria->equals($criteria)) {
					$count = HorarisespaisPeer::doCount($criteria, false, $con);
				} else {
					$count = count($this->collHorarisespaiss);
				}
			} else {
				$count = count($this->collHorarisespaiss);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a Horarisespais object to this object
	 * through the Horarisespais foreign key attribute.
	 *
	 * @param      Horarisespais $l Horarisespais
	 * @return     void
	 * @throws     PropelException
	 */
	public function addHorarisespais(Horarisespais $l)
	{
		if ($this->collHorarisespaiss === null) {
			$this->initHorarisespaiss();
		}
		if (!in_array($l, $this->collHorarisespaiss, true)) { // only add it if the **same** object is not already associated
			array_push($this->collHorarisespaiss, $l);
			$l->setEspais($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Espais is new, it will return
	 * an empty collection; or if this Espais has previously
	 * been saved, it will retrieve related Horarisespaiss from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Espais.
	 */
	public function getHorarisespaissJoinMaterial($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(EspaisPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collHorarisespaiss === null) {
			if ($this->isNew()) {
				$this->collHorarisespaiss = array();
			} else {

				$criteria->add(HorarisespaisPeer::ESPAIS_ESPAIID, $this->espaiid);

				$this->collHorarisespaiss = HorarisespaisPeer::doSelectJoinMaterial($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(HorarisespaisPeer::ESPAIS_ESPAIID, $this->espaiid);

			if (!isset($this->lastHorarisespaisCriteria) || !$this->lastHorarisespaisCriteria->equals($criteria)) {
				$this->collHorarisespaiss = HorarisespaisPeer::doSelectJoinMaterial($criteria, $con, $join_behavior);
			}
		}
		$this->lastHorarisespaisCriteria = $criteria;

		return $this->collHorarisespaiss;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Espais is new, it will return
	 * an empty collection; or if this Espais has previously
	 * been saved, it will retrieve related Horarisespaiss from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Espais.
	 */
	public function getHorarisespaissJoinHoraris($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(EspaisPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collHorarisespaiss === null) {
			if ($this->isNew()) {
				$this->collHorarisespaiss = array();
			} else {

				$criteria->add(HorarisespaisPeer::ESPAIS_ESPAIID, $this->espaiid);

				$this->collHorarisespaiss = HorarisespaisPeer::doSelectJoinHoraris($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(HorarisespaisPeer::ESPAIS_ESPAIID, $this->espaiid);

			if (!isset($this->lastHorarisespaisCriteria) || !$this->lastHorarisespaisCriteria->equals($criteria)) {
				$this->collHorarisespaiss = HorarisespaisPeer::doSelectJoinHoraris($criteria, $con, $join_behavior);
			}
		}
		$this->lastHorarisespaisCriteria = $criteria;

		return $this->collHorarisespaiss;
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
			if ($this->collHorarisespaiss) {
				foreach ((array) $this->collHorarisespaiss as $o) {
					$o->clearAllReferences($deep);
				}
			}
		} // if ($deep)

		$this->collHorarisespaiss = null;
	}

	// symfony_behaviors behavior
	
	/**
	 * Calls methods defined via {@link sfMixer}.
	 */
	public function __call($method, $arguments)
	{
	  if (!$callable = sfMixer::getCallable('BaseEspais:'.$method))
	  {
	    throw new sfException(sprintf('Call to undefined method BaseEspais::%s', $method));
	  }
	
	  array_unshift($arguments, $this);
	
	  return call_user_func_array($callable, $arguments);
	}

} // BaseEspais
